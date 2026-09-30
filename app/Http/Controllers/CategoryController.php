<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Setting;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->withCount(['products' => fn ($query) => $query->where('is_active', true)])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
        $homeContent = Setting::where('group', 'homepage')->pluck('value', 'key');
        return view('categories.index', compact('categories', 'homeContent'));
    }

    public function show(Category $category)
    {
        return redirect()->route('products.index', ['category' => $category->slug]);
    }
}
