@extends('layouts.app')

@section('title', 'Add Patient')

@section('content')
<h2 class="mb-4">Add Patient</h2>
<form method="POST" action="{{ route('admin.patients.store') }}">
    @csrf
    @include('admin.patients._form')
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
