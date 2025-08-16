<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Bridal Makeup',
                'description' => 'Complete bridal makeup including hair styling, makeup, and touch-ups',
                'price' => 15000,
                'duration' => 120,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Party Makeup',
                'description' => 'Glamorous party makeup with hair styling',
                'price' => 8000,
                'duration' => 90,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Photoshoot Makeup',
                'description' => 'Professional makeup for photoshoots and events',
                'price' => 12000,
                'duration' => 90,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Everyday Makeup',
                'description' => 'Natural everyday makeup application',
                'price' => 5000,
                'duration' => 60,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Special Occasion',
                'description' => 'Custom makeup for special events and occasions',
                'price' => 10000,
                'duration' => 90,
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
