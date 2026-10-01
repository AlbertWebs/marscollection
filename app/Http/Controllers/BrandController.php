<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::where('is_active', true)
            ->withCount(['products' => fn ($query) => $query->where('is_active', true)])
            ->whereHas('products', fn ($query) => $query->where('is_active', true))
            ->orderBy('name')
            ->get();
        return view('brands.index', compact('brands'));
    }

    public function show(Brand $brand)
    {
        abort_unless($brand->is_active, 404);

        $products = Product::where('is_active', true)
            ->where('brand_id', $brand->id)
            ->with(['category', 'brand'])
            ->orderBy('name')
            ->paginate(50)
            ->withQueryString();
        $categories = Category::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();
        $brands = Brand::where('is_active', true)->orderBy('name')->get();
        $selectedCategory = null;
        $selectedBrand = $brand;

        return view('products.index', compact('products', 'categories', 'brands', 'selectedCategory', 'selectedBrand'));
    }
}
