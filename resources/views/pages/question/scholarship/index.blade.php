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
            let histories = responseHistories.data;
            if (histories.length > 0) {
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
                        score: detail.score
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

                Promise.all(promiseResults).then(() => {
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
                            return data.presenter.name;
                        }
                    }, {
                        data: 'identity',
                        render: (data, type, row, meta) => {
                            return data.school_applicant.name;
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

                    dataTableInstance = new DataTable('#myTable', dataTableConfig);
                });

            } else {
                console.log('tidak ada');
            }

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
