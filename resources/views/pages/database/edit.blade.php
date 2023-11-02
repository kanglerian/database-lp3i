@push('styles')
    <link href="{{ asset('css/select2-input.css') }}" rel="stylesheet" />
@endpush
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-3">
            <nav class="flex">
                <ol class="inline-flex items-center space-x-2 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('database.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">
                            <i class="fa-solid fa-database mr-2"></i>
                            Database
                        </a>
                    </li>
                    <li>
                      <div class="flex items-center">
                        <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                        <a href="{{ route('database.show', $applicant->identity) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-gray-800 md:ml-2">Profil Mahasiswa</a>
                      </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Edit Mahasiswa</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="flex flex-col md:flex-row items-center gap-2">
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
                <button onclick="saveChanges()"
                    class="text-white bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2 text-center"><i
                        class="fa-solid fa-floppy-disk mr-1"></i> Simpan perubahan</button>
            </div>
        </div>
    </x-slot>
    <div class="py-4">
        @include('pages.database.edit.message')
        <form action="{{ route('database.update', $applicant->id) }}" method="POST" id="formChanges">
            @csrf
            @method('PATCH')
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                @include('pages.database.edit.information')
                @include('pages.database.edit.biodata')

                <div class="flex flex-col md:flex-row items-start gap-5">
                    @include('pages.database.edit.father')
                    @include('pages.database.edit.mother')
                </div>

            </div>
        </form>
    </div>
</x-app-layout>
@push('scripts')
    <script src="{{ asset('js/api-notif.js') }}"></script>
@endpush
