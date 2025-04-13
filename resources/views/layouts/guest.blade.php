<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <style>
            .auth-wrapper {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem;
                background-color: #f8f9fa;
            }
            .auth-card {
                width: 100%;
                max-width: 420px;
                padding: 2rem;
                border-radius: 10px;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            }
            .logo-wrapper {
                text-align: center;
                margin-bottom: 2rem;
            }
            .logo-wrapper img {
                height: 60px;
            }
        </style>
    </head>
    <body>
        <div class="auth-wrapper">
            <div class="auth-card bg-white">
                <div class="logo-wrapper">
                    <a href="/" class="text-decoration-none">
                        <h1 class="text-success">Fruits & Veggies</h1>
                    </a>
                </div>

                @yield('content')
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Custom JS -->
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
