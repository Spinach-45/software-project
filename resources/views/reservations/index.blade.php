@extends('layouts.app')

@section('title', '我的借用紀錄')

@section('content')
    <h1>我的借用紀錄</h1>
    <p>
        <a href="{{ route('reservations.week') }}">查看教室週借用狀況</a> ·
        <a href="{{ route('reservations.create') }}">＋ 預約借用</a>
    </p>
    <table>
        <thead><tr><th>日期</th><th>時間</th><th>教室</th><th>借用物品</th><th>狀態</th><th>審核意見</th></tr></thead>
        <tbody>
        @forelse ($reservations as $r)
            <tr>
                <td>{{ $r->date->format('Y-m-d') }}</td>
                <td>{{ substr($r->start_time, 0, 5) }}–{{ substr($r->end_time, 0, 5) }}</td>
                <td>{{ $r->room->code }} {{ $r->room->name }}</td>
                <td>{{ $r->items->map(fn ($i) => "{$i->name} ×{$i->pivot->quantity}")->join('、') ?: '—' }}</td>
                <td>{{ \App\Models\Reservation::STATUSES[$r->status] }}</td>
                <td>{{ $r->review_note ?? '—' }}</td>
            </tr>
        @empty
            <tr><td colspan="6" class="muted">還沒有借用紀錄</td></tr>
        @endforelse
        </tbody>
    </table>
@endsection
