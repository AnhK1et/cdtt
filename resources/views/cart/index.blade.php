@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
<div class="container">
    <h1>Giỏ hàng</h1>

    @if(count($cartItems) > 0)
    <div class="cart">
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tổng</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $productId => $item)
                <tr>
                    <td>
                        <div class="cart-product">
                            @if($item['product']->image_url)
                                <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->name }}">
                            @else
                                <div class="product-placeholder small">📱</div>
                            @endif
                            <div>
                                <h3>{{ $item['product']->name }}</h3>
                            </div>
                        </div>
                    </td>
                    <td>{{ number_format($item['product']->final_price) }}đ</td>
                    <td>
                        <form action="{{ route('cart.update', $productId) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['product']->stock }}" onchange="this.form.submit()" class="form-control quantity-input">
                        </form>
                    </td>
                    <td>{{ number_format($item['subtotal']) }}đ</td>
                    <td>
                        <form action="{{ route('cart.remove', $productId) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><strong>Tổng cộng:</strong></td>
                    <td colspan="2"><strong>{{ number_format($total) }}đ</strong></td>
                </tr>
            </tfoot>
        </table>

        <div class="cart-actions">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Tiếp tục mua sắm</a>
            <form action="{{ route('cart.clear') }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Xóa toàn bộ</button>
            </form>
            <a href="{{ route('orders.checkout') }}" class="btn btn-primary">Thanh toán</a>
        </div>
    </div>
    @else
    <div class="empty-cart">
        <p>Giỏ hàng của bạn đang trống.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">Mua sắm ngay</a>
    </div>
    @endif
</div>
@endsection

