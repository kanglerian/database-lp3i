<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 pb-3">
            <nav class="flex">
                <ol class="inline-flex items-center space-x-2 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">
                            <i class="fa-solid fa-table-columns mr-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Rekapitulasi Data Aplikan</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <section class="space-y-5 py-10">

        <div class="max-w-7xl px-5 mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                <div class="flex items-end flex-wrap md:flex-nowrap text-gray-500 md:gap-3 order-2 md:order-none">
                    <input type="hidden" id="identity_val" value="{{ Auth::user()->identity }}">
                    <input type="hidden" id="role_val" value="{{ Auth::user()->role }}">
                    <div class="inline-block flex flex-col space-y-1 p-1 md:p-0">
                        <label for="change_pmb" class="text-xs">Periode PMB:</label>
                        <input type="number" id="change_pmb" onchange="changeTrigger()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
                            placeholder="Tahun PMB">
                    </div>
                    <div class="inline-block flex flex-col space-y-1 p-1 md:p-0">
                        <label for="session" class="text-xs">Gelombang:</label>
                        <select id="session" onchange="changeTrigger()"
                            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                            <option value="all">Pilih</option>
                            <option value="1">Gelombang 1</option>
                            <option value="2">Gelombang 2</option>
                            <option value="3">Gelombang 3</option>
                        </select>
                    </div>
                </div>
                <div class="px-6 py-2 rounded-xl text-sm bg-gray-50 border border-gray-200 order-1 md:order-none">
                    <div>
                        <span class="font-bold">{{ Auth::user()->name }}</span>
                        (<span onclick="copyIdentity('{{ Auth::user()->identity }}')">ID:
                            {{ Auth::user()->identity }}</span>)
                        <button onclick="copyIdentity('{{ Auth::user()->identity }}')" class="text-blue-500"><i
                                class="fa-regular fa-copy"></i></button>
                    </div>
                    <span class="text-xs text-gray-600">Gunakan Key Identity ini di aplikasi Whatsapp
                        Sender.</span>
                </div>
            </div>
        </div>

        <div class="max-w-7xl px-5 mx-auto">
            <section class="bg-gray-50 p-8 rounded-3xl border border-gray-200 space-y-5">
                @include('pages.dashboard.presenter.data.aplikan')
                <hr>
                @include('pages.dashboard.presenter.data.daftar')
                <hr>
                @include('pages.dashboard.presenter.data.registrasi')

                @include('pages.dashboard.utilities.all')
                @include('pages.dashboard.utilities.pmb')
                @include('pages.dashboard.utilities.session')

                @include('pages.dashboard.presenter.data.scripts')
            </section>
        </div>
    </section>

</x-app-layout>
