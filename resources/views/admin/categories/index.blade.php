@extends('layouts.admin')

@section('title', 'Danh mục')
@section('page-title', 'Quản lý danh mục')

@section('content')
<div class="admin-actions">
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Thêm danh mục mới</a>
</div>

<p>Danh sách danh mục đã bị ẩn.</p>
@endsection

