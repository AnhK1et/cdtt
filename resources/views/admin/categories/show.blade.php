@extends('layouts.admin')

@section('title', 'Chi tiết danh mục')
@section('page-title', 'Chi tiết danh mục')

@section('content')
<div class="admin-detail">
    <div class="detail-info">
        <h2>{{ $category->name }}</h2>
        @if($category->image_url)
            <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="detail-image">
        @endif
        <p><strong>Mô tả:</strong> {{ $category->description ?? 'N/A' }}</p>
        <p><strong>Trạng thái:</strong> {{ $category->is_active ? 'Hoạt động' : 'Tắt' }}</p>
        <p><strong>Số sản phẩm:</strong> {{ $category->products()->count() }}</p>
    </div>

    <div class="admin-actions">
        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary">Sửa</a>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
    </div>

    @if($category->products()->count() > 0)
    <div class="related-items">
        <h3>Sản phẩm trong danh mục</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Giá</th>
                    <th>Tồn kho</th>
                </tr>
            </thead>
            <tbody>
                @foreach($category->products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td><a href="{{ route('admin.products.show', $product->id) }}">{{ $product->name }}</a></td>
                    <td>{{ number_format($product->price) }}đ</td>
                    <td>{{ $product->stock }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection

