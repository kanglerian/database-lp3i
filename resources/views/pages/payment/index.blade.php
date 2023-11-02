<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Pembayaran') }}
            </h2>
            <div class="flex flex-wrap justify-center items-center gap-2 px-2 text-gray-600">
                <a href="{{ route('enrollment.index') }}" class="text-sm text-gray-800 bg-gray-50 hover:bg-gray-100 cursor-pointer px-4 py-2 rounded-lg">
                    Pendaftaran
                </a>
                <a href="{{ route('registration.index') }}" class="text-sm text-gray-800 bg-gray-50 hover:bg-gray-100 cursor-pointer px-4 py-2 rounded-lg">
                    Registrasi
                </a>
            </div>
        </div>
    </x-slot>


    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-3 py-5">
        <p class="text-sm text-center text-gray-500">Mohon maaf, halaman ini sedang dalam perbaikan. Silahkan akses menu <a href="{{ route('enrollment.index') }}" class="underline">Pendaftaran</a> atau <a href="{{ route('registration.index') }}" class="underline">Registrasi</a></p>
    </div>
</x-app-layout>
