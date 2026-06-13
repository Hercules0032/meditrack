@php
    $badgeClass = match($status) {
        'confirmed' => 'bg-success',
        'cancelled' => 'bg-danger',
        default => 'bg-warning text-dark',
    };
@endphp
<span class="badge {{ $badgeClass }}">{{ ucfirst($status) }}</span>
