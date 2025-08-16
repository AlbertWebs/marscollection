<?php

namespace App\Helpers;

class SeoHelper
{
    /**
     * Generate SEO-friendly title
     */
    public static function generateTitle($title, $brand = null, $category = null)
    {
        $parts = [$title];
        
        if ($brand) {
            $parts[] = $brand;
        }
        
        $parts[] = 'Zayn\'s Beauty';
        
        return implode(' - ', $parts);
    }

    /**
     * Generate SEO-friendly description
     */
    public static function generateDescription($description, $productName = null, $brand = null, $category = null)
    {
        if ($description) {
            return $description;
        }

        $parts = [];
        
        if ($productName) {
            $parts[] = $productName;
        }
        
        if ($brand) {
            $parts[] = "from {$brand}";
        }
        
        $parts[] = 'Premium beauty product';
        
        if ($category) {
            $parts[] = "in {$category} category";
        }
        
        $parts[] = 'Shop now for the best price and quality.';
        
        return implode(' - ', $parts);
    }

    /**
     * Generate SEO-friendly keywords
     */
    public static function generateKeywords($keywords, $productName = null, $brand = null, $category = null)
    {
        $keywordArray = [];
        
        if ($keywords) {
            $keywordArray = array_merge($keywordArray, explode(',', $keywords));
        }
        
        if ($productName) {
            $keywordArray[] = $productName;
        }
        
        if ($category) {
            $keywordArray[] = $category;
        }
        
        if ($brand) {
            $keywordArray[] = $brand;
        }
        
        // Add default beauty keywords
        $defaultKeywords = [
            'beauty products',
            'premium beauty',
            'skincare',
            'makeup',
            'beauty accessories',
            'Zayn\'s Beauty'
        ];
        
        $keywordArray = array_merge($keywordArray, $defaultKeywords);
        
        return implode(', ', array_unique($keywordArray));
    }

    /**
     * Generate product schema markup
     */
    public static function generateProductSchema($product)
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product->name,
            'description' => self::generateDescription($product->description, $product->name, $product->brand->name ?? null, $product->category->name ?? null),
            'image' => ImageHelper::getProductImageUrl($product->image),
            'url' => route('products.show', $product),
            'sku' => (string) $product->id,
            'mpn' => (string) $product->id,
            'brand' => [
                '@type' => 'Brand',
                'name' => $product->brand->name ?? 'Zayn\'s Beauty'
            ],
            'category' => $product->category->name ?? 'Beauty Products',
            'offers' => [
                '@type' => 'Offer',
                'price' => (string) $product->price,
                'priceCurrency' => 'KES',
                'priceValidUntil' => now()->addYear()->toISOString(),
                'availability' => $product->stock_quantity > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                'url' => route('products.show', $product),
                'seller' => [
                    '@type' => 'Organization',
                    'name' => 'Zayn\'s Beauty'
                ]
            ]
        ];

        // Add aggregate rating if reviews exist
        if ($product->reviews_count > 0) {
            $schema['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => (string) $product->average_rating,
                'reviewCount' => (string) $product->reviews_count,
                'bestRating' => '5',
                'worstRating' => '1'
            ];
        }

        return $schema;
    }

    /**
     * Generate breadcrumb schema markup
     */
    public static function generateBreadcrumbSchema($breadcrumbs)
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => []
        ];

        foreach ($breadcrumbs as $index => $breadcrumb) {
            $schema['itemListElement'][] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $breadcrumb['name'],
                'item' => $breadcrumb['url']
            ];
        }

        return $schema;
    }

    /**
     * Generate organization schema markup
     */
    public static function generateOrganizationSchema()
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'Zayn\'s Beauty',
            'url' => url('/'),
            'logo' => asset('images/logo.png'),
            'description' => 'Premium beauty products and professional beauty services',
            'address' => [
                '@type' => 'PostalAddress',
                'addressCountry' => 'KE',
                'addressLocality' => 'Nairobi',
                'addressRegion' => 'Nairobi'
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'customer service',
                'email' => 'info@zaynsbeauty.com'
            ],
            'sameAs' => [
                // Add your social media URLs here
                // 'https://facebook.com/zaynsbeauty',
                // 'https://instagram.com/zaynsbeauty',
                // 'https://twitter.com/zaynsbeauty'
            ]
        ];
    }

    /**
     * Generate website schema markup
     */
    public static function generateWebsiteSchema()
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => 'Zayn\'s Beauty',
            'url' => url('/'),
            'description' => 'Premium beauty products and professional beauty services in Kenya',
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => route('products.index') . '?search={search_term_string}',
                'query-input' => 'required name=search_term_string'
            ]
        ];
    }

    /**
     * Generate local business schema markup
     */
    public static function generateLocalBusinessSchema()
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BeautySalon',
            'name' => 'Zayn\'s Beauty',
            'description' => 'Premium beauty products and professional beauty services',
            'url' => url('/'),
            'logo' => asset('images/logo.png'),
            'image' => asset('images/og-image.jpg'),
            'telephone' => '+254-XXX-XXX-XXX',
            'email' => 'info@zaynsbeauty.com',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => '',
                'addressLocality' => 'Nairobi',
                'addressRegion' => 'Nairobi',
                'postalCode' => '',
                'addressCountry' => 'KE'
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => '',
                'longitude' => ''
            ],
            'openingHours' => 'Mo-Fr 09:00-18:00',
            'priceRange' => '$$',
            'sameAs' => [
                // Add your social media URLs here
            ]
        ];
    }

    /**
     * Generate FAQ schema markup
     */
    public static function generateFaqSchema($faqs)
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => []
        ];

        foreach ($faqs as $faq) {
            $schema['mainEntity'][] = [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer']
                ]
            ];
        }

        return $schema;
    }

    /**
     * Generate review schema markup
     */
    public static function generateReviewSchema($review)
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Review',
            'author' => [
                '@type' => 'Person',
                'name' => $review->order->customer_name
            ],
            'reviewRating' => [
                '@type' => 'Rating',
                'ratingValue' => (string) $review->rating,
                'bestRating' => '5'
            ],
            'reviewBody' => $review->comment ?? 'Great product!',
            'datePublished' => $review->created_at->toISOString()
        ];
    }

    /**
     * Clean and format text for SEO
     */
    public static function cleanText($text, $maxLength = 160)
    {
        $text = strip_tags($text);
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);
        
        if (strlen($text) > $maxLength) {
            $text = substr($text, 0, $maxLength - 3) . '...';
        }
        
        return $text;
    }

    /**
     * Generate canonical URL
     */
    public static function generateCanonicalUrl($url = null)
    {
        if ($url) {
            return $url;
        }
        
        return request()->url();
    }

    /**
     * Generate Open Graph data
     */
    public static function generateOpenGraphData($title, $description, $image = null, $type = 'website', $url = null)
    {
        return [
            'og:type' => $type,
            'og:url' => $url ?? request()->url(),
            'og:title' => $title,
            'og:description' => $description,
            'og:image' => $image ?? asset('images/og-image.jpg'),
            'og:image:width' => '1200',
            'og:image:height' => '630',
            'og:site_name' => 'Zayn\'s Beauty',
            'og:locale' => 'en_US'
        ];
    }

    /**
     * Generate Twitter Card data
     */
    public static function generateTwitterCardData($title, $description, $image = null, $url = null)
    {
        return [
            'twitter:card' => 'summary_large_image',
            'twitter:url' => $url ?? request()->url(),
            'twitter:title' => $title,
            'twitter:description' => $description,
            'twitter:image' => $image ?? asset('images/og-image.jpg')
        ];
    }
}
