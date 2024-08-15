<!-- Main modal -->
<div id="modal-add-category-scholarship" tabindex="-1" aria-hidden="true"
    class="hidden flex justify-center items-center fixed top-0 left-0 right-0 z-50  w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="fixed top-0 left-0 right-0 bottom-0 bg-black opacity-50"></div>
    <div class="relative w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-3xl shadow">
            <button type="button" onclick="modalAddCategoryScholarship()"
                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                data-modal-hide="modal-daftar">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="p-8">
                <h3 class="mb-4 text-xl font-medium text-gray-900">Tambah Kategori Soal</h3>
                <hr class="mb-3">
                <form class="space-y-4" method="POST" onsubmit="return handleAddCategory(event)">
                    <div class="grid grid-cols-1">
                        <div>
                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900">Nama
                                Kategori</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <i class="fa-solid fa-tag text-gray-400"></i>
                                </div>
                                <input type="text" name="category" id="category"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                    placeholder="Kategori" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center">Tambah
                        Sekarang!</button>
                    <p class="text-xs text-gray-600 text-center">Periksa terlebih dahulu apakah sudah benar?</p>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const handleAddCategory = async (e) => {
        e.preventDefault();
        const categoryInput = e.target.elements.category;
        if (categoryInput.value) {
            await axios.post(`http://localhost:3000/categories`, {
                    name: categoryInput.value,
                })
                .then((response) => {
                    alert(response.data.message);
                    categoryInput.value = '';
                    modalAddCategoryScholarship();
                })
                .catch((error) => {
                    alert(error.message);
                });
        }
    }
</script>
