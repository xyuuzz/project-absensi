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

        body {
            background-color: rgb(181, 179, 179);
        }
        @media only screen and (max-width: 576px){
            .float-smm-left {
                float: left;
            }
            .mt-smm-1 {
                margin-top: 10px;
            }
            .d-smm-block {
                display: block;
            }
            .mb-smm-5 {
                margin-bottom: 60px;
            }
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
            @if(request()->routeIs("login") || request()->routeIs("register"))
                @yield('content')
            @endif

            @if(request()->routeIs("register_student") || request()->routeIs("register_teacher") || Auth::check())
                {{$slot}}
            @endif
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
