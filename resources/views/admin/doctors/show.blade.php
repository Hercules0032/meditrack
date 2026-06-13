@extends('layouts.app')

@section('title', 'Doctor Profile')

@section('content')
<h2 class="mb-4">Dr. {{ $doctor->user->name }}</h2>
<div class="card mb-4"><div class="card-body">
    <p><strong>Specialization:</strong> {{ $doctor->specialization }}</p>
    <p><strong>License:</strong> {{ $doctor->license_number }}</p>
    <p><strong>Email:</strong> {{ $doctor->user->email }}</p>
    <p><strong>Phone:</strong> {{ $doctor->phone }}</p>
</div></div>
<a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">Back</a>
@endsection
