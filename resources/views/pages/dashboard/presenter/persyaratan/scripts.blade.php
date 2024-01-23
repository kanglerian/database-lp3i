@push('scripts')
    <script>
        const changeTrigger = () => {
            changeFilterDataPersyaratanAplikan()
        }
    </script>
    <script>
        const promiseDataPersyaratanAplikan = () => {
            showLoadingAnimation();
            Promise.all([
                    getDataTableDataPersyaratanAplikan(),
                ])
                .then((response) => {
                    let responseDTDPA = response[0];
                    dataTableDataPersyaratanAplikanInstance = $('#table-report-persyaratan-aplikan').DataTable(responseDTDPA.config);
                    dataTableDataPersyaratanAplikanInitialized = responseDTDPA.initialized;
                    hideLoadingAnimation();
                })
                .catch((error) => {
                    console.log(error);
                    hideLoadingAnimation();
                });
        }
        promiseDataPersyaratanAplikan();
    </script>
@endpush
