<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Cửa Hàng Điện Thoại')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-content">
                <div class="top-bar-left">
                    <span>Hotline: <strong>1900-xxxx</strong></span>
                    <span>|</span>
                    <span>Miễn phí vận chuyển cho đơn hàng trên 500.000đ</span>
                </div>
                <div class="top-bar-right">
                    @auth
                        <a href="{{ route('orders.index') }}">Đơn hàng</a>
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}">Quản trị</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-link">Đăng xuất ({{ auth()->user()->name }})</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}">Đăng nhập</a>
                        <span>|</span>
                        <a href="{{ route('register') }}">Đăng ký</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                <div class="header-logo">
                    <a href="{{ route('home') }}">
                        <span class="logo-text-red">AnhKiet Store</span>
                    </a>
                </div>
                
                <div class="header-search">
                    <form method="GET" action="{{ route('products.index') }}" class="search-form">
                        <input type="text" name="search" class="search-input" placeholder="Tìm kiếm điện thoại, phụ kiện..." value="{{ request('search') }}">
                        <button type="submit" class="search-btn-red">🔍</button>
                    </form>
                </div>

                <div class="header-actions">
                    <a href="#" class="header-icon">
                        <span class="icon-text">❤️</span>
                        <span class="icon-label">Yêu thích</span>
                    </a>
                    <a href="{{ route('cart.index') }}" class="header-icon cart-header">
                        <span class="icon-text">🛒</span>
                        <span class="icon-label">Giỏ hàng</span>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="cart-badge-red">{{ count(session('cart')) }}</span>
                        @else
                            <span class="cart-badge-red">0</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Navigation -->
    <nav class="main-nav">
        <div class="container">
            <ul class="main-nav-list">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Trang chủ</a></li>
                <li><a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">Sản phẩm</a></li>
                <li><a href="{{ route('products.index') }}">Danh mục</a></li>
                <li><a href="#">Tin tức</a></li>
            </ul>
        </div>
    </nav>

    <!-- Messages -->
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

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <!-- About Section -->
                <div class="footer-section">
                    <h3 class="footer-title">Về AnhKiet Store</h3>
                    <p class="footer-description">
                        Chuyên cung cấp điện thoại chính hãng, phụ kiện chất lượng cao với giá tốt nhất thị trường. 
                        Cam kết bảo hành chính hãng và dịch vụ chăm sóc khách hàng tận tâm.
                    </p>
                    <div class="footer-social">
                        <a href="#" class="social-link" aria-label="Facebook">
                            <span>📘</span>
                        </a>
                        <a href="#" class="social-link" aria-label="Instagram">
                            <span>📷</span>
                        </a>
                        <a href="#" class="social-link" aria-label="YouTube">
                            <span>📺</span>
                        </a>
                        <a href="#" class="social-link" aria-label="Zalo">
                            <span>💬</span>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-section">
                    <h3 class="footer-title">Liên kết nhanh</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li><a href="{{ route('products.index') }}">Sản phẩm</a></li>
                        <li><a href="{{ route('products.index') }}">Danh mục</a></li>
                        <li><a href="{{ route('cart.index') }}">Giỏ hàng</a></li>
                        <li><a href="{{ route('orders.index') }}">Đơn hàng</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div class="footer-section">
                    <h3 class="footer-title">Hỗ trợ khách hàng</h3>
                    <ul class="footer-links">
                        <li><a href="#">Chính sách bảo hành</a></li>
                        <li><a href="#">Chính sách đổi trả</a></li>
                        <li><a href="#">Hướng dẫn mua hàng</a></li>
                        <li><a href="#">Vận chuyển & Thanh toán</a></li>
                        <li><a href="#">Câu hỏi thường gặp</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="footer-section">
                    <h3 class="footer-title">Thông tin liên hệ</h3>
                    <div class="footer-contact">
                        <div class="contact-item">
                            <span class="contact-icon">📞</span>
                            <div>
                                <strong>Hotline:</strong>
                                <a href="tel:1900xxxx">1900-xxxx</a>
                            </div>
                        </div>
                        <div class="contact-item">
                            <span class="contact-icon">✉️</span>
                            <div>
                                <strong>Email:</strong>
                                <a href="mailto:info@anhkietstore.com">info@anhkietstore.com</a>
                            </div>
                        </div>
                        <div class="contact-item">
                            <span class="contact-icon">📍</span>
                            <div>
                                <strong>Địa chỉ:</strong>
                                <p>123 Đường ABC, Quận XYZ, TP.HCM</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <span class="contact-icon">🕒</span>
                            <div>
                                <strong>Giờ làm việc:</strong>
                                <p>8:00 - 22:00 (Tất cả các ngày)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="footer-bottom-content">
                    <p>&copy; {{ date('Y') }} <strong>AnhKiet Store</strong>. Tất cả quyền được bảo lưu.</p>
                    <div class="footer-payments">
                        <span class="payment-label">Chấp nhận thanh toán:</span>
                        <div class="payment-icons">
                            <span class="payment-icon">💳</span>
                            <span class="payment-icon">🏦</span>
                            <span class="payment-icon">📱</span>
                            <span class="payment-icon">💰</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>

