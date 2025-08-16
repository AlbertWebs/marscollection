<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Skincare',
                'description' => 'Face creams, serums, cleansers, and treatments for healthy skin',
                'image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80'
            ],
            [
                'name' => 'Makeup',
                'description' => 'Foundation, lipstick, eyeshadow, and other cosmetic products',
                'image' => 'https://images.unsplash.com/photo-1586495777744-4413f21062fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80'
            ],
            [
                'name' => 'Haircare',
                'description' => 'Shampoo, conditioner, styling products, and hair treatments',
                'image' => 'https://images.unsplash.com/photo-1522338242992-e1a54906a8da?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80'
            ],
            [
                'name' => 'Fragrances',
                'description' => 'Perfumes, colognes, and body sprays',
                'image' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80'
            ],
            [
                'name' => 'Body Care',
                'description' => 'Body lotions, scrubs, and bath products',
                'image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80'
            ],
            [
                'name' => 'Tools & Accessories',
                'description' => 'Makeup brushes, mirrors, and beauty tools',
                'image' => 'https://images.unsplash.com/photo-1586495777744-4413f21062fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80'
            ]
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'image' => $category['image'],
                'is_active' => true
            ]);
        }
    }
}
