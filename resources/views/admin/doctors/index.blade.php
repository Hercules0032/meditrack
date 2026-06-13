@extends('layouts.app')

@section('title', __('messages.doctors'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>{{ __('messages.doctors') }}</h2>
    <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary">Add Doctor</a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-auto"><input type="text" name="search" class="form-control" placeholder="Search..." value="{{ $search }}"></div>
    <div class="col-auto"><button class="btn btn-outline-secondary">Search</button></div>
</form>

<form method="POST" action="{{ route('admin.doctors.bulk-delete') }}">
    @csrf
    <button type="submit" class="btn btn-danger btn-sm mb-2" onclick="return confirm('Delete selected?')">Delete Selected</button>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr><th><input type="checkbox" id="select-all"></th><th>Name</th><th>Specialization</th><th>License</th><th>Phone</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($doctors as $doctor)
                    <tr>
                        <td><input type="checkbox" name="ids[]" value="{{ $doctor->id }}" class="row-check"></td>
                        <td>{{ $doctor->user->name }}</td>
                        <td>{{ $doctor->specialization }}</td>
                        <td>{{ $doctor->license_number }}</td>
                        <td>{{ $doctor->phone }}</td>
                        <td>
                            <a href="{{ route('admin.doctors.show', $doctor) }}" class="btn btn-sm btn-outline-info">View</a>
                            <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" class="d-inline">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted">No doctors found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</form>
{{ $doctors->withQueryString()->links() }}
@endsection
