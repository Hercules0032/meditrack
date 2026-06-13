@extends('layouts.app')

@section('title', '404')

@section('content')
<div class="text-center py-5">
    <h1 class="display-1 text-muted">404</h1>
    <p class="lead">The page you're looking for doesn't exist.</p>
    <a href="{{ route('home') }}" class="btn btn-primary">Go Home</a>
</div>
@endsection
