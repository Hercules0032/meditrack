@extends('layouts.app')

@section('title', '403')

@section('content')
<div class="text-center py-5">
    <h1 class="display-1 text-danger">403</h1>
    <p class="lead">You don't have permission to access this page.</p>
    <a href="{{ route('home') }}" class="btn btn-primary">Go Home</a>
</div>
@endsection
