@if ($enrollment)
    <!-- Main modal -->
    <div id="modal-edit-daftar" tabindex="-1" aria-hidden="true"
        class="hidden flex justify-center items-center fixed top-0 left-0 right-0 z-50  w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="fixed top-0 left-0 right-0 bottom-0 bg-black opacity-50"></div>
        <div class="relative w-full max-w-xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-2xl shadow">
                <button type="button" onclick="modalEditDaftar()"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                    data-modal-hide="modal-daftar">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900">Ubah Daftar Mahasiswa Baru</h3>
                    <hr class="mb-3">
                    <form class="space-y-4" action="{{ route('enrollment.update', $enrollment->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="grid grid-cols-1 md:grid-cols-3 md:gap-3">
                            <div>
                                <label for="pmb" class="block mb-2 text-sm font-medium text-gray-900">Tahun
                                    PMB</label>
                                <input type="number" value="{{ $enrollment->pmb }}" name="pmb" maxlength="4"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="Tahun PMB" required>
                                @if ($errors->has('pmb'))
                                    <span class="text-red-500 text-xs">{{ $errors->first('pmb') }}</span>
                                @else
                                    <span class="text-red-500 text-xs">*Wajib diisi.</span>
                                @endif
                            </div>
                            <div>
                                <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Tanggal
                                    Daftar</label>
                                <input type="date" name="date" value="{{ $enrollment->date }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="Tanggal Daftar" required>
                                @if ($errors->has('date'))
                                    <span class="text-red-500 text-xs">{{ $errors->first('date') }}</span>
                                @else
                                    <span class="text-red-500 text-xs">*Wajib diisi.</span>
                                @endif
                            </div>
                            <div>
                                <label for="session"
                                    class="block mb-2 text-sm font-medium text-gray-900">Gelombang</label>
                                <select name="session"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    required>
                                    @if ($enrollment->session)
                                        <option value="{{ $enrollment->session }}">
                                            {{ $enrollment->session }}
                                        </option>
                                    @endif
                                    <hr>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                                @if ($errors->has('session'))
                                    <span class="text-red-500 text-xs">{{ $errors->first('session') }}</span>
                                @else
                                    <span class="text-red-500 text-xs">*Wajib diisi.</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <input type="hidden" value="{{ $enrollment->identity_user }}" name="identity_user"
                                id="identity_user"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <div class="grid grid-cols-1">
                            <div>
                                <label for="receipt" class="block mb-2 text-sm font-medium text-gray-900">
                                    No. Kwitansi
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                        <i class="fa-solid fa-receipt text-gray-400"></i>
                                    </div>
                                    <input type="text" name="receipt" maxlength="8" value="{{ $enrollment->receipt }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                        placeholder="No. Kwitansi" required>
                                </div>
                                @if ($errors->has('receipt'))
                                    <span class="text-red-500 text-xs">{{ $errors->first('receipt') }}</span>
                                @else
                                    <span class="text-red-500 text-xs">*Wajib diisi 5 - 8 digit.</span>
                                @endif
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-3">
                            <div>
                                <label for="register"
                                    class="block mb-2 text-sm font-medium text-gray-900">Keterangan</label>
                                <select name="register"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    required>
                                    @if ($enrollment->register)
                                        <option value="{{ $enrollment->register }}">{{ $enrollment->register }}
                                        </option>
                                    @endif
                                    <hr>
                                    <option value="Daftar Kampus">Daftar Kampus</option>
                                    <option value="Daftar BK">Daftar BK</option>
                                    <option value="Daftar TF Kampus">Daftar TF Kampus</option>
                                </select>
                                @if ($errors->has('register'))
                                    <span class="text-red-500 text-xs">{{ $errors->first('register') }}</span>
                                @else
                                    <span class="text-red-500 text-xs">*Wajib diisi.</span>
                                @endif
                            </div>
                            <div>
                                <label for="register_end"
                                    class="block mb-2 text-sm font-medium text-gray-900">Keterangan
                                    Daftar</label>
                                <select name="register_end"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    required>
                                    @if ($enrollment->register_end)
                                        <option value="{{ $enrollment->register_end }}">
                                            {{ $enrollment->register_end }}
                                        </option>
                                    @endif
                                    <hr>
                                    <option value="Daftar Kampus">Daftar Kampus</option>
                                    <option value="Daftar BK">Daftar BK</option>
                                    <option value="Daftar TF Kampus">Daftar TF Kampus</option>
                                </select>
                                @if ($errors->has('register_end'))
                                    <span class="text-red-500 text-xs">{{ $errors->first('register_end') }}</span>
                                @else
                                    <span class="text-red-500 text-xs">*Wajib diisi.</span>
                                @endif
                            </div>
                        </div>
                        <div class="grid grid-cols-1">
                            <div>
                                <label for="nominal" class="block mb-2 text-sm font-medium text-gray-900">Nominal
                                    Daftar</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                        <span class="text-sm text-gray-500">Rp</span>
                                    </div>
                                    <input type="text" name="nominal" value="{{ $enrollment->nominal }}"
                                        onkeyup="validateNumber(event)"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"placeholder="0"
                                        required>
                                </div>
                                @if ($errors->has('nominal'))
                                    <span class="text-red-500 text-xs">{{ $errors->first('nominal') }}</span>
                                @else
                                    <span class="text-red-500 text-xs">*Wajib diisi.</span>
                                @endif
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-3">
                            <div>
                                <label for="repayment"
                                    class="block mb-2 text-sm font-medium text-gray-900">Pengembalian
                                    BK</label>
                                <input type="date" name="repayment" value="{{ $enrollment->repayment }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="Tanggal Pengembalian BK">
                            </div>
                            <div>
                                <label for="debit"
                                    class="block mb-2 text-sm font-medium text-gray-900">Debit</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                        <span class="text-sm text-gray-500">Rp</span>
                                    </div>
                                    <input type="text" name="debit" value="{{ $enrollment->debit }}"
                                        onkeyup="validateNumber(event)"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                        placeholder="0">
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="note" class="block mb-2 text-sm font-medium text-gray-900">Catatan</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <i class="fa-solid fa-note-sticky text-gray-400"></i>
                                </div>
                                <input type="text" name="note" value="{{ $enrollment->note }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                    placeholder="Catatan">
                            </div>
                        </div>
                        <button type="submit"
                            class="w-full text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan
                            Perubahan</button>
                        <p class="text-xs text-gray-600 text-center">Periksa terlebih dahulu apakah sudah benar?</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Main modal -->
