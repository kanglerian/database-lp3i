<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 pb-3">
            <nav class="flex">
                <ol class="inline-flex items-center space-x-2 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('payment.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">
                            <i class="fa-regular fa-credit-card mr-2"></i>
                            Pembayaran
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Registrasi</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="flex flex-wrap justify-center items-center gap-2 px-2 text-gray-600">
                <div class="flex bg-gray-200 px-4 py-2 text-sm rounded-xl items-center gap-2">
                    <i class="fa-solid fa-database"></i>
                    <h2 id="count_filter">{{ $total }}</h2>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">
            @if (session('message'))
                <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-xl"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-reguler">
                        {{ session('message') }}
                    </div>
                </div>
            @endif

            <div class="flex justify-between items-center gap-3 mx-2 py-2">
                <div class="flex items-end flex-wrap md:flex-nowrap text-gray-500 md:gap-3">
                    <div class="flex flex-col space-y-1 p-1 md:p-0">
                        <label for="change_pmb" class="text-xs">Periode PMB:</label>
                        <input type="number" id="change_pmb" onchange="changeFilter()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800"
                            placeholder="Tahun PMB">
                    </div>
                    <div class="flex flex-col space-y-1 p-1 md:p-0">
                        <label for="date" class="text-xs">Tanggal:</label>
                        <input type="date" id="date" onchange="changeFilter()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800">
                    </div>
                    <div class="flex flex-col space-y-1 p-1 md:p-0">
                        <label for="session" class="text-xs">Gelombang:</label>
                        <select id="session" onchange="changeFilter()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800">
                            <option value="all">Pilih</option>
                            <option value="1">Gelombang 1</option>
                            <option value="2">Gelombang 2</option>
                            <option value="3">Gelombang 3</option>
                        </select>
                    </div>
                    <div class="flex flex-col space-y-1 p-1 md:p-0">
                        <label for="percent" class="text-xs">Persen</label>
                        <select id="percent" onchange="changeFilter()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800">
                            <option value="all">Pilih</option>
                            <option value="0.3">< 30% </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden border rounded-3xl">
                <div class="p-8 bg-white border-b border-gray-200">
                    <div class="relative overflow-x-auto">
                        <table id="myTable" class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 rounded-l-xl">
                                        Tanggal
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Gelombang
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nama Lengkap
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nominal
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Harga Deal
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Diskon
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Keterangan
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        < 30%
                                    </th>
                                    <th scope="col" class="px-6 py-3 rounded-r-xl">
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

</x-app-layout>

<script src="{{ asset('js/moment-with-locales.min.js') }}"></script>
<script src="{{ asset('js/moment-timezone-with-data.min.js') }}"></script>
<script src="{{ asset('js/axios.min.js') }}"></script>
@include('pages.payment.registration.js.filterjs')
<script>
    const getDataTable = async () => {
        const dataTableConfig = {
            ajax: {
                url: urlData,
                dataSrc: 'registrations'
            },
            order: [
                [0, 'desc']
            ],
            rowCallback: function(row, data, index) {
                if(index % 2 != 0){
                    $(row).css('background-color', '#f9fafb');
                }
            },
            columnDefs: [{
                    width: 100,
                    target: 0
                },
                {
                    width: 100,
                    target: 1
                },
                {
                    width: 200,
                    target: 2
                },
                {
                    width: 150,
                    target: 3
                },
                {
                    width: 150,
                    target: 4
                },
                {
                    width: 100,
                    target: 5
                },
                {
                    width: 150,
                    target: 6
                },
                {
                    width: 50,
                    target: 7
                },
                {
                    width: 50,
                    target: 8
                },
            ],
            columns: [{
                    data: 'date'
                },
                {
                    data: 'session'
                },
                {
                    data: 'applicant',
                    render: (data, type, row, meta) => {
                        let showUrl = "{{ route('database.show', ':identity') }}".replace(
                            ':identity',
                            data.identity);
                        return `<a href="${showUrl}" class="font-bold underline">${data.name}</a>`;
                    }
                },
                {
                    data: 'nominal',
                    render: (data, type, row, meta) => {
                        const convert = parseInt(data);
                        return `Rp${convert.toLocaleString('id-ID')}`
                    }
                },
                {
                    data: 'deal',
                    render: (data, type, row, meta) => {
                        const convert = parseInt(data);
                        return `Rp${convert.toLocaleString('id-ID')}`
                    }
                },
                {
                    data: 'discount',
                    render: (data, type, row, meta) => {
                        const convert = parseInt(data);
                        return `Rp${convert.toLocaleString('id-ID')}`
                    }
                },
                {
                    data: 'desc_discount',
                    render: (data, type, row) => {
                        return `${data || 'Tidak ada'}`
                    }
                },
                {
                    data: {
                        nominal: 'nominal',
                        deal: 'deal'
                    },
                    render: (data, type, row) => {
                        let dataPercent = parseInt(data.deal) * 0.3;
                        let percent = parseInt(data.nominal) < dataPercent;
                        return ` ${percent ? '<i class="fa-solid fa-circle-check text-emerald-500"></i>' : '<i class="fa-solid fa-circle-xmark text-red-500"></i>'}`
                    }
                },
                {
                    data: 'id',
                    render: (data, type, row) => {
                        return `
                        <div class="flex items-center gap-1">
                            <button type="button" class="md:mt-0 bg-red-500 hover:bg-red-600 px-3 py-1 rounded-lg text-xs text-white" onclick="event.preventDefault(); deleteRecord(${data})">
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
            dataRegistrations = data.registrations;
            dataTableInstance = $('#myTable').DataTable(dataTableConfig);
            dataTableInitialized = true;
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    }

    getDataTable();

    const deleteRecord = (id) => {
        if (confirm('Apakah kamu yakin akan menghapus data?')) {
            $.ajax({
                url: `/registration/${id}`,
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
