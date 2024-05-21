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
                        id="table-report-register-source">
                        <thead class="text-xs text-gray-700 uppercase" id="headers_register_source">
                            <th scope="col" class="px-6 py-4 text-center">No</th>
                        </thead>
                        <tbody></tbody>
                        <tfoot id="footers_register_source"></tfoot>
                    </table>
                </div>
            </section>
        </div>
    </section>
    @include('pages.dashboard.utilities.all')
    @include('pages.dashboard.utilities.pmb')
    @push('scripts')
        <script>
            let databasesDataRegisterSource;
            let dataTableDataRegisterSourceInstance;
            let dataTableDataRegisterSourceInitialized = false;
            let urlRegisterSource = `/api/report/database/register/source?pmbVal=${pmbVal}`;
        </script>

        <script>
            const changeFilterDataRegisterSource = () => {
                let queryParams = [];

                let pmbVal = document.getElementById('change_pmb').value;

                if (pmbVal !== 'all') {
                    queryParams.push(`pmbVal=${pmbVal}`);
                }

                let queryString = queryParams.join('&');

                urlRegisterSource = `/api/report/database/register/source?${queryString}`;

                if (dataTableDataRegisterSourceInstance) {
                    showLoadingAnimation();
                    dataTableDataRegisterSourceInstance.clear();
                    dataTableDataRegisterSourceInstance.destroy();
                    getDataTableRegisterSource()
                        .then((response) => {
                            dataTableDataRegisterSourceInstance = $('#table-report-register-source').DataTable(response
                                .config);
                            dataTableDataRegisterSourceInitialized = response.initialized;
                            hideLoadingAnimation();
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }
            }

            const getDataTableRegisterSource = async () => {
                return new Promise(async (resolve, reject) => {
                    try {
                        const response = await axios.get(urlRegisterSource);
                        let registers = response.data.registers;
                        let presenters = response.data.presenters;

                        let headerBucket =
                            '<th scope="col" class="px-6 py-4 text-center">No</th><th scope="col" class="px-6 py-4 text-center">Sumber Data</th>'

                        let footerBucket =
                            '<th scope="col" colspan="2" class="px-6 py-4 text-center">Total</th>'

                        presenters.forEach((presenter, index) => {
                            headerBucket +=
                                `<th scope="col" class="px-6 py-4 text-center">${presenter.name}</th>`
                            footerBucket +=
                                `<td scope="col" class="px-6 py-4 text-center" id="total_${presenter.identity}">0</td>`
                        });

                        headerBucket += `<th scope="col" class="px-6 py-4 text-center">Total</th>`
                        footerBucket += `<td scope="col" class="px-6 py-4 text-center" id="total">0</td>`

                        let columnConfigs = [{
                                data: 'pmb',
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
                        ];

                        const groupedData = registers.reduce((result, currentItem) => {
                            const existingItem = result.find(item => item.name === currentItem
                                .name);

                            if (existingItem) {
                                const existingRegister = existingItem.register.find(reg => reg
                                    .presenter === currentItem.identity_user);

                                if (existingRegister) {
                                    existingRegister.count = currentItem.register;
                                } else {
                                    existingItem.register.push({
                                        presenter: currentItem.identity_user,
                                        count: currentItem.register
                                    });
                                }
                                existingItem.total = existingItem.register.reduce((acc, reg) =>
                                    acc + parseInt(reg.count), 0);
                            } else {
                                result.push({
                                    pmb: currentItem.pmb,
                                    name: currentItem.name,
                                    register: [{
                                        presenter: currentItem.identity_user,
                                        count: currentItem.register
                                    }],
                                    total: parseInt(currentItem.register)
                                });
                            }

                            return result;
                        }, []);


                        presenters.forEach((presenter) => {
                            columnConfigs.push({
                                data: {
                                    register: 'register',
                                    identity_user: 'identity_user',
                                },
                                render: (data, type, row) => {
                                    let bucket = data.register;
                                    let resultBucket = bucket.find((res) => res
                                        .presenter == presenter.identity)
                                    let result = (resultBucket ? parseInt(resultBucket
                                        .count) : 0);
                                    return result;
                                }
                            });
                        });

                        columnConfigs.push({
                            data: 'total',
                            render: (data, type, row) => {
                                return data;
                            }
                        });

                        const filteredData = registers.reduce((result, currentItem) => {
                            const existingItem = result.find(item => item.pmb === currentItem.pmb &&
                                item.identity_user === currentItem.identity_user);

                            if (existingItem) {
                                existingItem.count += parseInt(currentItem.register);
                            } else {
                                result.push({
                                    pmb: currentItem.pmb,
                                    identity_user: currentItem.identity_user,
                                    count: parseInt(currentItem.register)
                                });
                            }

                            return result;
                        }, []);

                        document.getElementById('headers_register_source').innerHTML = headerBucket;
                        document.getElementById('footers_register_source').innerHTML = footerBucket;

                        let total = 0;
                        filteredData.forEach((filter) => {
                            document.getElementById(`total_${filter.identity_user}`).innerText = parseInt(filter.count);
                            total += parseInt(filter.count);
                        });

                        document.getElementById('total').innerText = total;

                        const dataTableConfig = {
                            data: groupedData,
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
                changeFilterDataRegisterSource()
            }
        </script>
        <script>
            const promiseDataRegisterSource = () => {
                showLoadingAnimation();
                Promise.all([
                        getDataTableRegisterSource(),
                    ])
                    .then((response) => {
                        let responseDTRS = response[0];
                        dataTableDataRegisterSourceInstance = $('#table-report-register-source').DataTable(responseDTRS
                            .config);
                        dataTableDataRegisterSourceInitialized = responseDTRS.initialized;
                        hideLoadingAnimation();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
            promiseDataRegisterSource();
        </script>
    @endpush
</x-app-layout>
