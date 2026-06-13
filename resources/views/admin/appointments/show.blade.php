@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')
<h2 class="mb-4">Appointment #{{ $appointment->id }}</h2>
<div class="card mb-3"><div class="card-body">
    <p><strong>Patient:</strong> {{ $appointment->patient->user->name }}</p>
    <p><strong>Doctor:</strong> {{ $appointment->doctor->user->name }}</p>
    <p><strong>Date:</strong> {{ $appointment->appointment_date->format('M d, Y H:i') }}</p>
    <p><strong>Status:</strong> @include('partials.status-badge', ['status' => $appointment->status])</p>
    <p><strong>Notes:</strong> {{ $appointment->notes ?? 'None' }}</p>
</div></div>

@if($appointment->status !== 'confirmed')
<form method="POST" action="{{ route('admin.appointments.status', $appointment->id) }}" class="d-inline">
    @csrf @method('PATCH')
    <input type="hidden" name="status" value="confirmed">
    <button class="btn btn-success">Confirm</button>
</form>
@endif

<a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary">Back</a>
@endsection
