@if (Auth::user()->role !== 'S')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-3">
        <div class="grid grid-cols-1 gap-4">
            <div class="bg-white relative overflow-x-auto border border-gray-200 sm:rounded-lg">
                <header class="w-full md:w-1/2 p-5 space-y-2">
                    <h1 class="flex items-center gap-2 font-bold text-gray-700">
                        <span>Quick Search: </span>
                        <span id="count-quicksearch"
                            class="inline-block bg-red-500 px-2 py-1 rounded-lg text-xs text-white">
                            0
                        </span>
                    </h1>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <i class="fa-solid fa-magnifying-glass text-gray-500"></i>
                        </div>
                        <input type="search" id="quick-search" onchange="quickSearch()"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                            placeholder="Cari calon mahasiswa disini...">
                    </div>
                    <p id="quick-search" class="mt-2 text-xs text-gray-500">Fitur cari cepat data calon
                        mahasiswa.
                        Untuk selengkapnya <a href="{{ route('database.index') }}"
                            class="font-medium text-blue-600 hover:underline">klik disini.</a>
                    </p>
                </header>
                <hr class="mb-5">
                <section class="px-5 pb-5">
                    <table id="quickSearchTable" class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-white">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    No.
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    getYearPMB
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nama Lengkap
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Presenter
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Sumber Database
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Asal Sekolah
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Tahun Lulus
                                </th>
                            </tr>
                        </thead>
                        <tbody id="result-quicksearch">
                            <tr class="border-b bg-gray-50">
                                <td colspan="7" class="px-6 py-4 text-center">Silahkan untuk isi kolom
                                    pencarian.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </section>
                <hr class="mb-5">
                <div class="px-5 pb-5">
                    <p class="text-gray-500 text-xs">Silahkan untuk klik nama untuk melihat informasi lebih lanjut.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endif
