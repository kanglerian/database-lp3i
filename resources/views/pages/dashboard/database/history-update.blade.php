<script>
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
                        `https://history-chat.politekniklp3i-tasikmalaya.ac.id/update/${database[i].phone}`,
                        data, {
                            headers: {
                                'lp3i-api-key': '8137cd04674735e5',
                            },
                        })
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
</script>
