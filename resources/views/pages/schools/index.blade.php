<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 pb-3">
            <div class="flex items-center gap-10">
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Daftar Sekolah') }}
                </h2>
            </div>
            <div class="flex flex-wrap justify-center gap-3 px-2 text-gray-600">
                <div class="flex bg-gray-200 px-4 py-2 text-sm rounded-xl items-center gap-2">
                    <i class="fa-solid fa-database"></i>
                    <h2 id="count_filter">0</h2>
                </div>
                <a href="{{ route('schools.setting') }}"
                    class="flex bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 text-sm rounded-xl items-center gap-2">
                    <i class="fa-solid fa-gear"></i>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-5 py-10">

        <div class="max-w-7xl px-5 mx-auto">
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
        </div>


        <section class="max-w-7xl grid grid-cols-1 md:grid-cols-2 gap-5 px-5 mx-auto">
            @if ($slepets > 0)
                <div
                    class="flex flex-col justify-between px-6 py-5 mb-4 text-red-800 rounded-3xl bg-red-50 border border-red-200">
                    <div>
                        <div class="flex items-center">
                            <i class="fa-solid fa-circle-info mr-2"></i>
                            <span class="sr-only">Info</span>
                            <h3 class="text-lg font-medium">Lakukan Update Data Sekolah!</h3>
                        </div>
                        <div class="mt-2 mb-4 text-sm">
                            Dalam daftar ini, terdapat sekitar <span class="font-bold">{{ $slepets }}</span> entri
                            sekolah yang masih menunggu penyesuaian wilayah, status, dan jenisnya. Penting untuk
                            mengubahnya
                            agar laporan menjadi lebih akurat.
                        </div>
                    </div>
                    <div class="flex">
                        <form action="{{ route('schools.index') }}" method="GET">
                            <input type="hidden" name="problem" value="true">
                            <button type="submit"
                                class="text-white bg-red-800 hover:bg-red-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-reguler rounded-xl text-xs px-4 py-3 me-1 text-center inline-flex items-center">
                                <i class="fa-solid fa-filter me-1"></i>
                                Filter
                            </button>
                        </form>
                        <a href="{{ route('schools.index') }}"
                            class="text-white bg-red-800 hover:bg-red-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-reguler rounded-xl text-xs px-4 py-3 me-1 text-center inline-flex items-center">
                            <i class="fa-solid fa-arrow-rotate-left me-1"></i>
                            Reset
                        </a>
                    </div>
                </div>
            @endif
            @if ($useless > 0)
                <div
                    class="flex flex-col justify-between px-6 py-5 mb-4 text-red-800 rounded-3xl bg-red-50 border border-red-200">
                    <div>
                        <div class="flex items-center">
                            <i class="fa-solid fa-circle-info mr-2"></i>
                            <span class="sr-only">Info</span>
                            <h3 class="text-lg font-medium">Lakukan Penghapusan Sekolah!</h3>
                        </div>
                        <div class="mt-2 mb-4 text-sm">
                            Dalam daftar ini, terdapat sekitar <span class="font-bold">{{ $useless }}</span> entri
                            sekolah memiliki data 0. Supaya tetap menampilkan data yang up to date maka silahkan hapus
                            data sekolah.
                        </div>
                    </div>
                    <div class="flex">
                        <form action="{{ route('school.clear') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="text-white bg-red-800 hover:bg-red-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-reguler rounded-xl text-xs px-4 py-3 me-1 text-center inline-flex items-center">
                                <i class="fa-solid fa-trash mr-2"></i>
                                Hapus Data Sekolah
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </section>

        <div class="max-w-7xl px-5 mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                <form method="GET" id="searchForm" action="{{ route('schools.index') }}"
                    class="w-full flex flex-col md:flex-row justify-between items-center md:items-end gap-5">
                    <div class="flex items-center gap-4">
                        <div class="w-full">
                            <label for="change_pmb" class="block mb-2 text-sm font-medium text-gray-900">Periode
                                PMB</label>
                            <input type="number" id="change_pmb" name="pmb"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full py-3 px-4"
                                placeholder="PMB" required />
                        </div>
                        <div class="w-full">
                            <label for="region" class="block mb-2 text-sm font-medium text-gray-900">
                                Wilayah
                            </label>
                            <select id="region" name="region"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full py-3 px-4">
                                <option value="all">Pilih wilayah</option>
                                @foreach ($schools_by_region as $region)
                                    <option value="{{ $region->region }}">{{ $region->region }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="w-full md:w-1/3 relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-5 pointer-events-none">
                            <i class="fa-solid fa-search text-gray-400"></i>
                        </div>
                        <input type="search" name="name" id="name" onchange="submitForm()"
                            class="block w-full py-4 px-10 ps-12 text-sm text-gray-900 border border-gray-300 rounded-2xl bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Cari nama sekolah..." autofocus />
                        <button type="submit"
                            class="text-white absolute end-2.5 bottom-2.5 bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-4 py-2">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="max-w-7xl px-5 mx-auto">
            <div class="bg-gray-50 overflow-hidden border rounded-3xl">
                <div class="p-8 bg-white border-b border-gray-200">
                    <div class="relative overflow-x-auto sm:rounded-xl">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase">
                                <tr>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        No.
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Wilayah
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        Nama Sekolah
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Total
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-emerald-50">
                                        Valid
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-red-50">
                                        Non Valid
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        Jumlah Kelas
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Presentasi
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        Daftar Online
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Website
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        Beasiswa
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Sosial Media
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        Grab Data
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        MGM
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        Sekolah
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Jadwal Datang
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        Guru BK
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Psikotes
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($schools as $key => $school)
                                    <tr class="border-b border-gray-200">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50">
                                            {{ $schools->perPage() * ($schools->currentPage() - 1) + $key + 1 }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $school->wilayah }}
                                        </td>
                                        <td class="px-6 py-4 bg-gray-50">
                                            <a href="{{ route('schools.show', $school->id) }}"
                                                class="underline font-bold text-gray-700">
                                                {{ $school->nama }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $school->jumlah }}
                                        </td>
                                        <td class="px-6 py-4 bg-emerald-50">
                                            {{ $school->valid }}
                                        </td>
                                        <td class="px-6 py-4 bg-red-50">
                                            {{ $school->nonvalid }}
                                        </td>
                                        <td class="px-6 py-4 bg-gray-50">
                                            {{ $school->kelas }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $school->presentasi }}
                                        </td>
                                        <td class="px-6 py-4 bg-gray-50">
                                            {{ $school->daftaronline }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $school->website }}
                                        </td>
                                        <td class="px-6 py-4 bg-gray-50">
                                            {{ $school->beasiswa }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $school->sosmed }}
                                        </td>
                                        <td class="px-6 py-4 bg-gray-50">
                                            {{ $school->grab }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $school->mgm }}
                                        </td>
                                        <td class="px-6 py-4 bg-gray-50">
                                            {{ $school->sekolah }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $school->jadwaldatang }}
                                        </td>
                                        <td class="px-6 py-4 bg-gray-50">
                                            {{ $school->gurubk }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $school->psikotes }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="18" class="px-6 py-4 text-center">Data tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="p-1">
                            {{ $schools->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('utilities.pmb')
    @include('pages.schools.modals.school')
    <script>
        function submitForm() {
            document.getElementById('searchForm').submit();
        }

        function getUrlParams() {
            const urlParams = new URLSearchParams(window.location.search);
            const name = urlParams.get('name');
            const pmb = urlParams.get('pmb') || pmbVal;
            const region = urlParams.get('region') || 'all';
            document.getElementById('name').value = name;
            document.getElementById('change_pmb').value = pmb;
            document.getElementById('region').value = region;
        }
        getUrlParams();
    </script>
</x-app-layout>
