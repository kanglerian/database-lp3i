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

        @if (Auth::user()->role != 'S')
            <div class="max-w-7xl px-5 mx-auto">
                <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                    <div
                        class="flex justify-center items-end flex-wrap md:flex-nowrap text-gray-500 md:gap-3 order-2 md:order-none">
                        <input type="hidden" id="identity_val" value="{{ Auth::user()->identity }}">
                        <input type="hidden" id="role_val" value="{{ Auth::user()->role }}">
                        <div class="w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
                            <label for="change_pmb" class="text-xs">Periode PMB:</label>
                            <input type="number" id="change_pmb" onchange="changeTrigger()"
                                class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
                                placeholder="Tahun PMB">
                        </div>
                    </div>
                    <div class="px-4 py-2 rounded-xl text-sm bg-white border border-gray-100 order-1 md:order-none">
                        <div>
                            <span class="font-bold">{{ Auth::user()->name }}</span>
                            (<span onclick="copyIdentity('{{ Auth::user()->identity }}')">ID:
                                {{ Auth::user()->identity }}</span>)
                            <button onclick="copyIdentity('{{ Auth::user()->identity }}')" class="text-blue-500"><i
                                    class="fa-regular fa-copy"></i></button>
                        </div>
                        <span class="text-xs text-gray-600">Gunakan Key Identity ini di aplikasi Whatsapp
                            Sender.</span>
                    </div>
                </div>
            </div>

            @include('pages.dashboard.database.database')
            @include('pages.dashboard.database.scripts')

            @if ($slepets > 0)
                <section class="max-w-7xl px-5 mx-auto">
                    <div class="p-4 mb-4 text-red-800 border border-red-300 rounded-xl bg-red-50">
                        <div class="flex items-center">
                            <i class="fa-solid fa-circle-info mr-2"></i>
                            <span class="sr-only">Info</span>
                            <h3 class="text-lg font-medium">Lakukan Update Data Sekolah!</h3>
                        </div>
                        <div class="mt-2 mb-4 text-sm">
                            Dalam daftar ini, terdapat sekitar <span class="font-bold">{{ $slepets }}</span> entri
                            sekolah yang masih menunggu penyesuaian wilayah, status, dan jenisnya. Penting untuk
                            mengubahnya
                            agar laporan menjadi lebih akurat.
                        </div>
                        @if (Auth::user()->role == 'A')
                            <div class="flex">
                                <a href="{{ route('schools.index') }}"
                                    class="text-white bg-red-800 hover:bg-red-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 me-2 text-center inline-flex items-center">
                                    <i class="fa-solid fa-eye mr-2"></i>
                                    lihat selengkapnya
                                </a>
                            </div>
                        @else
                            <div class="flex">
                                <span
                                    class="text-white bg-red-800 hover:bg-red-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 me-2 text-center inline-flex items-center">
                                    Segera ubah data, hubungi Administrator.
                                </span>
                            </div>
                        @endif
                    </div>
                </section>
            @endif

            <section class="max-w-7xl px-5 mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <a href="{{ route('dashboard.rekapitulasi_database') }}"
                        class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer p-5 rounded-xl">
                        <div class="space-y-1 z-10">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-database"></i>
                                <h2 class="font-bold">Rekapitulasi Database</h2>
                            </div>
                            <p class="text-xs">Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis,
                                vitae.</p>
                        </div>
                        <i
                            class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
                    </a>
                    <a href="{{ route('dashboard.rekapitulasi_perolehan_pmb') }}"
                        class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer p-5 rounded-xl">
                        <div class="space-y-1 z-10">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-coins"></i>
                                <h2 class="font-bold">Rekap Perolehan PMB</h2>
                            </div>
                            <p class="text-xs">Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis,
                                vitae.</p>
                        </div>
                        <i
                            class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
                    </a>
                    <a href="{{ route('dashboard.rekapitulasi_history') }}"
                        class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer p-5 rounded-xl">
                        <div class="space-y-1 z-10">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-comments"></i>
                                <h2 class="font-bold">Rekapitulasi Follow Up Presenter</h2>
                            </div>
                            <p class="text-xs">Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis,
                                vitae.</p>
                        </div>
                        <i
                            class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
                    </a>
                    @if (Auth::user()->role !== 'S')
                        <a href="{{ route('dashboard.rekapitulasi_register_program') }}"
                            class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer p-5 rounded-xl">
                            <div class="space-y-1 z-10">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-book"></i>
                                    <h2 class="font-bold">Rekapitulasi Tebaran Program Studi</h2>
                                </div>
                                <p class="text-xs">Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis,
                                    vitae.</p>
                            </div>
                            <i
                                class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
                        </a>
                    @endif
                    @if (Auth::user()->role == 'P')
                        <a href="{{ route('dashboard.rekapitulasi_aplikan') }}"
                            class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer p-5 rounded-xl">
                            <div class="space-y-1 z-10">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-users"></i>
                                    <h2 class="font-bold">Rekap Data Aplikan</h2>
                                </div>
                                <p class="text-xs">Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis,
                                    vitae.</p>
                            </div>
                            <i
                                class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
                        </a>
                    @endif

                    @if (Auth::user()->role == 'P')
                        <a href="{{ route('dashboard.rekapitulasi_persyaratan') }}"
                            class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer p-5 rounded-xl">
                            <div class="space-y-1 z-10">
                                <div class="flex items-center gap-2">
                                    <i class="fa-regular fa-folder-open"></i>
                                    <h2 class="font-bold">Rekapitulasi Data Persyaratan Aplikan</h2>
                                </div>
                                <p class="text-xs">Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis,
                                    vitae.</p>
                            </div>
                            <i
                                class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
                        </a>
                    @endif

                    @if (Auth::user()->role == 'P')
                        <a href="{{ route('dashboard.rekapitulasi_register_school') }}"
                            class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer p-5 rounded-xl">
                            <div class="space-y-1 z-10">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-users"></i>
                                    <h2 class="font-bold">Rekap Data Aplikan Register</h2>
                                </div>
                                <p class="text-xs">Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis,
                                    vitae.</p>
                            </div>
                            <i
                                class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
                        </a>
                    @endif

                    <a href="{{ route('dashboard.rekapitulasi_register_source') }}"
                        class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer p-5 rounded-xl">
                        <div class="space-y-1 z-10">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-server"></i>
                                <h2 class="font-bold">Rekapitulasi Data Aplikan Register Sumber</h2>
                            </div>
                            <p class="text-xs">Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis,
                                vitae.</p>
                        </div>
                        <i
                            class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
                    </a>

                    <a href="{{ route('dashboard.rekapitulasi_register_school_year') }}"
                        class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer p-5 rounded-xl">
                        <div class="space-y-1 z-10">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-server"></i>
                                <h2 class="font-bold">Rekapitulasi Data Aplikan Register Sumber</h2>
                            </div>
                            <p class="text-xs">Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis,
                                vitae.</p>
                        </div>
                        <i
                            class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
                    </a>
                </div>
            </section>


            @include('pages.dashboard.utilities.all')
            @include('pages.dashboard.utilities.pmb')

            @include('pages.dashboard.target.target')
            @include('pages.dashboard.search.search')

            @include('pages.dashboard.harta.database')
            @include('pages.dashboard.source.source')
        @endif

    </section>
</x-app-layout>
