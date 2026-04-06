<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)->with(['category', 'brand']);

        // Filter by category slug
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        // Filter by brand slug
        if ($request->filled('brand')) {
            $query->whereHas('brand', fn($q) => $q->where('slug', $request->brand));
        }

        // Filter by price range
        if ($request->has('min_price') && $request->min_price !== '' && $request->min_price !== null) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price !== '' && $request->max_price !== null) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by tag (featured, trending, etc.)
        if ($request->has('tag') && $request->tag !== '' && $request->tag !== null) {
            if ($request->tag === 'featured') {
                $query->where('is_featured', true);
            } elseif ($request->tag === 'trending') {
                $query->where('is_trending', true);
            }
        }

        // Search functionality
        if ($request->has('search') && $request->search !== '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $products = $query->paginate(24);
        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();

        return view('products.index', compact('products', 'categories', 'brands'));
    }

    public function show(Product $product)
    {
        // Check if product is active
        if (!$product->is_active) {
            abort(404);
        }

        $product->load(['category', 'brand', 'reviews.order']);
        
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->with(['category', 'brand'])
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
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