@extends('layouts.app')

@section('title', 'Sản phẩm')

@section('content')
<div class="container">
    @if($currentCategory && $currentCategory->banner)
    <div class="category-banner">
        <img src="{{ asset('storage/' . $currentCategory->banner) }}" alt="{{ $currentCategory->name }}">
        <div class="banner-overlay">
            <h1>{{ $currentCategory->name }}</h1>
            @if($currentCategory->description)
                <p>{{ $currentCategory->description }}</p>
            @endif
        </div>
    </div>
    @else
    <h1>Sản phẩm</h1>
    @endif

    <div class="products-page">
        <aside class="filters">
            <h3>Lọc sản phẩm</h3>
            <form method="GET" action="{{ route('products.index') }}">
                <div class="form-group">
                    <label>Danh mục:</label>
                    <select name="category" class="form-control">
                        <option value="">Tất cả</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Sắp xếp:</label>
                    <select name="sort" class="form-control">
                        <option value="">Mặc định</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Tên A-Z</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tìm kiếm:</label>
                    <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Tên sản phẩm...">
                </div>
                <button type="submit" class="btn btn-primary">Lọc</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Xóa bộ lọc</a>
            </form>
        </aside>

        <div class="products-list">
            @if($products->count() > 0)
                <div class="product-grid">
                    @foreach($products as $product)
                    <div class="product-card">
                        @if($product->sale_price)
                            <div class="product-badge">Giảm {{ $product->discount_percent }}%</div>
                        @endif
                        <a href="{{ route('products.show', $product->slug) }}">
                            @if($product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                            @else
                                <div class="product-placeholder">📱</div>
                            @endif
                            <div class="product-info">
                                <h3>{{ $product->name }}</h3>
                                <p class="product-category">{{ $product->category->name }}</p>
                                <div class="product-price">
                                    @if($product->sale_price)
                                        <span class="price-old">{{ number_format($product->price) }}đ</span>
                                        <span class="price-new">{{ number_format($product->sale_price) }}đ</span>
                                    @else
                                        <span class="price-new">{{ number_format($product->price) }}đ</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                <div class="pagination">
                    {{ $products->links() }}
                </div>
            @else
                <p>Không tìm thấy sản phẩm nào.</p>
            @endif
        </div>
    </div>
</div>
@endsection

