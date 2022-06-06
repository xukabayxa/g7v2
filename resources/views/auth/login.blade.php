@extends('layouts.app')
@section('content')
<form class="login" method="POST" action="{{ route('login') }}">
    @csrf
    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email đăng nhập">
    @error('email')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Mật khẩu">
    @error('password')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
    <button type="submit "><i class="fas fa-sign-in-alt" style="margin-right: 5px"></i>Đăng nhập</button>
</form>
@endsection