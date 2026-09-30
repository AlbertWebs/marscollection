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
        'title' => 'Mars Collection - Shoes & Footwear in Kenya',
        'description' => 'Shop sneakers, formal shoes, sandals and more at Mars Collection in Kenya.',
        'keywords' => 'shoes Kenya, sneakers, formal shoes, sandals, Mars Collection',
        'author' => 'Mars Collection',
        'robots' => 'index, follow',
        'language' => 'English',
        'theme_color' => '#111111',
    ],

    /*
    |--------------------------------------------------------------------------
    | Open Graph Defaults
    |--------------------------------------------------------------------------
    */
    'open_graph' => [
        'type' => 'website',
        'site_name' => 'Mars Collection',
        'locale' => 'en_US',
        'image' => [
            'width' => 1200,
            'height' => 630,
            'alt' => 'Mars Collection footwear',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Twitter Card Defaults
    |--------------------------------------------------------------------------
    */
    'twitter' => [
        'card' => 'summary_large_image',
        'site' => '@marscollection', // Update with your Twitter handle
        'creator' => '@marscollection', // Update with your Twitter handle
    ],

    /*
    |--------------------------------------------------------------------------
    | Schema.org Defaults
    |--------------------------------------------------------------------------
    */
    'schema' => [
        'organization' => [
            'name' => 'Mars Collection',
            'url' => 'https://marscollection.co.ke',
            'logo' => 'https://marscollection.co.ke/mars-collections-logo.png',
            'description' => 'Shoes and footwear from Mars Collection in Kenya.',
            'email' => 'info@marscollection.co.ke',
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
            'type' => 'Store',
            'name' => 'Mars Collection',
            'description' => 'Shoes and footwear from Mars Collection in Kenya.',
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
        'sitemap' => 'https://marscollection.co.ke/sitemap.xml',
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
        'facebook' => 'https://facebook.com/marscollection',
        'instagram' => 'https://instagram.com/marscollection',
        'twitter' => 'https://twitter.com/marscollection',
        'youtube' => 'https://youtube.com/marscollection',
        'tiktok' => 'https://tiktok.com/@marscollection',
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
        'sneakers' => ['sneakers Kenya', 'casual sneakers', 'everyday trainers'],
        'formal' => ['formal shoes Kenya', 'dress shoes', 'work shoes'],
        'sandals' => ['sandals Kenya', 'comfortable sandals'],
        'boots' => ['boots Kenya', 'ankle boots'],
    ],

    /*
    |--------------------------------------------------------------------------
    | SEO Page Templates
    |--------------------------------------------------------------------------
    */
    'page_templates' => [
        'home' => [
            'title' => 'Mars Collection - Shoes & Footwear in Kenya',
            'description' => 'Shop sneakers, formal shoes, sandals and more at Mars Collection in Kenya.',
            'keywords' => 'shoes Kenya, sneakers, formal shoes, sandals, Mars Collection',
        ],
        'products' => [
            'title' => 'Shop Shoes & Footwear | Mars Collection',
            'description' => 'Shop sneakers, formal shoes, loafers, flats, sandals and boots from Mars Collection.',
            'keywords' => 'shoes, sneakers, loafers, flats, sandals, boots, Mars Collection',
        ],
        'categories' => [
            'title' => 'Shoe Categories | Mars Collection',
            'description' => 'Browse sneakers, formal shoes, loafers, flats, sandals and boots.',
            'keywords' => 'shoe categories, sneakers, formal shoes, loafers, flats, sandals, boots',
        ],
        'brands' => [
            'title' => 'Footwear | Mars Collection',
            'description' => 'Explore footwear styles from Mars Collection.',
            'keywords' => 'Mars Collection footwear, shoes Kenya',
        ],
        'about' => [
            'title' => 'About Mars Collection | Shoes in Kenya',
            'description' => 'Discover Mars Collection, a footwear shop serving customers in Kenya.',
            'keywords' => 'about Mars Collection, shoes Kenya, footwear',
        ],
        'contact' => [
            'title' => 'Contact Us - Mars Collection | Get in Touch',
            'description' => 'Contact Mars Collection about footwear, sizing, orders, and customer support.',
            'keywords' => 'contact Mars Collection, shoe sizing, footwear support, orders',
        ],
    ],
];
