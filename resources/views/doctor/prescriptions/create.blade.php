@extends('layouts.app')

@section('title', 'Write Prescription')

@section('content')
<h2 class="mb-4">Prescription for {{ $appointment->patient->user->name }}</h2>

<form method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" name="medicine" class="form-control" placeholder="Search medicine (OpenFDA)..." value="{{ $medicineName }}">
        <button class="btn btn-outline-secondary">Lookup</button>
    </div>
</form>

@if($medicineInfo && !empty($medicineInfo['results'][0]))
    <div class="alert alert-info">
        <strong>Drug Info:</strong>
        {{ $medicineInfo['results'][0]['openfda']['brand_name'][0] ?? 'Unknown' }}
        — {{ Str::limit($medicineInfo['results'][0]['indications_and_usage'][0] ?? 'No description', 200) }}
    </div>
@endif

<form method="POST" action="{{ route('doctor.prescriptions.store', $appointment) }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">Medicines</label>
        <textarea name="medicines" class="form-control" rows="4" required>{{ old('medicines') }}</textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Instructions</label>
        <textarea name="instructions" class="form-control" rows="4" required>{{ old('instructions') }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">Save Prescription</button>
</form>
@endsection
