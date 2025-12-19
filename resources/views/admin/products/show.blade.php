@extends('layouts.admin')

@section('title', 'Chi tiết sản phẩm')
@section('page-title', 'Chi tiết sản phẩm')

@section('content')
<div class="admin-detail">
    <div class="detail-info">
        <h2>{{ $product->name }}</h2>
        @if($product->image)
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="detail-image">
        @endif
        <p><strong>Danh mục:</strong> {{ $product->category->name }}</p>
        <p><strong>Giá:</strong> {{ number_format($product->price) }}đ</p>
        @if($product->sale_price)
            <p><strong>Giá khuyến mãi:</strong> {{ number_format($product->sale_price) }}đ</p>
        @endif
        <p><strong>Tồn kho:</strong> {{ $product->stock }}</p>
        <p><strong>Trạng thái:</strong> {{ $product->is_active ? 'Hoạt động' : 'Tắt' }}</p>
        <p><strong>Nổi bật:</strong> {{ $product->is_featured ? 'Có' : 'Không' }}</p>
        @if($product->description)
            <p><strong>Mô tả:</strong> {{ $product->description }}</p>
        @endif
        @if($product->specifications)
            <p><strong>Thông số:</strong></p>
            <div class="specs-content">{{ nl2br(e($product->specifications)) }}</div>
        @endif
    </div>

    <div class="admin-actions">
        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">Sửa</a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
    </div>
</div>
@endsection

