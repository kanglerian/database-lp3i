<x-app-layout>
    <x-slot name="header">
        @include('pages.database.components.navigation')
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-10 space-y-5">
        @if (session('message'))
            <div id="alert" class="flex items-center p-4 mb-4 bg-emerald-500 text-emerald-50 rounded-2xl"
                role="alert">
                <i class="fa-solid fa-circle-check"></i>
                <div class="ml-3 text-sm font-reguler">
                    {{ session('message') }}
                </div>
            </div>
        @endif
        <div class="px-2">
            <button type="button" onclick="modalFunction('add')"
                class="bg-lp3i-100 hover:bg-lp3i-200 px-4 py-2 text-sm rounded-xl text-white"><i
                    class="fa-solid fa-circle-plus"></i> Tambah Data</button>
        </div>
        <div class="bg-white overflow-hidden border rounded-3xl">
            <div class="p-8 bg-gray-50 border-b border-gray-200">
                <div class="relative overflow-x-auto">
                    <table id="tableAchievement" data-user="{{ $user->identity }}"
                        class="w-full text-sm text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 rounded-t-lg">
                                    No.
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nama Kegiatan
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Tingkat
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Tahun
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Pencapaian
                                </th>
                                <th scope="col" class="px-6 py-3 rounded-t-lg">
                                    Action
                                </th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="fixed inset-0 flex items-center justify-center z-50 hidden" id="modalChat">
        <div class="fixed inset-0 bg-black opacity-50"></div>
        <div class="fixed inset-0 flex items-center justify-center">
            <div class="w-full md:w-1/2 relative bg-white rounded-3xl shadow mx-5">
                <div class="flex items-start justify-between px-8 py-6 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Tambah Data Prestasi
                    </h3>
                    <button  type="button" onclick="modalFunction()"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div>
                    <form method="POST" action="{{ route('achievements.store') }}" class="px-8 pb-8 pt-3 space-y-3">
                        @csrf
                        <input type="hidden" value="{{ $user->identity }}" name="identity_user">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Nama Kegiatan</label>
                            <input type="text" id="name" name="name" placeholder="Isi nama kegiatan disini.."
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Tahun</label>
                            <input type="date" id="year" name="year" placeholder="Tahun"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Tingkat</label>
                            <select name="level" id="level"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                                <option>Pilih tingkat</option>
                                <option value="Internasional">Internasional</option>
                                <option value="Provinsi">Provinsi</option>
                                <option value="Kota / Kabupaten">Kota / Kabupaten</option>
                                <option value="Kecamatan">Kecamatan</option>
                                <option value="Desa / Kelurahan">Desa / Kelurahan</option>
                                <option value="Sekolah">Sekolah</option>
                                <option value="Jurusan">Jurusan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Pencapaian</label>
                            <input type="text" id="result" name="result" placeholder="Isi pencapaian disini.."
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                        </div>
                        <hr>
                        <div class="flex items-center space-x-2">
                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center">Simpan</button>
                            <button type="button" onclick="modalFunction()"
                                class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-xl border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script>
    const modalFunction = () => {
        let modalChat = document.getElementById('modalChat');
        document.getElementById('name').value = '';
        document.getElementById('level').value = '';
        document.getElementById('year').value = '';
        document.getElementById('result').value = '';
        modalChat.classList.toggle('hidden');
    }
</script>

<script>
    $(document).ready(function() {
        let identity = document.getElementById('tableAchievement').getAttribute('data-user');
        $('#tableAchievement').DataTable({
            ajax: {
                url: `/achievements/${identity}`,
                dataSrc: 'achievements'
            },
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'name'
                },
                {
                    data: 'level'
                },
                {
                    data: 'year'
                },
                {
                    data: 'result'
                },
                {
                    data: 'id',
                    render: (data, type, row) => {
                        return `
                        <div class="flex items-center gap-1">
                            <button class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded-lg text-xs text-white" onclick="event.preventDefault(); deleteRecord(${data})">
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
                url: `/achievements/${id}`,
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
