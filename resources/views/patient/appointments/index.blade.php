@extends('layouts.app')

@section('title', __('messages.appointments'))

@section('content')
<div class="d-flex justify-content-between mb-4">
    <h2>{{ __('messages.appointments') }}</h2>
    <a href="{{ route('patient.appointments.create') }}" class="btn btn-primary">{{ __('messages.book_appointment') }}</a>
</div>
<div class="table-responsive">
    <table class="table table-hover">
        <thead class="table-light"><tr><th>Date</th><th>Doctor</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->appointment_date->format('M d, Y H:i') }}</td>
                    <td>Dr. {{ $appointment->doctor->user->name }}</td>
                    <td>@include('partials.status-badge', ['status' => $appointment->status])</td>
                    <td>
                        <a href="{{ route('patient.appointments.show', $appointment) }}" class="btn btn-sm btn-outline-primary">View</a>
                        @if($appointment->status !== 'cancelled')
                            <form action="{{ route('patient.appointments.destroy', $appointment) }}" method="POST" class="d-inline">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Cancel?')">Cancel</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted">No appointments yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $appointments->links() }}
@endsection
