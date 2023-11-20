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
                <div class="flex bg-gray-200 px-4 py-2 text-sm rounded-lg items-center gap-2">
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
                    <div class="ml-3 text-sm font-medium">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 px-2 py-2">
                <div class="order-2 md:order-none flex justify-between items-center gap-3">
                    <div class="flex items-end flex-wrap md:flex-nowrap text-gray-500 md:gap-3">
                        <input type="hidden" id="identity" value="{{ $presenter->identity }}">
                        <div class="inline-block flex flex-col space-y-1 p-1 md:p-0">
                            <label for="change_pmb" class="text-xs">Periode PMB:</label>
                            <input type="number" id="change_pmb" onchange="changeFilter()"
                                class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
                                placeholder="Tahun PMB">
                        </div>
                        <div class="inline-block flex flex-col space-y-1 p-1 md:p-0">
                            <label for="date" class="text-xs">Tanggal:</label>
                            <input type="date" id="date" onchange="changeFilter()"
                                class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                        </div>
                        <div class="inline-block flex flex-col space-y-1 p-1 md:p-0">
                            <label for="session" class="text-xs">Gelombang:</label>
                            <select id="session" onchange="changeFilter()"
                                class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
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
                        <div class="relative bg-sky-500 p-4 rounded-xl space-y-1">
                            <h2 class="text-white text-xl" id="target_count">0</h2>
                            <p class="text-white text-sm">Total Target</p>
                            <div class="absolute top-2 right-4">
                                <button type="button" onclick="modalTarget()" class="text-white">
                                    <i class="fa-solid fa-circle-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="relative bg-emerald-500 p-4 rounded-xl space-y-1">
                            <h2 class="text-white text-xl" id="register_count">0</h2>
                            <p class="text-white text-sm">Registrasi</p>
                            <div class="absolute top-2 right-4">
                                <a href="{{ route('database.index') }}" class="text-white">
                                    <i class="fa-solid fa-circle-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div id="container-animate" class="relative bg-red-500 p-4 rounded-xl space-y-1">
                            <h2 class="text-white text-xl" id="result_count">0</h2>
                            <p class="text-white text-sm">Sisa Target</p>
                            <div class="hidden absolute top-[-40px] right-[-40px]" id="animate">
                                <dotlottie-player src="{{ asset('animations/win.lottie') }}" background="transparent" speed="1" style="width: 150px; height: 150px" direction="1" mode="normal" loop autoplay></dotlottie-player>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden border md:rounded-xl">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="relative overflow-x-auto md:rounded-xl">
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