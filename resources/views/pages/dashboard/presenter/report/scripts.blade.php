@push('scripts')
    <script>
        const promiseRekapitulasi = () => {
            showLoadingAnimation();
            Promise.all([
                getDataTableDatabaseSchool(),
                ])
                .then((response) => {
                    let responseDTDS = response[0];
                    dataTableSourceDatabaseWilayahInstance = $('#table-source-database-wilayah').DataTable(
                        responseDTDS.config);
                    dataTableSourceDatabaseWilayahInitialized = responseDTDS.initialized;
                    hideLoadingAnimation();
                })
                .catch((error) => {
                    console.log(error);
                    hideLoadingAnimation();
                });
        }
        promiseRekapitulasi();
    </script>
@endpush
