<script>
    
</script>
<script>

    const resetFilter = () => {
        urlData = `get/databases`;
        urlExcel = 'applicants/export';
        if (dataTableInitialized) {
            dataTableInstance.ajax.url(urlData).load();
            hideLoadingAnimation();
            getAPI();
            document.getElementById('date_start').value = '';
            document.getElementById('date_end').value = '';
            document.getElementById('year_grad').value = '';
            document.getElementById('school').value = '';
            document.getElementById('birthday').value = '';
            document.getElementById('change_pmb').value = '';
            document.getElementById('change_achievement').value = '';
            document.getElementById('change_relation').value = '';
            document.getElementById('change_phone').value = 'all';
            document.getElementById('change_kip').value = 'all';
            document.getElementById('change_plan').value = 'all';
            document.getElementById('change_come').value = 'all';
            document.getElementById('change_income').value = 'all';
            document.getElementById('change_follow').value = 'all';
            document.getElementById('change_source').value = 'all';
            document.getElementById('change_source_daftar').value = 'all';
            document.getElementById('change_status').value = 'all';
            document.getElementById('change_applicant').value = 'all';
        } else {
            getDataTable();
        }
    }
</script>
