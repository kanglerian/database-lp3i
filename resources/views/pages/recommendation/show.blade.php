@push('styles')
    <style>
        .js-example-input-single {
            display: flex;
            width: 100%!important;
        }

        .select2-selection {
            border-radius: 0.75rem !important;
            padding-top: 20px !important;
            padding-bottom: 20px !important;
            background: #f9fafb !important;
            border: 1px solid #d1d5db !important;
        }

        .select2-results__option {
            font-size: 14px !important;
        }

        #select2-school_id-container {
            position: absolute;
            top: 7px !important;
            font-size: 14px !important;
            left: 5px !important;
        }
        .select2-selection__arrow {
            position: absolute;
            top: 8px !important;
            right: 5px !important;
        }
    </style>
@endpush
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 pb-3">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Data Rekomendasi') }}
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
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <header class="space-y-4">
                <div class="bg-gray-50 p-5 border border-gray-200 rounded-3xl">
                    <ul class="text-gray-900 space-y-1">
                        <li>Nama lengkap: <span class="font-medium">{{ Auth::user()->name }}</span></li>
                        <li>Asal sekolah: <span class="font-medium">{{ $applicant->schoolapplicant->name }}</span></li>
                        <li>Presenter: <span class="font-medium">{{ $applicant->presenter->name }}</span></li>
                    </ul>
                </div>
                <p>Data teman yang direkomendasikan (ikut SNBT, Kedinasan, AKABRI, Akademi TNI, AKPOL):</p>
            </header>
            @if (count($recommendations) > 0)
                <button type="button" data-modal-target="statusModal" onclick="changeStatusModal(this)"
                    class="inline-block bg-lp3i-100 hover:bg-lp3i-200 text-white px-5 py-2 rounded-xl text-sm"
                >
                    <i class="fa-solid fa-plus mr-1"></i>
                    <span>Tambah</span>
                </button>
            @else
                <a href="{{ route('recommendation.create') }}" class="inline-block bg-lp3i-100 hover:bg-lp3i-200 text-white px-5 py-2 rounded-xl text-sm">
                    <i class="fa-solid fa-plus mr-1"></i>
                    <span>Tambah</span>
                </a>
            @endif
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                No
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama Lengkap
                            </th>
                            <th scope="col" class="px-6 py-3">
                                No. HP
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Asal Sekolah
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Kelas
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Tahun Lulus
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recommendations as $no => $recommendation)
                            <tr class="bg-white border-b">
                                <td class="px-6 py-4">
                                    {{ $no + 1 }}
                                </td>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $recommendation->name }}
                                </th>
                                <td class="px-6 py-4">
                                    <a target="_blank" href="https://wa.me/{{ $recommendation->phone }}" class="underline">{{ $recommendation->phone }}</a>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $recommendation->schoolapplicant->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $recommendation->class }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $recommendation->year }}
                                </td>
                                <td class="px-6 py-4">
                                    <button type="button" data-id="{{ $recommendation->id }}"
                                        data-modal-target="statusModal" data-name="{{ $recommendation->name }}"
                                        data-phone="{{ $recommendation->phone }}"
                                        data-school="{{ $recommendation->school_id }}"
                                        data-classes="{{ $recommendation->class }}"
                                        data-year="{{ $recommendation->year }}" onclick="editStatusModal(this)"
                                        class="bg-amber-500 hover:bg-amber-600 px-3 py-1 rounded-lg text-xs text-white"
                                    >
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center">Data belum tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
@include('pages.recommendation.modal.data');
