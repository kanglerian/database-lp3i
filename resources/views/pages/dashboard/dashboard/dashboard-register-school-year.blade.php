<section class="space-y-5 py-10">
    <div class="max-w-7xl px-5 mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center gap-3">
            <div
                class="flex justify-center items-end flex-wrap md:flex-nowrap text-gray-500 md:gap-3 order-2 md:order-none">
                <input type="hidden" id="identity_val" value="{{ Auth::user()->identity }}">
                <input type="hidden" id="role_val" value="{{ Auth::user()->role }}">
                <div class="w-full flex flex-col space-y-1 p-1 md:p-0">
                    <label for="change_pmb" class="text-xs">Periode PMB:</label>
                    <input type="number" id="change_pmb" onchange="changeTrigger()"
                        class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-xl text-gray-800"
                        placeholder="Tahun PMB">
                </div>
            </div>
            <div class="px-4 py-2 rounded-xl text-sm bg-gray-50 border border-gray-200 order-1 md:order-none">
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
    <div class="max-w-7xl px-5 mx-auto space-y-5">
        <section>
            <div>
                <div id="map" class="rounded-3xl border border-gray-300"></div>
            </div>
        </section>
    </div>
</section>
@include('pages.dashboard.utilities.all')
@include('pages.dashboard.utilities.pmb')
@push('scripts')
    <script>
        let urlRegisterSchoolYear =
            `/api/report/database/register/school/year?pmbVal=${pmbVal}&identityVal=${identityVal}&roleVal=${roleVal}`;
    </script>

    <script>
        const changeFilterMapRegisterSchoolYear = () => {
            let queryParams = [];

            let pmbVal = document.getElementById('change_pmb').value;
            let identityVal = document.getElementById('identity_val').value;
            let roleVal = document.getElementById('role_val').value;

            if (pmbVal !== 'all') {
                queryParams.push(`pmbVal=${pmbVal}`);
            }

            if (identityVal !== 'all') {
                queryParams.push(`identityVal=${identityVal}`);
            }

            if (roleVal !== 'all') {
                queryParams.push(`roleVal=${roleVal}`);
            }

            let queryString = queryParams.join('&');

            urlRegisterSchoolYear = `/api/report/database/register/school/year?${queryString}`;
        }

        const getMapRegisterSchoolYear = async () => {
            const response = await axios.get(urlRegisterSchoolYear);
            let registers = response.data;

            const reducedData = registers.reduce((accumulator, currentValue) => {
                const existingItem = accumulator.find(item => item.name === currentValue
                    .name);

                pmbVal = document.getElementById('change_pmb').value;

                if (existingItem) {
                    let years = [];
                    for (let i = 0; i < 5; i++) {
                        years.push(parseInt(pmbVal) - i)
                    }
                    years.forEach(year => {
                        const existingYear = existingItem.register.find((
                            entry) => entry.year == year);
                        if (existingYear.year == currentValue.year) {
                            existingYear.count += parseInt(currentValue
                                .register)
                        }
                    });
                } else {
                    const record = {
                        identity_user: currentValue.identity_user,
                        name: currentValue.name,
                        lat: currentValue.lat,
                        lng: currentValue.lng,
                        pmb: currentValue.pmb,
                        register: []
                    };

                    let years = [];
                    for (let i = 0; i < 5; i++) {
                        years.push(parseInt(pmbVal) - i)
                    }
                    years.forEach(year => {
                        if (year == currentValue.year) {
                            record.register.push({
                                year: year,
                                count: parseInt(currentValue.register)
                            });
                        } else {
                            record.register.push({
                                year: year,
                                count: 0
                            });
                        }
                    });

                    accumulator.push(record);
                }

                return accumulator;
            }, []);

            const map = L.map('map').setView([-6.618, 107.282], 8);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://politekniklp3i-tasikmalaya.ac.id">Politeknik LP3I Kampus Tasikmalaya</a>'
            }).addTo(map);

            reducedData.forEach((result) => {
                console.log(result);
                const lat = result.lat ?? -6.618;
                const lng = result.lng ?? 107.282;
                const marker = L.marker([lat, lng]).addTo(map);
                const dataRegist = result.register;
                let resultRegist = '';
                dataRegist.forEach((data) => {
                    resultRegist += `
                                  <li>${data.year}: ${data.count}</li>
                              `
                });
                const paragraph = `
                          <b>${result.name}</b>
                          <hr style="margin: 5px 0px"/>
                          <ul>${resultRegist}</ul>`
                marker.bindPopup(paragraph).openPopup();

                const circle = L.circle([lat, lng], {
                    color: 'red',
                    fillColor: '#f03',
                    fillOpacity: 0.5,
                    radius: 80
                }).addTo(map);
            });
        }
    </script>

    <script>
        const changeTrigger = () => {
            changeFilterMapRegisterSchoolYear()
        }
    </script>
@endpush
