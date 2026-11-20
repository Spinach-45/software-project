@extends('layouts.app')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>
    <div class="alert todo">這個頁面還沒做（{{ $module }}）。請到對應的 Controller 找 <code>TODO({{ $module }})</code>。</div>
@endsection
