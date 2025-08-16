<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Zayn\'s Beauty',
                'description' => 'Premium beauty products for all skin types',
                'logo' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'website' => 'https://zaynsbeauty.com'
            ],
            [
                'name' => 'Glow Essentials',
                'description' => 'Natural skincare and makeup products',
                'logo' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'website' => 'https://glowessentials.com'
            ],
            [
                'name' => 'Luxe Beauty',
                'description' => 'Luxury beauty and skincare products',
                'logo' => 'https://images.unsplash.com/photo-1586495777744-4413f21062fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'website' => 'https://luxebeauty.com'
            ],
            [
                'name' => 'Pure Radiance',
                'description' => 'Organic and clean beauty products',
                'logo' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'website' => 'https://pureradiance.com'
            ],
            [
                'name' => 'Beauty Haven',
                'description' => 'Professional beauty tools and accessories',
                'logo' => 'https://images.unsplash.com/photo-1522338242992-e1a54906a8da?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'website' => 'https://beautyhaven.com'
            ]
        ];

        foreach ($brands as $brand) {
            Brand::create([
                'name' => $brand['name'],
                'slug' => Str::slug($brand['name']),
                'description' => $brand['description'],
                'logo' => $brand['logo'],
                'website' => $brand['website'],
                'is_active' => true
            ]);
        }
    }
}
