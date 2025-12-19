@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
<div class="homepage-layout">
    <div class="container">
        <div class="homepage-content">
            <!-- Left Sidebar -->
            <aside class="categories-sidebar">
                <h3 class="sidebar-title">DANH MỤC SẢN PHẨM</h3>
                <ul class="sidebar-categories">
                    @php
                        $sidebarCategories = \App\Models\Category::where('is_active', true)->take(8)->get();
                    @endphp
                    @foreach($sidebarCategories as $category)
                    <li>
                        <a href="{{ route('products.index', ['category' => $category->id]) }}">
                            @if($category->image_url)
                                <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="category-icon-img">
                            @else
                                <span class="category-icon">📱</span>
                            @endif
                            <span>{{ $category->name }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </aside>

            <!-- Main Content -->
            <div class="homepage-main">
                <!-- Hero Banner -->
                <div class="hero-banner">
                    <div class="hero-content">
                        <div class="hero-left">
                            <h2 class="hero-title">iPhone 17 PRO</h2>
                            <p class="hero-subtitle">Bù thật ít. Đổi thật nhanh.</p>
                            <div class="hero-installment">
                                <div class="installment-item">
                                    <span class="installment-label">Trả góp</span>
                                    <span class="installment-value">Đến 7 Triệu</span>
                                </div>
                                <div class="installment-item">
                                    <span class="installment-label">Giá</span>
                                    <span class="installment-value">30.99 Triệu</span>
                                </div>
                                <div class="installment-item">
                                    <span class="installment-label">Thời hạn</span>
                                    <span class="installment-value">12 Tháng</span>
                                </div>
                            </div>
                            <a href="{{ route('products.index') }}" class="btn-hero-buy">Xem thêm</a>
                        </div>
                        <div class="hero-right">
                            <div class="hero-image-placeholder">📱</div>
                        </div>
                    </div>
                    <div class="hero-dots">
                        <span class="dot active"></span>
                        <span class="dot"></span>
                        <span class="dot"></span>
                    </div>
                </div>

                <!-- Flash Sale Section -->
                <div class="flash-sale-section">
                    <div class="flash-sale-header">
                        <div class="flash-sale-badge">FLASH SALE</div>
                        <div class="flash-sale-title">
                            <h3>SẮP MỞ BÁN LỘC CHƯA CÓ LỊCH</h3>
                            <h4>BLACK FIRE DAY</h4>
                        </div>
                        <div class="flash-sale-action">
                            <p>Chọn Game Trúng Lớn</p>
                            <a href="#" class="btn-flash-register">Đăng ký ngay</a>
                        </div>
                    </div>
                    <div class="flash-sale-countdown">
                        <span class="countdown-label">BẮT ĐẦU SAU:</span>
                        <div class="countdown-boxes">
                            <div class="countdown-box">--</div>
                            <div class="countdown-box">--</div>
                            <div class="countdown-box">--</div>
                            <div class="countdown-box">--</div>
                        </div>
                    </div>
                    <div class="flash-sale-message">
                        <p>Chưa có chương trình Flash Sale nào đang diễn ra.</p>
                        <small>Chỉ áp dụng thanh toán online thành công...</small>
                    </div>
                </div>

                <!-- Product Categories Icons -->
                @if($categories->count() > 0)
                <section class="category-icons-section">
                    <div class="section-header">
                        <h2>Danh mục sản phẩm</h2>
                        <a href="{{ route('products.index') }}" class="view-all-link">Xem tất cả</a>
                    </div>
                    <div class="category-icons-grid">
                        @foreach($categories->take(8) as $category)
                        <a href="{{ route('products.index', ['category' => $category->id]) }}" class="category-icon-item">
                            <div class="category-icon-circle">
                                @if($category->image_url)
                                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}">
                                @else
                                    <span>📱</span>
                                @endif
                            </div>
                            <span>{{ $category->name }}</span>
                        </a>
                        @endforeach
                    </div>
                </section>
                @endif

                <!-- Featured Products -->
                @if($featuredProducts->count() > 0)
                <section class="featured-products-section">
                    <div class="section-header">
                        <h2>Sản phẩm nổi bật</h2>
                        <a href="{{ route('products.index') }}" class="view-all-link">Xem tất cả</a>
                    </div>
                    <div class="product-grid-homepage">
                        @foreach($featuredProducts->take(8) as $product)
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
                                    <div class="product-price">
                                        @if($product->sale_price)
                                            <span class="price-old">{{ number_format($product->price) }}₫</span>
                                            <span class="price-new">{{ number_format($product->sale_price) }}₫</span>
                                        @else
                                            <span class="price-new">{{ number_format($product->price) }}₫</span>
                                        @endif
                                    </div>
                                    <div class="product-rating">
                                        <span class="stars">★★★★★</span>
                                        <span class="rating-count">(324)</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </section>
                @endif

                <!-- Latest Products -->
                @if($latestProducts->count() > 0)
                <section class="latest-products-section">
                    <div class="section-header">
                        <h2>Sản phẩm mới nhất</h2>
                        <a href="{{ route('products.index') }}" class="view-all-link">Xem tất cả</a>
                    </div>
                    <div class="product-grid-homepage">
                        @foreach($latestProducts->take(12) as $product)
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
                                    <div class="product-price">
                                        @if($product->sale_price)
                                            <span class="price-old">{{ number_format($product->price) }}₫</span>
                                            <span class="price-new">{{ number_format($product->sale_price) }}₫</span>
                                        @else
                                            <span class="price-new">{{ number_format($product->price) }}₫</span>
                                        @endif
                                    </div>
                                    <div class="product-rating">
                                        <span class="stars">★★★★★</span>
                                        <span class="rating-count">(324)</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </section>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

