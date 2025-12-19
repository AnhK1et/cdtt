@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container">
    <h1>Đơn hàng #{{ $order->order_number }}</h1>

    <div class="order-detail">
        <div class="order-info">
            <h2>Thông tin đơn hàng</h2>
            <p><strong>Mã đơn hàng:</strong> {{ $order->order_number }}</p>
            <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Trạng thái:</strong> 
                <span class="status status-{{ $order->status }}">
                    @if($order->status == 'pending') Chờ xử lý
                    @elseif($order->status == 'processing') Đang xử lý
                    @elseif($order->status == 'shipped') Đã giao hàng
                    @elseif($order->status == 'delivered') Đã nhận hàng
                    @elseif($order->status == 'cancelled') Đã hủy
                    @endif
                </span>
            </p>
            <p><strong>Tổng tiền:</strong> {{ number_format($order->total_amount) }}đ</p>
        </div>

        <div class="shipping-info">
            <h2>Thông tin giao hàng</h2>
            <p><strong>Người nhận:</strong> {{ $order->customer_name }}</p>
            <p><strong>Email:</strong> {{ $order->customer_email }}</p>
            <p><strong>Điện thoại:</strong> {{ $order->customer_phone }}</p>
            <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
            @if($order->notes)
                <p><strong>Ghi chú:</strong> {{ $order->notes }}</p>
            @endif
        </div>

        <div class="order-items">
            <h2>Sản phẩm</h2>
            <table class="order-items-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ number_format($item->price) }}đ</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->subtotal) }}đ</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><strong>Tổng cộng:</strong></td>
                        <td><strong>{{ number_format($order->total_amount) }}đ</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

