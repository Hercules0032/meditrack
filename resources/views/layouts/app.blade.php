<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - @yield('title', __('messages.dashboard'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">{{ config('app.name') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item">
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('lang.switch', 'en') }}" class="btn btn-outline-light {{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
                            <a href="{{ route('lang.switch', 'bn') }}" class="btn btn-outline-light {{ app()->getLocale() === 'bn' ? 'active' : '' }}">BN</a>
                        </div>
                    </li>
                    @auth
                        <li class="nav-item">
                            <span class="navbar-text text-white">{{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</span>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-light btn-sm">{{ __('messages.logout') }}</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link text-white" href="{{ route('login') }}">{{ __('messages.login') }}</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="{{ route('register') }}">{{ __('messages.register') }}</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            @auth
                <div class="col-md-2 sidebar p-0">
                    @include('partials.sidebar')
                </div>
                <div class="col-md-10">
            @else
                <div class="col-12">
            @endauth
                    <main class="p-4">
                        @if(session('success'))
                            <x-alert-banner type="success" :message="session('success')" />
                        @endif
                        @if(session('error'))
                            <x-alert-banner type="error" :message="session('error')" />
                        @endif
                        @if(isset($errors) && $errors->any())
                            <x-alert-banner type="error" :message="$errors->first()" />
                        @endif

                        @yield('content')
                    </main>
                </div>
        </div>
    </div>

    <footer class="text-center text-muted py-3 border-top mt-4">
        <small>&copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('messages.welcome') }}</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
