<div class="max-w-7xl px-5 mx-auto">
    <section class="bg-gray-50 rounded-3xl border border-gray-200 space-y-5">
        <header class="px-6 pt-5 space-y-1">
            <h1 class="flex items-center gap-2 font-bold text-gray-700">
                <span>Registrasi: Berdasarkan Program Studi</span>
            </h1>
            <p class="text-gray-600 text-sm">Berikut ini adalah registrasi berdasarkan program studi yang terdaftar.</p>
        </header>
        <hr>
        <div class="relative overflow-x-auto px-6 pb-4">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500" id="table-report-register-program">
                <thead class="text-xs text-gray-700 uppercase">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-center">No</th>
                        <th scope="col" class="px-6 py-4 text-center">Program Studi</th>
                        <th scope="col" class="px-6 py-4 text-center">Reguler</th>
                        <th scope="col" class="px-6 py-4 text-center">Non Reguler</th>
                        <th scope="col" class="px-6 py-4 text-center">Total</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="font-bold">Total</td>
                        <td id="register_reguler">0</td>
                        <td id="register_nonreguler">0</td>
                        <td id="register_total">0</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
</div>

@push('scripts')
    <script>
        let dataTableDataRegisterProgramInstance;
        let dataTableDataRegisterProgramInitialized = false;
        let urlRegisterProgram =
            `/api/dashboard/register/program?pmbVal=${pmbVal}`;
    </script>
    <script>
        const changeFilterDataRegisterProgram = () => {
            let queryParams = [];

            let pmbVal = document.getElementById('change_pmb').value;

            if (pmbVal !== 'all') {
                queryParams.push(`pmbVal=${pmbVal}`);
            }

            let queryString = queryParams.join('&');

            urlRegisterProgram = `/api/dashboard/register/program?${queryString}`;

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

                    let totalReguler = 0;
                    let totalNonReguler = 0;

                    registers.forEach(register => {
                        totalReguler += parseInt(register.register_reguler);
                        totalNonReguler += parseInt(register.register_nonreguler);
                    });

                    document.getElementById('register_reguler').innerText = totalReguler;
                    document.getElementById('register_nonreguler').innerText = totalNonReguler;
                    document.getElementById('register_total').innerText = totalReguler + totalNonReguler;

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
                            data: 'register_reguler',
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
                                register_reguler: 'register_reguler',
                                register_nonreguler: 'register_nonreguler',
                            },
                            render: (data, type, row, meta) => {
                                let result = parseInt(data.register_reguler) + parseInt(data.register_nonreguler);
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
        const promiseDataRegisterProgram = () => {
            showLoadingAnimation();
            Promise.all([
                    getDataTableRegisterProgram(),
                ])
                .then((response) => {
                    let responseDTRS = response[0];
                    dataTableDataRegisterProgramInstance = $('#table-report-register-program').DataTable(
                        responseDTRS
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
