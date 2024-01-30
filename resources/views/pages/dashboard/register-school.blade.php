<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0 h-10">
            <nav class="flex">
                <ol class="inline-flex items-center space-x-2 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">
                            <i class="fa-solid fa-table-columns mr-2"></i>
                            Dashboard
                        </a>
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

    <section class="space-y-5 py-8">
        <div class="max-w-7xl px-5 mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                <div
                    class="flex justify-center items-end flex-wrap md:flex-nowrap text-gray-500 md:gap-3 order-2 md:order-none">
                    <input type="hidden" id="identity_val" value="{{ Auth::user()->identity }}">
                    <input type="hidden" id="role_val" value="{{ Auth::user()->role }}">
                    <div class="w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
                        <label for="change_pmb" class="text-xs">Periode PMB:</label>
                        <input type="number" id="change_pmb" onchange="changeTriger()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
                            placeholder="Tahun PMB">
                    </div>
                    <div class="w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
                        <label for="status" class="text-xs">Status Sekolah:</label>
                        <select id="status" onchange="changeTriger()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                            <option value="all">Pilih</option>
                            <option value="N">Negeri</option>
                            <option value="S">Swasta</option>
                        </select>
                    </div>
                </div>
                <div class="px-4 py-2 rounded-xl text-sm bg-white border border-gray-100 order-1 md:order-none">
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
            <section class="bg-white p-5 md:rounded-xl border border-gray-100 space-y-5">
                <header class="space-y-1 mb-5">
                    <div class="flex items-center gap-2">
                        <i class="fa-regular fa-circle-dot"></i>
                        <h2 class="font-bold text-gray-800">Rekap Data Registrasi Per Tingkat Sekolah</h2>
                    </div>
                    <p class="text-sm text-gray-700 text-sm">
                        Berikut ini adalah hasil perhitungan dari riwayat pesan.
                    </p>
                </header>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500"
                        id="table-report-register-school">
                        <thead class="text-xs text-gray-700 uppercase" id="table-header-register-school">

                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </section>
        </div>
    </section>
    @include('pages.dashboard.utilities.all')
    @include('pages.dashboard.utilities.pmb')
    @push('scripts')
        <script>
            let dataTableDataRegisterSchoolInstance;
            let dataTableDataRegisterSchoolInitialized = false;
            let urlRegisterSchool = '/api/report/database/register/school';
        </script>
        <script>
            const changeTriger = () => {
                let queryParams = [];

                let pmbVal = document.getElementById('change_pmb').value;
                let identityVal = document.getElementById('identity_val').value;

                if (pmbVal !== 'all') {
                    queryParams.push(`pmbVal=${pmbVal}`);
                }

                if (identityVal !== 'all') {
                    queryParams.push(`identityVal=${identityVal}`);
                }

                if (roleVal !== 'all') {
                    queryParams.push(`roleVal=${roleVal}`);
                }

                let queryString = queryParams.join('&');

                urlRegisterSchool = `/api/report/database/register/school?${queryString}`;

                if (dataTableDataRegisterSchoolInstance) {
                    dataTableDataRegisterSchoolInstance.destroy();
                    getDataTableRegisterSchool()
                        .then((response) => {
                            dataTableDataRegisterSchoolInstance = $('#table-report-register-school').DataTable(response
                                .config);
                            dataTableDataRegisterSchoolInitialized = response.initialized;
                        })
                        .catch((error) => {
                            console.log(error);
                        })
                }

            }
        </script>
        <script>
            const getDataTableRegisterSchool = async () => {
                return new Promise(async (resolve, reject) => {
                    try {
                        let database;
                        const response = await fetch(urlRegisterSchool);

                        if (!response.ok) {
                            console.log('Network response was not ok.');
                        }

                        database = await response.json();

                        let types =
                            '<th scope="col" class="px-6 py-4 text-center">No</th><th scope="col" class="px-6 py-4 text-center">Wilayah</th>';

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
                        ];

                        database.forEach((data) => {
                            types +=
                                `<th scope="col" class="px-6 py-4 text-center">${data.tipe}</th>`;
                            columnConfigs.push({
                                data: 'register',
                                render: (data, type, row, meta) => {
                                    return parseInt(data);
                                }
                            });
                        });

                        const dataTableConfig = {
                            data: database,
                            columns: columnConfigs,
                        }

                        document.getElementById('table-header-register-school').innerHTML =
                            `<tr>${types}</tr>`;

                        let result = {
                            config: dataTableConfig,
                            initialized: true
                        }
                        resolve(result);

                    } catch (error) {
                        reject(error);
                    }
                });
            }
            getDataTableRegisterSchool()
                .then((response) => {
                    console.log(response);
                    dataTableDataRegisterSchoolInstance = $('#table-report-register-school').DataTable(response
                        .config);
                    dataTableDataRegisterSchoolInitialized = response.initialized;
                })
                .catch((error) => {
                    console.log(error);
                });
        </script>
    @endpush
</x-app-layout>
