@extends('layouts.app')

@section('title', '教室管理')

@section('content')
    <h1>教室管理</h1>
    <p><a href="{{ route('admin.rooms.create') }}">＋ 新增教室</a></p>
    <table>
        <thead><tr><th>編號</th><th>名稱</th><th>樓層</th><th>可預約</th><th></th></tr></thead>
        <tbody>
        @foreach ($rooms as $room)
            <tr>
                <td>{{ $room->code }}</td>
                <td>{{ $room->name }}</td>
                <td>{{ $room->floor }}</td>
                <td>{{ $room->is_reservable ? '是' : '否' }}</td>
                <td><a href="{{ route('admin.rooms.edit', $room) }}">編輯</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
