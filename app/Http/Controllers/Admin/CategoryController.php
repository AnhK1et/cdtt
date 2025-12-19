<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
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
        $categories = Category::latest()->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:5120',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('categories/banners', 'public');
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được tạo thành công');
    }

    public function show($id)
    {
        $category = Category::with('products')->findOrFail($id);
        return view('admin.categories.show', compact('category'));
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:5120',
            'is_active' => 'boolean',
        ]);

        $category = Category::findOrFail($id);
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        
        if ($request->hasFile('image')) {
            if ($category->image) {
                \Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        if ($request->hasFile('banner')) {
            if ($category->banner) {
                \Storage::disk('public')->delete($category->banner);
            }
            $data['banner'] = $request->file('banner')->store('categories/banners', 'public');
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được cập nhật');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Không thể xóa danh mục có sản phẩm');
        }

        if ($category->image) {
            \Storage::disk('public')->delete($category->image);
        }

        if ($category->banner) {
            \Storage::disk('public')->delete($category->banner);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được xóa');
    }
}
