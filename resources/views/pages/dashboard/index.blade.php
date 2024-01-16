<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
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
        @include('pages.dashboard.target.target')
        @include('pages.dashboard.search.search')

        <div class="max-w-7xl px-5 mx-auto">
            <section class="bg-white p-5 md:rounded-xl border border-gray-100 space-y-5">
                <header class="space-y-1">
                    <h2 class="font-bold text-xl text-gray-800">Data Aplikan</h2>
                    <p class="text-sm text-gray-700 text-sm">
                        Berikut ini adalah hasil perhitungan dari riwayat pesan.
                    </p>
                </header>
                <hr>
                @include('pages.dashboard.presenter.data.aplikan')
            </section>
        </div>

        <div class="max-w-7xl px-5 mx-auto">
            <section class="bg-white p-5 md:rounded-xl border border-gray-100 space-y-5">
                <header class="space-y-1">
                    <h2 class="font-bold text-xl text-gray-800">Rekapitulasi Sumber Database</h2>
                    <p class="text-sm text-gray-700 text-sm">
                        Berikut ini adalah hasil perhitungan dari riwayat pesan.
                    </p>
                </header>
                <hr>
                @if (Auth::user()->role == 'P')
                    @include('pages.dashboard.presenter.report.sourcedatabasebywilayah')
                @endif
                @if (Auth::user()->role == 'A' || Auth::user()->role == 'K')
                    @include('pages.dashboard.admin.report.sourcedatabasebypresenter')
                @endif
                @if (Auth::user()->role == 'A' || Auth::user()->role == 'K')
                    @include('pages.dashboard.admin.report.wilayahdatabasebypresenter')
                @endif
            </section>
        </div>

        @include('pages.dashboard.database.history')
        @include('pages.dashboard.harta.database')
        @include('pages.dashboard.source.source')

    </section>
    @include('pages.dashboard.utilities.scripts')

</x-app-layout>
