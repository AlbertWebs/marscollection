<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class HomePageSeeder extends Seeder
{
    public function run(): void
    {
        $content = [
            'home.title' => 'Mars Collection | Sneakers & Shoes in Kenya',
            'home.description' => 'Shop sneakers, casual shoes, formal footwear and everyday favourites at Mars Collection. Find your fit and order online in Kenya.',
            'home.keywords' => 'shoes Kenya, sneakers Nairobi, buy shoes online Kenya, Mars Collection footwear',
            'home.hero.eyebrow' => 'Footwear for every move',
            'home.hero.title_start' => 'Step out in',
            'home.hero.title_end' => 'your style.',
            'home.hero.description' => 'Fresh kicks, timeless classics and everyday comfort. Find your next favourite pair at Mars Collection.',
            'home.hero.primary_button' => 'Shop footwear',
            'home.hero.secondary_button' => 'Browse categories',
            'home.hero.categories' => 'Sneakers · Formal · Everyday',
            'home.categories.eyebrow' => 'Find your pair',
            'home.categories.title' => 'Shop by category',
            'home.categories.link' => 'All categories',
            'home.trending.eyebrow' => 'The pairs everyone wants',
            'home.trending.title' => 'Trending now',
            'home.trending.link' => 'Shop all',
            'home.featured.eyebrow' => 'Made for your everyday',
            'home.featured.title' => 'The Mars edit',
            'home.featured.description' => 'Fresh sneakers, smart classics and comfortable pairs for wherever the day takes you.',
            'home.featured.button' => 'Explore all footwear',
            'home.benefit.size.title' => 'A size for your stride',
            'home.benefit.size.description' => 'Clear size options on every pair',
            'home.benefit.delivery.title' => 'Delivery across Kenya',
            'home.benefit.delivery.description' => 'Convenient dispatch to your door',
            'home.benefit.fit.title' => 'Help choosing your fit',
            'home.benefit.fit.description' => 'Message us with your shoe questions',
            'home.newsletter.title' => 'Get new arrivals & offers first',
            'home.newsletter.description' => 'Footwear drops, exclusive offers, and updates from Mars Collection.',
            'home.newsletter.placeholder' => 'your@email.com',
            'home.newsletter.button' => 'Subscribe',
        ];

        foreach ($content as $key => $value) {
            Setting::set($key, $value, ucwords(str_replace(['home.', '.', '_'], ['', ' ', ' '], $key)), 'homepage', 'string');
        }
    }
}
