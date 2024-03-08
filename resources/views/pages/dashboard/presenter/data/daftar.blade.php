<section>
    <header class="space-y-1 mb-5">
        <div class="flex items-center gap-2">
            <i class="fa-regular fa-circle-dot"></i>
            <h2 class="font-bold text-gray-800">Daftar</h2>
        </div>
        <p class="text-sm text-gray-700 text-sm">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus, architecto.
        </p>
    </header>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500" id="table-report-data-daftar">
            <thead class="text-xs text-gray-700 uppercase">
                <tr>
                    <th scope="col" class="px-6 py-4 text-center">
                        No
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Gelombang
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Tanggal Daftar
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
                        Keterangan
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Keterangan Daftar
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Nominal Daftar
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Tanggal Pengembalian BK
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Debit
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Kas Pendaftaran
                    </th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <td colspan="12">
                        <p class="text-sm text-gray-700 bg-yellow-300 space-x-1 py-3 px-4 rounded-lg">
                            <span>Total Kas Pendaftaran:</span>
                            <span class="font-bold underline" id="total_kas_daftar">
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</section>
@push('scripts')
    <script>
        let dataTableDataAplikanDaftarInitialized = false;
        let dataTableDataAplikanDaftarInstance;
        let databasesDataAplikanDaftar;
        let urlDataAplikanDaftar =
            `/api/report/database/aplikan/daftar?pmbVal=${pmbVal}&identityVal=${identityVal}&sessionVal=${sessionVal}`;
    </script>
    <script>
        const changeFilterDataAplikanDaftar = () => {
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

            urlDataAplikanDaftar = `/api/report/database/aplikan/daftar?${queryString}`;

            if (dataTableDataAplikanDaftarInstance) {
                dataTableDataAplikanDaftarInstance.clear();
                dataTableDataAplikanDaftarInstance.destroy();
                getDataTableDataAplikanDaftar()
                    .then((response) => {
                        dataTableDataAplikanDaftarInstance = $('#table-report-data-daftar').DataTable(response
                            .config);
                        dataTableDataAplikanDaftarInitialized = response.initialized;
                        hideLoadingAnimation();
                    })
                    .catch((error) => {
                        hideLoadingAnimation();
                    });
            }
        }

        const getDataTableDataAplikanDaftar = () => {
            return new Promise(async (resolve, reject) => {
                try {
                    const response = await axios.get(urlDataAplikanDaftar);
                    let databases = response.data.databases;


                    let totalkas = 0;
                    databases.forEach(database => {
                        totalkas += database.nominal - database.debit
                    });
                    document.getElementById('total_kas_daftar').innerText =
                        `Rp${totalkas.toLocaleString('id-ID')}`

                    const dataTableConfig = {
                        data: databases,
                        columnDefs: [{
                                width: 10,
                                target: 0
                            },
                            {
                                width: 100,
                                targets: [1, 2, 3, 4, 5, 6, 7, ]
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
                                    return data == null ? 'Tidak diketahui' : data.year;
                                }
                            },
                            {
                                data: 'register',
                            },
                            {
                                data: 'register_end',
                            },
                            {
                                data: 'nominal',
                                render: (data) => {
                                    let result = parseInt(data);
                                    return `Rp${result.toLocaleString('id-ID')}`;
                                }
                            },
                            {
                                data: 'repayment',
                                render: (data) => {
                                    return data || 'Tidak ada';
                                }
                            },
                            {
                                data: 'debit',
                                render: (data) => {
                                    let result = parseInt(data) || 0;
                                    return `Rp${result.toLocaleString('id-ID')}`;
                                }
                            },
                            {
                                data: {
                                    nominal: 'nominal',
                                    debit: 'debit'
                                },
                                render: (data) => {
                                    let result = (parseInt(data.nominal) || 0) - (parseInt(data
                                        .debit) || 0);
                                    return `Rp${result.toLocaleString('id-ID')}`;
                                }
                            },
                        ]
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
