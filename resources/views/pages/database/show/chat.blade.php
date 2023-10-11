<x-app-layout>
    <x-slot name="header">
        @include('pages.database.components.navigation')
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
        @if (session('error'))
            <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-red-500 text-white rounded-lg" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div class="ml-3 text-sm font-medium">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        @if (session('message'))
            <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-lg"
                role="alert">
                <i class="fa-solid fa-circle-check"></i>
                <div class="ml-3 text-sm font-medium">
                    {{ session('message') }}
                </div>
            </div>
        @endif
        @if ($errors->first('berkas'))
            <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-red-500 text-white rounded-lg" role="alert">
                <i class="fa-solid fa-circle-xmark"></i>
                <div class="ml-3 text-sm font-medium">
                    {{ $errors->first('berkas') }}
                </div>
            </div>
        @endif
    </div>

    <div id="phone" data-phone="{{ $user->phone }}" class="max-w-7xl mx-auto flex flex-col md:flex-row py-4 sm:px-6 lg:px-8 gap-5 mt-3" id="riwayat">
        <div class="w-full">
            <div class="flex flex-wrap items-center gap-4 gap-3 px-4">
                <button type="button" data-modal-target="dataModal" onclick="dataModal(this)"
                    class="bg-lp3i-100 hover:bg-lp3i-200 px-3 py-2 text-sm rounded-lg text-white"><i
                        class="fa-solid fa-circle-plus"></i> Tambah Data</button>
            </div>

            <div class="p-6">
                <ol class="relative border-l border-gray-200 dark:border-gray-700" id="histories">
                    {{-- @forelse ($histories as $history)

                    @empty
                        <li class="mb-10 ml-4">
                            <div
                                class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Data riwayat belum ada</h3>
                            <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">Silahkan untuk isi
                                riwayat melalui tombol tambah data atau dengan aplikasi pihak ke-3.</p>
                        </li>
                    @endforelse --}}
                </ol>

            </div>
        </div>
    </div>

</x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const getChats = async () => {
        let phone = document.getElementById('phone').getAttribute('data-phone');
        if (phone) {
            let bucket = '';
            await axios.get(`https://api.politekniklp3i-tasikmalaya.ac.id/history/phone/${phone}`)
                .then((response) => {
                    let histories = response.data;
                    histories.forEach(history => {
                        bucket += `
                        <li class="mb-10 ml-4">
                            <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white">
                            </div>
                            <div class="flex gap-5 mb-2">
                                <time
                                    class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">${history.date}</time>
                                <div class="flex gap-3">
                                    <button type="button" data-id="${history.id}" data-modal-target="dataModal"
                                        data-title="${history.title}" data-date="${history.date}"
                                        data-title="${history.title}" data-result="${history.result}" data-report="${history.report}"
                                        onclick="editModal(this)" class="text-xs text-gray-600 hover:text-yellow-600"><i
                                            class="fa-regular fa-pen-to-square"></i></button>
                                    <button type="button" data-id="${history.id}" onclick="deleteModal(this)"
                                        class="text-xs text-gray-600 hover:text-red-600"><i
                                            class="fa-regular fa-trash-can"></i></button>
                                </div>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">${history.title}</h3>
                            <p class="mb-4 text-sm font-normal text-gray-500 dark:text-gray-400">${history.result}
                            <p class="mb-4 text-sm font-normal text-gray-500 dark:text-gray-400"><span class="font-bold">Hasil:</span> ${history.report == null ? 'Belum diisi' : history.report}
                            </p>
                        </li>`
                    });
                    document.getElementById('histories').innerHTML = bucket;
                })
                .catch((error) => {
                    console.log(error.message);
                });
        } else {
            console.log('Nomor telepon tidak ditemukan.');
        }
    }
    getChats();
</script>
