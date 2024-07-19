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
                await axios.patch(`${URL_API_LP3I}/history/update/${database[i].phone}`, data)
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
