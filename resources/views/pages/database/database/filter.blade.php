<div
    class="bg-white rounded-xl border border-gray-200 flex items-center gap-3 text-gray-500 overflow-x-auto pb-4 px-4 py-2 mx-2">
    <div class="flex flex-row items-end md:gap-3 flex-wrap md:flex-nowrap md:overflow-x-auto">
        <div class="w-1/2 space-y-1 p-1 md:p-0">
            <label for="date_start" class="text-xs">Tanggal awal:</label>
            <input type="date" id="date_start" onchange="changeFilter()"
                class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
        </div>
        <div class="w-1/2 space-y-1 p-1 md:p-0">
            <label for="" class="text-xs">Tanggal akhir:</label>
            <input type="date" id="date_end" onchange="changeFilter()"
                class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
        </div>
        <div class="w-1/2 space-y-1 p-1 md:p-0">
            <label for="" class="text-xs">Tahun lulus:</label>
            <input type="number" id="year_grad" onkeyup="if (event.keyCode === 13) changeFilter()"
                class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
                placeholder="Tahun lulus">
        </div>
        @if (Auth::user()->role == 'A')
            <div class="w-1/2 space-y-1 p-1 md:p-0">
                <label for="" class="text-xs">Presenter:</label>
                <select id="identity_user" onchange="changeFilter()"
                    class="js-example-basic-single w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                    <option value="all">Pilih presenter</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->identity }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        @else
            <input type="hidden" id="identity_user" value="{{ Auth::user()->identity }}">
        @endif
        <div class="w-1/2 space-y-1 p-1 md:p-0">
            <label for="" class="text-xs">Asal sekolah:</label>
            <select id="school" onchange="changeFilter()"
                class="js-example-basic-single w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                <option value="all">Pilih sekolah</option>
                <option value="0">Tidak diketahui</option>
                @foreach ($schools as $school)
                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-1/2 space-y-1 p-1 md:p-0">
            <label for="" class="text-xs">Jurusan:</label>
            <input type="text" id="change_major" onkeyup="if (event.keyCode === 13) changeFilter()"
                class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
                placeholder="Jurusan">
        </div>
        <div class="w-1/2 space-y-1 p-1 md:p-0">
            <label for="" class="text-xs">Tanggal lahir:</label>
            <input type="date" id="birthday" onkeyup="if (event.keyCode === 13) changeFilter()"
                class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
                placeholder="Tanggal Lahir">
        </div>
        <div class="w-1/2 space-y-1 p-1 md:p-0">
            <label for="" class="text-xs">Periode PMB:</label>
            <input type="number" id="change_pmb" onkeyup="if (event.keyCode === 13) changeFilter()"
                class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
                placeholder="Tahun PMB">
        </div>
        <div class="w-1/2 space-y-1 p-1 md:p-0">
            <label for="" class="text-xs">Prestasi:</label>
            <input type="text" id="change_achievement" onkeyup="if (event.keyCode === 13) changeFilter()"
                class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
                placeholder="Prestasi">
        </div>
        <div class="w-1/2 space-y-1 p-1 md:p-0">
            <label for="" class="text-xs">Relasi:</label>
            <input type="text" id="change_relation" onkeyup="if (event.keyCode === 13) changeFilter()"
                class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
                placeholder="Relasi">
        </div>
        <div class="w-1/2 space-y-1 p-1 md:p-0">
            <label for="" class="text-xs">Pekerjaan Ayah:</label>
            <input type="text" id="change_jobfather" onkeyup="if (event.keyCode === 13) changeFilter()"
                class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
                placeholder="Pekerjaan Ayah">
        </div>
        <div class="w-1/2 space-y-1 p-1 md:p-0">
            <label for="" class="text-xs">Pekerjaan Ibu:</label>
            <input type="text" id="change_jobmother" onkeyup="if (event.keyCode === 13) changeFilter()"
                class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
                placeholder="Pekerjaan Ibu">
        </div>
        <div class="w-1/2 space-y-1 p-1 md:p-0">
            <label for="" class="text-xs">Ket. Follow Up:</label>
            <select id="change_follow" onchange="changeFilter()"
                class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                <option value="all">Keterangan</option>
                @foreach ($follows as $follow)
                    <option value="{{ $follow->id }}">{{ $follow->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-1/2 space-y-1 p-1 md:p-0">
            <label for="" class="text-xs">Datang ke LP3I</label>
            <select id="change_come" onchange="changeFilter()"
                class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                <option value="all">Pilih</option>
                <option value="1">Ya</option>
                <option value="0">Tidak</option>
            </select>
        </div>
        <div class="w-1/2 space-y-1 p-1 md:p-0">
            <label for="" class="text-xs">KIP</label>
            <select id="change_kip" onchange="changeFilter()"
                class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                <option value="all">Pilih</option>
                <option value="1">Ya</option>
                <option value="0">Tidak</option>
            </select>
        </div>
        <div class="w-1/2 space-y-1 p-1 md:p-0">
            <label for="" class="text-xs">Sumber:</label>
            <select id="change_source" onchange="changeFilter()"
                class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                <option value="all">Sumber</option>
                @foreach ($sources as $source)
                    <option value="{{ $source->id }}">{{ $source->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-1/2 space-y-1 p-1 md:p-0">
            <label for="" class="text-xs">Status:</label>
            <select id="change_status" onchange="changeFilter()"
                class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                <option value="all">Status</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
