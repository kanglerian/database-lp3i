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
                                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">Rekap
                                Perolehan PMB</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">
                                Rekapitulasi Pencapaian PMB
                            </span>
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
                    <div class="inline-block flex flex-col space-y-1 p-1 md:p-0">
                        <label for="change_pmb" class="text-xs">Periode PMB:</label>
                        <input type="number" id="change_pmb" onchange="changeFilter()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800"
                            placeholder="Tahun PMB">
                    </div>
                    <div class="inline-block flex flex-col space-y-1 p-1 md:p-0">
                        <label for="date" class="text-xs">Tanggal:</label>
                        <input type="date" id="date" onchange="changeFilter()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800">
                    </div>
                    <div class="inline-block flex flex-col space-y-1 p-1 md:p-0">
                        <label for="session" class="text-xs">Gelombang:</label>
                        <select id="session" onchange="changeFilter()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800">
                            <option value="all">Pilih</option>
                            <option value="1">Gelombang 1</option>
                            <option value="2">Gelombang 2</option>
                            <option value="3">Gelombang 3</option>
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

        @if (Auth::user()->role == 'A')
            <div class="max-w-7xl px-5 mx-auto">
                <section class="bg-gray-50 p-8 rounded-3xl border border-gray-200 space-y-5">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500"
                            id="table-report-target-presenter">
                            <thead class="text-xs text-gray-700 uppercase">
                                <tr>
                                    <th rowspan="2" scope="col" class="px-6 py-4 text-center">No</th>
                                    <th rowspan="2" scope="col" class="px-6 py-4 text-center">Presenter</th>
                                    <th colspan="2" scope="col" class="px-6 py-4 text-center">Sales Volume</th>
                                    <th rowspan="2" scope="col" class="px-6 py-4 text-center">%</th>
                                    <th colspan="2" scope="col" class="px-6 py-4 text-center">Sales Revenue</th>
                                    <th rowspan="2" scope="col" class="px-6 py-4 text-center">%</th>
                                </tr>
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-center">Target</th>
                                    <th scope="col" class="px-6 py-4 text-center">Realisasi</th>
                                    <th scope="col" class="px-6 py-4 text-center">Target</th>
                                    <th scope="col" class="px-6 py-4 text-center">Realisasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0%</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0%</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="font-bold">Total</td>
                                    <td id="target_volume_presenter">0</td>
                                    <td id="realization_volume_presenter">0</td>
                                    <td id="percent_volume_presenter">0%</td>
                                    <td id="target_revenue_presenter">0</td>
                                    <td id="realization_revenue_presenter">0</td>
                                    <td id="percent_revenue_presenter">0%</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </section>
            </div>
        @endif

        <div class="max-w-7xl px-5 mx-auto">
            <section class="bg-gray-50 p-8 rounded-3xl border border-gray-200 space-y-5">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500" id="table-report-target-month">
                        <thead class="text-xs text-gray-700 uppercase">
                            <tr>
                                <th rowspan="2" scope="col" class="px-6 py-4 text-center">No</th>
                                <th rowspan="2" scope="col" class="px-6 py-4 text-center">Bulan</th>
                                <th colspan="2" scope="col" class="px-6 py-4 text-center">Sales Volume</th>
                                <th rowspan="2" scope="col" class="px-6 py-4 text-center">%</th>
                                <th colspan="2" scope="col" class="px-6 py-4 text-center">Sales Revenue</th>
                                <th rowspan="2" scope="col" class="px-6 py-4 text-center">%</th>
                            </tr>
                            <tr>
                                <th scope="col" class="px-6 py-4 text-center">Target</th>
                                <th scope="col" class="px-6 py-4 text-center">Realisasi</th>
                                <th scope="col" class="px-6 py-4 text-center">Target</th>
                                <th scope="col" class="px-6 py-4 text-center">Realisasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0%</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0%</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="font-bold">Total</td>
                                <td id="target_volume_month">0</td>
                                <td id="realization_volume_month">0</td>
                                <td id="percent_volume_month">0%</td>
                                <td id="target_revenue_month">0</td>
                                <td id="realization_revenue_month">0</td>
                                <td id="percent_revenue_month">0%</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </section>
        </div>

    </section>
    @include('pages.dashboard.utilities.pmb')
    @push('scripts')
        <script>
            let dataTableDataTargetByMonthInstance;
            let dataTableDataTargetByMonthInitialized = false;
            let urlTargetMonth =
                `/api/report/database/target/month?pmbVal=${pmbVal}`;
        </script>

        <script>
            const changeFilterDataTargetByMonth = () => {
                let queryParams = [];

                let pmbVal = document.getElementById('change_pmb').value;

                if (pmbVal !== 'all') {
                    queryParams.push(`pmbVal=${pmbVal}`);
                }

                let queryString = queryParams.join('&');

                urlTargetMonth = `/api/report/database/target/month?${queryString}`;

                if (dataTableDataTargetByMonthInstance) {
                    showLoadingAnimation();
                    dataTableDataTargetByMonthInstance.clear();
                    dataTableDataTargetByMonthInstance.destroy();
                    getDataTableTargetByMonth()
                        .then((response) => {
                            dataTableDataTargetByMonthInstance = $('#table-report-target-month').DataTable(
                                response
                                .config);
                            dataTableDataTargetByMonthInitialized = response.initialized;
                            hideLoadingAnimation();
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }
            }

            const getDataTableTargetByMonth = async () => {
                return new Promise(async (resolve, reject) => {
                    try {
                        const response = await axios.get(urlTargetMonth);
                        let register = response.data.databases;

                        let totalTargetVolume = 0;
                        let totalRealizationVolume = 0;

                        let totalTargetRevenue = 0;
                        let totalRealizationRevenue = 0;

                        register.forEach(regist => {
                            totalTargetVolume += parseInt(regist.target_volume);
                            totalTargetRevenue += parseInt(regist.target_revenue);
                            totalRealizationVolume += parseInt(regist.realization_volume);
                            totalRealizationRevenue += parseInt(regist.realization_revenue);
                        });

                        document.getElementById('target_volume_month').innerText = totalTargetVolume;
                        document.getElementById('realization_volume_month').innerText =
                            totalRealizationVolume;
                        document.getElementById('percent_volume_month').innerText =
                            `${(totalRealizationVolume / totalTargetVolume * 100).toFixed()}%`;
                        document.getElementById('target_revenue_month').innerText =
                            `Rp${totalTargetRevenue.toLocaleString('id-ID')}`;
                        document.getElementById('realization_revenue_month').innerText =
                            `Rp${totalRealizationRevenue.toLocaleString('id-ID')}`;
                        document.getElementById('percent_revenue_month').innerText =
                            `${(totalTargetRevenue / totalRealizationRevenue * 100).toFixed()}%`;

                        let columnConfigs = [{
                                data: 'pmb',
                                render: (data, type, row, meta) => {
                                    return meta.row + 1;
                                },
                            },
                            {
                                data: 'date_volume',
                                render: (data, type, row, meta) => {
                                    let result;
                                    switch (parseInt(data)) {
                                        case 1:
                                            result = 'Januari'
                                            break;
                                        case 2:
                                            result = 'Februari'
                                            break;
                                        case 3:
                                            result = 'Maret'
                                            break;
                                        case 4:
                                            result = 'April'
                                            break;
                                        case 5:
                                            result = 'Mei'
                                            break;
                                        case 6:
                                            result = 'Juni'
                                            break;
                                        case 7:
                                            result = 'Juli'
                                            break;
                                        case 8:
                                            result = 'Agustus'
                                            break;
                                        case 9:
                                            result = 'September'
                                            break;
                                        case 10:
                                            result = 'Oktober'
                                            break;
                                        case 11:
                                            result = 'November'
                                            break;
                                        case 12:
                                            result = 'Desember'
                                            break;
                                        default:
                                            result = 'Yok ndak tau!'
                                            break;
                                    }
                                    return result.toUpperCase();
                                }
                            },
                            {
                                data: 'target_volume',
                                render: (data, type, row, meta) => {
                                    return data;
                                }
                            },
                            {
                                data: 'realization_volume',
                                render: (data, type, row, meta) => {
                                    return data;
                                }
                            },
                            {
                                data: {
                                    target_volume: 'target_volume',
                                    realization_volume: 'realization_volume'
                                },
                                render: (data, type, row, meta) => {
                                    let target = parseInt(data.target_volume);
                                    let realization = parseInt(data.realization_volume);
                                    let result = realization / target * 100;
                                    return `${result.toFixed()}%`;
                                }
                            },
                            {
                                data: 'target_revenue',
                                render: (data, type, row, meta) => {
                                    let result = parseInt(data);
                                    return `Rp${result.toLocaleString('id-ID')}`;
                                }
                            },
                            {
                                data: 'realization_revenue',
                                render: (data, type, row, meta) => {
                                    let result = parseInt(data);
                                    return `Rp${result.toLocaleString('id-ID')}`;
                                }
                            },
                            {
                                data: {
                                    target_revenue: 'target_revenue',
                                    realization_revenue: 'realization_revenue'
                                },
                                render: (data, type, row, meta) => {
                                    let target = parseInt(data.target_revenue);
                                    let realization = parseInt(data.realization_revenue);
                                    let result = realization / target * 100;
                                    return `${result.toFixed()}%`;
                                }
                            },
                        ];


                        const dataTableConfig = {
                            data: register,
                            columnDefs: [{
                                width: 50,
                                target: 0
                            }],
                            createdRow: (row, data, index) => {
                                if (index % 2 === 0) {
                                    $(row).css('background-color', '#f9fafb');
                                }
                            },
                            columns: columnConfigs,
                        }

                        let results = {
                            config: dataTableConfig,
                            initialized: true
                        }

                        resolve(results);
                    } catch (error) {
                        reject(error)
                    }
                });
            }
        </script>

        @if (Auth::user()->role == 'A')
            <script>
                let dataTableDataTargetByPresenterInstance;
                let dataTableDataTargetByPresenterInitialized = false;
                let urlTargetPresenter =
                    `/api/report/database/target/presenter?pmbVal=${pmbVal}`;
            </script>

            <script>
                const changeFilterDataTargetByPresenter = () => {
                    let queryParams = [];

                    let pmbVal = document.getElementById('change_pmb').value;
                    let sessionVal = document.getElementById('session').value;
                    let dateVal = document.getElementById('date').value;

                    if (pmbVal !== 'all') {
                        queryParams.push(`pmbVal=${pmbVal}`);
                    }

                    if (sessionVal !== 'all') {
                        queryParams.push(`sessionVal=${sessionVal}`);
                    }

                    if (dateVal !== 'all') {
                        queryParams.push(`dateVal=${dateVal}`);
                    }

                    let queryString = queryParams.join('&');

                    urlTargetPresenter = `/api/report/database/target/presenter?${queryString}`;

                    if (dataTableDataTargetByPresenterInstance) {
                        showLoadingAnimation();
                        dataTableDataTargetByPresenterInstance.clear();
                        dataTableDataTargetByPresenterInstance.destroy();
                        getDataTableTargetByPresenter()
                            .then((response) => {
                                dataTableDataTargetByPresenterInstance = $('#table-report-target-presenter').DataTable(
                                    response
                                    .config);
                                dataTableDataTargetByPresenterInitialized = response.initialized;
                                hideLoadingAnimation();
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    }
                }

                const getDataTableTargetByPresenter = async () => {
                    return new Promise(async (resolve, reject) => {
                        try {
                            const response = await axios.get(urlTargetPresenter);
                            let register = response.data.databases;

                            let totalTargetVolume = 0;
                            let totalRealizationVolume = 0;

                            let totalTargetRevenue = 0;
                            let totalRealizationRevenue = 0;

                            register.forEach(regist => {
                                totalTargetVolume += parseInt(regist.target_volume);
                                totalTargetRevenue += parseInt(regist.target_revenue);
                                totalRealizationVolume += parseInt(regist.realization_volume);
                                totalRealizationRevenue += parseInt(regist.realization_revenue);
                            });

                            document.getElementById('target_volume_presenter').innerText = totalTargetVolume;
                            document.getElementById('realization_volume_presenter').innerText =
                                totalRealizationVolume;
                            document.getElementById('percent_volume_presenter').innerText =
                                `${(totalRealizationVolume / totalTargetVolume * 100).toFixed()}%`;
                            document.getElementById('target_revenue_presenter').innerText =
                                `Rp${totalTargetRevenue.toLocaleString('id-ID')}`;
                            document.getElementById('realization_revenue_presenter').innerText =
                                `Rp${totalRealizationRevenue.toLocaleString('id-ID')}`;
                            document.getElementById('percent_revenue_presenter').innerText =
                                `${(totalTargetRevenue / totalRealizationRevenue * 100).toFixed()}%`;

                            let columnConfigs = [{
                                    data: 'pmb',
                                    render: (data, type, row, meta) => {
                                        return meta.row + 1;
                                    },
                                },
                                {
                                    data: 'name',
                                    render: (data, type, row, meta) => {
                                        return data;
                                    }
                                },
                                {
                                    data: 'target_volume',
                                    render: (data, type, row, meta) => {
                                        return data;
                                    }
                                },
                                {
                                    data: 'realization_volume',
                                    render: (data, type, row, meta) => {
                                        return data;
                                    }
                                },
                                {
                                    data: {
                                        target_volume: 'target_volume',
                                        realization_volume: 'realization_volume'
                                    },
                                    render: (data, type, row, meta) => {
                                        let target = parseInt(data.target_volume);
                                        let realization = parseInt(data.realization_volume);
                                        let result = realization / target * 100;
                                        return `${result.toFixed()}%`;
                                    }
                                },
                                {
                                    data: 'target_revenue',
                                    render: (data, type, row, meta) => {
                                        let result = parseInt(data);
                                        return `Rp${result.toLocaleString('id-ID')}`;
                                    }
                                },
                                {
                                    data: 'realization_revenue',
                                    render: (data, type, row, meta) => {
                                        let result = parseInt(data);
                                        return `Rp${result.toLocaleString('id-ID')}`;
                                    }
                                },
                                {
                                    data: {
                                        target_revenue: 'target_revenue',
                                        realization_revenue: 'realization_revenue'
                                    },
                                    render: (data, type, row, meta) => {
                                        let target = parseInt(data.target_revenue);
                                        let realization = parseInt(data.realization_revenue);
                                        let result = realization / target * 100;
                                        return `${result.toFixed()}%`;
                                    }
                                },
                            ];


                            const dataTableConfig = {
                                data: register,
                                columnDefs: [{
                                    width: 50,
                                    target: 0
                                }],
                                createdRow: (row, data, index) => {
                                    if (index % 2 === 0) {
                                        $(row).css('background-color', '#f9fafb');
                                    }
                                },
                                columns: columnConfigs,
                            }

                            let results = {
                                config: dataTableConfig,
                                initialized: true
                            }

                            resolve(results);
                        } catch (error) {
                            reject(error)
                        }
                    });
                }
            </script>
        @endif


        @if (Auth::user()->role == 'A')
            <script>
                const promiseDataTarget = () => {
                    showLoadingAnimation();
                    Promise.all([
                            getDataTableTargetByPresenter(),
                            getDataTableTargetByMonth(),
                        ])
                        .then((response) => {
                            let responseDTBP = response[0];
                            let responseDTBM = response[1];
                            dataTableDataTargetByPresenterInstance = $('#table-report-target-presenter').DataTable(
                                responseDTBP.config);
                            dataTableDataTargetByPresenterInitialized = responseDTBP.initialized;
                            dataTableDataTargetByMonthInstance = $('#table-report-target-month').DataTable(responseDTBM
                                .config);
                            dataTableDataTargetByMonthInitialized = responseDTBM.initialized;
                            hideLoadingAnimation();
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }
            </script>
        @else
            <script>
                const promiseDataTarget = () => {
                    showLoadingAnimation();
                    Promise.all([
                            getDataTableTargetByMonth(),
                        ])
                        .then((response) => {
                            let responseDTBM = response[0];
                            dataTableDataTargetByMonthInitialized = responseDTBM.initialized;
                            dataTableDataTargetByMonthInstance = $('#table-report-target-month').DataTable(responseDTBM
                                .config);
                            dataTableDataTargetByMonthInitialized = responseDTBM.initialized;
                            hideLoadingAnimation();
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }
            </script>
        @endif

        <script>
            promiseDataTarget();
        </script>
    @endpush
</x-app-layout>
