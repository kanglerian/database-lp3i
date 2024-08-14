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
            <div class="flex justify-between items-center gap-3 p-5 md:p-0">
                <form method="GET" action="{{ route('enrollment.index') }}"
                    class="w-full flex flex-col md:flex-row items-end gap-4">
                    <div class="w-full">
                        <label for="change_pmb" class="block mb-2 text-xs font-medium text-gray-900">Periode PMB</label>
                        <input type="number" name="pmb" id="change_pmb"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5"
                            placeholder="Tahun PMB" required />
                    </div>
                    <div class="w-full">
                        <label for="date" class="block mb-2 text-xs font-medium text-gray-900">Tanggal</label>
                        <input type="date" name="date" id="date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5" />
                    </div>
                    <div class="w-full">
                        <label for="repayment" class="block mb-2 text-xs font-medium text-gray-900">
                            Pengembalian BK
                        </label>
                        <input type="date" name="repayment" id="repayment"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5" />
                    </div>
                    <div class="w-full">
                        <label for="register" class="block mb-2 text-xs font-medium text-gray-900">
                            Keterangan
                        </label>
                        <select id="register" name="register"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5">
                            <option value="all">Pilih</option>
                            <option value="Daftar Kampus">Daftar Kampus</option>
                            <option value="Daftar BK">Daftar BK</option>
                            <option value="Daftar TF Kampus">Daftar TF Kampus</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label for="register_end" class="block mb-2 text-xs font-medium text-gray-900">
                            Keterangan Daftar
                        </label>
                        <select id="register_end" name="register_end"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5">
                            <option value="all">Pilih</option>
                            <option value="Daftar Kampus">Daftar Kampus</option>
                            <option value="Daftar BK">Daftar BK</option>
                            <option value="Daftar TF Kampus">Daftar TF Kampus</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <button type="submit"
                            class="inline-block text-white bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-xs px-5 py-2.5">
                            <i class="fa-solid fa-filter"></i>
                        </button>
                        <a href="{{ route('enrollment.index') }}"
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
                                        Keterangan
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Daftar
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        Nominal Daftar
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Pengembalian BK
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        Debit
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Kas
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($enrollments as $key => $enrollment)
                                    <tr class="border-b border-gray-200">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50">
                                            {{ $enrollments->perPage() * ($enrollments->currentPage() - 1) + $key + 1 }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $enrollment->date }}
                                        </td>
                                        <td class="px-6 py-4 bg-gray-50">
                                            {{ $enrollment->session }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $enrollment->applicant->name }}
                                        </td>
                                        <td class="px-6 py-4 bg-gray-50">
                                            {{ $enrollment->register }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $enrollment->register_end }}
                                        </td>
                                        <td class="px-6 py-4 bg-gray-50">
                                            {{ $enrollment->nominal }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $enrollment->repayment ?? 'Tidak ada' }}
                                        </td>
                                        <td class="px-6 py-4 bg-gray-50">
                                            {{ $enrollment->debit ?? 'Tidak ada' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $enrollment->nominal - $enrollment->debit }}
                                        </td>
                                        <td class="px-6 py-4 bg-gray-50">
                                            <form action="{{ route('enrollment.destroy', $enrollment->id) }}"
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
                            {{ $enrollments->links() }}
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
                const repayment = urlParams.get('repayment');
                const register = urlParams.get('register') || 'all';
                const registerEnd = urlParams.get('register_end') || 'all';
                document.getElementById('change_pmb').value = pmb;
                document.getElementById('date').value = date;
                document.getElementById('repayment').value = repayment;
                document.getElementById('register').value = register;
                document.getElementById('register_end').value = registerEnd;
            }
            getUrlParams();

            function confirmDelete() {
                return confirm('Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.');
            }
        </script>
    @endpush
</x-app-layout>
