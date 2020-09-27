<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>{{ config('app.name', 'Laravel 7 Blog') }}</title>

        <!--  Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/blog.css') }}">
    </head>
    <body>
        <div id="app">
            <!-- Navigation -->
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">

                    <a class="navbar-brand" href="{{ route('home') }}">
                        {{ config('app.name', 'Laravel 7 Blog') }}
                    </a>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto"></ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">

                            <!-- Search form is enabled for every body -->
                            @include('partials.nav.search-form')
                            
                            @guest
                                <!-- Authentication Links -->
                                @include('partials.nav.auth-links')
                            @else
                                <!-- Logged In Controls -->
                                @include('partials.nav.logged-controls')
                            @endguest

                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Main App Content -->
            <main class="py-4">

                @error('searchTerm')
                    <div class="container alert alert-danger">{{ $message }}</div>
                @enderror

                @yield('content')
            </main>
        </div>
    </body>
</html>
