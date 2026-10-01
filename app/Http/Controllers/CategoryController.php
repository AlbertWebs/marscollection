<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Setting;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->withCount(['products' => fn ($query) => $query->where('is_active', true)])
            ->whereHas('products', fn ($query) => $query->where('is_active', true))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
        $homeContent = Setting::where('group', 'homepage')->pluck('value', 'key');
        return view('categories.index', compact('categories', 'homeContent'));
    }

    public function show(Category $category)
    {
        abort_unless($category->is_active, 404);

        $products = Product::where('is_active', true)
            ->where('category_id', $category->id)
            ->with(['category', 'brand'])
            ->orderByDesc('is_featured')
            ->orderBy('name')
            ->paginate(50)
            ->withQueryString();
        $categories = Category::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();
        $brands = Brand::where('is_active', true)->orderBy('name')->get();
        $selectedCategory = $category;
        $selectedBrand = null;

        return view('products.index', compact('products', 'categories', 'brands', 'selectedCategory', 'selectedBrand'));
    }
}
