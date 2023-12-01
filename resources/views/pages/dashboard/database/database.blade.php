@if (Auth::user()->role !== 'S')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-5 px-2 space-y-5">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-2">
            <div class="flex justify-between items-center px-5 py-3 bg-lp3i-200 text-white rounded-xl">
                <h4>
                    <i class="fa-solid fa-database mr-1"></i>
                    <span class="text-sm">Database</span>
                </h4>
                <span class="bg-lp3i-100 text-white text-sm px-2 py-1 rounded-lg" id="database_count">0</span>
            </div>
            <a href="#quicksearch_container" onclick="quickSearchStatus('schoolarship')"
                class="cursor-pointer flex justify-between items-center px-5 py-3 bg-cyan-500 text-white rounded-xl">
                <h4>
                    <i class="fa-solid fa-graduation-cap mr-1"></i>
                    <span class="text-sm">Beasiswa</span>
                </h4>
                <span class="bg-cyan-600 text-white text-sm px-2 py-1 rounded-lg" id="schoolarship_count">0</span>
            </a>
            <a href="#quicksearch_container" onclick="quickSearchStatus('aplikan')"
                class="cursor-pointer flex justify-between items-center px-5 py-3 bg-yellow-500 text-white rounded-xl">
                <h4>
                    <i class="fa-solid fa-file-lines mr-1"></i>
                    <span class="text-sm">Aplikan</span>
                </h4>
                <span class="bg-yellow-600 text-white text-sm px-2 py-1 rounded-lg" id="applicant_count">0</span>
            </a>
            <a href="#quicksearch_container" onclick="quickSearchStatus('daftar')"
                class="cursor-pointer flex justify-between items-center px-5 py-3 bg-sky-500 text-white rounded-xl">
                <h4>
                    <i class="fa-solid fa-id-badge mr-1"></i>
                    <span class="text-sm">Daftar</span>
                </h4>
                <span class="bg-sky-600 text-white text-sm px-2 py-1 rounded-lg" id="enrollment_count">0</span>
            </a>
            <a href="#quicksearch_container" onclick="quickSearchStatus('registrasi')"
                class="cursor-pointer flex justify-between items-center px-5 py-3 bg-emerald-500 text-white rounded-xl">
                <h4>
                    <i class="fa-solid fa-user-check mr-1"></i>
                    <span class="text-sm">Registrasi</span>
                </h4>
                <span class="bg-emerald-600 text-white text-sm px-2 py-1 rounded-lg" id="registration_count">0</span>
            </a>
        </div>
        <section>
            <h2 class="font-bold text-gray-900 text-xl">Sumber Informasi</h2>
            <p class="text-sm text-gray-700">Berikut ini adalah <i>Quick Search</i> untuk data dari sumber informasi.</p>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-2 mt-3">
                <a href="#quicksearch_container" onclick="quickSearchSource(8)"
                    class="cursor-pointer flex justify-between items-center px-5 py-3 bg-lp3i-100 hover:bg-lp3i-200 text-white rounded-xl">
                    <h4>
                        <i class="fa-solid fa-database mr-1"></i>
                        <span class="text-sm">Daftar Online</span>
                    </h4>
                </a>
                <a href="#quicksearch_container" onclick="quickSearchSource(10)"
                    class="cursor-pointer flex justify-between items-center px-5 py-3 bg-lp3i-100 hover:bg-lp3i-200 text-white rounded-xl">
                    <h4>
                        <i class="fa-solid fa-database mr-1"></i>
                        <span class="text-sm">Beasiswa</span>
                    </h4>
                </a>
            </div>
        </section>
    </div>
@endif
