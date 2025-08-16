<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contact Settings
        Setting::set('contact_phone_primary', '+254 700 123 456', 'Primary Phone Number', 'contact', 'string');
        Setting::set('contact_phone_secondary', '+254 733 789 012', 'Secondary Phone Number', 'contact', 'string');
        Setting::set('contact_email_primary', 'info@zaynsbeauty.com', 'Primary Email', 'contact', 'string');
        Setting::set('contact_email_support', 'support@zaynsbeauty.com', 'Support Email', 'contact', 'string');
        Setting::set('contact_address_name', 'Zayn\'s Beauty Store', 'Business Name', 'contact', 'string');
        Setting::set('contact_address_street', 'Westlands Mall, 2nd Floor', 'Street Address', 'contact', 'string');
        Setting::set('contact_address_city', 'Nairobi, Kenya', 'City and Country', 'contact', 'string');
        Setting::set('contact_address_full', 'Zayn\'s Beauty Store, Westlands Mall, 2nd Floor, Nairobi, Kenya', 'Full Address', 'contact', 'string');

        // Business Settings
        Setting::set('business_name', 'Zayn\'s Beauty', 'Business Name', 'business', 'string');
        Setting::set('business_hours_monday_friday', '9:00 AM - 8:00 PM', 'Monday - Friday Hours', 'business', 'string');
        Setting::set('business_hours_saturday', '9:00 AM - 6:00 PM', 'Saturday Hours', 'business', 'string');
        Setting::set('business_hours_sunday', '10:00 AM - 4:00 PM', 'Sunday Hours', 'business', 'string');
        Setting::set('business_note', 'We\'re closed on public holidays. Online orders are processed 24/7!', 'Business Note', 'business', 'string');

        // Social Media Settings
        Setting::set('social_facebook', 'https://facebook.com/zaynsbeauty', 'Facebook URL', 'social', 'string');
        Setting::set('social_instagram', 'https://instagram.com/zaynsbeauty', 'Instagram URL', 'social', 'string');
        Setting::set('social_twitter', 'https://twitter.com/zaynsbeauty', 'Twitter URL', 'social', 'string');

        // Email Settings
        Setting::set('email_admin', 'admin@zaynsbeauty.com', 'Admin Email', 'email', 'string');
        Setting::set('email_from_name', 'Zayn\'s Beauty', 'From Name', 'email', 'string');
        Setting::set('email_from_address', 'noreply@zaynsbeauty.com', 'From Address', 'email', 'string');
        Setting::set('email_privacy', 'privacy@zaynsbeauty.com', 'Privacy Email', 'email', 'string');
        Setting::set('email_legal', 'legal@zaynsbeauty.com', 'Legal Email', 'email', 'string');
        Setting::set('email_returns', 'returns@zaynsbeauty.com', 'Returns Email', 'email', 'string');
        Setting::set('email_shipping', 'shipping@zaynsbeauty.com', 'Shipping Email', 'email', 'string');

        // Hero Section Settings
        Setting::set('hero_enabled', '1', 'Enable Hero Section', 'hero', 'boolean');
        Setting::set('hero_title', 'Natural Beauty', 'Hero Title', 'hero', 'string');
        Setting::set('hero_subtitle', 'Premium beauty products that enhance your natural radiance. From skincare essentials to makeup must-haves, we bring you the finest quality products for your beauty journey.', 'Hero Description', 'hero', 'textarea');
        Setting::set('hero_image', 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80', 'Hero Image URL', 'hero', 'string');
        Setting::set('hero_stats_customers', '500+', 'Happy Customers Count', 'hero', 'string');
        Setting::set('hero_stats_products', '100+', 'Premium Products Count', 'hero', 'string');
        Setting::set('hero_stats_rating', '5★', 'Average Rating', 'hero', 'string');

        // Video Section Settings
        Setting::set('video_enabled', '1', 'Enable Video Section', 'video', 'boolean');
        Setting::set('video_title', 'DISCOVER THE SECRETS OF GLOWING SKIN', 'Video Section Title', 'video', 'string');
        Setting::set('video_description', 'Learn expert tips and techniques for achieving radiant, healthy skin from our beauty specialists', 'Video Description', 'video', 'textarea');
        Setting::set('video_youtube_id', 'BNmXh0p0Py4', 'YouTube Video ID', 'video', 'string');
        Setting::set('video_thumbnail', 'https://images.unsplash.com/photo-1556228720-195a672e8a03?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80', 'Video Thumbnail URL', 'video', 'string');
    }
}
