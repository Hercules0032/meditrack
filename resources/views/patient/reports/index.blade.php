@extends('layouts.app')

@section('title', __('messages.reports'))

@section('content')
<h2 class="mb-4">{{ __('messages.reports') }}</h2>

<form method="POST" action="{{ route('patient.reports.store') }}" enctype="multipart/form-data" class="card card-body mb-4">
    @csrf
    <div class="mb-3">
        <label class="form-label">Upload Report (PDF, JPG, PNG — max 5MB)</label>
        <input type="file" name="report" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
    </div>
    <button type="submit" class="btn btn-primary">Upload</button>
</form>

<div class="table-responsive">
    <table class="table">
        <thead class="table-light"><tr><th>File</th><th>Uploaded</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($reports as $report)
                <tr>
                    <td><a href="{{ asset('storage/' . $report->file_path) }}" target="_blank">{{ $report->file_name }}</a></td>
                    <td>{{ $report->uploaded_at->format('M d, Y') }}</td>
                    <td>
                        <form action="{{ route('patient.reports.destroy', $report) }}" method="POST">@csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-muted text-center">No reports uploaded.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $reports->links() }}
@endsection
