<section>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500" id="table-database-presenter-wilayah">
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
                        Tasikmalaya
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Kab. Tasikmalaya
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Ciamis
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Banjar
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Garut
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Pangandaran
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Tidak Diketahui
                    </th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <th scope="col" colspan="2" class="px-6 py-4 text-center text-gray-700">
                        Total Database
                    </th>
                    <td scope="col" id="presenter_wilayah_total" class="px-6 py-4 text-center"></td>
                    <td scope="col" id="presenter_wilayah_tasikmalaya" class="px-6 py-4 text-center"></td>
                    <td scope="col" id="presenter_wilayah_kabtasikmalaya" class="px-6 py-4 text-center"></td>
                    <td scope="col" id="presenter_wilayah_ciamis" class="px-6 py-4 text-center"></td>
                    <td scope="col" id="presenter_wilayah_banjar" class="px-6 py-4 text-center"></td>
                    <td scope="col" id="presenter_wilayah_garut" class="px-6 py-4 text-center"></td>
                    <td scope="col" id="presenter_wilayah_pangandaran" class="px-6 py-4 text-center"></td>
                    <td scope="col" id="presenter_wilayah_tidakdiketahui" class="px-6 py-4 text-center"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</section>

@push('scripts')
    <script>
        let dataTableSourceDatabaseWilayahPresenterInstance;
        let dataTableSourceDatabaseWilayahPresenterInitialized = false;
        let urlDatabasePresenterWilayah = `/api/report/database/presenter/wilayah?pmbVal=${pmbVal}&identityVal=${identityVal}&roleVal=${roleVal}`;
    </script>

    <script>
        const changeFilterSourceDatabasePresenterWilayah = () => {
            let queryParams = [];

            let pmbVal = document.getElementById('change_pmb').value;

            if (pmbVal !== 'all') {
                queryParams.push(`pmbVal=${pmbVal}`);
            }

            let queryString = queryParams.join('&');

            urlDatabasePresenterWilayah = `/api/report/database/presenter/wilayah?${queryString}`;

            if (dataTableSourceDatabaseWilayahPresenterInstance) {
                showLoadingAnimation();
                dataTableSourceDatabaseWilayahPresenterInstance.clear();
                dataTableSourceDatabaseWilayahPresenterInstance.destroy();
                getDataTableSourceDatabasePresenterWilayah()
                    .then((response) => {
                        dataTableSourceDatabaseWilayahPresenterInstance = $('#table-database-presenter-wilayah').DataTable(response.config);
                        dataTableSourceDatabaseWilayahPresenterInitialized = response.initialized;
                        hideLoadingAnimation();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }

        const getDataTableSourceDatabasePresenterWilayah = async () => {
            return new Promise(async (resolve, reject) => {
                try {
                    const response = await axios.get(urlDatabasePresenterWilayah);
                    let databases = response.data.databases;

                    let jumlah = 0;
                    let tasikmalaya = 0;
                    let kabtasikmalaya = 0;
                    let ciamis = 0;
                    let banjar = 0;
                    let garut = 0;
                    let pangandaran = 0;
                    let tidakdiketahui = 0;

                    databases.forEach(database => {
                        jumlah += parseInt(database.jumlah);
                        tasikmalaya += parseInt(database.tasikmalaya);
                        kabtasikmalaya += parseInt(database.kabtasikmalaya);
                        ciamis += parseInt(database.ciamis);
                        banjar += parseInt(database.banjar);
                        garut += parseInt(database.garut);
                        pangandaran += parseInt(database.pangandaran);
                        tidakdiketahui += parseInt(database.tidakdiketahui);
                    });

                    document.getElementById('presenter_wilayah_total').innerText = jumlah;
                    document.getElementById('presenter_wilayah_tasikmalaya').innerText = tasikmalaya;
                    document.getElementById('presenter_wilayah_kabtasikmalaya').innerText = kabtasikmalaya;
                    document.getElementById('presenter_wilayah_ciamis').innerText = ciamis;
                    document.getElementById('presenter_wilayah_banjar').innerText = banjar;
                    document.getElementById('presenter_wilayah_garut').innerText = garut;
                    document.getElementById('presenter_wilayah_pangandaran').innerText = pangandaran;
                    document.getElementById('presenter_wilayah_tidakdiketahui').innerText = tidakdiketahui;


                    let columnConfigs = [{
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
                            data: 'kabtasikmalaya',
                        },
                        {
                            data: 'tasikmalaya',
                        },
                        {
                            data: 'ciamis',
                        },
                        {
                            data: 'banjar',
                        },
                        {
                            data: 'garut',
                        },
                        {
                            data: 'pangandaran',
                        },
                        {
                            data: 'tidakdiketahui',
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
