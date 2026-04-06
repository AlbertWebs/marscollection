<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->get();
        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        return redirect()->route('products.index', ['category' => $category->slug]);
    }
}
