<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center h-10">
            <h2 class="font-bold text-xl text-gray-800 leading-tight py-2">
                {{ __('Berkas PMB Online') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div id="info" class="hidden mx-2 mb-4 flex items-center p-4 mb-4 bg-red-500 text-white rounded-xl" role="alert"></div>
            <div class="overflow-hidden border border-gray-200 rounded-3xl">
                <div class="p-8 bg-gray-50 border-b border-gray-200">
                    <div class="relative overflow-x-auto md:rounded-xl">
                        <table class="w-full text-sm text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr class="flex justify-between items-center">
                                    <th scope="col" class="w-[300px] md:w-full px-6 py-3 rounded-t-lg">
                                        Nama Berkas
                                    </th>
                                    <th scope="col" class="w-1/2 md:w-1/3 px-6 py-3 rounded-t-lg">
                                        Action
                                    </th>
                            </thead>
                            <tbody>
                                @foreach ($userupload as $suc)
                                    <tr class="bg-gray-50 border-b flex justify-between items-center">
                                        <td class="w-[300px] md:w-full px-6 py-4">{{ $suc->fileupload->name }}</td>
                                        <td class="w-1/2 md:w-1/3 px-6 py-4">
                                            <button
                                                class="inline-block bg-green-500 hover:bg-green-600 px-3 py-1 rounded-md text-xs text-white"><i
                                                    class="fa-solid fa-circle-check"></i></button>
                                            <a href="{{ env('API_LP3I') }}/pmbonline/download?identity={{ $suc->identity_user }}&filename={{ $suc->identity_user }}-{{ $suc->fileupload->namefile }}.{{ $suc->typefile }}"
                                                class="bg-sky-500 px-3 py-1 rounded-md text-xs text-white""><i
                                                    class="fa-solid fa-download"></i></a>
                                            @if (!$applicant->is_register)
                                                <button
                                                    onclick="event.preventDefault(); deleteBerkas('{{ $suc->id }}','{{ $suc->fileupload->namefile }}', '{{ $suc->typefile }}', '{{ $suc->identity_user }}')"
                                                    class="inline-block bg-red-500 hover:bg-red-600 px-3 py-1 rounded-md text-xs text-white">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                @foreach ($fileupload as $upload)
                                    <tr class="bg-gray-50 border-b flex justify-between items-center">
                                        <td class="w-[300px] md:w-full px-6 py-4">{{ $upload->name }}</td>
                                        <td class="loading-form w-1/2 md:w-1/3 px-6 py-4" colspan="2"
                                            id="loading-form-{{ $upload->namefile }}">
                                            <form action="javascript:void(0)" enctype="multipart/form-data"
                                                class="inline-block" id="form-{{ $upload->namefile }}" method="POST">
                                                @csrf
                                                <div>
                                                    <input type="hidden" name="fileupload_id"
                                                        value="{{ $upload->id }}">
                                                    <input type="hidden" name="namefile"
                                                        value="{{ $upload->namefile }}">
                                                    <input type="file" name="berkas"
                                                        onchange="notifButton('{{ $upload->namefile }}')"
                                                        id="berkas-{{ $upload->namefile }}" class="text-sm"
                                                        accept="{{ $upload->accept }}">
                                                    <button id="button-{{ $upload->namefile }}"
                                                        onclick="uploadBerkas('{{ $upload->id }}','{{ $upload->namefile }}','{{ $identity }}')"
                                                        class="hidden inline-block bg-sky-500 hover:bg-sky-600 px-3 py-1 rounded-md text-xs text-white">
                                                        <i class="fa-solid fa-upload"></i>
                                                    </button>
                                                </div>
                                                <small>Maks: 1MB</small>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script>
        const notifButton = (namefile) => {
            let inputElement = document.getElementById(`berkas-${namefile}`);
            let buttonElement = document.getElementById(`button-${namefile}`);

            if (inputElement.files.length > 0) {
                buttonElement.classList.remove('hidden');
            } else {
                buttonElement.classList.add('hidden');
            }
        }
        const uploadBerkas = (id, namefile, identity) => {
            let inputElement = document.getElementById(`berkas-${namefile}`);
            let buttonElement = document.getElementById(`button-${namefile}`);

            inputElement.addEventListener('change', function() {
                if (inputElement.files.length > 0) {
                    buttonElement.classList.remove('hidden');
                } else {
                    newButton.classList.add('hidden');
                }
            });

            let uploadForm = document.getElementById(`form-${namefile}`);
            let loadingForm = document.getElementById(`loading-form-${namefile}`);
            let loadingElement = document.createElement('div');
            loadingElement.innerHTML = `
                <div role="status">
                    <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
            `;

            uploadForm.style.display = 'none';
            loadingForm.appendChild(loadingElement);

            let berkas = inputElement.files[0];

            if (berkas) {
                const reader = new FileReader();
                reader.onload = async (event) => {
                    let data = {
                        identity: identity,
                        image: event.target.result.split(';base64,').pop(),
                        namefile: namefile,
                        typefile: berkas.name.split('.').pop(),
                    }

                    let status = {
                        fileupload_id: id,
                        typefile: berkas.name.split('.').pop(),
                    }

                    await axios.post(`${URL_API_LP3I}/pmbonline/upload`, data)
                        .then((res) => {
                            alert('Berhasil diupload!');
                            loadingForm.removeChild(loadingElement);
                            uploadForm.style.display = 'block';
                            $.ajax({
                                url: `/userupload`,
                                type: 'POST',
                                data: {
                                    data: status,
                                    '_token': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    if (response.status == 'success') {
                                        location.reload();
                                    } else {
                                        console.log('Ada kesalahan dalam permintaan.');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    location.reload();
                                }
                            })
                            console.log(res.data);
                        })
                        .catch((err) => {
                            let bucket =
                                `<i class="fa-solid fa-circle-exclamation"></i>
                            <div class="ml-3 text-sm font-medium">
                                Maaf, server sedang tidak berfungsi saat ini. Harap hubungi administrator untuk informasi lebih lanjut.
                            </div>`
                            let info = document.getElementById('info');
                            info.classList.remove('hidden');
                            info.innerHTML = bucket;
                        });
                };

                reader.readAsDataURL(berkas);
            }
        }

        const deleteBerkas = async (id, namefile, typefile, identity) => {
            if (confirm(`Apakah kamu yakin akan menghapus data?`)) {
                var data = {
                    identity: identity,
                    namefile: namefile,
                    typefile: typefile,
                }
                await axios.delete(`${URL_API_LP3I}/pmbonline/delete`, {
                        params: data
                    })
                    .then((res) => {
                        alert('Berhasil dihapus!');
                        $.ajax({
                            url: `/userupload/${id}`,
                            type: 'POST',
                            data: {
                                '_method': 'DELETE',
                                '_token': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                location.reload();
                            },
                            error: function(xhr, status, error) {
                                console.log(error);
                            }
                        });


                    })
                    .catch((err) => {
                        let bucket =
                            `<i class="fa-solid fa-circle-exclamation"></i>
                            <div class="ml-3 text-sm font-medium">
                                Maaf, server sedang tidak berfungsi saat ini. Harap hubungi administrator untuk informasi lebih lanjut.
                            </div>`
                        let info = document.getElementById('info');
                        info.classList.remove('hidden');
                        info.innerHTML = bucket;
                    });

            }
        }
    </script>

</x-app-layout>
