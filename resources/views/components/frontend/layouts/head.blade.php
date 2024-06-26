@php
    $title = $attributes->get('title');
    $description = $attributes->get('description');
@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $description }}">
    <link rel="shortcut icon" href="{{ useImage(app('setting')->basic->favicon) }}">

    <title>{{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('libs/tail.select.js-1.0.2/css/tail.select.css') }}">
    @vite(['resources/css/tailwind.css'])
    <link rel="stylesheet" href="{{ asset('assets/css/preloader.css') }}">


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    {{-- App Css  --}}
    <link href="{{ asset('frontend/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style">
    {{-- bootstrap Css  --}}
    <link href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="app-style">
    {{-- icons css  --}}
    <link href="{{ asset('frontend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" id="app-style">
    {{-- Head JS  --}}
    <script src="{{ asset('frontend/assets/js/head.js') }}"></script>
    {{-- Color extractor for matching image color --}}
    <script src="{{ asset('frontend/extractColor.js') }}"></script>
    <!-- Scripts -->
    <script src="{{ asset('frontend/assets/jquery/jquery.min.js') }}"></script>
    {{-- <script src="{{ asset('libs/htmx/index.min.js') }}" defer></script> --}}
    <script src="https://unpkg.com/htmx.org@1.9.10"
        integrity="sha384-D1Kt99CQMDuVetoL1lrYwg5t+9QdHe7NLX/SoJYkXDFfX37iInKRy5xLSi8nO7UC" crossorigin="anonymous">
    </script>
    @vite(['resources/css/app.css', 'resources/scss/app.scss', 'resources/js/app.js'])
    @stack('customCss')
</head>
