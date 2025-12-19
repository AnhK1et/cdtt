@extends('layouts.admin')

@section('title', 'Sản phẩm')
@section('page-title', 'Quản lý sản phẩm')

@section('content')
<div class="admin-actions">
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Thêm sản phẩm mới</a>
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Danh mục</th>
            <th>Giá</th>
            <th>Tồn kho</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name }}</td>
            <td>{{ number_format($product->price) }}đ</td>
            <td>{{ $product->stock }}</td>
            <td>
                <span class="status status-{{ $product->is_active ? 'active' : 'inactive' }}">
                    {{ $product->is_active ? 'Hoạt động' : 'Tắt' }}
                </span>
            </td>
            <td>
                <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-primary btn-sm">Xem</a>
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-secondary btn-sm">Sửa</a>
                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="pagination">
    {{ $products->links() }}
</div>
@endsection

