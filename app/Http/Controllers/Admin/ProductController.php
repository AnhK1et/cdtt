<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                abort(403);
            }
            return $next($request);
        });
    }

    public function index()
    {
        $products = Product::with('category')->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'specifications' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:5120',
            'brand' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'storage' => 'nullable|integer',
            'ram' => 'nullable|integer',
            'screen_size' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('products/banners', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được tạo thành công');
    }

    public function show($id)
    {
        $product = Product::with('category', 'orderItems')->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'specifications' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:5120',
            'brand' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'storage' => 'nullable|integer',
            'ram' => 'nullable|integer',
            'screen_size' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $product = Product::findOrFail($id);
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        
        if ($request->hasFile('image')) {
            if ($product->image) {
                \Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        if ($request->hasFile('banner')) {
            if ($product->banner) {
                \Storage::disk('public')->delete($product->banner);
            }
            $data['banner'] = $request->file('banner')->store('products/banners', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được cập nhật');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->orderItems()->count() > 0) {
            return back()->with('error', 'Không thể xóa sản phẩm đã có đơn hàng');
        }

        if ($product->image) {
            \Storage::disk('public')->delete($product->image);
        }

        if ($product->banner) {
            \Storage::disk('public')->delete($product->banner);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được xóa');
    }
}
