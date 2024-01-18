@if (Auth::user()->role !== 'S')
    <div class="max-w-7xl px-5 mx-auto">
        <section class="bg-white p-5 md:rounded-xl border border-gray-100">
            <header class="space-y-1">
                <h2 class="font-bold text-gray-800">Riwayat Target Pengiriman Pesan</h2>
                <p class="text-sm text-gray-700 text-sm">
                    Berikut ini adalah hasil perhitungan dari riwayat pesan.
                </p>
            </header>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-3 my-5">
                <div class="bg-lp3i-200 text-sm py-4 px-5 rounded-xl text-white">
                    <i class="fa-solid fa-phone"></i>
                    <i class="fa-solid fa-database mr-2"></i>
                    <span>Total: </span>
                    <span id="phonehistory_total" class="font-bold">0</span>
                </div>
                <div class="bg-emerald-500 text-sm py-4 px-5 rounded-xl text-white">
                    <i class="fa-solid fa-phone"></i>
                    <i class="fa-solid fa-circle-check mr-2"></i>
                    <span>Valid: </span>
                    <span id="phonehistory_valid" class="font-bold">0</span>
                </div>
                <div class="bg-red-500 text-sm py-4 px-5 rounded-xl text-white">
                    <i class="fa-solid fa-phone"></i>
                    <i class="fa-solid fa-circle-xmark mr-2"></i>
                    <span>Tidak Valid: </span>
                    <span id="phonehistory_nonvalid" class="font-bold">0</span>
                </div>
            </div>
            <div class="relative overflow-x-auto border border-gray-200 rounded-xl">
                {{-- @if (Auth::user()->role == 'P')
                    <button onclick="updateHistories()"
                        class="text-sm bg-red-500 hover:bg-red-600 rounded-lg px-4 py-2 text-white">Jangan ditekan,
                        bahaya!</button>
                @endif --}}
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase">
                        <tr>
                            <th scope="col" class="px-6 py-4 bg-gray-50">
                                Nama Presenter
                            </th>
                            <th scope="col" class="px-6 py-4 text-center bg-white">
                                Kategori 1
                            </th>
                            <th scope="col" class="px-6 py-4 text-center bg-gray-50">
                                Kategori 2
                            </th>
                            <th scope="col" class="px-6 py-4 text-center bg-white">
                                Kategori 3
                            </th>
                            <th scope="col" class="px-6 py-4 text-center bg-gray-50">
                                Kategori 4
                            </th>
                            <th scope="col" class="px-6 py-4 text-center bg-white">
                                Kategori 5
                            </th>
                            <th scope="col" class="px-6 py-4 text-center bg-gray-50">
                                Kategori 6
                            </th>
                            <th scope="col" class="px-6 py-4 text-center bg-white">
                                Kategori 7
                            </th>
                            <th scope="col" class="px-6 py-4 text-center bg-gray-50">
                                Kategori 8
                            </th>
                            <th scope="col" class="px-6 py-4 text-center bg-white">
                                Kategori 9
                            </th>
                            <th scope="col" class="px-6 py-4 text-center bg-gray-50">
                                Kategori 10
                            </th>
                            <th scope="col" class="px-6 py-4 text-center bg-white">
                                Kategori 11
                            </th>
                            <th scope="col" class="px-6 py-4 text-center bg-gray-50">
                                Kategori 12
                            </th>
                            <th scope="col" class="px-6 py-4 text-center bg-gray-50">
                                Lebih dari kategori 12
                            </th>
                        </tr>
                    </thead>
                    <tbody id="history_chat_presenter">
                        <tr>
                            <td colspan="14" class="bg-white text-center text-sm px-6 py-4">Tidak ada data.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endif
