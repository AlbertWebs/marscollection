<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::whereIn('sku', [
            'VC-SERUM-001', 'HA-MOIST-002', 'LIP-SET-003', 'PERF-FLOR-004',
            'BRUSH-SET-005', 'NIGHT-CREAM-006', 'FOUND-NAT-007', 'BODY-LOT-008',
        ])->update(['is_active' => false]);

        $brand = Brand::where('slug', 'mars-collection')->firstOrFail();
        $sizeVariants = collect(range(39, 45))->map(fn ($size) => ['label' => (string) $size])->all();

        $products = [
            ['sku' => 'MC-SNK-001', 'name' => 'Court Classic High-Top', 'category' => 'Sneakers', 'description' => 'Meet the Court Classic High-Top, an everyday sneaker designed for clean streetwear styling. Its cushioned collar adds comfort around the ankle, while the grippy rubber sole is built for steady everyday steps. Choose from black, white or gold accents and select your available shoe size. Pair it with denim, joggers or relaxed outfits for an easy finish.', 'meta_description' => 'Shop the Court Classic High-Top from Mars Collection Kenya. Choose your shoe size and black, white or gold color option, then order online.', 'price' => 6500, 'original_price' => 8500, 'image' => '/images/mars-footwear-hero.png', 'colors' => ['Black', 'White', 'Gold'], 'badge' => 'NEW', 'featured' => true, 'trending' => true],
            ['sku' => 'MC-SNK-002', 'name' => 'Everyday Court Sneaker', 'category' => 'Sneakers', 'description' => 'A lightweight lace-up sneaker with a padded insole for all-day wear.', 'price' => 4200, 'original_price' => null, 'image' => '/images/sneakers-red.jpg', 'colors' => ['Red', 'Black', 'White'], 'badge' => 'POPULAR', 'featured' => true, 'trending' => true],
            ['sku' => 'MC-SNK-003', 'name' => 'Street Runner', 'category' => 'Sneakers', 'description' => 'A sporty everyday pair with a breathable upper and flexible sole.', 'price' => 5800, 'original_price' => 7200, 'image' => '/images/sneakers-runner.jpg', 'colors' => ['Black', 'Grey', 'White'], 'badge' => null, 'featured' => true, 'trending' => true],
            ['sku' => 'MC-FRM-004', 'name' => 'City Lace-Up', 'category' => 'Formal Shoes', 'description' => 'A versatile lace-up profile for workdays, events and dressed-up evenings.', 'price' => 7200, 'original_price' => null, 'image' => '/images/formal-shoes.jpg', 'colors' => ['Black', 'Brown'], 'badge' => null, 'featured' => true, 'trending' => false],
            ['sku' => 'MC-LOA-005', 'name' => 'Weekend Penny Loafer', 'category' => 'Loafers', 'description' => 'An easy slip-on with a classic profile that works with denim or tailored trousers.', 'price' => 5600, 'original_price' => null, 'image' => '/images/loafers.jpg', 'colors' => ['Black', 'Tan'], 'badge' => 'EASY WEAR', 'featured' => true, 'trending' => true],
            ['sku' => 'MC-FLT-006', 'name' => 'Soft Step Ballet Flat', 'category' => 'Flats', 'description' => 'A simple lightweight flat with a flexible sole for busy days on your feet.', 'price' => 3500, 'original_price' => null, 'image' => '/images/flats.jpg', 'colors' => ['Black', 'Nude'], 'badge' => null, 'featured' => false, 'trending' => true],
            ['sku' => 'MC-SND-007', 'name' => 'Everyday Comfort Sandal', 'category' => 'Sandals', 'description' => 'A relaxed, easy-to-wear sandal with a supportive footbed and adjustable straps.', 'price' => 2900, 'original_price' => null, 'image' => '/images/sandals.jpg', 'colors' => ['Black', 'Brown'], 'badge' => null, 'featured' => false, 'trending' => false],
            ['sku' => 'MC-BOT-008', 'name' => 'Everyday Ankle Boot', 'category' => 'Boots', 'description' => 'A sturdy ankle boot with a clean shape for cooler days and evening plans.', 'price' => 7900, 'original_price' => 9500, 'image' => '/images/boots.jpg', 'colors' => ['Black', 'Brown'], 'badge' => 'JUST IN', 'featured' => true, 'trending' => false],
        ];

        foreach ($products as $item) {
            $category = Category::where('name', $item['category'])->firstOrFail();
            $product = Product::updateOrCreate(
                ['sku' => $item['sku']],
                [
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'original_price' => $item['original_price'],
                    'category_id' => $category->id,
                    'brand_id' => $brand->id,
                    'image' => $item['image'],
                    'rating' => 0,
                    'reviews_count' => 0,
                    'sold_count' => 0,
                    'badge' => $item['badge'],
                    'badge_color' => 'amber',
                    'is_featured' => $item['featured'],
                    'is_trending' => $item['trending'],
                    'is_active' => true,
                    'stock_quantity' => 12,
                    'colors' => $item['colors'],
                    'variants' => $sizeVariants,
                ]
            );

            if (isset($item['meta_description'])) {
                $product->update(['meta_description' => $item['meta_description']]);
            }
        }
    }
}
