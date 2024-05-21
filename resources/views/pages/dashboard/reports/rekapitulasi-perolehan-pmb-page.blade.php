<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 pb-3">
            <nav class="flex">
                <ol class="inline-flex items-center space-x-2 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">
                            <i class="fa-solid fa-table-columns mr-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Rekap Perolehan PMB</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <section class="max-w-7xl px-5 mx-auto mt-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <a href="{{ route('dashboard.rekapitulasi_perolehan_pmb') }}"
                class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer p-5 rounded-3xl">
                <div class="space-y-1 z-10">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-database"></i>
                        <h2 class="font-bold">Perolehan PMB</h2>
                    </div>
                    <p class="text-xs">Berikut ini adalah menu dari rekapitulasi perolehan PMB yang tersedia di PMB.</p>
                </div>
                <i class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
            </a>
            @if (Auth::user()->role == 'A')
                <a href="{{ route('dashboard.rekapitulasi_register_program') }}"
                    class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer p-5 rounded-3xl">
                    <div class="space-y-1 z-10">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-book"></i>
                            <h2 class="font-bold">Tebaran Program Studi</h2>
                        </div>
                        <p class="text-xs">Berikut ini adalah data rekapitulasi dari tebaran program studi yang tersedia.</p>
                    </div>
                    <i class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
                </a>
            @endif

            @if (Auth::user()->role == 'A')
                <a href="{{ route('dashboard.rekapitulasi_register_source') }}"
                    class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer p-5 rounded-3xl">
                    <div class="space-y-1 z-10">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-server"></i>
                            <h2 class="font-bold">Sumber Register</h2>
                        </div>
                        <p class="text-xs">Berikut ini adalah rekapitulasi data register mahasiswa baru berdasarkan sumber data.</p>
                    </div>
                    <i class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
                </a>
            @endif

            @if (Auth::user()->role == 'A')
                <a href="{{ route('dashboard.rekapitulasi_register_school_year') }}"
                    class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer p-5 rounded-3xl">
                    <div class="space-y-1 z-10">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-school"></i>
                            <h2 class="font-bold">Register Per Sekolah</h2>
                        </div>
                        <p class="text-xs">Berikut ini adalah rekapitulasi data register mahasiswa baru berdasarkan sekolah.</p>
                    </div>
                    <i class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
                </a>
            @endif

            @if (Auth::user()->role == 'A')
                <a href="{{ route('dashboard.rekapitulasi_register_school') }}"
                    class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer p-5 rounded-3xl">
                    <div class="space-y-1 z-10">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-school"></i>
                            <h2 class="font-bold">Register Per Tingkat Sekolah</h2>
                        </div>
                        <p class="text-xs">Berikut ini adalah rekapitulasi data register mahasiswa baru berdasarkan tingkat sekolah.</p>
                    </div>
                    <i class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
                </a>
            @endif

            <a href="{{ route('dashboard.rekapitulasi_pencapaian_pmb') }}"
                class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer p-5 rounded-3xl">
                <div class="space-y-1 z-10">
                    <div class="flex items-center gap-2">
                        <i class="fa-regular fa-folder-open"></i>
                        <h2 class="font-bold">Rekapitulasi Pencapaian PMB</h2>
                    </div>
                    <p class="text-xs">Berikut ini adalah rekapitulasi pencapaian PMB dari target dan pendapatan presenter.</p>
                </div>
                <i class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
            </a>
        </div>
    </section>

</x-app-layout>
