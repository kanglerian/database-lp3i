@if (Auth::user()->role !== 'S')
    <div class="max-w-7xl mx-auto">
        <section class="bg-white p-5 md:rounded-xl border border-gray-100">
            <header class="space-y-1">
                <h2 class="font-bold text-gray-800">Riwayat Target Pengiriman Pesan</h2>
                <p class="text-sm text-gray-700 text-sm">
                    Berikut ini adalah hasil perhitungan dari riwayat pesan.
                </p>
            </header>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-3 my-5">
                <div class="bg-lp3i-200 text-sm py-4 px-5 rounded-xl text-white">
                    <i class="fa-solid fa-phone"></i>
                    <i class="fa-solid fa-database mr-2"></i>
                    <span>Total: </span>
                    <span id="phonehistory_total" class="font-bold">0</span>
                </div>
                <div class="bg-emerald-500 text-sm py-4 px-5 rounded-xl text-white">
                    <i class="fa-solid fa-phone"></i>
                    <i class="fa-solid fa-circle-check mr-2"></i>
                    <span>Valid: </span>
                    <span id="phonehistory_valid" class="font-bold">0</span>
                </div>
                <div class="bg-red-500 text-sm py-4 px-5 rounded-xl text-white">
                    <i class="fa-solid fa-phone"></i>
                    <i class="fa-solid fa-circle-xmark mr-2"></i>
                    <span>Tidak Valid: </span>
                    <span id="phonehistory_nonvalid" class="font-bold">0</span>
                </div>
            </div>
            <div class="relative overflow-x-auto border border-gray-200 rounded-xl">
                @if (Auth::user()->role == 'P')
                    <button onclick="updateHistories()"
                        class="text-sm bg-red-500 hover:bg-red-600 rounded-lg px-4 py-2 text-white">Jangan ditekan,
                        bahaya!</button>
                @endif
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase">
                        <tr>
                            <th scope="col" class="px-6 py-4 bg-gray-50">
                                Nama Presenter
                            </th>
                            <th scope="col" class="px-6 py-4 text-center bg-white">
                                Kategori 1
                            </th>
                            <th scope="col" class="px-6 py-4 text-center bg-gray-50">
                                Kategori 2
                            </th>
                            <th scope="col" class="px-6 py-4 text-center bg-white">
                                Kategori 3
                            </th>
                            <th scope="col" class="px-6 py-4 text-center bg-gray-50">
                                Kategori 4
                            </th>
                            <th scope="col" class="px-6 py-4 text-center bg-white">
                                Kategori 5
                            </th>
                            <th scope="col" class="px-6 py-4 text-center bg-gray-50">
                                Kategori 6
                            </th>
                            <th scope="col" class="px-6 py-4 text-center bg-white">
                                Kategori 7
                            </th>
                            <th scope="col" class="px-6 py-4 text-center bg-gray-50">
                                Kategori 8
                            </th>
                            <th scope="col" class="px-6 py-4 text-center bg-white">
                                Kategori 9
                            </th>
                            <th scope="col" class="px-6 py-4 text-center bg-gray-50">
                                Kategori 10
                            </th>
                            <th scope="col" class="px-6 py-4 text-center bg-white">
                                Kategori 11
                            </th>
                            <th scope="col" class="px-6 py-4 text-center bg-gray-50">
                                Kategori 12
                            </th>
                        </tr>
                    </thead>
                    <tbody id="history_chat_presenter">
                        <tr>
                            <td colspan="13" class="bg-white text-center text-sm px-6 py-4">Tidak ada data.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endif
