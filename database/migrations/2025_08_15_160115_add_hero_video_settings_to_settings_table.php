<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Hero Section Settings
        DB::table('settings')->insert([
            [
                'key' => 'hero_title',
                'value' => 'Discover Your Natural Beauty',
                'type' => 'string',
                'group' => 'hero',
                'label' => 'Hero Title',
                'description' => 'Main heading for the hero section',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'hero_subtitle',
                'value' => 'Premium beauty products that enhance your natural radiance. From skincare essentials to makeup must-haves, we bring you the finest quality products for your beauty journey.',
                'type' => 'textarea',
                'group' => 'hero',
                'label' => 'Hero Description',
                'description' => 'Description text below the hero title',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'hero_image',
                'value' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                'type' => 'string',
                'group' => 'hero',
                'label' => 'Hero Image URL',
                'description' => 'URL for the hero section background image',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'hero_stats_customers',
                'value' => '500+',
                'type' => 'string',
                'group' => 'hero',
                'label' => 'Happy Customers Count',
                'description' => 'Number of happy customers to display',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'hero_stats_products',
                'value' => '100+',
                'type' => 'string',
                'group' => 'hero',
                'label' => 'Premium Products Count',
                'description' => 'Number of premium products to display',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'hero_stats_rating',
                'value' => '5★',
                'type' => 'string',
                'group' => 'hero',
                'label' => 'Average Rating',
                'description' => 'Average rating to display',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'hero_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'hero',
                'label' => 'Enable Hero Section',
                'description' => 'Show or hide the hero section',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Video Section Settings
            [
                'key' => 'video_title',
                'value' => 'DISCOVER THE SECRETS OF GLOWING SKIN',
                'type' => 'string',
                'group' => 'video',
                'label' => 'Video Section Title',
                'description' => 'Title for the video section',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'video_description',
                'value' => 'Learn expert tips and techniques for achieving radiant, healthy skin from our beauty specialists',
                'type' => 'textarea',
                'group' => 'video',
                'label' => 'Video Description',
                'description' => 'Description text for the video section',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'video_youtube_id',
                'value' => 'BNmXh0p0Py4',
                'type' => 'string',
                'group' => 'video',
                'label' => 'YouTube Video ID',
                'description' => 'YouTube video ID (e.g., BNmXh0p0Py4)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'video_thumbnail',
                'value' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80',
                'type' => 'string',
                'group' => 'video',
                'label' => 'Video Thumbnail URL',
                'description' => 'URL for the video thumbnail image',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'video_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'video',
                'label' => 'Enable Video Section',
                'description' => 'Show or hide the video section',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('settings')->whereIn('group', ['hero', 'video'])->delete();
    }
};
