@extends('layouts.app')

@section('title', 'New Appointment')

@section('content')
<h2 class="mb-4">Schedule Appointment</h2>
<form method="POST" action="{{ route('admin.appointments.store') }}">
    @csrf
    @include('admin.appointments._form')
    <button type="submit" class="btn btn-primary">Save</button>
</form>
@endsection
