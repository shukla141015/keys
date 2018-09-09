<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @isset($description)
    <meta name="description" content="{{ $description }}" />
    @endisset
    @isset($keywords)
    <meta name="keywords" content="{{ $keywords }}" />
    @endisset

    <link rel="canonical" href="{{ URL::current() }}" />

    <title>{{ $title }}</title>

    @stack('head')

    <link rel="icon" type="image/png" href="/favicon.png" />

    <link rel="stylesheet" type="text/css" href="{{ mix('css/main.css') }}" />

    @if(App::environment('production'))
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-85344990-4"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-85344990-4');
        </script>
    @endif

</head>
<body class="flex flex-col bg-grey-lightest min-h-screen">

    @if($showHeader ?? true)
        @include('layout.header')
    @endif


    <div id="app" class="container mx-auto px-2 flex-1">
        @yield('content')
    </div>


    @include('layout.footer')


    <script type="text/javascript" src="{{ mix('js/scripts.js') }}"></script>

    @stack('footer')

</body>
</html>
