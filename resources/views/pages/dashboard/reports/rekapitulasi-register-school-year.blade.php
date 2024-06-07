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
                                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">Rekap
                                Perolehan PMB</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">
                                Rekap Data Aplikan Register Per Sekolah
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
                    <div class="w-full flex flex-col space-y-1 p-1 md:p-0">
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
        <div class="max-w-7xl px-5 mx-auto space-y-5">
            <section class="bg-gray-50 p-8 rounded-3xl border border-gray-200 space-y-5">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500"
                        id="table-report-register-school-year">
                        <thead class="text-xs text-gray-700 uppercase">
                            <tr>
                                <th scope="col" rowspan="2" class="px-6 py-4 text-center">No</th>
                                <th scope="col" rowspan="2" class="px-6 py-4 text-center">Nama Sekolah</th>
                                <th scope="col" colspan="5" class="px-6 py-4 text-center">Lulusan</th>
                            </tr>
                            <tr id="headers-report-register-school-year">
                                <th scope="col" class="px-6 py-4 text-center">2024</th>
                                <th scope="col" class="px-6 py-4 text-center">2023</th>
                                <th scope="col" class="px-6 py-4 text-center">2022</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </section>
            <section>
                <div>
                    <div id="map" class="rounded-3xl border border-gray-300"></div>
                </div>
            </section>
        </div>
    </section>
    @include('pages.dashboard.utilities.all')
    @include('pages.dashboard.utilities.pmb')
    @push('scripts')
        <script>
            let databasesDataRegisterSchoolYear;
            let dataTableDataRegisterSchoolYearInstance;
            let dataTableDataRegisterSchoolYearInitialized = false;
            let urlRegisterSchoolYear =
                `/api/report/database/register/school/year?pmbVal=${pmbVal}&identityVal=${identityVal}&roleVal=${roleVal}`;
            let map = L.map('map').setView([-6.618, 107.282], 8);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://politekniklp3i-tasikmalaya.ac.id">Politeknik LP3I Kampus Tasikmalaya</a>'
            }).addTo(map);
        </script>

        <script>
            const changeFilterDataRegisterSchoolYear = () => {
                map.stop();
                let queryParams = [];

                let identityVal = document.getElementById('identity_val').value;
                let roleVal = document.getElementById('role_val').value;

                if (identityVal !== 'all') {
                    queryParams.push(`identityVal=${identityVal}`);
                }

                if (roleVal !== 'all') {
                    queryParams.push(`roleVal=${roleVal}`);
                }

                let queryString = queryParams.join('&');

                urlRegisterSchoolYear = `/api/report/database/register/school/year?${queryString}`;

                if (dataTableDataRegisterSchoolYearInstance) {
                    showLoadingAnimation();
                    dataTableDataRegisterSchoolYearInstance.clear();
                    dataTableDataRegisterSchoolYearInstance.destroy();
                    getDataTableRegisterSchoolYear()
                        .then((response) => {
                            dataTableDataRegisterSchoolYearInstance = $('#table-report-register-school-year').DataTable(
                                response
                                .config);
                            dataTableDataRegisterSchoolYearInitialized = response.initialized;
                            hideLoadingAnimation();
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }
            }

            const getDataTableRegisterSchoolYear = async () => {
                return new Promise(async (resolve, reject) => {
                    try {
                        const response = await axios.get(urlRegisterSchoolYear);
                        let registers = response.data;

                        const reducedData = registers.reduce((accumulator, currentValue) => {
                            const existingItem = accumulator.find(item => item.name === currentValue
                                .name);

                            pmbVal = document.getElementById('change_pmb').value;

                            if (existingItem) {
                                let years = [];
                                for (let i = 0; i < 5; i++) {
                                    years.push(parseInt(pmbVal) - i)
                                }
                                years.forEach(year => {
                                    const existingYear = existingItem.register.find((
                                        entry) => entry.year == year);
                                    if (existingYear.year == currentValue.year) {
                                        existingYear.count += parseInt(currentValue
                                            .register)
                                    }
                                });
                            } else {
                                const record = {
                                    identity_user: currentValue.identity_user,
                                    name: currentValue.name,
                                    lat: currentValue.lat,
                                    lng: currentValue.lng,
                                    pmb: currentValue.pmb,
                                    register: []
                                };

                                let years = [];
                                for (let i = 0; i < 5; i++) {
                                    years.push(parseInt(pmbVal) - i)
                                }
                                years.forEach(year => {
                                    if (year == currentValue.year) {
                                        record.register.push({
                                            year: year,
                                            count: parseInt(currentValue.register)
                                        });
                                    } else {
                                        record.register.push({
                                            year: year,
                                            count: 0
                                        });
                                    }
                                });

                                accumulator.push(record);
                            }

                            return accumulator;
                        }, []);

                        let headerBucket = '';

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

                        for (let i = 0; i < 5; i++) {
                            headerBucket +=
                                `<th scope="col" class="px-6 py-4 text-center">${parseInt(pmbVal) - i}</th>`
                            columnConfigs.push({
                                data: 'register',
                                render: (data, type, row, meta) => {
                                    return data[i].count;
                                }
                            }, );
                        }

                        document.getElementById('headers-report-register-school-year').innerHTML =
                            headerBucket;

                        reducedData.forEach((result) => {
                            console.log(result);
                            const lat = result.lat ?? -6.618;
                            const lng = result.lng ?? 107.282;
                            const marker = L.marker([lat, lng]).addTo(map);
                            const dataRegist = result.register;
                            let resultRegist = '';
                            dataRegist.forEach((data) => {
                                resultRegist += `
                                    <li>${data.year}: ${data.count}</li>
                                `
                            });
                            const paragraph = `
                            <b>${result.name}</b>
                            <hr style="margin: 5px 0px"/>
                            <ul>${resultRegist}</ul>`
                            marker.bindPopup(paragraph).openPopup();

                            const circle = L.circle([lat, lng], {
                                color: 'red',
                                fillColor: '#f03',
                                fillOpacity: 0.5,
                                radius: 80
                            }).addTo(map);
                        });

                        const dataTableConfig = {
                            data: reducedData,
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
                changeFilterDataRegisterSchoolYear()
            }
        </script>
        <script>
            const promiseDataRegisterSchoolYear = () => {
                showLoadingAnimation();
                Promise.all([
                        getDataTableRegisterSchoolYear(),
                    ])
                    .then((response) => {
                        let responseDTRS = response[0];
                        dataTableDataRegisterSchoolYearInstance = $('#table-report-register-school-year').DataTable(
                            responseDTRS
                            .config);
                        dataTableDataRegisterSchoolYearInitialized = responseDTRS.initialized;
                        hideLoadingAnimation();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
            promiseDataRegisterSchoolYear();
        </script>
    @endpush
</x-app-layout>
