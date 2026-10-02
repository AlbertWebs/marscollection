<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Contact;
use App\Models\Brand;
use App\Models\Bundle;
use App\Models\Category;
use App\Models\Setting;
use App\Models\NewsletterSubscriber;
use App\Services\EmbeddingService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')->orderBy('name')->limit(6)->get();
        $trendingProducts = Product::where('is_active', true)->where('is_trending', true)->latest()->limit(5)->get();
        $featuredProducts = Product::where('is_active', true)->where('is_featured', true)->latest()->limit(10)->get();
        $homeContent = Setting::where('group', 'homepage')->pluck('value', 'key');
        return view('home', compact('categories', 'trendingProducts', 'featuredProducts', 'homeContent'));
    }

    public function about()
    {
        $categories = Category::where('is_active', true)
            ->withCount(['products' => fn ($query) => $query->where('is_active', true)])
            ->whereHas('products', fn ($query) => $query->where('is_active', true))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
        $brandDetails = [
            'phone' => Setting::get('contact_phone_primary', '0726243706'),
            'email' => Setting::get('contact_email_primary', 'info@marscollection.co.ke'),
            'facebook' => Setting::get('social_facebook', ''),
            'instagram' => Setting::get('social_instagram', ''),
            'twitter' => Setting::get('social_twitter', ''),
        ];

        return view('about', compact('categories', 'brandDetails'));
    }

    public function contact()
    {
        $faqs = config('faqs', []);
        return view('contact', compact('faqs'));
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
            'website' => 'nullable|string|max:255', // Hidden honeypot field
            'company' => 'nullable|string|max:255', // Hidden honeypot field
        ]);

        // Check for honeypot fields - if filled, it's likely a bot
        $isBot = !empty($request->website) || !empty($request->company);
        
        // Only store legitimate messages (not from bots)
        if (!$isBot) {
            Contact::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'is_bot' => false,
                'website' => $request->website,
                'company' => $request->company,
            ]);
        }
        
        // Always show success message to avoid revealing honeypot detection
        return redirect()->route('contact')->with('success', 'Thank you for your message! We\'ll get back to you soon.');
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        
        // Redirect to products page with search parameter
        return redirect()->route('products.index', ['search' => $query]);
    }

    public function subscribeNewsletter(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $subscriber = NewsletterSubscriber::where('email', $validated['email'])->first();

        if ($subscriber) {
            $subscriber->update([
                'is_active' => true,
                'source' => 'website',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'subscribed_at' => now(),
                'unsubscribed_at' => null,
            ]);
        } else {
            NewsletterSubscriber::create([
                'email' => $validated['email'],
                'source' => 'website',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'is_active' => true,
                'subscribed_at' => now(),
            ]);
        }

        return back()->with('newsletter_success', 'You have been subscribed successfully.');
    }

    public function sitemap()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" '
              . 'xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" '
              . 'xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";

        // Helper to format XML url entry
        $formatUrl = function($loc, $lastmod = null, $changefreq = 'weekly', $priority = '0.8', $images = []) {
            $entry = "  <url>\n";
            $entry .= "    <loc>" . htmlspecialchars($loc, ENT_XML1, 'UTF-8') . "</loc>\n";
            $entry .= "    <lastmod>" . ($lastmod ? $lastmod->toW3cString() : now()->toW3cString()) . "</lastmod>\n";
            $entry .= "    <changefreq>{$changefreq}</changefreq>\n";
            $entry .= "    <priority>{$priority}</priority>\n";
            
            foreach ($images as $img) {
                if (!empty($img['loc'])) {
                    $entry .= "    <image:image>\n";
                    $entry .= "      <image:loc>" . htmlspecialchars($img['loc'], ENT_XML1, 'UTF-8') . "</image:loc>\n";
                    if (!empty($img['title'])) {
                        $entry .= "      <image:title>" . htmlspecialchars($img['title'], ENT_XML1, 'UTF-8') . "</image:title>\n";
                    }
                    if (!empty($img['caption'])) {
                        $entry .= "      <image:caption>" . htmlspecialchars($img['caption'], ENT_XML1, 'UTF-8') . "</image:caption>\n";
                    }
                    $entry .= "    </image:image>\n";
                }
            }
            $entry .= "  </url>\n";
            return $entry;
        };

        $categories = Category::where('is_active', true)
            ->whereHas('products', fn ($query) => $query->where('is_active', true))
            ->get();
        $brands = Brand::where('is_active', true)
            ->whereHas('products', fn ($query) => $query->where('is_active', true))
            ->get();
        $bundles = Bundle::where('is_active', true)->get();

        // 1. High-Priority Static & Core Pages
        $staticPages = [
            ['url' => route('home'), 'priority' => '1.0', 'changefreq' => 'daily'],
            ['url' => route('about'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => route('contact'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => route('shipping-info'), 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['url' => route('returns-policy'), 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['url' => route('privacy-policy'), 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['url' => route('terms-of-service'), 'priority' => '0.3', 'changefreq' => 'yearly'],
        ];
        if (Product::where('is_active', true)->exists()) {
            $staticPages[] = ['url' => route('products.index'), 'priority' => '0.9', 'changefreq' => 'daily'];
        }
        if ($categories->isNotEmpty()) {
            $staticPages[] = ['url' => route('categories.index'), 'priority' => '0.85', 'changefreq' => 'daily'];
        }
        if ($brands->isNotEmpty()) {
            $staticPages[] = ['url' => route('brands.index'), 'priority' => '0.8', 'changefreq' => 'weekly'];
        }
        if ($bundles->isNotEmpty()) {
            $staticPages[] = ['url' => route('bundles.index'), 'priority' => '0.85', 'changefreq' => 'weekly'];
        }
        if (Bundle::where('is_active', true)->where('is_featured', true)->exists()) {
            $staticPages[] = ['url' => route('bundles.featured'), 'priority' => '0.8', 'changefreq' => 'weekly'];
        }
        if (Bundle::where('is_active', true)->where('is_trending', true)->exists()) {
            $staticPages[] = ['url' => route('bundles.trending'), 'priority' => '0.8', 'changefreq' => 'weekly'];
        }

        foreach ($staticPages as $page) {
            $xml .= $formatUrl($page['url'], null, $page['changefreq'], $page['priority']);
        }

        // 2. Active Categories
        foreach ($categories as $category) {
            $catImages = [];
            if ($category->image) {
                $catImages[] = [
                    'loc'   => \App\Helpers\ImageHelper::getProductImageUrl($category->image),
                    'title' => $category->name . ' - Mars Collection Nairobi',
                ];
            }
            $xml .= $formatUrl(
                route('categories.show', $category),
                $category->updated_at,
                'weekly',
                '0.85',
                $catImages
            );
        }

        // 3. Active Products with Google Images Schema
        $products = Product::where('is_active', true)->with(['category', 'brand'])->get();
        foreach ($products as $product) {
            $images = [];
            $imgUrl = \App\Helpers\ImageHelper::getProductImageUrl($product->image);
            if ($imgUrl) {
                $images[] = [
                    'loc'     => $imgUrl,
                    'title'   => $product->name . ' - Mars Collection Kenya',
                    'caption' => Str::limit($product->description ?? $product->name, 120),
                ];
            }

            $priority = ($product->is_featured || $product->is_trending) ? '0.9' : '0.8';
            $xml .= $formatUrl(
                route('products.show', $product),
                $product->updated_at,
                'daily',
                $priority,
                $images
            );
        }

        // 4. Active Brands
        foreach ($brands as $brand) {
            $brandImages = [];
            if ($brand->logo) {
                $brandImages[] = [
                    'loc'   => \App\Helpers\ImageHelper::getProductImageUrl($brand->logo),
                    'title' => $brand->name . ' at Mars Collection',
                ];
            }
            $xml .= $formatUrl(
                route('brands.show', $brand),
                $brand->updated_at,
                'weekly',
                '0.8',
                $brandImages
            );
        }

        // 5. Active Bundles
        foreach ($bundles as $bundle) {
            $bundleImages = [];
            $imgUrl = \App\Helpers\ImageHelper::getProductImageUrl($bundle->image);
            if ($imgUrl) {
                $bundleImages[] = [
                    'loc'     => $imgUrl,
                    'title'   => $bundle->name . ' - Mars Collection Bundle',
                    'caption' => $bundle->name,
                ];
            }
            $xml .= $formatUrl(
                route('bundles.show', $bundle),
                $bundle->updated_at,
                'weekly',
                '0.85',
                $bundleImages
            );
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type'  => 'application/xml; charset=utf-8',
            'Cache-Control' => 'public, max-age=3600'
        ]);
    }

    public function privacyPolicy()
    {
        return view('policies.privacy-policy');
    }

    public function termsOfService()
    {
        return view('policies.terms-of-service');
    }

    public function shippingInfo()
    {
        return view('policies.shipping-info');
    }

    public function returnsPolicy()
    {
        return view('policies.returns-policy');
    }
} 
