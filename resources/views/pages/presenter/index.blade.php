<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-semibold text-md text-gray-800 leading-tight">
            {{ __('Presenter') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">
            @if (session('message'))
                <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-lg"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            <div class="px-2">
                <a href="{{ route('presenter.create') }}"
                    class="bg-sky-500 hover:bg-sky-600 px-3 py-2 text-sm rounded-lg text-white"><i
                        class="fa-solid fa-circle-plus"></i> Tambah Data</a>
            </div>
            <div class="bg-white overflow-hidden border md:rounded-xl">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="relative overflow-x-auto md:rounded-xl">
                        <table id="myTable" class="w-full text-sm text-sm text-left text-gray-500">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 rounded-t-lg">
                                        NIP
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nama Lengkap
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        No. Telpon (Whatsapp)
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 rounded-t-lg">
                                        Action
                                    </th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            ajax: {
                url: 'get/presenters',
                dataSrc: 'presenters'
            },
            columns: [
                {
                    data: 'identity',
                },
                {
                    data: 'name'
                },
                {
                    data: 'phone',
                    render: (data, row) => {
                        return typeof(data) == 'string' ? data : 'Tidak diketahui';
                    }
                },
                {
                    data: {
                        id: 'id',
                        status: 'status'
                    },
                    render: (data, type, row) => {
                        let editUrl = "{{ route('presenter.change', ':id') }}".replace(':id',
                            data.id);
                        switch (data.status) {
                            case "0":
                                return `<button onclick="event.preventDefault(); statusRecord(${data.id})" class="bg-red-500 px-3 py-1 rounded-md text-xs text-white"><i class="fa-solid fa-toggle-off"></i></button>`
                                break;
                            case "1":
                                return `<button onclick="event.preventDefault(); statusRecord(${data.id})"  class="bg-emerald-500 px-3 py-1 rounded-md text-xs text-white"><i class="fa-solid fa-toggle-on"></i></button>`
                                break;
                        }
                    }
                },
                {
                    data: 'id',
                    render: (data, type, row) => {
                        let editUrl = "{{ route('presenter.edit', ':id') }}".replace(':id',
                            data);
                        return `
                            <a href="${editUrl}" class="inline-block bg-amber-500 hover:bg-amber-600 px-3 py-1 rounded-md text-xs text-white">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <button class="inline-block bg-red-500 hover:bg-red-600 px-3 py-1 rounded-md text-xs text-white" onclick="event.preventDefault(); deleteRecord(${data})">
                                <i class="fa-solid fa-trash"></i>
                            </button>`
                    }
                },
            ],
        });
    });

    const deleteRecord = (id) => {
        if (confirm('Apakah kamu yakin akan menghapus data?')) {
            $.ajax({
                url: `/presenter/${id}`,
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

    const statusRecord = (id) => {
        if (confirm('Apakah kamu yakin akan mengubah status data?')) {
            $.ajax({
                url: `/presenter/change/${id}`,
                type: 'POST',
                data: {
                    '_method': 'PATCH',
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

    const copyRecord = (name, phone, school, year, source) => {
        var contentSource = '';
        switch (source) {
            case "1":
                contentSource = 'Website'
                break;
            case "2":
                contentSource = 'Presenter'
                break;
        }
        const textarea = document.createElement("textarea");
        textarea.value = `Nama lengkap: ${name} \nNo. Telp (Whatsapp): ${phone} \nAsal sekolah dan tahun lulus: ${school == "null" ? 'Tidak diketahui' : school} (${year}) \nSumber: ${contentSource}`;
        textarea.style.position = "fixed";
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand("copy");
        document.body.removeChild(textarea);
        alert('Link sudah disalin!');
    }
</script>
