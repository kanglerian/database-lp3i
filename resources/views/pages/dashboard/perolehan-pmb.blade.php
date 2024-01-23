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
                                Rekap Perolehan PMB
                            </span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <section class="space-y-5 py-8">
        @include('pages.dashboard.database.filter')
        <div class="max-w-7xl px-5 mx-auto">
            <section class="bg-white p-5 md:rounded-xl border border-gray-100 space-y-5">
                <header class="space-y-1 mb-5">
                    <div class="flex items-center gap-2">
                        <i class="fa-regular fa-circle-dot"></i>
                        <h2 class="font-bold text-gray-800">Rekap Perolehan PMB</h2>
                    </div>
                    <p class="text-sm text-gray-700 text-sm">
                        Berikut ini adalah hasil perhitungan dari riwayat pesan.
                    </p>
                </header>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500" id="table-report-perolehan-pmb">
                        <thead class="text-xs text-gray-700 uppercase">
                            <tr>
                                <th rowspan="2" scope="col" class="px-6 py-4 text-center">
                                    No
                                </th>
                                <th rowspan="2" scope="col" class="px-6 py-4 text-center">
                                    Bulan
                                </th>
                                <th rowspan="2" scope="col" class="px-6 py-4 text-center">
                                    Aplikan
                                </th>
                                <th rowspan="2" scope="col" class="px-6 py-4 text-center">
                                    Daftar
                                </th>
                                <th colspan="2" scope="col" class="px-6 py-4 text-center">
                                    Bulan
                                </th>
                                <th rowspan="2" scope="col" class="px-6 py-4 text-center">
                                    Total Registrasi
                                </th>
                                <th colspan="2" scope="col" class="px-6 py-4 text-center">
                                    Potensi Omset
                                </th>
                                <th rowspan="2" scope="col" class="px-6 py-4 text-center">
                                    Total Potensi Omset
                                </th>
                                <th colspan="2" scope="col" class="px-6 py-4 text-center">
                                    Harga Jual Rata-Raata
                                </th>
                                <th rowspan="2" scope="col" class="px-6 py-4 text-center">
                                    Harga Jual Rata-Rata All
                                </th>
                            </tr>
                            <tr>
                                <th scope="col" class="px-6 py-4 text-center">
                                    Reguler
                                </th>
                                <th scope="col" class="px-6 py-4 text-center">
                                    Non Reguler
                                </th>
                                <th scope="col" class="px-6 py-4 text-center">
                                    Reguler
                                </th>
                                <th scope="col" class="px-6 py-4 text-center">
                                    Non Reguler
                                </th>
                                <th scope="col" class="px-6 py-4 text-center">
                                    Reguler
                                </th>
                                <th scope="col" class="px-6 py-4 text-center">
                                    Non Reguler
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>lorem</td>
                                <td>lorem</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </section>
    @push('scripts')
        <script>
            let dataTableDataPerolehanPMBInstance;
            let dataTableDataPerolehanPMBInitialized = false;
            const getDataTablePerolehanPMB = async () => {
                let database;
                fetch(`/api/report/database/perolehanpmb`)
                .then((response) => {
                    if(!response.ok){
                        console.log('Network Error');
                    }
                    return response.json();
                })
                .then((data) => {
                    database = data;
                })
                .catch((error) => {
                    console.log(error);
                });

                const dataTableConfig = {
                    data: database,
                    columnDefs: [{
                            width: 10,
                            target: 0
                        },
                        {
                            width: 100,
                            targets: [1, 2, 3, 4, 5, 6, 7]
                        },
                    ],
                    columns: [
                        {
                            data: 'id',
                            render: (data, type, row, meta) => {
                                return meta.row + 1;
                            }
                        },
                    ],
                }


                dataTableDataPerolehanPMBInstance = $('#table-report-perolehan-pmb').DataTable(dataTableConfig);
                    dataTableDataPerolehanPMBInitialized = true;
            }
            getDataTablePerolehanPMB();
        </script>
    @endpush
    @include('pages.dashboard.utilities.scripts')
</x-app-layout>
