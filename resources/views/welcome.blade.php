<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="welcome-page">
    <div class="container py-5 text-center">
        <h1 class="display-4 fw-bold text-primary">{{ config('app.name') }}</h1>
        <p class="lead text-muted">{{ __('messages.welcome') }} — Hospital & Clinic Management System</p>
        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">{{ __('messages.login') }}</a>
            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">{{ __('messages.register') }}</a>
        </div>
    </div>
</body>
</html>
