<section>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500" id="table-database-presenter">
            <thead class="text-xs text-gray-700 uppercase">
                <tr>
                    <th scope="col" class="px-6 py-4 text-center">
                        No
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Nama Presenter
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Total
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Valid
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Non Valid
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Presentasi
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Grab Data
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Daftar Online
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Website
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Beasiswa
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Sosial Media
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        MGM
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Sekolah
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Jadwal
                    <th scope="col" class="px-6 py-4 text-center">
                        Guru BK
                    </th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <th scope="col" colspan="2" class="px-6 py-4 text-center text-gray-700">
                        Total Database
                    </th>
                    <td scope="col" id="presenter_jumlah" class="px-6 py-4 text-center"></td>
                    <td scope="col" id="presenter_valid" class="px-6 py-4 text-center"></td>
                    <td scope="col" id="presenter_nonvalid" class="px-6 py-4 text-center"></td>
                    <td scope="col" id="presenter_presentasi" class="px-6 py-4 text-center"></td>
                    <td scope="col" id="presenter_grab" class="px-6 py-4 text-center"></td>
                    <td scope="col" id="presenter_daftaronline" class="px-6 py-4 text-center"></td>
                    <td scope="col" id="presenter_website" class="px-6 py-4 text-center"></td>
                    <td scope="col" id="presenter_beasiswa" class="px-6 py-4 text-center"></td>
                    <td scope="col" id="presenter_sosmed" class="px-6 py-4 text-center"></td>
                    <td scope="col" id="presenter_mgm" class="px-6 py-4 text-center"></td>
                    <td scope="col" id="presenter_sekolah" class="px-6 py-4 text-center"></td>
                    <td scope="col" id="presenter_jadwaldatang" class="px-6 py-4 text-center"></td>
                    <td scope="col" id="presenter_gurubk" class="px-6 py-4 text-center"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</section>

@push('scripts')
    <script>
        let dataTableSourceDatabasePresenterInstance;
        let dataTableSourceDatabasePresenterInitialized = false;
        let urlDatabasePresenter =
            `/api/report/database/presenter/source?pmbVal=${pmbVal}&identityVal=${identityVal}&roleVal=${roleVal}`;
    </script>

    <script>
        const changeFilterSourceDatabasePresenter = () => {
            let queryParams = [];

            let pmbVal = document.getElementById('change_pmb').value;

            if (pmbVal !== 'all') {
                queryParams.push(`pmbVal=${pmbVal}`);
            }

            let queryString = queryParams.join('&');

            urlDatabasePresenter = `/api/report/database/presenter/source?${queryString}`;

            if (dataTableSourceDatabasePresenterInstance) {
                showLoadingAnimation();
                dataTableSourceDatabasePresenterInstance.clear();
                dataTableSourceDatabasePresenterInstance.destroy();
                getDataTableSourceDatabasePresenter()
                    .then((response) => {
                        dataTableSourceDatabasePresenterInstance = $('#table-database-presenter').DataTable(response
                            .config);
                        dataTableSourceDatabasePresenterInitialized = response.initialized;
                        hideLoadingAnimation();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }

        const getDataTableSourceDatabasePresenter = async () => {
            return new Promise(async (resolve, reject) => {
                try {
                    const response = await axios.get(urlDatabasePresenter);
                    let databases = response.data.databases;

                    let jumlah = 0;
                    let valid = 0;
                    let nonvalid = 0;
                    let presentasi = 0;
                    let grab = 0;
                    let daftaronline = 0;
                    let website = 0;
                    let beasiswa = 0;
                    let sosmed = 0;
                    let mgm = 0;
                    let sekolah = 0;
                    let jadwaldatang = 0;
                    let gurubk = 0;

                    databases.forEach(database => {
                        jumlah += parseInt(database.jumlah);
                        valid += parseInt(database.valid);
                        nonvalid += parseInt(database.nonvalid);
                        presentasi += parseInt(database.presentasi);
                        grab += parseInt(database.grab);
                        daftaronline += parseInt(database.daftaronline);
                        website += parseInt(database.website);
                        beasiswa += parseInt(database.beasiswa);
                        sosmed += parseInt(database.sosmed);
                        mgm += parseInt(database.mgm);
                        sekolah += parseInt(database.sekolah);
                        jadwaldatang += parseInt(database.jadwaldatang);
                        gurubk += parseInt(database.gurubk);
                    });

                    document.getElementById('presenter_jumlah').innerText = jumlah;
                    document.getElementById('presenter_valid').innerText = valid;
                    document.getElementById('presenter_nonvalid').innerText = nonvalid;
                    document.getElementById('presenter_presentasi').innerText = presentasi;
                    document.getElementById('presenter_grab').innerText = grab;
                    document.getElementById('presenter_daftaronline').innerText = daftaronline;
                    document.getElementById('presenter_website').innerText = website;
                    document.getElementById('presenter_beasiswa').innerText = beasiswa;
                    document.getElementById('presenter_sosmed').innerText = sosmed;
                    document.getElementById('presenter_mgm').innerText = mgm;
                    document.getElementById('presenter_sekolah').innerText = sekolah;
                    document.getElementById('presenter_jadwaldatang').innerText = jadwaldatang;
                    document.getElementById('presenter_gurubk').innerText = gurubk;

                    let columnConfigs = [
                        {
                            data: 'presenter',
                            render: (data, type, row, meta) => {
                                return meta.row + 1;
                            }
                        },
                        {
                            data: 'presenter',
                        },
                        {
                            data: 'jumlah',
                        },
                        {
                            data: 'valid',
                        },
                        {
                            data: 'nonvalid',
                        },
                        {
                            data: 'presentasi',
                        },
                        {
                            data: 'grab',
                        },
                        {
                            data: 'daftaronline',
                        },
                        {
                            data: 'website',
                        },
                        {
                            data: 'beasiswa',
                        },
                        {
                            data: 'sosmed',
                        },
                        {
                            data: 'mgm',
                        },
                        {
                            data: 'sekolah',
                        },
                        {
                            data: 'jadwaldatang',
                        },
                        {
                            data: 'gurubk',
                        },
                    ];

                    const dataTableConfig = {
                        data: databases,
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
@endpush
