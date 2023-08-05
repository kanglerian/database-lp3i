<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Database') }}
            </h2>
            <div class="flex flex-wrap justify-center items-center gap-3 px-2 text-gray-600">
                <div class="flex bg-gray-200 px-4 py-2 text-sm rounded-lg items-center gap-2">
                    <i class="fa-solid fa-database"></i>
                    <h2 id="count_filter">{{ $total }}</h2>
                </div>
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
            @if (session('error'))
                <div id="alert" class="mx-2 mb-4 flex items-center p-4 mb-4 bg-red-400 text-white rounded-lg"
                    role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('error') }}
                    </div>
                </div>
            @endif
            <div class="flex flex-wrap justify-between items-center gap-4 md:gap-0 px-2">
                <div class="flex items-center gap-3">
                    <a href="{{ route('database.create') }}"
                        class="bg-lp3i-100 hover:bg-lp3i-200 px-3 py-2 text-sm rounded-lg text-white"><i
                            class="fa-solid fa-circle-plus"></i> Tambah Data</a>
                </div>
                <div class="flex items-center gap-3 text-gray-500">
                    <div class="flex items-center gap-2">
                        <select id="change_type"
                            class="w-32 bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                            <option value="all">PMB</option>
                            @foreach ($sources as $source)
                                <option value="{{ $source->id }}">{{ $source->name }}</option>
                            @endforeach
                        </select>
                        <select id="change_year"
                            class="w-32 bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                            <option value="all">Sumber</option>
                            @foreach ($academics as $academic)
                                <option value="{{ $academic->year }}">{{ $academic->year }}</option>
                            @endforeach
                        </select>
                        <button type="button" onclick="changeFilter()" class="bg-sky-500 hover:bg-sky-600 px-3 py-2 text-xs rounded-lg text-white">
                            <i class="fa-solid fa-filter"></i>
                        </button>
                        <button type="button" onclick="resetFilter()"
                            class="bg-red-500 hover:bg-red-600 px-3 py-2 text-xs rounded-lg text-white">
                            <i class="fa-solid fa-filter-circle-xmark"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden border md:rounded-xl">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="relative overflow-x-auto md:rounded-xl">
                        <table id="myTable" class="w-full text-sm text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 rounded-tl-lg">
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
                                    <th scope="col" class="px-6 py-3 rounded-tr-lg">
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
    var urlData = 'get/databases';
    var dataTableInitialized = false;
    var dataTableInstance;

    const getAPI = () => {
        fetch(urlData)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Data dari server:', data.applicants);
                const count = data.applicants.length;
                document.getElementById('count_filter').innerText = count;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    const changeFilter = () => {
        let typeVal = document.getElementById('change_type').value;
        let yearVal = document.getElementById('change_year').value;
        urlData = `get/databases/${typeVal}/${yearVal}`;

        if (dataTableInitialized) {
            dataTableInstance.ajax.url(urlData).load();
            getAPI();
        } else {
            getDataTable();
        }
    }

    const resetFilter = () => {
        urlData = `get/databases`;
        if (dataTableInitialized) {
            dataTableInstance.ajax.url(urlData).load();
            getAPI();
        } else {
            getDataTable();
        }
    }

    const getDataTable = async () => {
        const dataTableConfig = {
            ajax: {
                url: urlData,
                dataSrc: 'applicants'
            },
            order: [
                [6, 'desc']
            ],
            columns: [{
                    data: {
                        identity: 'identity',
                        name: 'name',
                    },
                    render: (data, type, row) => {
                        let editUrl = "{{ route('histories.show', ':identity') }}".replace(
                            ':identity',
                            data.identity);
                        return `<a href="${editUrl}" class="font-bold underline">${data.name}</a>`
                    }
                },
                {
                    data: 'phone',
                    render: (data) => {
                        return typeof(data) == 'object' ? 'Tidak diketahui' : data;
                    }
                },
                {
                    data: 'school',
                    render: (data) => {
                        return typeof(data) == 'object' ? 'Tidak diketahui' : data;
                    }
                },
                {
                    data: 'year',
                    render: (data, row) => {
                        return typeof(data) == 'string' ? data : 'Tidak diketahui';
                    }
                },
                {
                    data: 'source_setting',
                    render: (data, type, row) => {
                        return data.name;
                    }
                },
                {
                    data: 'status',
                    render: (data, type, row) => {
                        return data;
                        // switch (data) {
                        //     case "1":
                        //         return '<span class="bg-gray-200 text-gray-800 px-3 py-1 rounded-md text-xs">Tidak diketahui</span>'
                        //         break;
                        //     case "2":
                        //         return '<span class="bg-amber-500 px-3 py-1 rounded-md text-xs text-white">Potensi</span>'
                        //         break;
                        //     case "3":
                        //         return '<span class="bg-sky-500 px-3 py-1 rounded-md text-xs text-white">Daftar</span>'
                        //         break;
                        //     case "4":
                        //         return '<span class="bg-emerald-500 px-3 py-1 rounded-md text-xs text-white">Registrasi</span>'
                        //         break;
                        //     case "5":
                        //         return '<span class="bg-red-500 px-3 py-1 rounded-md text-xs text-white">Batal</span>'
                        //         break;
                        // }
                    }
                },
                {
                    data: {
                        id: 'id',
                        identity: 'identity',
                        name: 'name',
                        phone: 'phone',
                        school: 'school',
                        year: 'year',
                        source: 'source',
                        status: 'status'
                    },
                    render: (data, type, row) => {
                        let showUrl = "{{ route('database.show', ':identity') }}".replace(
                            ':identity',
                            data.identity);
                        let editUrl = "{{ route('database.edit', ':id') }}".replace(':id',
                            data.id);
                        let folder = data.status == 4 || data.status == 3 ?
                            `<a href="${showUrl}" class="inline-block bg-sky-500 hover:bg-sky-600 px-3 py-1 rounded-md text-xs text-white"><i class="fa-regular fa-folder-open"></i></a>` :
                            `<button class="inline-block border border-gray-300 px-3 py-1 rounded-md text-xs text-gray-400"><i class="fa-regular fa-folder-open"></i></button>`;
                        return `
                            ${folder}
                            <button class="inline-block bg-sky-500 hover:bg-sky-600 px-3 py-1 rounded-md text-xs text-white" onclick="event.preventDefault(); copyRecord('${data.name}','${data.phone}','${data.school}','${data.year}','${data.source}',)">
                                <i class="fa-solid fa-copy"></i>
                            </button>
                            <a href="${editUrl}" class="inline-block bg-amber-500 hover:bg-amber-600 px-3 py-1 rounded-md text-xs text-white">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <button class="inline-block bg-red-500 hover:bg-red-600 px-3 py-1 rounded-md text-xs text-white" onclick="event.preventDefault(); deleteRecord(${data.id})">
                                <i class="fa-solid fa-trash"></i>
                            </button>`
                    }
                },
            ],
        }
        dataTableInstance = $('#myTable').DataTable(dataTableConfig);
        dataTableInitialized = true;
    }
    getAPI();
    getDataTable();

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
        }
        const textarea = document.createElement("textarea");
        textarea.value =
            `Nama lengkap: ${name} \nNo. Telp (Whatsapp): ${phone} \nAsal sekolah dan tahun lulus: ${school == "null" ? 'Tidak diketahui' : school} (${year}) \nSumber: ${contentSource}`;
        textarea.style.position = "fixed";
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand("copy");
        document.body.removeChild(textarea);
        alert('Link sudah disalin!');
    }
</script>
