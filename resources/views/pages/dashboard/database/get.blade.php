<script>
    const getDatabases = async () => {
        await axios.get(apiDashboard)
            .then((res) => {
                document.getElementById('database_count').innerText = parseInt(res.data.database_count).toLocaleString('id-ID');
                document.getElementById('schoolarship_count').innerText = parseInt(res.data.database_count).toLocaleString('id-ID')res.data.schoolarship_count;
                document.getElementById('applicant_count').innerText = res.data.applicant_count;
                document.getElementById('enrollment_count').innerText = res.data.enrollment_count;
                document.getElementById('registration_count').innerText = res.data.registration_count;
            })
            .catch((err) => {
                console.log(err);
            });
    }
    getDatabases();
</script>
