@extends('layouts.admin')

@section('title', 'Sửa sản phẩm')
@section('page-title', 'Sửa sản phẩm')

@section('content')
<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label>Danh mục *</label>
        <select name="category_id" class="form-control" required>
            <option value="">Chọn danh mục</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Tên sản phẩm *</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
    </div>
    <div class="form-group">
        <label>Mô tả</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
    </div>
    <div class="form-group">
        <label>Thông số kỹ thuật</label>
        <textarea name="specifications" class="form-control" rows="5">{{ old('specifications', $product->specifications) }}</textarea>
    </div>
    <div class="form-row">
        <div class="form-group">
            <label>Giá *</label>
            <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
        </div>
        <div class="form-group">
            <label>Giá khuyến mãi</label>
            <input type="number" name="sale_price" class="form-control" value="{{ old('sale_price', $product->sale_price) }}" step="0.01" min="0">
        </div>
        <div class="form-group">
            <label>Tồn kho *</label>
            <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" min="0" required>
        </div>
    </div>
    <div class="form-group">
        <label>Hình ảnh</label>
        @if($product->image_url)
            <div>
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="admin-thumbnail">
            </div>
        @endif
        <input type="file" name="image" class="form-control" accept="image/*">
        <small class="form-text text-muted">Ảnh đại diện cho sản phẩm (khuyến nghị: 500x500px)</small>
    </div>
    <div class="form-group">
        <label>Banner</label>
        @if($product->banner)
            <div>
                <img src="{{ asset('storage/' . $product->banner) }}" alt="{{ $product->name }} Banner" class="admin-thumbnail" style="max-width: 400px; height: auto;">
            </div>
        @endif
        <input type="file" name="banner" class="form-control" accept="image/*">
        <small class="form-text text-muted">Banner hiển thị trên trang chi tiết sản phẩm (khuyến nghị: 1200x400px)</small>
    </div>
    <div class="form-row">
        <div class="form-group">
            <label>Thương hiệu</label>
            <input type="text" name="brand" class="form-control" value="{{ old('brand', $product->brand) }}">
        </div>
        <div class="form-group">
            <label>Màu sắc</label>
            <input type="text" name="color" class="form-control" value="{{ old('color', $product->color) }}">
        </div>
        <div class="form-group">
            <label>Bộ nhớ (GB)</label>
            <input type="number" name="storage" class="form-control" value="{{ old('storage', $product->storage) }}" min="0">
        </div>
        <div class="form-group">
            <label>RAM (GB)</label>
            <input type="number" name="ram" class="form-control" value="{{ old('ram', $product->ram) }}" min="0">
        </div>
        <div class="form-group">
            <label>Kích thước màn hình</label>
            <input type="text" name="screen_size" class="form-control" value="{{ old('screen_size', $product->screen_size) }}">
        </div>
    </div>
    <div class="form-group">
        <label>
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
            Kích hoạt
        </label>
    </div>
    <div class="form-group">
        <label>
            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
            Sản phẩm nổi bật
        </label>
    </div>
    <button type="submit" class="btn btn-primary">Cập nhật</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy</a>
</form>
@endsection

