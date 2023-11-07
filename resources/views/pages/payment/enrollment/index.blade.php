<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
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
                    <h2 id="count_filter">{{ $total }}</h2>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">
            @if (session('message'))
                <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-lg"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('message') }}
                    </div>
                </div>
            @endif

            <div class="flex justify-between items-center gap-3 mx-2 py-2">
                <div class="flex items-end flex-wrap md:flex-nowrap text-gray-500 md:gap-3">
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
                        <label for="repayment" class="text-xs">Pengembalian BK:</label>
                        <input type="date" id="repayment" onchange="changeFilter()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                    </div>
                    <div class="inline-block flex flex-col space-y-1 p-1 md:p-0">
                        <label for="register" class="text-xs">Keterangan:</label>
                        <select id="register" onchange="changeFilter()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                            <option value="all">Pilih</option>
                            <option value="Daftar Kampus">Daftar Kampus</option>
                            <option value="Daftar BK">Daftar BK</option>
                            <option value="Daftar TF Kampus">Daftar TF Kampus</option>
                        </select>
                    </div>
                    <div class="inline-block flex flex-col space-y-1 p-1 md:p-0">
                        <label for="register_end" class="text-xs">Keterangan Daftar:</label>
                        <select id="register_end" onchange="changeFilter()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                            <option value="all">Pilih</option>
                            <option value="Daftar Kampus">Daftar Kampus</option>
                            <option value="Daftar BK">Daftar BK</option>
                            <option value="Daftar TF Kampus">Daftar TF Kampus</option>
                        </select>
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
            columnDefs: [
                {
                    width: 100,
                    target: 0
                },
                {
                    width: 200,
                    target: 1
                },
                {
                    width: 100,
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
                    width: 100,
                    target: 6
                },
                {
                    width: 100,
                    target: 7
                },
                {
                    width: 50,
                    target: 8
                },
            ],
            columns: [
                {
                    data: 'date'
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
                            <button class="md:mt-0 bg-red-500 hover:bg-red-600 px-3 py-1 rounded-md text-xs text-white" onclick="event.preventDefault(); deleteRecord(${data.id})">
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
            if (response) {
                const text = await response.text();
                console.error("Response text:", text);
            }
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
