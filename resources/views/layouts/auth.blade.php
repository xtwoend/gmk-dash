<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sign in') - {{ config('app.name') }}</title>
    
    <!-- CSS files -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* @import url('https://rsms.me/inter/inter.css'); */
        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }
        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body class="d-flex flex-column">
    <script src="{{ asset('node_modules/@tabler/core/dist/js/demo-theme.min.js') }}"></script>
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <a href="." class="navbar-brand navbar-brand-autodark">
                    <img src="{{ asset('img/icon.png') }}" height="36" alt="Tabler">
                </a>
            </div>
            @yield('content')
        </div>
    </div>
    
    <!-- Libs JS -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js" defer></script> --}}
</body>
</html>
