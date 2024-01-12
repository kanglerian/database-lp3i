@if (Auth::user()->role !== 'S')
    <div class="max-w-7xl px-5 mx-auto">
        <section class="bg-white p-5 md:rounded-xl border border-gray-100 space-y-5">
            <header class="space-y-1">
                <h2 class="font-bold text-gray-800">Rekapitulasi Database</h2>
                <p class="text-sm text-gray-700 text-sm">
                    Berikut ini adalah hasil perhitungan dari riwayat pesan.
                </p>
            </header>
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500" id="table-rekap-database">
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
                    <tbody id="history_chat_presente">
                        <tr>
                            <td colspan="14" class="bg-white text-center text-sm px-6 py-4">Tidak ada data.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    @push('scripts')
        <script src="{{ asset('js/axios.min.js') }}"></script>
        <script>
            let pmbVal = document.getElementById('change_pmb').value;
            let urlData = `api/report/database/presenter/source?pmbVal=${pmbVal}`;
            let dataTableRekapInitialized = false;
            let dataTableRekapInstance;
            let databases;

            const getAPIRekap = async () => {
                await axios.get(urlData)
                    .then((response) => {
                        databases = response.data;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }

            const changeFilterRekap = () => {
                let queryParams = [];
                let pmbVal = document.getElementById('change_pmb').value;
                if (pmbVal !== 'all') {
                    queryParams.push(`pmbVal=${pmbVal}`);
                }
                let queryString = queryParams.join('&');

                urlData = `api/report/database/presenter/source?${queryString}`;
                if (dataTableRekapInstance) {
                    dataTableRekapInstance.ajax.url(urlData).load();
                    getAPIRekap();
                } else {
                    getDataTable();
                }
            }

            const getDataTable = async () => {
                const dataTableConfig = {
                    ajax: {
                        url: urlData,
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
                    ],
                }
                try {
                    const response = await fetch(urlData);
                    const data = await response.json();
                    databases = data.databases;
                    dataTableRekapInstance = $('#table-rekap-database').DataTable(dataTableConfig);
                    dataTableRekapInitialized = true;
                } catch (error) {
                    console.error("Error fetching data:", error);
                    if (response) {
                        const text = await response.text();
                        console.error("Response text:", text);
                    }
                }
            }
            getDataTable();
        </script>
    @endpush
@endif
