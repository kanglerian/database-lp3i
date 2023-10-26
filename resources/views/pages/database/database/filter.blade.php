<div
    class="w-full bg-white rounded-xl border flex flex-wrap md:flex-nowrap overflow-x-auto border-gray-200 text-gray-500 p-4 md:gap-3">
    <div class="w-1/2 md:w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
        <label for="change_pmb" class="text-xs">Periode PMB:</label>
        <input type="number" id="change_pmb"
            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
            placeholder="Tahun PMB">
    </div>
    <div class="w-1/2 md:w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
        <label for="change_applicant" class="text-xs">Status Aplikan</label>
        <select id="change_applicant"
            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
            <option value="all">Pilih</option>
            <option value="database">Database</option>
            <option value="aplikan">Aplikan</option>
            <option value="daftar">Daftar</option>
            <option value="registrasi">Registrasi</option>
            <option value="schoolarship">Beasiswa</option>
        </select>
    </div>
    <div class="w-1/2 md:w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
        <label for="change_source_daftar" class="text-xs">Sumber Informasi:</label>
        <select id="change_source_daftar"
            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
            <option value="all">Sumber</option>
            @foreach ($sources as $source)
                <option value="{{ $source->id }}">{{ $source->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="w-1/2 md:w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
        <label for="change_source" class="text-xs">Sumber Database:</label>
        <select id="change_source"
            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
            <option value="all">Sumber</option>
            @foreach ($sources as $source)
                <option value="{{ $source->id }}">{{ $source->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="w-1/2 md:w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
        <label for="change_status" class="text-xs">Status Database:</label>
        <select id="change_status"
            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
            <option value="all">Status</option>
            @foreach ($statuses as $status)
                <option value="{{ $status->id }}">{{ $status->name }}</option>
            @endforeach
        </select>
    </div>
    @if (Auth::user()->role == 'A')
        <div class="w-1/2 md:w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
            <label for="identity_user" class="text-xs">Presenter:</label>
            <select id="identity_user"
                class="js-example-basic-single bg-white border border-gray-300 w-full md:w-[150px] px-3 py-2 text-xs rounded-lg text-gray-800">
                <option value="all">Pilih presenter</option>
                <option value="6281313608558">Administrator</option>
                @foreach ($users as $user)
                    <option value="{{ $user->identity }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
    @else
        <input type="hidden" id="identity_user" value="{{ Auth::user()->identity }}">
    @endif
    <div class="w-1/2 md:w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
        <label for="date_start" class="text-xs">Tanggal awal:</label>
        <input type="date" id="date_start"
            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
    </div>
    <div class="w-1/2 md:w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
        <label for="date_end" class="text-xs">Tanggal akhir:</label>
        <input type="date" id="date_end"
            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
    </div>
    <div class="w-1/2 md:w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
        <label for="change_follow" class="text-xs">Ket. Follow Up:</label>
        <select id="change_follow"
            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
            <option value="all">Keterangan</option>
            @foreach ($follows as $follow)
                <option value="{{ $follow->id }}">{{ $follow->name }}</option>
            @endforeach
        </select>
    </div>
</div>


<div
    class="w-full bg-white rounded-xl border flex flex-wrap md:flex-nowrap overflow-x-auto border-gray-200 text-gray-500 p-4 md:gap-3">
    <div class="w-1/2 md:w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
        <label for="school" class="text-xs">Asal sekolah:</label>
        <select id="school"
            class="js-example-basic-single w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
            <option value="all">Pilih sekolah</option>
            <option value="0">Tidak diketahui</option>
            @foreach ($schools as $school)
                <option value="{{ $school->id }}">{{ $school->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="w-1/2 md:w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
        <label for="change_major" class="text-xs">Jurusan:</label>
        <input type="text" id="change_major"
            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
            placeholder="Jurusan">
    </div>
    <div class="w-1/2 md:w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
        <label for="year_grad" class="text-xs">Tahun lulus:</label>
        <input type="number" id="year_grad"
            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
            placeholder="Tahun lulus">
    </div>
    <div class="w-1/2 md:w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
        <label for="birthday" class="text-xs">Tanggal lahir:</label>
        <input type="date" id="birthday"
            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
            placeholder="Tanggal Lahir">
    </div>
    <div class="w-1/2 md:w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
        <label for="change_achievement" class="text-xs">Prestasi:</label>
        <input type="text" id="change_achievement"
            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
            placeholder="Prestasi">
    </div>
    <div class="w-1/2 md:w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
        <label for="change_relation" class="text-xs">Relasi:</label>
        <input type="text" id="change_relation"
            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
            placeholder="Relasi">
    </div>
    <div class="w-1/2 md:w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
        <label for="change_jobfather" class="text-xs">Pekerjaan Ayah:</label>
        <input type="text" id="change_jobfather"
            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
            placeholder="Pekerjaan Ayah">
    </div>
    <div class="w-1/2 md:w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
        <label for="change_jobmother" class="text-xs">Pekerjaan Ibu:</label>
        <input type="text" id="change_jobmother"
            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
            placeholder="Pekerjaan Ibu">
    </div>
    <div class="w-1/2 md:w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
        <label for="change_plan" class="text-xs">Rencana Aplikan</label>
        <select id="change_plan"
            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
            <option value="all">Pilih</option>
            <option value="Kuliah">Kuliah</option>
            <option value="Kerja">Kerja</option>
            <option value="Bisnis">Bisnis</option>
            <option value="Nikah">Nikah</option>
        </select>
    </div>
    <div class="w-1/2 md:w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
        <label for="change_come" class="text-xs">Datang ke LP3I</label>
        <select id="change_come"
            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
            <option value="all">Pilih</option>
            <option value="1">Ya</option>
            <option value="0">Tidak</option>
        </select>
    </div>
    <div class="w-1/2 md:w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
        <label for="change_income" class="text-xs">Penghasilan Orang Tua</label>
        <select id="change_income"
            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
            <option value="all">Pilih</option>
            <option value="< 1.000.000">&lt; 1.000.000</option>
            <option value="1.000.000 - 2.000.000">1.000.000 - 2.000.000</option>
            <option value="2.000.000 - 4.000.000">2.000.000 - 4.000.000</option>
            <option value="> 5.000.000">&gt; 5.000.000</option>
        </select>
    </div>
    <div class="w-1/2 md:w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
        <label for="change_kip" class="text-xs">KIP</label>
        <select id="change_kip"
            class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
            <option value="all">Pilih</option>
            <option value="1">Ya</option>
            <option value="0">Tidak</option>
        </select>
    </div>
</div>
