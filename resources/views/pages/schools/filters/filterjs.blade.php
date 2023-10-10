<script>
    var urlData = 'get/schools';

    var dataTableInitialized = false;
    var dataTableInstance;

    var dataSchools;

    const getAPI = () => {
        showLoadingAnimation();
        fetch(urlData)
            .then(response => {
                hideLoadingAnimation();
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const count = data.schools.length;
                dataSchools = data.schools;
                document.getElementById('count_filter').innerText = count;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    const changeFilter = () => {
        showLoadingAnimation();

        let queryParams = [];

        let regionCheck = document.getElementById('change_region').value || 'all';

        if (regionCheck !== 'all') {
            queryParams.push(`regionCheck=${regionCheck}`);
        }

        let queryString = queryParams.join('&');

        urlData = `get/schools?${queryString}`;

        if (dataTableInitialized) {
            dataTableInstance.ajax.url(urlData).load();
            hideLoadingAnimation();
            getAPI();
        } else {
            getDataTable();
        }
    }

    const resetFilter = () => {
        urlData = `get/schools`;
        urlExcel = 'applicants/export';
        if (dataTableInitialized) {
            dataTableInstance.ajax.url(urlData).load();
            hideLoadingAnimation();
            getAPI();
            document.getElementById('change_region').value = 'all';
        } else {
            getDataTable();
        }
    }
</script>

<script>
    const showLoadingAnimation = () => {
        document.getElementById('data-loading').style.display = 'block';
    }

    const hideLoadingAnimation = () => {
        document.getElementById('data-loading').style.display = 'none';
    }
</script>
