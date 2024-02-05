@push('scripts')
    <script>
        const changeTrigger = () => {
            changeFilterDataAplikanAplikan(),
            changeFilterDataAplikanDaftar(),
            changeFilterDataAplikanRegistrasi()
        }
    </script>
    <script>
        const promiseDataAplikan = () => {
            showLoadingAnimation();
            Promise.all([
                    getDataTableDataAplikanAplikan(),
                    getDataTableDataAplikanDaftar(),
                    getDataTableDataAplikanRegistrasi(),
                ])
                .then((response) => {
                    let responseDTDAA = response[0];
                    let responseDTDAD = response[1];
                    let responseDTDAR = response[2];

                    dataTableDataAplikanAplikanInstance = $('#table-report-data-aplikan').DataTable(responseDTDAA.config);
                    dataTableDataAplikanAplikanInitialized = responseDTDAA.initialized;
                    dataTableDataAplikanDaftarInstance = $('#table-report-data-daftar').DataTable(responseDTDAD.config);
                    dataTableDataAplikanDaftarInitialized = responseDTDAD.initialized;
                    dataTableDataAplikanRegistrasiInstance = $('#table-report-data-registrasi').DataTable(responseDTDAR.config);
                    dataTableDataAplikanRegistrasiInitialized = responseDTDAR.initialized;
                    hideLoadingAnimation();
                })
                .catch((error) => {
                    hideLoadingAnimation();
                });
        }
        promiseDataAplikan();
    </script>
@endpush
