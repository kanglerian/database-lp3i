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
            @if (session('error'))
                <div id="alert" class="mx-2 mb-4 flex items-center p-4 mb-4 bg-red-500 text-white rounded-lg"
                    role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('error') }}
                    </div>
                </div>
            @endif
            @if (session('message'))
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
            @endif
            <div class="bg-white overflow-hidden border md:rounded-xl">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="relative overflow-x-auto md:rounded-xl">
                        <table class="w-full text-sm text-sm text-left text-gray-500">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr class="flex justify-between items-center">
                                    <th scope="col" class="px-6 py-3 rounded-t-lg">
                                        Nama Berkas
                                    </th>
                                    <th scope="col" class="px-6 py-3 rounded-t-lg">
                                        Action
                                    </th>
                            </thead>
                            <tbody>
                                @foreach ($userupload as $suc)
                                    <tr class="bg-white border-b flex justify-between items-center">
                                        <td class="px-6 py-4">{{ $suc->name }}</td>
                                        <td class="px-6 py-4">
                                            <button
                                                class="inline-block bg-green-500 hover:bg-green-600 px-3 py-1 rounded-md text-xs text-white"><i
                                                    class="fa-solid fa-circle-check"></i></button>
                                            <a href="https://api.politekniklp3i-tasikmalaya.ac.id/pmbonline/download/{{ $suc->identity_user }}/{{ $suc->identity_user }}-{{ $suc->namefile }}.{{ $suc->typefile }}"
                                                class="bg-sky-500 px-3 py-1 rounded-md text-xs text-white""><i
                                                    class="fa-solid fa-download"></i></a>
                                            <button onclick="event.preventDefault(); deleteRecord('{{ $suc->id }}')"
                                                class="inline-block bg-red-500 hover:bg-red-600 px-3 py-1 rounded-md text-xs text-white">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                                @foreach ($fileupload as $upload)
                                    <tr class="bg-white border-b flex justify-between items-center">
                                        <td class="px-6 py-4">{{ $upload->name }}</td>
                                        <td class="px-6 py-4">
                                            <form action="{{ route('userupload.store') }}"
                                                enctype="multipart/form-data" class="inline-block" method="POST">
                                                @csrf
                                                <div>
                                                    <input type="hidden" name="name" value="{{ $upload->name }}">
                                                    <input type="hidden" name="namefile"
                                                        value="{{ $upload->namefile }}">
                                                    <input type="file" name="berkas" id="berkas" class="text-sm"
                                                        accept="{{ $upload->accept }}" style="width:95px">
                                                    <button type="submit"
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
