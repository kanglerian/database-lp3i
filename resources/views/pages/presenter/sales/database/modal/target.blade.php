<!-- Main modal -->
<div id="modal-target" tabindex="-1" aria-hidden="true"
    class="hidden flex justify-center items-center fixed top-0 left-0 right-0 z-50  w-full px-8 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="fixed top-0 left-0 right-0 bottom-0 bg-black opacity-50"></div>
    <div class="relative w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-3xl shadow">
            <button type="button" onclick="modalTarget()"
                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-xl text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                data-modal-hide="modal-target">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="px-6 py-6 lg:px-8">
                <h3 class="mb-4 text-xl font-medium text-gray-900">Tambah Target Database</h3>
                <hr class="mb-3">
                <form class="space-y-4" action="{{ route('targetdatabase.store') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $presenter->identity }}" name="identity_user" id="identity_user">

                    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-3">
                        <div>
                            <label for="pmb" class="block mb-2 text-sm font-medium text-gray-900">PMB</label>
                            <input type="number" name="pmb" maxlength="4" id="pmb"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Tahun PMB" required>
                        </div>
                        <div>
                            <label for="total" class="block mb-2 text-sm font-medium text-gray-900">Total Target</label>
                            <input type="number" name="total" id="total"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="0" required>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center">Tambah Target</button>
                    <p class="text-xs text-gray-600 text-center">Periksa terlebih dahulu apakah sudah benar?</p>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const getYearPMB = () => {
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear();
        const currentMonth = currentDate.getMonth();
        const startYear = currentMonth >= 9 ? currentYear + 1 : currentYear;
        document.getElementById('pmb').value = startYear;
        document.getElementById('change_pmb').value = startYear;
    }
    getYearPMB();
</script>
