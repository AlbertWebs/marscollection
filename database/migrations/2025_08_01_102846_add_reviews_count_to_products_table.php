<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('reviews_count')->default(0)->after('rating');
        });

        // Populate reviews_count for existing products
        $products = \App\Models\Product::all();
        foreach ($products as $product) {
            $reviewsCount = $product->reviews()->count();
            $averageRating = $product->reviews()->avg('rating') ?? 0;
            
            $product->update([
                'reviews_count' => $reviewsCount,
                'rating' => $averageRating
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('reviews_count');
        });
    }
};
