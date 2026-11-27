@extends('layouts.app')

@section('title', '管院平面圖')

@section('content')
    <h1>管院平面圖</h1>
    <div class="alert todo">TODO(模組一)：把平面圖放在 <code>public/images/floorplan.png</code>，再依教室的 map_x / map_y（百分比）疊上標記。</div>
    <ul>
        @foreach ($rooms as $room)
            <li><a href="{{ route('spaces.show', $room) }}">{{ $room->code }} {{ $room->name }}</a>（x {{ $room->map_x }}%, y {{ $room->map_y }}%）</li>
        @endforeach
    </ul>
@endsection
