<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use Illuminate\Http\Request;

class BundleController extends Controller
{
    public function index()
    {
        $bundles = Bundle::where('is_active', true)
            ->with('products')
            ->paginate(12);

        return view('bundles.index', compact('bundles'));
    }

    public function featured()
    {
        $bundles = Bundle::where('is_featured', true)
            ->where('is_active', true)
            ->with('products')
            ->get();

        return view('bundles.featured', compact('bundles'));
    }

    public function trending()
    {
        $bundles = Bundle::where('is_trending', true)
            ->where('is_active', true)
            ->with('products')
            ->get();

        return view('bundles.trending', compact('bundles'));
    }

    public function show(Bundle $bundle)
    {
        $bundle->load('products.category', 'products.brand');
        return view('bundles.show', compact('bundle'));
    }
}
