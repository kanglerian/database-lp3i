<script>
    let identity = document.getElementById('identity_val').value;
    let pmb = document.getElementById('change_pmb').value;
    var urlData = `/api/target/volume/getdatabases?identityVal=${identity}&pmbVal=${pmb}`;
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
        let pmbVal = document.getElementById('change_pmb').value || 'all';

        queryParams.push(`identityVal=${identity}`);

        if (pmbVal !== 'all') {
            queryParams.push(`pmbVal=${pmbVal}`);
        }d

        let queryString = queryParams.join('&');

        urlData = `/api/target/volume/getdatabases?${queryString}`;

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
        urlData = `/api/target/volume/getdatabases`;
        if (dataTableInitialized) {
            dataTableInstance.ajax.url(urlData).load();
            hideLoadingAnimation();
            getAPI();
            document.getElementById('change_pmb').value = '';
        } else {
            getDataTable();
        }
    }
</script>
