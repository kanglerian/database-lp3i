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

    <div id="phone" data-phone="{{ $user->phone }}"
        class="max-w-7xl mx-auto flex flex-col md:flex-row py-4 sm:px-6 lg:px-8 gap-5 mt-3" id="riwayat">
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

<script>
    const dataModal = (button) => {
        const modalTarget = button.dataset.modalTarget;
        let status = document.getElementById(modalTarget);
        document.getElementById('title_form').innerText = `Tambah Data Riwayat`;
        document.getElementById('title').value = '';
        document.getElementById('date').value = '';
        document.getElementById('result').value = '';
        document.getElementById('report').value = '';
        document.getElementById('formButton').innerText = 'Simpan';

        status.classList.toggle('hidden');
    }

    const editModal = (button) => {
        const modalTarget = button.dataset.modalTarget;
        const id = button.dataset.id;
        const title = button.dataset.title;
        const date = button.dataset.date;
        const result = button.dataset.result;
        const report = button.dataset.report;
        let status = document.getElementById(modalTarget);
        document.getElementById('title_form').innerText = `Edit Data Riwayat ${title}`;
        document.getElementById('title').value = title;
        document.getElementById('date').value = date;
        document.getElementById('result').value = result;
        document.getElementById('report').value = report;
        document.getElementById('formButton').innerText = 'Simpan perubahan';

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
    const formModal = document.getElementById('formModal');
    formModal.addEventListener('submit', async (event) => {
        event.preventDefault();
        const title = document.getElementById('title').value;
        const date = document.getElementById('date').value;
        const result = document.getElementById('result').value;
        const report = document.getElementById('report').value;
        const phone = document.getElementById('phone').getAttribute('data-phone');
    })

    const formData = {
        title,
        date,
        result,
        report,
        phone,
    };

    try {
        await axios.post('https://api.politekniklp3i-tasikmalaya.ac.id/history/store', formData)
        .then((response) => {
            alert('Histori ditambahkan');
        })
    } catch (error) {
        console.error(error);
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
            <form method="POST" action="javascript:void(0)" id="formModal">
                <div class="p-4 space-y-6">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Judul Riwayat</label>
                        <input type="text" id="title" name="title" placeholder="Isi judul riwayat disini.."
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required>
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
                    <button type="submit" data-modal-target="dataModal" onclick="dataModal(this)"
                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
