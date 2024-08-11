<section class="space-y-5 py-10">
    <header class="px-6 pt-5 space-y-1 text-center">
        <h1 class="flex flex-col text-xl items-center gap-2 font-bold text-gray-700">
            <span>Peta Sebaran Registrasi Berdasarkan Sekolah dan Tahun Lulus</span>
        </h1>
        <p class="text-gray-600 text-sm">Berikut ini adalah registrasi berdasarkan sekolah dan tahun lulus 5 tahun terakhir.</p>
    </header>
    <div class="max-w-7xl px-5 mx-auto space-y-5">
        <section>
            <div>
                <div id="map" class="rounded-3xl border border-gray-300"></div>
            </div>
        </section>
    </div>
</section>
@push('scripts')
    <script>
        let urlRegisterSchoolYear = `/api/report/database/register/school/year`;
        let map = L.map('map').setView([-6.618, 107.282], 8);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://politekniklp3i-tasikmalaya.ac.id">Politeknik LP3I Kampus Tasikmalaya</a>'
        }).addTo(map);
    </script>

    <script>
        const changeFilterMapRegisterSchoolYear = () => {
            getMapRegisterSchoolYear();
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

            reducedData.forEach((result) => {
                const lat = result.lat ?? -6.618;
                const lng = result.lng ?? 107.282;
                const marker = L.marker([lat, lng]).addTo(map);
                const dataRegist = result.register;
                let resultRegist = '';
                dataRegist.forEach((data) => {
                    resultRegist += `<li>${data.year}: ${data.count} orang</li>`
                });
                const paragraph = `<b>${result.name}</b><hr style="margin: 5px 0px"/><ul>${resultRegist}</ul>`
                marker.bindPopup(paragraph).openPopup();

                const circle = L.circle([lat, lng], {
                    color: 'red',
                    fillColor: '#f03',
                    fillOpacity: 0.5,
                    radius: 80
                }).addTo(map);
            });
        }
        getMapRegisterSchoolYear();
    </script>
@endpush
