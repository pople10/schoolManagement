<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
        <title> ENSAH  {{ ucwords(basename($_SERVER["REQUEST_URI"], '.php')) }}</title>

        <!-- CSS Bootstrap -->
        <link href="{{ URL::asset('resources/css/bootstrap.min.css') }}" rel="stylesheet">
        
        <!-- JS Bootstrap -->
        <script src="{{ URL::asset('resources/js/bootstrap.js') }}"></script>
        
        <!-- CSS Semantic UI -->
        <link href="{{ URL::asset('resources/assets/semanticUI/semantic.min.css') }}" rel="stylesheet">
        
        <!-- JS Semantic UI -->
        <script href="{{ URL::asset('resources/assets/semanticUI/semantic.min.js') }}"></script>
        
        <!-- CSS Font Awesome -->
        <link href="{{ URL::asset('resources/css/font-awesome.css') }}" rel="stylesheet">
        
        <!-- jQuery -->
        <script src="{{ URL::asset('resources/js/jQuery.js') }}"></script>
        
        <!-- DataTable -->
        <link href="{{ URL::asset('resources/assets/datatable/datatables.min.css') }}" rel="stylesheet">
        <script src="{{ URL::asset('resources/assets/datatable/datatables.min.js') }}"></script>

    <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <link href="{{ URL::asset('css/main.css') }}?t={{ time() }}" rel="stylesheet">
        
        <!-- Trackiness CSS -->
        <link href="{{ URL::asset('css/trackiness.css') }}" rel="stylesheet">

</head>
<body>
    <div >

        <main >
            @yield('content')
        </main>
    </div>
</body>
</html>
