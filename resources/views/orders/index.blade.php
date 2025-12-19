@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

@section('content')
<div class="container">
    <h1>Đơn hàng của tôi</h1>

    @if($orders->count() > 0)
    <table class="orders-table">
        <thead>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
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
                <td>
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm">Xem chi tiết</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination">
        {{ $orders->links() }}
    </div>
    @else
    <p>Bạn chưa có đơn hàng nào.</p>
    @endif
</div>
@endsection

