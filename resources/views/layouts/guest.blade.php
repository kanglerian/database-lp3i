<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon/favicon.png') }}">
    <title>{{ config('app.name', 'Politeknik LP3I Kampus Tasikmalaya') }}</title>

    <!-- Fonts -->
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto+Mono&family=Source+Code+Pro:wght@400;600;700&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <style>
        body {
            font-family: 'Roboto Mono', monospace;
            font-family: 'Source Code Pro', monospace;
        }
        .js-example-input-single {
            width: 100%;
        }
        .select2-selection {
            border-radius: 0.75rem!important;
            padding-top: 22px!important;
            padding-bottom: 22px!important;
        }
        .select2-selection__rendered {
            top: -13px!important;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-gray-50">
    <div class="font-sans text-gray-900">
        {{ $slot }}
    </div>

    <div class="fixed bottom-0 right-0">
        <a href="https://politekniklp3i-tasikmalaya.ac.id/conflict-register"><lottie-player
                src="{{ asset('animations/whatsapp.json') }}" background="Transparent" speed="1"
                style="width: 100px; height: 100px" direction="1" mode="normal" loop autoplay></lottie-player>
        </a>
    </div>

    <script src="{{ asset('js/all.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('js/lottie.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    @stack('scripts')
</body>

</html>
