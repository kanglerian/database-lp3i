<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Database') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('message'))
                <div id="alert" class="mx-2 mb-4 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-lg"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            <div class="px-2 pb-4">
                <a href="{{ route('database.create') }}"
                    class="bg-sky-500 hover:bg-sky-600 px-3 py-2 text-sm rounded-lg text-white"><i
                        class="fa-solid fa-circle-plus"></i> Tambah Data</a>
            </div>
            <div class="bg-white overflow-hidden border md:rounded-xl">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="relative overflow-x-auto md:rounded-xl">
                        <table id="myTable" class="w-full text-sm text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3 rounded-t-lg">
                                        Nama lengkap
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        No. Telpon (Whatsapp)
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Asal sekolah
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Tahun lulus
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Sumber
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Status
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
    $(document).ready(function() {
        $('#myTable').DataTable({
            ajax: {
                url: 'api/applicants',
                dataSrc: 'applicants'
            },
            columns: [{
                    data: 'name'
                },
                {
                    data: 'phone'
                },
                {
                    data: 'school',
                    render: (data, type, row) => {
                        return data == null ? 'Tidak diketahui' : data;
                    }
                },
                {
                    data: 'year'
                },
                {
                    data: 'source',
                    render: (data, type, row) => {
                        switch (data) {
                            case null:
                                return 'Tidak diketahui'
                                break;
                            case 1:
                                return 'Website'
                                break;
                            case 2:
                                return 'Presenter'
                                break;
                        }
                    }
                },
                {
                    data: 'status',
                    render: (data, type, row) => {
                        switch (data) {
                            case 1:
                                return '<span class="bg-gray-200 text-gray-800 px-3 py-1 rounded-md text-xs">Tidak diketahui</span>'
                                break;
                            case 2:
                                return '<span class="bg-amber-500 px-3 py-1 rounded-md text-xs text-white">Potensi</span>'
                                break;
                            case 3:
                                return '<span class="bg-sky-500 px-3 py-1 rounded-md text-xs text-white">Daftar</span>'
                                break;
                            case 4:
                                return '<span class="bg-emerald-500 px-3 py-1 rounded-md text-xs text-white">Registrasi</span>'
                                break;
                            case 5:
                                return '<span class="bg-red-500 px-3 py-1 rounded-md text-xs text-white">Batal</span>'
                                break;
                        }
                    }
                },
                {
                    data: {
                        id: 'id',
                        name: 'name',
                        phone: 'phone',
                        school: 'school',
                        year: 'year',
                        source: 'source'
                    },
                    render: (data, type, row) => {
                        let editUrl = "{{ route('database.edit', ':id') }}".replace(':id',
                            data);
                        return `
                            <button class="inline-block bg-sky-500 hover:bg-sky-600 px-3 py-1 rounded-md text-xs text-white" onclick="event.preventDefault(); copyRecord('${data.name}','${data.phone}','${data.school}','${data.year}','${data.source}',)">
                                <i class="fa-solid fa-copy"></i>
                            </button>
                            <a href="${editUrl}" class="inline-block bg-amber-500 hover:bg-amber-600 px-3 py-1 rounded-md text-xs text-white">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <button class="inline-block bg-red-500 hover:bg-red-600 px-3 py-1 rounded-md text-xs text-white" onclick="event.preventDefault(); deleteRecord(${data})">
                                <i class="fa-solid fa-trash"></i>
                            </button>`
                    }
                },
            ],
        });
    });

    const deleteRecord = (id) => {
        if (confirm('Apakah kamu yakin akan menghapus data?')) {
            $.ajax({
                url: `/database/${id}`,
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

    const copyRecord = (name, phone, school, year, source) => {
        var contentSource = '';
        switch (source) {
            case "1":
                contentSource = 'Website'
                break;
            case "2":
                contentSource = 'Presenter'
                break;
            default:
                break;
        }
        const textarea = document.createElement("textarea");
        textarea.value = `Nama lengkap: ${name} \nNo. Telp (Whatsapp): ${phone} \nAsal sekolah dan tahun lulus: ${school} (${year}) \nSumber: ${contentSource}`;
        textarea.style.position = "fixed";
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand("copy");
        document.body.removeChild(textarea);
        alert('Link sudah disalin!');
    }
</script>
