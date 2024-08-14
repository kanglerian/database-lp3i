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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Pendaftaran</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="flex flex-wrap justify-center items-center gap-2 px-2 text-gray-600">
                <div class="flex bg-gray-200 px-4 py-2 text-sm rounded-xl items-center gap-2">
                    <i class="fa-solid fa-database"></i>
                    {{-- <h2 id="count_filter">{{ $total }}</h2> --}}
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
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
                <div id="alert" class="mx-2 mb-3 flex items-center p-4 mb-3 bg-red-500 text-white rounded-xl"
                    role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div class="ml-3 text-sm font-reguler">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <div class="flex justify-between items-center gap-3 mx-2 py-2">
                <div class="flex items-end flex-wrap md:flex-nowrap text-gray-500 md:gap-3">
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
                        <label for="repayment" class="text-xs">Pengembalian BK:</label>
                        <input type="date" id="repayment" onchange="changeFilter()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800">
                    </div>
                    <div class="inline-block flex flex-col space-y-1 p-1 md:p-0">
                        <label for="register" class="text-xs">Keterangan:</label>
                        <select id="register" onchange="changeFilter()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800">
                            <option value="all">Pilih</option>
                            <option value="Daftar Kampus">Daftar Kampus</option>
                            <option value="Daftar BK">Daftar BK</option>
                            <option value="Daftar TF Kampus">Daftar TF Kampus</option>
                        </select>
                    </div>
                    <div class="inline-block flex flex-col space-y-1 p-1 md:p-0">
                        <label for="register_end" class="text-xs">Keterangan Daftar:</label>
                        <select id="register_end" onchange="changeFilter()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800">
                            <option value="all">Pilih</option>
                            <option value="Daftar Kampus">Daftar Kampus</option>
                            <option value="Daftar BK">Daftar BK</option>
                            <option value="Daftar TF Kampus">Daftar TF Kampus</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden border rounded-3xl">
                <div class="p-8 bg-white border-b border-gray-200">
                    <div class="relative overflow-x-auto">
                        <table id="myTable" class="w-full text-sm text-sm text-left text-gray-500">
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
                                        Keterangan
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Daftar
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nominal Daftar
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Pengembalian BK
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Debit
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Kas
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
@include('pages.payment.enrollment.js.filterjs')
<script>
    const getDataTable = async () => {
        const dataTableConfig = {
            ajax: {
                url: urlData,
                dataSrc: 'enrollments'
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
                    width: 100,
                    target: 3
                },
                {
                    width: 150,
                    target: 4
                },
                {
                    width: 150,
                    target: 5
                },
                {
                    width: 100,
                    target: 6
                },
                {
                    width: 100,
                    target: 7
                },
                {
                    width: 100,
                    target: 8
                },
                {
                    width: 50,
                    target: 9
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
                    data: 'register'
                },
                {
                    data: 'register_end'
                },
                {
                    data: 'nominal',
                    render: (data, type, row) => {
                        return `Rp${data.toLocaleString('id-ID')}`
                    }
                },
                {
                    data: 'repayment',
                    render: (data, type, row) => {
                        return `${data || 'Tidak ada'}`
                    }
                },
                {
                    data: 'debit',
                    render: (data, type, row) => {
                        return `${data ? 'Rp' + data.toLocaleString('id-ID') : 'Tidak ada'}`
                    }
                },
                {
                    data: {
                        nominal: 'nominal',
                        debit: 'debit'
                    },
                    render: (data, type, row) => {
                        let debit = data.debit || 0;
                        let nominal = data.nominal || 0;
                        let money = nominal - debit;
                        return `Rp${money.toLocaleString('id-ID')}`
                    }
                },
                {
                    data: {
                        id: 'id',
                    },
                    render: (data, type, row) => {
                        return `
                        <div class="flex items-center gap-1">
                            <button class="md:mt-0 bg-red-500 hover:bg-red-600 px-3 py-1 rounded-lg text-xs text-white" onclick="event.preventDefault(); deleteRecord(${data.id})">
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
                url: `/enrollment/${id}`,
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
