<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-5">
            <a href="#" class="inline-flex items-center px-1 pt-1 border-b-2 border-lp3i-100 text-sm font-medium leading-8 text-gray-900 focus:outline-none focus:border-lp3i-300 transition duration-150 ease-in-out"><i class="fa-regular fa-id-card mr-2"></i> Profil</a>
            <a href="#riwayat" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-8 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out"><i class="fa-regular fa-comments mr-2"></i> Riwayat Chat</a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5 px-2">
        <a href="{{ route('database.index') }}"
            class="inline-block border border-gray-400 hover:bg-gray-400 hover:text-white text-gray-500 px-4 py-2 rounded-lg text-sm"><i
                class="fa-solid fa-arrow-left"></i> Kembali</a>
    </div>

    <div class="max-w-7xl mx-auto flex flex-col md:flex-row py-4 sm:px-6 lg:px-8 gap-5" id="riwayat">
        <div class="w-full">
            <div class="flex flex-wrap items-center gap-4 gap-3 px-4">
                <button type="button" data-modal-target="dataModal" onclick="dataModal(this)"
                    class="bg-lp3i-100 hover:bg-lp3i-200 px-3 py-2 text-sm rounded-lg text-white"><i
                        class="fa-solid fa-circle-plus"></i> Tambah Data</button>
            </div>

            <div class="p-6">
                <ol class="relative border-l border-gray-200 dark:border-gray-700">
                    @forelse ($histories as $history)
                        <li class="mb-10 ml-4">
                            <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white">
                            </div>
                            <div class="flex gap-5 mb-2">
                                <time
                                    class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ $history['date'] }}</time>
                                <div class="flex gap-3">
                                    <button type="button" data-id="{{ $history['id'] }}" data-modal-target="dataModal"
                                        data-title="{{ $history['title'] }}" data-date="{{ $history['date'] }}"
                                        data-title="{{ $history['title'] }}" data-result="{{ $history['result'] }}" data-report="{{ $history['report'] }}"
                                        onclick="editModal(this)" class="text-xs text-gray-600 hover:text-yellow-600"><i
                                            class="fa-regular fa-pen-to-square"></i></button>
                                    <button type="button" data-id="{{ $history['id'] }}" onclick="deleteModal(this)"
                                        class="text-xs text-gray-600 hover:text-red-600"><i
                                            class="fa-regular fa-trash-can"></i></button>
                                </div>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $history['title'] }}</h3>
                            <p class="mb-4 text-sm font-normal text-gray-500 dark:text-gray-400">{{ $history['result'] }}
                            <p class="mb-4 text-sm font-normal text-gray-500 dark:text-gray-400"><span class="font-bold">Hasil:</span> {{ $history['report'] == null ? 'Belum diisi' : $history['report'] }}
                            </p>
                        </li>
                    @empty
                        <li class="mb-10 ml-4">
                            <div
                                class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Data riwayat belum ada</h3>
                            <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">Silahkan untuk isi
                                riwayat melalui tombol tambah data atau dengan aplikasi pihak ke-3.</p>
                        </li>
                    @endforelse
                </ol>

            </div>
        </div>
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
                                            {{ $user->SchoolApplicant == null ? '___' : $user->SchoolApplicant->name }}
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
                    <hr class="my-3">
                    <div class="relative h-[535px] overflow-y-auto  overflow-x-auto md:rounded-xl">
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
                                            <a href="https://api.politekniklp3i-tasikmalaya.ac.id/pmbonline/download/{{ $suc->identity_user }}/{{ $suc->identity_user }}-{{ $suc->fileupload->namefile }}.{{ $suc->typefile }}"
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
                </header>
            </div>
        </div>
    </div>

</x-app-layout>
