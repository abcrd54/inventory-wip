<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | Inventory Roda 3</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">

    {{-- Google Font --}}
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap">

    {{-- Icons --}}
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

    {{-- Template CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">
</head>

<body>

{{-- Loader --}}
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>

<div class="auth-main">
    <div class="auth-wrapper v3">
        <div class="auth-form">
            <div class="auth-header">
                <a href="#">
                    <img src="{{ asset('assets/images/logo-dark.svg') }}" alt="logo">
                </a>
            </div>

            <div class="card my-5">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-end mb-4">
                        <h3 class="mb-0"><b>Login</b></h3>
                    </div>

                    {{-- ERROR MESSAGE --}}
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.process') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label class="form-label">Username / Email</label>
                            <input type="text" name="username" class="form-control"
                                   placeholder="Username" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control"
                                   placeholder="Password" required>
                        </div>

                        <div class="d-flex mt-1 justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input input-primary"
                                       type="checkbox" name="remember">
                                <label class="form-check-label text-muted">
                                    Keep me sign in
                                </label>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary">
                                Login
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            <div class="auth-footer row">
                <div class="col my-1">
                    <p class="m-0">© {{ date('Y') }} Inventory Roda 3</p>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- JS --}}
<script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
<script src="{{ asset('assets/js/pcoded.js') }}"></script>
<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>

<script>layout_change('light');</script>
<script>change_box_container('false');</script>
<script>layout_rtl_change('false');</script>
<script>preset_change("preset-1");</script>
<script>font_change("Public-Sans");</script>

</body>
</html>
