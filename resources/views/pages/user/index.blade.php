<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 pb-3">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Akun') }}
            </h2>
            <div class="flex flex-wrap justify-center items-center gap-3 px-2 text-gray-600">
                <div class="flex bg-gray-200 px-4 py-2 text-sm rounded-xl items-center gap-2">
                    <i class="fa-solid fa-users"></i>
                    <h2>{{ $users }}</h2>
                </div>
                <div class="flex bg-gray-200 px-4 py-2 text-sm rounded-xl items-center gap-2">
                    <i class="fa-solid fa-circle-check text-green-500"></i>
                    <h2>{{ $active }}</h2>
                </div>
                <div class="flex bg-gray-200 px-4 py-2 text-sm rounded-xl items-center gap-2">
                    <i class="fa-solid fa-circle-xmark text-red-500"></i>
                    <h2>{{ $deactive }}</h2>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">
            @if (session('message'))
                <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-2xl"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-reguler">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-red-500 text-white rounded-2xl"
                    role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('error') }}
                    </div>
                </div>
            @endif
            <div class="flex flex-wrap justify-between items-center gap-4 md:gap-0 px-2">
                <a href="{{ route('user.create') }}"
                    class="bg-lp3i-100 hover:bg-lp3i-200 px-3 py-2 text-sm rounded-xl text-white"><i
                        class="fa-solid fa-circle-plus"></i> Tambah Data</a>
                <div class="flex items-center gap-3 text-gray-500">
                    <div class="flex items-center gap-2">
                        <select name="role" id="change_role"
                            class="w-32 bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800">
                            <option value="all">Peran</option>
                            <option value="A">Adminstrator</option>
                            <option value="P">Presenter</option>
                            <option value="S">Siswa</option>
                        </select>
                        <select name="role" id="change_status"
                            class="w-28 bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800">
                            <option value="all">Status</option>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                        <button type="button" onclick="changeFilter()"
                            class="bg-sky-500 hover:bg-sky-600 px-3 py-2 text-xs rounded-xl text-white">
                            <i class="fa-solid fa-filter"></i>
                        </button>
                        <button type="button" onclick="resetFilter()"
                            class="bg-red-500 hover:bg-red-600 px-3 py-2 text-xs rounded-xl text-white">
                            <i class="fa-solid fa-filter-circle-xmark"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden border rounded-3xl">
                <div class="p-8 bg-white border-b border-gray-200">
                    <div class="relative overflow-x-auto md:rounded-xl">
                        <table id="myTable" class="w-full text-sm text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 rounded-t-lg">
                                        <i class="fa-solid fa-user"></i>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nama Lengkap
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        No. Telpon (Whatsapp)
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Peran
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
    </div>
</x-app-layout>

<script>
    var urlData = 'get/users';
    var dataTableInitialized = false;
    var dataTableInstance;

    const changeFilter = () => {
        showLoadingAnimation();
        let roleVal = document.getElementById('change_role').value;
        let statusVal = document.getElementById('change_status').value;
        urlData = `get/users/${roleVal}/${statusVal}`;

        if (dataTableInitialized) {
            dataTableInstance.ajax.url(urlData).load();
            hideLoadingAnimation();
        } else {
            getDataTable();
        }
    }

    const resetFilter = () => {
        showLoadingAnimation();
        document.getElementById('change_role').value = 'all';
        document.getElementById('change_status').value = 'all';
        urlData = `get/users/all/all`;
        if (dataTableInitialized) {
            dataTableInstance.ajax.url(urlData).load();
            hideLoadingAnimation();
        } else {
            getDataTable();
        }
    }

    const getDataTable = () => {
        showLoadingAnimation();
        dataTableInstance = $('#myTable').DataTable({
            ajax: {
                url: urlData,
                dataSrc: 'users'
            },
            columns: [{
                    data: {
                        id: 'id',
                        status: 'status'
                    },
                    render: (data, type, row) => {
                        switch (data.status) {
                            case "0":
                                return `<i class="fa-solid fa-circle-xmark text-red-500"></i>`
                                break;
                            case "1":
                                return `<i class="fa-solid fa-circle-check text-green-500"></i>`
                                break;
                        }
                    }
                },
                {
                    data: 'name'
                },
                {
                    data: 'email'
                },
                {
                    data: 'phone',
                    render: (data, row) => {
                        return typeof(data) == 'string' ? data : 'Tidak diketahui';
                    }
                },
                {
                    data: 'role',
                    render: (data, row) => {
                        switch (data) {
                            case "A":
                                return 'Administrator';
                                break;
                            case "S":
                                return `Siswa`;
                                break;
                            case "P":
                                return `Presenter`;
                                break;
                            case "E":
                                return `Pendidikan`;
                                break;
                            case "C":
                                return `C&P`;
                                break;
                            default:
                                return `Tidak diketahui`;
                                break;
                        }
                    }
                },
                {
                    data: {
                        id: 'id',
                        role: 'role',
                        status: 'status'
                    },
                    render: (data, type, row) => {
                        let editUrl = "{{ route('user.edit', ':id') }}".replace(':id', data.id);
                        let status = data.status === "1" ?
                            `<button onclick="event.preventDefault(); statusRecord(${data.id})"  class="bg-emerald-500 px-3 py-1 rounded-lg text-xs text-white"><i class="fa-solid fa-toggle-on"></i></button>` :
                            `<button onclick="event.preventDefault(); statusRecord(${data.id})" class="bg-red-500 px-3 py-1 rounded-lg text-xs text-white"><i class="fa-solid fa-toggle-off"></i></button>`
                        return `
                        <div class="flex items-center gap-1">
                            ${status}
                            <a href="${editUrl}" class="bg-amber-500 hover:bg-amber-600 px-3 py-1 rounded-lg text-xs text-white">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <button class="md:mt-0 bg-red-500 hover:bg-red-600 px-3 py-1 rounded-lg text-xs text-white" onclick="event.preventDefault(); deleteRecord(${data.id})">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>`
                    }
                },
            ],
        });
        dataTableInitialized = true;
        hideLoadingAnimation();
    }

    getDataTable();

    const deleteRecord = (id) => {
        if (confirm('Apakah kamu yakin akan menghapus data?')) {
            $.ajax({
                url: `/user/${id}`,
                type: 'POST',
                data: {
                    '_method': 'DELETE',
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: (response) => {
                    location.reload();
                },
                error: (xhr, status, error) => {
                    if (xhr.status === 500 && xhr.responseText.includes("SQLSTATE[23000]")) {
                        var errorCode = 23000;
                        alert('Tidak dapat menghapus atau memperbarui baris induk.');
                    }
                }
            })
        }
    }

    const statusRecord = (id) => {
        if (confirm('Apakah kamu yakin akan mengubah status data?')) {
            $.ajax({
                url: `/user/change/${id}`,
                type: 'POST',
                data: {
                    '_method': 'PATCH',
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

    const copyRecord = (name, phone, school, year, source) => {
        var contentSource = '';
        switch (source) {
            case "1":
                contentSource = 'Website'
                break;
            case "2":
                contentSource = 'Presenter'
                break;
        }
        const textarea = document.createElement("textarea");
        textarea.value =
            `Nama lengkap: ${name} \nNo. Telp (Whatsapp): ${phone} \nAsal sekolah dan tahun lulus: ${school == "null" ? 'Tidak diketahui' : school} (${year}) \nSumber: ${contentSource}`;
        textarea.style.position = "fixed";
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand("copy");
        document.body.removeChild(textarea);
        alert('Data sudah disalin.');
    }
</script>
