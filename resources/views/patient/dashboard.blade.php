@extends('layouts.app')

@section('title', __('messages.dashboard'))

@section('content')
<h2 class="mb-4">{{ __('messages.dashboard') }} — Patient</h2>
<div class="row">
    <x-stats-card title="Upcoming" :value="$upcomingAppointments" icon="bi-calendar-event" color="primary" />
    <x-stats-card :title="__('messages.reports')" :value="$totalReports" icon="bi-file-medical" color="info" />
    <x-stats-card title="Prescriptions" :value="$prescriptions" icon="bi-capsule" color="success" />
</div>
@endsection
