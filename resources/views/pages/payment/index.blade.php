<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Pembayaran') }}
            </h2>
            <div class="flex flex-wrap justify-center items-center gap-2 px-2 text-gray-600">
                <a href="{{ route('enrollment.index') }}"
                    class="text-sm text-gray-800 bg-white hover:bg-gray-50 border border-gray-200 cursor-pointer px-4 py-2 rounded-xl">
                    Target
                </a>
                <a href="{{ route('enrollment.index') }}"
                    class="text-sm text-gray-800 bg-white hover:bg-gray-50 border border-gray-200 cursor-pointer px-4 py-2 rounded-xl">
                    Pendaftaran
                </a>
                <a href="{{ route('registration.index') }}"
                    class="text-sm text-gray-800 bg-white hover:bg-gray-50 border border-gray-200 cursor-pointer px-4 py-2 rounded-xl">
                    Registrasi
                </a>
            </div>
        </div>
    </x-slot>


    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-3 py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div class="p-6 bg-gray-50 border border-gray-200 rounded-3xl m-1">
                <h5 class="mb-2 text-md font-medium text-gray-500">Total Kas Pendaftaran</h5>
                <div class="flex items-baseline text-gray-900 mb-3">
                    <span class="text-xl font-semibold">Rp</span>
                    <span class="text-3xl text-gray-800 font-extrabold tracking-tight">
                        {{ number_format($cash, 0, ',', '.') }}
                    </span>
                </div>
                <p class="mb-3 font-normal text-xs text-gray-700">Berikut ini adalah informasi total kas pendaftaran.
                    Untuk selengkapnya klik tombol di bawah ini.</p>
                <a href="{{ route('enrollment.index') }}"
                    class="inline-flex items-center px-3 py-2 text-xs font-medium text-center text-white bg-lp3i-100 hover:bg-lp3i-200 rounded-xl hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    Lihat selengkapnya
                    <i class="fa-solid fa-arrow-right-long ml-2"></i>
                </a>
            </div>
            <div class="p-6 bg-gray-50 border border-gray-200 rounded-3xl m-1">
                <h5 class="mb-2 text-md font-medium text-gray-500">Total Registrasi Awal</h5>
                <div class="flex items-baseline text-gray-900 mb-3">
                    <span class="text-xl font-semibold">Rp</span>
                    <span class="text-3xl text-gray-800 font-extrabold tracking-tight">
                        {{ number_format($total, 0, ',', '.') }}
                    </span>
                </div>
                <p class="mb-3 font-normal text-xs text-gray-700">Berikut ini adalah informasi total registrasi awal.
                    Untuk selengkapnya klik tombol di bawah ini.</p>
                <a href="{{ route('registration.index') }}"
                    class="inline-flex items-center px-3 py-2 text-xs font-medium text-center text-white bg-lp3i-100 hover:bg-lp3i-200 rounded-xl hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    Lihat selengkapnya
                    <i class="fa-solid fa-arrow-right-long ml-2"></i>
                </a>
            </div>
            <div class="p-6 bg-gray-50 border border-gray-200 rounded-3xl m-1">
                <h5 class="mb-2 text-md font-medium text-gray-500">Total Potensi Omset</h5>
                <div class="flex items-baseline text-gray-900 mb-3">
                    <span class="text-xl font-semibold text-gray-900">Rp</span>
                    <span class="text-3xl text-gray-800 font-extrabold tracking-tight">
                        {{ number_format($turnover, 0, ',', '.') }}
                    </span>
                </div>
                <p class="mb-3 font-normal text-xs text-gray-700">Berikut ini adalah informasi total potensi omset.
                    Untuk selengkapnya klik tombol di bawah ini.</p>
                <a href="{{ route('registration.index') }}"
                    class="inline-flex items-center px-3 py-2 text-xs font-medium text-center text-white bg-lp3i-100 hover:bg-lp3i-200 rounded-xl hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    Lihat selengkapnya
                    <i class="fa-solid fa-arrow-right-long ml-2"></i>
                </a>
            </div>
        </div>
        <p class="text-sm text-center text-gray-500">Mohon maaf, halaman ini sedang dalam perbaikan. Silahkan akses menu
            <a href="{{ route('enrollment.index') }}" class="underline">Pendaftaran</a> atau <a
                href="{{ route('registration.index') }}" class="underline">Registrasi</a>.
        </p>
    </div>
</x-app-layout>
