@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng')
@section('page-title', 'Chi tiết đơn hàng')

@section('content')
<div class="admin-detail">
    <div class="order-header">
        <h2>Đơn hàng #{{ $order->order_number }}</h2>
        <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="order-status">
        <h3>Cập nhật trạng thái</h3>
        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            <select name="status" class="form-control">
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Đã giao hàng</option>
                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Đã nhận hàng</option>
                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
            </select>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>

    <div class="order-info">
        <h3>Thông tin khách hàng</h3>
        <p><strong>Tên:</strong> {{ $order->customer_name }}</p>
        <p><strong>Email:</strong> {{ $order->customer_email }}</p>
        <p><strong>Điện thoại:</strong> {{ $order->customer_phone }}</p>
        <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
        @if($order->notes)
            <p><strong>Ghi chú:</strong> {{ $order->notes }}</p>
        @endif
    </div>

    <div class="order-items">
        <h3>Sản phẩm</h3>
        <table class="admin-table">
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

    <div class="admin-actions">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại</a>
    </div>
</div>
@endsection

