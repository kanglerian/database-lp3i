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
                    <li>
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-300 mr-2"></i>
                            <a href="{{ route('dashboard.rekapitulasi_perolehan_pmb_page') }}"
                                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">Rekap Perolehan PMB</a>
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
                            <input type="number" id="change_pmb" onchange="changeFilterDataTargetByPresenter()"
                                class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800"
                                placeholder="Tahun PMB">
                        </div>
                        <div class="inline-block flex flex-col space-y-1 p-1 md:p-0">
                            <label for="date" class="text-xs">Tanggal:</label>
                            <input type="date" id="date" onchange="changeFilterDataTargetByPresenter()"
                                class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800">
                        </div>
                        <div class="inline-block flex flex-col space-y-1 p-1 md:p-0">
                            <label for="session" class="text-xs">Gelombang:</label>
                            <select id="session" onchange="changeFilterDataTargetByPresenter()"
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
                        {{-- <tfoot>
                            <tr>
                                <td colspan="2" class="font-bold">Total</td>
                                <td id="total_beasiswa_reguler">0</td>
                                <td id="total_nonbeasiswa_reguler">0</td>
                                <td id="total_nonreguler">0</td>
                                <td id="total">0</td>
                            </tr>
                        </tfoot> --}}
                    </table>
                </div>
            </section>
        </div>
    </section>
    @include('pages.dashboard.utilities.pmb')
    @push('scripts')
        <script>
            let databasesDataRegisterProgram;
            let dataTableDataTargetByPresenterInstance;
            let dataTableDataTargetByPresenterInitialized = false;
            let urlTarget =
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

                urlTarget = `/api/report/database/target/presenter?${queryString}`;

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
                        const response = await axios.get(urlTarget);
                        let register = response.data.databases;
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
                                    return `${realization / target * 100}%`;
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
                                    return `${realization / target * 100}%`;
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

        <script>
            const changeTrigger = () => {
                changeFilterDataTargetByPresenter()
            }
        </script>
        <script>
            const promiseDataTargetByPresenter = () => {
                showLoadingAnimation();
                Promise.all([
                        getDataTableTargetByPresenter(),
                    ])
                    .then((response) => {
                        let responseDTRS = response[0];
                        dataTableDataTargetByPresenterInstance = $('#table-report-target-presenter').DataTable(responseDTRS
                            .config);
                        dataTableDataTargetByPresenterInitialized = responseDTRS.initialized;
                        hideLoadingAnimation();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
            promiseDataTargetByPresenter();
        </script>
    @endpush
</x-app-layout>
