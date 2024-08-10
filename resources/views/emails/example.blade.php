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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&family=Source+Code+Pro:wght@400;600;700&display=swap"
        rel="stylesheet">

</head>

<body class="bg-gray-50">
    <div class="bg-red-500">
        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptatem aperiam voluptatibus vel esse, sunt praesentium sequi consectetur repudiandae corporis porro nihil suscipit odit soluta sit accusamus consequuntur delectus aliquam corrupti? Dolore, alias ad fugiat facilis aperiam id delectus dolorum incidunt consectetur pariatur illum reiciendis aspernatur, sapiente corporis quo repellendus nulla laboriosam! Odit fugiat earum delectus fuga consectetur dolorem! Corporis praesentium in ab, similique iste id explicabo, molestias quibusdam dolorem accusamus sed itaque velit necessitatibus culpa tempora sint rerum maiores asperiores quam aliquam temporibus reiciendis dignissimos unde! Tempora tenetur perspiciatis magnam omnis excepturi nam tempore, repellat velit natus, dignissimos, iusto quasi?</p>
    </div>
</body>

</html>
