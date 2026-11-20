@extends('layouts.app')

@section('title', '註冊')

@section('content')
    <form method="POST" action="{{ route('register') }}" class="form narrow">
        @csrf
        <h1>註冊</h1>
        <label>姓名 <input type="text" name="name" value="{{ old('name') }}" required autofocus></label>
        <label>Email <input type="email" name="email" value="{{ old('email') }}" required></label>
        <label>身分
            <select name="role">
                <option value="user" @selected(old('role') === 'user')>一般使用者（學生、職員）</option>
                <option value="teacher" @selected(old('role') === 'teacher')>老師</option>
            </select>
        </label>
        <label>密碼（至少 8 碼） <input type="password" name="password" required></label>
        <label>確認密碼 <input type="password" name="password_confirmation" required></label>
        <button type="submit">送出註冊</button>
        <p class="muted">註冊後需由管理員審核通過才能登入。</p>
    </form>
@endsection
