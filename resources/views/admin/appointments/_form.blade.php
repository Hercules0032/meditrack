<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Patient</label>
        <select name="patient_id" class="form-select" required>
            @foreach($patients as $p)
                <option value="{{ $p->id }}" @selected(old('patient_id', $appointment->patient_id ?? '') == $p->id)>{{ $p->user->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Doctor</label>
        <select name="doctor_id" class="form-select" required>
            @foreach($doctors as $d)
                <option value="{{ $d->id }}" @selected(old('doctor_id', $appointment->doctor_id ?? '') == $d->id)>Dr. {{ $d->user->name }} ({{ $d->specialization }})</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Date & Time</label>
        <input type="datetime-local" name="appointment_date" class="form-control"
            value="{{ old('appointment_date', isset($appointment) ? $appointment->appointment_date->format('Y-m-d\TH:i') : '') }}" required>
    </div>
    @if(!empty($edit))
        <div class="col-md-6 mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                @foreach(['pending','confirmed','cancelled'] as $s)
                    <option value="{{ $s }}" @selected(old('status', $appointment->status) === $s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
    @endif
    <div class="col-12 mb-3">
        <label class="form-label">Notes</label>
        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $appointment->notes ?? '') }}</textarea>
    </div>
</div>
