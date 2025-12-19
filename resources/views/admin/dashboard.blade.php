@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <h3>Tổng đơn hàng</h3>
        <p class="stat-number">{{ $stats['total_orders'] }}</p>
    </div>
    <div class="stat-card">
        <h3>Đơn chờ xử lý</h3>
        <p class="stat-number">{{ $stats['pending_orders'] }}</p>
    </div>
    <div class="stat-card">
        <h3>Tổng sản phẩm</h3>
        <p class="stat-number">{{ $stats['total_products'] }}</p>
    </div>
    <div class="stat-card">
        <h3>Danh mục</h3>
        <p class="stat-number">{{ $stats['total_categories'] }}</p>
    </div>
    <div class="stat-card">
        <h3>Khách hàng</h3>
        <p class="stat-number">{{ $stats['total_users'] }}</p>
    </div>
    <div class="stat-card">
        <h3>Doanh thu</h3>
        <p class="stat-number">{{ number_format($stats['total_revenue']) }}đ</p>
    </div>
</div>

<div class="recent-orders">
    <h2>Đơn hàng gần đây</h2>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Khách hàng</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Ngày đặt</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentOrders as $order)
            <tr>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ number_format($order->total_amount) }}đ</td>
                <td>
                    <span class="status status-{{ $order->status }}">
                        @if($order->status == 'pending') Chờ xử lý
                        @elseif($order->status == 'processing') Đang xử lý
                        @elseif($order->status == 'shipped') Đã giao hàng
                        @elseif($order->status == 'delivered') Đã nhận hàng
                        @elseif($order->status == 'cancelled') Đã hủy
                        @endif
                    </span>
                </td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary btn-sm">Xem</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

