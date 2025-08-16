<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::where('is_active', true)->get();
        return view('brands.index', compact('brands'));
    }

    public function show(Brand $brand)
    {
        $products = $brand->products()->paginate(12);
        return view('brands.show', compact('brand', 'products'));
    }
} 