<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 pb-3">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Presenter') }}
            </h2>
            <div class="flex flex-wrap justify-center items-center gap-3 px-2 text-gray-600">
                <div class="flex bg-gray-200 px-4 py-2 text-sm rounded-xl items-center gap-2">
                    <i class="fa-solid fa-database"></i>
                    <h2 id="count_filter">{{ $total }}</h2>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-5 md:p-0 space-y-5">
            @if (session('message'))
                <div id="alert" class="flex items-center p-4 mb-4 bg-emerald-500 text-emerald-50 rounded-2xl"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-reguler">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div id="alert" class="flex items-center p-4 mb-4 bg-red-500 text-red-50 rounded-2xl"
                    role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div class="ml-3 text-sm font-reguler">
                        {{ session('error') }}
                    </div>
                </div>
            @endif
            <section class="flex flex-col md:flex-row items-center justify-between gap-3 md:gap-0">
                <a href="{{ route('presenters.create') }}"
                    class="bg-lp3i-100 hover:bg-lp3i-200 px-4 py-3 text-sm rounded-xl text-white"><i
                        class="fa-solid fa-circle-plus"></i> Tambah Data</a>
                <div class="bg-white">
                    <label for="table-search" class="sr-only">Search</label>
                    <form method="GET" action="{{ route('presenters.index') }}" class="relative mt-1">
                        <div
                            class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                            <i class="fa-solid fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="name" id="quick_name"
                            class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-xl w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Cari nama disini..." autofocus>
                    </form>
                </div>
            </section>
            <div class="bg-gray-50 overflow-hidden border rounded-3xl">
                <div class="p-8 bg-white border-b border-gray-200">
                    <div class="relative overflow-x-auto sm:rounded-xl">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase">
                                <tr>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        No.
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        ID
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        Nama lengkap
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        No. Telpon (Whatsapp)
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-center">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($presenters as $key => $presenter)
                                    <tr class="border-b border-gray-200">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50">
                                            {{ $presenters->perPage() * ($presenters->currentPage() - 1) + $key + 1 }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $presenter->identity }}
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-700 bg-gray-50">
                                            {{ $presenter->name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $presenter->phone }}
                                        </td>
                                        <td class="px-6 py-4 bg-gray-50">
                                            <form action="{{ route('presenters.status', $presenter->id) }}"
                                                method="GET" class="inline-block">
                                                @csrf
                                                <button type="submit"
                                                    class="{{ $presenter->status ? 'bg-emerald-500 hover:bg-emerald-600' : 'bg-red-500 hover:bg-red-600' }} px-3 py-2 rounded-xl text-white transition-all ease-in-out">
                                                    {!! $presenter->status ? '<i class="fa-solid fa-toggle-on"></i>' : '<i class="fa-solid fa-toggle-off"></i>' !!}
                                                </button>
                                            </form>
                                            <a href="{{ route('presenters.show', $presenter->id) }}"
                                                class="inline-block bg-blue-500 hover:bg-blue-600 px-3 py-2 rounded-xl text-white transition-all ease-in-out">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                            <a href="{{ route('presenters.edit', $presenter->id) }}"
                                                class="inline-block bg-amber-500 hover:bg-amber-600 px-3 py-2 rounded-xl text-white transition-all ease-in-out">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('presenters.destroy', $presenter->id) }}"
                                                method="post" class="inline-block" onsubmit="return confirmDelete()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 px-3 py-2 rounded-xl text-white transition-all ease-in-out">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center">Data tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="p-1">
                            {{ $presenters->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function getUrlParams() {
            const urlParams = new URLSearchParams(window.location.search);
            const name = urlParams.get('name');
            document.getElementById('quick_name').value = name;
            console.log(name);
        }
        getUrlParams();

        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.');
        }
    </script>
</x-app-layout>
