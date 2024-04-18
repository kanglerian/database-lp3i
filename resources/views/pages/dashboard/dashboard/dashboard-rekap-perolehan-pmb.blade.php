<div class="max-w-7xl px-5 mx-auto">
    <section class="bg-gray-50 rounded-3xl border border-gray-200 space-y-5">
        <header class="px-6 pt-5 space-y-1">
            <h1 class="flex items-center gap-2 font-bold text-gray-700">
                <span>Rekapitulasi: Perolehan PMB</span>
            </h1>
            <p class="text-gray-600 text-sm">Berikut ini adalah rekapitulasi perolehan PMB.</p>
        </header>
        <hr>
        <div class="relative overflow-x-auto px-6 pb-4">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500" id="table-report-rekapitulasi">
                <thead class="text-xs text-gray-700 uppercase">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-center">No</th>
                        <th scope="col" class="px-6 py-4 text-center">Presenter</th>
                        <th scope="col" class="px-6 py-4 text-center">Aplikan</th>
                        <th scope="col" class="px-6 py-4 text-center">Daftar</th>
                        <th scope="col" class="px-6 py-4 text-center">Total Register</th>
                        <th scope="col" class="px-6 py-4 text-center">Total Omset</th>
                        <th scope="col" class="px-6 py-4 text-center">Harga Jual Rata-Rata</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="font-bold">Total</td>
                        <td id="rekapitulasi_applicant">0</td>
                        <td id="rekapitulasi_enrollment">0</td>
                        <td id="rekapitulasi_registration">0</td>
                        <td id="rekapitulasi_omzet">0</td>
                        <td id="rekapitulasi_price">0</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
</div>

@push('scripts')
    <script>
        let dataTableDataRekapitulasiInstance;
        let dataTableDataRekapitulasiInitialized = false;
        let urlRekapitulasi =
            `/api/dashboard/register/rekapperolehanpmb?pmbVal=${pmbVal}`;
    </script>

    <script>
        const changeFilterRekapitulasi = () => {
            let queryParams = [];

            let pmbVal = document.getElementById('change_pmb').value;

            if (pmbVal !== 'all') {
                queryParams.push(`pmbVal=${pmbVal}`);
            }

            let queryString = queryParams.join('&');

            urlRekapitulasi = `/api/dashboard/register/rekapperolehanpmb?${queryString}`;

            if (dataTableDataRekapitulasiInstance) {
                showLoadingAnimation();
                dataTableDataRekapitulasiInstance.clear();
                dataTableDataRekapitulasiInstance.destroy();
                getDataTableRekapitulasi()
                    .then((response) => {
                        dataTableDataRekapitulasiInstance = $('#table-report-rekapitulasi').DataTable(
                            response
                            .config);
                        dataTableDataRekapitulasiInitialized = response.initialized;
                        hideLoadingAnimation();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }

        const getDataTableRekapitulasi = async () => {
            return new Promise(async (resolve, reject) => {
                try {
                    const response = await axios.get(urlRekapitulasi);
                    let registers = response.data.databases;

                    let totalApplicant = 0;
                    let totalEnrollment = 0;
                    let totalRegistration = 0;
                    let totalOmzet = 0;

                    registers.forEach(register => {
                        totalApplicant += parseInt(register.applicant);
                        totalEnrollment += parseInt(register.enrollment);
                        totalRegistration += parseInt(register.registration);
                        totalOmzet += parseInt(register.omzet);
                    });

                    document.getElementById('rekapitulasi_applicant').innerText = totalApplicant;
                    document.getElementById('rekapitulasi_enrollment').innerText = totalEnrollment;
                    document.getElementById('rekapitulasi_registration').innerText = totalRegistration;
                    document.getElementById('rekapitulasi_omzet').innerText = `Rp${totalOmzet.toLocaleString('id-ID')}`;
                    document.getElementById('rekapitulasi_price').innerText = `Rp${(totalOmzet / totalRegistration).toLocaleString('id-ID')}`;

                    let columnConfigs = [{
                            data: 'identity',
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
                            data: 'applicant',
                            render: (data, type, row, meta) => {
                                return parseInt(data);
                            }
                        },
                        {
                            data: 'enrollment',
                            render: (data, type, row, meta) => {
                                return parseInt(data);
                            }
                        },
                        {
                            data: 'registration',
                            render: (data, type, row, meta) => {
                                return parseInt(data);
                            }
                        },
                        {
                            data: 'omzet',
                            render: (data, type, row, meta) => {
                                let result = parseInt(data);
                                return `Rp${result.toLocaleString('id-ID')}`;
                            }
                        },
                        {
                            data: {
                                omzet: 'omzet',
                                registration: 'registration',
                            },
                            render: (data, type, row, meta) => {
                                let result = parseInt(data.omzet) / data.registration;
                                return `Rp${result.toLocaleString('id-ID')}`;
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
        const promiseDataRekapitulasi = () => {
            showLoadingAnimation();
            Promise.all([
                    getDataTableRekapitulasi(),
                ])
                .then((response) => {
                    let responseDTRS = response[0];
                    dataTableDataRekapitulasiInstance = $('#table-report-rekapitulasi').DataTable(
                        responseDTRS
                        .config);
                    dataTableDataRekapitulasiInitialized = responseDTRS.initialized;
                    hideLoadingAnimation();
                })
                .catch((error) => {
                    console.log(error);
                });
        }
        promiseDataRekapitulasi();
    </script>
@endpush
