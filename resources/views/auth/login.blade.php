@extends('layouts.app')

@section('title', '登入')

@section('content')
    <form method="POST" action="{{ route('login') }}" class="form narrow">
        @csrf
        <h1>登入</h1>
        <label>Email <input type="email" name="email" value="{{ old('email') }}" required autofocus></label>
        <label>密碼 <input type="password" name="password" required></label>
        <label class="inline"><input type="checkbox" name="remember"> 記住我</label>
        <button type="submit">登入</button>
        <p>還沒有帳號？<a href="{{ route('register') }}">註冊</a></p>
    </form>
@endsection
