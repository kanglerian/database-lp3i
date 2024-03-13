<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0 h-10">
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
                <div class="flex bg-gray-200 px-4 py-2 text-sm rounded-xl items-center gap-2">
                    <i class="fa-solid fa-users"></i>
                    <h2 id="count_persons">0</h2>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">
            @if (session('message'))
                <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-2xl"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-reguler">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-red-500 text-white rounded-2xl"
                    role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div class="ml-3 text-sm font-reguler">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if (Auth::user()->role == 'A')
                <div class="flex flex-wrap justify-between items-center gap-4 md:gap-0 px-2">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('scholarship.question') }}"
                            class="bg-lp3i-100 hover:bg-lp3i-200 px-4 py-2 text-sm rounded-xl text-white">
                            <i class="fa-solid fa-scroll mr-1"></i> Bank Soal
                        </a>
                        <button onclick="exportExcel()"
                            class="bg-emerald-500 hover:bg-emerald-600 px-4 py-2 text-sm rounded-xl text-white">
                            <i class="fa-solid fa-file-excel mr-1"></i> Ekspor Excel
                        </button>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden border rounded-3xl">
                <div class="p-8 bg-gray-50 border-b border-gray-200">
                    <div class="relative overflow-x-auto">
                        <table id="myTable" class="w-full text-sm text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 rounded-tl-lg">
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
                                    <th scope="col" class="px-6 py-3 rounded-tr-lg">
                                        Hasil Tes
                                    </th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="7" class="text-center px-6 py-4 text-gray-600 whitespace-nowrap">
                                        Data belum ditemukan.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

@include('pages.question.scholarship.exports.excel')
<script src="{{ asset('js/axios.min.js') }}"></script>
<script>
    var data;
    var categories;
    var histories;
    const getHistories = async () => {
        try {
            showLoadingAnimation();
            const [responseHistories, responseCategories] = await Promise.all([
                axios.get(`${URL_API_LP3I}/scholarship/histories`),
                axios.get(`${URL_API_LP3I}/scholarship/categories`)
            ]);

            histories = responseHistories.data;
            categories = responseCategories.data;

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

            await Promise.all(applicants.map(async (details) => {
                const detailBucket = details.map(detail => ({
                    identity: detail.identity,
                    category: detail.category,
                    score: detail.score,
                    trueResult: detail.trueResult,
                    falseResult: detail.falseResult,
                    questions: detail.questions,
                    recordLength: detail.recordLength,
                }));

                const identityVal = details[0].identity;

                try {
                    const response = await axios.get(
                        `/api/database/${identityVal}`);
                    applicantBucket.push({
                        identity: response.data.user,
                        detail: detailBucket,
                    });
                } catch (error) {
                    console.log(error);
                }
            }));

            var dataTableInitialized = false;
            var dataTableInstance;
            data = applicantBucket;
            document.getElementById('count_persons').innerText = data.length;

            const manualColumns = [{
                data: 'identity',
                render: (data, type, row, meta) => {
                    return meta.row + 1;
                }
            }, {
                data: 'identity',
                render: (data, type, row, meta) => {
                    return data ? data.name : 'Tidak diketahui';
                }
            }, {
                data: 'identity',
                render: (data, type, row, meta) => {
                    return data ? data.presenter.name : 'Tidak diketahui';
                }
            }, {
                data: 'identity',
                render: (data, type, row, meta) => {
                    return data ? data.school_applicant.name : 'Tidak diketahui';
                }
            }, {
                data: 'detail',
                render: (data, type, row, meta) => {
                    let totalTrue = data.filter((result) => result.trueResult).reduce((acc,
                            result) => acc +
                        result.trueResult, 0);
                    return totalTrue;
                }
            }, {
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

            hideLoadingAnimation();
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
            const [responseRecords, responseQuestions] = await Promise.all([
                axios.get(
                    `${URL_API_LP3I}/scholarship/records?identity_user=${history.identity_user}&category=${history.category_id}`
                ),
                axios.get(`${URL_API_LP3I}/scholarship/questions?category=${history.category_id}`)
            ]);

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
