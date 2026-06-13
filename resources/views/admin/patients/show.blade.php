@extends('layouts.app')

@section('title', 'Patient Profile')

@section('content')
<h2 class="mb-4">{{ $patient->full_name }}</h2>
<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6"><strong>Email:</strong> {{ $patient->user->email }}</div>
            <div class="col-md-6"><strong>Age:</strong> {{ $patient->age }}</div>
            <div class="col-md-6"><strong>Phone:</strong> {{ $patient->phone }}</div>
            <div class="col-md-6"><strong>Gender:</strong> {{ ucfirst($patient->gender) }}</div>
            <div class="col-md-6"><strong>Blood Group:</strong> {{ $patient->blood_group ?? 'N/A' }}</div>
            <div class="col-12"><strong>Address:</strong> {{ $patient->address ?? 'N/A' }}</div>
        </div>
    </div>
</div>

<h4>Appointments</h4>
<div class="table-responsive">
    <table class="table">
        <thead><tr><th>Date</th><th>Doctor</th><th>Status</th></tr></thead>
        <tbody>
            @forelse($patient->appointments as $appt)
                <tr>
                    <td>{{ $appt->appointment_date->format('M d, Y H:i') }}</td>
                    <td>{{ $appt->doctor->user->name ?? 'N/A' }}</td>
                    <td>@include('partials.status-badge', ['status' => $appt->status])</td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-muted">No appointments.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">Back</a>
@endsection
