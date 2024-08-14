<x-app-layout>
    @push('styles')
        <link href="{{ asset('css/select2-input.css') }}" rel="stylesheet" />
        <style>
            .js-example-input-single {
                width: 100%;
            }

            .select2-selection {
                border-radius: 0.75rem !important;
                padding-top: 22px !important;
                padding-bottom: 22px !important;
            }

            .select2-selection__rendered {
                top: -13px !important;
            }
        </style>
    @endpush
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 pb-3">
            <nav class="flex">
                <ol class="inline-flex items-center space-x-2 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('schools.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">
                            <i class="fa-solid fa-school mr-2"></i>
                            Sekolah
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Pengaturan</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

    </x-slot>

    <section class="space-y-5 py-5">

        <section class="max-w-7xl mx-auto">
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
                    <div class="ml-3 text-sm font-reguler">
                        {{ session('error') }}
                    </div>
                </div>
            @endif
        </section>

        <section class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between">
                <div class="w-full md:w-4/6 p-3">
                    <form action="{{ route('school.migration') }}" class="max-w-sm space-y-5" method="POST">
                        @csrf
                        <div>
                            <label for="school_from" class="block mb-2 text-sm font-medium text-gray-900">Sekolah
                                Asal</label>
                            <select id="school_from" name="school_from"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 js-example-input-one">
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}">{{ $school->nama }} (Jumlah: {{ $school->jumlah }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="school_to" class="block mb-2 text-sm font-medium text-gray-900">Sekolah
                                Tujuan</label>
                            <select id="school_to" name="school_to"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 js-example-input-two">
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}">{{ $school->nama }} (Jumlah: {{ $school->jumlah }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="text-white bg-sky-700 hover:bg-sky-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5">Migrasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

    </section>

    @push('scripts')
        <script src="{{ asset('js/indonesia.js') }}"></script>
        <script src="{{ asset('js/axios.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.js-example-input-one').select2({
                    placeholder: 'Pilih sekolah',
                });
                $('.js-example-input-two').select2({
                    placeholder: 'Pilih sekolah',
                });
            });
        </script>
    @endpush
</x-app-layout>
