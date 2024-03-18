<script>
    let identity = document.getElementById('identity_val').value;
    let pmb = document.getElementById('change_pmb').value;
    var urlData = `/api/target/volume/getvolumes?identityVal=${identity}&pmbVal=${pmb}`;
    var dataTableInitialized = false;
    var dataTableInstance;

    var dataTargets;

    const getAPI = () => {
        showLoadingAnimation();
        fetch(urlData)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                hideLoadingAnimation();
                return response.json();
            })
            .then(data => {
                const count = data.targets.length;
                dataTargets = data.targets;
                document.getElementById('count_filter').innerText = count.toLocaleString();
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    const changeFilter = () => {
        showLoadingAnimation();
        let queryParams = [];
        let identity = document.getElementById('identity_val').value;
        let dateVal = document.getElementById('date').value || 'all';
        let pmbVal = document.getElementById('change_pmb').value || 'all';
        let sessionVal = document.getElementById('session').value || 'all';

        queryParams.push(`identityVal=${identity}`);

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

        urlData = `/api/target/volume/getvolumes?${queryString}`;

        getRegistrations();
        if (dataTableInitialized) {
            dataTableInstance.ajax.url(urlData).load();
            hideLoadingAnimation();
            getAPI();
        } else {
            getDataTable();
        }
    }

    const resetFilter = () => {
        urlData = `/api/target/volume/getvolumes`;
        if (dataTableInitialized) {
            dataTableInstance.ajax.url(urlData).load();
            hideLoadingAnimation();
            getAPI();
            document.getElementById('date').value = '';
            document.getElementById('change_pmb').value = '';
            document.getElementById('session').value = '';
        } else {
            getDataTable();
        }
    }
</script>
