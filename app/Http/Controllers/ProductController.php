<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Services\EmbeddingService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)->with(['category', 'brand']);

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }
        if ($request->filled('brand')) {
            $query->whereHas('brand', fn($q) => $q->where('slug', $request->brand));
        }
        if ($request->has('min_price') && $request->min_price !== '') {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price !== '') {
            $query->where('price', '<=', $request->max_price);
        }
        if ($request->filled('tag')) {
            if ($request->tag === 'featured')  $query->where('is_featured', true);
            if ($request->tag === 'trending')  $query->where('is_trending', true);
        }
        if ($request->filled('search')) {
            $query->where(fn($q) => $q->where('name', 'like', '%'.$request->search.'%')
                                      ->orWhere('description', 'like', '%'.$request->search.'%'));
        }

        $products   = $query->orderByDesc('created_at')->orderByDesc('id')->paginate(50);
        $categories = Category::where('is_active', true)->get();
        $brands     = Brand::where('is_active', true)->get();
        $selectedCategory = $request->filled('category')
            ? $categories->firstWhere('slug', $request->category)
            : null;
        $selectedBrand = $request->filled('brand')
            ? $brands->firstWhere('slug', $request->brand)
            : null;

        return view('products.index', compact('products', 'categories', 'brands', 'selectedCategory', 'selectedBrand'));
    }

    public function show(Request $request, Product $product)
    {
        if (!$product->is_active) abort(404);

        $product->load(['category', 'brand', 'reviews.order']);

        // Track this product view in session (keep last 20, most recent first).
        // Re-visiting a product bumps it to the front so recency weighting works correctly.
        $viewed = $request->session()->get('viewed_products', []);
        $viewed = array_values(array_filter($viewed, fn($id) => $id !== $product->id));
        array_unshift($viewed, $product->id);
        $viewed = array_slice($viewed, 0, 20);
        $request->session()->put('viewed_products', $viewed);

        // "You may also like" is cached per product for 30 min, embedding-based with category fallback.
        $similarProducts = cache()->remember('similar_products_' . $product->id, now()->addMinutes(30), function () use ($product) {
            $results = app(EmbeddingService::class)->getSimilarProducts($product, 6);
            if ($results->isEmpty()) {
                $results = Product::where('category_id', $product->category_id)
                    ->where('id', '!=', $product->id)
                    ->where('is_active', true)
                    ->with(['category', 'brand'])
                    ->limit(6)->get();
            }
            return $results;
        });

        return view('products.show', compact('product', 'similarProducts'));
    }

    public function trending()
    {
        return redirect()->route('products.index', ['tag' => 'trending']);
    }

    public function featured()
    {
        return redirect()->route('products.index', ['tag' => 'featured']);
    }
}
