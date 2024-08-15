<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 pb-3">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('question.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">
                            <i class="fa-solid fa-file-lines mr-2"></i>
                            E-Assessment
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-300 mr-2"></i>
                            <a href="{{ route('scholarship.index') }}"
                                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">SBPMB Online</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Bank Soal</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="flex flex-wrap justify-center items-center gap-3 px-2 text-gray-600">
                <div class="flex bg-gray-200 px-4 py-2 text-sm rounded-xl items-center gap-2">
                    <i class="fa-solid fa-scroll"></i>
                    <h2 id="count_questions"></h2>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-5 md:p-0 space-y-5">
            @if (session('message'))
                <div id="alert" class="flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-lg"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-reguler">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div id="alert" class="flex items-center p-4 mb-4 bg-red-500 text-red-50 rounded-xl"
                    role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('error') }}
                    </div>
                </div>
            @endif
            <div class="flex flex-wrap justify-between items-center gap-4 md:gap-0 px-2">
                <div class="flex items-center gap-3">
                    <button onclick="modalAddTestScholarship()"
                        class="bg-lp3i-100 hover:bg-lp3i-200 px-4 py-2 text-sm rounded-xl text-white"><i
                            class="fa-solid fa-circle-plus mr-1"></i> Tambah Soal</button>
                    <button onclick="modalAddCategoryScholarship()"
                        class="bg-emerald-500 hover:bg-emerald-600 px-4 py-2 text-sm rounded-xl text-white">
                        <i class="fa-solid fa-tags mr-1"></i> Tambah Kategori
                    </button>
                </div>
            </div>
            <div class="bg-white overflow-hidden border rounded-3xl">
                <div class="p-8 bg-white border-b border-gray-200">
                    <div class="relative overflow-x-auto rounded-3xl">
                        <table id="myTable" class="w-full text-sm text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 rounded-t-lg">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        ID Soal
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nama Kategori
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Soal
                                    </th>
                                    <th scope="col" class="px-6 py-3 rounded-t-lg">
                                        Action
                                    </th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="{{ asset('js/axios.min.js') }}"></script>

@include('pages.question.scholarship.modal.add')
@include('pages.question.scholarship.modal.category')

<script>
    const showAnswers = async (question) => {
        await axios.get(`http://localhost:3000/answers/question/${question}`)
            .then((response) => {
                let message = '';
                const answers = response.data;
                answers.forEach((answer, index) => {
                    message +=
                        `${index + 1}. ${answer.answer} (${answer.correct ? 'benar' : 'salah'} - ${answer.id})\n`
                });
                alert(message);
            })
            .catch((error) => {
                console.log(error.message);
            });
    }

    const modalAddTestScholarship = () => {
        getCategories();
        let modal = document.getElementById('modal-add-test-scholarship');
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }

    const modalAddCategoryScholarship = () => {
        let modal = document.getElementById('modal-add-category-scholarship');
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }
</script>

<script>
    var urlData = `http://localhost:3000/questions`;
    var dataTableInitialized = false;
    var dataTableInstance;

    const getDataTable = async () => {
        try {
            const response = await axios.get(urlData);
            const data = response.data;
            document.getElementById('count_questions').innerText = data.length;
            const manualColumns = [{
                data: 'id',
                render: (data, type, row, meta) => {
                    return meta.row + 1;
                }
            }, {
                data: 'id',
                render: (data, type, row, meta) => {
                    return data;
                }
            }, {
                data: 'category.name',
                render: (data, type, row, meta) => {
                    return data;
                }
            }, {
                data: 'question',
                render: (data, type, row, meta) => {
                    return data.length > 30 ? data.substring(0, 30) + '...' : data;
                }
            }, {
                data: 'id',
                render: (data, type, row) => {
                    return `
                        <div class="flex items-center gap-1">
                            <button class="bg-sky-500 hover:bg-sky-600 px-3 py-1 rounded-lg text-xs text-white" onclick="event.preventDefault(); showAnswers(${data});">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <button class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded-lg text-xs text-white" onclick="event.preventDefault(); deleteRecord(${data})">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>`
                }
            }];

            const dataTableConfig = {
                columns: manualColumns,
                data: data,
            }


            if (dataTableInitialized) {
                dataTableInstance.destroy();
            }

            dataTableInstance = new DataTable('#myTable', dataTableConfig);

            dataTableInitialized = true;
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    };

    getDataTable();

    const deleteRecord = async (id) => {
        const confirmation = confirm('Apakah anda yakin untuk menghapus pertanyaan ini?');
        if (confirmation) {
            await axios.delete(`http://localhost:3000/questions/${id}`)
                .then((response) => {
                    getDataTable();
                })
                .catch((error) => {
                    alert(error.message);
                });
        }
    }
</script>
