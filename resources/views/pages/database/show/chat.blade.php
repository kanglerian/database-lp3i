<x-app-layout>
    <x-slot name="header">
        @include('pages.database.components.navigation')
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-5">
        @if (session('error'))
            <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-red-500 text-white rounded-xl" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div class="ml-3 text-sm font-reguler">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        @if (session('message'))
            <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-lg"
                role="alert">
                <i class="fa-solid fa-circle-check"></i>
                <div class="ml-3 text-sm font-reguler">
                    {{ session('message') }}
                </div>
            </div>
        @endif
        @if ($errors->first('berkas'))
            <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-red-500 text-white rounded-xl" role="alert">
                <i class="fa-solid fa-circle-xmark"></i>
                <div class="ml-3 text-sm font-reguler">
                    {{ $errors->first('berkas') }}
                </div>
            </div>
        @endif
    </div>

    <div id="phone" data-phone="{{ $user->phone }}"
        class="max-w-7xl mx-auto flex flex-col md:flex-row py-4 sm:px-6 lg:px-8 gap-5 mt-3" id="riwayat">
        <div class="w-full">
            <div class="flex flex-wrap items-center gap-4 gap-3 px-4">
                <button type="button" onclick="modalFunction('add')"
                    class="bg-lp3i-100 hover:bg-lp3i-200 px-3 py-2 text-sm rounded-lg text-white"><i
                        class="fa-solid fa-circle-plus"></i> Tambah Data</button>
            </div>

            <div class="p-6">
                <ol class="relative border-l border-gray-200" id="histories">
                    <li class="mb-10 ml-4">
                        <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white">
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Sedang Memuat Chat</h3>
                        <p class="mb-4 text-base font-normal text-gray-500">Silahkan ditunggu chat sedang dimuat..</p>
                    </li>
                </ol>
            </div>
        </div>
    </div>

    <div class="fixed inset-0 flex items-center justify-center z-50 hidden" id="modalChat">
        <div class="fixed inset-0 bg-black opacity-50"></div>
        <div class="fixed inset-0 flex items-center justify-center">
            <div class="w-full md:w-1/2 relative bg-white rounded-3xl shadow mx-5">
                <div class="flex items-start justify-between px-8 py-6 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900" id="title_form">
                        Tambah Data Riwayat
                    </h3>
                    <button type="button" onclick="" data-modal-target="dataModal"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                        data-modal-hide="defaultModal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div>
                    <div class="px-8 pb-8 pt-3 space-y-3">
                        <input type="hidden" value="" id="id" name="id">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Judul Riwayat</label>
                            <input type="text" id="title" name="title" placeholder="Isi judul riwayat disini.."
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal</label>
                            <input type="date" id="date" name="date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Isi Pesan</label>
                            <textarea name="result" id="result" cols="30" rows="5" placeholder="Isi pesan disini..."
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required></textarea>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Hasil</label>
                            <input type="text" id="report" name="report" placeholder="Tulis hasilnya disini"
                                class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500">
                        </div>
                        <hr>
                        <div>
                            <button type="button" id="formButton" onclick="saveHistory()"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
                            <button type="submit" onclick="modalFunction()"
                                class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('pages.database.js.scripts')

</x-app-layout>
