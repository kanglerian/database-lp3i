<input id="identity_user_val" type="hidden" value="{{ Auth::user()->identity }}">
<input id="role_val" type="hidden" value="{{ Auth::user()->role }}">
<script src="{{ asset('js/axios.min.js') }}"></script>
<script>
    let pmbVal = document.getElementById('change_pmb').value;
    let identityUserVal = document.getElementById('identity_user_val').value;
    let roleVal = document.getElementById('role_val').value;

    let urlSourceDatabaseWilayah = `api/report/database/wilayah/source?pmbVal=${pmbVal}&identityUserVal=${identityUserVal}&roleVal=${roleVal}`;
    let urlDatabasePresenter = `api/report/database/presenter/source?pmbVal=${pmbVal}&identityUserVal=${identityUserVal}&roleVal=${roleVal}`;
    let urlDatabasePresenterWilayah = `api/report/database/presenter/wilayah?pmbVal=${pmbVal}&identityUserVal=${identityUserVal}&roleVal=${roleVal}`;

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
