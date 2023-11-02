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
    var urlData = 'get/enrollments';

    var dataTableInitialized = false;
    var dataTableInstance;

    var dataEnrollments;

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
                const count = data.enrollments.length;
                dataEnrollments = data.enrollments;
                document.getElementById('count_filter').innerText = count;
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
        let repaymentVal = document.getElementById('repayment').value || 'all';
        let registerVal = document.getElementById('register').value || 'all';
        let registerEndVal = document.getElementById('register_end').value || 'all';

        if (date !== 'all') {
            queryParams.push(`date=${date}`);
        }
        if (pmbVal !== 'all') {
            queryParams.push(`pmbVal=${pmbVal}`);
        }
        if (repaymentVal !== 'all') {
            queryParams.push(`repaymentVal=${repaymentVal}`);
        }
        if (registerVal !== 'all') {
            queryParams.push(`registerVal=${registerVal}`);
        }
        if (registerEndVal !== 'all') {
            queryParams.push(`registerEndVal=${registerEndVal}`);
        }

        let queryString = queryParams.join('&');

        urlData = `get/enrollments?${queryString}`;

        if (dataTableInitialized) {
            dataTableInstance.ajax.url(urlData).load();
            hideLoadingAnimation();
            getAPI();
        } else {
            getDataTable();
        }
    }

    const resetFilter = () => {
        urlData = `get/enrollments`;
        if (dataTableInitialized) {
            dataTableInstance.ajax.url(urlData).load();
            hideLoadingAnimation();
            getAPI();
            document.getElementById('date').value = '';
            document.getElementById('change_pmb').value = '';
            document.getElementById('repayment').value = '';
            document.getElementById('register').value = '';
            document.getElementById('register_end').value = '';
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
