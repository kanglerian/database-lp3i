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
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">SBPMB Online</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="flex flex-wrap justify-center items-center gap-3 px-2 text-gray-600">
                <a href="{{ route('scholarship.question') }}"
                    class="bg-lp3i-100 hover:bg-lp3i-200 px-4 py-2 text-sm rounded-xl text-white">
                    <i class="fa-solid fa-scroll mr-1"></i> Bank Soal
                </a>
                <div class="flex bg-gray-200 px-4 py-2 text-sm rounded-xl items-center gap-2">
                    <i class="fa-solid fa-users"></i>
                    <h2 id="count_persons">0</h2>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <input type="hidden" id="identity_val" value="{{ Auth::user()->identity }}">
        <input type="hidden" id="role_val" value="{{ Auth::user()->role }}">
        <div class="max-w-7xl mx-auto px-5 md:p-0 space-y-5">
            @if (session('message'))
                <div id="alert" class="flex items-center p-4 mb-4 bg-emerald-500 text-emerald-50 rounded-2xl"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-reguler">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div id="alert" class="flex items-center p-4 mb-4 bg-red-500 text-red-50 rounded-2xl"
                    role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div class="ml-3 text-sm font-reguler">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <div class="flex justify-start items-center gap-3 mx-2 py-2">
                <div class="flex justify-center md:justify-start items-end flex-wrap md:flex-nowrap text-gray-500 md:gap-3">
                    <div class="flex flex-col space-y-1 p-1 md:p-0">
                        <label for="change_pmb" class="text-xs">Periode PMB:</label>
                        <input type="number" id="change_pmb"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800"
                            placeholder="Tahun PMB">
                    </div>
                    <div class="flex flex-col space-y-1 p-1 md:p-0">
                        <label for="date_start" class="text-xs">Tanggal Dari:</label>
                        <input type="date" id="date_start"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800">
                    </div>
                    <div class="flex flex-col space-y-1 p-1 md:p-0">
                        <label for="date_end" class="text-xs">Tanggal Sampai:</label>
                        <input type="date" id="date_end"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800">
                    </div>
                    <div class="flex p-1 gap-2 md:p-0">
                        <button type="button" onclick="changeFilter()"
                            class="bg-sky-500 hover:bg-sky-600 px-4 py-2 text-xs rounded-xl text-white">
                            <i class="fa-solid fa-filter"></i>
                        </button>
                        <button type="button" onclick="exportExcel()"
                            class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm space-x-1">
                            <i class="fa-solid fa-file-excel"></i>
                        </button>
                    </div>
                </div>
            </div>

            @if (Auth::user()->role == 'A')
                <div class="flex flex-wrap justify-between items-center gap-4 md:gap-0 px-2">
                    <div class="flex items-center gap-3">
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden border rounded-3xl">
                <div class="p-8 bg-gray-50 border-b border-gray-200">
                    <div class="relative overflow-x-auto">
                        <table id="scholarship-table" class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 rounded-tl-lg">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Tanggal
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
                                    <th scope="col" class="px-6 py-3 rounded-tr-lg">
                                        Nilai Akhir
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
    @include('pages.question.scholarship.exports.excel')
    @include('pages.dashboard.utilities.all')
    @include('pages.dashboard.utilities.pmb')
    @push('scripts')
        <script>
            let dataTableInstance;
            let dataTableInitialized = false;
            let url = `/api/applicants/scholarships?pmbVal=${pmbVal}`;
            let dataScholarship;
        </script>
        <script>
            const changeFilter = () => {
                let queryParams = [];

                let pmbVal = document.getElementById('change_pmb').value;
                let dateStart = document.getElementById('date_start').value || 'all';
                let dateEnd = document.getElementById('date_end').value || 'all';

                if (pmbVal !== 'all') {
                    queryParams.push(`pmbVal=${pmbVal}`);
                }
                if (dateStart !== 'all') {
                    queryParams.push(`dateStart=${dateStart}`);
                }
                if (dateEnd !== 'all') {
                    queryParams.push(`dateEnd=${dateEnd}`);
                }

                let queryString = queryParams.join('&');

                url = `/api/applicants/scholarships?${queryString}`;

                if (dataTableInstance) {
                    showLoadingAnimation();
                    dataTableInstance.clear();
                    dataTableInstance.destroy();
                    getDataTable()
                        .then((response) => {
                            dataTableInstance = $('#scholarship-table').DataTable(response.config);
                            dataTableInitialized = response.initialized;
                            hideLoadingAnimation();
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }
            }

            const getDataTable = async () => {
                return new Promise(async (resolve, reject) => {
                    try {
                        const [responseHistories, responseCategories] = await Promise.all([
                            axios.get(`http://localhost:3000/histories`),
                            axios.get(`http://localhost:3000/categories`)
                        ]);

                        const responseApplicants = await axios.get(url);

                        histories = responseHistories.data;
                        categories = responseCategories.data;
                        applicants = responseApplicants.data;

                        const recordPromises = histories.map((history) => getRecords(history));

                        const promises = await Promise.all(recordPromises);

                        let tampung = [];
                        applicants.forEach((applicant) => {
                            let totalBenar = 0;
                            let totalSalah = 0;
                            let totalScore = 0;
                            let scores = promises.filter((promise) => promise.identity == applicant
                                .identity);
                            scores.forEach(score => {
                                totalBenar += score.trueResult;
                                totalSalah += score.falseResult;
                                totalScore += parseInt(score.score);
                            });
                            let data = {
                                identity: applicant.identity,
                                pmb: applicant.pmb,
                                date: applicant.scholarship_date,
                                name: applicant.name,
                                school: applicant.school ? applicant.school_applicant.name :
                                    'Tidak diketahui',
                                presenter: applicant.presenter.name,
                                trueScore: totalBenar,
                                total: (totalScore / categories.length).toFixed()
                            }
                            tampung.push(data);
                        });
                        console.log(tampung);
                        dataScholarship = tampung;

                        document.getElementById('count_persons').innerText = tampung.length;

                        let columnConfigs = [{
                                data: 'pmb',
                                render: (data, type, row, meta) => {
                                    return meta.row + 1;
                                },
                            },
                            {
                                data: 'date',
                                render: (data, type, row, meta) => {
                                    return data || 'Tidak diketahui';
                                }
                            },
                            {
                                data: 'name',
                                render: (data, type, row, meta) => {
                                    return data;
                                }
                            },
                            {
                                data: 'presenter',
                                render: (data, type, row, meta) => {
                                    return data
                                }
                            },
                            {
                                data: 'school',
                                render: (data, type, row, meta) => {
                                    return data;
                                }
                            },
                            {
                                data: 'trueScore',
                                render: (data, type, row, meta) => {
                                    return data;
                                }
                            },
                            {
                                data: 'total',
                                render: (data, type, row, meta) => {
                                    return data;
                                }
                            },
                        ];

                        const dataTableConfig = {
                            data: tampung,
                            columnDefs: [{
                                width: 50,
                                target: 0
                            }],
                            createdRow: (row, data, index) => {
                                if (index % 2 === 0) {
                                    $(row).css('background-color', '#f9fafb');
                                }
                            },
                            columns: columnConfigs,
                        }

                        let results = {
                            config: dataTableConfig,
                            initialized: true
                        }

                        resolve(results);
                    } catch (error) {
                        
                        reject(error)
                    }
                });
            }
        </script>
        <script>
            const promiseDataScholarship = () => {
                showLoadingAnimation();
                Promise.all([
                        getDataTable(),
                    ])
                    .then((response) => {
                        let responseDTRS = response[0];
                        dataTableInstance = $('#scholarship-table').DataTable(
                            responseDTRS
                            .config);
                        dataTableInitialized = responseDTRS.initialized;
                        hideLoadingAnimation();
                    })
                    .catch((error) => {
                        console.log(error);
                        hideLoadingAnimation();
                    });
            }
            promiseDataScholarship();
        </script>
        <script>
            const getRecords = async (history) => {
                try {
                    const [responseRecords, responseQuestions] = await Promise.all([
                        axios.get(
                            `http://localhost:3000/records?identity_user=${history.identity_user}&category=${history.category_id}`
                        ),
                        axios.get(`http://localhost:3000/questions?category=${history.category_id}`)
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
    @endpush
</x-app-layout>
