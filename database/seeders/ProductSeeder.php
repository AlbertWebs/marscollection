<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $brands = Brand::all();

        $products = [
            [
                'name' => 'Vitamin C Serum',
                'description' => 'Brightening serum with 20% Vitamin C for radiant skin',
                'price' => 3999,
                'original_price' => 5999,
                'category_name' => 'Skincare',
                'brand_name' => 'Zayn\'s Beauty',
                'image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.8,
                'sold_count' => 2100,
                'badge' => 'BEST SELLER',
                'badge_color' => 'pink',
                'is_featured' => true,
                'is_trending' => true,
                'stock_quantity' => 50,
                'sku' => 'VC-SERUM-001'
            ],
            [
                'name' => 'Hyaluronic Acid Moisturizer',
                'description' => 'Deeply hydrating moisturizer with hyaluronic acid',
                'price' => 2999,
                'original_price' => null,
                'category_name' => 'Skincare',
                'brand_name' => 'Glow Essentials',
                'image' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.7,
                'sold_count' => 1800,
                'badge' => null,
                'badge_color' => null,
                'is_featured' => false,
                'is_trending' => true,
                'stock_quantity' => 75,
                'sku' => 'HA-MOIST-002'
            ],
            [
                'name' => 'Color Pop Lipstick Set',
                'description' => 'Long-lasting lipstick set in 5 vibrant shades',
                'price' => 2499,
                'original_price' => 3499,
                'category_name' => 'Makeup',
                'brand_name' => 'Luxe Beauty',
                'image' => 'https://images.unsplash.com/photo-1586495777744-4413f21062fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.9,
                'sold_count' => 3200,
                'badge' => 'NEW',
                'badge_color' => 'green',
                'is_featured' => true,
                'is_trending' => true,
                'stock_quantity' => 30,
                'sku' => 'LIP-SET-003'
            ],
            [
                'name' => 'Floral Perfume',
                'description' => 'Elegant floral fragrance with notes of rose and jasmine',
                'price' => 5999,
                'original_price' => null,
                'category_name' => 'Fragrances',
                'brand_name' => 'Pure Radiance',
                'image' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.6,
                'sold_count' => 1500,
                'badge' => 'PREMIUM',
                'badge_color' => 'purple',
                'is_featured' => false,
                'is_trending' => false,
                'stock_quantity' => 25,
                'sku' => 'PERF-FLOR-004'
            ],
            [
                'name' => 'Professional Makeup Brushes',
                'description' => 'Complete set of professional makeup brushes',
                'price' => 3499,
                'original_price' => 4999,
                'category_name' => 'Tools & Accessories',
                'brand_name' => 'Beauty Haven',
                'image' => 'https://images.unsplash.com/photo-1586495777744-4413f21062fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.8,
                'sold_count' => 2800,
                'badge' => 'LIMITED',
                'badge_color' => 'red',
                'is_featured' => true,
                'is_trending' => false,
                'stock_quantity' => 40,
                'sku' => 'BRUSH-SET-005'
            ],
            [
                'name' => 'Anti-Aging Night Cream',
                'description' => 'Advanced anti-aging formula for overnight repair',
                'price' => 8999,
                'original_price' => 12000,
                'category_name' => 'Skincare',
                'brand_name' => 'Zayn\'s Beauty',
                'image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.7,
                'sold_count' => 1800,
                'badge' => 'BEST SELLER',
                'badge_color' => 'blue',
                'is_featured' => true,
                'is_trending' => true,
                'stock_quantity' => 35,
                'sku' => 'NIGHT-CREAM-006'
            ],
            [
                'name' => 'Natural Foundation',
                'description' => 'Buildable coverage foundation for all skin types',
                'price' => 5200,
                'original_price' => null,
                'category_name' => 'Makeup',
                'brand_name' => 'Glow Essentials',
                'image' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.6,
                'sold_count' => 1500,
                'badge' => null,
                'badge_color' => null,
                'is_featured' => false,
                'is_trending' => false,
                'stock_quantity' => 60,
                'sku' => 'FOUND-NAT-007'
            ],
            [
                'name' => 'Luxury Body Lotion',
                'description' => 'Rich, moisturizing body lotion with natural oils',
                'price' => 4299,
                'original_price' => null,
                'category_name' => 'Body Care',
                'brand_name' => 'Luxe Beauty',
                'image' => 'https://images.unsplash.com/photo-1586495777744-4413f21062fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.9,
                'sold_count' => 1700,
                'badge' => 'NEW',
                'badge_color' => 'green',
                'is_featured' => true,
                'is_trending' => false,
                'stock_quantity' => 45,
                'sku' => 'BODY-LOT-008'
            ]
        ];

        foreach ($products as $productData) {
            $category = $categories->where('name', $productData['category_name'])->first();
            $brand = $brands->where('name', $productData['brand_name'])->first();

            if ($category && $brand) {
                Product::updateOrCreate(
                    ['sku' => $productData['sku']], // Find by SKU
                    [
                        'name' => $productData['name'],
                        'description' => $productData['description'],
                        'price' => $productData['price'],
                        'original_price' => $productData['original_price'],
                        'category_id' => $category->id,
                        'brand_id' => $brand->id,
                        'image' => $productData['image'],
                        'rating' => $productData['rating'],
                        'sold_count' => $productData['sold_count'],
                        'badge' => $productData['badge'],
                        'badge_color' => $productData['badge_color'],
                        'is_featured' => $productData['is_featured'],
                        'is_trending' => $productData['is_trending'],
                        'stock_quantity' => $productData['stock_quantity'],
                        'sku' => $productData['sku']
                    ]
                );
            }
        }
    }
}
