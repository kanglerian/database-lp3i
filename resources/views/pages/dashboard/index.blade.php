<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0 h-10">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                @if (Auth::user()->role == 'S' && Auth::user()->status == 0)
                    Registrasi Pembayaran
                @else
                    Dashboard
                @endif
            </h2>
            <div class="flex flex-wrap justify-center items-center gap-3 px-2 text-gray-600">
                @if (Auth::user()->status != 1)
                    <div class="px-6 py-2 rounded-lg bg-red-500 text-white text-sm">
                        <p><i class="fa-solid fa-lock mr-1"></i> Akun anda belum di aktifkan.</p>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>

    <section class="space-y-5 py-8">
        @if (Auth::user()->role == 'S')
            <div class="py-10">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-5 px-5 md:px-0">
                        <div class="w-full md:w-6/12 space-y-5 order-2 md:order-none">
                            <div class="space-y-1">
                                <h3 class="text-2xl font-bold text-gray-800">Silahkan untuk lakukan Transfer!</h3>
                                <p class="text-gray-700">Isi formulir pendaftaran dan raih kesempatan yang luar biasa di
                                    depan mata.</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 items-end">
                                <div class="space-y-3">
                                    <img src="{{ asset('logo/btn.png') }}" alt="Logo BTN" width="150px">
                                    <div onclick="copyRecord('0003401300001406')"
                                        class="cursor-pointer flex justify-between items-center border px-3 py-1 rounded-lg">
                                        <div class="space-y-1">
                                            <h1 class="font-bold text-sm text-gray-800">BANK BTN LP3I Tasikmalaya</h1>
                                            <p class="text-sm text-gray-700">0003401300001406</p>
                                        </div>
                                        <button onclick="copyRecord('0003401300001406')"><i
                                                class="fa-solid fa-clipboard text-gray-500 hover:text-blue-500"></i></button>
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <img src="{{ asset('logo/bsi.png') }}" alt="Logo BSI" width="150px">
                                    <div onclick="copyRecord('1025845605')"
                                        class="cursor-pointer flex justify-between items-center border px-3 py-1 rounded-lg">
                                        <div class="space-y-1">
                                            <h1 class="font-bold text-sm text-gray-800">BANK BSI (LPPPI TASIKMALAYA)
                                            </h1>
                                            <p class="text-sm text-gray-700">1025845605</p>
                                        </div>
                                        <button onclick="copyRecord('1025845605')"><i
                                                class="fa-solid fa-clipboard text-gray-500 hover:text-blue-500"></i></button>
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <img src="{{ asset('logo/bni.png') }}" alt="Logo BNI" width="150px">
                                    <div onclick="copyRecord('4549998888')"
                                        class="cursor-pointer flex justify-between items-center border px-3 py-1 rounded-lg">
                                        <div class="space-y-1">
                                            <h1 class="font-bold text-sm text-gray-800">BANK BNI (LP3I Tasikmalaya)</h1>
                                            <p class="text-sm text-gray-700">4549998888</p>
                                        </div>
                                        <button onclick="copyRecord('4549998888')"><i
                                                class="fa-solid fa-clipboard text-gray-500 hover:text-blue-500"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-5/12 order-1 md:order-none">
                            <img src="{{ asset('img/payment.svg') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @include('pages.dashboard.database.filter')
        @include('pages.dashboard.database.database')
        @include('pages.dashboard.database.scripts')

        <section class="max-w-7xl px-5 mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <a href="{{ route('dashboard.rekapitulasi_page') }}" class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer p-5 rounded-xl">
                    <div class="space-y-1 z-10">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-database"></i>
                            <h2 class="font-bold">Rekapitulasi Database</h2>
                        </div>
                        <p class="text-xs">Menu tampilkan jumlah data wilayah dan presenter secara lengkap.</p>
                    </div>
                    <i class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
                </a>
                <a href="{{ route('dashboard.perolehan_pmb_page') }}" class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer p-5 rounded-xl">
                    <div class="space-y-1 z-10">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-coins"></i>
                            <h2 class="font-bold">Rekap Perolehan PMB</h2>
                        </div>
                        <p class="text-xs">Menu ini menampilkan data kelengkapan persyaratan dari aplikan berdasarkan PMB.</p>
                    </div>
                    <i class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
                </a>
                <a href="{{ route('dashboard.history_page') }}" class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer p-5 rounded-xl">
                    <div class="space-y-1 z-10">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-comments"></i>
                            <h2 class="font-bold">Rekapitulasi Follow Up Presenter</h2>
                        </div>
                        <p class="text-xs">Menu ini menampilkan riwayat pesan berdasarkan presenter dengan rinci.</p>
                    </div>
                    <i class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
                </a>
                @if (Auth::user()->role == 'P')
                <a href="{{ route('dashboard.aplikan_page') }}" class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer p-5 rounded-xl">
                    <div class="space-y-1 z-10">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-users"></i>
                            <h2 class="font-bold">Rekap Data Aplikan</h2>
                        </div>
                        <p class="text-xs">Menu ini tampilkan data aplikan, daftar, dan registrasi secara lengkap.</p>
                    </div>
                    <i class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
                </a>
                @endif
                @if (Auth::user()->role == 'P')
                <a href="{{ route('dashboard.persyaratan_page') }}" class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer p-5 rounded-xl">
                    <div class="space-y-1 z-10">
                        <div class="flex items-center gap-2">
                            <i class="fa-regular fa-folder-open"></i>
                            <h2 class="font-bold">Rekapitulasi Data Persyaratan Aplikan</h2>
                        </div>
                        <p class="text-xs">Menu ini menampilkan data kelengkapan persyaratan dari aplikan berdasarkan PMB.</p>
                    </div>
                    <i class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
                </a>
                @endif
            </div>
        </section>

        @include('pages.dashboard.target.target')
        @include('pages.dashboard.search.search')


        @include('pages.dashboard.harta.database')
        @include('pages.dashboard.source.source')

    </section>
    @include('pages.dashboard.utilities.scripts')

</x-app-layout>
