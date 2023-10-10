<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Sekolah') }}
            </h2>
            <div class="flex flex-wrap justify-center items-center gap-3 px-2 text-gray-600">
                <form action="{{ route('school.import') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="berkas" id="berkas"
                        class="text-xs border border-gray-200 bg-white px-2 py-1.5 rounded-md" required>
                    <button type="submit"
                        class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm space-x-1">
                        <i class="fa-solid fa-file-import"></i>
                    </button>
                </form>
                <div class="flex bg-gray-200 px-4 py-2 text-sm rounded-lg items-center gap-2">
                    <i class="fa-solid fa-database"></i>
                    <h2 id="count_filter">{{ $total }}</h2>
                </div>
            </div>
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
                <button type="button" data-modal-target="schoolModal" onclick="changeSchoolModal(this)"
                    class="bg-lp3i-100 hover:bg-lp3i-200 px-3 py-2 text-sm rounded-lg text-white">
                    <i class="fa-solid fa-circle-plus"></i> Tambah Data</button>
            </div>

            <div class="flex flex-wrap">
                @foreach ($schools_by_region as $school_by_region)
                    <a href="{{ route('school.show', $school_by_region->region) }}" class="block w-1/2 md:w-1/4 p-1">
                        <div class="flex justify-between items-center px-5 py-3 bg-lp3i-200 text-white rounded-xl">
                            <h4>
                                <i class="fa-solid fa-map-location-dot mr-1"></i>
                                <span class="text-sm">{{ $school_by_region->region }}</span>
                            </h4>
                            <span class="bg-lp3i-100 text-white text-sm px-2 py-1 rounded-lg">{{ $school_by_region->jumlah }}</span>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="bg-white overflow-hidden border md:rounded-xl">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="relative overflow-x-auto md:rounded-xl">
                        <table id="myTable" class="w-full text-sm text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 rounded-t-lg">
                                        No.
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Wilayah
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nama
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Presentasi
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Grab Data
                                    </th>
                                    <th scope="col" class="px-6 py-3 rounded-t-lg">
                                        Total
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

@include('pages.schools.modals.school')

<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            ajax: {
                url: 'get/schools',
                dataSrc: 'schools'
            },
            columns: [
                {
                    data: 'grab',
                    render: (data, type, row, meta) => {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'wilayah',
                },
                {
                    data: 'nama'
                },
                {
                    data: 'presentasi'
                },
                {
                    data: 'grab'
                },
                {
                    data: 'jumlah'
                },
            ],
        });
    });

    const deleteRecord = (id) => {
        if (confirm('Apakah kamu yakin akan menghapus data?')) {
            $.ajax({
                url: `/school/${id}`,
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
