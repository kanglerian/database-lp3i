<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 pb-3">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Pengaturan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('message'))
                <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-2xl"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-reguler">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Source --}}
                <div class="space-y-5">
                    <div class="px-2">
                        <button type="button" data-modal-target="sourceModal" onclick="changeSourceModal(this)"
                            class="bg-lp3i-100 hover:bg-lp3i-200 px-3 py-2 text-sm rounded-xl text-white">
                            <i class="fa-solid fa-circle-plus"></i> Tambah Data</button>
                    </div>
                    <div class="bg-white overflow-y-auto h-80 border rounded-3xl">
                        <div class="p-8 bg-white border-b border-gray-200">
                            <h2 class="font-bold text-lg mb-5">Sumber Database</h2>
                            <div class="relative overflow-x-auto md:rounded-xl">
                                <table class="w-full text-sm text-sm text-left text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 rounded-t-lg">
                                                No
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Nama
                                            </th>
                                            <th scope="col" class="px-6 py-3 rounded-t-lg">
                                                Action
                                            </th>
                                    </thead>
                                    <tbody>
                                        @forelse ($sources as $no => $source)
                                            <tr class="bg-white border-b">
                                                <th class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap">
                                                    {{ $no + 1 }}
                                                </th>
                                                <td class="px-6 py-3">
                                                    {{ $source->name }}
                                                </td>
                                                <td class="flex gap-1 items-center px-6 py-3">
                                                    <button type="button" data-id="{{ $source->id }}"
                                                        data-modal-target="sourceModal" data-name="{{ $source->name }}"
                                                        onclick="editSourceModal(this)"
                                                        class="bg-amber-500 hover:bg-amber-600 px-3 py-1 rounded-lg text-xs text-white">
                                                        <i class="fa-solid fa-edit"></i>
                                                    </button>
                                                    <button type="button" data-id="{{ $source->id }}"
                                                        onclick="deleteSource(this)"
                                                        class="md:mt-0 inline-block bg-red-500 hover:bg-red-600 px-3 py-1 rounded-lg text-xs text-white">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="bg-white border-b">
                                                <td class="px-6 py-3 text-center" colspan="3">Data sumber belum ada.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Data Upload --}}
                <div class="space-y-5">
                    <div class="px-2">
                        <button type="button" data-modal-target="fileModal" onclick="changeFileModal(this)"
                            class="bg-lp3i-100 hover:bg-lp3i-200 px-3 py-2 text-sm rounded-xl text-white">
                            <i class="fa-solid fa-circle-plus"></i> Tambah Data</button>
                    </div>
                    <div class="bg-white overflow-y-auto h-80 border rounded-3xl">
                        <div class="p-8 bg-white border-b border-gray-200">
                            <h2 class="font-bold text-lg mb-5">Data File Upload</h2>
                            <div class="relative overflow-x-auto md:rounded-xl">
                                <table class="w-full text-sm text-sm text-left text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 rounded-t-lg">
                                                No
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Nama
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Accept
                                            </th>
                                            <th scope="col" class="px-6 py-3 rounded-t-lg">
                                                Action
                                            </th>
                                    </thead>
                                    <tbody>
                                        @forelse ($files as $no => $file)
                                            <tr class="bg-white border-b">
                                                <th class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap">
                                                    {{ $no + 1 }}
                                                </th>
                                                <td class="px-6 py-3">
                                                    {{ $file->name }}
                                                </td>
                                                <td class="px-6 py-3">
                                                    {{ $file->accept }}
                                                </td>
                                                <td class="flex gap-1 items-center px-6 py-3">
                                                    <button type="button" data-id="{{ $file->id }}"
                                                        data-modal-target="fileModal" data-name="{{ $file->name }}" data-accept="{{ $file->accept }}"
                                                        onclick="editFileModal(this)"
                                                        class="bg-amber-500 hover:bg-amber-600 px-3 py-1 rounded-lg text-xs text-white">
                                                        <i class="fa-solid fa-edit"></i>
                                                    </button>
                                                    <button type="button" data-id="{{ $file->id }}"
                                                        onclick="deleteFile(this)"
                                                        class="md:mt-0 inline-block bg-red-500 hover:bg-red-600 px-3 py-1 rounded-lg text-xs text-white">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="bg-white border-b">
                                                <td class="px-6 py-3 text-center" colspan="4">Data sumber belum ada.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Status --}}
                <div class="space-y-5">
                    <div class="px-2">
                        <button type="button" data-modal-target="statusModal" onclick="changeStatusModal(this)"
                            class="bg-lp3i-100 hover:bg-lp3i-200 px-3 py-2 text-sm rounded-xl text-white">
                            <i class="fa-solid fa-circle-plus"></i> Tambah Data</button>
                    </div>
                    <div class="bg-white overflow-y-auto h-80 border rounded-3xl">
                        <div class="p-8 bg-white border-b border-gray-200">
                            <h2 class="font-bold text-lg mb-5">Status Aplikan</h2>
                            <div class="relative overflow-x-auto md:rounded-xl">
                                <table class="w-full text-sm text-sm text-left text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 rounded-t-lg">
                                                No
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Nama
                                            </th>
                                            <th scope="col" class="px-6 py-3 rounded-t-lg">
                                                Action
                                            </th>
                                    </thead>
                                    <tbody>
                                        @forelse ($statuses as $no => $status)
                                            <tr class="bg-white border-b">
                                                <th class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap">
                                                    {{ $no + 1 }}
                                                </th>
                                                <td class="px-6 py-3">
                                                    {{ $status->name }}
                                                </td>
                                                <td class="flex gap-1 items-center px-6 py-3">
                                                    <button type="button" data-id="{{ $status->id }}"
                                                        data-modal-target="statusModal" data-name="{{ $status->name }}"
                                                        onclick="editStatusModal(this)"
                                                        class="bg-amber-500 hover:bg-amber-600 px-3 py-1 rounded-lg text-xs text-white">
                                                        <i class="fa-solid fa-edit"></i>
                                                    </button>
                                                    <button type="button" data-id="{{ $status->id }}"
                                                        onclick="deleteStatus(this)"
                                                        class="md:mt-0 inline-block bg-red-500 hover:bg-red-600 px-3 py-1 rounded-lg text-xs text-white">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="bg-white border-b">
                                                <td class="px-6 py-3 text-center" colspan="4">Data status belum ada.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Program Type --}}
                <div class="space-y-5">
                    <div class="px-2">
                        <button type="button" data-modal-target="programTypeModal" onclick="changeProgramTypeModal(this)"
                            class="bg-lp3i-100 hover:bg-lp3i-200 px-3 py-2 text-sm rounded-xl text-white">
                            <i class="fa-solid fa-circle-plus"></i> Tambah Data</button>
                    </div>
                    <div class="bg-white overflow-y-auto h-80 border rounded-3xl">
                        <div class="p-8 bg-white border-b border-gray-200">
                            <h2 class="font-bold text-lg mb-5">Tipe Program</h2>
                            <div class="relative overflow-x-auto md:rounded-xl">
                                <table class="w-full text-sm text-sm text-left text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 rounded-t-lg">
                                                No
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Nama
                                            </th>
                                            <th scope="col" class="px-6 py-3 rounded-t-lg">
                                                Action
                                            </th>
                                    </thead>
                                    <tbody>
                                        @forelse ($programtypes as $no => $programtype)
                                            <tr class="bg-white border-b">
                                                <th class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap">
                                                    {{ $no + 1 }}
                                                </th>
                                                <td class="px-6 py-3">
                                                    {{ $programtype->name }}
                                                </td>
                                                <td class="flex gap-1 items-center px-6 py-3">
                                                    <button type="button" data-id="{{ $programtype->id }}"
                                                        data-modal-target="programTypeModal" data-name="{{ $programtype->name }}"
                                                        onclick="editProgramTypeModal(this)"
                                                        class="bg-amber-500 hover:bg-amber-600 px-3 py-1 rounded-lg text-xs text-white">
                                                        <i class="fa-solid fa-edit"></i>
                                                    </button>
                                                    <button type="button" data-id="{{ $programtype->id }}"
                                                        onclick="deleteProgramType(this)"
                                                        class="md:mt-0 inline-block bg-red-500 hover:bg-red-600 px-3 py-1 rounded-lg text-xs text-white">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="bg-white border-b">
                                                <td class="px-6 py-3 text-center" colspan="4">Data tipe program belum ada.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Follow Up --}}
                <div class="space-y-5">
                    <div class="px-2">
                        <button type="button" data-modal-target="followModal" onclick="changeFollowModal(this)"
                            class="bg-lp3i-100 hover:bg-lp3i-200 px-3 py-2 text-sm rounded-xl text-white">
                            <i class="fa-solid fa-circle-plus"></i> Tambah Data</button>
                    </div>
                    <div class="bg-white overflow-y-auto h-80 border rounded-3xl">
                        <div class="p-8 bg-white border-b border-gray-200">
                            <h2 class="font-bold text-lg mb-5">Daftar Follow Up</h2>
                            <div class="relative overflow-x-auto md:rounded-xl">
                                <table class="w-full text-sm text-sm text-left text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 rounded-t-lg">
                                                No
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Nama
                                            </th>
                                            <th scope="col" class="px-6 py-3 rounded-t-lg">
                                                Action
                                            </th>
                                    </thead>
                                    <tbody>
                                        @forelse ($follows as $no => $follow)
                                            <tr class="bg-white border-b">
                                                <th class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap">
                                                    {{ $no + 1 }}
                                                </th>
                                                <td class="px-6 py-3">
                                                    {{ $follow->name }}
                                                </td>
                                                <td class="flex gap-1 items-center px-6 py-3">
                                                    <button type="button" data-id="{{ $follow->id }}"
                                                        data-modal-target="followModal" data-name="{{ $follow->name }}"
                                                        onclick="editFollowModal(this)"
                                                        class="bg-amber-500 hover:bg-amber-600 px-3 py-1 rounded-lg text-xs text-white">
                                                        <i class="fa-solid fa-edit"></i>
                                                    </button>
                                                    <button type="button" data-id="{{ $follow->id }}"
                                                        onclick="deleteFollow(this)"
                                                        class="md:mt-0 inline-block bg-red-500 hover:bg-red-600 px-3 py-1 rounded-lg text-xs text-white">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="bg-white border-b">
                                                <td class="px-6 py-3 text-center" colspan="4">Data follow up belum ada.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@include('pages.setting.modals.source')
@include('pages.setting.modals.file')
@include('pages.setting.modals.status')
@include('pages.setting.modals.programtype')
@include('pages.setting.modals.followup')
