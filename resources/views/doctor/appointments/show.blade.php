@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')
<h2 class="mb-4">Appointment Details</h2>
<div class="card mb-3"><div class="card-body">
    <p><strong>Patient:</strong> {{ $appointment->patient->user->name }}</p>
    <p><strong>Date:</strong> {{ $appointment->appointment_date->format('M d, Y H:i') }}</p>
    <p><strong>Status:</strong> @include('partials.status-badge', ['status' => $appointment->status])</p>
    <p><strong>Notes:</strong> {{ $appointment->notes ?? 'None' }}</p>
</div></div>

@if($appointment->status === 'pending')
    <form method="POST" action="{{ route('doctor.appointments.confirm', $appointment) }}">
        @csrf
        <button class="btn btn-success">Confirm Appointment</button>
    </form>
@endif

@if($appointment->status === 'confirmed')
    @if($appointment->prescription)
        <a href="{{ route('doctor.prescriptions.show', $appointment) }}" class="btn btn-info">View Prescription</a>
    @else
        <a href="{{ route('doctor.prescriptions.create', $appointment) }}" class="btn btn-primary">Write Prescription</a>
    @endif
@endif

<a href="{{ route('doctor.appointments.index') }}" class="btn btn-secondary">Back</a>
@endsection
