@props(['title', 'value', 'icon' => 'bi-bar-chart', 'color' => 'primary'])

<div class="col-md-3 mb-3">
    <div class="card border-0 shadow-sm stats-card">
        <div class="card-body d-flex align-items-center">
            <div class="rounded-circle bg-{{ $color }} bg-opacity-10 p-3 me-3">
                <i class="bi {{ $icon }} text-{{ $color }} fs-4"></i>
            </div>
            <div>
                <p class="text-muted mb-0 small">{{ $title }}</p>
                <h4 class="mb-0 fw-bold">{{ $value }}</h4>
            </div>
        </div>
    </div>
</div>
