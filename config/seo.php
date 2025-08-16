<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SEO Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains all the SEO-related configuration for your application.
    | You can customize these settings to improve your website's SEO performance.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Default Meta Tags
    |--------------------------------------------------------------------------
    */
    'defaults' => [
        'title' => 'Zayn\'s Beauty - Premium Beauty Products & Professional Services',
        'description' => 'Discover premium beauty products, professional beauty services, and expert beauty consultations. Shop the latest trends in skincare, makeup, and beauty accessories.',
        'keywords' => 'beauty products, skincare, makeup, beauty services, beauty salon, beauty consultation, premium beauty, beauty accessories',
        'author' => 'Zayn\'s Beauty',
        'robots' => 'index, follow',
        'language' => 'English',
        'theme_color' => '#ec4899',
    ],

    /*
    |--------------------------------------------------------------------------
    | Open Graph Defaults
    |--------------------------------------------------------------------------
    */
    'open_graph' => [
        'type' => 'website',
        'site_name' => 'Zayn\'s Beauty',
        'locale' => 'en_US',
        'image' => [
            'width' => 1200,
            'height' => 630,
            'alt' => 'Zayn\'s Beauty - Premium Beauty Products',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Twitter Card Defaults
    |--------------------------------------------------------------------------
    */
    'twitter' => [
        'card' => 'summary_large_image',
        'site' => '@zaynsbeauty', // Update with your Twitter handle
        'creator' => '@zaynsbeauty', // Update with your Twitter handle
    ],

    /*
    |--------------------------------------------------------------------------
    | Schema.org Defaults
    |--------------------------------------------------------------------------
    */
    'schema' => [
        'organization' => [
            'name' => 'Zayn\'s Beauty',
            'url' => 'https://zaynsbeauty.com',
            'logo' => 'https://zaynsbeauty.com/images/logo.png',
            'description' => 'Premium beauty products and professional beauty services',
            'email' => 'info@zaynsbeauty.com',
            'phone' => '+254-XXX-XXX-XXX',
            'address' => [
                'street' => '',
                'city' => 'Nairobi',
                'region' => 'Nairobi',
                'postal_code' => '',
                'country' => 'KE',
            ],
            'geo' => [
                'latitude' => '',
                'longitude' => '',
            ],
            'opening_hours' => 'Mo-Fr 09:00-18:00',
            'price_range' => '$$',
        ],
        'local_business' => [
            'type' => 'BeautySalon',
            'name' => 'Zayn\'s Beauty',
            'description' => 'Premium beauty products and professional beauty services',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sitemap Configuration
    |--------------------------------------------------------------------------
    */
    'sitemap' => [
        'enabled' => true,
        'cache_duration' => 3600, // 1 hour
        'priorities' => [
            'home' => 1.0,
            'products' => 0.9,
            'categories' => 0.8,
            'brands' => 0.8,
            'bundles' => 0.8,
            'pages' => 0.7,
            'policies' => 0.3,
        ],
        'change_frequencies' => [
            'home' => 'daily',
            'products' => 'weekly',
            'categories' => 'weekly',
            'brands' => 'weekly',
            'bundles' => 'weekly',
            'pages' => 'monthly',
            'policies' => 'yearly',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Robots.txt Configuration
    |--------------------------------------------------------------------------
    */
    'robots' => [
        'user_agent' => '*',
        'allow' => [
            '/',
            '/products/',
            '/categories/',
            '/brands/',
            '/bundles/',
            '/appointments/',
            '/about',
            '/contact',
            '/privacy-policy',
            '/terms-of-service',
            '/shipping-info',
            '/returns-policy',
        ],
        'disallow' => [
            '/admin/',
            '/login',
            '/register',
            '/password/',
            '/email/',
            '/verify-email',
            '/forgot-password',
            '/reset-password',
            '/confirm-password',
            '/cart',
            '/checkout/',
            '/search',
            '/products?search=',
            '/products?category=',
            '/products?brand=',
        ],
        'crawl_delay' => 1,
        'sitemap' => 'https://zaynsbeauty.com/sitemap.xml',
    ],

    /*
    |--------------------------------------------------------------------------
    | Performance Optimization
    |--------------------------------------------------------------------------
    */
    'performance' => [
        'cache_control' => 'public, max-age=3600, s-maxage=86400',
        'compression' => true,
        'security_headers' => [
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'SAMEORIGIN',
            'X-XSS-Protection' => '1; mode=block',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Permissions-Policy' => 'geolocation=(), microphone=(), camera=()',
        ],
        'content_security_policy' => "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://fonts.bunny.net; style-src 'self' 'unsafe-inline' https://fonts.bunny.net; font-src 'self' https://fonts.bunny.net; img-src 'self' data: https:; connect-src 'self'; frame-src 'none'; object-src 'none';",
    ],

    /*
    |--------------------------------------------------------------------------
    | Social Media Links
    |--------------------------------------------------------------------------
    */
    'social_media' => [
        'facebook' => 'https://facebook.com/zaynsbeauty',
        'instagram' => 'https://instagram.com/zaynsbeauty',
        'twitter' => 'https://twitter.com/zaynsbeauty',
        'youtube' => 'https://youtube.com/zaynsbeauty',
        'tiktok' => 'https://tiktok.com/@zaynsbeauty',
    ],

    /*
    |--------------------------------------------------------------------------
    | Analytics Configuration
    |--------------------------------------------------------------------------
    */
    'analytics' => [
        'google_analytics' => [
            'enabled' => false,
            'tracking_id' => 'GA_MEASUREMENT_ID', // Replace with your GA4 tracking ID
        ],
        'google_tag_manager' => [
            'enabled' => false,
            'container_id' => 'GTM-XXXXXXX', // Replace with your GTM container ID
        ],
        'facebook_pixel' => [
            'enabled' => false,
            'pixel_id' => 'XXXXXXXXXX', // Replace with your Facebook Pixel ID
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | SEO Keywords by Category
    |--------------------------------------------------------------------------
    */
    'keywords' => [
        'skincare' => [
            'skincare products',
            'facial care',
            'anti-aging',
            'moisturizer',
            'cleanser',
            'serum',
            'sunscreen',
            'beauty routine',
        ],
        'makeup' => [
            'makeup products',
            'cosmetics',
            'foundation',
            'lipstick',
            'eyeshadow',
            'mascara',
            'beauty makeup',
            'professional makeup',
        ],
        'haircare' => [
            'hair products',
            'hair care',
            'shampoo',
            'conditioner',
            'hair treatment',
            'hair styling',
            'professional hair care',
        ],
        'fragrances' => [
            'perfumes',
            'fragrances',
            'colognes',
            'body sprays',
            'luxury fragrances',
            'beauty scents',
        ],
        'tools' => [
            'beauty tools',
            'makeup brushes',
            'skincare tools',
            'beauty accessories',
            'professional tools',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | SEO Page Templates
    |--------------------------------------------------------------------------
    */
    'page_templates' => [
        'home' => [
            'title' => 'Zayn\'s Beauty - Premium Beauty Products & Professional Services | Kenya',
            'description' => 'Discover premium beauty products, professional beauty services, and expert beauty consultations in Kenya. Shop the latest trends in skincare, makeup, and beauty accessories. Book appointments online.',
            'keywords' => 'beauty products Kenya, skincare Nairobi, makeup Kenya, beauty services, beauty salon Nairobi, beauty consultation, premium beauty products, beauty accessories',
        ],
        'products' => [
            'title' => 'Beauty Products - Premium Skincare, Makeup & Beauty Accessories | Zayn\'s Beauty',
            'description' => 'Shop premium beauty products including skincare, makeup, and beauty accessories. Discover trending and featured products from top beauty brands. Free shipping on orders over KES 5,000.',
            'keywords' => 'beauty products, skincare, makeup, beauty accessories, premium beauty, beauty brands, trending products, featured products',
        ],
        'categories' => [
            'title' => 'Beauty Categories - Shop by Category | Zayn\'s Beauty',
            'description' => 'Browse beauty products by category. Find skincare, makeup, haircare, fragrances, and beauty tools. Shop the best beauty products organized by category.',
            'keywords' => 'beauty categories, skincare category, makeup category, haircare category, fragrance category, beauty tools category',
        ],
        'brands' => [
            'title' => 'Beauty Brands - Premium Beauty Brands | Zayn\'s Beauty',
            'description' => 'Discover premium beauty brands at Zayn\'s Beauty. Shop the best beauty products from top international and local brands. Quality guaranteed.',
            'keywords' => 'beauty brands, premium brands, international brands, local brands, quality beauty products',
        ],
        'about' => [
            'title' => 'About Us - Zayn\'s Beauty | Premium Beauty Products & Services',
            'description' => 'Learn about Zayn\'s Beauty - your trusted source for premium beauty products and professional beauty services in Kenya. Our story, mission, and commitment to beauty excellence.',
            'keywords' => 'about Zayn\'s Beauty, beauty company Kenya, beauty services Nairobi, premium beauty products, beauty excellence',
        ],
        'contact' => [
            'title' => 'Contact Us - Zayn\'s Beauty | Get in Touch',
            'description' => 'Contact Zayn\'s Beauty for customer support, product inquiries, or beauty consultations. We\'re here to help you with all your beauty needs.',
            'keywords' => 'contact Zayn\'s Beauty, customer support, beauty consultation, product inquiries, beauty help',
        ],
    ],
];
