@extends('layouts.app')

@section('title', __('messages.appointments'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>{{ __('messages.appointments') }}</h2>
    <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary">New Appointment</a>
</div>

<form method="GET" class="mb-3">
    <select name="status" class="form-select w-auto d-inline" onchange="this.form.submit()">
        <option value="">All Statuses</option>
        @foreach(['pending','confirmed','cancelled'] as $s)
            <option value="{{ $s }}" @selected($status === $s)>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
</form>

<form method="POST" action="{{ route('admin.appointments.bulk-delete') }}">
    @csrf
    <button type="submit" class="btn btn-danger btn-sm mb-2" onclick="return confirm('Delete selected?')">Delete Selected</button>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr><th><input type="checkbox" id="select-all"></th><th>Date</th><th>Patient</th><th>Doctor</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($appointments as $appointment)
                    <tr>
                        <td><input type="checkbox" name="ids[]" value="{{ $appointment->id }}" class="row-check"></td>
                        <td>{{ $appointment->appointment_date->format('M d, Y H:i') }}</td>
                        <td>{{ $appointment->patient->user->name }}</td>
                        <td>{{ $appointment->doctor->user->name }}</td>
                        <td>@include('partials.status-badge', ['status' => $appointment->status])</td>
                        <td>
                            <a href="{{ route('admin.appointments.show', $appointment) }}" class="btn btn-sm btn-outline-info">View</a>
                            <a href="{{ route('admin.appointments.edit', $appointment) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted">No appointments.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</form>
{{ $appointments->withQueryString()->links() }}
@endsection
