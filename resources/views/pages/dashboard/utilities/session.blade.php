@push('utilities')
    <script>
        const getSessionPMB = () => {
            const currentDate = new Date();
            const currentMonth = currentDate.getMonth() + 1;
            let session = 'all';
            if (currentMonth >= 1 && currentMonth <= 3) {
                session = 2;
            } else if (currentMonth >= 4 && currentMonth <= 6) {
                session = 3;
            } else if (currentMonth >= 7 && currentMonth <= 9) {
                session = 4;
            } else if (currentMonth >= 10 && currentMonth <= 12) {
                session = 1;
            }
            document.getElementById('session').value = session;
        }

        getSessionPMB();
    </script>
    <script>
        let sessionVal = document.getElementById('session').value;
    </script>
@endpush
