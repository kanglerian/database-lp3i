@if (Auth::user()->role !== 'S')
    <section>
        <header class="space-y-1 mb-5">
            <div class="flex items-center gap-2">
                <i class="fa-regular fa-circle-dot"></i>
                <h2 class="font-bold text-gray-800">Sumber Database Berdasarkan Wilayah</h2>
            </div>
            <p class="text-sm text-gray-700 text-sm">
                Berikut ini adalah hasil perhitungan dari riwayat pesan.
            </p>
        </header>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500" id="table-source-database-wilayah">
                <thead class="text-xs text-gray-700 uppercase">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-center">
                            No
                        </th>
                        <th scope="col" class="px-6 py-4 text-center">
                            Wilayah
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
                        <td scope="col" id="wilayah_jumlah" class="px-6 py-4 text-center"></td>
                        <td scope="col" id="wilayah_valid" class="px-6 py-4 text-center"></td>
                        <td scope="col" id="wilayah_nonvalid" class="px-6 py-4 text-center"></td>
                        <td scope="col" id="wilayah_presentasi" class="px-6 py-4 text-center"></td>
                        <td scope="col" id="wilayah_grab" class="px-6 py-4 text-center"></td>
                        <td scope="col" id="wilayah_daftaronline" class="px-6 py-4 text-center"></td>
                        <td scope="col" id="wilayah_website" class="px-6 py-4 text-center"></td>
                        <td scope="col" id="wilayah_beasiswa" class="px-6 py-4 text-center"></td>
                        <td scope="col" id="wilayah_sosmed" class="px-6 py-4 text-center"></td>
                        <td scope="col" id="wilayah_mgm" class="px-6 py-4 text-center"></td>
                        <td scope="col" id="wilayah_sekolah" class="px-6 py-4 text-center"></td>
                        <td scope="col" id="wilayah_jadwaldatang" class="px-6 py-4 text-center"></td>
                        <td scope="col" id="wilayah_gurubk" class="px-6 py-4 text-center"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>

    @push('scripts')
        <script>
            const getAPIDatabaseSchool = async () => {
                await axios.get(urlSourceDatabaseWilayah)
                    .then((response) => {
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
                        databasesSourceDatabaseWilayah = response.data;
                        databasesSourceDatabaseWilayah.databases.forEach(database => {
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
                        document.getElementById('wilayah_jumlah').innerText = jumlah;
                        document.getElementById('wilayah_valid').innerText = valid;
                        document.getElementById('wilayah_nonvalid').innerText = nonvalid;
                        document.getElementById('wilayah_presentasi').innerText = presentasi;
                        document.getElementById('wilayah_grab').innerText = grab;
                        document.getElementById('wilayah_daftaronline').innerText = daftaronline;
                        document.getElementById('wilayah_website').innerText = website;
                        document.getElementById('wilayah_beasiswa').innerText = beasiswa;
                        document.getElementById('wilayah_sosmed').innerText = sosmed;
                        document.getElementById('wilayah_mgm').innerText = mgm;
                        document.getElementById('wilayah_sekolah').innerText = sekolah;
                        document.getElementById('wilayah_jadwaldatang').innerText = jadwaldatang;
                        document.getElementById('wilayah_gurubk').innerText = gurubk;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
            getAPIDatabaseSchool();
        </script>

        <script>
            const changeFilterDatabaseSchool = () => {
                let queryParams = [];
                let pmbVal = document.getElementById('change_pmb').value;
                if (pmbVal !== 'all') {
                    queryParams.push(`pmbVal=${pmbVal}`);
                }
                let queryString = queryParams.join('&');

                urlSourceDatabaseWilayah = `api/report/database/wilayah/source?${queryString}`;
                if (dataTableSourceDatabaseWilayahInstance) {
                    dataTableSourceDatabaseWilayahInstance.ajax.url(urlSourceDatabaseWilayah).load();
                    getAPIDatabaseSchool();
                } else {
                    getDataTableDatabaseSchool();
                }
            }

            const getDataTableDatabaseSchool = async () => {
                const dataTableConfig = {
                    ajax: {
                        url: urlSourceDatabaseWilayah,
                        dataSrc: 'databases'
                    },
                    columnDefs: [{
                            width: 10,
                            target: 0
                        },
                        {
                            width: 100,
                            targets: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
                        },
                    ],
                    createdRow: function(row, data, index) {
                        if (index % 2 === 0) {
                            $(row).css('background-color', '#f9fafb');
                        }
                    },
                    columns: [{
                            data: 'wilayah',
                            render: (data, type, row, meta) => {
                                return meta.row + 1;
                            }
                        },
                        {
                            data: 'wilayah',
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
                    ],
                }
                try {
                    const response = await fetch(urlSourceDatabaseWilayah);
                    const data = await response.json();
                    databasesSourceDatabaseWilayah = data.databases;
                    dataTableSourceDatabaseWilayahInstance = $('#table-source-database-wilayah').DataTable(
                        dataTableConfig);
                    dataTableSourceDatabaseWilayahInitialized = true;
                } catch (error) {
                    console.error("Error fetching data:", error);
                    if (response) {
                        const text = await response.text();
                        console.error("Response text:", text);
                    }
                }
            }
            getDataTableDatabaseSchool();
        </script>
    @endpush
@endif