@push('scripts')
    <script>
        const changeTrigger = () => {
            getHistories();
            changeFilterDatabase();
        }
    </script>
    <script>
        const changeFilterDatabasePresenter = () => {
            let queryParams = [];
            let pmbVal = document.getElementById('change_pmb').value;
            if (pmbVal !== 'all') {
                queryParams.push(`pmbVal=${pmbVal}`);
            }
            let queryString = queryParams.join('&');

            urlDatabasePresenter = `/api/report/database/presenter/source?${queryString}`;
        }

        const changeFilterDatabasePresenterWilayah = () => {
            let queryParams = [];
            let pmbVal = document.getElementById('change_pmb').value;
            if (pmbVal !== 'all') {
                queryParams.push(`pmbVal=${pmbVal}`);
            }
            let queryString = queryParams.join('&');

            urlDatabasePresenterWilayah = `/api/report/database/presenter/wilayah?${queryString}`;
        }

        const getHistories = async () => {
            try {
                showLoadingAnimation();
                const responsePresenters = await axios.get(`/get/presenter`);
                const responseDatabase = await axios.get(apiDashboard);
                const presenters = responsePresenters.data.presenters;
                const pmbVal = document.getElementById('change_pmb').value;

                document.getElementById('phonehistory_total').innerText = responseDatabase.data.database_count
                    .toLocaleString('id-ID');
                document.getElementById('phonehistory_valid').innerText = responseDatabase.data.database_phone
                    .length.toLocaleString('id-ID');
                document.getElementById('phonehistory_nonvalid').innerText = (responseDatabase.data.database_count -
                    responseDatabase.data.database_phone.length).toLocaleString('id-ID');

                let buckets = [];
                for (let i = 0; i < presenters.length; i++) {
                    const responseHistories = await axios.get(
                        `https://api.politekniklp3i-tasikmalaya.ac.id/history/detail/${pmbVal}/${presenters[i].identity}`
                    );
                    const databasesPhone = responseDatabase.data.database_phone;
                    const databasesCount = responseDatabase.data.database_count;
                    const databasePhone = databasesPhone.filter((data) => data.identity_user == presenters[i]
                        .identity);
                    const histories = responseHistories.data;
                    let categoriesBucket = [];
                    for (let i = 1; i < 14; i++) {
                        let categoryCount;
                        if (i > 12) {
                            categoryCount = histories.filter((history) => history.category > i);
                        } else {
                            categoryCount = histories.filter((history) => history.category == i);
                        }
                        let percent = (categoryCount.length / databasePhone.length) * 100;
                        categoriesBucket.push({
                            category: categoryCount,
                            percent: percent,
                            databases_count: databasesCount,
                            database_phone: databasePhone.length,
                        });
                    }
                    let data = {
                        name: presenters[i].name,
                        categories: categoriesBucket
                    }
                    buckets.push(data);
                }

                let content = '';
                buckets.forEach((bucket) => {
                    let contentBucket = '';
                    let categoriesBucket = '';
                    let categories = bucket.categories;
                    if (categories.length > 0) {
                        categories.forEach((category, i) => {
                            categoriesBucket += `
                    <td class="px-6 py-4 text-center ${i % 2 == 0 ? 'bg-white' : 'bg-gray-50'}">
                        <ul class="space-y-1">
                            <li class="font-bold">${category.percent.toFixed()}%</li>
                            <li class="text-xs">${category.category.length}/${category.database_phone}</li>
                            <li class="text-xs">Total: ${category.database_phone} (${category.category.length - category.database_phone})</li>
                            ${category.database_phone > category.category.length - category.database_phone ?
                            `<li onclick="informationText()" class="text-xs cursor-pointer hover:text-sky-600 transition"><i class="fa-solid fa-circle-info"></i>  Informasi</li>` : ''}
                        </ul>
                    </td>`
                        });
                        content += `
                    <tr>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50">
                            ${bucket.name}
                        </td>
                        ${categoriesBucket}
                    </tr>
                `
                    } else {
                        content += `
                    <tr>
                        <td colspan="14" class="text-center bg-white text-sm px-6 py-4">Tidak ada data.</td>
                    </tr>
                `
                    }
                });
                document.getElementById('history_chat_presenter').innerHTML = content;
                hideLoadingAnimation();
            } catch (error) {
                let content = `
                    <tr>
                        <td colspan="13" class="text-center bg-white text-sm px-6 py-4">${error.message}</td>
                    </tr>
                `
                document.getElementById('history_chat_presenter').innerHTML = content;
            }
        }

        const informationText = () => {
            let message = `Persentase data > 100% mungkin disebabkan oleh:
        1. Pengiriman pesan ke nomor tidak terdaftar.
        2. Penghapusan nomor setelah pengiriman pesan.`;
            alert(message);
        }

        getHistories();
    </script>
    <script>
        const updateHistories = async () => {
            try {
                showLoadingAnimation();
                const responseDatabase = await axios.get(apiDashboard);
                const database = responseDatabase.data.database_phone;
                for (let i = 0; i < database.length; i++) {
                    let data = {
                        identity: identity,
                        pmb: 2024
                    }
                    await axios.patch(
                            `https://api.politekniklp3i-tasikmalaya.ac.id/history/update/${database[i].phone}`, data
                        )
                        .then((response) => {
                            console.log(response.data.message);
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }
                hideLoadingAnimation();
            } catch (error) {
                console.log(error);
            }
        }
    </script>
@endpush
