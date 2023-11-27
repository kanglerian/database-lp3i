<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('question.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">
                            <i class="fa-solid fa-file-lines mr-2"></i>
                            E-Assessment
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">SBPMB Online</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="flex flex-wrap justify-center items-center gap-3 px-2 text-gray-600">
                <div role="status" id="data-loading">
                    <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin fill-blue-600"
                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="currentColor" />
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="currentFill" />
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="flex bg-gray-200 px-4 py-2 text-sm rounded-lg items-center gap-2">
                    <i class="fa-solid fa-users"></i>
                    <h2 id="count_persons"></h2>
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
                    <a href="{{ route('scholarship.question') }}"
                        class="bg-lp3i-100 hover:bg-lp3i-200 px-4 py-2 text-sm rounded-lg text-white">
                        <i class="fa-solid fa-scroll mr-1"></i> Bank Soal
                    </a>
                    <button onclick="exportExcel()"
                        class="bg-emerald-500 hover:bg-emerald-600 px-4 py-2 text-sm rounded-lg text-white">
                        <i class="fa-solid fa-file-excel mr-1"></i> Ekspor Excel
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
                                        Nama Lengkap
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Presenter
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Asal Sekolah
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Total Benar
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nilai Akhir
                                    </th>
                                    <th scope="col" class="px-6 py-3 rounded-t-lg">
                                        Hasil Tes
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
<script>
    const getHistories = async () => {
        try {
            const responseHistories = await axios.get(
                `https://api.politekniklp3i-tasikmalaya.ac.id/scholarship/histories`
            );
            const responseCategories = await axios.get(
                `https://api.politekniklp3i-tasikmalaya.ac.id/scholarship/categories`
            );
            document.getElementById('data-loading').style.display = 'block';
            let histories = responseHistories.data;
            let categories = responseCategories.data;
            if(histories && categories){
                document.getElementById('data-loading').style.display = 'none';
            }

            const recordPromises = histories.map((history) => getRecords(history));
            const results = await Promise.all(recordPromises);

            const applicants = Object.values(results.reduce((acc, item) => {
                const key = item.identity;
                if (!acc[key]) {
                    acc[key] = [];
                }
                acc[key].push(item);
                return acc;
            }, {}));

            let applicantBucket = [];

            const promiseResults = applicants.map(async (details) => {

                let detailBucket = details.map(detail => ({
                    category: detail.category,
                    score: detail.score,
                    trueResult: detail.trueResult,
                    falseResult: detail.falseResult,
                    questions: detail.questions,
                    recordLength: detail.recordLength,
                }));

                try {
                    const response = await axios.get(`/api/database/${details[0].identity}`);
                    applicantBucket.push({
                        identity: response.data.user,
                        detail: detailBucket,
                    });
                } catch (error) {
                    console.log(error);
                }
            });

            await Promise.all(promiseResults);
            var dataTableInitialized = false;
            var dataTableInstance;
            const data = applicantBucket;
            document.getElementById('count_persons').innerText = data.length;

            const manualColumns = [{
                data: 'identity',
                render: (data, type, row, meta) => {
                    return meta.row + 1;
                }
            }, {
                data: 'identity',
                render: (data, type, row, meta) => {
                    return data.name;
                }
            }, {
                data: 'identity',
                render: (data, type, row, meta) => {
                    // return data.presenter.name;
                    return data;
                }
            }, {
                data: 'identity',
                render: (data, type, row, meta) => {
                    return data;
                    // return data.school_applicant.name;
                }
            },{
                data: 'detail',
                render: (data, type, row, meta) => {
                    let totalTrue = data.filter((result) => result.trueResult).reduce((acc, result) => acc +
                        result.trueResult, 0);
                    return totalTrue;
                }
            },{
                data: 'detail',
                render: (data, type, row, meta) => {
                    let count = categories.length;
                    let totalScore = data
                        .map((result) => parseInt(result.score))
                        .reduce((acc, score) => acc + score, 0);
                    let averageScore = count > 0 ? totalScore / count : 0;
                    return averageScore.toFixed();
                }
            }, {
                data: 'detail',
                render: (data, type, row, meta) => {
                    let elementBucket = '';
                    data.forEach(element => {
                        elementBucket +=
                            `<li><i class="fa-regular fa-circle-dot"></i> ${element.category}: (${element.score})</li>`
                    });
                    return `<ul class="space-y-2">${elementBucket}</ul>`;
                }
            }];

            const dataTableConfig = {
                columns: manualColumns,
                data: data,
            }

            if (dataTableInitialized) {
                dataTableInstance.clear().destroy();
            }

            dataTableInstance = new DataTable('#myTable', dataTableConfig);

            dataTableInitialized = true;

        } catch (error) {
            console.log(error.message);
        }
    }
    getHistories();
</script>

<script>
    const getRecords = async (history) => {
        try {
            const responseRecords = await axios.get(
                `https://api.politekniklp3i-tasikmalaya.ac.id/scholarship/records?identity_user=${history.identity_user}&category=${history.category_id}`
            );
            const responseQuestions = await axios.get(
                `https://api.politekniklp3i-tasikmalaya.ac.id/scholarship/questions?category=${history.category_id}`
            );

            let identity = history.identity_user;
            let category = history.category.name;
            let records = responseRecords.data;
            let recordLength = records.length;
            let trueResult = records.filter((record) => record.answer.correct == true).length;
            let falseResult = records.filter((record) => record.answer.correct == false).length;

            let questions = responseQuestions.data.length;

            let nilai = (trueResult / questions) * 100;
            let score = nilai.toFixed();

            return {
                identity,
                recordLength,
                trueResult,
                falseResult,
                questions,
                score,
                category,
                records,
            }

        } catch (error) {
            document.getElementById('result').innerHTML = `${error.message}`;
        }
    }
</script>
<script>
    const exportExcel = () => {
        alert('export');
    }
</script>
