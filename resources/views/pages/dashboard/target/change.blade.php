<script>
    const changeFilterTarget = () => {
        let queryParams = [];
        let identity = document.getElementById('identity').value;
        let dateVal = document.getElementById('date').value || 'all';
        let pmbVal = document.getElementById('change_pmb').value || 'all';
        let sessionVal = document.getElementById('session').value || 'all';

        queryParams.push(`identity=${identity}`);

        if (dateVal !== 'all') {
            queryParams.push(`dateVal=${dateVal}`);
        }

        if (pmbVal !== 'all') {
            queryParams.push(`pmbVal=${pmbVal}`);
        }

        if (sessionVal !== 'all') {
            queryParams.push(`sessionVal=${sessionVal}`);
        }

        let queryString = queryParams.join('&');

        apiTargets = `/get/targets?${queryString}`;
        getRegistrations();
    }
</script>
