<script>
    const getDatabases = async () => {
        await axios.get(apiDashboard)
            .then((res) => {
                document.getElementById('database_count').innerText = parseInt(res.data.database_count).toLocaleString('id-ID');
                document.getElementById('schoolarship_count').innerText = parseInt(res.data.schoolarship_count).toLocaleString('id-ID');
                document.getElementById('applicant_count').innerText = parseInt(res.data.applicant_count).toLocaleString('id-ID');
                document.getElementById('enrollment_count').innerText = parseInt(res.data.enrollment_count).toLocaleString('id-ID');
                document.getElementById('registration_count').innerText = parseInt(res.data.registration_count).toLocaleString('id-ID');
            })
            .catch((err) => {
                console.log(err);
            });
    }
    getDatabases();
</script>
