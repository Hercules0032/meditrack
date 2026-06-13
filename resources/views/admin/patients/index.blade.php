@extends('layouts.app')

@section('title', __('messages.patients'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>{{ __('messages.patients') }}</h2>
    <a href="{{ route('admin.patients.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Add Patient</a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-auto">
        <input type="text" name="search" class="form-control" placeholder="Search by name..." value="{{ $search }}">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-secondary">Search</button>
    </div>
</form>

<form method="POST" action="{{ route('admin.patients.bulk-delete') }}" id="bulk-form">
    @csrf
    <div class="mb-2">
        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete selected?')">Delete Selected</button>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $patient)
                    <tr>
                        <td><input type="checkbox" name="ids[]" value="{{ $patient->id }}" class="row-check"></td>
                        <td>{{ $patient->user->name }}</td>
                        <td>{{ $patient->user->email }}</td>
                        <td>{{ $patient->age }}</td>
                        <td>{{ $patient->phone }}</td>
                        <td>{{ ucfirst($patient->gender) }}</td>
                        <td>
                            <a href="{{ route('admin.patients.show', $patient) }}" class="btn btn-sm btn-outline-info">View</a>
                            <a href="{{ route('admin.patients.edit', $patient) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('admin.patients.destroy', $patient) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted">No patients found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</form>

{{ $patients->withQueryString()->links() }}
@endsection
