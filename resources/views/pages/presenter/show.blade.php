<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <nav class="flex">
                <ol class="inline-flex items-center space-x-2 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('presenter.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">
                            <i class="fa-solid fa-users mr-2"></i>
                            Presenter
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Detail Presenter</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="flex flex-wrap justify-center items-center gap-2 px-2 text-gray-600">
                <div class="flex bg-gray-200 px-4 py-2 text-sm rounded-xl items-center gap-2">
                    <i class="fa-solid fa-database"></i>
                    <h2 id="count_filter">0</h2>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('message'))
                <div id="alert" class="mx-2 mb-4 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-lg"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-reguler">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 px-2 py-2">
                <div class="order-2 md:order-none flex justify-between items-center gap-3">
                    <div class="flex items-end flex-wrap md:flex-nowrap text-gray-500 md:gap-3">
                        <input type="hidden" id="identity_val" value="{{ $presenter->identity }}">
                        <div class="inline-block flex flex-col space-y-1 p-1 md:p-0">
                            <label for="change_pmb" class="text-xs">Periode PMB:</label>
                            <input type="number" id="change_pmb" onchange="changeFilter()"
                                class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800"
                                placeholder="Tahun PMB">
                        </div>
                        <div class="inline-block flex flex-col space-y-1 p-1 md:p-0">
                            <label for="date" class="text-xs">Tanggal:</label>
                            <input type="date" id="date" onchange="changeFilter()"
                                class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800">
                        </div>
                        <div class="inline-block flex flex-col space-y-1 p-1 md:p-0">
                            <label for="session" class="text-xs">Gelombang:</label>
                            <select id="session" onchange="changeFilter()"
                                class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800">
                                <option value="all">Pilih</option>
                                <option value="1">Gelombang 1</option>
                                <option value="2">Gelombang 2</option>
                                <option value="3">Gelombang 3</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="order-1 md:order-none">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        <div class="relative bg-sky-500 p-4 rounded-2xl space-y-1">
                            <h2 class="text-white text-xl" id="target_count">0</h2>
                            <p class="text-white text-sm">Total Target</p>
                            <div class="absolute top-2 right-4">
                                <button type="button" onclick="modalTarget()" class="text-white">
                                    <i class="fa-solid fa-circle-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="relative bg-emerald-500 p-4 rounded-2xl space-y-1">
                            <h2 class="text-white text-xl" id="register_count">0</h2>
                            <p class="text-white text-sm">Registrasi</p>
                            <div class="absolute top-2 right-4">
                                <a href="{{ route('database.index') }}" class="text-white">
                                    <i class="fa-solid fa-circle-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div id="container-animate" class="relative bg-red-500 p-4 rounded-2xl space-y-1">
                            <h2 class="text-white text-xl" id="result_count">0</h2>
                            <p class="text-white text-sm">Sisa Target</p>
                            <div class="hidden absolute top-[-40px] right-[-40px]" id="animate">
                                <dotlottie-player src="{{ asset('animations/win.lottie') }}" background="transparent" speed="1" style="width: 150px; height: 150px" direction="1" mode="normal" loop autoplay></dotlottie-player>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden border rounded-3xl">
                <div class="p-8 bg-white border-b border-gray-200">
                    <div class="relative overflow-x-auto rounded-3xl">
                        <table id="myTable" class="w-full text-sm text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 rounded-t-lg">
                                        Tanggal
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        PMB
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Gelombang
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Jumlah
                                    </th>
                                    <th scope="col" class="px-6 py-3 rounded-t-lg">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('pages.presenter.modal.target')
</x-app-layout>

<script src="{{ asset('js/moment-with-locales.min.js') }}"></script>
<script src="{{ asset('js/moment-timezone-with-data.min.js') }}"></script>
<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
@include('pages.presenter.js.filterjs')
<script>
    const getRegistrations = async () => {
        await axios.get(urlData)
        .then((res) => {
            let dataTargets = res.data.targets;
            let targets = 0;
            let registers = res.data.registrations.length;
            dataTargets.forEach(data => {
                targets += parseInt(data.total);
            });
            console.log(registers);
            document.getElementById('register_count').innerText = registers;
            document.getElementById('target_count').innerText = targets;
            document.getElementById('result_count').innerText = targets - registers;
            if(targets - registers <= 0){
                document.getElementById('animate').classList.remove('hidden');
                document.getElementById('container-animate').classList.remove('bg-red-500');
                document.getElementById('container-animate').classList.add('bg-yellow-500');
            }
        })
        .catch((err) => {
            console.log(err);
        });
    }
    getRegistrations();
</script>
<script>
    const getDataTable = async () => {
        const dataTableConfig = {
            ajax: {
                url: urlData,
                dataSrc: 'targets'
            },
            order: [
                [0, 'desc']
            ],
            columnDefs: [{
                    width: 100,
                    target: 0
                },
                {
                    width: 100,
                    target: 1
                },
                {
                    width: 100,
                    target: 2
                },
                {
                    width: 200,
                    target: 3
                },
                {
                    width: 150,
                    target: 4
                },
            ],
            columns: [{
                    data: 'date',
                    render: (data) => {
                        return moment(data).tz('Asia/Jakarta').locale('id').format('LL');
                    }
                },
                {
                    data: 'pmb'
                },
                {
                    data: 'session'
                },
                {
                    data: 'total'
                },
                {
                    data: 'id',
                    render: (data, type, row) => {
                        return `
                        <div class="flex items-center gap-1">
                            <button class="md:mt-0 bg-red-500 hover:bg-red-600 px-3 py-1 rounded-md text-xs text-white" onclick="event.preventDefault(); deleteRecord(${data})">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>`
                    }
                },
            ],
        }
        try {
            const response = await fetch(urlData);
            const data = await response.json();
            dataTargets = data.targets;
            dataTableInstance = $('#myTable').DataTable(dataTableConfig);
            dataTableInitialized = true;
        } catch (error) {
            console.error("Error fetching data:", error);
            if (response) {
                const text = await response.text();
                console.error("Response text:", text);
            }
        }
    }

    getDataTable();

    const deleteRecord = (id) => {
        if (confirm(`Apakah kamu yakin akan menghapus data?`)) {
            $.ajax({
                url: `/target/${id}`,
                type: 'POST',
                data: {
                    '_method': 'DELETE',
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert('Error deleting record');
                }
            })
        }
    }
</script>
<script>
    const modalTarget = () => {
        let modal = document.getElementById('modal-target');
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }
</script>
