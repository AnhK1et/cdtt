@extends('layouts.app')

@section('title', $product->name)

@section('content')
@if($product->banner)
<div class="product-banner">
    <img src="{{ asset('storage/' . $product->banner) }}" alt="{{ $product->name }}">
</div>
@endif
<div class="container">
    <div class="product-detail">
        <div class="product-images">
            @if($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="main-image">
            @else
                <div class="product-placeholder large">📱</div>
            @endif
        </div>

        <div class="product-details">
            <div class="product-header">
                <h1>{{ $product->name }}</h1>
                <p class="product-category">Danh mục: <a href="{{ route('products.index', ['category' => $product->category_id]) }}">{{ $product->category->name }}</a></p>
            </div>
            
            <div class="product-price-section">
                @if($product->sale_price)
                    <div class="price-main">
                        <span class="price-new large">{{ number_format($product->sale_price) }}đ</span>
                        <span class="discount-badge">-{{ $product->discount_percent }}%</span>
                    </div>
                    <div class="price-old-wrapper">
                        <span class="price-old">{{ number_format($product->price) }}đ</span>
                    </div>
                @else
                    <div class="price-main">
                        <span class="price-new large">{{ number_format($product->price) }}đ</span>
                    </div>
                @endif
            </div>

            @if($product->description)
            <div class="product-description">
                <h3>Mô tả sản phẩm</h3>
                <p>{{ $product->description }}</p>
            </div>
            @endif

            <div class="product-actions">
                @if($product->stock > 0)
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                    @csrf
                    <div class="quantity-selector">
                        <label>Số lượng:</label>
                        <div class="quantity-controls">
                            <button type="button" class="qty-btn minus" onclick="changeQuantity(-1)">-</button>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control qty-input">
                            <button type="button" class="qty-btn plus" onclick="changeQuantity(1)">+</button>
                        </div>
                        <span class="stock-info">Còn {{ $product->stock }} sản phẩm</span>
                    </div>
                    <button type="submit" class="btn btn-primary btn-large btn-buy">
                        🛒 Thêm vào giỏ hàng
                    </button>
                </form>
                @else
                <div class="out-of-stock-box">
                    <p class="out-of-stock">⚠️ Hết hàng</p>
                    <p class="stock-notice">Sản phẩm hiện đang hết hàng. Vui lòng quay lại sau!</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Product Specifications Section - Below Image -->
    <div class="product-specs-section">
        <div class="product-specs-container">
            @if($product->specifications)
            <div class="product-specs">
                <h3>Thông số kỹ thuật</h3>
                <div class="specs-content">
                    {!! nl2br(e($product->specifications)) !!}
                </div>
            </div>
            @endif

            <div class="product-meta">
                @if($product->brand)
                    <p><strong>Thương hiệu:</strong> {{ $product->brand }}</p>
                @endif
                @if($product->color)
                    <p><strong>Màu sắc:</strong> {{ $product->color }}</p>
                @endif
                @if($product->storage)
                    <p><strong>Bộ nhớ:</strong> {{ $product->storage }}GB</p>
                @endif
                @if($product->ram)
                    <p><strong>RAM:</strong> {{ $product->ram }}GB</p>
                @endif
                @if($product->screen_size)
                    <p><strong>Màn hình:</strong> {{ $product->screen_size }}</p>
                @endif
                <p><strong>Tồn kho:</strong> {{ $product->stock }} sản phẩm</p>
            </div>
        </div>
    </div>

    @if($relatedProducts->count() > 0)
    <section class="related-products">
        <h2>🔗 Sản phẩm liên quan</h2>
        <div class="product-grid">
            @foreach($relatedProducts as $related)
            <div class="product-card">
                @if($related->sale_price)
                    <div class="product-badge">Giảm {{ $related->discount_percent }}%</div>
                @endif
                <a href="{{ route('products.show', $related->slug) }}">
                    @if($related->image_url)
                        <img src="{{ $related->image_url }}" alt="{{ $related->name }}">
                    @else
                        <div class="product-placeholder">📱</div>
                    @endif
                    <div class="product-info">
                        <h3>{{ $related->name }}</h3>
                        <p class="product-category">{{ $related->category->name }}</p>
                        <div class="product-price">
                            @if($related->sale_price)
                                <span class="price-old">{{ number_format($related->price) }}đ</span>
                                <span class="price-new">{{ number_format($related->sale_price) }}đ</span>
                            @else
                                <span class="price-new">{{ number_format($related->price) }}đ</span>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </section>
    @endif

@push('scripts')
<script>
function changeQuantity(change) {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value);
    const max = parseInt(input.max);
    const min = parseInt(input.min);
    const newValue = currentValue + change;
    
    if (newValue >= min && newValue <= max) {
        input.value = newValue;
    }
}
</script>
@endpush
</div>
@endsection

