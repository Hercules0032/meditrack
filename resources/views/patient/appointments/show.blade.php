@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')
<h2 class="mb-4">Appointment Details</h2>
<div class="card mb-3"><div class="card-body">
    <p><strong>Doctor:</strong> Dr. {{ $appointment->doctor->user->name }} ({{ $appointment->doctor->specialization }})</p>
    <p><strong>Date:</strong> {{ $appointment->appointment_date->format('M d, Y H:i') }}</p>
    <p><strong>Status:</strong> @include('partials.status-badge', ['status' => $appointment->status])</p>
    @if($appointment->prescription)
        <hr>
        <h5>Prescription</h5>
        <p><strong>Medicines:</strong> {{ $appointment->prescription->medicines }}</p>
        <p><strong>Instructions:</strong> {{ $appointment->prescription->instructions }}</p>
    @endif
</div></div>
<a href="{{ route('patient.appointments.index') }}" class="btn btn-secondary">Back</a>
@endsection
