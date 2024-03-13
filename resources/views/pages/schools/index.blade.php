<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
            <div class="flex items-center gap-10">
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Daftar Sekolah') }}
                </h2>
            </div>
            <div class="flex flex-wrap justify-center items-center gap-3 px-2 text-gray-600">
                <div class="flex bg-gray-200 px-4 py-2 text-sm rounded-xl items-center gap-2">
                    <i class="fa-solid fa-database"></i>
                    <h2 id="count_filter">0</h2>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-5 py-10">

        <div class="max-w-7xl px-5 mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                <div class="flex items-end flex-wrap md:flex-nowrap text-gray-500 md:gap-3 order-2 md:order-none">
                    <div class="inline-block flex flex-col space-y-1 p-1 md:p-0">
                        <label for="change_pmb" class="text-xs">Periode PMB:</label>
                        <input type="number" id="change_pmb" onchange="changeTrigger()"
                            class="w-full md:w-[150px] bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800"
                            placeholder="Tahun PMB">
                    </div>
                    <div class="inline-block flex flex-col space-y-1 p-1 md:p-0">
                        <label for="region" class="text-xs">Wilayah:</label>
                        <select id="region" onchange="changeTrigger()"
                            class="w-full md:w-[150px] bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800">
                            <option value="all">Pilih wilayah</option>
                            @foreach ($schools_by_region as $region)
                                <option value="{{ $region->region }}">{{ $region->region }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl px-5 mx-auto">
            @if (session('message'))
                <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-2xl"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-reguler">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
        </div>


        @if ($slepets > 0)
            <section class="max-w-7xl px-5 mx-auto">
                <div class="px-6 py-5 mb-4 text-red-800 rounded-3xl bg-red-50 border border-red-200">
                    <div class="flex items-center">
                        <i class="fa-solid fa-circle-info mr-2"></i>
                        <span class="sr-only">Info</span>
                        <h3 class="text-lg font-medium">Lakukan Update Data Sekolah!</h3>
                    </div>
                    <div class="mt-2 mb-4 text-sm">
                        Dalam daftar ini, terdapat sekitar <span class="font-bold">{{ $slepets }}</span> entri
                        sekolah yang masih menunggu penyesuaian wilayah, status, dan jenisnya. Penting untuk mengubahnya
                        agar laporan menjadi lebih akurat.
                    </div>
                    <div class="flex">
                        <button onclick="showUpdate()"
                            class="text-white bg-red-800 hover:bg-red-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-reguler rounded-xl text-xs px-4 py-1.5 me-2 text-center inline-flex items-center">
                            <i class="fa-solid fa-filter mr-2"></i>
                            Tampilkan Data
                        </button>
                    </div>
                </div>
            </section>
        @endif

        <div class="max-w-7xl px-5 mx-auto">
            <div class="bg-gray-50 overflow-hidden border rounded-3xl">
                <div class="p-8 bg-white border-b border-gray-200">
                    <div class="relative overflow-x-auto">
                        <table id="table-schools" class="w-full text-sm text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 rounded-l-xl">
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
                                        Valid
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Non Valid
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
                                    <th scope="col" class="px-6 py-3 rounded-r-xl">
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
@include('utilities.pmb')
@include('pages.schools.modals.school')

<script>
    let urlSchools = `/api/school/getsources?pmbVal=${pmbVal}`;
    let dataTableDataSchoolInstance;
    let dataTableDataSchoolInitialized = false;

    const showUpdate = () => {
        let queryParams = [];
        let regionVal = 'TIDAK DIKETAHUI';

        if (regionVal !== 'all') {
            queryParams.push(`regionVal=${regionVal}`);
        }

        let queryString = queryParams.join('&');

        urlSchools = `/api/school/getsources?${queryString}`;

        if (dataTableDataSchoolInstance) {
            showLoadingAnimation();
            dataTableDataSchoolInstance.clear();
            dataTableDataSchoolInstance.destroy();
            getDataTableSchools()
                .then((response) => {
                    dataTableDataSchoolInstance = $('#table-schools').DataTable(response.config);
                    dataTableDataSchoolInitialized = response.initialized;
                    hideLoadingAnimation();
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }

    const changeTrigger = () => {
        let queryParams = [];
        let pmbVal = document.getElementById('change_pmb').value;
        let regionVal = document.getElementById('region').value;

        if (pmbVal !== 'all') {
            queryParams.push(`pmbVal=${pmbVal}`);
        }

        if (regionVal !== 'all') {
            queryParams.push(`regionVal=${regionVal}`);
        }

        let queryString = queryParams.join('&');

        urlSchools = `/api/school/getsources?${queryString}`;

        if (dataTableDataSchoolInstance) {
            showLoadingAnimation();
            dataTableDataSchoolInstance.clear();
            dataTableDataSchoolInstance.destroy();
            getDataTableSchools()
                .then((response) => {
                    dataTableDataSchoolInstance = $('#table-schools').DataTable(response.config);
                    dataTableDataSchoolInitialized = response.initialized;
                    hideLoadingAnimation();
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }

    const getDataTableSchools = () => {
        return new Promise(async (resolve, reject) => {
            try {
                const responses = await axios.get(urlSchools);
                let databases = responses.data.schools;

                document.getElementById('count_filter').innerText = databases.length;

                const dataTableConfig = {
                    data: databases,
                    columnDefs: [{
                        width: 50,
                        target: 0
                    }],
                    createdRow: (row, data, index) => {
                        if (index % 2 != 0) {
                            $(row).css('background-color', '#f9fafb');
                        }
                    },
                    columns: [{
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
                                let showUrl = "{{ route('schools.show', ':id') }}".replace(
                                    ':id',
                                    data.id);
                                return `<a href="${showUrl}" class="font-bold underline">${data.nama} ${data.id}</a>`;
                            }
                        },
                        {
                            data: 'jumlah'
                        },
                        {
                            data: 'valid'
                        },
                        {
                            data: 'nonvalid'
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
                let results = {
                    config: dataTableConfig,
                    initialized: true
                }

                resolve(results);
            } catch (error) {
                reject(error);
            }
        });
    }


    const promiseDataSchools = () => {
        showLoadingAnimation();
        Promise.all([
                getDataTableSchools(),
            ])
            .then((response) => {
                let responseDTS = response[0];
                dataTableDataSchoolInstance = $('#table-schools').DataTable(responseDTS
                    .config);
                dataTableDataSchoolInitialized = responseDTS.initialized;
                hideLoadingAnimation();
            })
            .catch((error) => {
                console.log(error);
            });
    }
    promiseDataSchools();
</script>
