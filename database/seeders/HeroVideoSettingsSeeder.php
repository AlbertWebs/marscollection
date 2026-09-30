<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class HeroVideoSettingsSeeder extends Seeder
{
    public function run(): void
    {
        Setting::set('video_enabled', '0', 'Enable Video Section', 'video', 'boolean');
        Setting::set('video_title', 'Find your fit', 'Video Section Title', 'video', 'string');
        Setting::set('video_description', 'Contact Mars Collection for help choosing your shoe size.', 'Video Description', 'video', 'textarea');
        Setting::set('video_youtube_id', '', 'Video ID', 'video', 'string');
        Setting::set('video_thumbnail', '/images/mars-footwear-hero.png', 'Video Thumbnail URL', 'video', 'string');
    }
}
