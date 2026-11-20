@extends('layouts.app')

@section('title', '空間查詢')

@section('content')
    <h1>管院空間查詢</h1>
    <p><a href="{{ route('spaces.map') }}">查看管院平面圖</a></p>
    <table>
        <thead><tr><th>編號</th><th>名稱</th><th>樓層</th><th>類型</th><th>容納人數</th><th></th></tr></thead>
        <tbody>
        @forelse ($rooms as $room)
            <tr>
                <td>{{ $room->code }}</td>
                <td>{{ $room->name }}</td>
                <td>{{ $room->floor }}</td>
                <td>{{ $room->type }}</td>
                <td>{{ $room->capacity }}</td>
                <td><a href="{{ route('spaces.show', $room) }}">詳細資訊</a></td>
            </tr>
        @empty
            <tr><td colspan="6" class="muted">還沒有教室資料</td></tr>
        @endforelse
        </tbody>
    </table>
@endsection
