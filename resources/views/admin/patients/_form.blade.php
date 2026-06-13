<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $patient->user->name ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $patient->user->email ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Date of Birth</label>
        <input type="date" name="dob" class="form-control" value="{{ old('dob', isset($patient) ? $patient->dob->format('Y-m-d') : '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $patient->phone ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-select" required>
            @foreach(['male', 'female', 'other'] as $g)
                <option value="{{ $g }}" @selected(old('gender', $patient->gender ?? '') === $g)>{{ ucfirst($g) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label d-block">Blood Group</label>
        @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="blood_group" value="{{ $bg }}" id="bg_{{ $bg }}"
                    @checked(old('blood_group', $patient->blood_group ?? '') === $bg)>
                <label class="form-check-label" for="bg_{{ $bg }}">{{ $bg }}</label>
            </div>
        @endforeach
    </div>
    <div class="col-12 mb-3">
        <label class="form-label">Address</label>
        <textarea name="address" class="form-control" rows="2">{{ old('address', $patient->address ?? '') }}</textarea>
    </div>
</div>
