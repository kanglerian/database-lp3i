<div class="max-w-7xl px-5 mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 bg-gray-100 p-8 rounded-3xl border border-gray-200">
        <section>
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr class="bg-emerald-500 border-b border-gray-200 rounded-3xl">
                            <th colspan="3" class="text-white px-6 py-3 text-center uppercase text-sm rounded-t-2xl">
                                <i class="fa-solid fa-coins mr-1"></i> Sales Revenue
                            </th>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Target
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Realisasi
                            </th>
                            <th scope="col" class="px-6 py-3">
                                %
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white">
                            <td class="px-6 py-4 rounded-bl-2xl" id="target_revenue">
                                Rp0
                            </td>
                            <td class="px-6 py-4 text-gray-900 whitespace-nowrap" id="realization_revenue">
                                Rp0
                            </td>
                            <td class="px-6 py-4 rounded-br-2xl" id="percent_revenue">
                                0%
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <section>
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr class="bg-red-500 border-b border-gray-200">
                            <th colspan="3" class="text-white px-6 py-3 text-center uppercase text-sm rounded-t-2xl">
                                <i class="fa-solid fa-users mr-1"></i> Sales Volume
                            </th>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Target
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Realisasi
                            </th>
                            <th scope="col" class="px-6 py-3">
                                %
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white">
                            <td class="px-6 py-4 rounded-bl-2xl" id="target_volume">
                                0
                            </td>
                            <td class="px-6 py-4 text-gray-900 whitespace-nowrap" id="realization_volume">
                                0
                            </td>
                            <td class="px-6 py-4 rounded-br-2xl" id="percent_volume">
                                0%
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <section>
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr class="bg-sky-500 border-b border-gray-200">
                            <th colspan="3" class="text-white px-6 py-3 text-center uppercase text-sm rounded-t-2xl">
                                <i class="fa-solid fa-database mr-1"></i> Database
                            </th>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Target
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Realisasi
                            </th>
                            <th scope="col" class="px-6 py-3">
                                %
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white">
                            <td class="px-6 py-4 rounded-bl-2xl">
                                0
                            </td>
                            <td class="px-6 py-4 text-gray-900 whitespace-nowrap">
                                0
                            </td>
                            <td class="px-6 py-4 rounded-br-2xl">
                                0%
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

@push('scripts')
    <script>
        let urlSales = `/api/dashboard/sales?pmbVal=${pmbVal}&identityVal=${identityVal}&roleVal=${roleVal}`

        const changeDataSales = () => {
            let identityVal = document.getElementById('identity_val').value;
            let pmbVal = document.getElementById('change_pmb').value || 'all';
            let roleVal = document.getElementById('role_val').value || 'all';
            urlSales = `/api/dashboard/sales?pmbVal=${pmbVal}&identityVal=${identityVal}&roleVal=${roleVal}`
            console.log(urlSales);
            getDataSales();
        }

        const getDataSales = async () => {
            await axios.get(urlSales)
                .then((response) => {
                    let databases = response.data.databases;

                    let totalTargetRevenue = 0;
                    let totalRealizationRevenue = 0;

                    let totalTargetVolume = 0;
                    let totalRealizationVolume = 0;

                    databases.forEach(database => {
                        totalTargetRevenue += parseInt(database.target_revenue);
                        totalRealizationRevenue += parseInt(database.realization_revenue);
                        totalTargetVolume += parseInt(database.target_volume);
                        totalRealizationVolume += parseInt(database.realization_volume);
                    });

                    document.getElementById('target_revenue').innerText =
                        `Rp${totalTargetRevenue.toLocaleString('id-ID')}`;
                    document.getElementById('realization_revenue').innerText =
                        `Rp${totalRealizationRevenue.toLocaleString('id-ID')}`;
                    document.getElementById('percent_revenue').innerText =
                        `${(totalRealizationRevenue / totalTargetRevenue * 100).toFixed()}%`;


                    document.getElementById('target_volume').innerText = totalTargetVolume;
                    document.getElementById('realization_volume').innerText = totalRealizationVolume;
                    document.getElementById('percent_volume').innerText =
                        `${(totalRealizationVolume / totalTargetVolume * 100).toFixed()}%`;
                })
                .catch((error) => {
                    console.log(error);
                });
        }

        getDataSales();
    </script>
@endpush
