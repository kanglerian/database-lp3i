@if (Auth::user()->role == 'P')
    <section class="max-w-7xl px-5 mx-auto">
        <div class="bg-gray-50 p-8 rounded-3xl border border-gray-200">
            <header class="space-y-1">
                <h2 class="font-bold text-gray-900 text-xl">Informasi Target Perolehan</h2>
                <p class="text-sm text-gray-700">Berikut ini adalah data target perolehan mahasiswa baru.</p>
            </header>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-3">
                <div class="flex justify-between items-center px-5 py-3 bg-sky-500 text-white rounded-2xl">
                    <h4>
                        <i class="fa-solid fa-bullseye mr-1"></i>
                        <span class="text-sm">Total Target</span>
                    </h4>
                    <span class="bg-sky-600 text-white text-sm px-2 py-1 rounded-lg" id="target_count">0</span>
                </div>
                <div class="flex justify-between items-center px-5 py-3 bg-emerald-500 text-white rounded-2xl">
                    <h4>
                        <i class="fa-solid fa-person-circle-check mr-1"></i>
                        <span class="text-sm">Registrasi</span>
                    </h4>
                    <span class="bg-emerald-600 text-white text-sm px-2 py-1 rounded-lg" id="register_count">0</span>
                </div>
                <div id="container-animate"
                    class="relative flex justify-between items-center px-5 py-3 bg-red-500 text-white rounded-2xl">
                    <h4>
                        <i class="fa-solid fa-person-circle-xmark mr-1"></i>
                        <span class="text-sm">Sisa Target</span>
                    </h4>
                    <span class="bg-red-600 text-white text-sm px-2 py-1 rounded-lg" id="result_count">0</span>
                    <div class="hidden absolute top-[-60px] right-0" id="animate">
                        <dotlottie-player src="{{ asset('animations/win.lottie') }}" background="transparent"
                            speed="1" style="width: 150px; height: 150px" direction="1" mode="normal" loop
                            autoplay></dotlottie-player>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script>
            let apiTargets = `/get/targets?identityVal=${identityVal}&pmbVal=${pmbVal}`;
        </script>
        <script>
            const changeFilterTarget = () => {
                let queryParams = [];
                let identity = document.getElementById('identity_val').value;
                let pmbVal = document.getElementById('change_pmb').value || 'all';

                queryParams.push(`identity=${identity}`);

                if (pmbVal !== 'all') {
                    queryParams.push(`pmbVal=${pmbVal}`);
                }

                let queryString = queryParams.join('&');

                apiTargets = `/get/targets?${queryString}`;
                getRegistrations();
            }
        </script>
        <script>
            const getRegistrations = async () => {
                await axios.get(apiTargets)
                    .then((res) => {
                        let dataTargets = res.data.targets;
                        let targets = 0;
                        let registers = res.data.registrations.length;
                        dataTargets.forEach(data => {
                            targets += parseInt(data.total);
                        });
                        document.getElementById('register_count').innerText = registers;
                        document.getElementById('target_count').innerText = targets;
                        document.getElementById('result_count').innerText = targets - registers;
                        if (targets - registers <= 0) {
                            document.getElementById('animate').classList.remove('hidden');
                            document.getElementById('container-animate').classList.remove('bg-red-500');
                            document.getElementById('container-animate').classList.add('bg-yellow-500');
                            document.getElementById('result_count').classList.remove('bg-red-600');
                            document.getElementById('result_count').classList.add('bg-yellow-600');
                        } else {
                            document.getElementById('animate').classList.add('hidden');
                            document.getElementById('container-animate').classList.remove('bg-yellow-500');
                            document.getElementById('container-animate').classList.add('bg-red-500');
                            document.getElementById('result_count').classList.add('bg-red-600');
                            document.getElementById('result_count').classList.remove('bg-yellow-600');
                        }
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            }
            getRegistrations();
        </script>
    @endpush
@endif
