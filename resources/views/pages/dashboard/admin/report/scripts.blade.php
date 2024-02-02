@push('scripts')
    <script>
        const changeTrigger = () => {
            changeFilterSourceDatabasePresenterWilayah();
            changeFilterSourceDatabasePresenter();
        }
    </script>
    <script>
        const promiseRekapitulasi = () => {
            showLoadingAnimation();
            Promise.all([
                    getDataTableSourceDatabasePresenter(),
                    getDataTableSourceDatabasePresenterWilayah(),
                ])
                .then((response) => {
                    let responseDTSDP = response[0];
                    let responseDTSDPW = response[1];

                    dataTableSourceDatabasePresenterInstance = $('#table-database-presenter').DataTable(responseDTSDP
                        .config);
                    dataTableSourceDatabasePresenterInitialized = responseDTSDP.initialized;

                    dataTableSourceDatabaseWilayahPresenterInstance = $('#table-database-presenter-wilayah')
                        .DataTable(responseDTSDPW
                            .config);
                    dataTableSourceDatabaseWilayahPresenterInitialized = responseDTSDPW.initialized;

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
