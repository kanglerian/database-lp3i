<x-app-layout>
    <x-slot name="header">
        <nav class="flex items-center justify-between">
            <ol class="inline-flex items-center space-x-2 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('setting.index') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">
                        <i class="fa-solid fa-gears me-1"></i>
                        Setting
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fa-solid fa-angle-right text-gray-300 me-2"></i>
                        <span class="text-sm font-medium text-gray-500">Master Program Studi</span>
                    </div>
                </li>
            </ol>
            <a href="https://api.politekniklp3i-tasikmalaya.com" target="_blank" class="bg-sky-500 text-white text-xs py-2 px-4 rounded-xl transition-all ease-in-out">
                <i class="fa-solid fa-circle-nodes"></i>
                <span>API</span>
            </a>
        </nav>
    </x-slot>

    <main>
        @if (session('message'))
            <div id="alert" class="flex items-center p-4 mb-4 bg-emerald-500 text-emerald-50 rounded-2xl"
                role="alert">
                <i class="fa-solid fa-circle-check"></i>
                <div class="ml-3 text-sm font-reguler">
                    {{ session('message') }}
                </div>
            </div>
        @endif
        @if (session('error'))
            <div id="alert" class="flex items-center p-4 mb-4 bg-red-500 text-red-50 rounded-2xl" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div class="ml-3 text-sm font-reguler">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        <section class="space-y-4">
          <a href="{{ route('programtype.create') }}" class="inline-block text-white bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5">Tambah data</a>
            <div class="relative overflow-x-auto border rounded-3xl p-8">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500" id="table-program-studi">
                    <thead class="text-xs text-gray-700 uppercase">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-center">No</th>
                            <th scope="col" class="px-6 py-4 text-center">Kode</th>
                            <th scope="col" class="px-6 py-4 text-center">Program Studi</th>
                            <th scope="col" class="px-6 py-4 text-center">Kampus</th>
                            <th scope="col" class="px-6 py-4 text-center">Tipe</th>
                            <th scope="col" class="px-6 py-4 text-center">Status</th>
                            <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </section>
    </main>
    <script>
      function confirmDelete() {
          return confirm('Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.');
      }
    </script>
    @push('scripts')
        <script>
            const getDataTableRegisterProgram = async () => {
                console.log(URL_API_LP3I);
                return new Promise(async (resolve, reject) => {
                    try {
                        const response = await axios.get(`${URL_API_LP3I}/dashboard/programs/all`);
                        const programs = response.data;
                        console.log(programs);

                        let columnConfigs = [
                            {
                                data: 'uuid',
                                render: (data, type, row, meta) => {
                                    return meta.row + 1;
                                },
                            },
                            {
                                data: 'code',
                                render: (data, type, row, meta) => {
                                    return data;
                                },
                            },
                            {
                                data: {
                                    title: 'title',
                                    level: 'level',
                                },
                                render: (data, type, row, meta) => {
                                    return `${data.level} ${data.title}`;
                                },
                            },
                            {
                                data: 'campus',
                                render: (data, type, row, meta) => {
                                    return data;
                                },
                            },
                            {
                                data: 'type',
                                render: (data, type, row, meta) => {
                                    switch (data) {
                                        case 'R':
                                            return 'Reguler';
                                        case 'N':
                                            return 'Non Reguler';
                                        case 'RPL':
                                            return 'Rekognisi Pembelajaran Lampau';
                                        default:
                                            return 'Tidak diketahui';
                                    }
                                },
                            },
                            {
                                data: 'status',
                                render: (data, type, row, meta) => {
                                    const icon = data ? 'fa-toggle-on' : 'fa-toggle-off';
                                    const bgColor = data ? 'bg-emerald-500' : 'bg-red-500';
                                    const buttonText = data ? 'Aktif' : 'Tidak Aktif';
                                    return `
                                        <button class="${bgColor} text-white px-3 py-1.5 rounded-lg text-xs" onclick="toggleStatus('${row.uuid}')">
                                            <i class="fa-solid ${icon}"></i> ${buttonText}
                                        </button>
                                    `;
                                },
                            },
                            {
                                data: 'uuid',
                                render: (data, type, row, meta) => {
                                    const buttonEdit = `<button type="button" onclick="alert('Hello!')" class="bg-yellow-500 hover:bg-yellow-600 px-4 py-2 rounded-xl rounded-xl text-xs text-white transition-all ease-in-out"><i class="fa-solid fa-edit"></i></button>`
                                    const buttonDelete = `<button type="button" onclick="alert('Hello!')" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-xl rounded-xl text-xs text-white transition-all ease-in-out"><i class="fa-solid fa-trash-can"></i></button>`
                                    return `${buttonEdit} ${buttonDelete}`;
                                },
                            },
                        ];

                        const dataTableConfig = {
                            data: programs,
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
            const promiseDataRegisterProgram = () => {
                showLoadingAnimation();
                Promise.all([
                    getDataTableRegisterProgram(),
                ])
                    .then((response) => {
                        let responseDTRS = response[0];
                        dataTableDataRegisterProgramInstance = $('#table-program-studi').DataTable(
                            responseDTRS
                                .config);
                        dataTableDataRegisterProgramInitialized = responseDTRS.initialized;
                        hideLoadingAnimation();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
            promiseDataRegisterProgram();
        </script>
    @endpush
</x-app-layout>
