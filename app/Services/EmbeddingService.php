<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductEmbedding;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmbeddingService
{
    private string $apiKey;
    private string $model;
    private string $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->model  = config('services.gemini.embedding_model', 'gemini-embedding-004');
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
                Log::error('EmbeddingService: API error', ['status' => $response->status(), 'body' => $response->body()]);
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
     */
    public function generateForProduct(Product $product): bool
    {
        $text      = $this->productToText($product);
        $embedding = $this->embed($text);

        if (!$embedding) return false;

        ProductEmbedding::updateOrCreate(
            ['product_id' => $product->id],
            ['embedding'  => $embedding, 'model' => $this->model]
        );

        return true;
    }

    /**
     * Cosine similarity between two float vectors.
     */
    public function cosineSimilarity(array $a, array $b): float
    {
        $dot = 0.0;
        $magA = 0.0;
        $magB = 0.0;
        $len = min(count($a), count($b));

        for ($i = 0; $i < $len; $i++) {
            $dot  += $a[$i] * $b[$i];
            $magA += $a[$i] * $a[$i];
            $magB += $b[$i] * $b[$i];
        }

        $denom = sqrt($magA) * sqrt($magB);
        return $denom > 0 ? $dot / $denom : 0.0;
    }

    /**
     * Find N most similar products to a given embedding vector.
     * Excludes the product IDs in $excludeIds.
     */
    public function findSimilar(array $queryVector, int $limit = 6, array $excludeIds = []): \Illuminate\Support\Collection
    {
        $embeddings = ProductEmbedding::with(['product.brand', 'product.category'])
            ->whereHas('product', fn($q) => $q->where('is_active', true))
            ->when(!empty($excludeIds), fn($q) => $q->whereNotIn('product_id', $excludeIds))
            ->get();

        return $embeddings
            ->map(fn($e) => [
                'product'    => $e->product,
                'similarity' => $this->cosineSimilarity($queryVector, $e->embedding),
            ])
            ->sortByDesc('similarity')
            ->take($limit)
            ->pluck('product')
            ->filter();
    }

    /**
     * Get similar products for a given product.
     */
    public function getSimilarProducts(Product $product, int $limit = 6): \Illuminate\Support\Collection
    {
        $embedding = ProductEmbedding::where('product_id', $product->id)->first();
        if (!$embedding) return collect();

        return $this->findSimilar($embedding->embedding, $limit, [$product->id]);
    }

    /**
     * Get "Picked for you" products based on an array of viewed product IDs.
     * Averages the embeddings of viewed products then finds similar ones.
     */
    public function getPickedForYou(array $viewedProductIds, int $limit = 10): \Illuminate\Support\Collection
    {
        if (empty($viewedProductIds)) return collect();

        $embeddings = ProductEmbedding::whereIn('product_id', $viewedProductIds)->get();
        if ($embeddings->isEmpty()) return collect();

        // Average the viewed embeddings into one query vector
        $count  = $embeddings->count();
        $avgVec = null;

        foreach ($embeddings as $e) {
            $vec = $e->embedding;
            if ($avgVec === null) {
                $avgVec = $vec;
            } else {
                for ($i = 0; $i < count($avgVec); $i++) {
                    $avgVec[$i] += $vec[$i] ?? 0;
                }
            }
        }

        for ($i = 0; $i < count($avgVec); $i++) {
            $avgVec[$i] /= $count;
        }

        return $this->findSimilar($avgVec, $limit, $viewedProductIds);
    }
}
