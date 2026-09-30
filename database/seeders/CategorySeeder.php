<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Sneakers', 'description' => 'Everyday sneakers, court styles and streetwear favourites.', 'image' => '/images/sneakers-runner.jpg'],
            ['name' => 'Formal Shoes', 'description' => 'Polished lace-ups and dress shoes for sharper occasions.', 'image' => '/images/formal-shoes.jpg'],
            ['name' => 'Loafers', 'description' => 'Easy slip-on styles for work, weekends and everything between.', 'image' => '/images/loafers.jpg'],
            ['name' => 'Flats', 'description' => 'Light, versatile flats made for busy days.', 'image' => '/images/flats.jpg'],
            ['name' => 'Sandals', 'description' => 'Open, comfortable pairs for relaxed days and warm weather.', 'image' => '/images/sandals.jpg'],
            ['name' => 'Boots', 'description' => 'Statement boots and dependable everyday pairs.', 'image' => '/images/boots.jpg'],
        ];

        $slugs = [];
        foreach ($categories as $index => $category) {
            $slug = Str::slug($category['name']);
            $slugs[] = $slug;
            Category::updateOrCreate(['slug' => $slug], $category + ['sort_order' => $index + 1, 'is_active' => true]);
        }

        Category::whereNotIn('slug', $slugs)->update(['is_active' => false]);
    }
}
