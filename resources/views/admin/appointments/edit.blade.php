@extends('layouts.app')

@section('title', 'Edit Appointment')

@section('content')
<h2 class="mb-4">Edit Appointment</h2>
<form method="POST" action="{{ route('admin.appointments.update', $appointment) }}">
    @csrf @method('PUT')
    @include('admin.appointments._form', ['appointment' => $appointment, 'edit' => true])
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
