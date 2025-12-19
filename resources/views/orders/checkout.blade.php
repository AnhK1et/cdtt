@extends('layouts.app')

@section('title', 'Thanh toán')

@section('content')
<div class="container">
    <h1>Thanh toán</h1>

    <div class="checkout">
        <div class="checkout-form">
            <h2>Thông tin giao hàng</h2>
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Họ tên *</label>
                    <input type="text" name="customer_name" class="form-control" value="{{ auth()->user()->name }}" required>
                </div>
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="customer_email" class="form-control" value="{{ auth()->user()->email }}" required>
                </div>
                <div class="form-group">
                    <label>Số điện thoại *</label>
                    <input type="text" name="customer_phone" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Địa chỉ giao hàng *</label>
                    <textarea name="shipping_address" class="form-control" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label>Ghi chú</label>
                    <textarea name="notes" class="form-control" rows="2"></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-large">Đặt hàng</button>
            </form>
        </div>

        <div class="checkout-summary">
            <h2>Đơn hàng</h2>
            <div class="order-items">
                @foreach($cartItems as $productId => $item)
                <div class="order-item">
                    <div class="item-info">
                        <h4>{{ $item['product']->name }}</h4>
                        <p>{{ $item['quantity'] }} x {{ number_format($item['product']->final_price) }}đ</p>
                    </div>
                    <div class="item-total">{{ number_format($item['subtotal']) }}đ</div>
                </div>
                @endforeach
            </div>
            <div class="order-total">
                <strong>Tổng cộng: {{ number_format($total) }}đ</strong>
            </div>
        </div>
    </div>
</div>
@endsection

