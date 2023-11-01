<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
            <div class="flex items-center gap-10">
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Daftar Sekolah') }}
                </h2>
                {{-- Loading animation --}}
                <div role="status" class="hidden" id="data-loading">
                    <svg aria-hidden="true"
                        class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="currentColor" />
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="currentFill" />
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="flex flex-wrap justify-center items-center gap-3 px-2 text-gray-600">
                <form action="{{ route('school.import') }}" id="form-school" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="berkas" id="berkas"
                        class="text-xs border border-gray-200 bg-white px-2 py-1.5 rounded-md" required>
                    <button type="submit"
                        class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm space-x-1">
                        <i class="fa-solid fa-file-import"></i>
                    </button>
                </form>
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

            <div class="flex flex-wrap">
                @foreach ($schools_by_region as $school_by_region)
                    <div class="block w-1/2 md:w-1/4 p-1">
                        <div class="flex justify-between items-center px-5 py-3 bg-lp3i-200 text-white rounded-xl">
                            <h4>
                                <i class="fa-solid fa-map-location-dot mr-1"></i>
                                <span class="text-sm">{{ $school_by_region->region }}</span>
                            </h4>
                            <span
                                class="bg-lp3i-100 text-white text-sm px-2 py-1 rounded-lg">{{ $school_by_region->jumlah }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="px-2">
                <button type="button" data-modal-target="schoolModal" onclick="changeSchoolModal(this)"
                    class="bg-lp3i-100 hover:bg-lp3i-200 px-3 py-2 text-sm rounded-lg text-white">
                    <i class="fa-solid fa-circle-plus"></i> Tambah Data</button>
            </div>

            @include('pages.schools.filters.filter')

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
                                        Wilayah
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nama
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Total
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Jumlah Kelas
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Presentasi
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Daftar Online
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Website
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Beasiswa
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Sosial Media
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Grab Data
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        MGM
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Sekolah
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Jadwal Datang
                                    </th>
                                    <th scope="col" class="px-6 py-3 rounded-t-lg">
                                        Guru BK
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

@include('pages.schools.modals.school')
@include('pages.schools.filters.filterjs')

<script>
    const getDataTable = async () => {
        const dataTableConfig = {
            ajax: {
                url: 'get/schools',
                dataSrc: 'schools'
            },
            columns: [
                {
                    data: 'grab',
                    render: (data, type, row, meta) => {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'wilayah',
                },
                {
                    data: {
                        id: 'id',
                        name: 'name',
                    },
                    render: (data, type, row) => {
                        let showUrl = "{{ route('school.show', ':id') }}".replace(
                            ':id',
                            data.id);
                        return `<a href="${showUrl}" class="font-bold underline">${data.nama}</a>`;
                    }
                },
                {
                    data: 'jumlah'
                },
                {
                    data: 'kelas',
                },
                {
                    data: 'presentasi'
                },
                {
                    data: 'daftaronline'
                },
                {
                    data: 'website'
                },
                {
                    data: 'beasiswa'
                },
                {
                    data: 'sosmed'
                },
                {
                    data: 'grab'
                },
                {
                    data: 'mgm'
                },
                {
                    data: 'sekolah'
                },
                {
                    data: 'jadwaldatang'
                },
                {
                    data: 'gurubk'
                },
            ],
        }
        try {
            const response = await fetch(urlData);
            const data = await response.json();
            dataSchools = data.schools;
            dataTableInstance = $('#myTable').DataTable(dataTableConfig);
            dataTableInitialized = true;
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    }
    getAPI();
    getDataTable();
</script>
