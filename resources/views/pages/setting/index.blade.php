<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight py-2">
                {{ __('Pengaturan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('message'))
                <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-lg"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            <div class="flex flex-col md:flex-row gap-5">
                <div class="w-full md:w-1/2 space-y-5">
                    <div class="px-2">
                        <button type="button" data-modal-target="sourceModal" onclick="changeSourceModal(this)"
                            class="bg-lp3i-100 hover:bg-lp3i-200 px-3 py-2 text-sm rounded-lg text-white">
                            <i class="fa-solid fa-circle-plus"></i> Tambah Data</button>
                    </div>
                    <div class="bg-white overflow-hidden border md:rounded-xl">
                        <div class="p-6 bg-white border-b border-gray-200">
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
                                                <td class="px-6 py-3">
                                                    <button type="button" data-source="{{ $source->id }}"
                                                        data-modal-target="sourceModal" data-name="{{ $source->name }}"
                                                        onclick="editSourceModal(this)"
                                                        class="inline-block bg-amber-500 hover:bg-amber-600 px-3 py-1 rounded-md text-xs text-white">
                                                        <i class="fa-solid fa-edit"></i>
                                                    </button>
                                                    <button type="button" data-source="{{ $source->id }}"
                                                        onclick="deleteSource(this)"
                                                        class="mt-1 md:mt-0 inline-block bg-red-500 hover:bg-red-600 px-3 py-1 rounded-md text-xs text-white">
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
            </div>
        </div>
    </div>
</x-app-layout>

{{-- Script Source --}}
<script>
    const changeSourceModal = (button) => {
        const modalTarget = button.dataset.modalTarget;
        let status = document.getElementById(modalTarget);
        let url = "{{ route('setting.store') }}";
        document.getElementById('title_source').innerText = `Tambah Sumber Database`;
        document.getElementById('name_source').value = '';
        document.getElementById('formSourceButton').innerText = 'Simpan';
        document.getElementById('formSourceModal').setAttribute('action', url);

        const elementsToRemove = document.querySelectorAll('[name="_method"]');
        if (elementsToRemove.length > 0) {
            elementsToRemove.forEach((element) => {
                element.remove();
            });
        } else {
            console.log("No elements found with the specified name.");
        }
        status.classList.toggle('hidden');
    }

    const editSourceModal = (button) => {
        const formModal = document.getElementById('formSourceModal');
        const modalTarget = button.dataset.modalTarget;
        const id = button.dataset.source;
        const name = button.dataset.name;
        let url = "{{ route('setting.update', ':id') }}".replace(':id', id);
        let status = document.getElementById(modalTarget);
        document.getElementById('title_source').innerText = `Edit Sumber Database ${name}`;
        document.getElementById('name_source').value = name;
        document.getElementById('formSourceButton').innerText = 'Simpan perubahan';
        document.getElementById('formSourceModal').setAttribute('action', url);
        let csrfToken = document.createElement('input');
        csrfToken.setAttribute('type', 'hidden');
        csrfToken.setAttribute('name', '_token');
        csrfToken.setAttribute('value', '{{ csrf_token() }}');
        formModal.appendChild(csrfToken);

        let methodInput = document.createElement('input');
        methodInput.setAttribute('type', 'hidden');
        methodInput.setAttribute('name', '_method');
        methodInput.setAttribute('value', 'PATCH');
        formModal.appendChild(methodInput);

        status.classList.toggle('hidden');
    }

    const deleteSource = (item) => {
        let id = item.dataset.source;
        if (confirm('Apakah kamu yakin akan menghapus data?')) {
            $.ajax({
                url: `/setting/${id}`,
                type: 'POST',
                data: {
                    '_method': 'DELETE',
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert('Kategori dipakai, tidak bisa dihapus.');
                }
            })
        }
    }
</script>

{{-- Modal Source --}}
<div class="fixed inset-0 flex items-center justify-center z-50 hidden" id="sourceModal">
    <div class="fixed inset-0 bg-black opacity-50"></div>
    <div class="fixed inset-0 flex items-center justify-center">
        <div class="w-full md:w-1/2 relative bg-white rounded-lg shadow mx-5">
            <div class="flex items-start justify-between p-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900" id="title_source">
                    Tambah Sumber Database
                </h3>
                <button type="button" onclick="changeSourceModal(this)" data-modal-target="sourceModal"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                    data-modal-hide="defaultModal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('setting.store') }}" id="formSourceModal">
                @csrf
                <div class="p-4 space-y-6">
                    <div>
                        <label for="text" class="block mb-2 text-sm font-medium text-gray-900">Nama
                            Database</label>
                        <input type="text" id="name_source" name="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required>
                    </div>
                </div>
                <div class="flex items-center p-4 space-x-2 border-t border-gray-200 rounded-b">
                    <button type="submit" id="formSourceButton"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
                    <button type="button" data-modal-target="sourceModal" onclick="changeSourceModal(this)"
                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>