<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0 h-10">
            <nav class="flex">
                <ol class="inline-flex items-center space-x-2 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">
                            <i class="fa-solid fa-table-columns mr-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">
                                Rekap Perolehan PMB
                            </span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <section class="space-y-5 py-8">
        <div class="max-w-7xl px-5 mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                <div class="flex items-end flex-wrap md:flex-nowrap text-gray-500 md:gap-3 order-2 md:order-none">
                    <input type="hidden" id="identity_val" value="{{ Auth::user()->identity }}">
                    <input type="hidden" id="role_val" value="{{ Auth::user()->role }}">
                    <div class="inline-block flex flex-col space-y-1 p-1 md:p-0">
                        <label for="change_pmb" class="text-xs">Periode PMB:</label>
                        <input type="number" id="change_pmb" onchange="changeTrigger()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
                            placeholder="Tahun PMB">
                    </div>
                    <div class="inline-block flex flex-col space-y-1 p-1 md:p-0">
                        <label for="session" class="text-xs">Gelombang:</label>
                        <select id="session" onchange="changeTrigger()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                            <option value="all">Pilih</option>
                            <option value="1">Gelombang 1</option>
                            <option value="2">Gelombang 2</option>
                            <option value="3">Gelombang 3</option>
                            <option value="4">Gelombang 4</option>
                        </select>
                    </div>
                    <div class="inline-block flex flex-col space-y-1 p-1 md:p-0">
                        <label for="programtype_id" class="text-xs">Program Kuliah:</label>
                        <select id="programtype_id" onchange="changeTrigger()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                            <option value="all">Pilih</option>
                            @foreach ($program_types as $programtype)
                                <option value="{{ $programtype->id }}">{{ $programtype->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="px-6 py-2 rounded-xl text-sm bg-white border border-gray-100 order-1 md:order-none">
                    <div>
                        <span class="font-bold">{{ Auth::user()->name }}</span>
                        (<span onclick="copyIdentity('{{ Auth::user()->identity }}')">ID:
                            {{ Auth::user()->identity }}</span>)
                        <button onclick="copyIdentity('{{ Auth::user()->identity }}')" class="text-blue-500"><i
                                class="fa-regular fa-copy"></i></button>
                    </div>
                    <span class="text-xs text-gray-600">Gunakan Key Identity ini di aplikasi Whatsapp
                        Sender.</span>
                </div>
            </div>
        </div>
        <div class="max-w-7xl px-5 mx-auto">
            <section class="bg-white p-5 md:rounded-xl border border-gray-100 space-y-5">
                <header class="space-y-1 mb-5">
                    <div class="flex items-center gap-2">
                        <i class="fa-regular fa-circle-dot"></i>
                        <h2 class="font-bold text-gray-800">Rekap Perolehan PMB</h2>
                    </div>
                    <p class="text-sm text-gray-700 text-sm">
                        Berikut ini adalah hasil perhitungan dari riwayat pesan.
                    </p>
                </header>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500"
                        id="table-report-perolehan-pmb">
                        <thead class="text-xs text-gray-700 uppercase">
                            <tr>
                                <th rowspan="2" scope="col" class="px-6 py-4 text-center">
                                    No
                                </th>
                                <th rowspan="2" scope="col" class="px-6 py-4 text-center">
                                    Bulan
                                </th>
                                <th rowspan="2" scope="col" class="px-6 py-4 text-center">
                                    Aplikan
                                </th>
                                <th rowspan="2" scope="col" class="px-6 py-4 text-center">
                                    Daftar
                                </th>
                                <th colspan="2" scope="col" class="px-6 py-4 text-center">
                                    Registrasi
                                </th>
                                <th rowspan="2" scope="col" class="px-6 py-4 text-center">
                                    Total Registrasi
                                </th>
                                <th colspan="2" scope="col" class="px-6 py-4 text-center">
                                    Potensi Omset
                                </th>
                                <th rowspan="2" scope="col" class="px-6 py-4 text-center">
                                    Total Potensi Omset
                                </th>
                                <th colspan="2" scope="col" class="px-6 py-4 text-center">
                                    Harga Jual Rata-Rata
                                </th>
                                <th rowspan="2" scope="col" class="px-6 py-4 text-center">
                                    Harga Jual Rata-Rata All
                                </th>
                            </tr>
                            <tr>
                                <th scope="col" class="px-6 py-4 text-center">
                                    Reguler
                                </th>
                                <th scope="col" class="px-6 py-4 text-center">
                                    Non Reguler
                                </th>
                                <th scope="col" class="px-6 py-4 text-center">
                                    Reguler
                                </th>
                                <th scope="col" class="px-6 py-4 text-center">
                                    Non Reguler
                                </th>
                                <th scope="col" class="px-6 py-4 text-center">
                                    Reguler
                                </th>
                                <th scope="col" class="px-6 py-4 text-center">
                                    Non Reguler
                                </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </section>
        </div>
    </section>
    @push('scripts')
        <script>
            let dataTableDataPerolehanPMBInstance;
            let dataTableDataPerolehanPMBInitialized = false;
        </script>
        <script>
            const changeTrigger = () => {
                let queryParams = [];
                let pmbVal = document.getElementById('change_pmb').value;
                let identityVal = document.getElementById('identity_val').value;
                let sessionVal = document.getElementById('session').value;
                let programTypeVal = document.getElementById('programtype_id').value;

                if (pmbVal !== 'all') {
                    queryParams.push(`pmbVal=${pmbVal}`);
                }

                queryParams.push(`identityVal=${identityVal}`);

                if (sessionVal !== 'all') {
                    queryParams.push(`sessionVal=${sessionVal}`);
                }

                if (programTypeVal !== 'all') {
                    queryParams.push(`programTypeVal=${programTypeVal}`);
                }

                let queryString = queryParams.join('&');

                urlPerolehanPMB = `/api/report/database/perolehanpmb?${queryString}`;

                if (dataTableDataPerolehanPMBInstance) {
                    dataTableDataPerolehanPMBInstance.destroy();
                    getDataTablePerolehanPMB()
                        .then((response) => {
                            if (dataTableDataPerolehanPMBInstance) {
                                dataTableDataPerolehanPMBInstance.destroy();
                            }

                            dataTableDataPerolehanPMBInstance = $('#table-report-perolehan-pmb').DataTable(response
                                .config);
                            dataTableDataPerolehanPMBInitialized = response.initialized;
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }
            }
        </script>
        <script>
            const getDataTablePerolehanPMB = async () => {
                showLoadingAnimation();
                return new Promise(async (resolve, reject) => {
                    let database;
                    console.log(urlPerolehanPMB);
                    fetch(urlPerolehanPMB)
                        .then((response) => {
                            if (!response.ok) {
                                console.log('Network Error');
                            }
                            return response.json();
                        })
                        .then((data) => {
                            database = data;

                            const mergedData = data.reduce((accumulator, current) => {
                                const existingData = accumulator.find(
                                    (item) => item.month_number === current.month_number &&
                                    item.identity_user === current.identity_user
                                );

                                if (existingData) {
                                    existingData.register_regular = (parseInt(existingData
                                        .register_regular) || 0) + (parseInt(current
                                        .register_regular) || 0);
                                    existingData.register_nonreguler = (parseInt(existingData
                                        .register_nonreguler) || 0) + (parseInt(current
                                        .register_nonreguler) || 0);
                                    existingData.omset_reguler = (parseInt(existingData
                                        .omset_reguler) || 0) + (parseInt(current
                                        .omset_reguler) || 0);
                                    existingData.omset_nonreguler = (parseInt(existingData
                                        .omset_nonreguler) || 0) + (parseInt(current
                                        .omset_nonreguler) || 0);
                                } else {
                                    accumulator.push({
                                        ...current
                                    });
                                }

                                return accumulator;
                            }, []);


                            const dataTableConfig = {
                                data: mergedData,
                                columnDefs: [{
                                    width: 10,
                                    target: 0
                                }, ],
                                columns: [{
                                        data: 'pmb',
                                        render: (data, type, row, meta) => {
                                            return meta.row + 1;
                                        }
                                    },
                                    {
                                        data: 'month_number',
                                        render: (data, type, row, meta) => {
                                            let result;
                                            let convert = parseInt(data);
                                            switch (convert) {
                                                case 1:
                                                    result = 'Januari';
                                                    break;
                                                case 2:
                                                    result = 'Februari';
                                                    break;
                                                case 3:
                                                    result = 'Maret';
                                                    break;
                                                case 4:
                                                    result = 'April';
                                                    break;
                                                case 5:
                                                    result = 'Mei';
                                                    break;
                                                case 6:
                                                    result = 'Juni';
                                                    break;
                                                case 7:
                                                    result = 'Juli';
                                                    break;
                                                case 8:
                                                    result = 'Agustus';
                                                    break;
                                                case 9:
                                                    result = 'September';
                                                    break;
                                                case 10:
                                                    result = 'Oktober';
                                                    break;
                                                case 11:
                                                    result = 'November';
                                                    break;
                                                case 12:
                                                    result = 'Desember';
                                                    break;
                                                default:
                                                    break;
                                            }
                                            return result;
                                        }
                                    },
                                    {
                                        data: 'aplikan',
                                        render: (data, type, row, meta) => {
                                            return parseInt(data) || 0;
                                        }
                                    },
                                    {
                                        data: 'daftar',
                                        render: (data, type, row, meta) => {
                                            return parseInt(data) || 0;
                                        }
                                    },
                                    {
                                        data: 'register_regular',
                                        render: (data, type, row, meta) => {
                                            return parseInt(data) || 0;
                                        }
                                    },
                                    {
                                        data: 'register_nonreguler',
                                        render: (data, type, row, meta) => {
                                            return parseInt(data) || 0;
                                        }
                                    },
                                    {
                                        data: {
                                            register_regular: 'register_regular',
                                            register_nonreguler: 'register_nonreguler'
                                        },
                                        render: (data, type, row, meta) => {
                                            let result = (parseInt(data.register_regular) ||
                                                0) + (parseInt(
                                                data.register_nonreguler) || 0);
                                            return result;
                                        }
                                    },
                                    {
                                        data: 'omset_reguler',
                                        render: (data, type, row, meta) => {
                                            let result = parseInt(data) || 0;
                                            return `Rp${result.toLocaleString('id-ID')}`;
                                        }
                                    },
                                    {
                                        data: 'omset_nonreguler',
                                        render: (data, type, row, meta) => {
                                            let result = parseInt(data) || 0;
                                            return `Rp${result.toLocaleString('id-ID')}`;
                                        }
                                    },
                                    {
                                        data: {
                                            omset_reguler: 'omset_reguler',
                                            omset_nonreguler: 'omset_nonreguler'
                                        },
                                        render: (data, type, row, meta) => {
                                            let result = (parseInt(data.omset_reguler) ||
                                                0) + (
                                                parseInt(
                                                    data.omset_nonreguler) || 0);
                                            return `Rp${result.toLocaleString('id-ID')}`;
                                        }
                                    },
                                    {
                                        data: {
                                            register_regular: 'register_regular',
                                            omset_reguler: 'omset_reguler',
                                        },
                                        render: (data, type, row, meta) => {
                                            let registerRegular = parseInt(data
                                                .register_regular) || 0;
                                            let omsetReguler = parseInt(data
                                                    .omset_reguler) ||
                                                0;
                                            if (registerRegular === 0) {
                                                return 'Rp0';
                                            }
                                            let result = omsetReguler / registerRegular;
                                            return `Rp${result.toLocaleString('id-ID')}`;
                                        }
                                    },
                                    {
                                        data: {
                                            register_nonreguler: 'register_nonreguler',
                                            omset_nonreguler: 'omset_nonreguler',
                                        },
                                        render: (data, type, row, meta) => {
                                            let registerNonReguler = parseInt(data
                                                .register_nonreguler);
                                            let omsetNonReguler = parseInt(data
                                                .omset_nonreguler);
                                            if (isNaN(registerNonReguler) || isNaN(
                                                    omsetNonReguler)) {
                                                return `Rp0`;
                                            }
                                            if (registerNonReguler === 0) {
                                                return `Rp0`;
                                            }
                                            let result = omsetNonReguler /
                                                registerNonReguler;
                                            return `Rp${result.toLocaleString('id-ID')}`;
                                        }
                                    },
                                    {
                                        data: {
                                            register_regular: 'register_regular',
                                            register_nonreguler: 'register_nonreguler',
                                            omset_reguler: 'omset_reguler',
                                            omset_nonreguler: 'omset_nonreguler',
                                        },
                                        render: (data, type, row, meta) => {
                                            let registrasi = (parseInt(data
                                                    .register_regular) ||
                                                0) + (
                                                parseInt(
                                                    data.register_nonreguler) || 0);
                                            let omset = (parseInt(data.omset_reguler) ||
                                                0) + (
                                                parseInt(
                                                    data.omset_nonreguler) || 0);
                                            if (registrasi === 0) {
                                                return 'Rp0';
                                            }
                                            let result = omset / registrasi;
                                            return `Rp${result.toLocaleString('id-ID')}`;
                                        }
                                    },
                                ],
                            }


                            dataTableDataPerolehanPMBInstance = $('#table-report-perolehan-pmb')
                                .DataTable(
                                    dataTableConfig);
                            dataTableDataPerolehanPMBInitialized = true;
                            hideLoadingAnimation();
                            let result = {
                                config: dataTableConfig,
                                initialized: true
                            }
                            resolve(result);
                        })
                        .catch((error) => {
                            reject(error);
                        });
                });
            }
            getDataTablePerolehanPMB();
        </script>
    @endpush
    @include('pages.dashboard.utilities.scripts')
</x-app-layout>
