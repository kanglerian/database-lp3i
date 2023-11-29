<!-- Main modal -->
<div id="modal-daftar" tabindex="-1" aria-hidden="true"
    class="hidden flex justify-center items-center fixed top-0 left-0 right-0 z-50  w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="fixed top-0 left-0 right-0 bottom-0 bg-black opacity-50"></div>
    <div class="relative w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">
            <button type="button" onclick="modalDaftar()"
                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                data-modal-hide="modal-daftar">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="px-6 py-6 lg:px-8">
                <h3 class="mb-4 text-xl font-medium text-gray-900">Daftar Mahasiswa Baru</h3>
                <hr class="mb-3">
                <form class="space-y-4" action="{{ route('enrollment.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-3">
                        <div>
                            <label for="pmb" class="block mb-2 text-sm font-medium text-gray-900">Tahun PMB</label>
                            <input type="number" value="{{ $user->pmb }}" name="pmb" id="pmb"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Tahun PMB" required>
                        </div>
                        <div>
                            <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Tanggal
                                Daftar</label>
                            <input type="date" name="date" id="date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Tanggal Daftar" required>
                        </div>
                    </div>
                    <div>
                        <input type="hidden" value="{{ $user->identity }}" name="identity_user" id="identity_user"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                    <div class="grid grid-cols-1">
                        <div>
                            <label for="receipt" class="block mb-2 text-sm font-medium text-gray-900">No.
                                Kwitansi</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <i class="fa-solid fa-receipt text-gray-400"></i>
                                </div>
                                <input type="number" name="receipt" id="receipt"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                    placeholder="No. Kwitansi" required>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-3">
                        <div>
                            <label for="register"
                                class="block mb-2 text-sm font-medium text-gray-900">Keterangan</label>
                            <select id="register" name="register"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                                <option>Daftar Kampus</option>
                                <option>Daftar BK</option>
                                <option>Daftar TF Kampus</option>
                            </select>
                        </div>
                        <div>
                            <label for="register_end" class="block mb-2 text-sm font-medium text-gray-900">Keterangan
                                Daftar</label>
                            <select id="register_end" name="register_end"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                                <option>Daftar Kampus</option>
                                <option>Daftar BK</option>
                                <option>Daftar TF Kampus</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1">
                        <div>
                            <label for="nominal" class="block mb-2 text-sm font-medium text-gray-900">Nominal
                                Daftar</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <span class="text-sm text-gray-500">Rp</span>
                                </div>
                                <input type="text" name="nominal" id="nominal" onkeyup="validateNumber(event)"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"placeholder="0"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-3">
                        <div>
                            <label for="repayment" class="block mb-2 text-sm font-medium text-gray-900">Pengembalian
                                BK</label>
                            <input type="date" name="repayment" id="repayment"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Tanggal Pengembalian BK">
                        </div>
                        <div>
                            <label for="debit" class="block mb-2 text-sm font-medium text-gray-900">Debit</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <span class="text-sm text-gray-500">Rp</span>
                                </div>
                                <input type="text" name="debit" id="debit" onkeyup="validateNumber(event)"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                    placeholder="0">
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="note" class="block mb-2 text-sm font-medium text-gray-900">Catatan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                <i class="fa-solid fa-note-sticky text-gray-400"></i>
                            </div>
                            <input type="text" name="note" id="note"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                placeholder="Catatan">
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Daftar
                        Sekarang!</button>
                    <p class="text-xs text-gray-600 text-center">Periksa terlebih dahulu apakah sudah benar?</p>
                </form>
            </div>
        </div>
    </div>
</div>
