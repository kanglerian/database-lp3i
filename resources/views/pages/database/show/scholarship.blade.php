<x-app-layout>
    <x-slot name="header">
        @include('pages.database.components.navigation')
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
        @if (session('error'))
            <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-red-500 text-white rounded-lg" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div class="ml-3 text-sm font-medium">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        @if (session('message'))
            <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-lg"
                role="alert">
                <i class="fa-solid fa-circle-check"></i>
                <div class="ml-3 text-sm font-medium">
                    {{ session('message') }}
                </div>
            </div>
        @endif
    </div>

    <input type="hidden" value="{{ $user->identity }}" id="identity">

    <div class="max-w-7xl mx-auto px-5">
        <div class="w-full mx-auto">
            <div class="grid grid-cols-2 mx-auto text-center gap-3" id="score_container">
                <span id="total_true" class="p-6 bg-sky-500 text-sm text-white rounded-lg"></span>
                <span id="average_score" class="p-6 bg-emerald-500 text-sm text-white rounded-lg"></span>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto flex flex-col md:flex-row py-4 sm:px-6 lg:px-8 gap-5">
        <div class="w-full mx-auto space-y-5 px-5" id="result"></div>
    </div>

    @push('scripts')
        <script>
            const getHistories = async () => {
                try {
                    let identity = document.getElementById('identity').value;
                    const responseHistories = await axios.get(
                        `${URL_API_LP3I}/scholarship/histories?identity_user=${identity}`
                    );

                    const responseCategories = await axios.get(
                        `${URL_API_LP3I}/scholarship/categories`
                    );
                    let histories = responseHistories.data;
                    let categories = responseCategories.data;
                    if (histories.length > 0) {
                        const recordPromises = histories.map((history) => getRecords(history));
                        const results = await Promise.all(recordPromises);
                        let bucket = '';
                        let count = categories.length;
                        let totalTrue = results.filter((result) => result.trueResult).reduce((acc, result) => acc +
                            result.trueResult, 0);
                        let totalScore = results
                            .map((result) => parseInt(result.score))
                            .reduce((acc, score) => acc + score, 0);
                        let averageScore = parseInt(count > 0 ? totalScore / count : 0);
                        results.forEach(result => {
                            let score = parseInt(result.score);
                            let scoreResult = score.toFixed();
                            bucket += `
                        <div class="p-6 bg-white shadow rounded-xl">
                            <h2 class="text-lg font-bold">${result.category}</h2>
                            <ul class="text-sm space-y-1 mt-2">
                                <li>
                                    <i class="fa-solid fa-scroll text-gray-400"></i>
                                    Jumlah Soal: ${result.questions}
                                </li>
                                <li>
                                    <i class="fa-solid fa-inbox text-gray-400"></i>
                                    Jumlah Terjawab: ${result.recordLength}</li>
                                <li>
                                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                    Benar: ${result.trueResult}
                                </li>
                                <li>
                                    <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                    Salah: ${result.falseResult}
                                </li>
                                <li>
                                    <i class="fa-solid fa-star text-amber-400"></i>
                                    Nilai: ${scoreResult}
                                </li>
                            </ul>
                        </div>
                    `
                        });
                        document.getElementById('result').innerHTML = `
                        <div class="grid grid-cols-1 md:grid-cols-3 mx-auto gap-3">
                            ${bucket}
                        </div>
                    `;
                        document.getElementById('total_true').innerText = `Total Benar: ${totalTrue}`;
                        document.getElementById('average_score').innerText = `Nilai Akhir: ${averageScore}`;
                    } else {
                        document.getElementById('score_container').style.display = 'none';
                        document.getElementById('result').innerHTML =
                            `<p class="text-sm text-center text-gray-600">Tidak ada yang dikerjakan.</p>`;
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
                        `${URL_API_LP3I}/scholarship/records?identity_user=${history.identity_user}&category=${history.category_id}`
                    );
                    const responseQuestions = await axios.get(
                        `${URL_API_LP3I}/scholarship/questions?category=${history.category_id}`
                    );

                    let category = history.category.name;
                    let records = responseRecords.data;
                    let recordLength = records.length;
                    let trueResult = records.filter((record) => record.answer.correct == true).length;
                    let falseResult = records.filter((record) => record.answer.correct == false).length;

                    let questions = responseQuestions.data.length;

                    let nilai = (trueResult / questions) * 100;
                    let score = nilai.toFixed();

                    return {
                        recordLength,
                        trueResult,
                        falseResult,
                        questions,
                        score,
                        category,
                    }

                } catch (error) {
                    document.getElementById('result').innerHTML = `${error.message}`;
                }
            }
        </script>
    @endpush
</x-app-layout>
