<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script>
        window.App = {!! json_encode([
            'csrfTokens' => csrf_token(),
            'user' => Auth::user(),
            'signedIn'  => Auth::check()
        ]) !!};
    </script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/trix/0.11.2/trix.css" rel="stylesheet">
    <style>
        body{
            padding-bottom: 100px;
        }
        .level{
            display: flex;
            align-items: center;
        }
        .flex{
            flex: 1;
        }
        .ml-1{
            margin-left: 1em;
        }
        .mr-a{
            margin-right: auto;
        }
        [v-cloak] {
            display: none;
        }
        .ais-highlighted > em{
            background-color: yellow;
            font-style: normal;
        }
    </style>
    @yield('header');
</head>
<body dir="rtl">
    <div id="app">
      @include('layouts.nav')
        <flash message="{{ session('flash') }}"></flash>
        @yield('content')

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
