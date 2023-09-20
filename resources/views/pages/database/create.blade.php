@push('styles')
    <link href="{{ asset('css/select2-input.css') }}" rel="stylesheet" />
@endpush
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight py-2">
                Tambah Database Baru
            </h2>
            <div class="flex items-center gap-2">
                <div class="flex items-center gap-2 border border-gray-200 px-3 py-1.5 rounded-lg">
                    <i class="fa-solid fa-map-location-dot text-gray-700"></i>
                    <span class="text-sm" id="wilayah"></span>
                </div>
                <div class="flex items-center gap-2 border border-gray-200 px-3 py-1.5 rounded-lg">
                    <i class="fa-solid fa-rectangle-list text-gray-700"></i>
                    <span class="text-sm">
                        @if ($programs == null)
                            <i class="fa-solid fa-wifi text-red-500"></i>
                        @else
                            <i class="fa-solid fa-wifi text-green-500"></i>
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </x-slot>
    <div class="py-4">
        {{-- Message --}}
        @include('pages.database.create.message')
        <form method="POST" action="{{ route('database.store') }}" id="formDatabase">
            @csrf
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('pages.database.create.information')
            @include('pages.database.create.biodata')
            </div>
        </form>
    </div>
</x-app-layout>
