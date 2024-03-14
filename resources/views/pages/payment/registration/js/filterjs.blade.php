<script>
    const getYearPMB = () => {
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear();
        const currentMonth = currentDate.getMonth();
        const startYear = currentMonth >= 9 ? currentYear + 1 : currentYear;
        document.getElementById('change_pmb').value = startYear;
    }
    getYearPMB();
</script>
<script>
    var urlData = 'get/registrations';

    var dataTableInitialized = false;
    var dataTableInstance;

    var dataRegistrations;

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
                const count = data.registrations.length;
                dataRegistrations = data.registrations;
                document.getElementById('count_filter').innerText = count.toLocaleString();
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    const changeFilter = () => {
        showLoadingAnimation();
        let queryParams = [];
        let date = document.getElementById('date').value || 'all';
        let pmbVal = document.getElementById('change_pmb').value || 'all';
        let sessionVal = document.getElementById('session').value || 'all';
        let percentVal = document.getElementById('percent').value || 'all';

        if (date !== 'all') {
            queryParams.push(`date=${date}`);
        }
        if (pmbVal !== 'all') {
            queryParams.push(`pmbVal=${pmbVal}`);
        }
        if (sessionVal !== 'all') {
            queryParams.push(`sessionVal=${sessionVal}`);
        }
        if (percentVal !== 'all') {
            queryParams.push(`percentVal=${percentVal}`);
        }

        let queryString = queryParams.join('&');

        urlData = `get/registrations?${queryString}`;

        if (dataTableInitialized) {
            dataTableInstance.ajax.url(urlData).load();
            hideLoadingAnimation();
            getAPI();
        } else {
            getDataTable();
        }
    }

    const resetFilter = () => {
        urlData = `get/registrations`;
        if (dataTableInitialized) {
            dataTableInstance.ajax.url(urlData).load();
            hideLoadingAnimation();
            getAPI();
            document.getElementById('date').value = '';
            document.getElementById('change_pmb').value = '';
            document.getElementById('session').value = '';
            document.getElementById('percent').value = '';
        } else {
            getDataTable();
        }
    }
</script>
