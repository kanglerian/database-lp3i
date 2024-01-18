@push('scripts')
    <script>
        const changeTrigger = () => {
            changeFilterDatabasePresenter();
            changeFilterDatabasePresenterWilayah();
        }
    </script>
    <script>
        const promiseRekapitulasi = () => {
            showLoadingAnimation();
            Promise.all([
                    getDataTableDatabasePresenter(),
                    getDataTableDatabasePresenterWilayah(),
                ])
                .then((response) => {
                    const responseDTDP = response[0];
                    const responseDTDPW = response[1];

                    dataTableSourceDatabasePresenterInstance = $('#table-database-presenter').DataTable(responseDTDP
                        .config);
                    dataTableSourceDatabasePresenterInitialized = responseDTDP.initialized;

                    dataTableSourceDatabaseWilayahPresenterInstance = $('#table-database-presenter-wilayah')
                        .DataTable(responseDTDPW.config);
                    dataTableSourceDatabaseWilayahPresenterInitialized = responseDTDPW.initialized;

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
