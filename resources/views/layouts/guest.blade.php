<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon/favicon.png') }}">
    <title>{{ config('app.name', 'Politeknik LP3I Kampus Tasikmalaya') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
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
    </style>

</head>

<body class="bg-opacity-10 bg-[url('/img/pattern.svg')] bg-no-repeat bg-center bg-cover">
    <div class="font-sans text-gray-900">
        {{ $slot }}
    </div>

    <div class="absolute bottom-0 right-0">
        <a href="https://politekniklp3i-tasikmalaya.ac.id/conflict-register"><lottie-player src="{{ asset('animations/whatsapp.json') }}" background="Transparent" speed="1"
            style="width: 100px; height: 100px" direction="1" mode="normal" loop autoplay></lottie-player>
        </a>
    </div>

    <script src="{{ asset('js/all.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('js/lottie.js') }}"></script>

    <script>
        let phoneInput = document.getElementById('phone');
        phoneInput.addEventListener('input', function() {
            let phone = phoneInput.value;

            if (phone.startsWith('62')) {
                // Biarkan jika sudah dimulai dengan '62'
            } else if (phone.startsWith('0')) {
                // Ubah '0' menjadi '62' jika dimulai dengan '0'
                phoneInput.value = '62' + phone.substring(1);
            } else {
                // Ubah angka selain '0' dan '62' menjadi '62'
                phoneInput.value = '62';
            }
        });
    </script>

</body>

</html>
