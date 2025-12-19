@extends('layouts.admin')

@section('title', 'Thêm danh mục')
@section('page-title', 'Thêm danh mục mới')

@section('content')
<form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label>Tên danh mục *</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
    </div>
    <div class="form-group">
        <label>Mô tả</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
    </div>
    <div class="form-group">
        <label>Hình ảnh</label>
        <input type="file" name="image" class="form-control" accept="image/*">
        <small class="form-text text-muted">Ảnh đại diện cho danh mục (khuyến nghị: 300x300px)</small>
    </div>
    <div class="form-group">
        <label>Banner</label>
        <input type="file" name="banner" class="form-control" accept="image/*">
        <small class="form-text text-muted">Banner hiển thị trên trang danh mục (khuyến nghị: 1200x400px)</small>
    </div>
    <div class="form-group">
        <label>
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
            Kích hoạt
        </label>
    </div>
    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Hủy</a>
</form>
@endsection

