@if (Auth::user()->role !== 'S')
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center gap-3">
            <div class="flex items-end flex-wrap md:flex-nowrap text-gray-500 md:gap-3 order-2 md:order-none">
                <input type="hidden" id="identity" value="{{ Auth::user()->identity }}">
                <div class="inline-block flex flex-col space-y-1 p-1 md:p-0">
                    <label for="change_pmb" class="text-xs">Periode PMB:</label>
                    <input type="number" id="change_pmb" onchange="changeTrigger()"
                        class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
                        placeholder="Tahun PMB">
                </div>
                <div class="inline-block flex flex-col space-y-1 p-1 md:p-0">
                    <label for="date" class="text-xs">Tanggal:</label>
                    <input type="date" id="date" onchange="changeTrigger()"
                        class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                </div>
                <div class="inline-block flex flex-col space-y-1 p-1 md:p-0">
                    <label for="session" class="text-xs">Gelombang:</label>
                    <select id="session" onchange="changeTrigger()"
                        class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800">
                        <option value="all">Pilih</option>
                        <option value="1">Gelombang 1</option>
                        <option value="2">Gelombang 2</option>
                        <option value="3">Gelombang 3</option>
                        <option value="4">Gelombang 4</option>
                    </select>
                </div>
            </div>
            <div class="px-6 py-2 rounded-xl text-sm bg-white border border-gray-100 order-1 md:order-none">
                <div>
                    <span class="font-bold">{{ Auth::user()->name }}</span>
                    (<span onclick="copyIdentity('{{ Auth::user()->identity }}')">ID:
                        {{ Auth::user()->identity }}</span>)
                    <button onclick="copyIdentity('{{ Auth::user()->identity }}')" class="text-blue-500"><i
                            class="fa-regular fa-copy"></i></button>
                </div>
                <span class="text-xs text-gray-600">Gunakan Key Identity ini di aplikasi Whatsapp
                    Sender.</span>
            </div>
        </div>
    </div>
@endif
