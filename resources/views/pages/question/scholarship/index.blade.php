<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Soal Beasiswa') }}
            </h2>
            <div class="flex flex-wrap justify-center items-center gap-3 px-2 text-gray-600">
                <div class="flex bg-gray-200 px-4 py-2 text-sm rounded-lg items-center gap-2">
                    <i class="fa-solid fa-scroll"></i>
                    <h2 id="count_questions"></h2>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">
            @if (session('message'))
                <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-lg"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-red-500 text-white rounded-lg"
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
                        class="bg-lp3i-100 hover:bg-lp3i-200 px-4 py-2 text-sm rounded-lg text-white"><i
                            class="fa-solid fa-circle-plus"></i> Tambah Soal</button>
                    <button onclick="modalAddCategoryScholarship()"
                        class="bg-emerald-500 hover:bg-emerald-600 px-4 py-2 text-sm rounded-lg text-white">
                        <i class="fa-solid fa-tags"></i> Tambah Kategori
                    </button>
                </div>
            </div>
            <div class="bg-white overflow-hidden border md:rounded-xl">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="relative overflow-x-auto md:rounded-xl">
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
        await axios.get(`https://api.politekniklp3i-tasikmalaya.ac.id/scholarship/answers/question/${question}`)
        .then((response) => {
            let message = '';
            const answers = response.data;
            answers.forEach((answer, index) => {
                message += `${index + 1}. ${answer.answer} (${answer.correct ? 'benar' : 'salah'} - ${answer.id})\n`
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
    var urlData = 'https://api.politekniklp3i-tasikmalaya.ac.id/scholarship/questions';
    var dataTableInitialized = false;
    var dataTableInstance;

    const getDataTable = async () => {
        try {
            const response = await axios.get(urlData);
            const data = response.data;
            document.getElementById('count_questions').innerText = data.length;
            const manualColumns = [
                {
                data: 'id',
                render: (data, type, row, meta) => {
                    return meta.row + 1;
                }
            },{
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
                            <button class="bg-sky-500 hover:bg-sky-600 px-3 py-1 rounded-md text-xs text-white" onclick="event.preventDefault(); showAnswers(${data});">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <button class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded-md text-xs text-white" onclick="event.preventDefault(); deleteRecord(${data})">
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
            await axios.delete(`https://api.politekniklp3i-tasikmalaya.ac.id/scholarship/questions/${id}`)
                .then((response) => {
                    console.log(response.data);
                    getDataTable();
                })
                .catch((error) => {
                    console.log(error.message);
                });
        }
    }
</script>
