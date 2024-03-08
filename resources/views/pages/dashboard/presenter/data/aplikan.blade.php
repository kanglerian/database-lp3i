<section>
    <header class="space-y-1 mb-5">
        <div class="flex items-center gap-2">
            <i class="fa-regular fa-circle-dot"></i>
            <h2 class="font-bold text-gray-800">Aplikan</h2>
        </div>
        <p class="text-sm text-gray-700 text-sm">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt, vitae.
        </p>
    </header>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500" id="table-report-data-aplikan">
            <thead class="text-xs text-gray-700 uppercase">
                <tr>
                    <th scope="col" class="px-6 py-4 text-center">
                        No
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Gelombang
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Tanggal
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Nama Aplikan
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Asal Sekolah
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Lulusan
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Jenis Kelamin
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Sumber Database
                    </th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</section>
@push('scripts')
    <script>
        let dataTableDataAplikanAplikanInitialized = false;
        let dataTableDataAplikanAplikanInstance;
        let databasesDataAplikanAplikan;
        let urlDataAplikanAplikan =
            `/api/report/database/aplikan/aplikan?pmbVal=${pmbVal}&identityVal=${identityVal}&sessionVal=${sessionVal}`;
    </script>
    <script>
        const changeFilterDataAplikanAplikan = () => {
            showLoadingAnimation();
            let queryParams = [];
            let pmbVal = document.getElementById('change_pmb').value;
            let sessionVal = document.getElementById('session').value;
            let identityVal = document.getElementById('identity_val').value;
            let roleVal = document.getElementById('role_val').value;

            if (pmbVal !== 'all') {
                queryParams.push(`pmbVal=${pmbVal}`);
            }

            if (sessionVal !== 'all') {
                queryParams.push(`sessionVal=${sessionVal}`);
            }

            if (identityVal !== 'all') {
                queryParams.push(`identityVal=${identityVal}`);
            }

            if (roleVal !== 'all') {
                queryParams.push(`roleVal=${roleVal}`);
            }

            let queryString = queryParams.join('&');

            urlDataAplikanAplikan = `/api/report/database/aplikan/aplikan?${queryString}`;

            if (dataTableDataAplikanAplikanInstance) {
                dataTableDataAplikanAplikanInstance.clear();
                dataTableDataAplikanAplikanInstance.destroy();
                getDataTableDataAplikanAplikan()
                    .then((response) => {
                        dataTableDataAplikanAplikanInstance = $('#table-report-data-aplikan').DataTable(response
                            .config);
                        dataTableDataAplikanAplikanInitialized = response.initialized;
                        hideLoadingAnimation();
                    })
                    .catch((error) => {
                        hideLoadingAnimation();
                    });
            }
        }

        const getDataTableDataAplikanAplikan = () => {
            return new Promise(async (resolve, reject) => {
                try {
                    const response = await axios.get(urlDataAplikanAplikan);
                    let databases = response.data.databases;

                    const dataTableConfig = {
                        data: databases,
                        columnDefs: [{
                                width: 10,
                                target: 0
                            },
                            {
                                width: 100,
                                targets: [1, 2, 3, 4, 5, 6, 7]
                            },
                        ],
                        createdRow: function(row, data, index) {
                            if (index % 2 === 0) {
                                $(row).css('background-color', '#f9fafb');
                            }
                        },
                        columns: [{
                                data: 'id',
                                render: (data, type, row, meta) => {
                                    return meta.row + 1;
                                }
                            },
                            {
                                data: 'session',
                            },
                            {
                                data: 'date',
                            },
                            {
                                data: 'applicant',
                                render: (data) => {
                                    return data == null ? 'Tidak diketahui' : data.name;
                                }
                            },
                            {
                                data: 'schoolapplicant',
                                render: (data) => {
                                    return data == null ? 'Tidak diketahui' : data.name;
                                }
                            },
                            {
                                data: 'applicant',
                                render: (data) => {
                                    return data.year == null ? 'Tidak diketahui' : data.year;
                                }
                            },
                            {
                                data: 'applicant',
                                render: (data) => {
                                    let gender;
                                    if (data == null) {
                                        gender = 'Tidak diketahui'
                                    } else {
                                        if (data) {
                                            gender = 'Laki-laki'
                                        } else {
                                            gender = 'Perempuan'
                                        }
                                    }
                                    return gender;
                                }
                            },
                            {
                                data: 'sourcesetting',
                                render: (data) => {
                                    return data == null ? 'Tidak diketahui' : data.name;
                                }
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
    </script>
@endpush
