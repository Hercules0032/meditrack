@props(['type' => 'success', 'message'])

@php
    $classes = match($type) {
        'error' => 'alert-danger',
        'warning' => 'alert-warning',
        default => 'alert-success',
    };
@endphp

<div class="alert {{ $classes }} alert-dismissible fade show" role="alert">
    {{ $message }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
