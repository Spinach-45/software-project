@extends('layouts.app')

@section('title', '帳號審核')

@section('content')
    <h1>帳號審核</h1>

    @foreach (['待審核' => $pending, '所有帳號' => $others] as $heading => $users)
        <h2>{{ $heading }}（{{ $users->count() }}）</h2>
        <table>
            <thead><tr><th>姓名</th><th>Email</th><th>註冊時間</th><th>角色</th><th>狀態</th><th></th></tr></thead>
            <tbody>
            @forelse ($users as $user)
                <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <select name="role" form="user-{{ $user->id }}">
                                @foreach (\App\Models\User::ROLES as $value => $label)
                                    <option value="{{ $value }}" @selected($user->role === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="status" form="user-{{ $user->id }}">
                                @foreach (\App\Models\User::STATUSES as $value => $label)
                                    <option value="{{ $value }}" @selected($user->status === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <form id="user-{{ $user->id }}" method="POST" action="{{ route('admin.users.update', $user) }}">
                                @csrf @method('PATCH')
                                <button type="submit">儲存</button>
                            </form>
                        </td>
                </tr>
            @empty
                <tr><td colspan="6" class="muted">沒有資料</td></tr>
            @endforelse
            </tbody>
        </table>
    @endforeach
@endsection
