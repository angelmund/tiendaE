<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('DataTables/datatables.min.css') }}">
    <!-- jQuery -->
    {{--  <script src="{{ asset('DataTables/jQuery-3.7.0/jquery-3.7.0.min.js') }}"></script>  --}}

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('bootstrap-5.2.3-dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        crossorigin="anonymous">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-------- moment ---------->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    @yield('css')
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        {{--  @include('layouts.navigation')  --}}
        @include('layouts.header')

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}

            {{-- @include('layouts.modales') --}}
            {{--  @include('proyectos.edit')  --}}
        </main>
        @include('layouts.footer')
    </div>
   

    <!-- Bootstrap JS -->
    <script src="{{ asset('bootstrap-5.2.3-dist/js/bootstrap.min.js') }}"></script>
    <!-- SweetAlert2 JS -->
    <script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- DataTables JS -->
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    


    @yield('js')
</body>
<footer>
   
</footer>


</html>