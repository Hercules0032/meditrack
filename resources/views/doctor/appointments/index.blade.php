@extends('layouts.app')

@section('title', __('messages.appointments'))

@section('content')
<h2 class="mb-4">{{ __('messages.appointments') }}</h2>
<div class="table-responsive">
    <table class="table table-hover">
        <thead class="table-light">
            <tr><th>Date</th><th>Patient</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->appointment_date->format('M d, Y H:i') }}</td>
                    <td>{{ $appointment->patient->user->name }}</td>
                    <td>@include('partials.status-badge', ['status' => $appointment->status])</td>
                    <td>
                        <a href="{{ route('doctor.appointments.show', $appointment) }}" class="btn btn-sm btn-outline-primary">View</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-muted text-center">No appointments.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $appointments->links() }}
@endsection
