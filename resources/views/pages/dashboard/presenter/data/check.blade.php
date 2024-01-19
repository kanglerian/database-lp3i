@push('scripts')
    <script>
        const getFiles = async () => {
            try {
                const responseFiles = await axios.get('/api/report/database/aplikan/files');
                const responseFileUploads = responseFiles.data.file_uploads;
                const responseUsersUpload = responseFiles.data.users_upload;

                for (let i = 0; i < responseFileUploads.length; i++) {
                    let users = [];
                    responseUsersUpload.forEach(upload => {
                        users.push({
                            id: responseFileUploads[i].id,
                            users: upload.identity_user
                        });
                    });
                    console.log(users);
                }

            } catch (error) {
                console.log(error);
            }
        }
        getFiles();
    </script>
@endpush
