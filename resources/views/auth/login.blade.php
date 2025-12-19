@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
<div class="container">
    <div class="auth-form">
        <h1>Đăng nhập</h1>
        
        @if($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="remember"> Ghi nhớ đăng nhập
                </label>
            </div>
            <button type="submit" class="btn btn-primary btn-large">Đăng nhập</button>
        </form>

        <p class="auth-link">
            Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a>
        </p>
    </div>
</div>
@endsection

