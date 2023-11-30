@if (Auth::user()->role == 'A')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-5 space-y-5">
        <div class="flex flex-col md:flex-row gap-3">
            <section class="w-full md:w-2/3 p-3 space-y-5">
                <div>
                    <h1 class="my-2 font-bold text-gray-700">Total Sumber Informasi:</h1>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach ($sourcesIdEnrollmentCount as $sourcesdaftarid)
                            <div
                                class="flex justify-between items-center px-5 py-3 bg-gray-100 text-gray-800 border border-gray-300 rounded-xl">
                                <h4>
                                    <i class="fa-solid fa-database mr-1"></i>
                                    <span class="text-sm">{{ $sourcesdaftarid->sourceDaftarSetting->name }}</span>
                                </h4>
                                <span
                                    class="bg-gray-600 text-white text-xs px-2 py-1 rounded-lg">{{ $sourcesdaftarid->total }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div>
                    <h1 class="my-2 font-bold text-gray-700">Total Sumber Database:</h1>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach ($sourcesIdCount as $sourcesid)
                            <div
                                class="cursor-pointer flex justify-between items-center px-5 py-3 bg-gray-100 text-gray-800 border border-gray-300 rounded-xl">
                                <h4>
                                    <i class="fa-solid fa-database mr-1"></i>
                                    <span class="text-sm">{{ $sourcesid->sourceSetting->name }}</span>
                                </h4>
                                <span
                                    class="bg-gray-600 text-white text-xs px-2 py-1 rounded-lg">{{ $sourcesid->total }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
            <section class="w-full md:w-1/3 p-3">
                <div class="w-full bg-white p-3 rounded-3xl border border-gray-200" id="chartPresenterContainer">
                    <div class="text-center py-3">
                        <h3 class="font-bold text-gray-800">Data Berdasarkan Presenter</h3>
                        <p class="text-xs text-gray-500">Berikut ini jumlah data calon mahasiswa per Presenter.</p>
                    </div>
                    <hr>
                    <canvas id="chartPresenter" class="py-3"></canvas>
                </div>
            </section>
        </div>
    </div>
@endif
