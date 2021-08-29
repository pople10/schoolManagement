<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" type="image/png" href="{{ URL::asset('resources/images/Logoll.svg') }}"/>
        
        <!-- Icon -->
        <title> ENSAH  {{ ucwords(basename($_SERVER["REQUEST_URI"], '.php')) }}</title>

        
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <!-- CSS Bootstrap -->
        <link href="{{ URL::asset('resources/css/bootstrap.min.css') }}" rel="stylesheet">
        
        <!-- JSBootstrap -->
        <script src="{{ URL::asset('resources/js/bootstrap.min.js') }}"></script>
        
        <!-- CSS Semantic UI -->
        <link href="{{ URL::asset('resources/assets/semanticUI/semantic.css') }}" rel="stylesheet">
        
        <!-- JS Semantic UI -->
        <script href="{{ URL::asset('resources/assets/semanticUI/semantic.min.js') }}"></script>
        
        <!-- CSS Font Awesome -->
        <link href="{{ URL::asset('resources/assets/font-awesome/css/all.css') }}" rel="stylesheet">
        
        <!-- jQuery -->
        <script src="{{ URL::asset('resources/js/jQuery.js') }}"></script>
        
        <!-- DataTable -->
        <link href="{{ URL::asset('resources/assets/datatable/datatables.min.css') }}" rel="stylesheet">
        <script src="{{ URL::asset('resources/assets/datatable/datatables.min.js') }}"></script>
        
        <!--Alerts -->
        
            <!-- Sweet -->
        <script src="{{ URL::asset('resources/assets/alerts/sweet.js') }}"></script>
        
            <!-- Bootbox -->
        <script src="{{ URL::asset('resources/assets/alerts/bootbox.js') }}"></script>
        
            <!-- Toastr -->
        <link href="{{ URL::asset('resources/assets/alerts/toastr.css') }}" rel="stylesheet">
        <script src="{{ URL::asset('resources/assets/alerts/toastr.js') }}"></script>
        
         <!-- JS Globally -->
        <script src="{{URL::asset('resources/js/preglobal.js')}}"></script>
        
        <!-- Selectize CSS -->
        <link href="{{ URL::asset('resources/css/selectize.css') }}" rel="stylesheet">
        
        <!-- Selectize JS -->
        <script src="{{ URL::asset('resources/js/selectize.js') }}"></script>
        
        <!-- Video js CSS -->
        <link href="{{ URL::asset('resources/css/videojs.css') }}" rel="stylesheet">
        
        <!-- PDFOBJECT JS -->
        <script src="{{ URL::asset('resources/js/pdfobject.js') }}"></script>
        
        <!-- Uploader JS -->
        <script src="{{ URL::asset('resources/js/uploader.js') }}"></script>
        
        <!-- Chart JS -->
        <script src="{{ URL::asset('resources/js/chartjs.js') }}"></script>
        
        <!-- Material Icon CSS -->
        <link rel="stylesheet" href="{{ URL::asset('resources/css/materialicons.css') }}" />
        
        <!-- App Pure CSS -->
        <link rel="stylesheet" href="{{URL::asset('public/css/app.css')}}" />
        
        <!-- Main Pure CSS -->
        <link href="{{ URL::asset('css/main.css') }}" rel="stylesheet">
        <!-- -->
              
    </head>
    <body onload="loading()">
         <div class="loading-container">
             <div class="loaderCustom loading-centerize">Loading...</div>
         </div>
        