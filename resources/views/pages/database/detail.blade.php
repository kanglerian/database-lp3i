<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight py-2">
                Berkas PMB Online ({{ $user->name }})
            </h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5 px-2">
        <a href="{{ route('database.index') }}"
            class="inline-block border border-gray-400 hover:bg-gray-400 hover:text-white text-gray-500 px-4 py-2 rounded-lg text-sm"><i
                class="fa-solid fa-arrow-left"></i> Kembali</a>
    </div>

    <div class="max-w-7xl mx-auto flex flex-col md:flex-row py-4 sm:px-6 lg:px-8 gap-5">
        <div class="w-full md:w-4/6 mx-auto space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    <section>
                        <header class="flex md:justify-between flex-col md:flex-row items-start md:items-center gap-3">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">
                                    Daftar Riwayat Hidup
                                </h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    Mahasiswa orangtua/wali mahasiswa Politeknik LP3I Kampus Tasikmalaya.
                                </p>
                            </div>
                            <a href="{{ route('database.print', $user->identity) }}" class="text-white bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 text-center"><i class="fa-solid fa-print"></i> Print</a>
                        </header>
                        <hr class="my-3">
                        <section class="space-y-5">
                            <div class="space-y-1">
                                <h2 class="text-lg font-bold text-gray-900">Biodata Mahasiswa</h2>
                                <ul class="text-sm space-y-1 text-gray-800">
                                    <li class="space-x-2">
                                        <span>Nama Lengkap:</span>
                                        <span
                                            class="border-b">{{ $user->name == null ? '___' : $user->name }}</span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Program Studi:</span>
                                        <span
                                            class="border-b">{{ $user->program == null ? '___' : $user->program }}</span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Tempat / Tanggal Lahir:</span>
                                        <span class="border-b">
                                            {{ $user->place_of_birth == null ? '___' : $user->place_of_birth }}
                                            /
                                            {{ $user->date_of_birth == null ? '___' : $user->date_of_birth }}
                                    </li>
                                    <li class="space-x-2">
                                        <span>Pendidikan Terakhir:</span>
                                        <span class="border-b">
                                            {{ $user->SchoolApplicant->name == null ? '___' : $user->SchoolApplicant->name }}
                                        </span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Alamat:</span>
                                        <span class="border-b">
                                            {{ $user->address == null ? '___' : $user->address }}
                                        </span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>No. Telpon:</span>
                                        <span class="border-b">
                                            {{ $user->phone == null ? '___' : $user->phone }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="space-y-1">
                                <h2 class="text-lg font-bold text-gray-900">Biodata Ayah</h2>
                                <ul class="text-sm space-y-1 text-gray-800">
                                    <li class="space-x-2">
                                        <span>Nama Lengkap:</span>
                                        <span
                                            class="border-b">{{ $father->name == null ? '___' : $father->name }}</span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Pekerjaan:</span>
                                        <span class="border-b">{{ $father->job == null ? '___' : $father->job }}</span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Tempat / Tanggal Lahir:</span>
                                        <span class="border-b">
                                            {{ $father->place_of_birth == null ? '___' : $father->place_of_birth }}
                                            /
                                            {{ $father->date_of_birth == null ? '___' : $father->date_of_birth }}
                                    </li>
                                    <li class="space-x-2">
                                        <span>Pendidikan Terakhir:</span>
                                        <span class="border-b">
                                            {{ $father->education == null ? '___' : $father->education }}
                                        </span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Alamat:</span>
                                        <span class="border-b">
                                            {{ $father->address == null ? '___' : $father->address }}
                                        </span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>No. Telpon:</span>
                                        <span class="border-b">
                                            {{ $father->phone == null ? '___' : $father->phone }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="space-y-1">
                                <h2 class="text-lg font-bold text-gray-900">Biodata Ibu</h2>
                                <ul class="text-sm space-y-1 text-gray-800">
                                    <li class="space-x-2">
                                        <span>Nama Lengkap:</span>
                                        <span
                                            class="border-b">{{ $mother->name == null ? '___' : $mother->name }}</span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Pekerjaan:</span>
                                        <span class="border-b">{{ $mother->job == null ? '___' : $mother->job }}</span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Tempat / Tanggal Lahir:</span>
                                        <span class="border-b">
                                            {{ $mother->place_of_birth == null ? '___' : $mother->place_of_birth }}
                                            /
                                            {{ $mother->date_of_birth == null ? '___' : $mother->date_of_birth }}
                                    </li>
                                    <li class="space-x-2">
                                        <span>Pendidikan Terakhir:</span>
                                        <span class="border-b">
                                            {{ $mother->education == null ? '___' : $mother->education }}
                                        </span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Alamat:</span>
                                        <span class="border-b">
                                            {{ $mother->address == null ? '___' : $mother->address }}
                                        </span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>No. Telpon:</span>
                                        <span class="border-b">
                                            {{ $mother->phone == null ? '___' : $mother->phone }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </section>
                    </section>
                </div>
            </div>
        </div>

        <div class="w-full md:w-2/6 mx-auto space-y-5">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @if (session('error'))
                    <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-red-500 text-white rounded-lg"
                        role="alert">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <div class="ml-3 text-sm font-medium">
                            {{ session('error') }}
                        </div>
                    </div>
                @endif
                @if (session('message'))
                    <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-lg"
                        role="alert">
                        <i class="fa-solid fa-circle-check"></i>
                        <div class="ml-3 text-sm font-medium">
                            {{ session('message') }}
                        </div>
                    </div>
                @endif
                @if ($errors->first('berkas'))
                    <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-red-500 text-white rounded-lg"
                        role="alert">
                        <i class="fa-solid fa-circle-xmark"></i>
                        <div class="ml-3 text-sm font-medium">
                            {{ $errors->first('berkas') }}
                        </div>
                    </div>
                @endif
                <header>
                    <h2 class="text-lg font-bold text-gray-900">
                        Berkas {{ $user->name }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Tabel di bawah ini berisi berkas yang diunggah oleh pemilik akun.
                    </p>
                </header>
                <hr class="my-3">
                <div class="relative overflow-x-auto md:rounded-xl">
                    <table class="w-full text-sm text-sm text-left text-gray-500">
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr class="flex justify-between items-center">
                                <th scope="col" class="px-6 py-3 rounded-t-lg">
                                    Nama Berkas
                                </th>
                                <th scope="col" class="px-6 py-3 rounded-t-lg">
                                    Aksi
                                </th>
                        </thead>
                        <tbody>
                            @foreach ($userupload as $suc)
                                <tr class="bg-white border-b flex justify-between items-center">
                                    <td class="px-6 py-4">{{ $suc->fileupload->name }}</td>
                                    <td class="px-6 py-4">
                                        <a href="https://api.politekniklp3i-tasikmalaya.ac.id/pmbonline/download?identity={{ $suc->identity_user }}&filename={{ $suc->identity_user }}-{{ $suc->fileupload->namefile }}.{{ $suc->typefile }}"
                                            class="bg-sky-500 px-3 py-1 rounded-md text-xs text-white""><i
                                                class="fa-solid fa-download"></i></a>
                                        <button
                                            class="inline-block bg-green-500 hover:bg-green-600 px-3 py-1 rounded-md text-xs text-white"><i
                                                class="fa-solid fa-circle-check"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                            @foreach ($fileupload as $upload)
                                <tr class="bg-white border-b flex justify-between items-center">
                                    <td class="px-6 py-4">{{ $upload->name }}</td>
                                    <td class="px-6 py-4">
                                        <button
                                            class="inline-block bg-red-500 hover:bg-red-600 px-3 py-1 rounded-md text-xs text-white"><i
                                                class="fa-solid fa-circle-xmark"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script>
    const deleteRecord = (id) => {
        if (confirm(`Apakah kamu yakin akan menghapus data? ${id}`)) {
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
                    alert(status);
                }
            })
        }
    }
</script>
