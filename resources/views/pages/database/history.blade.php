<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight py-2">
                Riwayat Follow Up - {{ $user->name }} ({{ $user->identity }})
            </h2>
            <div class="flex flex-wrap justify-center items-center gap-3 px-2 text-gray-600">
                <div class="flex bg-gray-200 px-4 py-2 text-sm rounded-lg items-center gap-2">
                    <i class="fa-regular fa-comments"></i>
                    <h2 id="count_filter">{{ count($histories) }}</h2>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5 mt-7">
        @if (session('message'))
            <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-lg"
                role="alert">
                <i class="fa-solid fa-circle-check"></i>
                <div class="ml-3 text-sm font-medium">
                    {{ session('message') }}
                </div>
            </div>
        @endif
        @if (session('error'))
            <div id="alert" class="mx-2 mb-4 flex items-center p-4 mb-4 bg-red-400 text-white rounded-lg"
                role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div class="ml-3 text-sm font-medium">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        <div class="flex flex-wrap items-center gap-4 gap-3 px-4">
            <a href="{{ route('database.index') }}"
                class="inline-block border border-gray-400 hover:bg-gray-400 hover:text-white text-gray-500 px-4 py-2 rounded-lg text-sm"><i
                    class="fa-solid fa-arrow-left"></i> Kembali</a>
            <button type="button" data-modal-target="dataModal" onclick="dataModal(this)"
                class="bg-lp3i-100 hover:bg-lp3i-200 px-3 py-2 text-sm rounded-lg text-white"><i
                    class="fa-solid fa-circle-plus"></i> Tambah Data</button>
        </div>

        <div class="p-6">
            <ol class="relative border-l border-gray-200 dark:border-gray-700">
                @forelse ($histories as $history)
                    <li class="mb-10 ml-4">
                        <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white">
                        </div>
                        <div class="flex gap-5 mb-2">
                            <time
                                class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ $history['date'] }}</time>
                            <div class="flex gap-3">
                                <button type="button" data-id="{{ $history['id'] }}" data-modal-target="dataModal"
                                    data-title="{{ $history['title'] }}" data-date="{{ $history['date'] }}"
                                    data-title="{{ $history['title'] }}" data-result="{{ $history['result'] }}" data-report="{{ $history['report'] }}"
                                    onclick="editModal(this)" class="text-xs text-gray-600 hover:text-yellow-600"><i
                                        class="fa-regular fa-pen-to-square"></i></button>
                                <button type="button" data-id="{{ $history['id'] }}" onclick="deleteModal(this)"
                                    class="text-xs text-gray-600 hover:text-red-600"><i
                                        class="fa-regular fa-trash-can"></i></button>
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $history['title'] }}</h3>
                        <p class="mb-4 text-sm font-normal text-gray-500 dark:text-gray-400">{{ $history['result'] }}
                        <p class="mb-4 text-sm font-normal text-gray-500 dark:text-gray-400"><span class="font-bold">Hasil:</span> {{ $history['report'] == null ? 'Belum diisi' : $history['report'] }}
                        </p>
                    </li>
                @empty
                    <li class="mb-10 ml-4">
                        <div
                            class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Data riwayat belum ada</h3>
                        <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">Silahkan untuk isi
                            riwayat melalui tombol tambah data atau dengan aplikasi pihak ke-3.</p>
                    </li>
                @endforelse
            </ol>

        </div>

    </div>
</x-app-layout>

<script>
    const dataModal = (button) => {
        const modalTarget = button.dataset.modalTarget;
        let status = document.getElementById(modalTarget);
        let url = "{{ route('histories.store') }}";
        document.getElementById('title_form').innerText = `Tambah Data Riwayat`;
        document.getElementById('title').value = '';
        document.getElementById('date').value = '';
        document.getElementById('result').value = '';
        document.getElementById('report').value = '';
        document.getElementById('formButton').innerText = 'Simpan';
        document.getElementById('formModal').setAttribute('action', url);

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

    const editModal = (button) => {
        const modalTarget = button.dataset.modalTarget;
        const id = button.dataset.id;
        const title = button.dataset.title;
        const date = button.dataset.date;
        const result = button.dataset.result;
        const report = button.dataset.report;
        let url = "{{ route('histories.update', ':id') }}".replace(':id', id);
        let status = document.getElementById(modalTarget);
        document.getElementById('title_form').innerText = `Edit Data Riwayat ${title}`;
        document.getElementById('title').value = title;
        document.getElementById('date').value = date;
        document.getElementById('result').value = result;
        document.getElementById('report').value = report;
        document.getElementById('formButton').innerText = 'Simpan perubahan';
        document.getElementById('formModal').setAttribute('action', url);
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

    const deleteModal = (item) => {
        let id = item.dataset.id;
        if (confirm(`Apakah kamu yakin akan menghapus data?`)) {
            $.ajax({
                url: `https://api.politekniklp3i-tasikmalaya.ac.id/history/delete/${id}`,
                type: 'POST',
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert('Error deleting record');
                }
            })
        }
    }
</script>


<div class="fixed inset-0 flex items-center justify-center z-50 hidden" id="dataModal">
    <div class="fixed inset-0 bg-black opacity-50"></div>
    <div class="fixed inset-0 flex items-center justify-center">
        <div class="w-full md:w-1/2 relative bg-white rounded-lg shadow mx-5">
            <div class="flex items-start justify-between p-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900" id="title_form">
                    Tambah Data Riwayat
                </h3>
                <button type="button" onclick="dataModal(this)" data-modal-target="dataModal"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                    data-modal-hide="defaultModal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('histories.store') }}" id="formModal">
                @csrf
                <div class="p-4 space-y-6">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Judul Riwayat</label>
                        <input type="text" id="title" name="title" placeholder="Isi judul riwayat disini.."
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required>
                        <input type="hidden" name="phone" value="{{ $user->phone }}">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal</label>
                        <input type="date" id="date" name="date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Isi Pesan</label>
                        <textarea name="result" id="result" cols="30" rows="5" placeholder="Isi pesan disini..."
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required></textarea>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Hasil</label>
                        <input type="text" id="report" name="report" placeholder="Tulis hasilnya disini"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500">
                    </div>
                </div>
                <div class="flex items-center p-4 space-x-2 border-t border-gray-200 rounded-b">
                    <button type="submit" id="formButton"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
                    <button type="button" data-modal-target="dataModal" onclick="dataModal(this)"
                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
