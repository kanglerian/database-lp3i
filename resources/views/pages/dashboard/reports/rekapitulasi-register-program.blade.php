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
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">
                                Rekapitulasi Tebaran Program Studi
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
                    <input type="hidden" id="identity_val" value="{{ Auth::user()->identity }}">
                    <input type="hidden" id="role_val" value="{{ Auth::user()->role }}">
                    <div class="w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
                        <label for="change_pmb" class="text-xs">Periode PMB:</label>
                        <input type="number" id="change_pmb" onchange="changeTrigger()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800"
                            placeholder="Tahun PMB">
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
                        id="table-report-register-program">
                        <thead class="text-xs text-gray-700 uppercase">
                            <tr>
                                <th rowspan="2" scope="col" class="px-6 py-4 text-center">No</th>
                                <th rowspan="2" scope="col" class="px-6 py-4 text-center">Program Studi</th>
                                <th colspan="2" scope="col" class="px-6 py-4 text-center">Reguler</th>
                                <th rowspan="2" scope="col" class="px-6 py-4 text-center">Non Reguler</th>
                                <th rowspan="2" scope="col" class="px-6 py-4 text-center">Total</th>
                            </tr>
                            <tr>
                                <th scope="col" class="px-6 py-4 text-center">Beasiswa</th>
                                <th scope="col" class="px-6 py-4 text-center">Non Beasiswa</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="font-bold">Total</td>
                                <td id="total_beasiswa_reguler">0</td>
                                <td id="total_nonbeasiswa_reguler">0</td>
                                <td id="total_nonreguler">0</td>
                                <td id="total">0</td>
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
            let databasesDataRegisterProgram;
            let dataTableDataRegisterProgramInstance;
            let dataTableDataRegisterProgramInitialized = false;
            let urlRegisterProgram =
                `/api/report/database/register/program?pmbVal=${pmbVal}&identityVal=${identityVal}&roleVal=${roleVal}`;
        </script>

        <script>
            const changeFilterDataRegisterProgram = () => {
                let queryParams = [];

                let pmbVal = document.getElementById('change_pmb').value;
                let identityVal = document.getElementById('identity_val').value;
                let roleVal = document.getElementById('role_val').value;

                if (pmbVal !== 'all') {
                    queryParams.push(`pmbVal=${pmbVal}`);
                }

                if (identityVal !== 'all') {
                    queryParams.push(`identityVal=${identityVal}`);
                }

                if (roleVal !== 'all') {
                    queryParams.push(`roleVal=${roleVal}`);
                }

                let queryString = queryParams.join('&');

                urlRegisterProgram = `/api/report/database/register/program?${queryString}`;

                if (dataTableDataRegisterProgramInstance) {
                    showLoadingAnimation();
                    dataTableDataRegisterProgramInstance.clear();
                    dataTableDataRegisterProgramInstance.destroy();
                    getDataTableRegisterProgram()
                        .then((response) => {
                            dataTableDataRegisterProgramInstance = $('#table-report-register-program').DataTable(
                                response
                                .config);
                            dataTableDataRegisterProgramInitialized = response.initialized;
                            hideLoadingAnimation();
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }
            }

            const getDataTableRegisterProgram = async () => {
                return new Promise(async (resolve, reject) => {
                    try {
                        const response = await axios.get(urlRegisterProgram);
                        let registers = response.data;

                        let total_beasiswa_reguler = 0;
                        let total_nonbeasiswa_reguler = 0;
                        let total_nonreguler = 0;
                        let total = 0;

                        registers.forEach(register => {
                            total_beasiswa_reguler += parseInt(register.register_reguler_beasiswa);
                            total_nonbeasiswa_reguler += parseInt(register.register_reguler_nonbeasiswa);
                            total_nonreguler += parseInt(register.register_nonreguler);
                            total += parseInt(register.register_reguler_beasiswa) + parseInt(register.register_reguler_nonbeasiswa) + parseInt(register.register_nonreguler);
                        });

                        document.getElementById('total_beasiswa_reguler').innerText = total_beasiswa_reguler;
                        document.getElementById('total_nonbeasiswa_reguler').innerText = total_nonbeasiswa_reguler;
                        document.getElementById('total_nonreguler').innerText = total_nonreguler;
                        document.getElementById('total').innerText = total;

                        let columnConfigs = [{
                                data: 'pmb',
                                render: (data, type, row, meta) => {
                                    return meta.row + 1;
                                },
                            },
                            {
                                data: 'program',
                                render: (data, type, row, meta) => {
                                    return data;
                                }
                            },
                            {
                                data: 'register_reguler_beasiswa',
                                render: (data, type, row, meta) => {
                                    return parseInt(data);
                                }
                            },
                            {
                                data: 'register_reguler_nonbeasiswa',
                                render: (data, type, row, meta) => {
                                    return parseInt(data);
                                }
                            },
                            {
                                data: 'register_nonreguler',
                                render: (data, type, row, meta) => {
                                    return parseInt(data);
                                }
                            },
                            {
                                data: {
                                    register_reguler_beasiswa: 'register_reguler_beasiswa',
                                    register_reguler_nonbeasiswa: 'register_reguler_nonbeasiswa',
                                    register_nonreguler: 'register_nonreguler',
                                },
                                render: (data, type, row, meta) => {
                                    let result = parseInt(data.register_reguler_beasiswa) +
                                        parseInt(data.register_reguler_nonbeasiswa) + parseInt(data
                                            .register_nonreguler);
                                    return result;
                                }
                            },
                        ];


                        const dataTableConfig = {
                            data: registers,
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
                changeFilterDataRegisterProgram()
            }
        </script>
        <script>
            const promiseDataRegisterProgram = () => {
                showLoadingAnimation();
                Promise.all([
                        getDataTableRegisterProgram(),
                    ])
                    .then((response) => {
                        let responseDTRS = response[0];
                        dataTableDataRegisterProgramInstance = $('#table-report-register-program').DataTable(responseDTRS
                            .config);
                        dataTableDataRegisterProgramInitialized = responseDTRS.initialized;
                        hideLoadingAnimation();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
            promiseDataRegisterProgram();
        </script>
    @endpush
</x-app-layout>
