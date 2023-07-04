<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-semibold text-md text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if (Auth::user()->status != 1)
                    <div class="p-6 bg-red-500 text-white">
                        <p><i class="fa-solid fa-lock mr-1"></i> Akun anda belum di aktifkan.</p>
                    </div>
                @else
                <div class="p-6 bg-white">
                    <p><i class="fa-regular fa-face-smile-beam mr-1"></i> Selamat datang, {{ Auth::user()->name }} </p>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
