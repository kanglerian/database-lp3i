<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" />

    <style>
        .dataTables_length > label {
            font-size: 14px!important;
            color: #6b7280!important;
        }

        .dataTables_info, .paginate_button {
            font-size: 14px!important;
            color: #6b7280!important;
        }

        .dataTables_length > label > select {
            font-size: 14px!important;
            padding: 3px 20px 3px 15px !important;
            border-radius: 10px!important;
            margin: 5px!important;
        }
        .dataTables_filter > label {
            font-size: 14px!important;
        }
        .dataTables_filter > label > input {
            margin: 5px!important;
            border-radius: 10px!important;
        }
    </style>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <script src="{{ asset('js/all.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
</body>

</html>