<div id="modal-daftar" tabindex="-1" aria-hidden="true"
    class="hidden flex justify-center items-center fixed top-0 left-0 right-0 z-50  w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="fixed top-0 left-0 right-0 bottom-0 bg-black opacity-50"></div>
    <div class="relative w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-2xl shadow">
            <button type="button" onclick="modalDaftar()"
                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                data-modal-hide="modal-daftar">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="px-6 py-6 lg:px-8">
                <div class="space-y-1 mb-3">
                    <h3 class="text-lg font-bold text-gray-900">Daftar Mahasiswa Baru</h3>
                    <p class="text-sm text-gray-600">Ini adalah menu untuk mendaftarkan mahasiswa.</p>
                </div>
                <hr class="mb-3">
                <form class="space-y-4" action="{{ route('enrollment.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 md:gap-3">
                        <div>
                            <label for="pmb" class="block mb-2 text-sm font-medium text-gray-900">Tahun
                                PMB</label>
                            <input type="number" value="{{ $user->pmb }}" name="pmb" maxlength="4" id="pmb"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Tahun PMB" required>
                            @if ($errors->has('pmb'))
                                <span class="text-red-500 text-xs">{{ $errors->first('pmb') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </div>
                        <div>
                            <label for="date_daftar" class="block mb-2 text-sm font-medium text-gray-900">Tanggal
                                Daftar</label>
                            <input type="date" name="date" id="date_daftar"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Tanggal Daftar" required>
                            @if ($errors->has('date'))
                                <span class="text-red-500 text-xs">{{ $errors->first('date') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </div>
                        <div>
                            <label for="session_daftar"
                                class="block mb-2 text-sm font-medium text-gray-900">Gelombang</label>
                            <select id="session_daftar" name="session"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <input type="hidden" value="{{ $user->identity }}" name="identity_user" id="identity_user"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                    <div class="grid grid-cols-1">
                        <div>
                            <label for="receipt" class="block mb-2 text-sm font-medium text-gray-900">
                                No. Kwitansi
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <i class="fa-solid fa-receipt text-gray-400"></i>
                                </div>
                                <input type="number" name="receipt" maxlength="8" id="receipt"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                    placeholder="No. Kwitansi" required>
                            </div>
                            @if ($errors->has('receipt'))
                                <span class="text-red-500 text-xs">{{ $errors->first('receipt') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi 5 - 10 digit.</span>
                            @endif
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-3">
                        <div>
                            <label for="register"
                                class="block mb-2 text-sm font-medium text-gray-900">Keterangan</label>
                            <select id="register" name="register"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                                <option value="Daftar Kampus">Daftar Kampus</option>
                                <option value="Daftar BK">Daftar BK</option>
                                <option value="Daftar TF Kampus">Daftar TF Kampus</option>
                            </select>
                            @if ($errors->has('register'))
                                <span class="text-red-500 text-xs">{{ $errors->first('register') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </div>
                        <div>
                            <label for="register_end" class="block mb-2 text-sm font-medium text-gray-900">Keterangan
                                Daftar</label>
                            <select id="register_end" name="register_end"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                                <option value="Daftar Kampus">Daftar Kampus</option>
                                <option value="Daftar BK">Daftar BK</option>
                                <option value="Daftar TF Kampus">Daftar TF Kampus</option>
                            </select>
                            @if ($errors->has('register_end'))
                                <span class="text-red-500 text-xs">{{ $errors->first('register_end') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </div>
                    </div>
                    <div class="grid grid-cols-1">
                        <div>
                            <label for="nominal" class="block mb-2 text-sm font-medium text-gray-900">Nominal
                                Daftar</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <span class="text-sm text-gray-500">Rp</span>
                                </div>
                                <input type="text" name="nominal" id="nominal" onkeyup="validateNumber(event)"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"placeholder="0"
                                    required>
                            </div>
                            @if ($errors->has('nominal'))
                                <span class="text-red-500 text-xs">{{ $errors->first('nominal') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-3">
                        <div>
                            <label for="repayment" class="block mb-2 text-sm font-medium text-gray-900">Pengembalian
                                BK</label>
                            <input type="date" name="repayment" id="repayment"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Tanggal Pengembalian BK">
                        </div>
                        <div>
                            <label for="debit" class="block mb-2 text-sm font-medium text-gray-900">Debit</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <span class="text-sm text-gray-500">Rp</span>
                                </div>
                                <input type="text" name="debit" id="debit" onkeyup="validateNumber(event)"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                    placeholder="0">
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="note" class="block mb-2 text-sm font-medium text-gray-900">Catatan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                <i class="fa-solid fa-note-sticky text-gray-400"></i>
                            </div>
                            <input type="text" name="note" id="note"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                placeholder="Catatan">
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Daftar
                        Sekarang!</button>
                    <p class="text-xs text-gray-600 text-center">Periksa terlebih dahulu apakah sudah benar?</p>
                </form>
            </div>
        </div>
    </div>
</div>

@if (!$enrollment)
<script>
    const daftarSetting = () => {
        const currentDate = new Date();
        const currentMonth = currentDate.getMonth() + 1;

        const currentYear = currentDate.getFullYear();
        const currentMonths = currentDate.getMonth();
        const startYear = currentMonths >= 9 ? currentYear + 1 : currentYear;

        let session = 'all';

        if (currentMonth >= 1 && currentMonth <= 3) {
            session = 2;
        } else if (currentMonth >= 4 && currentMonth <= 6) {
            session = 3;
        } else if (currentMonth >= 7 && currentMonth <= 9) {
            session = 4;
        } else if (currentMonth >= 10 && currentMonth <= 12) {
            session = 1;
        }

        document.getElementById('session_daftar').value = session;
        document.getElementById('date_daftar').value = currentDate.toISOString().slice(0, 10);
    }

    daftarSetting();
</script>
@endif
