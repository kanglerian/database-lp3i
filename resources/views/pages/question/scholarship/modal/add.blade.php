<!-- Main modal -->
<div id="modal-add-test-scholarship" tabindex="-1" aria-hidden="true"
    class="hidden flex justify-center items-center fixed top-0 left-0 right-0 z-50  w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="fixed top-0 left-0 right-0 bottom-0 bg-black opacity-50"></div>
    <div class="relative w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-2xl shadow">
            <button type="button" onclick="modalAddTestScholarship()"
                class="absolute top-5 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                data-modal-hide="modal-daftar">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="px-6 py-6 lg:px-8">
                <h3 class="mb-4 text-xl font-medium text-gray-900">Tambah Soal Beasiswa</h3>
                <hr class="mb-3">
                <form class="space-y-4" onsubmit="handleSubmit(event)" method="POST">
                    <div class="grid grid-cols-1">
                        <div>
                            <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900">
                                Kategori
                            </label>
                            <select id="category_id" name="category_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                                <option>Pilih kategori</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 mb-10">
                        <div>
                            <label for="question" class="block mb-2 text-sm font-medium text-gray-900">
                                Soal Beasiswa
                            </label>
                            <div id="question_container" style="height: 150px;"></div>
                        </div>
                    </div>
                    <hr>
                    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-3">
                        <div>
                            <label for="answer_a" class="block mb-2 text-sm font-medium text-gray-900">Jawaban A</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <i class="fa-solid fa-key text-gray-400"></i>
                                </div>
                                <input type="text" name="answer_a" id="answer_a"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                    placeholder="Jawaban A" required>
                            </div>
                            <div class="flex items-center gap-2 mt-2">
                                <div class="flex items-center">
                                    <input id="status_a_true" type="radio" value="true" name="status_a"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500"
                                        required>
                                    <label for="status_a_true"
                                        class="ms-2 text-xs font-medium text-gray-900">Benar</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="status_a_false" type="radio" value="false" name="status_a"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500"
                                        required>
                                    <label for="status_a_false"
                                        class="ms-2 text-xs font-medium text-gray-900">Salah</label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 md:mt-0">
                            <label for="answer_b" class="block mb-2 text-sm font-medium text-gray-900">Jawaban B</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <i class="fa-solid fa-key text-gray-400"></i>
                                </div>
                                <input type="text" name="answer_b" id="answer_b"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                    placeholder="Jawaban B" required>
                            </div>
                            <div class="flex items-center gap-2 mt-2">
                                <div class="flex items-center">
                                    <input id="status_b_true" type="radio" value="true" name="status_b"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500"
                                        required>
                                    <label for="status_b_true"
                                        class="ms-2 text-xs font-medium text-gray-900">Benar</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="status_b_false" type="radio" value="false" name="status_b"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500"
                                        required>
                                    <label for="status_b_false"
                                        class="ms-2 text-xs font-medium text-gray-900">Salah</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-3 mb-4">
                        <div>
                            <label for="answer_c" class="block mb-2 text-sm font-medium text-gray-900">Jawaban C</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <i class="fa-solid fa-key text-gray-400"></i>
                                </div>
                                <input type="text" name="answer_c" id="answer_c"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                    placeholder="Jawaban C" required>
                            </div>
                            <div class="flex items-center gap-2 mt-2">
                                <div class="flex items-center">
                                    <input id="status_c_true" type="radio" value="true" name="status_c"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500"
                                        required>
                                    <label for="status_c_true"
                                        class="ms-2 text-xs font-medium text-gray-900">Benar</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="status_c_false" type="radio" value="false" name="status_c"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500"
                                        required>
                                    <label for="status_c_false"
                                        class="ms-2 text-xs font-medium text-gray-900">Salah</label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 md:mt-0">
                            <label for="answer_d" class="block mb-2 text-sm font-medium text-gray-900">Jawaban
                                D</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <i class="fa-solid fa-key text-gray-400"></i>
                                </div>
                                <input type="text" name="answer_d" id="answer_d"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                    placeholder="Jawaban D" required>
                            </div>
                            <div class="flex items-center gap-2 mt-2">
                                <div class="flex items-center">
                                    <input id="status_d_true" type="radio" value="true" name="status_d"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500"
                                        required>
                                    <label for="status_d_true"
                                        class="ms-2 text-xs font-medium text-gray-900">Benar</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="status_d_false" type="radio" value="false" name="status_d"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500"
                                        required>
                                    <label for="status_d_false"
                                        class="ms-2 text-xs font-medium text-gray-900">Salah</label>
                                </div>
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
    const getCategories = async () => {
        await axios.get(`http://localhost:3000/categories`)
            .then((response) => {
                let bucket = '';
                let categories = response.data;
                if (categories.length) {
                    categories.forEach(category => {
                        bucket += `<option value="${category.id}">${category.name}</option>`
                    });
                } else {
                    bucket += `<option value="Kategori belum ada">Kategori belum ada</option>`
                }
                document.getElementById('category_id').innerHTML = bucket;
            })
            .catch((error) => {
                document.getElementById('category_id').innerHTML = `<option>${error.message}</option>`;
            });
    }
    getCategories();
</script>
<script src="{{ asset('js/quill.min.js') }}"></script>
<script>
    var quill = new Quill('#question_container', {
        modules: {
            toolbar: [
                [{
                    header: [1, 2, false]
                }],
                ['bold', 'italic', 'underline', 'strike'],
            ]
        },
        placeholder: 'Tulis soal disini..',
        theme: 'snow'
    });
</script>
<script>
    const handleSubmit = async (e) => {
        e.preventDefault();
        const target = e.target;
        const question = quill.root.innerHTML;
        if (target[0].value !== 'Kategori belum ada') {
            let dataQuestion = {
                category_id: target[0].value,
                question: question,
            }
            await axios.post(`http://localhost:3000/questions`, dataQuestion)
                .then(async (response) => {
                    let id = response.data.id;
                    let answers = [{
                        question_id: id,
                        answer: target[7].value,
                        correct: target[8].checked,
                    }, {
                        question_id: id,
                        answer: target[10].value,
                        correct: target[11].checked,
                    }, {
                        question_id: id,
                        answer: target[13].value,
                        correct: target[14].checked,
                    }, {
                        question_id: id,
                        answer: target[16].value,
                        correct: target[17].checked,
                    }, ];

                    await Promise.all(
                        answers.map(async (answer) => {
                            try {
                                const response = await axios.post(
                                    'http://localhost:3000/answers',
                                    answer
                                );
                                console.log(response.data);
                                let modal = document.getElementById(
                                    'modal-add-test-scholarship');
                                modal.classList.add('hidden');
                                getDataTable();
                            } catch (error) {
                                console.log(error.message);
                            }
                        })
                    );
                })
                .catch((error) => {
                    console.log(error.message);
                });
        } else {
            alert('Harap isi terlebih dahulu kategori.')
        }
    }
</script>
