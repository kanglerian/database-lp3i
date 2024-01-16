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
                @if (Auth::user()->status != 1)
                    <div class="px-6 py-2 rounded-lg bg-red-500 text-white text-sm">
                        <p><i class="fa-solid fa-lock mr-1"></i> Akun anda belum di aktifkan.</p>
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
        @include('pages.dashboard.utilities.scripts')

        @include('pages.dashboard.database.database')
        @include('pages.dashboard.target.target')
        @include('pages.dashboard.search.search')

        <div class="max-w-7xl px-5 mx-auto">
            <section class="bg-white p-5 md:rounded-xl border border-gray-100 space-y-5">
                <header class="space-y-1">
                    <h2 class="font-bold text-xl text-gray-800">Rekapitulasi Sumber Database</h2>
                    <p class="text-sm text-gray-700 text-sm">
                        Berikut ini adalah hasil perhitungan dari riwayat pesan.
                    </p>
                </header>
                <hr>
                @include('pages.dashboard.report.main')
                @if (Auth::user()->role == 'P')
                    @include('pages.dashboard.report.sourcedatabasebywilayah')
                @endif
                @if (Auth::user()->role == 'A' || Auth::user()->role == 'K')
                    @include('pages.dashboard.report.sourcedatabasebypresenter')
                @endif
                @if (Auth::user()->role == 'A' || Auth::user()->role == 'K')
                    @include('pages.dashboard.report.wilayahdatabasebypresenter')
                @endif
            </section>
        </div>

        @include('pages.dashboard.database.history')
        @include('pages.dashboard.harta.database')
        @include('pages.dashboard.source.source')

    </section>

</x-app-layout>
@if (Auth::user()->role !== 'S')
    <script src="{{ asset('js/chart.min.js') }}"></script>
    <script src="{{ asset('js/chart.umd.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script>
        const copyIdentity = (identity) => {
            const textarea = document.createElement("textarea");
            textarea.value = identity;
            textarea.style.position = "fixed";
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand("copy");
            document.body.removeChild(textarea);
            alert('ID sudah disalin!');
        }
    </script>
    <script>
        let identity = document.getElementById('identity').value;
        let pmb = document.getElementById('change_pmb').value;
        let apiTargets = `/get/targets?identity=${identity}&pmbVal=${pmb}`;
        let apiDashboard = `/get/dashboard/all?identity=${identity}&pmbVal=${pmb}`
    </script>
    @if (Auth::user()->role == 'A' || Auth::user()->role == 'K')
        <script>
            const changeTrigger = () => {
                changeFilterDatabasePresenter();
                changeFilterDatabasePresenterWilayah();
                changeFilterDatabaseSchool();
                getHistories();
                changeFilterDatabase();
            }
        </script>
    @else
        <script>
            const changeTrigger = () => {
                changeFilterDatabasePresenter();
                changeFilterDatabasePresenterWilayah();
                changeFilterDatabaseSchool();
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
        let dataTableInitialized = false;
        let dataTableInstance;
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
