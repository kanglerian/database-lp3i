<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Pembayaran') }}
            </h2>
        </div>
    </x-slot>

    <main class="max-w-7xl mx-auto">
        <form method="GET" action="{{ route('payment.index') }}"
            class="w-full flex flex-col md:flex-row justify-between items-center md:items-end gap-5 px-2 pb-5">
            <div class="w-full md:w-1/4 relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-5 pointer-events-none">
                    <i class="fa-regular fa-calendar text-gray-400"></i>
                </div>
                <input type="number" name="pmb" id="change_pmb" onchange="submitForm()"
                    class="block w-full py-4 px-10 ps-12 text-sm text-gray-900 border border-gray-300 rounded-2xl bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Periode PMB" autofocus />
                <button type="submit"
                    class="text-white absolute end-2.5 bottom-2.5 bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-xs px-4 py-2">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span>Cari</span>
                </button>
            </div>
        </form>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div class="p-6 bg-gray-50 border border-gray-200 rounded-3xl m-1">
                <h5 class="mb-2 text-md font-medium text-gray-500">Total Kas Pendaftaran</h5>
                <div class="flex items-baseline text-gray-900 mb-3">
                    <span class="text-xl font-semibold">Rp</span>
                    <span class="text-3xl text-gray-800 font-extrabold tracking-tight">
                        {{ number_format($cash, 0, ',', '.') }}
                    </span>
                </div>
                <p class="mb-3 font-normal text-xs text-gray-700">Berikut ini adalah informasi total kas pendaftaran.
                    Untuk selengkapnya klik tombol di bawah ini.</p>
                <a href="{{ route('enrollment.index') }}"
                    class="inline-flex items-center px-3 py-2 text-xs font-medium text-center text-white bg-lp3i-100 hover:bg-lp3i-200 rounded-xl focus:ring-4 focus:outline-none focus:ring-blue-300">
                    Lihat selengkapnya
                    <i class="fa-solid fa-arrow-right-long ml-2"></i>
                </a>
            </div>
            <div class="p-6 bg-gray-50 border border-gray-200 rounded-3xl m-1">
                <h5 class="mb-2 text-md font-medium text-gray-500">Total Registrasi Awal</h5>
                <div class="flex items-baseline text-gray-900 mb-3">
                    <span class="text-xl font-semibold">Rp</span>
                    <span class="text-3xl text-gray-800 font-extrabold tracking-tight">
                        {{ number_format($total, 0, ',', '.') }}
                    </span>
                </div>
                <p class="mb-3 font-normal text-xs text-gray-700">Berikut ini adalah informasi total registrasi awal.
                    Untuk selengkapnya klik tombol di bawah ini.</p>
                <a href="{{ route('registration.index') }}"
                    class="inline-flex items-center px-3 py-2 text-xs font-medium text-center text-white bg-lp3i-100 hover:bg-lp3i-200 rounded-xl focus:ring-4 focus:outline-none focus:ring-blue-300">
                    Lihat selengkapnya
                    <i class="fa-solid fa-arrow-right-long ml-2"></i>
                </a>
            </div>
            <div class="p-6 bg-gray-50 border border-gray-200 rounded-3xl m-1">
                <h5 class="mb-2 text-md font-medium text-gray-500">Total Potensi Omset</h5>
                <div class="flex items-baseline text-gray-900 mb-3">
                    <span class="text-xl font-semibold text-gray-900">Rp</span>
                    <span class="text-3xl text-gray-800 font-extrabold tracking-tight">
                        {{ number_format($turnover, 0, ',', '.') }}
                    </span>
                </div>
                <p class="mb-3 font-normal text-xs text-gray-700">Berikut ini adalah informasi total potensi omset.
                    Untuk selengkapnya klik tombol di bawah ini.</p>
                <a href="{{ route('registration.index') }}"
                    class="inline-flex items-center px-3 py-2 text-xs font-medium text-center text-white bg-lp3i-100 hover:bg-lp3i-200 rounded-xl focus:ring-4 focus:outline-none focus:ring-blue-300">
                    Lihat selengkapnya
                    <i class="fa-solid fa-arrow-right-long ml-2"></i>
                </a>
            </div>
        </div>
    </main>
    @include('utilities.pmb')

    <script>
      function getUrlParams() {
          const urlParams = new URLSearchParams(window.location.search);
          const pmb = urlParams.get('pmb') || pmbVal;
          document.getElementById('change_pmb').value = pmb;
      }
      getUrlParams();
    </script>
</x-app-layout>
