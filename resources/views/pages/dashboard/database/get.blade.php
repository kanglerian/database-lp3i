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

    const getHistories = async () => {
        try {
            const responseHistories = await axios.get(`http://localhost:4004/detail/${pmb}/${identity}`);
            const responseDatabase = await axios.get(apiDashboard);
            const histories = responseHistories.data;
            const database = responseDatabase.data;

            for (let i = 1; i < 13; i++) {
                let category = histories.filter((history) => history.category == i);
                let percent = (category.length / database.databasePhone.length) * 100;
                document.getElementById(`category_${i}`).innerText =
                    `Kategori ${i}: ${category.length} (${percent.toFixed()}%)`;
            }

        } catch (error) {
            console.log(error);
        }
    }

    getHistories();

    getDatabases();
</script>
