@extends('layouts.app')

@section('title', 'Đăng ký')

@section('content')
<div class="container">
    <div class="auth-form">
        <h1>Đăng ký</h1>
        
        @if($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label>Họ tên</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-large">Đăng ký</button>
        </form>

        <p class="auth-link">
            Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a>
        </p>
    </div>
</div>
@endsection

