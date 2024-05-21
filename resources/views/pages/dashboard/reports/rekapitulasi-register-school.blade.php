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
                                Rekap Data Aplikan Register
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
                    <div class="w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
                        <label for="wilayah" class="text-xs">Wilayah:</label>
                        <select id="wilayah" onchange="changeTrigger()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800">
                            <option value="all">Pilih</option>
                            <option value="KAB. TASIKMALAYA">KAB. TASIKMALAYA</option>
                            <option value="TASIKMALAYA">TASIKMALAYA</option>
                            <option value="CIAMIS">CIAMIS</option>
                            <option value="BANJAR">BANJAR</option>
                            <option value="PANGANDARAN">PANGANDARAN</option>
                            <option value="GARUT">GARUT</option>
                            <option value="TIDAK DIKETAHUI">TIDAK DIKETAHUI</option>
                        </select>
                    </div>
                    <div class="w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
                        <label for="tipe" class="text-xs">Tipe Sekolah:</label>
                        <select id="tipe" onchange="changeTrigger()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800">
                            <option value="all">Pilih</option>
                            <option value="SMA">SMA</option>
                            <option value="SMK">SMK</option>
                            <option value="MA">MA</option>
                            <option value="PAKET">PAKET</option>
                        </select>
                    </div>
                    <div class="w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
                        <label for="status" class="text-xs">Status Sekolah:</label>
                        <select id="status" onchange="changeTrigger()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800">
                            <option value="all">Pilih</option>
                            <option value="N">Negeri</option>
                            <option value="S">Swasta</option>
                        </select>
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
                        id="table-report-register-school">
                        <thead class="text-xs text-gray-700 uppercase">
                            <th scope="col" class="px-6 py-4 text-center">No</th>
                            <th scope="col" class="px-6 py-4 text-center">Wilayah</th>
                            <th scope="col" class="px-6 py-4 text-center">Tipe Sekolah</th>
                            <th scope="col" class="px-6 py-4 text-center">Status</th>
                            <th scope="col" class="px-6 py-4 text-center">Total</th>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="font-bold">Total</td>
                                <td id="total_foot">0</td>
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
            let tipeVal = document.getElementById('tipe').value;
            let wilayahVal = document.getElementById('wilayah').value;
            let statusVal = document.getElementById('status').value;

            let databasesDataRegisterSchool;
            let dataTableDataRegisterSchoolInstance;
            let dataTableDataRegisterSchoolInitialized = false;
            let urlRegisterSchool = `/api/report/database/register/school?pmbVal=${pmbVal}&identityVal=${identityVal}&roleVal=${roleVal}&statusVal=${statusVal}&tipeVal=${tipeVal}&wilayahVal=${wilayahVal}`;
        </script>

        <script>
            const changeFilterDataRegisterSchool = () => {
                let queryParams = [];

                let pmbVal = document.getElementById('change_pmb').value;
                let identityVal = document.getElementById('identity_val').value;
                let roleVal = document.getElementById('role_val').value;
                let statusVal = document.getElementById('status').value;
                let wilayahVal = document.getElementById('wilayah').value;
                let tipeVal = document.getElementById('tipe').value;

                if (pmbVal !== 'all') {
                    queryParams.push(`pmbVal=${pmbVal}`);
                }

                if (identityVal !== 'all') {
                    queryParams.push(`identityVal=${identityVal}`);
                }

                if (roleVal !== 'all') {
                    queryParams.push(`roleVal=${roleVal}`);
                }

                if (tipeVal !== 'all') {
                    queryParams.push(`tipeVal=${tipeVal}`);
                }

                if (wilayahVal !== 'all') {
                    queryParams.push(`wilayahVal=${wilayahVal}`);
                }

                if (statusVal !== 'all') {
                    queryParams.push(`statusVal=${statusVal}`);
                }

                let queryString = queryParams.join('&');

                urlRegisterSchool = `/api/report/database/register/school?${queryString}`;

                if (dataTableDataRegisterSchoolInstance) {
                    showLoadingAnimation();
                    dataTableDataRegisterSchoolInstance.clear();
                    dataTableDataRegisterSchoolInstance.destroy();
                    getDataTableRegisterSchool()
                        .then((response) => {
                            dataTableDataRegisterSchoolInstance = $('#table-report-register-school').DataTable(response
                                .config);
                            dataTableDataRegisterSchoolInitialized = response.initialized;
                            hideLoadingAnimation();
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }
            }

            const getDataTableRegisterSchool = async () => {
                return new Promise(async (resolve, reject) => {
                    try {
                        const response = await axios.get(urlRegisterSchool);
                        let registers = response.data;

                        let total = registers.length;
                        document.getElementById('total_foot').innerText = total;

                        let columnConfigs = [{
                                data: 'pmb',
                                render: (data, type, row, meta) => {
                                    return meta.row + 1;
                                },
                            },
                            {
                                data: 'wilayah',
                                render: (data, type, row, meta) => {
                                    return data;
                                }
                            },
                            {
                                data: 'tipe',
                                render: (data, type, row, meta) => {
                                    return data;
                                }
                            },
                            {
                                data: 'status',
                                render: (data, type, row, meta) => {
                                    let result;
                                    switch (data) {
                                        case 'N':
                                            result = 'Negeri';
                                            break;
                                        case 'S':
                                            result = 'Swasta';
                                            break;
                                        default:
                                            result = 'Tidak diketahui';
                                            break;
                                    }
                                    return result;
                                },
                            }, {
                                data: 'register',
                                render: (data, type, row, meta) => {
                                    return parseInt(data);
                                }
                            }
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
                changeFilterDataRegisterSchool()
            }
        </script>
        <script>
            const promiseDataRegisterSchool = () => {
                showLoadingAnimation();
                Promise.all([
                        getDataTableRegisterSchool(),
                    ])
                    .then((response) => {
                        let responseDTRS = response[0];
                        dataTableDataRegisterSchoolInstance = $('#table-report-register-school').DataTable(responseDTRS
                            .config);
                        dataTableDataRegisterSchoolInitialized = responseDTRS.initialized;
                        hideLoadingAnimation();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
            promiseDataRegisterSchool();
        </script>
    @endpush
</x-app-layout>
