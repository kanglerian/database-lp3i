@push('scripts')
<script>
    const checkServer = async () => {
        await axios.get(`${URL_API_LP3I}/history`)
            .then((response) => {
                if (response.status == 200) {
                    $('#content').show();
                    $('#forbidden').hide();
                }
            })
            .catch((error) => {
                $('#content').hide();
                $('#forbidden').show();
            });
    }
    checkServer();

    const modalFunction = (type, id, date, title, result, report) => {
        let modalChat = document.getElementById('modalChat');
        switch (type) {
            case 'add':
                document.getElementById('title_form').innerText = `Tambah Data Riwayat`;
                document.getElementById('formButton').innerText = 'Simpan';
                document.getElementById('id').value = '';
                document.getElementById('title').value = '';
                document.getElementById('date').value = '';
                document.getElementById('result').value = '';
                document.getElementById('report').value = '';
                break;
            case 'update':
                document.getElementById('id').value = id;
                document.getElementById('title').value = title;
                document.getElementById('date').value = date;
                document.getElementById('result').value = result;
                document.getElementById('report').value = report;
                document.getElementById('title_form').innerText = `Ubah Data Riwayat`;
                document.getElementById('formButton').innerText = 'Simpan Perubahan';
                break;
        }
        modalChat.classList.toggle('hidden');
    }

    const saveHistory = async () => {
        const title = document.getElementById('title').value;
        const date = document.getElementById('date').value;
        const result = document.getElementById('result').value;
        const report = document.getElementById('report').value;
        const phone = document.getElementById('phone').getAttribute('data-phone');

        let type = document.getElementById('formButton').innerText;

        const formData = {
            title,
            date,
            result,
            report,
            phone,
        };

        switch (type) {
            case 'Simpan':
                await axios.post(`${URL_API_LP3I}/history/store`, formData)
                    .then((res) => {
                        alert('Berhasil disimpan!');
                        location.reload();
                    })
                    .catch((err) => {
                        console.log(err.message);
                    });
                break;
            case 'Simpan Perubahan':
                const id = document.getElementById('id').value;
                await axios.post(`${URL_API_LP3I}/history/update/${id}`, formData)
                    .then((res) => {
                        alert('Berhasil diupdate!');
                        location.reload();
                    })
                    .catch((err) => {
                        console.log(err.message);
                    });
                break;
        }
        console.log(formData);
    }

    const deleteChat = async (id) => {
        let confirmed = confirm('Apakah yakin akan dihapus?');
        if (confirmed) {
            await axios.post(`${URL_API_LP3I}/history/delete/${id}`)
                .then((res) => {
                    alert('Berhasil dihapus!');
                    location.reload();
                })
                .catch((err) => {
                    console.log(err.message);
                });
        }
    }

    const getChats = async () => {
        let phone = document.getElementById('phone').getAttribute('data-phone');
        if (phone) {
            let bucket = '';
            await axios.get(`${URL_API_LP3I}/history/phone/${phone}`)
                .then((response) => {
                    let histories = response.data;
                    if (histories.length > 0) {
                        histories.forEach(history => {
                            bucket += `
                                <li class="mb-10 ml-4">
                                    <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white">
                                    </div>
                                    <div class="flex gap-5 mb-2">
                                        <time
                                            class="mb-1 text-sm font-normal leading-none text-gray-400">${history.date}</time>
                                        <div class="flex gap-3">
                                            <button type="button" onclick="modalFunction('update', '${history.id}', '${history.date}', '${history.title}', '${history.result}', '${history.report}')" class="text-xs text-gray-600 hover:text-yellow-600"><i
                                                    class="fa-regular fa-pen-to-square"></i></button>
                                            <button type="button" onclick="deleteChat('${history.id}')"
                                                class="text-xs text-gray-600 hover:text-red-600"><i
                                                    class="fa-regular fa-trash-can"></i></button>
                                        </div>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900">${history.title}</h3>
                                    <p class="mb-4 text-sm font-normal text-gray-500">${history.result}
                                    <p class="mb-4 text-sm font-normal text-gray-500"><span class="font-bold">Hasil:</span> ${history.report == null ? 'Belum diisi' : history.report}
                                    </p>
                                </li>`
                        });
                        document.getElementById('histories').innerHTML = bucket;
                    } else {
                        bucket += `
                            <li class="mb-10 ml-4">
                                <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white">
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Data riwayat belum ada</h3>
                                <p class="mb-4 text-base font-normal text-gray-500">Silahkan untuk isi
                                        riwayat melalui tombol tambah data.</p>
                            </li>
                            `
                        document.getElementById('histories').innerHTML = bucket;
                    }
                })
                .catch((error) => {
                    console.log(error);
                    bucket += `
                            <p class="mb-4 text-base font-normal text-gray-500">${error.message}</p>
                            `
                    document.getElementById('histories').innerHTML = bucket;
                });
        } else {
            console.log('Nomor telepon tidak ditemukan.');
        }
    }
    getChats();
</script>
@endpush
