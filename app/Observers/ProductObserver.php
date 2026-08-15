<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\EmbeddingService;

class ProductObserver
{
    public function created(Product $product): void
    {
        $this->dispatchEmbedding($product);
    }

    public function updated(Product $product): void
    {
        // Clear cached similar products for this product
        cache()->forget('similar_products_' . $product->id);

        // Only re-embed when fields that affect semantic meaning change
        $semantic = ['name', 'description', 'brand_id', 'category_id', 'variants'];
        if ($product->wasChanged($semantic)) {
            $this->dispatchEmbedding($product);
        }
    }

    public function deleted(Product $product): void
    {
        cache()->forget('similar_products_' . $product->id);
    }

    private function dispatchEmbedding(Product $product): void
    {
        // Run in background via queue so it doesn't slow down the request
        dispatch(function () use ($product) {
            app(EmbeddingService::class)->generateForProduct($product);
        })->afterResponse();
    }
}
