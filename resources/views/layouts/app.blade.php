<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Dashboard')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap">

    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">
</head>

<body data-pc-theme="light">

    {{-- Loader --}}
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- Header --}}
    @include('layouts.header')

    {{-- Content --}}
    <div class="pc-container">
        <div class="pc-content">
            @yield('content')
        </div>
    </div>

    {{-- Footer --}}
    @include('layouts.footer')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- JS -->
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.js') }}"></script>

    @stack('scripts')
</body>
</html>
