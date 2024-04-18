<div class="max-w-7xl px-5 mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <section>
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr class="bg-emerald-500 border-b-4 border-emerald-600">
                            <th colspan="3" class="text-white px-6 py-3 text-center uppercase text-sm rounded-t-3xl">
                                <i class="fa-solid fa-coins mr-1"></i> Sales Revenue
                            </th>
                        </tr>
                        <tr class="bg-emerald-500 text-white">
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
                        <tr class="bg-emerald-500 text-white">
                            <td class="px-6 py-4 rounded-bl-3xl" id="target_revenue">
                                Rp0
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap" id="realization_revenue">
                                Rp0
                            </td>
                            <td class="px-6 py-4 rounded-br-3xl" id="percent_revenue">
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
                        <tr class="bg-red-500 border-b-4 border-red-600">
                            <th colspan="3" class="text-white px-6 py-3 text-center uppercase text-sm rounded-t-3xl">
                                <i class="fa-solid fa-users mr-1"></i> Sales Volume
                            </th>
                        </tr>
                        <tr class="bg-red-500 text-white">
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
                        <tr class="bg-red-500 text-white">
                            <td class="px-6 py-4 rounded-bl-3xl" id="target_volume">
                                0
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap" id="realization_volume">
                                0
                            </td>
                            <td class="px-6 py-4 rounded-br-3xl" id="percent_volume">
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
                        <tr class="bg-sky-500 border-b-4 border-sky-600">
                            <th colspan="3" class="text-white px-6 py-3 text-center uppercase text-sm rounded-t-3xl">
                                <i class="fa-solid fa-database mr-1"></i> Database
                            </th>
                        </tr>
                        <tr class="bg-sky-500 text-white">
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
                        <tr class="bg-sky-500 text-white">
                            <td class="px-6 py-4 rounded-bl-3xl" id="target_database">
                                0
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap" id="realization_database">
                                0
                            </td>
                            <td class="px-6 py-4 rounded-br-3xl" id="percent_database">
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
            getDataSales();
        }

        const getDataSales = async () => {
            await axios.get(urlSales)
                .then((response) => {
                    let sales = response.data.sales;
                    let databases = response.data.databases;

                    let totalTargetDatabase = 0;
                    let totalRealizationDatabase = 0;

                    let totalTargetRevenue = 0;
                    let totalRealizationRevenue = 0;

                    let totalTargetVolume = 0;
                    let totalRealizationVolume = 0;

                    databases.forEach(database => {
                        totalTargetDatabase += parseInt(database.total);
                        totalRealizationDatabase += parseInt(database.realization);
                    });

                    sales.forEach(sales => {
                        totalTargetRevenue += parseInt(sales.target_revenue);
                        totalRealizationRevenue += parseInt(sales.realization_revenue);
                        totalTargetVolume += parseInt(sales.target_volume);
                        totalRealizationVolume += parseInt(sales.realization_volume);
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

                    document.getElementById('target_database').innerText = totalTargetDatabase;
                    document.getElementById('realization_database').innerText = totalRealizationDatabase;
                    document.getElementById('percent_database').innerText =
                        `${(totalRealizationDatabase / totalTargetDatabase * 100).toFixed()}%`;
                })
                .catch((error) => {
                    console.log(error);
                });
        }

        getDataSales();
    </script>
@endpush
