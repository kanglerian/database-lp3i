<script src="{{ asset('js/axios.min.js') }}"></script>
<script>
    let pmbVal = document.getElementById('change_pmb').value;

    let urlSourceDatabaseWilayah = `api/report/database/wilayah/source?pmbVal=${pmbVal}`;
    let urlDatabasePresenter = `api/report/database/presenter/source?pmbVal=${pmbVal}`;
    let urlDatabasePresenterWilayah = `api/report/database/presenter/wilayah?pmbVal=${pmbVal}`;

    let dataTableSourceDatabaseWilayahInitialized = false;
    let dataTableSourceDatabaseWilayahInstance;
    let databasesSourceDatabaseWilayah;

    let dataTableSourceDatabasePresenterInitialized = false;
    let dataTableSourceDatabasePresenterInstance;
    let databasesSourceDatabasePresenter;

    let dataTableSourceDatabaseWilayahPresenterInitialized = false;
    let dataTableSourceDatabaseWilayahPresenterInstance;
    let databasesSourceDatabaseWilayahPresenter;
</script>
