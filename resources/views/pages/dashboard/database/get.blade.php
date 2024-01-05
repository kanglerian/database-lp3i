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
            const responseDatabase = await axios.get(apiDashboard);
            const database = responseDatabase.data.databasePhone;

            for (let i = 0; i < database.length; i++) {
                let data = {
                    identity: identity,
                    pmb: 2024
                }
                await axios.patch(`http://localhost:4004/update/${database[i].phone}`, data)
                    .then((response) => {
                        console.log(response.data.message);
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }

        } catch (error) {
            console.log(error);
        }
    }

    const showData = async (i) => {
        try {
            const responseHistories = await axios.get(`http://localhost:4004/detail/${pmb}/${identity}`);
            const responseDatabase = await axios.get(apiDashboard);
            const histories = responseHistories.data;
            const database = responseDatabase.data.databasePhone;


            const data = histories.filter((history) => history.category == i);

            document.getElementById('count-quicksearch').innerText = parseInt(data.length).toLocaleString(
                'id-ID');

            const manualColumns = [{
                data: 'id',
                render: (data, type, row, meta) => {
                    return meta.row + 1;
                }
            }, {
                data: 'pmb',
                render: (data, type, row, meta) => {
                    return data;
                }
            }, {
                data: {
                    name: 'name',
                    identity: 'identity',
                    identity_user: 'identity_user'
                },
                render: (data, type, row, meta) => {
                    let editUrl = "{{ route('database.show', ':identity') }}".replace(
                        ':identity',
                        data.identity);
                    if (data.identity_user == identity || identity == '6281313608558') {
                        return `<a href="${editUrl}" class="font-bold underline">${data.name}</a>`
                    } else {
                        return `<span>${data.name}</span>`;
                    }
                }
            }, {
                data: 'presenter',
                render: (data) => {
                    return typeof(data) == 'object' ? data.name : 'Tidak diketahui';
                }
            }, {
                data: 'source_setting',
                render: (data, type, row) => {
                    return 'oey';
                }
            }, {
                data: 'school_applicant',
                render: (data) => {
                    return data == null ? 'Tidak diketahui' : 'Tidak diketahui';
                }
            }, {
                data: 'year',
                render: (data, row) => {
                    return data != null ? data : 'Tidak diketahui';
                }
            }];

            const dataTableConfig = {
                columns: manualColumns,
                data: data,
            }

            if (dataTableInitialized) {
                dataTableInstance.destroy();
            }

            dataTableInstance = new DataTable('#quickSearchTable', dataTableConfig);

            dataTableInitialized = true;

        } catch (error) {
            console.log(error);
        }
    };

    const getHistories = async () => {
        try {
            const responseHistories = await axios.get(`http://localhost:4004/detail/${pmb}/${identity}`);
            const responseDatabase = await axios.get(apiDashboard);
            const histories = responseHistories.data;
            const database = responseDatabase.data;

            for (let i = 1; i < 13; i++) {

                let category = histories.filter((history) => history.category == i);
                let percent = (category.length / database.databasePhone.length) * 100;

                document.getElementById(`category_${i}`).innerHTML =
                    `<p>Kategori ${i}: <button onclick="showData('${i}');">${category.length} (${percent.toFixed()}%)</button></p>`;
            }


            let percentDatabase = database.databasePhone.length / database.database_count * 100;
            document.getElementById('database').innerText = `Database: ${database.database_count}`
            document.getElementById('database_phone').innerText =
                `Database Phone: ${database.databasePhone.length} (${percentDatabase.toFixed()}%)`
            document.getElementById('database_nophone').innerText =
                `Database No Phone: ${database.database_count - database.databasePhone.length}`

        } catch (error) {
            console.log(error);
        }
    }

    getHistories();

    getDatabases();
</script>
