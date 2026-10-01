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
        Setting::set('contact_phone_primary', '0726243706', 'Primary Phone Number', 'contact', 'string');
        Setting::set('contact_phone_secondary', '', 'Secondary Phone Number', 'contact', 'string');
        Setting::set('contact_email_primary', 'info@marscollection.co.ke', 'Primary Email', 'contact', 'string');
        Setting::set('contact_email_support', 'support@marscollection.co.ke', 'Support Email', 'contact', 'string');
        Setting::set('contact_address_name', 'Mars Collection', 'Business Name', 'contact', 'string');
        Setting::set('contact_address_street', 'Nairobi, Kenya', 'Street Address', 'contact', 'string');
        Setting::set('contact_address_city', 'Nairobi, Kenya', 'City and Country', 'contact', 'string');
        Setting::set('contact_address_full', 'Mars Collection, Nairobi, Kenya', 'Full Address', 'contact', 'string');

        // Business Settings
        Setting::set('business_name', 'Mars Collection', 'Business Name', 'business', 'string');
        Setting::set('business_hours_monday_friday', '9:00 AM - 8:00 PM', 'Monday - Friday Hours', 'business', 'string');
        Setting::set('business_hours_saturday', '9:00 AM - 6:00 PM', 'Saturday Hours', 'business', 'string');
        Setting::set('business_hours_sunday', '10:00 AM - 4:00 PM', 'Sunday Hours', 'business', 'string');
        Setting::set('business_note', 'We\'re closed on public holidays. Online orders are processed 24/7!', 'Business Note', 'business', 'string');

        // Social Media Settings
        Setting::set('social_facebook', 'https://www.facebook.com/people/Mars-collections/100081227420740/', 'Facebook URL', 'social', 'string');
        Setting::set('social_instagram', '', 'Instagram URL', 'social', 'string');
        Setting::set('social_twitter', '', 'Twitter URL', 'social', 'string');
        Setting::set('social_tiktok', '', 'TikTok URL', 'social', 'string');

        // Email Settings
        Setting::set('email_admin', 'admin@marscollection.co.ke', 'Admin Email', 'email', 'string');
        Setting::set('email_from_name', 'Mars Collection', 'From Name', 'email', 'string');
        Setting::set('email_from_address', 'noreply@marscollection.co.ke', 'From Address', 'email', 'string');
        Setting::set('email_privacy', 'privacy@marscollection.co.ke', 'Privacy Email', 'email', 'string');
        Setting::set('email_legal', 'legal@marscollection.co.ke', 'Legal Email', 'email', 'string');
        Setting::set('email_returns', 'returns@marscollection.co.ke', 'Returns Email', 'email', 'string');
        Setting::set('email_shipping', 'shipping@marscollection.co.ke', 'Shipping Email', 'email', 'string');

        // Hero Section Settings
        Setting::set('hero_enabled', '1', 'Enable Hero Section', 'hero', 'boolean');
        Setting::set('hero_title', 'Step out in your style.', 'Hero Title', 'hero', 'string');
        Setting::set('hero_subtitle', 'Fresh kicks, timeless classics and everyday comfort. Find your next favourite pair at Mars Collection.', 'Hero Description', 'hero', 'textarea');
        Setting::set('hero_image', '/images/mars-footwear-hero.png', 'Hero Image URL', 'hero', 'string');
        Setting::set('hero_stats_customers', '500+', 'Happy Customers Count', 'hero', 'string');
        Setting::set('hero_stats_products', '100+', 'Premium Products Count', 'hero', 'string');
        Setting::set('hero_stats_rating', 'New', 'Store Rating', 'hero', 'string');

        // Video Section Settings
        Setting::set('video_enabled', '0', 'Enable Video Section', 'video', 'boolean');
        Setting::set('video_title', 'Find your fit', 'Video Section Title', 'video', 'string');
        Setting::set('video_description', 'Contact Mars Collection for help choosing your shoe size.', 'Video Description', 'video', 'textarea');
        Setting::set('video_youtube_id', '', 'Video ID', 'video', 'string');
        Setting::set('video_thumbnail', '/images/mars-footwear-hero.png', 'Video Thumbnail URL', 'video', 'string');
    }
}
