<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Registrasi') }}
            </h2>
            <div class="flex flex-wrap justify-center items-center gap-2 px-2 text-gray-600">
                <a href="{{ route('enrollment.index') }}"
                    class="text-sm text-gray-800 bg-gray-50 hover:bg-gray-100 cursor-pointer px-4 py-2 rounded-lg">
                    Pendaftaran
                </a>
                <a href="{{ route('registration.index') }}"
                    class="text-sm text-gray-800 bg-gray-50 hover:bg-gray-100 cursor-pointer px-4 py-2 rounded-lg">
                    Registrasi
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">
            @if (session('message'))
                <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-lg"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            <div class="px-2">
                <a onclick="alert('belum berfungsi, silahkan tambahkan di halaman mahasiswa.')"
                    class="bg-lp3i-100 hover:bg-lp3i-200 px-3 py-2 text-sm rounded-lg text-white"><i
                        class="fa-solid fa-circle-plus"></i> Tambah</a>
            </div>
            <div class="bg-white overflow-hidden border md:rounded-xl">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="relative overflow-x-auto md:rounded-xl">
                        <table id="myTable" class="w-full text-sm text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 rounded-t-lg">
                                        No.
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Tanggal
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Gelombang
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nama Lengkap
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nominal
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Harga Deal
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Diskon
                                    </th>
                                    <th scope="col" class="px-6 py-3 rounded-t-lg">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="fixed inset-0 flex items-center justify-center z-50 hidden" id="modalChat">
        <div class="fixed inset-0 bg-black opacity-50"></div>
        <div class="fixed inset-0 flex items-center justify-center">
            <div class="w-full md:w-1/2 relative bg-white rounded-lg shadow mx-5">
                <div class="flex items-start justify-between p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900" id="title_form">
                        Tambah Data Riwayat
                    </h3>
                    <button type="button" onclick="" data-modal-target="dataModal"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                        data-modal-hide="defaultModal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div>
                    <div class="p-4 space-y-6">
                        <input type="hidden" value="" id="id" name="id">
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
                        <button type="button" id="formButton" onclick="saveHistory()"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
                        <button type="submit" onclick="modalFunction()"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            ajax: {
                url: 'get/registrations',
                dataSrc: 'registrations'
            },
            columns: [
                {
                    data: 'id',
                    render: (data, type, row, meta) => {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'date'
                },
                {
                    data: 'session'
                },
                {
                    data: 'applicant',
                    render: (data, type, row, meta) => {
                        return `${data.name}`
                    }
                },
                {
                    data: 'nominal',
                    render: (data, type, row, meta) => {
                        return `Rp${data.toLocaleString('id-ID')}`
                    }
                },
                {
                    data: 'deal',
                    render: (data, type, row, meta) => {
                        return `Rp${data.toLocaleString('id-ID')}`
                    }
                },
                {
                    data: 'discount',
                    render: (data, type, row, meta) => {
                        return `Rp${data.toLocaleString('id-ID')}`
                    }
                },
                {
                    data: {
                        id: 'id',
                    },
                    render: (data, type, row) => {
                        return `
                        <div class="flex items-center gap-1">
                            <button class="md:mt-0 bg-red-500 hover:bg-red-600 px-3 py-1 rounded-md text-xs text-white" onclick="event.preventDefault(); deleteRecord(${data.id})">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>`
                    }
                },
            ],
        });
    });

    const deleteRecord = (id) => {
        if (confirm('Apakah kamu yakin akan menghapus data?')) {
            $.ajax({
                url: `/registration/${id}`,
                type: 'POST',
                data: {
                    '_method': 'DELETE',
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
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