@push('scripts')
    <script>
        const changeTrigger = () => {
            // changeFilterDataAplikanAplikan(),
            // changeFilterDataAplikanDaftar(),
            // changeFilterDataAplikanRegistrasi(),
            changeFilterDataPersyaratanAplikan()
        }
    </script>
    <script>
        const promiseDataAplikan = () => {
            showLoadingAnimation();
            Promise.all([
                    getDataTableDataAplikanAplikan(),
                    getDataTableDataAplikanDaftar(),
                    getDataTableDataAplikanRegistrasi(),
                    getDataTableDataPersyaratanAplikan(),
                ])
                .then((response) => {
                    let responseDTDAA = response[0];
                    let responseDTDAD = response[1];
                    let responseDTDAR = response[2];
                    let responseDTDPA = response[3];

                    dataTableDataAplikanAplikanInstance = $('#table-report-data-aplikan').DataTable(responseDTDAA.config);
                    dataTableDataAplikanAplikanInitialized = responseDTDAA.initialized;
                    dataTableDataAplikanDaftarInstance = $('#table-report-data-daftar').DataTable(responseDTDAD.config);
                    dataTableDataAplikanDaftarInitialized = responseDTDAD.initialized;
                    dataTableDataAplikanRegistrasiInstance = $('#table-report-data-registrasi').DataTable(responseDTDAR.config);
                    dataTableDataAplikanRegistrasiInitialized = responseDTDAR.initialized;

                    dataTableDataPersyaratanAplikanInstance = $('#table-report-persyaratan-aplikan').DataTable(responseDTDPA.config);
                    dataTableDataPersyaratanAplikanInitialized = responseDTDPA.initialized;
                    hideLoadingAnimation();
                })
                .catch((error) => {
                    console.log(error);
                    hideLoadingAnimation();
                });
        }
        promiseDataAplikan();
    </script>
@endpush
