@extends('layouts.app')

@section('title', __('messages.dashboard'))

@section('content')
<h2 class="mb-4">{{ __('messages.dashboard') }} — Doctor</h2>
<div class="row">
    <x-stats-card title="Today" :value="$todayAppointments" icon="bi-calendar-day" color="primary" />
    <x-stats-card title="Pending" :value="$pendingAppointments" icon="bi-clock" color="warning" />
    <x-stats-card title="Patients" :value="$totalPatients" icon="bi-people" color="success" />
</div>
@endsection
