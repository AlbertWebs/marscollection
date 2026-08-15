<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ProductEmbedding;
use App\Services\EmbeddingService;
use Illuminate\Console\Command;

class GenerateProductEmbeddings extends Command
{
    protected $signature = 'embeddings:generate
                            {--missing : Only generate for products without embeddings}
                            {--id= : Generate for a specific product ID}';

    protected $description = 'Generate Gemini embeddings for products';

    public function handle(EmbeddingService $service): int
    {
        if ($id = $this->option('id')) {
            $product = Product::find($id);
            if (!$product) {
                $this->error("Product #{$id} not found.");
                return 1;
            }
            $this->info("Generating embedding for: {$product->name}");
            $ok = $service->generateForProduct($product);
            $this->info($ok ? '✓ Done' : '✗ Failed — check GEMINI_API_KEY');
            return $ok ? 0 : 1;
        }

        $query = Product::where('is_active', true);

        if ($this->option('missing')) {
            $existing = ProductEmbedding::pluck('product_id');
            $query->whereNotIn('id', $existing);
        }

        $products = $query->with(['brand', 'category'])->get();
        $total    = $products->count();

        if ($total === 0) {
            $this->info('All products already have embeddings.');
            return 0;
        }

        $this->info("Generating embeddings for {$total} product(s)...");
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $success = 0;
        $failed  = 0;

        foreach ($products as $product) {
            $ok = $service->generateForProduct($product);
            $ok ? $success++ : $failed++;
            $bar->advance();
            // Small delay to respect rate limits (15 RPM free tier)
            usleep(100000); // 100ms
        }

        $bar->finish();
        $this->newLine();
        $this->info("Done: {$success} succeeded, {$failed} failed.");

        return $failed > 0 ? 1 : 0;
    }
}
