<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $doctor->user->name ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $doctor->user->email ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Specialization</label>
        <input type="text" name="specialization" class="form-control" value="{{ old('specialization', $doctor->specialization ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">License Number</label>
        <input type="text" name="license_number" class="form-control" value="{{ old('license_number', $doctor->license_number ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $doctor->phone ?? '') }}" required>
    </div>
</div>
