<script>
    const getDatabases = async () => {
        await axios.get(apiDashboard)
            .then((res) => {
                document.getElementById('database_count').innerText = parseInt(res.data.database_count)
                    .toLocaleString('id-ID');
                document.getElementById('schoolarship_count').innerText = parseInt(res.data
                    .schoolarship_count).toLocaleString('id-ID');
                document.getElementById('applicant_count').innerText = parseInt(res.data.applicant_count)
                    .toLocaleString('id-ID');
                document.getElementById('enrollment_count').innerText = parseInt(res.data.enrollment_count)
                    .toLocaleString('id-ID');
                document.getElementById('registration_count').innerText = parseInt(res.data
                    .registration_count).toLocaleString('id-ID');
            })
            .catch((err) => {
                console.log(err);
            });
    }

    const updateHistories = async () => {
        try {
            showLoadingAnimation();
            const responseDatabase = await axios.get(apiDashboard);
            const database = responseDatabase.data.database_phone;
            for (let i = 0; i < database.length; i++) {
                let data = {
                    identity: identity,
                    pmb: 2024
                }
                await axios.patch(
                        `https://api.politekniklp3i-tasikmalaya.ac.id/history/update/${database[i].phone}`, data
                    )
                    .then((response) => {
                        console.log(response.data.message);
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
            hideLoadingAnimation();
        } catch (error) {
            console.log(error);
        }
    }

    const getHistories = async () => {
        try {
            showLoadingAnimation();
            const responsePresenters = await axios.get(`get/presenter`);
            const responseDatabase = await axios.get(apiDashboard);
            const presenters = responsePresenters.data.presenters;
            const pmb = document.getElementById('change_pmb').value;

            document.getElementById('phonehistory_total').innerText = responseDatabase.data.database_count
                .toLocaleString('id-ID');
            document.getElementById('phonehistory_valid').innerText = responseDatabase.data.database_phone
                .length.toLocaleString('id-ID');
            document.getElementById('phonehistory_nonvalid').innerText = (responseDatabase.data.database_count -
                responseDatabase.data.database_phone.length).toLocaleString('id-ID');

            let buckets = [];
            for (let i = 0; i < presenters.length; i++) {
                const responseHistories = await axios.get(
                    `https://api.politekniklp3i-tasikmalaya.ac.id/history/detail/${pmb}/${presenters[i].identity}`
                );
                const databasesPhone = responseDatabase.data.database_phone;
                const databasesCount = responseDatabase.data.database_count;
                const databasePhone = databasesPhone.filter((data) => data.identity_user == presenters[i]
                    .identity);
                const histories = responseHistories.data;
                let categoriesBucket = [];
                for (let i = 1; i < 14; i++) {
                    let categoryCount;
                    if (i > 12) {
                        categoryCount = histories.filter((history) => history.category > i);
                    } else {
                        categoryCount = histories.filter((history) => history.category == i);
                    }
                    let percent = (categoryCount.length / databasePhone.length) * 100;
                    categoriesBucket.push({
                        category: categoryCount,
                        percent: percent,
                        databases_count: databasesCount,
                        database_phone: databasePhone.length,
                    });
                }
                let data = {
                    name: presenters[i].name,
                    categories: categoriesBucket
                }
                buckets.push(data);
            }

            let content = '';
            buckets.forEach((bucket) => {
                let contentBucket = '';
                let categoriesBucket = '';
                let categories = bucket.categories;
                if (categories.length > 0) {
                    categories.forEach((category, i) => {
                        categoriesBucket += `
                    <td class="px-6 py-4 text-center ${i % 2 == 0 ? 'bg-white' : 'bg-gray-50'}">
                        <ul class="space-y-1">
                            <li class="font-bold">${category.percent.toFixed()}%</li>
                            <li class="text-xs">${category.category.length}/${category.database_phone}</li>
                            <li class="text-xs">Total: ${category.database_phone} (${category.category.length - category.database_phone})</li>
                            ${category.database_phone > category.category.length - category.database_phone ?
                            `<li onclick="informationText()" class="text-xs cursor-pointer hover:text-sky-600 transition"><i class="fa-solid fa-circle-info"></i>  Informasi</li>` : ''}
                        </ul>
                    </td>`
                    });
                    content += `
                    <tr>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50">
                            ${bucket.name}
                        </td>
                        ${categoriesBucket}
                    </tr>
                `
                } else {
                    content += `
                    <tr>
                        <td colspan="14" class="text-center bg-white text-sm px-6 py-4">Tidak ada data.</td>
                    </tr>
                `
                }
            });
            document.getElementById('history_chat_presenter').innerHTML = content;
            hideLoadingAnimation();
        } catch (error) {
            let content = `
                    <tr>
                        <td colspan="13" class="text-center bg-white text-sm px-6 py-4">${error.message}</td>
                    </tr>
                `
            document.getElementById('history_chat_presenter').innerHTML = content;
        }
    }

    const informationText = () => {
        let message = `Persentase data > 100% mungkin disebabkan oleh:
        1. Pengiriman pesan ke nomor tidak terdaftar.
        2. Penghapusan nomor setelah pengiriman pesan.`;
        alert(message);
    }

    getHistories();
    getDatabases();
</script>
