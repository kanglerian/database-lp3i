<!-- Main modal -->
<div id="modal-edit-target" tabindex="-1" aria-hidden="true"
    class="hidden flex justify-center items-center fixed top-0 left-0 right-0 z-50  w-full px-8 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="fixed top-0 left-0 right-0 bottom-0 bg-black opacity-50"></div>
    <div class="relative w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-3xl shadow">
            <button type="button" onclick="modalEditTarget()"
                class="absolute top-7 right-5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-xl text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                data-modal-hide="modal-target">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="p-8">
                <h3 class="mb-4 text-xl font-medium text-gray-900">Ubah Target Database</h3>
                <hr class="mb-3">
                <form class="space-y-4" id="edit-form" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="grid grid-cols-1 gap-3">
                        <div>
                            <label for="edit_total" class="block mb-2 text-sm font-medium text-gray-900">Total Target</label>
                            <input type="number" name="edit_total" id="edit_total"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="0" required>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
                    <p class="text-xs text-gray-600 text-center">Periksa terlebih dahulu apakah sudah benar?</p>
                </form>
            </div>
        </div>
    </div>
</div>
