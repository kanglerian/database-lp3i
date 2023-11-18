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

    <div class="max-w-7xl mx-auto flex flex-col md:flex-row py-4 sm:px-6 lg:px-8 gap-5">
        <div class="w-full mx-auto space-y-5 px-5" id="result">
        </div>
    </div>

    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script>
        const getHistories = async () => {
            try {
                let identity = document.getElementById('identity').value;
                const responseHistories = await axios.get(
                    `https://api.politekniklp3i-tasikmalaya.ac.id/scholarship/histories?identity_user=${identity}`
                );
                let histories = responseHistories.data;
                if (histories.length > 0) {
                    const recordPromises = histories.map((history) => getRecords(history));
                    const results = await Promise.all(recordPromises);
                    let bucket = '';
                    results.forEach(result => {
                        bucket += `
                    <div class="p-6 bg-white shadow rounded-xl">
                        <div>
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
                                    Nilai: ${result.score}
                                </li>
                            </ul>
                        </div>
                    </div>
                    `
                    });
                    document.getElementById('result').innerHTML = `
                        <div class="grid grid-cols-2 md:grid-cols-3 mx-auto md:gap-3">
                            ${bucket}
                        </div>
                    `;
                } else {
                    document.getElementById('result').innerHTML = `<p class="text-sm text-center text-gray-600">Tidak ada yang dikerjakan.</p>`;
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

</x-app-layout>
