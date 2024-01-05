<script>
    const changeFilterDatabase = () => {
        let queryParams = [];
        let identityVal = document.getElementById('identity').value || 'all';
        let pmbVal = document.getElementById('change_pmb').value || 'all';
        let sessionVal = document.getElementById('session').value || 'all';

        queryParams.push(`identity=${identity}`);

        if (pmbVal !== 'all') {
            queryParams.push(`pmbVal=${pmbVal}`);
        }
        if (sessionVal !== 'all') {
            queryParams.push(`sessionVal=${sessionVal}`);
        }
        
        let queryString = queryParams.join('&');
        apiDashboard = `get/dashboard/all?${queryString}`;
        getDatabases();
    }
</script>
