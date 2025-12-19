@extends('layouts.admin')

@section('title', 'Sửa danh mục')
@section('page-title', 'Sửa danh mục')

@section('content')
<form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label>Tên danh mục *</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
    </div>
    <div class="form-group">
        <label>Mô tả</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
    </div>
    <div class="form-group">
        <label>Hình ảnh</label>
        @if($category->image_url)
            <div>
                <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="admin-thumbnail">
            </div>
        @endif
        <input type="file" name="image" class="form-control" accept="image/*">
        <small class="form-text text-muted">Ảnh đại diện cho danh mục (khuyến nghị: 300x300px)</small>
    </div>
    <div class="form-group">
        <label>Banner</label>
        @if($category->banner)
            <div>
                <img src="{{ asset('storage/' . $category->banner) }}" alt="{{ $category->name }} Banner" class="admin-thumbnail" style="max-width: 400px; height: auto;">
            </div>
        @endif
        <input type="file" name="banner" class="form-control" accept="image/*">
        <small class="form-text text-muted">Banner hiển thị trên trang danh mục (khuyến nghị: 1200x400px)</small>
    </div>
    <div class="form-group">
        <label>
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
            Kích hoạt
        </label>
    </div>
    <button type="submit" class="btn btn-primary">Cập nhật</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Hủy</a>
</form>
@endsection

