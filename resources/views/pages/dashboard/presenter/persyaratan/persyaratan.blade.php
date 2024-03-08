<section>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500" id="table-report-persyaratan-aplikan">
            <thead class="text-xs text-gray-700 uppercase" id="headers_fileupload">
                <tr>
                    <th scope="col" class="px-6 py-4 text-center">
                        No
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Gelombang
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Tanggal
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Nama Aplikan
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Asal Sekolah
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Lulusan
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Jenis Kelamin
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        Sumber Database
                    </th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</section>
@include('pages.dashboard.utilities.all')
@include('pages.dashboard.utilities.pmb')
@push('scripts')
    <script>
        let dataTableDataPersyaratanAplikanInitialized = false;
        let dataTableDataPersyaratanAplikanInstance;
        let databasesDataPersyaratanAplikan;
        let urlDataPersyaratanAplikan = `/api/report/database/aplikan/files?pmbVal=${pmbVal}&identityVal=${identityVal}&roleVal=${roleVal}`;
    </script>
    <script>
        const changeFilterDataPersyaratanAplikan = () => {
            showLoadingAnimation();
            let queryParams = [];
            let pmbVal = document.getElementById('change_pmb').value;
            let identityVal = document.getElementById('identity_val').value;
            let roleVal = document.getElementById('role_val').value;

            if (pmbVal !== 'all') {
                queryParams.push(`pmbVal=${pmbVal}`);
            }

            if (identityVal !== 'all') {
                queryParams.push(`identityVal=${identityVal}`);
            }

            if (roleVal !== 'all') {
                queryParams.push(`roleVal=${roleVal}`);
            }

            let queryString = queryParams.join('&');

            urlDataPersyaratanAplikan = `/api/report/database/aplikan/files?${queryString}`;

            if (dataTableDataPersyaratanAplikanInstance) {
                dataTableDataPersyaratanAplikanInstance.destroy();
                getDataTableDataPersyaratanAplikan()
                    .then((response) => {
                        dataTableDataPersyaratanAplikanInstance = $('#table-report-persyaratan-aplikan')
                            .DataTable(response.config);
                        dataTableDataPersyaratanAplikanInitialized = response.initialized;
                        hideLoadingAnimation();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }

        const getDataTableDataPersyaratanAplikan = async () => {
            return new Promise(async (resolve, reject) => {
                try {
                    const responseFiles = await axios.get(urlDataPersyaratanAplikan);
                    const responseFileUploads = responseFiles.data.file_uploads;
                    const responseUsersUpload = responseFiles.data.users_upload;

                    let fileUploadBucket =
                        '<th scope="col" class="px-6 py-4 text-center">No</th><th scope="col" class="px-6 py-4 text-center">Nama Lengkap</th>';
                    responseFileUploads.forEach(file => {
                        fileUploadBucket +=
                            `<th scope="col" class="px-6 py-4 text-center">${file.name}</th>`
                    });

                    document.getElementById('headers_fileupload').innerHTML = fileUploadBucket;

                    let columnConfigs = [{
                        data: 'identity_user',
                        render: (data, type, row, meta) => {
                            return meta.row + 1;
                        },
                    }, {
                        data: {
                            name: 'name',
                            identity_user: 'identity_user'
                        },
                        render: (data, type, row) => {
                            let showUrl = "{{ route('database.show', ':identity') }}"
                                .replace(
                                    ':identity',
                                    data.identity_user);
                            return `<a href="${showUrl}" target="_blank" class="font-bold underline">${data.name}</a>`;
                        },
                    }];

                    responseFileUploads.forEach((fileup) => {
                        columnConfigs.push({
                            data: 'file_uploads',
                            render: (data, type, row) => {
                                return data[fileup.id] == undefined ?
                                    '<i class="fa-solid fa-circle-xmark text-red-500"></i>' :
                                    '<i class="fa-solid fa-circle-check text-green-500"></i>';
                            }
                        });
                    });

                    const groupedData = responseUsersUpload.reduce((result, currentItem) => {
                        const key = currentItem.identity_user;
                        const name = currentItem.userupload ? currentItem.userupload.name :
                            'Tidak diketahui';
                        const pmb = currentItem.applicant.pmb;
                        if (key) {
                            result[key] = result[key] || {
                                pmb: pmb,
                                identity_user: key,
                                name: name,
                                file_uploads: []
                            };

                            result[key].file_uploads[currentItem.fileupload_id] = 1;
                        }
                        return result;
                    }, {});

                    const filteredGroupedData = Object.values(groupedData).filter(item => item
                        .identity_user);

                    filteredGroupedData;

                    const dataTableConfig = {
                        data: filteredGroupedData,
                        columnDefs: [{
                            width: 10,
                            target: 0
                        }],
                        createdRow: (row, data, index) => {
                            if (index % 2 === 0) {
                                $(row).css('background-color', '#f9fafb');
                            }
                        },
                        columns: columnConfigs,
                    }

                    let results = {
                        config: dataTableConfig,
                        initialized: true
                    }

                    resolve(results);
                } catch (error) {
                    reject(error)
                }
            });
        }
    </script>
@endpush
