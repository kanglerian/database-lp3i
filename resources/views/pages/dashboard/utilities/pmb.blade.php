@push('utilities')
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
        let pmbVal = document.getElementById('change_pmb').value;
    </script>
@endpush
