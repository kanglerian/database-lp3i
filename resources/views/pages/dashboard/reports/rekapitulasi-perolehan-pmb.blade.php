<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 pb-3">
            <nav class="flex">
                <ol class="inline-flex items-center space-x-2 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">
                            <i class="fa-solid fa-table-columns mr-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-300 mr-2"></i>
                            <a href="{{ route('dashboard.rekapitulasi_perolehan_pmb_page') }}"
                                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">Rekap Perolehan PMB</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Perolehan PMB</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <section class="space-y-5 py-10">
        <div class="max-w-7xl px-5 mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                <div
                    class="flex justify-center items-end flex-wrap md:flex-nowrap text-gray-500 md:gap-3 order-2 md:order-none">
                    <input type="hidden" id="identity_val" value="{{ Auth::user()->identity }}">
                    <input type="hidden" id="role_val" value="{{ Auth::user()->role }}">
                    <div class="w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
                        <label for="change_pmb" class="text-xs">Periode PMB:</label>
                        <input type="number" id="change_pmb" onchange="changeTrigger()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800"
                            placeholder="Tahun PMB">
                    </div>
                    <div class="w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
                        <label for="month" class="text-xs">Bulan:</label>
                        <input type="month" name="month" id="month" onchange="changeTrigger()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800"
                            placeholder="Tahun PMB">
                    </div>
                    <div class="w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
                        <label for="programtype_id" class="text-xs">Program Kuliah:</label>
                        <select id="programtype_id" onchange="changeTrigger()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800">
                            <option value="all">Pilih</option>
                            @foreach ($program_types as $programtype)
                                <option value="{{ $programtype->id }}">{{ $programtype->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="px-4 py-2 rounded-xl text-sm bg-gray-50 border border-gray-200 order-1 md:order-none">
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
            <section class="bg-gray-50 p-8 rounded-3xl border border-gray-200 space-y-5">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500"
                        id="table-report-perolehan-pmb">
                        <thead class="text-xs text-gray-700 uppercase">
                            <tr>
                                <th rowspan="2" scope="col" class="px-6 py-4 text-center">
                                    No
                                </th>
                                <th rowspan="2" scope="col" class="px-6 py-4 text-center">
                                    Presenter
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
                        <tfoot>
                            <tr>
                                <td colspan="3" class="font-bold">Total</td>
                                <td id="aplikan_foot">0</td>
                                <td id="daftar_foot">0</td>
                                <td id="register_reguler_foot">0</td>
                                <td id="register_nonreguler_foot">0</td>
                                <td id="register_foot">0</td>
                                <td id="omset_reguler_foot">0</td>
                                <td id="omset_nonreguler_foot">0</td>
                                <td id="omset_foot">0</td>
                                <td id="harga_reguler_foot">0</td>
                                <td id="harga_nonreguler_foot">0</td>
                                <td id="harga_foot">0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </section>
        </div>
    </section>
    @include('pages.dashboard.utilities.all')
    @include('pages.dashboard.utilities.pmb')
    @push('scripts')
        <script>
            let date = new Date();
            let year = date.getFullYear();
            let month = date.getMonth() + 1;

            let monthVal = document.getElementById('month').value = `${year}-${month.toString().padStart(2, '0')}`;
            let programTypeVal = document.getElementById('programtype_id').value;

            let dataTableDataPerolehanPMBInstance;
            let dataTableDataPerolehanPMBInitialized = false;
            let urlPerolehanPMB =
                `/api/report/database/perolehanpmb?pmbVal=${pmbVal}&identityVal=${identityVal}&roleVal=${roleVal}&monthVal=${monthVal}`;
        </script>
        <script>
            const changeFilterDataRekapPerolehan = () => {
                showLoadingAnimation();
                let queryParams = [];
                let pmbVal = document.getElementById('change_pmb').value;
                let identityVal = document.getElementById('identity_val').value;
                let roleVal = document.getElementById('role_val').value;
                let programTypeVal = document.getElementById('programtype_id').value;
                let monthVal = document.getElementById('month').value;

                if (pmbVal !== 'all') {
                    queryParams.push(`pmbVal=${pmbVal}`);
                }

                if (monthVal) {
                    let monthSplit = monthVal.split('-');
                    let monthReturn = parseInt(monthSplit[1], 10).toString();
                    pmbVal = document.getElementById('change_pmb').value = monthSplit[0];
                    queryParams.push(`monthVal=${monthReturn}`);
                }

                if (identityVal !== 'all') {
                    queryParams.push(`identityVal=${identityVal}`);
                }

                if (roleVal !== 'all') {
                    queryParams.push(`roleVal=${roleVal}`);
                }

                if (programTypeVal !== 'all') {
                    queryParams.push(`programTypeVal=${programTypeVal}`);
                }

                let queryString = queryParams.join('&');

                urlPerolehanPMB = `/api/report/database/perolehanpmb?${queryString}`;

                if (dataTableDataPerolehanPMBInstance) {
                    dataTableDataPerolehanPMBInstance.destroy();
                    getDataTableRekapPerolehan()
                        .then((response) => {
                            dataTableDataPerolehanPMBInstance = $('#table-report-perolehan-pmb').DataTable(response
                                .config);
                            dataTableDataPerolehanPMBInitialized = response.initialized;
                            hideLoadingAnimation();
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }
            }
        </script>
        <script>
            const changeTrigger = () => {
                changeFilterDataRekapPerolehan();
            }
        </script>
        <script>
            const getDataTableRekapPerolehan = async () => {
                return new Promise(async (resolve, reject) => {
                    try {
                        const response = await axios.get(urlPerolehanPMB);
                        let databases = response.data;

                        const mergedData = databases.reduce((accumulator, current) => {
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

                        let aplikan_total = 0;
                        let daftar_total = 0;
                        let register_reguler_total = 0;
                        let register_nonreguler_total = 0;
                        let omset_reguler_total = 0;
                        let omset_nonreguler_total = 0;

                        mergedData.forEach(merged => {
                            aplikan_total += parseInt(merged.aplikan) || 0;
                            daftar_total += parseInt(merged.daftar) || 0;
                            register_reguler_total += parseInt(merged.register_regular) ||
                                0;
                            register_nonreguler_total += parseInt(merged
                                .register_nonreguler) || 0;
                            omset_reguler_total += parseInt(merged.omset_reguler) || 0;
                            omset_nonreguler_total += parseInt(merged.omset_nonreguler) ||
                                0;
                        });

                        document.getElementById('aplikan_foot').innerText = aplikan_total;
                        document.getElementById('daftar_foot').innerText = daftar_total;
                        document.getElementById('register_reguler_foot').innerText =
                            register_reguler_total;
                        document.getElementById('register_nonreguler_foot').innerText =
                            register_nonreguler_total;
                        document.getElementById('register_foot').innerText =
                            register_reguler_total + register_nonreguler_total;
                        document.getElementById('omset_reguler_foot').innerText =
                            `Rp${omset_reguler_total.toLocaleString('id-ID')}`;
                        document.getElementById('omset_nonreguler_foot').innerText =
                            `Rp${omset_nonreguler_total.toLocaleString('id-ID')}`;
                        document.getElementById('omset_foot').innerText =
                            `Rp${(omset_reguler_total + omset_nonreguler_total).toLocaleString('id-ID')}`;

                        document.getElementById('harga_reguler_foot').innerText =
                            `Rp${(omset_reguler_total / register_reguler_total).toLocaleString('id-ID')}`;
                        document.getElementById('harga_nonreguler_foot').innerText =
                            `Rp${(omset_nonreguler_total / register_nonreguler_total).toLocaleString('id-ID')}`;
                        document.getElementById('harga_foot').innerText =
                            `Rp${((omset_reguler_total + omset_nonreguler_total) / (register_reguler_total + register_nonreguler_total)).toLocaleString('id-ID')}`;

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
                                    data: 'presenter',
                                    render: (data, type, row, meta) => {
                                        return data;
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

                        let result = {
                            config: dataTableConfig,
                            initialized: true
                        }
                        resolve(result);
                    } catch (error) {
                        reject(error)
                    }
                });
            }
        </script>

        <script>
            const promiseDataRekapPerolehan = () => {
                showLoadingAnimation();
                Promise.all([
                        getDataTableRekapPerolehan(),
                    ])
                    .then((response) => {
                        dataTableDataPerolehanPMBInstance = $('#table-report-perolehan-pmb').DataTable(response[0]
                            .config);
                        dataTableDataPerolehanPMBInitialized = response[0].initialized;
                        hideLoadingAnimation();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
            promiseDataRekapPerolehan();
        </script>
    @endpush
</x-app-layout>
