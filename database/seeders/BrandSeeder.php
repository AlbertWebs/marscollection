<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        Brand::updateOrCreate(
            ['slug' => 'mars-collection'],
            [
                'name' => 'Mars Collection',
                'description' => 'Footwear selected for everyday style and comfort.',
                'logo' => '/mars-collections-logo.png',
                'website' => 'https://marscollection.co.ke',
                'is_active' => true,
            ]
        );

        Brand::where('slug', '!=', 'mars-collection')->update(['is_active' => false]);
    }
}
