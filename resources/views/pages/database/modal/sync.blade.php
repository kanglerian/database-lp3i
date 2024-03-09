<!-- Main modal -->
<div id="modal-sync" tabindex="-1" aria-hidden="true"
    class="hidden flex justify-center items-center fixed top-0 left-0 right-0 z-40  w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="fixed top-0 left-0 right-0 bottom-0 bg-black opacity-50"></div>
    <div class="relative w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-3xl shadow">
            <button type="button" onclick="hideSync()"
                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full text-sm w-8 h-8 ml-auto inline-flex justify-center items-center">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="p-8">
                <div class="space-y-1 mb-3">
                    <h3 class="text-lg font-bold text-gray-900">Sinkronisasi Spreadsheet</h3>
                    <p class="text-sm text-gray-600">Berikut ini adalah menu untuk sinkronisasi spreadsheet.</p>
                </div>
                <hr class="mb-3">
                <div class="space-y-3">
                    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-3">
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Dari</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <i class="fa-solid fa-table-columns text-gray-500"></i>
                                </div>
                                <input type="number" name="start" id="start" onkeyup="validateInput()"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                    placeholder="Dari baris ke ..." required>
                            </div>
                        </div>
                        <div>
                            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Sampai</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <i class="fa-solid fa-table-columns text-gray-500"></i>
                                </div>
                                <input type="number" name="end" id="end" onkeyup="validateInput()"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                    placeholder="Sampai baris ke ..." required>
                            </div>
                        </div>
                    </div>
                    <p class="text-sm text-center text-gray-700">Yuk, sinkronisasi data! Rekomendasi kami adalah untuk tidak lebih dari <span id="max-count">0</span> data yang akan disinkronkan. Sekarang, berapa banyak data yang akan Anda sinkronkan? <span class="font-bold text-green-700"
                            id="count-sync"></span>.</p>
                    <p class="text-xs text-center text-gray-700">Jika bingung, tak perlu ragu untuk langsung klik tombol sinkronisasi.</p>
                    <button onclick="syncNow()" id="button-sync"
                        class="w-full text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center">Sinkronisasi
                        Sekarang!</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let total;
    let standart;
    const syncSpreadsheet = async (sheet) => {
        showLoadingAnimation();
        try {
            const response = await axios.get(`import/check-spreadsheet/${sheet}`);
            const maxCount = 1000;
            total = response.data.applicants;
            standart = total > maxCount ? maxCount : 1;
            document.getElementById('start').value = total - standart;
            document.getElementById('count-sync').innerText = `${standart} data`;
            document.getElementById('end').value = total;
            document.getElementById('max-count').innerText = maxCount;
            total = total - 1;
            let modalElement = document.getElementById('modal-sync');
            modalElement.classList.toggle('hidden');
            hideLoadingAnimation();
        } catch (error) {
            console.log(error);
            hideLoadingAnimation();
        }
    }

    const validateInput = () => {
        let buttonElement = document.getElementById('button-sync');
        let start = document.getElementById('start').value;
        let end = document.getElementById('end').value;
        if (end > total) {
            document.getElementById('end').value = total;
        }
        if (start > total) {
            document.getElementById('start').value = standart;
        }
        if (start == 0) {
            document.getElementById('start').value = 1;
        }
        let result = end - start;
        document.getElementById('count-sync').innerText = result;
        if (result > 2000 || result < 10) {
            buttonElement.style.display = 'none';
        } else {
            buttonElement.style.display = 'block';
        }
    }

    const syncNow = async () => {
        showLoadingAnimation();
        let start = document.getElementById('start').value;
        let end = document.getElementById('end').value;
        await axios.get(`import/applicants?start=${start}&end=${end}`)
            .then((response) => {
                alert(response.data.message);
                hideLoadingAnimation();
            })
            .catch((error) => {
                alert(error.message);
                hideLoadingAnimation();
            });
        document.getElementById('modal-sync').classList.toggle('hidden');
    }

    const hideSync = () => {
        let modalElement = document.getElementById('modal-sync');
        modalElement.classList.toggle('hidden');
    }
</script>
