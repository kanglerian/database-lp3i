<script>
    const changeFilterDatabase = () => {
        let queryParams = [];
        let identityVal = document.getElementById('identity').value || 'all';
        let pmbVal = document.getElementById('change_pmb').value || 'all';
        queryParams.push(`identity=${identity}`);
        if (pmbVal !== 'all') {
            queryParams.push(`pmbVal=${pmbVal}`);
        }
        let queryString = queryParams.join('&');
        apiDashboard = `get/dashboard/all?${queryString}`;
        getDatabases();
    }
</script>
