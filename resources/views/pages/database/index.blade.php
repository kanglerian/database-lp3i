@push('styles')
    <link href="{{ asset('css/select2-custom.css') }}" rel="stylesheet" />
@endpush
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Database') }}
            </h2>
            <div class="flex flex-wrap justify-center items-center gap-2 px-2 text-gray-600">
                <div>
                    <form action="{{ route('applicant.importupdate') }}" method="post" enctype="multipart/form-data"
                        class="flex items-center gap-2">
                        @csrf
                        @if (Auth::user()->role == 'P')
                            <input type="hidden" name="identity_user" value="{{ Auth::user()->identity }}"
                                placeholder="Nomor presenter">
                        @else
                            <div>
                                <x-select name="identity_user"
                                    class="w-52 {{ $errors->first('identity_user') ? 'border border-red-500' : '' }} text-xs mt-[0]"
                                    required>
                                    <option value="0">Pilih presenter</option>
                                    @foreach ($users as $presenter)
                                        <option value="{{ $presenter->identity }}">{{ $presenter->name }}
                                        </option>
                                    @endforeach
                                </x-select>
                            </div>
                        @endif
                        <input type="file" name="berkas" id="berkas"
                            class="text-xs border border-gray-200 bg-white px-2 py-1.5 rounded-md" required>
                        <button type="submit"
                            class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm space-x-1">
                            <i class="fa-solid fa-file-import"></i>
                        </button>
                    </form>
                </div>
                <div class="flex bg-gray-200 px-4 py-2 text-sm rounded-lg items-center gap-2">
                    <i class="fa-solid fa-database"></i>
                    <h2 id="count_filter">{{ $total }}</h2>
                </div>
                <button onclick="exportExcel()"
                    class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm space-x-1">
                    <i class="fa-solid fa-file-excel"></i>
                </button>
                <a id="downloadBlast" onclick="downloadBlast()"
                    class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-lg text-sm space-x-1">
                    <i class="fa-solid fa-download"></i>
                </a>
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
            <div class="flex items-center gap-3 mx-2">
                <a href="{{ route('database.create') }}"
                    class="bg-lp3i-100 hover:bg-lp3i-200 px-3 py-2 text-sm rounded-lg text-white"><i
                        class="fa-solid fa-circle-plus"></i> Tambah Data</a>
            </div>
            <div
                class="bg-white rounded-xl border border-gray-200 flex items-center gap-3 text-gray-500 overflow-x-auto pb-4 px-4 py-2 mx-2">
                <div class="flex items-end gap-3">
                    <div class="w-32 space-y-1">
                        <label for="date_start" class="text-xs">Tanggal awal:</label>
                        <input type="date" id="date_start" onchange="changeFilter()"
                            class="w-full bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                    </div>
                    <div class="w-32 space-y-1">
                        <label for="" class="text-xs">Tanggal akhir:</label>
                        <input type="date" id="date_end" onchange="changeFilter()"
                            class="w-full bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                    </div>
                    <div class="w-32 space-y-1">
                        <label for="" class="text-xs">Tahun lulus:</label>
                        <input type="number" id="year_grad" onkeyup="changeFilter()"
                            class="w-full bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
                            placeholder="Tahun lulus">
                    </div>
                    @if (Auth::user()->role == 'A')
                        <div class="w-32 space-y-1">
                            <label for="" class="text-xs">Presenter:</label>
                            <select id="identity_user" onchange="changeFilter()"
                                class="js-example-basic-single w-full bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                                <option value="all">Pilih presenter</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->identity }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="w-32 space-y-1">
                        <label for="" class="text-xs">Asal sekolah:</label>
                        <select id="school" onchange="changeFilter()"
                            class="js-example-basic-single w-full bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                            <option value="all">Pilih sekolah</option>
                            <option value="0">Tidak diketahui</option>
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-32 space-y-1">
                        <label for="" class="text-xs">Tanggal lahir:</label>
                        <input type="date" id="birthday" onkeyup="changeFilter()"
                            class="w-full bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
                            placeholder="Tanggal Lahir">
                    </div>
                    <div class="w-32 space-y-1">
                        <label for="" class="text-xs">Periode PMB:</label>
                        <input type="number" id="change_pmb" onkeyup="changeFilter()"
                            class="w-full bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
                            placeholder="Tahun PMB">
                    </div>
                    <div class="w-32 space-y-1">
                        <label for="" class="text-xs">Prestasi:</label>
                        <input type="text" id="change_achievement" onkeyup="changeFilter()"
                            class="w-full bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
                            placeholder="Prestasi">
                    </div>
                    <div class="w-32 space-y-1">
                        <label for="" class="text-xs">Relasi:</label>
                        <input type="text" id="change_relation" onkeyup="changeFilter()"
                            class="w-full bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
                            placeholder="Relasi">
                    </div>
                    <div class="w-32 space-y-1">
                        <label for="" class="text-xs">Pekerjaan Ayah:</label>
                        <input type="text" id="change_jobfather" onkeyup="changeFilter()"
                            class="w-full bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
                            placeholder="Pekerjaan Ayah">
                    </div>
                    <div class="w-32 space-y-1">
                        <label for="" class="text-xs">Pekerjaan Ibu:</label>
                        <input type="text" id="change_jobmother" onkeyup="changeFilter()"
                            class="w-full bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
                            placeholder="Pekerjaan Ibu">
                    </div>
                    <div class="w-32 space-y-1">
                        <label for="" class="text-xs">Ket. Follow Up:</label>
                        <select id="change_follow" onchange="changeFilter()"
                            class="w-full bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                            <option value="all">Keterangan</option>
                            @foreach ($follows as $follow)
                                <option value="{{ $follow->id }}">{{ $follow->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-32 space-y-1">
                        <label for="" class="text-xs">Datang ke LP3I</label>
                        <select id="change_come" onchange="changeFilter()"
                            class="w-full bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                            <option value="all">Pilih</option>
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
                    <div class="w-32 space-y-1">
                        <label for="" class="text-xs">KIP</label>
                        <select id="change_kip" onchange="changeFilter()"
                            class="w-full bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                            <option value="all">Pilih</option>
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
                    <div class="w-32 space-y-1">
                        <label for="" class="text-xs">Sumber:</label>
                        <select id="change_source" onchange="changeFilter()"
                            class="w-full bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                            <option value="all">Sumber</option>
                            @foreach ($sources as $source)
                                <option value="{{ $source->id }}">{{ $source->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-32 space-y-1">
                        <label for="" class="text-xs">Status:</label>
                        <select id="change_status" onchange="changeFilter()"
                            class="w-full bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                            <option value="all">Status</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </div>
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
                                        <i class="fa-solid fa-user"></i>
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        Tanggal
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        Nama lengkap
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        No. Telpon (Whatsapp)
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        Asal sekolah
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        Tahun lulus
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        Sumber
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
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
@include('pages.database.database.filter')
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });

    const getDataTable = async () => {
        const dataTableConfig = {
            ajax: {
                url: urlData,
                dataSrc: 'applicants'
            },
            order: [
                [0, 'desc']
            ],
            columnDefs: [{
                    width: 10,
                    target: 0
                },
                {
                    width: 150,
                    target: 1
                },
                {
                    width: 200,
                    target: 2
                },
                {
                    width: 100,
                    target: 3
                },
                {
                    width: 150,
                    target: 4
                },
                {
                    width: 150,
                    target: 5
                },
                {
                    width: 100,
                    target: 6
                },
                {
                    width: 50,
                    target: 7
                },
            ],
            columns: [{
                    data: 'id',
                    render: (data) => {
                        return `<i class="fa-regular fa-circle-dot"></i>`;
                    }
                },
                {
                    data: 'created_at',
                    render: (data) => {
                        return moment(data).tz('Asia/Jakarta').locale('id').format('LL');
                    }
                },
                {
                    data: {
                        identity: 'identity',
                        name: 'name',
                        phone: 'phone'
                    },
                    render: (data, type, row) => {
                        let editUrl = "{{ route('histories.show', ':identity') }}".replace(
                            ':identity',
                            data.identity);
                        return data.phone == null ? `<span class="font-bold">${data.name}</span>` :
                            `<a href="${editUrl}" class="font-bold underline">${data.name}</a>`;
                    }
                },
                {
                    data: 'phone',
                    render: (data) => {
                        return typeof(data) == 'object' ? 'Tidak diketahui' : data;
                    }
                },
                {
                    data: 'school_applicant',
                    render: (data) => {
                        return data == null ? 'Tidak diketahui' : data.name;
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
        try {
            const response = await fetch(urlData);
            const data = await response.json();
            // Tampilkan data applicants di console
            dataApplicants = data.applicants;
            dataTableInstance = $('#myTable').DataTable(dataTableConfig);
            dataTableInitialized = true;
        } catch (error) {
            console.error("Error fetching data:", error);
        }
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

    const downloadBlast = () => {
        var content = '';
        dataApplicants.forEach(applicant => {
            content += `${applicant.name},${applicant.phone == null ? '0000000000' : applicant.phone}\n`
        });
        var downloadBlast = document.getElementById('downloadBlast');
        var blob = new Blob([content], {
            type: "text/plain"
        });
        downloadBlast.href = URL.createObjectURL(blob);
        downloadBlast.download = `file-blast-applicant.txt`;
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

    const exportExcel = () => {
        $.ajax({
            url: urlExcel,
            method: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            success: (response, status, xhr) => {
                console.log('Berhasil!');
                const filename = xhr.getResponseHeader('Content-Disposition')
                    .split(';')[1]
                    .trim()
                    .split('=')[1];
                const blob = new Blob([response], {
                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            },
            error: () => {
                console.log('Terjadi kesalahan saat melakukan eksport');
            }
        });
    }
</script>
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
            $('.js-example-input-single').select2();
        });
    </script>
@endpush
