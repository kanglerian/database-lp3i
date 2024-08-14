<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 pb-3">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('E-Assessment') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-5 md:p-0 space-y-5">

            @if (session('message'))
                <div id="alert" class="flex items-center p-4 mb-4 bg-emerald-500 text-emerald-50 rounded-2xl"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-reguler">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div id="alert" class="flex items-center p-4 mb-4 bg-red-500 text-red-50 rounded-xl"
                    role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-2 md:grid-cols-3 md:gap-3 px-4">
                <div class="bg-gray-50 px-6 py-5 rounded-3xl border border-gray-200">
                    <h2 class="font-bold text-xl text-gray-900 mb-2">SBPMB Online</h2>
                    <p class="text-sm text-gray-600">Berikut ini adalah halaman untuk menampilkan hasil tes beasiswa dan pengaturan lainnya terkait dengan tes online beasiswa.</p>
                    <a href="{{ route('scholarship.index') }}" class="inline-block cursor-pointer text-xs bg-lp3i-100 hover:bg-lp3i-200 text-white px-4 py-2 rounded-xl mt-3">Lihat selengkapnya <i class="fa-solid fa-arrow-right-long"></i></a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
