<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fontss -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto+Mono&family=Source+Code+Pro:wght@400;600;700&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="bg-gray-50">
    <div class="container mx-auto px-4">
        <nav class="flex flex-col md:flex-row items-center justify-between py-3 gap-5">
            <div class="flex items-center gap-5">
                <img src="{{ asset('img/lp3i-logo.svg') }}" alt="" class="w-48">
                <img src="{{ asset('logo/logo-kampusglobalmandiri.png') }}" alt="" class="w-36">
            </div>
            <ul class="flex items-center text-sm gap-5">
                <li class="font-bold text-gray-800">Beranda</li>
                <li class="text-gray-700 hover:text-gray-800">
                    <a href="https://brosur.politekniklp3i-tasikmalaya.ac.id" target="_blank">Brosur Digital</a>
                </li>
                <li class="text-gray-700 hover:text-gray-800">
                    <a href="https://virtualkampus.politekniklp3i-tasikmalaya.ac.id" target="_blank">Virtual Kampus</a>
                </li>
                <li>
                    @if (Route::has('login'))
                        <div class="flex items-center gap-2">
                            @auth
                                <a href="{{ route('dashboard.index') }}"
                                    class="border border-gray-200 hover:bg-gray-100  px-3 py-1 rounded-lg text-sm text-gray-700 space-x-1">
                                    <i class="fa-solid fa-circle-user"></i>
                                    <span>{{ Auth::user()->name }}</span>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="flex items-center justify-center rounded-full border border-gray-200 hover:bg-gray-100 h-10 w-10 text-gray-600">
                                    <i class="fa-solid fa-right-to-bracket"></i>
                                </a>
                            @endauth
                        </div>
                    @endif
                </li>
            </ul>
        </nav>
        <div class="flex flex-col md:flex-row items-center justify-center py-10">
            <div class="w-full md:w-4/6 space-y-3 text-center md:text-left">
                <h1 class="font-bold text-2xl md:text-4xl">Pendaftaran Online Mahasiswa Baru</h1>
                <p class="text-gray-700">Kami menyambut Anda untuk mengakses layanan pendaftaran kami. Untuk mendapatkan informasi terkait persyaratan, upload berkas, dan berbagai informasi lainnya, silakan masuk ke akun Anda. Jika Anda belum memiliki akun, jangan ragu untuk menggunakan tombol "Daftar" di bawah ini untuk mendaftar sebagai calon mahasiswa baru di LP3I. Kami siap membantu Anda memulai langkah menuju kesuksesan akademik.</p>
                @if (Route::has('login'))
                    <div class="flex justify-center md:justify-start items-center gap-2">
                        @auth
                            <a href="{{ route('dashboard.index') }}"
                            class="bg-lp3i-100 hover:bg-lp3i-200 px-6 py-2 rounded-xl text-white">Dashboard</a>
                        @else
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="bg-lp3i-100 hover:bg-lp3i-200 px-6 py-2 rounded-xl text-white">Daftar Sekarang</a>
                            @endif
                            <a href="{{ route('login') }}"
                                class="border border-gray-300 hover:border-gray-200 bg-white hover:bg-gray-200 hover:text-gray-800 px-6 py-2 rounded-xl text-gray-600">Masuk</a>
                        @endauth
                    </div>
                @endif
            </div>
            <div class="w-full md:w-3/6">
                <div class="flex items-center justify-center">
                    <lottie-player src="{{ asset('animations/lp3i.json') }}" background="Transparent" speed="1"
                        style="width: 500px; height: 500px" direction="1" mode="normal" loop autoplay></lottie-player>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 py-10">
            <div class="w-full p-1">
                <div class="bg-gray-50 border border-gray-200 rounded-3xl px-4 py-4 space-y-1 text-center">
                    <h4 class="font-bold text-gray-800">Dibantu Penempatan Kerja</h4>
                    <p class="text-sm text-gray-700">Pendidikan keterampilan dengan dukungan penempatan kerja untuk kesuksesan profesional.</p>
                </div>
            </div>
            <div class="w-full p-1">
                <div class="bg-gray-50 border border-gray-200 rounded-3xl px-4 py-4 space-y-1 text-center">
                    <h4 class="font-bold text-gray-800">Keterampilan Berbasis Keahlian</h4>
                    <p class="text-sm text-gray-700">Pengembangan praktis melalui pendidikan keterampilan berbasis keahlian yang mendalam.</p>
                </div>
            </div>
            <div class="w-full p-1">
                <div class="bg-gray-50 border border-gray-200 rounded-3xl px-4 py-4 space-y-1 text-center">
                    <h4 class="font-bold text-gray-800">Relasi Perusahaan > 100</h4>
                    <p class="text-sm text-gray-700">Jaringan luas 100+ perusahaan untuk penempatan kerja terbaik dan peluang karir yang bertumbuh.</p>
                </div>
            </div>
            <div class="w-full p-1">
                <div class="bg-gray-50 border border-gray-200 rounded-3xl px-4 py-4 space-y-1 text-center">
                    <h4 class="font-bold text-gray-800">Hard Skill & Soft Skill</h4>
                    <p class="text-sm text-gray-700">LP3I fokus mengembangkan hardskill dan softskill bagi kesuksesan dan keseimbangan karir Anda.</p>
                </div>
            </div>
        </div>
        <hr>
        <footer class="text-center py-3">
            <p class="text-xs text-gray-600">Copyright © <span id="copyright-year">2023</span> Politeknik LP3I Kampus Tasikmalaya</p>
        </footer>
    </div>
    <script src="{{ asset('js/all.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('js/lottie.js') }}"></script>
    <script>
        const getYear = () => {
            const now = new Date();
            const currentYear = now.getFullYear();
            document.getElementById('copyright-year').innerText = currentYear;
        }
        getYear();
    </script>
</body>

</html>
