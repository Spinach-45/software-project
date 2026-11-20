@extends('layouts.app')

@section('title', $room->name)

@push('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css">
@endpush

@section('content')
    <h1>{{ $room->code }} {{ $room->name }}</h1>
    <dl class="info">
        <dt>樓層</dt><dd>{{ $room->floor ?? '—' }}</dd>
        <dt>類型</dt><dd>{{ $room->type ?? '—' }}</dd>
        <dt>容納人數</dt><dd>{{ $room->capacity ?? '—' }}</dd>
        <dt>設備</dt><dd>{{ $room->equipment ?? '—' }}</dd>
        <dt>說明</dt><dd>{{ $room->description ?? '—' }}</dd>
    </dl>

    <h2>360 全景照片</h2>
    @if ($room->panorama_path)
        <div id="panorama" class="panorama"></div>
    @else
        <p class="muted">尚未上傳全景照片。</p>
    @endif

    {{-- TODO(模組一)：顯示這間教室在平面圖上的位置；完整款可加上「預約這間教室」按鈕 --}}
@endsection

@push('scripts')
    @if ($room->panorama_path)
        <script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>
        <script>
            pannellum.viewer('panorama', {
                type: 'equirectangular',
                panorama: @json(asset($room->panorama_path)),
                autoLoad: true
            });
        </script>
    @endif
@endpush
