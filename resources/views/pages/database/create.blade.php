@push('styles')
    <link href="{{ asset('css/select2-input.css') }}" rel="stylesheet" />
@endpush
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center h-10">
            <nav class="flex">
                <ol class="inline-flex items-center space-x-2 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('database.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">
                            <i class="fa-solid fa-database mr-2"></i>
                            Database
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Tambah Calon Mahasiswa</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>
    <div class="py-10">
        {{-- Message --}}
        @include('pages.database.create.message')
        <form method="POST" action="{{ route('database.store') }}" id="formDatabase">
            @csrf
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <section class="grid md:grid-cols-2 gap-5">
                    @include('pages.database.create.information')
                    @include('pages.database.create.biodata')
                </section>
            </div>
        </form>
    </div>
</x-app-layout>
