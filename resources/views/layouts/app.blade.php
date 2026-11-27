<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', '首頁') | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('head')
</head>
<body>
<header class="topbar">
    <a class="brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
    <nav>
        <a href="{{ route('spaces.index') }}">空間查詢</a>
        @auth
            <a href="{{ route('reservations.index') }}">預約借用</a>
            @if (auth()->user()->isTeacher() || auth()->user()->isAdmin())
                <a href="{{ route('courses.index') }}">排課</a>
            @endif
            @if (auth()->user()->isAdmin())
                <span class="nav-group">管理：
                    <a href="{{ route('admin.users.index') }}">帳號</a>
                    <a href="{{ route('admin.rooms.index') }}">教室</a>
                    <a href="{{ route('admin.reservations.index') }}">預約</a>
                    <a href="{{ route('admin.courses.index') }}">課程</a>
                </span>
            @endif
        @endauth
    </nav>
    <div class="account">
        @auth
            <span>{{ auth()->user()->name }}（{{ \App\Models\User::ROLES[auth()->user()->role] }}）</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="link">登出</button>
            </form>
        @else
            <a href="{{ route('login') }}">登入</a>
            <a href="{{ route('register') }}">註冊</a>
        @endauth
    </div>
</header>

<main class="container">
    @if (session('status'))
        <div class="alert success">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @yield('content')
</main>
@stack('scripts')
</body>
</html>
