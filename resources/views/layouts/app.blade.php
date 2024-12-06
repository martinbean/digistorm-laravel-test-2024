<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', config('app.name'))</title>
        @vite([
            'resources/css/app.css',
            'resources/js/app.js',
        ])
    </head>
    <body class="bg-slate-50">
        <div id="app">
            <header class="bg-sky-400 p-4" role="banner">
                <div class="container">
                    <div class="flex items-center">
                        <div class="mr-auto">
                            <a class="font-bold text-lg text-white hover:text-white/75" href="{{ url('/') }}">
                                {{ config('app.name', 'Digistorm test') }}
                            </a>
                        </div>
                        <div class="ml-auto">
                            <form action="{{ route('contacts.index') }}" id="search-form" method="get" role="search">
                                <fieldset class="flex">
                                    <input autocomplete="off" class="form-control border-white border-r-none inline-flex outline-white focus:outline-white rounded-r-none" id="search" minlength="2" name="search" placeholder="Enter search term" required type="search" value="{{ request()->query('search') }}">
                                    <button class="btn btn-light border-l-none inline-flex rounded-l-none" type="submit">{{ __('Search') }}</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            <main class="py-4" role="main">
                <div class="container">
                    @yield('content')
                </div>
            </main>
        </div>
    </body>
</html>
