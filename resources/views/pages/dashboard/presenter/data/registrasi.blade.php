<section>
    <header class="space-y-1 mb-5">
        <div class="flex items-center gap-2">
            <i class="fa-regular fa-circle-dot"></i>
            <h2 class="font-bold text-gray-800">Registrasi</h2>
        </div>
        <p class="text-sm text-gray-700 text-sm">
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae, quaerat.
        </p>
    </header>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500" id="table-report-data-registrasi">
            <thead class="text-xs text-gray-700 uppercase">
                <tr>
                    <th scope="col" class="px-6 py-4 text-center">
                        No
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Gelombang
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Tanggal Registrasi
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
                        Pekerjaan Orang Tua
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Program
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Program Studi
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Sumber Database
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        MGM
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Registrasi
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Keterangan Potongan
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Harga Deal
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        < 30% </th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <td colspan="15">
                        <p class="text-sm text-gray-700 bg-yellow-300 space-x-1 py-3 px-4 rounded-lg">
                            <span>Total Kas Registrasi:</span>
                            <span class="font-bold underline" id="total_kas_registrasi">
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</section>
@push('scripts')
    <script>
        let dataTableDataAplikanRegistrasiInitialized = false;
        let dataTableDataAplikanRegistrasiInstance;
        let databasesDataAplikanRegistrasi;
        let urlDataAplikanRegistrasi =
            `/api/report/database/aplikan/registrasi?pmbVal=${pmbVal}&identityVal=${identityVal}&sessionVal=${sessionVal}`;
    </script>
    <script>
        const changeFilterDataAplikanRegistrasi = () => {
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

            urlDataAplikanRegistrasi = `/api/report/database/aplikan/registrasi?${queryString}`;

            if (dataTableDataAplikanRegistrasiInstance) {
                dataTableDataAplikanRegistrasiInstance.clear();
                dataTableDataAplikanRegistrasiInstance.destroy();
                getDataTableDataAplikanRegistrasi()
                    .then((response) => {
                        dataTableDataAplikanRegistrasiInstance = $('#table-report-data-registrasi').DataTable(
                            response
                            .config);
                        dataTableDataAplikanRegistrasiInitialized = response.initialized;
                        hideLoadingAnimation();
                    })
                    .catch((error) => {
                        hideLoadingAnimation();
                    });
            }
        }

        const getDataTableDataAplikanRegistrasi = () => {
            return new Promise(async (resolve, reject) => {
                try {
                    const response = await axios.get(urlDataAplikanRegistrasi);
                    let databases = response.data.databases;

                    let totalkas = 0;
                    databases.forEach(database => {
                        totalkas += parseInt(database.nominal)
                    });
                    document.getElementById('total_kas_registrasi').innerText =
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
                                    return data.year == null ? 'Tidak diketahui' : data.year;
                                }
                            },
                            {
                                data: {
                                    father: 'father',
                                    mother: 'mother'
                                },
                                render: (data) => {
                                    let mother = data.mother || 'Tidak diketahui';
                                    let father = data.father || 'Tidak diketahui';
                                    return `
                            <p>Ayah: ${father} | Ibu: ${mother}</p>`;
                                }
                            },
                            {
                                data: 'programtype',
                                render: (data) => {
                                    return data == null ? 'Tidak diketahui' : data.name;
                                }
                            },
                            {
                                data: 'applicant',
                                render: (data) => {
                                    return data == null ? 'Tidak diketahui' : data.program;
                                }
                            }, {
                                data: 'sourcesetting',
                                render: (data) => {
                                    return data == null ? 'Tidak diketahui' : data.name;
                                }
                            },
                            {
                                data: 'applicant',
                                render: (data) => {
                                    let result;
                                    if (data) {
                                        result = data.mgm || 'Tidak diketahui'
                                    } else {
                                        result = ' Tidak diketahui'
                                    }
                                    return result;
                                }
                            },
                            {
                                data: 'nominal',
                                render: (data) => {
                                    let result = parseInt(data);
                                    return `Rp${result.toLocaleString('id-ID')}`;
                                }
                            },
                            {
                                data: 'desc_discount',
                                render: (data) => {
                                    return data == null ? 'Tidak diketahui' : data.year;
                                }
                            }, {
                                data: 'deal',
                                render: (data) => {
                                    let result = parseInt(data);
                                    return `Rp${result.toLocaleString('id-ID')}`;
                                }
                            },
                            {
                                data: {
                                    nominal: 'nominal',
                                    deal: 'deal'
                                },
                                render: (data, type, row) => {
                                    let dataPercent = parseInt(data.deal) * 0.3;
                                    let percent = parseInt(data.nominal) < dataPercent;
                                    return ` ${percent ? '<i class="fa-solid fa-circle-check text-emerald-500"></i>' : '<i class="fa-solid fa-circle-xmark text-red-500"></i>'}`
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
