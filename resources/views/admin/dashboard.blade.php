@extends('layouts.app')

@section('title', __('messages.dashboard'))

@section('content')
<h2 class="mb-4">{{ __('messages.dashboard') }} — Admin</h2>
<div class="row">
    <x-stats-card :title="__('messages.patients')" :value="$totalPatients" icon="bi-people" color="primary" />
    <x-stats-card :title="__('messages.doctors')" :value="$totalDoctors" icon="bi-person-badge" color="success" />
    <x-stats-card :title="__('messages.appointments')" :value="$totalAppointments" icon="bi-calendar-check" color="info" />
    <x-stats-card title="Pending" :value="$pendingAppointments" icon="bi-clock" color="warning" />
</div>
@endsection
