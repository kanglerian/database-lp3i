@if (Auth::user()->role !== 'S')
    <section class="max-w-7xl px-5 mx-auto">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3 md:bg-gray-50 p-5 md:rounded-3xl md:border border-gray-200">
            <div class="flex justify-between items-center px-5 py-3 bg-lp3i-200 text-white rounded-2xl">
                <h4>
                    <i class="fa-solid fa-database mr-1"></i>
                    <span class="text-sm">Database</span>
                </h4>
                <span class="bg-lp3i-100 text-white text-sm px-2 py-1 rounded-lg" id="database_count">0</span>
            </div>
            <a href="#quicksearch_container" onclick="quickSearchStatus('schoolarship')"
                class="cursor-pointer flex justify-between items-center px-5 py-3 bg-cyan-500 hover:bg-cyan-600 text-white transition rounded-2xl">
                <h4>
                    <i class="fa-solid fa-graduation-cap mr-1"></i>
                    <span class="text-sm">Beasiswa</span>
                </h4>
                <span class="bg-cyan-600 text-white text-sm px-2 py-1 rounded-lg" id="schoolarship_count">0</span>
            </a>
            <a href="#quicksearch_container" onclick="quickSearchStatus('aplikan')"
                class="cursor-pointer flex justify-between items-center px-5 py-3 bg-yellow-500 hover:bg-yellow-600 transition text-white rounded-2xl">
                <h4>
                    <i class="fa-solid fa-file-lines mr-1"></i>
                    <span class="text-sm">Aplikan</span>
                </h4>
                <span class="bg-yellow-600 text-white text-sm px-2 py-1 rounded-lg" id="applicant_count">0</span>
            </a>
            <a href="#quicksearch_container" onclick="quickSearchStatus('daftar')"
                class="cursor-pointer flex justify-between items-center px-5 py-3 bg-sky-500 hover:bg-sky-600 transition text-white rounded-2xl">
                <h4>
                    <i class="fa-solid fa-id-badge mr-1"></i>
                    <span class="text-sm">Daftar</span>
                </h4>
                <span class="bg-sky-600 text-white text-sm px-2 py-1 rounded-lg" id="enrollment_count">0</span>
            </a>
            <a href="#quicksearch_container" onclick="quickSearchStatus('registrasi')"
                class="cursor-pointer flex justify-between items-center px-5 py-3 bg-emerald-500 hover:bg-emerald-600 transition text-white rounded-2xl">
                <h4>
                    <i class="fa-solid fa-user-check mr-1"></i>
                    <span class="text-sm">Registrasi</span>
                </h4>
                <span class="bg-emerald-600 text-white text-sm px-2 py-1 rounded-lg" id="registration_count">0</span>
            </a>
        </div>
    </section>
@endif

@push('scripts')
    <script>
        let apiDashboard = `/get/dashboard/all?identityVal=${identityVal}&roleVal=${roleVal}&pmbVal=${pmbVal}`
    </script>
    <script>
        const changeFilterDatabase = () => {
            let queryParams = [];
            let identityVal = document.getElementById('identity_val').value || 'all';
            let pmbVal = document.getElementById('change_pmb').value || 'all';

            queryParams.push(`identityVal=${identityVal}`);

            if (pmbVal !== 'all') {
                queryParams.push(`pmbVal=${pmbVal}`);
            }

            let queryString = queryParams.join('&');
            apiDashboard = `/get/dashboard/all?${queryString}`;
            getDatabases();
        }
    </script>
    <script>
        const getDatabases = async () => {
            showLoadingAnimation();
            try {
                const response = await axios.get(apiDashboard);
                document.getElementById('database_count').innerText = parseInt(response.data.database_count)
                    .toLocaleString('id-ID');
                document.getElementById('schoolarship_count').innerText = parseInt(response.data
                    .schoolarship_count).toLocaleString('id-ID');
                document.getElementById('applicant_count').innerText = parseInt(response.data.applicant_count)
                    .toLocaleString('id-ID');
                document.getElementById('enrollment_count').innerText = parseInt(response.data.enrollment_count)
                    .toLocaleString('id-ID');
                document.getElementById('registration_count').innerText = parseInt(response.data
                    .registration_count).toLocaleString('id-ID');
            } catch (error) {
                console.log(error);
            }
            hideLoadingAnimation();
        }

        getDatabases();
    </script>
@endpush
