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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-3">
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
            <div class="flex items-center gap-3">
                <a href="{{ route('database.create') }}"
                    class="bg-lp3i-100 hover:bg-lp3i-200 px-3 py-2 text-sm rounded-lg text-white"><i
                        class="fa-solid fa-circle-plus"></i> Tambah Data</a>
            </div>  
            <div class="flex items-center gap-3 text-gray-500 overflow-x-auto pb-4">
                <div class="flex items-center gap-2">
                    <input type="date" id="date_start"
                        class="w-32 bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                    <input type="date" id="date_end"
                        class="w-32 bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                    <input type="number" id="year_grad" onkeypress="handleEnterKeyPress(event)"
                        class="w-32 bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
                        placeholder="Tahun lulus">
                    <input type="number" id="year_grad" onkeypress="handleEnterKeyPress(event)"
                        class="w-32 bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
                        placeholder="Asal Sekolah">
                    <input type="number" id="year_grad" onkeypress="handleEnterKeyPress(event)"
                        class="w-32 bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
                        placeholder="Tanggal Lahir">
                    <input type="number" id="change_pmb" onkeypress="handleEnterKeyPress(event)"
                        class="w-32 bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
                        placeholder="Tahun PMB">
                    <select id="change_source"
                        class="w-32 bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                        <option value="all">Sumber</option>
                        @foreach ($sources as $source)
                            <option value="{{ $source->id }}">{{ $source->name }}</option>
                        @endforeach
                    </select>
                    <select id="change_source"
                        class="w-32 bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                        <option value="all">Sumber</option>
                        @foreach ($sources as $source)
                            <option value="{{ $source->id }}">{{ $source->name }}</option>
                        @endforeach
                    </select>
                    <select id="change_status"
                        class="w-32 bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                        <option value="all">Status</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                        @endforeach
                    </select>
                    <button type="button" onclick="changeFilter()"
                        class="bg-sky-500 hover:bg-sky-600 px-3 py-2 text-xs rounded-lg text-white">
                        <i class="fa-solid fa-filter"></i>
                    </button>
                    <button type="button" onclick="resetFilter()"
                        class="bg-red-500 hover:bg-red-600 px-3 py-2 text-xs rounded-lg text-white">
                        <i class="fa-solid fa-filter-circle-xmark"></i>
                    </button>
                </div>
            </div>
            <div class="bg-white overflow-hidden border md:rounded-xl">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="relative overflow-x-auto md:rounded-xl">
                        <table id="myTable" class="w-full text-sm text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 rounded-tl-lg">
                                        Tanggal
                                    </th>
                                    <th scope="col" class="px-6 py-3">
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

<script src="{{ asset('js/moment-with-locales.min.js') }}"></script>
<script src="{{ asset('js/moment-timezone-with-data.min.js') }}"></script>
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
                // console.log('Data dari server:', data.applicants);
                const count = data.applicants.length;
                document.getElementById('count_filter').innerText = count;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    const changeFilter = () => {
        let dateStart = document.getElementById('date_start').value || 'all';
        let dateEnd = document.getElementById('date_end').value || 'all';
        let yearGrad = document.getElementById('year_grad').value || 'all';
        let pmbVal = document.getElementById('change_pmb').value;
        let sourceVal = document.getElementById('change_source').value;
        let statusVal = document.getElementById('change_status').value;

        urlData = `get/databases/${pmbVal}/${sourceVal}/${dateStart}/${dateEnd}/${yearGrad}/${statusVal}`;
        if (dataTableInitialized) {
            dataTableInstance.ajax.url(urlData).load();
            getAPI();
        } else {
            getDataTable();
        }
    }

    const handleEnterKeyPress = (event) => {
        if (event.keyCode == 13) {
            changeFilter();
        }
    }

    const resetFilter = () => {
        urlData = `get/databases`;
        if (dataTableInitialized) {
            dataTableInstance.ajax.url(urlData).load();
            getAPI();
            document.getElementById('year_grad').value = '';
            document.getElementById('change_pmb').value = '';
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
                [0, 'desc']
            ],
            columns: [{
                    data: 'created_at',
                    render: (data) => {
                        return moment(data).tz('Asia/Jakarta').locale('id').format('LL');
                    }
                },
                {
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
                        return typeof(data) == 'number' ? data : 'Tidak diketahui';
                    }
                },
                {
                    data: 'source_setting',
                    render: (data, type, row) => {
                        return data.name;
                    }
                },
                {
                    data: 'applicant_status',
                    render: (data, type, row) => {
                        return data.name;
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
                        source_id: 'source_id',
                        status_id: 'status_id'
                    },
                    render: (data, type, row) => {
                        let showUrl = "{{ route('database.show', ':identity') }}".replace(
                            ':identity',
                            data.identity);
                        let editUrl = "{{ route('database.edit', ':id') }}".replace(':id',
                            data.id);
                        let folder = data.status_id == 4 || data.status_id == 3 ?
                            `<a href="${showUrl}" class="inline-block bg-sky-500 hover:bg-sky-600 px-3 py-1 rounded-md text-xs text-white"><i class="fa-regular fa-folder-open"></i></a>` :
                            `<button class="inline-block border border-gray-300 px-3 py-1 rounded-md text-xs text-gray-400"><i class="fa-regular fa-folder-open"></i></button>`;
                        return `
                        <div class="flex items-center gap-1">
                            ${folder}
                            <button class="bg-sky-500 hover:bg-sky-600 px-3 py-1 rounded-md text-xs text-white" onclick="event.preventDefault(); copyRecord('${data.name}','${data.phone}','${data.school}','${data.year}','${data.source_id}',)">
                                <i class="fa-solid fa-copy"></i>
                            </button>
                            <a href="${editUrl}" class="bg-amber-500 hover:bg-amber-600 px-3 py-1 rounded-md text-xs text-white">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <button class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded-md text-xs text-white" onclick="event.preventDefault(); deleteRecord(${data.id})">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>`
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
                    console.log(error);
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
                contentSource = 'MGM'
                break;
            case "3":
                contentSource = 'Sosial Media'
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
