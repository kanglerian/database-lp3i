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
                <div id="alert" class="flex items-center p-4 mb-4 bg-red-500 text-red-50 rounded-xl"
                    role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div class="ml-3 text-sm font-reguler">
                        {{ session('error') }}
                    </div>
                </div>
            @endif
            <div class="flex justify-between items-center gap-3 mx-2 py-2">
                <form method="GET" action="{{ route('registration.index') }}"
                    class="w-full flex flex-col md:flex-row items-end gap-4">
                    <div class="w-full">
                        <label for="change_pmb" class="block mb-2 text-xs font-medium text-gray-900">
                            Periode PMB
                        </label>
                        <input type="number" name="pmb" id="change_pmb"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5"
                            placeholder="Tahun PMB" required />
                    </div>
                    <div class="w-full">
                        <label for="date" class="block mb-2 text-xs font-medium text-gray-900">
                            Tanggal
                        </label>
                        <input type="date" name="date" id="date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5" />
                    </div>
                    <div class="w-full">
                        <label for="session" class="block mb-2 text-xs font-medium text-gray-900">
                            Gelombang
                        </label>
                        <select id="session" name="session"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5">
                            <option value="all">Pilih</option>
                            <option value="1">Gelombang 1</option>
                            <option value="2">Gelombang 2</option>
                            <option value="3">Gelombang 3</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for="percent" class="block mb-2 text-xs font-medium text-gray-900">
                            Persen
                        </label>
                        <select id="percent" name="percent"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5">
                            <option value="all">Pilih</option>
                            <option value="0.3">< 30% </option>
                        </select>
                    </div>
                    <div class="w-full">
                        <button type="submit"
                            class="inline-block text-white bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-xs px-5 py-2.5">
                            <i class="fa-solid fa-filter"></i>
                        </button>
                        <a href="{{ route('registration.index') }}"
                            class="inline-block text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-xs px-5 py-2.5">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden border rounded-3xl">
                <div class="p-8 bg-white border-b border-gray-200">
                    <div class="relative overflow-x-auto sm:rounded-xl">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase">
                                <tr>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        No.
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Tanggal
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        Gelombang
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nama Lengkap
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        Nominal
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Harga Deal
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        Diskon
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Keterangan
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        < 30% </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($registrations as $key => $registration)
                                    <tr class="border-b border-gray-200">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50">
                                            {{ $registrations->perPage() * ($registrations->currentPage() - 1) + $key + 1 }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $registration->date }}
                                        </td>
                                        <td class="px-6 py-4 bg-gray-50">
                                            {{ $registration->session }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $registration->applicant->name }}
                                        </td>
                                        <td class="px-6 py-4 bg-gray-50">
                                            {{ $registration->nominal }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $registration->deal }}
                                        </td>
                                        <td class="px-6 py-4 bg-gray-50">
                                            {{ $registration->nominal }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $registration->discount }}
                                        </td>
                                        <td class="px-6 py-4 bg-gray-50">
                                            @php
                                                $data_percent = $registration->deal * 0.3;
                                                $percent = $registration->nominal < $data_percent;
                                            @endphp
                                            {!! $percent
                                                ? '<i class="fa-solid fa-circle-check text-emerald-500"></i>'
                                                : '<i class="fa-solid fa-circle-xmark text-red-500"></i>' !!}
                                        </td>
                                        <td class="px-6 py-4">
                                            <form action="{{ route('registration.destroy', $registration->id) }}"
                                                method="post" class="inline-block"
                                                onsubmit="return confirmDelete()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 px-3 py-2 rounded-lg text-white transition-all ease-in-out">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="px-6 py-4 text-center">Data tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="p-1">
                            {{ $registrations->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('pages.dashboard.utilities.pmb')
    @push('scripts')
        <script>
            function getUrlParams() {
                const urlParams = new URLSearchParams(window.location.search);
                const pmb = urlParams.get('pmb') || pmbVal;
                const date = urlParams.get('date');
                const session = urlParams.get('session') || 'all';
                const percent = urlParams.get('percent') || 'all';
                document.getElementById('change_pmb').value = pmb;
                document.getElementById('date').value = date;
                document.getElementById('session').value = session;
                document.getElementById('percent').value = percent;
            }
            getUrlParams();

            function confirmDelete() {
                return confirm('Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.');
            }
        </script>
    @endpush
</x-app-layout>
