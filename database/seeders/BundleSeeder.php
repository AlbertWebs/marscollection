<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bundle;
use App\Models\Product;

class BundleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bundles = [
            [
                'name' => 'Flawless Complexion Set',
                'description' => 'Complete skincare routine for achieving flawless, radiant skin. Includes cleanser, serum, moisturizer, and sunscreen.',
                'price' => 12999,
                'original_price' => 18999,
                'image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'badge' => 'BEST SELLER',
                'badge_color' => 'pink',
                'category' => 'SKINCARE & MAKEUP',
                'is_featured' => true,
                'is_trending' => true,
                'sold_count' => 127,
                'rating' => 0,
                'review_count' => 0,
                'product_ids' => [1, 2, 6] // Vitamin C Serum, Hyaluronic Acid, Anti-Aging Night Cream
            ],
            [
                'name' => 'Ultimate Repair Hair Kit',
                'description' => 'Complete hair care solution for damaged and dry hair. Includes shampoo, conditioner, and hair mask.',
                'price' => 8999,
                'original_price' => 12999,
                'image' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'badge' => 'NEW',
                'badge_color' => 'green',
                'category' => 'HAIRCARE',
                'is_featured' => true,
                'is_trending' => false,
                'sold_count' => 89,
                'rating' => 0,
                'review_count' => 0,
                'product_ids' => [2, 7, 8] // Hyaluronic Acid, Natural Foundation, Luxury Body Lotion
            ],
            [
                'name' => 'Enigma Eau de Parfum',
                'description' => 'Exclusive fragrance collection with long-lasting scent. Perfect for special occasions.',
                'price' => 15999,
                'original_price' => 21999,
                'image' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'badge' => 'PREMIUM',
                'badge_color' => 'purple',
                'category' => 'FRAGRANCES',
                'is_featured' => false,
                'is_trending' => true,
                'sold_count' => 203,
                'rating' => 0,
                'review_count' => 0,
                'product_ids' => [4, 5] // Floral Perfume, Professional Makeup Brushes
            ],
            [
                'name' => 'Complete Makeup Collection',
                'description' => 'Professional makeup kit with everything you need for a perfect look. Includes foundation, lipstick, brushes, and more.',
                'price' => 18999,
                'original_price' => 25999,
                'image' => 'https://images.unsplash.com/photo-1586495777744-4413f21062fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'badge' => 'LIMITED',
                'badge_color' => 'red',
                'category' => 'MAKEUP',
                'is_featured' => true,
                'is_trending' => true,
                'sold_count' => 156,
                'rating' => 0,
                'review_count' => 0,
                'product_ids' => [3, 5, 7] // Color Pop Lipstick Set, Professional Makeup Brushes, Natural Foundation
            ]
        ];

        foreach ($bundles as $bundleData) {
            $productIds = $bundleData['product_ids'];
            unset($bundleData['product_ids']);
            
            $bundle = Bundle::create($bundleData);
            
            // Attach products to bundle
            foreach ($productIds as $productId) {
                $bundle->products()->attach($productId, ['quantity' => 1]);
            }
        }
    }
}
