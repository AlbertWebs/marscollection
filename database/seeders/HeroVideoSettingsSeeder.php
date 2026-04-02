<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeroVideoSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hero Section Settings
        Setting::set('hero_enabled', '1', 'Enable Hero Section', 'hero', 'boolean');
        Setting::set('hero_title', 'Natural Beauty', 'Hero Title', 'hero', 'string');
        Setting::set('hero_subtitle', 'Premium beauty products that enhance your natural radiance. From skincare essentials to makeup must-haves, we bring you the finest quality products for your beauty journey.', 'Hero Description', 'hero', 'textarea');
        Setting::set('hero_image', 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80', 'Hero Image URL', 'hero', 'string');
        Setting::set('hero_stats_customers', '500+', 'Happy Customers Count', 'hero', 'string');
        Setting::set('hero_stats_products', '100+', 'Premium Products Count', 'hero', 'string');
        Setting::set('hero_stats_rating', '5', 'Average Rating', 'hero', 'string');

        // Video Section Settings
        Setting::set('video_enabled', '1', 'Enable Video Section', 'video', 'boolean');
        Setting::set('video_title', 'DISCOVER THE SECRETS OF GLOWING SKIN', 'Video Section Title', 'video', 'string');
        Setting::set('video_description', 'Learn expert tips and techniques for achieving radiant, healthy skin from our beauty specialists', 'Video Description', 'video', 'textarea');
        Setting::set('video_youtube_id', 'BNmXh0p0Py4', 'YouTube Video ID', 'video', 'string');
        Setting::set('video_thumbnail', 'https://images.unsplash.com/photo-1556228720-195a672e8a03?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80', 'Video Thumbnail URL', 'video', 'string');
    }
}
