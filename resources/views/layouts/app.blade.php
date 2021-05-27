<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield("title")</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @if(!request()->routeIs("login"))
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        body {
            background-color: rgb(181, 179, 179);
        }
    </style>
    @endif

    @livewireStyles
</head>
<body>
    <div id="app">
        @auth
            @yield("gelombang")
            <livewire:navbar/>
        @endauth

        <main class="py-4">
            @if(request()->routeIs("login"))
                @yield('content')
            @endif

            @auth
                {{$slot}}
            @endauth

            @auth
            @yield("gelombang_footer")
        @endauth
        </main>
    </div>

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js" data-turbolinks-eval="false"></script>
    
    @stack("scripts")
</body>
</html>
