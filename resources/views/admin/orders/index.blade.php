@extends('layouts.admin')

@section('title', 'Đơn hàng')
@section('page-title', 'Quản lý đơn hàng')

@section('content')
<div class="filters">
    <form method="GET" action="{{ route('admin.orders.index') }}">
        <select name="status" class="form-control">
            <option value="">Tất cả trạng thái</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Đã giao hàng</option>
            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Đã nhận hàng</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
        </select>
        <button type="submit" class="btn btn-primary">Lọc</button>
    </form>
</div>

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
        @foreach($orders as $order)
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

<div class="pagination">
    {{ $orders->links() }}
</div>
@endsection

