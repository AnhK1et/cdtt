<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Quản trị') - anhkiet store</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <h2>📱 Admin Panel</h2>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">Danh mục</a>
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">Sản phẩm</a>
                <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">Đơn hàng</a>
                <a href="{{ route('home') }}">Về trang chủ</a>
                <form method="POST" action="{{ route('logout') }}" style="margin-top: auto;">
                    @csrf
                    <button type="submit" class="sidebar-logout">Đăng xuất</button>
                </form>
            </nav>
        </aside>

        <main class="admin-content">
            <header class="admin-header">
                <h1>@yield('page-title', 'Quản trị')</h1>
            </header>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <div class="admin-body">
                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>

