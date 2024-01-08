<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                @if (Auth::user()->role == 'S' && Auth::user()->status == 0)
                    Registrasi Pembayaran
                @else
                    Dashboard
                @endif
            </h2>
            <div class="flex flex-wrap justify-center items-center gap-3 px-2 text-gray-600">
                {{-- Loading animation --}}
                <div role="status" class="hidden" id="data-loading">
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
                @if (Auth::user()->status != 1)
                    <div class="px-6 py-2 rounded-lg bg-red-500 text-white text-sm">
                        <p><i class="fa-solid fa-lock mr-1"></i> Akun anda belum di aktifkan.</p>
                    </div>
                @else
                    <div class="px-6 py-2 rounded-lg text-sm bg-white">
                        <p><i class="fa-regular fa-face-smile-beam mr-1"></i> Selamat datang,
                            {{ Auth::user()->name }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>

    <section class="space-y-5 py-8">
        @if (Auth::user()->role == 'S')
            <div class="py-10">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-5 px-5 md:px-0">
                        <div class="w-full md:w-6/12 space-y-5 order-2 md:order-none">
                            <div class="space-y-1">
                                <h3 class="text-2xl font-bold text-gray-800">Silahkan untuk lakukan Transfer!</h3>
                                <p class="text-gray-700">Isi formulir pendaftaran dan raih kesempatan yang luar biasa di
                                    depan mata.</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 items-end">
                                <div class="space-y-3">
                                    <img src="{{ asset('logo/btn.png') }}" alt="Logo BTN" width="150px">
                                    <div onclick="copyRecord('0003401300001406')"
                                        class="cursor-pointer flex justify-between items-center border px-3 py-1 rounded-lg">
                                        <div class="space-y-1">
                                            <h1 class="font-bold text-sm text-gray-800">BANK BTN LP3I Tasikmalaya</h1>
                                            <p class="text-sm text-gray-700">0003401300001406</p>
                                        </div>
                                        <button onclick="copyRecord('0003401300001406')"><i
                                                class="fa-solid fa-clipboard text-gray-500 hover:text-blue-500"></i></button>
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <img src="{{ asset('logo/bsi.png') }}" alt="Logo BSI" width="150px">
                                    <div onclick="copyRecord('1025845605')"
                                        class="cursor-pointer flex justify-between items-center border px-3 py-1 rounded-lg">
                                        <div class="space-y-1">
                                            <h1 class="font-bold text-sm text-gray-800">BANK BSI (LPPPI TASIKMALAYA)
                                            </h1>
                                            <p class="text-sm text-gray-700">1025845605</p>
                                        </div>
                                        <button onclick="copyRecord('1025845605')"><i
                                                class="fa-solid fa-clipboard text-gray-500 hover:text-blue-500"></i></button>
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <img src="{{ asset('logo/bni.png') }}" alt="Logo BNI" width="150px">
                                    <div onclick="copyRecord('4549998888')"
                                        class="cursor-pointer flex justify-between items-center border px-3 py-1 rounded-lg">
                                        <div class="space-y-1">
                                            <h1 class="font-bold text-sm text-gray-800">BANK BNI (LP3I Tasikmalaya)</h1>
                                            <p class="text-sm text-gray-700">4549998888</p>
                                        </div>
                                        <button onclick="copyRecord('4549998888')"><i
                                                class="fa-solid fa-clipboard text-gray-500 hover:text-blue-500"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-5/12 order-1 md:order-none">
                            <img src="{{ asset('img/payment.svg') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @include('pages.dashboard.database.filter')
        @include('pages.dashboard.database.database')
        @include('pages.dashboard.target.target')
        @include('pages.dashboard.search.search')
        @include('pages.dashboard.database.history')
        @include('pages.dashboard.harta.database')
        @include('pages.dashboard.source.source')

    </section>

</x-app-layout>
@if (Auth::user()->role !== 'S')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.js"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
    <script>
        const showLoadingAnimation = () => {
            document.getElementById('data-loading').style.display = 'block';
        }

        const hideLoadingAnimation = () => {
            document.getElementById('data-loading').style.display = 'none';
        }
    </script>
    <script>
        const getYearPMB = () => {
            const currentDate = new Date();
            const currentYear = currentDate.getFullYear();
            const currentMonth = currentDate.getMonth();
            const startYear = currentMonth >= 9 ? currentYear + 1 : currentYear;
            document.getElementById('change_pmb').value = startYear;
        }
        getYearPMB();
    </script>
    <script>
        let identity = document.getElementById('identity').value;
        let pmb = document.getElementById('change_pmb').value;
        var apiTargets = `/get/targets?identity=${identity}&pmbVal=${pmb}`;
        var apiDashboard = `/get/dashboard/all?identity=${identity}&pmbVal=${pmb}`
    </script>

    @if (Auth::user()->role == 'A')
        <script>
            const changeTrigger = () => {
                getHistories();
                changeFilterDatabase();
            }
        </script>
    @else
        <script>
            const changeTrigger = () => {
                getHistories();
                changeFilterTarget();
                changeFilterDatabase();
            }
        </script>
    @endif
    @include('pages.dashboard.target.get')
    @include('pages.dashboard.target.change')
    @include('pages.dashboard.database.get')
    @include('pages.dashboard.database.change')
    <script>
        var dataTableInitialized = false;
        var dataTableInstance;
        const quickSearch = async () => {
            try {
                let nameSearch = document.getElementById('quick-search').value;
                if (nameSearch != '') {
                    let result = document.getElementById('result-quicksearch');
                    let identity = document.getElementById('identity').value;
                    const response = await axios.get(`quicksearch/${nameSearch}`);
                    const data = response.data.applicants;
                    document.getElementById('count-quicksearch').innerText = parseInt(data.length).toLocaleString(
                        'id-ID');

                    const manualColumns = [{
                        data: 'id',
                        render: (data, type, row, meta) => {
                            return meta.row + 1;
                        }
                    }, {
                        data: 'pmb',
                        render: (data, type, row, meta) => {
                            return data;
                        }
                    }, {
                        data: {
                            name: 'name',
                            identity: 'identity',
                            identity_user: 'identity_user'
                        },
                        render: (data, type, row, meta) => {
                            let editUrl = "{{ route('database.show', ':identity') }}".replace(
                                ':identity',
                                data.identity);
                            if (data.identity_user == identity || identity == '6281313608558') {
                                return `<a href="${editUrl}" class="font-bold underline">${data.name}</a>`
                            } else {
                                return `<span>${data.name}</span>`;
                            }
                        }
                    }, {
                        data: 'presenter',
                        render: (data) => {
                            return typeof(data) == 'object' ? data.name : 'Tidak diketahui';
                        }
                    }, {
                        data: 'source_setting',
                        render: (data, type, row) => {
                            return data.name;
                        }
                    }, {
                        data: 'school_applicant',
                        render: (data) => {
                            return data == null ? 'Tidak diketahui' : data.name;
                        }
                    }, {
                        data: 'year',
                        render: (data, row) => {
                            return data != null ? data : 'Tidak diketahui';
                        }
                    }];

                    const dataTableConfig = {
                        columns: manualColumns,
                        data: data,
                    }

                    if (dataTableInitialized) {
                        dataTableInstance.destroy();
                    }

                    dataTableInstance = new DataTable('#quickSearchTable', dataTableConfig);

                    dataTableInitialized = true;
                }
            } catch (error) {
                console.log(error);
            }
        }
    </script>
    <script>
        const quickSearchStatus = async (status) => {
            try {
                let pmbVal = document.getElementById('change_pmb').value || 'all';
                let result = document.getElementById('result-quicksearch');
                const response = await axios.get(`quicksearchstatus?statusApplicant=${status}&pmbVal=${pmbVal}`);
                const data = response.data.applicants;
                document.getElementById('count-quicksearch').innerText = parseInt(data.length).toLocaleString(
                    'id-ID');

                const manualColumns = [{
                    data: 'id',
                    render: (data, type, row, meta) => {
                        return meta.row + 1;
                    }
                }, {
                    data: 'pmb',
                    render: (data, type, row, meta) => {
                        return data;
                    }
                }, {
                    data: {
                        name: 'name',
                        identity: 'identity',
                        identity_user: 'identity_user'
                    },
                    render: (data, type, row, meta) => {
                        let editUrl = "{{ route('database.show', ':identity') }}".replace(
                            ':identity',
                            data.identity);
                        if (data.identity_user == identity || identity == '6281313608558') {
                            return `<a href="${editUrl}" class="font-bold underline">${data.name}</a>`
                        } else {
                            return `<span>${data.name}</span>`;
                        }
                    }
                }, {
                    data: 'presenter',
                    render: (data) => {
                        return typeof(data) == 'object' ? data.name : 'Tidak diketahui';
                    }
                }, {
                    data: 'source_setting',
                    render: (data, type, row) => {
                        return data.name;
                    }
                }, {
                    data: 'school_applicant',
                    render: (data) => {
                        return data == null ? 'Tidak diketahui' : data.name;
                    }
                }, {
                    data: 'year',
                    render: (data, row) => {
                        return data != null ? data : 'Tidak diketahui';
                    }
                }];

                const dataTableConfig = {
                    columns: manualColumns,
                    data: data,
                }

                if (dataTableInitialized) {
                    dataTableInstance.destroy();
                }

                dataTableInstance = new DataTable('#quickSearchTable', dataTableConfig);

                dataTableInitialized = true;
            } catch (error) {
                console.log(error);
            }
        }
    </script>
    <script>
        const quickSearchSource = async (source) => {
            try {
                let pmbVal = document.getElementById('change_pmb').value || 'all';
                let result = document.getElementById('result-quicksearch');
                const response = await axios.get(`quicksearchsource?source=${source}&pmbVal=${pmbVal}`);
                const data = response.data.applicants;

                document.getElementById('count-quicksearch').innerText = parseInt(data.length).toLocaleString(
                    'id-ID');
                const manualColumns = [{
                    data: 'id',
                    render: (data, type, row, meta) => {
                        return meta.row + 1;
                    }
                }, {
                    data: 'pmb',
                    render: (data, type, row, meta) => {
                        return data;
                    }
                }, {
                    data: {
                        name: 'name',
                        identity: 'identity',
                        identity_user: 'identity_user'
                    },
                    render: (data, type, row, meta) => {
                        let editUrl = "{{ route('database.show', ':identity') }}".replace(
                            ':identity',
                            data.identity);
                        if (data.identity_user == identity || identity == '6281313608558') {
                            return `<a href="${editUrl}" class="font-bold underline">${data.name}</a>`
                        } else {
                            return `<span>${data.name}</span>`;
                        }

                    }
                }, {
                    data: 'presenter',
                    render: (data) => {
                        return typeof(data) == 'object' ? data.name : 'Tidak diketahui';
                    }
                }, {
                    data: 'source_setting',
                    render: (data, type, row) => {
                        return data.name;
                    }
                }, {
                    data: 'school_applicant',
                    render: (data) => {
                        return data == null ? 'Tidak diketahui' : data.name;
                    }
                }, {
                    data: 'year',
                    render: (data, row) => {
                        return data != null ? data : 'Tidak diketahui';
                    }
                }];

                const dataTableConfig = {
                    columns: manualColumns,
                    data: data,
                }

                if (dataTableInitialized) {
                    dataTableInstance.destroy();
                }

                dataTableInstance = new DataTable('#quickSearchTable', dataTableConfig);

                dataTableInitialized = true;
            } catch (error) {
                console.log(error);
            }
        }
    </script>
    @if (Auth::user()->role == 'A')
        <script>
            const getPresenter = async () => {
                let data;
                const chartPresenter = document.getElementById('chartPresenter');
                const chartPresenterContainer = document.getElementById('chartPresenterContainer');
                await axios.get('get/dashboard/presenters')
                    .then(async (res) => {
                        data = res.data.presenters;
                        if (data.length > 0) {
                            let labels = data.map(element => element.name);
                            let dataPresenter = data.map(element => element.count);
                            await new Chart(chartPresenter, {
                                type: 'doughnut',
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            display: false,
                                        },
                                    },
                                },
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Hasil',
                                        data: dataPresenter,
                                    }]
                                }
                            });
                        } else {
                            let content =
                                `<div class="text-center py-3">
                        <h3 class="font-bold text-gray-800">Aplikan Berdasarkan Sumber Database</h3>
                    </div>
                    <hr>
                    <p class="text-center text-gray-700 text-sm py-3 px-3">Data tidak ada</p>`;
                            chartPresenterContainer.innerHTML = content;
                        }
                    })
                    .catch((err) => {
                        console.log(err.message);
                    });
            }
            getPresenter();
        </script>
    @endif
@endif
@if (Auth::user()->role == 'S')
    <script>
        const copyRecord = (number) => {
            const textarea = document.createElement("textarea");
            textarea.value = number;
            textarea.style.position = "fixed";
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand("copy");
            document.body.removeChild(textarea);
            alert('Nomor rekening sudah disalin!');
        }
    </script>
@endif
