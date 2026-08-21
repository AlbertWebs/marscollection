<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductEmbedding;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmbeddingService
{
    private ?string $apiKey;
    private string $model;
    private string $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->model  = config('services.gemini.embedding_model', 'gemini-embedding-2') ?? 'gemini-embedding-2';
        $this->apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:embedContent";
    }

    /**
     * Build a rich text representation of a product for embedding.
     */
    public function productToText(Product $product): string
    {
        $parts = [
            $product->name,
            $product->brand->name ?? '',
            $product->category->name ?? '',
            strip_tags($product->description ?? ''),
        ];

        // Include variant labels for better semantic matching
        if ($product->variants) {
            $labels = collect($product->variants)->pluck('label')->filter()->implode(', ');
            if ($labels) $parts[] = "Options: {$labels}";
        }

        return implode('. ', array_filter($parts));
    }

    /**
     * Call Gemini API to get an embedding vector for a text string.
     * Returns float[] or null on failure.
     */
    public function embed(string $text): ?array
    {
        if (!$this->apiKey) {
            Log::warning('EmbeddingService: GEMINI_API_KEY not set');
            return null;
        }

        try {
            $response = Http::timeout(15)
                ->post("{$this->apiUrl}?key={$this->apiKey}", [
                    'model'   => "models/{$this->model}",
                    'content' => [
                        'parts' => [['text' => $text]],
                    ],
                    'taskType' => 'SEMANTIC_SIMILARITY',
                ]);

            if (!$response->successful()) {
                Log::error('EmbeddingService: API error', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return null;
            }

            return $response->json('embedding.values');
        } catch (\Throwable $e) {
            Log::error('EmbeddingService: Exception', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Generate and persist the embedding for a product.
     * Stores as a pgvector-compatible string "[v1,v2,...]".
     */
    public function generateForProduct(Product $product): bool
    {
        $text      = $this->productToText($product);
        $embedding = $this->embed($text);

        if (!$embedding) return false;

        // Store as JSON array — the vector column accepts "[v1,v2,...]" format
        ProductEmbedding::updateOrCreate(
            ['product_id' => $product->id],
            ['embedding'  => $embedding, 'model' => $this->model]
        );

        return true;
    }

    /**
     * Find N most similar products to a given vector using pgvector's
     * native cosine distance operator (<=>) — runs entirely in the DB.
     *
     * Falls back gracefully when exclusions would leave fewer than $limit results:
     * - First try: exclude all viewed + cart items (fully fresh results)
     * - If not enough: allow viewed products back, still exclude cart items
     * - Cart items are ALWAYS excluded — no point recommending what they already intend to buy
     *
     * @param array $queryVector    float[] from Gemini
     * @param int   $limit
     * @param array $excludeIds     product IDs to exclude (viewed + cart combined)
     * @param array $hardExcludeIds product IDs to ALWAYS exclude regardless (cart items)
     */
    public function findSimilar(array $queryVector, int $limit = 6, array $excludeIds = [], array $hardExcludeIds = []): \Illuminate\Support\Collection
    {
        $base = ProductEmbedding::with(['product.brand', 'product.category'])
            ->whereHas('product', fn($q) => $q->where('is_active', true))
            ->when(!empty($hardExcludeIds), fn($q) => $q->whereNotIn('product_id', $hardExcludeIds));

        // First try: exclude everything (viewed + cart)
        $results = (clone $base)
            ->when(!empty($excludeIds), fn($q) => $q->whereNotIn('product_id', $excludeIds))
            ->nearestTo($queryVector, $limit)
            ->get()
            ->pluck('product')
            ->filter();

        // Not enough fresh results — allow viewed products back in (cart still excluded)
        if ($results->count() < $limit) {
            $results = $base
                ->nearestTo($queryVector, $limit)
                ->get()
                ->pluck('product')
                ->filter();
        }

        return $results;
    }

    /**
     * Get similar products for a given product.
     * The current product is a hard exclude — never recommend the same product.
     */
    public function getSimilarProducts(Product $product, int $limit = 6): \Illuminate\Support\Collection
    {
        $embedding = ProductEmbedding::where('product_id', $product->id)->first();
        if (!$embedding) return collect();

        // Hard exclude only the product itself — allow all others including viewed ones
        return $this->findSimilar($embedding->embedding, $limit, [], [$product->id]);
    }

    /**
     * Get "Picked for you" products based on viewed product IDs.
     *
     * Uses exponential decay weighting so recently viewed products
     * influence the recommendation vector more than older ones.
     * decay = 0.85^position  (position 0 = most recent = weight 1.0,
     *                          position 1 = 0.85, position 2 = 0.72, ...)
     *
     * This means: browse 8 makeup + 1 old hair product → recommendations
     * lean heavily toward makeup, but shift toward hair if user recently
     * switched to browsing hair products.
     *
     * @param array $viewedProductIds  Most recent first (index 0 = latest)
     * @param int   $limit
     */
    public function getPickedForYou(array $viewedProductIds, int $limit = 10, array $additionalExcludeIds = []): \Illuminate\Support\Collection
    {
        if (empty($viewedProductIds)) return collect();

        $embeddings = ProductEmbedding::whereIn('product_id', $viewedProductIds)
            ->get()
            ->keyBy('product_id');

        if ($embeddings->isEmpty()) return collect();

        // Build position map: product_id => position (0 = most recent)
        $positionMap = array_flip($viewedProductIds);

        $decay  = 0.85;
        $avgVec = null;
        $totalWeight = 0.0;

        foreach ($embeddings as $productId => $e) {
            $position = $positionMap[$productId] ?? 99;
            $weight   = pow($decay, $position); // 1.0, 0.85, 0.72, 0.61 ...

            $vec = $e->embedding;
            if ($avgVec === null) {
                $avgVec = array_map(fn($v) => $v * $weight, $vec);
            } else {
                for ($i = 0; $i < count($avgVec); $i++) {
                    $avgVec[$i] += ($vec[$i] ?? 0) * $weight;
                }
            }
            $totalWeight += $weight;
        }

        // Normalise by total weight
        if ($totalWeight > 0) {
            for ($i = 0; $i < count($avgVec); $i++) {
                $avgVec[$i] /= $totalWeight;
            }
        }

        // Viewed products = soft exclude (allowed back if not enough fresh results)
        // Cart items = hard exclude (never show what they already intend to buy)
        return $this->findSimilar($avgVec, $limit, $viewedProductIds, $additionalExcludeIds);
    }
}
