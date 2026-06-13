@extends('layouts.app')

@section('title', 'Add Doctor')

@section('content')
<h2 class="mb-4">Add Doctor</h2>
<form method="POST" action="{{ route('admin.doctors.store') }}">
    @csrf
    @include('admin.doctors._form')
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
