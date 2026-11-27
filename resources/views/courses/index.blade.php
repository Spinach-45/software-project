@extends('layouts.app')

@section('title', '我的課程')

@section('content')
    <h1>我的課程</h1>
    <p>
        <a href="{{ route('courses.calendar') }}">查看排課週日曆</a> ·
        <a href="{{ route('courses.create') }}">＋ 登記課程</a>
    </p>
    <table>
        <thead><tr><th>課程</th><th>日期</th><th>時間</th><th>希望教室</th><th></th></tr></thead>
        <tbody>
        @forelse ($courses as $course)
            <tr>
                <td>{{ $course->name }}</td>
                <td>{{ $course->date->format('Y-m-d') }}</td>
                <td>{{ substr($course->start_time, 0, 5) }}–{{ substr($course->end_time, 0, 5) }}</td>
                <td>{{ $course->room?->code ?? '—' }}</td>
                <td><a href="{{ route('courses.edit', $course) }}">編輯</a></td>
            </tr>
        @empty
            <tr><td colspan="5" class="muted">還沒有登記課程</td></tr>
        @endforelse
        </tbody>
    </table>
@endsection
