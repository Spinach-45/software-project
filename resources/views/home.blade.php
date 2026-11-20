@extends('layouts.app')

@section('content')
    <h1>管院空間與排課系統</h1>
    <div class="cards">
        <a class="card" href="{{ route('spaces.index') }}">
            <h2>空間查詢</h2>
            <p>瀏覽管院教室資訊、360 全景照片與平面圖，不須登入。</p>
        </a>
        <a class="card" href="{{ route('reservations.index') }}">
            <h2>預約借用</h2>
            <p>查看教室週借用狀況，預約教室與借用物品。</p>
        </a>
        <a class="card" href="{{ route('courses.index') }}">
            <h2>志願排課</h2>
            <p>老師登記想排課的時段，管理員統一調整。</p>
        </a>
    </div>
@endsection
