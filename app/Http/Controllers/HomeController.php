<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->take(8)
            ->get();
        
        $latestProducts = Product::where('is_active', true)
            ->latest()
            ->take(12)
            ->get();
        
        $categories = Category::where('is_active', true)->get();

        return view('home', compact('featuredProducts', 'latestProducts', 'categories'));
    }
}
