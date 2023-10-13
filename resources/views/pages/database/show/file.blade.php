<x-app-layout>
    <x-slot name="header">
        @include('pages.database.components.navigation')
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
        @if (session('error'))
            <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-red-500 text-white rounded-lg" role="alert">
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
            <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-red-500 text-white rounded-lg" role="alert">
                <i class="fa-solid fa-circle-xmark"></i>
                <div class="ml-3 text-sm font-medium">
                    {{ $errors->first('berkas') }}
                </div>
            </div>
        @endif
    </div>

    <div class="max-w-7xl mx-auto flex flex-col md:flex-row py-4 sm:px-6 lg:px-8 gap-5">
        <div class="w-full mx-auto space-y-5">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
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
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
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
                </header>
            </div>
        </div>
    </div>

</x-app-layout>
