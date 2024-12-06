<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Digistorm test') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    @vite('resources/css/app.css')
</head>
<body>
    <div id="app">
        <header role="banner">
            <div>
                <a href="{{ url('/') }}">
                    {{ config('app.name', 'Digistorm test') }}
                </a>
            </div>
        </header>

        <form action="{{ route('contacts.index') }}" id="search-form" method="get" role="search">
            <fieldset>
                <input autocomplete="off" id="search" minlength="2" name="search" placeholder="Enter search term" required type="search" value="{{ request()->query('search') }}">
                <button type="submit">{{ __('Search') }}</button>
                @if(request()->query('search'))
                    <a href="{{ route('contacts.index') }}">{{ __('Clear') }}</a>
                @endif
            </fieldset>
        </form>

        <main class="py-4" role="main">
            @yield('content')
        </main>
    </div>
</body>
</html>
