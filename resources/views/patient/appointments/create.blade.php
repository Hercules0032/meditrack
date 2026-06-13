@extends('layouts.app')

@section('title', __('messages.book_appointment'))

@section('content')
<h2 class="mb-4">{{ __('messages.book_appointment') }}</h2>
<form method="POST" action="{{ route('patient.appointments.store') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">Select Doctor</label>
        <select name="doctor_id" class="form-select" required>
            @foreach($doctors as $doctor)
                <option value="{{ $doctor->id }}">Dr. {{ $doctor->user->name }} — {{ $doctor->specialization }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Preferred Date & Time</label>
        <input type="datetime-local" name="appointment_date" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Notes</label>
        <textarea name="notes" class="form-control" rows="3" placeholder="Describe your symptoms..."></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Book Appointment</button>
</form>
@endsection
