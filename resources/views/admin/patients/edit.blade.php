@extends('layouts.app')

@section('title', 'Edit Patient')

@section('content')
<h2 class="mb-4">Edit Patient</h2>
<form method="POST" action="{{ route('admin.patients.update', $patient) }}">
    @csrf @method('PUT')
    @include('admin.patients._form', ['patient' => $patient])
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
