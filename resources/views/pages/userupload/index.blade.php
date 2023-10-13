<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight py-2">
                {{ __('Berkas PMB Online') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div id="info" class="hidden mx-2 mb-4 flex items-center p-4 mb-4 bg-red-500 text-white rounded-lg"
                role="alert">

            </div>
            {{-- @if (session('error'))
                <div id="alert" class="mx-2 mb-4 flex items-center p-4 mb-4 bg-red-500 text-white rounded-lg"
                    role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('error') }}
                    </div>
                </div>
            @endif --}}
            {{-- @if (session('message'))
                <div id="alert" class="mx-2 mb-4 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-lg"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            @if ($errors->first('berkas'))
                <div id="alert" class="mx-2 mb-4 flex items-center p-4 mb-4 bg-red-500 text-white rounded-lg"
                    role="alert">
                    <i class="fa-solid fa-circle-xmark"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ $errors->first('berkas') }}
                    </div>
                </div>
            @endif --}}
            <div class="bg-white overflow-hidden border md:rounded-xl">
                <div class="p-6 bg-white border-b border-gray-200">
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
                                    <tr class="bg-white border-b flex justify-between items-center">
                                        <td class="w-[300px] md:w-full px-6 py-4">{{ $suc->fileupload->name }}</td>
                                        <td class="w-1/2 md:w-1/3 px-6 py-4">
                                            <button
                                                class="inline-block bg-green-500 hover:bg-green-600 px-3 py-1 rounded-md text-xs text-white"><i
                                                    class="fa-solid fa-circle-check"></i></button>
                                            <a href="https://api.politekniklp3i-tasikmalaya.ac.id/pmbonline/download?identity={{ $suc->identity_user }}&filename={{ $suc->identity_user }}-{{ $suc->fileupload->namefile }}.{{ $suc->typefile }}"
                                                class="bg-sky-500 px-3 py-1 rounded-md text-xs text-white""><i
                                                    class="fa-solid fa-download"></i></a>
                                            <button
                                                onclick="event.preventDefault(); deleteBerkas('{{ $suc->id }}','{{ $suc->fileupload->namefile }}', '{{ $suc->typefile }}', '{{ $suc->identity_user }}')"
                                                class="inline-block bg-red-500 hover:bg-red-600 px-3 py-1 rounded-md text-xs text-white">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                                @foreach ($fileupload as $upload)
                                    <tr class="bg-white border-b flex justify-between items-center">
                                        <td class="w-[300px] md:w-full px-6 py-4">{{ $upload->name }}</td>
                                        <td class="loading-form w-1/2 md:w-1/3 px-6 py-4" colspan="2">
                                            <form action="javascript:void(0)" enctype="multipart/form-data"
                                                class="upload-form inline-block" id="form-{{ $upload->namefile }}" method="POST">
                                                @csrf
                                                <div>
                                                    <input type="hidden" name="fileupload_id"
                                                        value="{{ $upload->id }}">
                                                    <input type="hidden" name="namefile"
                                                        value="{{ $upload->namefile }}">
                                                    <input type="file" name="berkas"
                                                        id="berkas-{{ $upload->namefile }}" class="text-sm"
                                                        accept="{{ $upload->accept }}" style="width:95px">
                                                    <button
                                                        onclick="uploadBerkas('{{ $upload->id }}','{{ $upload->namefile }}','{{ $identity }}')"
                                                        class="inline-block bg-sky-500 hover:bg-sky-600 px-3 py-1 rounded-md text-xs text-white">
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
        const uploadBerkas = (id, namefile, identity) => {
            let inputElement = document.getElementById(`berkas-${namefile}`);
            let uploadForm = document.querySelector('.upload-form');
            let loadingForm = document.querySelector('.loading-form');
            let loadingElement = document.createElement('p');

            loadingElement.textContent = 'Loading...';
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

                    await axios.post(`https://api.politekniklp3i-tasikmalaya.ac.id/pmbonline/upload`, data)
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
                await axios.delete(`https://api.politekniklp3i-tasikmalaya.ac.id/pmbonline/delete`, {
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
                                if (response.status == 'success') {
                                    location.reload();
                                } else {
                                    console.log('Ada kesalahan dalam permintaan.');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(error);
                            }
                        })
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
