@extends('layouts.app')

@section('title', 'Prescription')

@section('content')
<h2 class="mb-4">Prescription</h2>
<div class="card"><div class="card-body">
    <p><strong>Patient:</strong> {{ $appointment->patient->user->name }}</p>
    <p><strong>Medicines:</strong></p>
    <pre class="bg-light p-3 rounded">{{ $appointment->prescription->medicines }}</pre>
    <p><strong>Instructions:</strong></p>
    <pre class="bg-light p-3 rounded">{{ $appointment->prescription->instructions }}</pre>
</div></div>
<a href="{{ route('doctor.appointments.show', $appointment) }}" class="btn btn-secondary mt-3">Back</a>
@endsection
