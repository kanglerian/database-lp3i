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

    @if (Auth::user()->role == 'S' && Auth::user()->status == 0)
        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-5 px-5 md:px-0">
                    <div class="w-full md:w-6/12 space-y-5 order-2 md:order-none">
                        <div class="space-y-1">
                            <h3 class="text-2xl font-bold text-gray-800">Silahkan untuk lakukan Transfer!</h3>
                            <p class="text-gray-700">Isi formulir pendaftaran dan raih kesempatan yang luar biasa di
                                depan mata.</p>
                        </div>
                        <div class="flex flex-wrap items-end">
                            <div class="w-1/2 md:w-1/3 space-y-3 p-4">
                                <img src="{{ asset('logo/btn.png') }}" alt="">
                                <div onclick="copyRecord('32902384901')"
                                    class="cursor-pointer flex justify-between items-center border px-3 py-1 rounded-lg">
                                    <div>
                                        <h1 class="font-bold text-gray-800">BANK BTN</h1>
                                        <p class="text-sm text-gray-700">32902384901</p>
                                    </div>
                                    <button onclick="copyRecord('32902384901')"><i
                                            class="fa-solid fa-clipboard text-gray-500 hover:text-blue-500"></i></button>
                                </div>
                            </div>
                            <div class="w-1/2 md:w-1/3 space-y-3 p-4">
                                <img src="{{ asset('logo/bni.png') }}" alt="">
                                <div onclick="copyRecord('32902384902')"
                                    class="cursor-pointer flex justify-between items-center border px-3 py-1 rounded-lg">
                                    <div>
                                        <h1 class="font-bold text-gray-800">BANK BNI</h1>
                                        <p class="text-sm text-gray-700">32902384902</p>
                                    </div>
                                    <button onclick="copyRecord('32902384902')"><i
                                            class="fa-solid fa-clipboard text-gray-500 hover:text-blue-500"></i></button>
                                </div>
                            </div>
                            <div class="w-1/2 md:w-1/3 space-y-3 p-4">
                                <img src="{{ asset('logo/bsi.png') }}" alt="">
                                <div onclick="copyRecord('32902384903')"
                                    class="cursor-pointer flex justify-between items-center border px-3 py-1 rounded-lg">
                                    <div>
                                        <h1 class="font-bold text-gray-800">BANK BSI</h1>
                                        <p class="text-sm text-gray-700">32902384903</p>
                                    </div>
                                    <button onclick="copyRecord('32902384903')"><i
                                            class="fa-solid fa-clipboard text-gray-500 hover:text-blue-500"></i></button>
                                </div>
                            </div>
                        </div>
                        <div>
                            @if (session('error'))
                                <div id="alert"
                                    class="mx-2 mb-4 flex items-center p-4 mb-4 bg-red-500 text-white rounded-lg"
                                    role="alert">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    <div class="ml-3 text-sm font-medium">
                                        {{ session('error') }}
                                    </div>
                                </div>
                            @endif
                            @if (session('message'))
                                <div id="alert"
                                    class="mx-2 mb-4 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-lg"
                                    role="alert">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <div class="ml-3 text-sm font-medium">
                                        {{ session('message') }}
                                    </div>
                                </div>
                            @endif
                            @if ($errors->first('berkas'))
                                <div id="alert"
                                    class="mx-2 mb-4 flex items-center p-4 mb-4 bg-red-500 text-white rounded-lg"
                                    role="alert">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    <div class="ml-3 text-sm font-medium">
                                        {{ $errors->first('berkas') }}
                                    </div>
                                </div>
                            @endif
                            @forelse ($userupload as $suc)
                                <div class="flex items-center gap-2">
                                    <button
                                        class="inline-block bg-green-500 hover:bg-green-600 px-3 py-1 rounded-md text-sm text-white">Bukti
                                        pembayaran sudah di unggah <i class="fa-solid fa-circle-check"></i></button>
                                </div>
                            @empty
                                @foreach ($fileupload as $upload)
                                    <div class="flex flex-wrap md:items-center gap-2">
                                        <h2 class="w-full font-bold text-gray-800">Upload Bukti Pembayaran:</h2>
                                        <form action="{{ route('upload.payment') }}" enctype="multipart/form-data"
                                            class="w-full flex flex-wrap gap-2 items-center" method="POST">
                                            @csrf
                                            <div class="flex items-center gap-2">
                                                <input type="hidden" name="name" value="{{ $upload->name }}">
                                                <input type="hidden" name="fileupload_id" value="11">
                                                <input type="hidden" name="namefile" value="{{ $upload->namefile }}">
                                                <input type="file" name="berkas" id="berkas"
                                                    class="text-sm border border-gray-200 bg-white px-2 py-2 rounded-md"
                                                    accept="{{ $upload->accept }}">
                                                <button type="submit"
                                                    class="inline-block bg-sky-500 hover:bg-sky-600 px-3 py-1 rounded-md text-xs text-white">
                                                    <i class="fa-solid fa-upload"></i>
                                                </button>
                                            </div>
                                            <small>Maks: 1MB</small>
                                        </form>
                                    </div>
                                @endforeach
                            @endforelse
                        </div>
                    </div>
                    <div class="w-full md:w-5/12 order-1 md:order-none">
                        <img src="{{ asset('img/payment.svg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (Auth::user()->role !== 'S')
        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-wrap">
                    <div class="block w-1/2 md:w-1/5 p-1">
                        <div class="flex justify-between items-center px-5 py-3 bg-lp3i-200 text-white rounded-xl">
                            <h4>
                                <i class="fa-solid fa-database mr-1"></i>
                                <span class="text-sm">Database</span>
                            </h4>
                            <span
                                class="bg-lp3i-100 text-white text-sm px-2 py-1 rounded-lg">{{ $databaseCount }}</span>
                        </div>
                    </div>
                    <div class="block w-1/2 md:w-1/5 p-1">
                        <div class="flex justify-between items-center px-5 py-3 bg-cyan-500 text-white rounded-xl">
                            <h4>
                                <i class="fa-solid fa-graduation-cap mr-1"></i>
                                <span class="text-sm">Beasiswa</span>
                            </h4>
                            <span
                                class="bg-cyan-600 text-white text-sm px-2 py-1 rounded-lg">{{ $schoolarshipCount }}</span>
                        </div>
                    </div>
                    <div class="block w-1/2 md:w-1/5 p-1">
                        <div class="flex justify-between items-center px-5 py-3 bg-yellow-500 text-white rounded-xl">
                            <h4>
                                <i class="fa-solid fa-file-lines mr-1"></i>
                                <span class="text-sm">Aplikan</span>
                            </h4>
                            <span
                                class="bg-yellow-600 text-white text-sm px-2 py-1 rounded-lg">{{ $applicantCount }}</span>
                        </div>
                    </div>
                    <div class="block w-1/2 md:w-1/5 p-1">
                        <div class="flex justify-between items-center px-5 py-3 bg-sky-500 text-white rounded-xl">
                            <h4>
                                <i class="fa-solid fa-id-badge mr-1"></i>
                                <span class="text-sm">Daftar</span>
                            </h4>
                            <span
                                class="bg-sky-600 text-white text-sm px-2 py-1 rounded-lg">{{ $daftarCount }}</span>
                        </div>
                    </div>
                    <div class="block w-1/2 md:w-1/5 p-1">
                        <div class="flex justify-between items-center px-5 py-3 bg-emerald-500 text-white rounded-xl">
                            <h4>
                                <i class="fa-solid fa-user-check mr-1"></i>
                                <span class="text-sm">Registrasi</span>
                            </h4>
                            <span
                                class="bg-emerald-600 text-white text-sm px-2 py-1 rounded-lg">{{ $registrasiCount }}</span>
                        </div>
                    </div>
                </div>
                @if (Auth::user()->role == 'A')
                    <div class="mt-5">
                        <h1 class="my-2 font-bold text-gray-700">Total Sumber Informasi:</h1>
                        <div class="flex flex-wrap">
                            @foreach ($sourcesIdDaftarCount as $sourcesdaftarid)
                                <div class="block w-1/2 md:w-1/5 p-1">
                                    <div
                                        class="flex justify-between items-center px-5 py-3 bg-gray-100 text-gray-800 border border-gray-300 rounded-xl">
                                        <h4>
                                            <i class="fa-solid fa-database mr-1"></i>
                                            <span
                                                class="text-sm">{{ $sourcesdaftarid->sourceDaftarSetting->name }}</span>
                                        </h4>
                                        <span
                                            class="bg-gray-600 text-white text-sm px-2 py-1 rounded-lg">{{ $sourcesdaftarid->total }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-5">
                        <h1 class="my-2 font-bold text-gray-700">Total Sumber Database:</h1>
                        <div class="flex flex-wrap">
                            @foreach ($sourcesIdCount as $sourcesid)
                                <div class="block w-1/2 md:w-1/5 p-1">
                                    <div
                                        class="flex justify-between items-center px-5 py-3 bg-gray-100 text-gray-800 border border-gray-300 rounded-xl">
                                        <h4>
                                            <i class="fa-solid fa-database mr-1"></i>
                                            <span class="text-sm">{{ $sourcesid->sourceSetting->name }}</span>
                                        </h4>
                                        <span
                                            class="bg-gray-600 text-white text-sm px-2 py-1 rounded-lg">{{ $sourcesid->total }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @if (Auth::user()->role == 'A')
            <div class="py-10">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row gap-5 px-5 md:px-0">
                        <div class="w-full md:w-1/3 bg-white p-3 rounded-3xl border border-gray-200"
                            id="chartSourceContainer">
                            <div class="text-center py-3">
                                <h3 class="font-bold text-gray-800">Data Berdasarkan Sumber Database</h3>
                            </div>
                            <hr>
                            <canvas id="chartSource" class="py-3"></canvas>
                        </div>
                        <div class="w-full md:w-1/3 bg-white p-3 rounded-3xl border border-gray-200"
                            id="chartSourceDaftarContainer">
                            <div class="text-center py-3">
                                <h3 class="font-bold text-gray-800">Data Berdasarkan Sumber Informasi</h3>
                            </div>
                            <hr>
                            <canvas id="chartSourceDaftar" class="py-3"></canvas>
                        </div>
                        <div class="w-full md:w-1/3 bg-white p-3 rounded-3xl border border-gray-200"
                            id="chartPresenterContainer">
                            <div class="text-center py-3">
                                <h3 class="font-bold text-gray-800">Data Berdasarkan Presenter</h3>
                            </div>
                            <hr>
                            <canvas id="chartPresenter" class="py-3"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
    @if (Auth::user()->role == 'P')
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4">
                <div class="bg-white relative overflow-x-auto border border-gray-200 sm:rounded-lg">
                    <header class="p-5 space-y-1">
                        <h1 class="flex items-center gap-2 font-bold text-gray-700">
                            <span>Database: Harta Gono Gini</span>
                            <span class="inline-block bg-red-500 px-2 py-1 rounded-lg text-xs text-white">
                                {{ $databasesAdminstratorCount }}
                            </span>
                        </h1>
                        <p class="text-gray-600 text-sm">Ini adalah data yang belum dibagikan ke Presenter.</p>
                    </header>
                    <hr class="mb-5">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-white">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    No.
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Sumber Database
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Sumber Database
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Asal Sekolah
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Tahun Lulus
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($databasesAdministrator as $number => $database)
                                <tr class="{{ $number % 2 == 0 ? 'border-b bg-gray-50' : 'bg-white' }}">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $number + 1 }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $database->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $database->sourceSetting->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $database->school ? $database->schoolApplicant->name : 'Tidak diketahui' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $database->year ? $database->year : 'Tidak diketahui' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @if ($databasesAdminstratorCount > count($databasesAdministrator))
                        <tfoot>
                            <tr class="bg-red-500 text-white">
                                <td colspan="5" class="text-center text-xs px-3 py-2">Data sudah lebih dari {{ count($databasesAdministrator) }}, silahkan cek melalui menu <a
                                    href="{{ route('database.index') }}" class="underline">Database</a></td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                    <hr class="mb-5">
                    <div class="px-5 pb-5">
                        <p class="text-gray-500 text-xs">Silahkan untuk dibagikan melalui menu <a
                                href="{{ route('database.index') }}" class="underline">Database</a>, kemudian
                            edit Presenter di profil calon mahasiswa baru oleh Administrator.</p>
                    </div>
                </div>
            </div>

        </div>
    @endif
</x-app-layout>
@if (Auth::user()->role !== 'S')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        var urlDataDashboard = 'get/dashboard/all'
        const getAll = async () => {
            await axios.get(urlDataDashboard)
                .then((res) => {
                    console.log(res);
                })
                .catch((err) => {
                    console.log(err);
                });
        }
        getAll();

        const changeFilter = () => {
            let queryParams = [];
            let pmbVal = document.getElementById('change_pmb').value || 'all';
            if (pmbVal !== 'all') {
                queryParams.push(`pmbVal=${pmbVal}`);
            }
            let queryString = queryParams.join('&');
            urlData = `get/dashboard/all?${queryString}`;
            getAll();
        }
    </script>
    <script>
        const getSource = async () => {
            let data;
            const chartSource = document.getElementById('chartSource');
            const chartSourceContainer = document.getElementById('chartSourceContainer');
            await axios.get('get/dashboard/sources')
                .then(async (res) => {
                    data = res.data.sources;
                    let labels = data.map(element => element.source_setting.name);
                    let dataSource = data.map(element => element.total);
                    if (dataSource.length > 0) {
                        await new Chart(chartSource, {
                            type: 'doughnut',
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                },
                            },
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Hasil',
                                    data: dataSource,
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
                        chartSourceContainer.innerHTML = content;
                    }
                })
                .catch((err) => {
                    console.log(err.message);
                });
        }
        getSource();
    </script>
    <script>
        const getSourceDaftar = async () => {
            let data;
            const chartSourceDaftar = document.getElementById('chartSourceDaftar');
            const chartSourceDaftarContainer = document.getElementById('chartSourceDaftarContainer');
            await axios.get('get/dashboard/sourcesdaftar')
                .then(async (res) => {
                    data = res.data.sources;
                    let labels = data
                        .filter(element => element.source_daftar_id !== null)
                        .map(element => element.source_daftar_setting.name);
                    let dataSource = data
                        .filter(element => element.source_daftar_id !== null)
                        .map(element => element.total);
                    if (dataSource.length > 0) {
                        await new Chart(chartSourceDaftar, {
                            type: 'doughnut',
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                },
                            },
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Hasil',
                                    data: dataSource,
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
                        chartSourceDaftarContainer.innerHTML = content;
                    }
                })
                .catch((err) => {
                    console.log(err.message);
                });
        }
        getSourceDaftar();
    </script>
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
                                        position: 'top',
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
