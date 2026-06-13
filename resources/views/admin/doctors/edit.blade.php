@extends('layouts.app')

@section('title', 'Edit Doctor')

@section('content')
<h2 class="mb-4">Edit Doctor</h2>
<form method="POST" action="{{ route('admin.doctors.update', $doctor) }}">
    @csrf @method('PUT')
    @include('admin.doctors._form', ['doctor' => $doctor])
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
