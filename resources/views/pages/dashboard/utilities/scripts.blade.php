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
        let pmbVal = document.getElementById('change_pmb').value;
        let identityVal = document.getElementById('identity_val').value;
        let roleVal = document.getElementById('role_val').value;
        let sessionVal = document.getElementById('session').value;
    </script>
    <script>
        let apiTargets = `/get/targets?identity=${identityVal}&pmbVal=${pmbVal}`;
        let apiDashboard = `/get/dashboard/all?identity=${identityVal}&pmbVal=${pmbVal}`

        let urlSourceDatabaseWilayah =
            `/api/report/database/wilayah/source?pmbVal=${pmbVal}&identityVal=${identityVal}&roleVal=${roleVal}`;
        let urlDatabasePresenter =
            `/api/report/database/presenter/source?pmbVal=${pmbVal}&identityVal=${identityVal}&roleVal=${roleVal}`;
        let urlDatabasePresenterWilayah =
            `/api/report/database/presenter/wilayah?pmbVal=${pmbVal}&identityVal=${identityVal}&roleVal=${roleVal}`;

        let urlDataAplikanAplikan =`/api/report/database/aplikan/aplikan?pmbVal=${pmbVal}&identityVal=${identityVal}&roleVal=${roleVal}&sessionVal=${sessionVal}`;
        let urlDataAplikanDaftar =`/api/report/database/aplikan/daftar?pmbVal=${pmbVal}&identityVal=${identityVal}&roleVal=${roleVal}&sessionVal=${sessionVal}`;
        let urlDataAplikanRegistrasi =`/api/report/database/aplikan/registrasi?pmbVal=${pmbVal}&identityVal=${identityVal}&roleVal=${roleVal}&sessionVal=${sessionVal}`;

        let urlDataPersyaratanAplikan = `/api/report/database/aplikan/files?pmbVal=${pmbVal}&identityVal=${identityVal}&roleVal=${roleVal}`;

        let urlPerolehanPMB = `/api/report/database/perolehanpmb?pmbVal=${pmbVal}&identityVal=${identityVal}&sessionVal=${sessionVal}`;

        let dataTableSourceDatabaseWilayahInitialized = false;
        let dataTableSourceDatabaseWilayahInstance;
        let databasesSourceDatabaseWilayah;

        let dataTableSourceDatabasePresenterInitialized = false;
        let dataTableSourceDatabasePresenterInstance;
        let databasesSourceDatabasePresenter;

        let dataTableSourceDatabaseWilayahPresenterInitialized = false;
        let dataTableSourceDatabaseWilayahPresenterInstance;
        let databasesSourceDatabaseWilayahPresenter;

        let dataTableDataAplikanAplikanInitialized = false;
        let dataTableDataAplikanAplikanInstance;
        let databasesDataAplikanAplikan;

        let dataTableDataAplikanDaftarInitialized = false;
        let dataTableDataAplikanDaftarInstance;
        let databasesDataAplikanDaftar;

        let dataTableDataAplikanRegistrasiInitialized = false;
        let dataTableDataAplikanRegistrasiInstance;
        let databasesDataAplikanRegistrasi;

        let dataTableDataPersyaratanAplikanInitialized = false;
        let dataTableDataPersyaratanAplikanInstance;
        let databasesDataPersyaratanAplikan;
    </script>
@endpush

@push('scripts')
    <script>
        const copyRecord = (number) => {
            const textarea = document.createElement("textarea");
            textarea.value = number;
            textarea.style.position = "fixed";
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand("copy");
            document.body.removeChild(textarea);
            alert('Nomor rekening sudah disalin!');
        }
    </script>
    <script>
        const copyIdentity = (identity) => {
            const textarea = document.createElement("textarea");
            textarea.value = identity;
            textarea.style.position = "fixed";
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand("copy");
            document.body.removeChild(textarea);
            alert('ID sudah disalin!');
        }
    </script>
@endpush
