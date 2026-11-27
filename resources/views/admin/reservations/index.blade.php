@extends('layouts.app')

@section('title', '預約審核')

@section('content')
    <h1>預約審核與借還</h1>
    <div class="alert todo">TODO(模組二)：每筆加上「通過 / 退件（含意見）」、「註記借出」、「確認歸還」按鈕。</div>
    <table>
        <thead><tr><th>申請人</th><th>日期</th><th>時間</th><th>教室</th><th>物品</th><th>狀態</th></tr></thead>
        <tbody>
        @forelse ($reservations as $r)
            <tr>
                <td>{{ $r->user->name }}</td>
                <td>{{ $r->date->format('Y-m-d') }}</td>
                <td>{{ substr($r->start_time, 0, 5) }}–{{ substr($r->end_time, 0, 5) }}</td>
                <td>{{ $r->room->code }}</td>
                <td>{{ $r->items->map(fn ($i) => "{$i->name} ×{$i->pivot->quantity}")->join('、') ?: '—' }}</td>
                <td>{{ \App\Models\Reservation::STATUSES[$r->status] }}</td>
            </tr>
        @empty
            <tr><td colspan="6" class="muted">沒有預約</td></tr>
        @endforelse
        </tbody>
    </table>
@endsection
