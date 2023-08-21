<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto+Mono&family=Source+Code+Pro:wght@400;600;700&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
</head>

<body class="antialiased">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center justify-center h-screen gap-5">
            <div class="w-full md:w-4/6 space-y-3 order-2 md:order-none">
                <h1 class="font-bold text-3xl">Pendaftaran Online Mahasiswa Baru</h1>
                <p>Silakan klik tombol daftar untuk berkonsultasi langsung dengan Education Consultant Politeknik LP3I
                    Kampus Tasikmalaya. Jika sudah memiliki akun, silakan pilih menu Masuk.</p>
                @if (Route::has('login'))
                    <div class="flex items-center gap-2">
                        @auth
                            <a href="{{ route('dashboard.index') }}" class="text-sm text-gray-700 underline">Dashboard</a>
                        @else
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="bg-red-500 hover:bg-red-600 px-5 py-2 rounded-lg text-white">Daftar</a>
                            @endif
                            <a href="{{ route('login') }}"
                                class="border border-gray-500 hover:border-gray-600 px-5 py-2 rounded-lg text-gray-800">Masuk</a>
                        @endauth
                    </div>
                @endif
            </div>
            <div class="w-full md:w-3/6 order-1 md:order-none">
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Inventore accusantium doloremque, ex
                perspiciatis dolorem ullam mollitia adipisci voluptate molestias neque. Deleniti non animi culpa
                exercitationem consequatur sunt tempora dicta eum sapiente alias delectus error eligendi atque,
                asperiores hic! Voluptate, explicabo? Non veniam ratione enim nemo labore, earum, quisquam odit commodi
                vitae totam vero, ullam velit doloribus eligendi nesciunt quo tenetur voluptatibus asperiores dolores.
                Similique repudiandae possimus reiciendis veniam at facilis, quia vero, nesciunt sunt ea provident
                soluta et corrupti ducimus quos eos explicabo quibusdam nisi repellat? Aliquam sit veniam, doloremque
                quos dignissimos eius distinctio, odio velit, pariatur corporis suscipit obcaecati?
            </div>
        </div>
    </div>
    <script src="{{ asset('js/all.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
</body>

</html>
