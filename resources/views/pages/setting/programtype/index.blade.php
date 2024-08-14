<x-app-layout>
    <x-slot name="header">
        <nav class="flex">
            <ol class="inline-flex items-center space-x-2 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('setting.index') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">
                        <i class="fa-solid fa-gears me-1"></i>
                        Setting
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fa-solid fa-angle-right text-gray-300 me-2"></i>
                        <span class="text-sm font-medium text-gray-500">Master Follow Up</span>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>

    <main class="max-w-7xl w-full mx-auto py-10">
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
            <div id="alert" class="flex items-center p-4 mb-4 bg-red-500 text-red-50 rounded-2xl" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div class="ml-3 text-sm font-reguler">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        <section class="border border-gray-100 rounded-3xl p-8 space-y-4">
          <a href="{{ route('programtype.create') }}" class="inline-block text-white bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5">Tambah data</a>
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 rounded-tl-xl">
                                No.
                            </th>
                            <th scope="col" class="px-6 py-4">
                                Nama
                            </th>
                            <th scope="col" class="px-6 py-4 rounded-tr-xl">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($programtypes as $key => $programtype)
                            <tr class="bg-white border-b hover:bg-gray-50 transition-all ease-in-out">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $programtypes->perPage() * ($programtypes->currentPage() - 1) + $key + 1 }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $programtype->name }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('programtype.edit', $programtype->id) }}"
                                        class="inline-block bg-amber-500 hover:bg-amber-600 px-3 py-2 rounded-xl text-white transition-all ease-in-out">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('programtype.destroy', $programtype->id) }}" method="post"
                                        class="inline-block" onsubmit="return confirmDelete()">
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
                                <td colspan="3" class="px-6 py-4 text-center">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-1">
                    {{ $programtypes->links() }}
                </div>
            </div>
        </section>
    </main>
    <script>
      function confirmDelete() {
          return confirm('Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.');
      }
  </script>
</x-app-layout>
