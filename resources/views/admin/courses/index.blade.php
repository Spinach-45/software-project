@extends('layouts.app')

@section('title', '課程管理')

@section('content')
    <h1>所有課程</h1>
    <p><a href="{{ route('admin.courses.conflicts') }}">查看時間衝突的課程</a> · <a href="{{ route('courses.calendar') }}">週日曆</a></p>
    <div class="alert todo">TODO(模組三)：管理員新增/修改/刪除課程、指派課程給老師。</div>
    <table>
        <thead><tr><th>課程</th><th>老師</th><th>日期</th><th>時間</th><th>教室</th></tr></thead>
        <tbody>
        @forelse ($courses as $course)
            <tr>
                <td>{{ $course->name }}</td>
                <td>{{ $course->teacher?->name ?? '未指派' }}</td>
                <td>{{ $course->date->format('Y-m-d') }}</td>
                <td>{{ substr($course->start_time, 0, 5) }}–{{ substr($course->end_time, 0, 5) }}</td>
                <td>{{ $course->room?->code ?? '—' }}</td>
            </tr>
        @empty
            <tr><td colspan="5" class="muted">沒有課程</td></tr>
        @endforelse
        </tbody>
    </table>
@endsection
