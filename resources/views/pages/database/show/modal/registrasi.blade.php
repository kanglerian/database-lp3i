<!-- Main modal -->
<div id="modal-registrasi" tabindex="-1" aria-hidden="true"
    class="hidden flex justify-center items-center fixed top-0 left-0 right-0 z-50  w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="fixed top-0 left-0 right-0 bottom-0 bg-black opacity-50"></div>
    <div class="relative w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">
            <button type="button" onclick="modalRegistrasi()"
                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                data-modal-hide="modal-registrasi">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="px-6 py-6 lg:px-8">
                <h3 class="mb-4 text-xl font-medium text-gray-900">Registrasi Mahasiswa Baru</h3>
                <hr class="mb-3">
                <form class="space-y-4" action="{{ route('registration.store') }}" method="POST">
                    @csrf
                    <div>
                        <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Tanggal
                            Registrasi</label>
                        <input type="date" name="date" id="date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Tanggal Registrasi" required>
                    </div>
                    <div>
                        <input type="hidden" value="{{ $user->identity }}" name="identity_user" id="identity_user"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                    <div>
                        <label for="nominal" class="block mb-2 text-sm font-medium text-gray-900">Nominal
                            Registrasi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                <span class="text-sm text-gray-500">Rp</span>
                            </div>
                            <input type="number" name="nominal" id="nominal"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"placeholder="0"
                                required>
                        </div>
                    </div>
                    <div>
                        <label for="deal" class="block mb-2 text-sm font-medium text-gray-900">Harga Deal</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                <span class="text-sm text-gray-500">Rp</span>
                            </div>
                            <input type="number" name="deal" id="deal"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="0" required>
                        </div>
                    </div>
                    <div>
                        <label for="discount" class="block mb-2 text-sm font-medium text-gray-900">Potongan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                <span class="text-sm text-gray-500">Rp</span>
                            </div>
                            <input type="number" name="discount" id="discount"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="0" required>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Registrasi
                        Sekarang!</button>
                    <p class="text-xs text-gray-600 text-center">Periksa terlebih dahulu apakah sudah benar?</p>
                </form>
            </div>
        </div>
    </div>
</div>
