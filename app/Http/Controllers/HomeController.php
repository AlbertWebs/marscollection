<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Brand;
use App\Models\Bundle;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    public function index()
    {
        $trendingProducts = Product::where('is_trending', true)->limit(5)->get();
        $featuredProducts = Product::where('is_featured', true)->limit(10)->get();

        return view('home', compact('trendingProducts', 'featuredProducts'));
    }

    public function about()
    {
        return view('about');
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
        $content = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Static pages
        $staticPages = [
            ['url' => route('home'), 'priority' => '1.0', 'changefreq' => 'daily'],
            ['url' => route('about'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => route('contact'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => route('products.index'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['url' => route('categories.index'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => route('brands.index'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => route('bundles.index'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => route('appointments.create'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => route('privacy-policy'), 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['url' => route('terms-of-service'), 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['url' => route('shipping-info'), 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['url' => route('returns-policy'), 'priority' => '0.5', 'changefreq' => 'monthly'],
        ];

        foreach ($staticPages as $page) {
            $content .= '  <url>' . "\n";
            $content .= '    <loc>' . $page['url'] . '</loc>' . "\n";
            $content .= '    <lastmod>' . now()->toISOString() . '</lastmod>' . "\n";
            $content .= '    <changefreq>' . $page['changefreq'] . '</changefreq>' . "\n";
            $content .= '    <priority>' . $page['priority'] . '</priority>' . "\n";
            $content .= '  </url>' . "\n";
        }

        // Products
        $products = Product::where('is_active', true)->get();
        foreach ($products as $product) {
            $content .= '  <url>' . "\n";
            $content .= '    <loc>' . route('products.show', $product) . '</loc>' . "\n";
            $content .= '    <lastmod>' . $product->updated_at->toISOString() . '</lastmod>' . "\n";
            $content .= '    <changefreq>weekly</changefreq>' . "\n";
            $content .= '    <priority>0.8</priority>' . "\n";
            $content .= '  </url>' . "\n";
        }

        // Categories
        $categories = Category::where('is_active', true)->get();
        foreach ($categories as $category) {
            $content .= '  <url>' . "\n";
            $content .= '    <loc>' . route('categories.show', $category) . '</loc>' . "\n";
            $content .= '    <lastmod>' . $category->updated_at->toISOString() . '</lastmod>' . "\n";
            $content .= '    <changefreq>weekly</changefreq>' . "\n";
            $content .= '    <priority>0.7</priority>' . "\n";
            $content .= '  </url>' . "\n";
        }

        // Brands
        $brands = Brand::where('is_active', true)->get();
        foreach ($brands as $brand) {
            $content .= '  <url>' . "\n";
            $content .= '    <loc>' . route('brands.show', $brand) . '</loc>' . "\n";
            $content .= '    <lastmod>' . $brand->updated_at->toISOString() . '</lastmod>' . "\n";
            $content .= '    <changefreq>weekly</changefreq>' . "\n";
            $content .= '    <priority>0.7</priority>' . "\n";
            $content .= '  </url>' . "\n";
        }

        // Bundles
        $bundles = Bundle::where('is_active', true)->get();
        foreach ($bundles as $bundle) {
            $content .= '  <url>' . "\n";
            $content .= '    <loc>' . route('bundles.show', $bundle) . '</loc>' . "\n";
            $content .= '    <lastmod>' . $bundle->updated_at->toISOString() . '</lastmod>' . "\n";
            $content .= '    <changefreq>weekly</changefreq>' . "\n";
            $content .= '    <priority>0.8</priority>' . "\n";
            $content .= '  </url>' . "\n";
        }

        $content .= '</urlset>';

        return response($content, 200, [
            'Content-Type' => 'application/xml',
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
