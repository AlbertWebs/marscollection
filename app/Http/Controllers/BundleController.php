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
            ->paginate(50);
        $pageType = 'all';
        return view('bundles.index', compact('bundles', 'pageType'));
    }

    public function featured()
    {
        $bundles = Bundle::where('is_featured', true)
            ->where('is_active', true)
            ->with('products')
            ->paginate(50);
        $pageType = 'featured';
        return view('bundles.index', compact('bundles', 'pageType'));
    }

    public function trending()
    {
        $bundles = Bundle::where('is_trending', true)
            ->where('is_active', true)
            ->with('products')
            ->paginate(50);
        $pageType = 'trending';
        return view('bundles.index', compact('bundles', 'pageType'));
    }

    public function show(Bundle $bundle)
    {
        abort_unless($bundle->is_active, 404);
        $bundle->load('products.category', 'products.brand');
        return view('bundles.show', compact('bundle'));
    }
}
