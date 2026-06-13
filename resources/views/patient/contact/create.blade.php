@extends('layouts.app')

@section('title', __('messages.contact_admin'))

@section('content')
<h2 class="mb-4">{{ __('messages.contact_admin') }}</h2>
<form method="POST" action="{{ route('patient.contact.store') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">Subject</label>
        <input type="text" name="subject" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Message</label>
        <textarea name="message" class="form-control" rows="5" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Send Message</button>
</form>
@endsection
