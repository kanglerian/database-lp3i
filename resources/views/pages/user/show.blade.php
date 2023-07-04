<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-semibold text-md text-gray-800 leading-tight">
                Berkas PMB Online ({{ $user->name }})
            </h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5 px-2">
        <a href="{{ route('user.index') }}"
            class="inline-block border border-gray-400 hover:bg-gray-400 hover:text-white text-gray-500 px-4 py-2 rounded-lg text-sm"><i
                class="fa-solid fa-arrow-left"></i> Kembali</a>
    </div>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    <section>
                        <header>
                            <h2 class="text-xl font-bold text-gray-900">
                                Daftar Riwayat Hidup
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Mahasiswa orangtua/wali mahasiswa Politeknik LP3I Kampus Tasikmalaya.
                            </p>
                        </header>
                        <hr class="my-3">
                        <section class="space-y-5">
                            <div class="space-y-1">
                                <h2 class="text-lg font-bold text-gray-900">Biodata Mahasiswa</h2>
                                <ul class="text-sm space-y-1 text-gray-800">
                                    <li class="space-x-2">
                                        <span>Nama Lengkap:</span>
                                        <span class="border-b">{{ $applicant->name == null ? '___' : $applicant->name }}</span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Program Studi:</span>
                                        <span class="border-b">{{ $applicant->program == null ? '___' : $applicant->program }}</span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Tempat / Tanggal Lahir:</span>
                                        <span class="border-b">
                                            {{ $applicant->place_of_birth == null ? '___' : $applicant->place_of_birth }}
                                            /
                                            {{ $applicant->date_of_birth == null ? '___' : $applicant->date_of_birth }}
                                    </li>
                                    <li class="space-x-2">
                                        <span>Pendidikan Terakhir:</span>
                                        <span class="border-b">
                                            {{ $applicant->school == null ? '___' : $applicant->school }}
                                        </span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Alamat:</span>
                                        <span class="border-b">
                                            {{ $applicant->address == null ? '___' : $applicant->address }}
                                        </span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>No. Telpon:</span>
                                        <span class="border-b">
                                            {{ $applicant->phone == null ? '___' : $applicant->phone }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="space-y-1">
                                <h2 class="text-lg font-bold text-gray-900">Biodata Ayah</h2>
                                <ul class="text-sm space-y-1 text-gray-800">
                                    <li class="space-x-2">
                                        <span>Nama Lengkap:</span>
                                        <span class="border-b">{{ $applicant->father_name == null ? '___' : $applicant->father_name }}</span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Program Studi:</span>
                                        <span class="border-b">{{ $applicant->program == null ? '___' : $applicant->program }}</span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Tempat / Tanggal Lahir:</span>
                                        <span class="border-b">
                                            {{ $applicant->place_of_birth == null ? '___' : $applicant->place_of_birth }}
                                            /
                                            {{ $applicant->date_of_birth == null ? '___' : $applicant->date_of_birth }}
                                    </li>
                                    <li class="space-x-2">
                                        <span>Pendidikan Terakhir:</span>
                                        <span class="border-b">
                                            {{ $applicant->school == null ? '___' : $applicant->school }}
                                        </span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Alamat:</span>
                                        <span class="border-b">
                                            {{ $applicant->address == null ? '___' : $applicant->address }}
                                        </span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>No. Telpon:</span>
                                        <span class="border-b">
                                            {{ $applicant->phone == null ? '___' : $applicant->phone }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </section>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">
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
            <div class="bg-white overflow-hidden border md:rounded-xl">
                <div class="p-6 bg-white border-b border-gray-200 space-y-5">
                    <header>
                        <h2 class="text-lg font-bold text-gray-900">
                            Berkas {{ $user->name }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Tabel di bawah ini berisi berkas yang diunggah oleh pemilik akun.
                        </p>
                    </header>
                    <div class="relative overflow-x-auto md:rounded-xl">
                        <table class="w-full text-sm text-sm text-left text-gray-500">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                                        <td class="px-6 py-4">{{ $suc->name }}</td>
                                        <td class="px-6 py-4">
                                            <a href="http://localhost:3033/download/{{ $suc->identity_user }}/{{ $suc->identity_user }}-{{ $suc->namefile }}.{{ $suc->typefile }}"
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
    </div>
</x-app-layout>

<script>
    const deleteRecord = (id) => {
        if (confirm('Apakah kamu yakin akan menghapus data?')) {
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
                    alert('Error deleting record');
                }
            })
        }
    }
</script>
