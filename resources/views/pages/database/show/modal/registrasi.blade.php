<!-- Main modal -->
<div id="modal-registrasi" tabindex="-1" aria-hidden="true"
    class="hidden flex justify-center items-center fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="fixed top-0 left-0 right-0 bottom-0 bg-black opacity-50"></div>
    <div class="relative w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="w-full relative bg-white rounded-lg shadow">
            <button type="button" onclick="modalRegistrasi()"
                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                data-modal-hide="modal-registrasi">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="grid grid-cols-1 p-8">
                <section>
                    <header>
                        <h2 class="font-bold text-gray-900 text-lg">Registrasi Mahasiswa Baru</h2>
                        <p class="text-gray-600 text-sm">Harap diperiksa kembali data diri calon mahasiswa.</p>
                    </header>
                    <hr class="my-3">
                    <div class="flex flex-col md:flex-row justify-center gap-3">
                        <ul class="w-full md:w-3/4 space-y-1.5 text-sm order-1">
                            @if ($user->nik)
                                <li>
                                    <span>NIK: <span class="underline font-medium">{{ $user->nik }}</span></span>
                                    <i class="fa-solid fa-circle-check text-green-500"></i>
                                </li>
                            @else
                                <li>
                                    <span>NIK: ________________</span>
                                    <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                </li>
                            @endif
                            @if ($user->name)
                                <li>
                                    <span>Nama Lengkap: <span
                                            class="underline font-medium">{{ $user->name }}</span></span>
                                    <i class="fa-solid fa-circle-check text-green-500"></i>
                                </li>
                            @else
                                <li>
                                    <span>Nama Lengkap: ________________</span>
                                    <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                </li>
                            @endif
                            @if ($user->date_of_birth)
                                <li>
                                    <span>Tempat/Tgl Lahir: <span
                                            class="underline font-medium">{{ $user->date_of_birth }}</span></span>
                                    <i class="fa-solid fa-circle-check text-green-500"></i>
                                </li>
                            @else
                                <li>
                                    <span>Tempat/Tgl Lahir: ___________________</span>
                                    <i class="fa-solid fa-circle-check text-red-500"></i>
                                </li>
                            @endif
                            <li>
                                <span>Jenis Kelamin: <span
                                        class="underline font-medium">{{ $user->gender ? 'Laki-laki' : 'Perempuan' }}</span></span>
                                <i class="fa-solid fa-circle-check text-green-500"></i>
                            </li>
                            @if ($user->address)
                                <li>
                                    <span>Alamat: <span class="underline font-medium">{{ $user->address }}</span></span>
                                    <i class="fa-solid fa-circle-check text-green-500"></i>
                                </li>
                            @else
                                <li>Alamat: ___________________</li>
                                <i class="fa-solid fa-circle-check text-red-500"></i>
                            @endif
                            @if ($user->religion)
                                <li>
                                    <span>Agama: <span class="underline font-medium">{{ $user->religion }}</span></span>
                                    <i class="fa-solid fa-circle-check text-green-500"></i>
                                </li>
                            @else
                                <li>
                                    <span>Agama: ________________</span>
                                    <i class="fa-solid fa-circle-check text-red-500"></i>
                                </li>
                            @endif
                        </ul>
                        @if ($profile->avatar)
                            <div class="flex flex-col items-center w-full md:w-1/4 space-y-2">
                                <img src="https://api.politekniklp3i-tasikmalaya.ac.id/pmbonline/download?identity={{ $profile->identity }}&filename={{ $profile->identity }}-{{ $profile->avatar }}"
                                    alt="Avatar" width="130px" height="130px" class="items-right rounded-xl">
                                <a href="{{ route('database.edit', $user->id) }}"
                                    class="cursor-pointer text-center inline-block md:block bg-yellow-500 hover:bg-yellow-600 text-xs text-white px-5 py-1.5 rounded-lg"><i
                                        class="fa-regular fa-pen-to-square"></i> Ubah data</a>
                            </div>
                        @else
                            <div
                                style="border: 1px dotted black; height: 130px; width: 130px;display: flex;justify-content: center;align-items:center">
                                <p>Pas foto 4x3</p>
                            </div>
                        @endif
                    </div>
                </section>
                <hr class="my-3">
                @if ($user->nik && $user->name && $user->gender && $user->date_of_birth && $user->place_of_birth && $user->is_read)
                    <section>
                        <form class="space-y-4" action="{{ route('registration.store') }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 md:gap-3">
                                <div>
                                    <label for="pmb" class="block mb-2 text-sm font-medium text-gray-900">Tahun
                                        PMB</label>
                                    <input type="number" value="{{ $user->pmb }}" name="pmb" id="pmb"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder="Tahun PMB" required>
                                </div>
                                <div>
                                    <label for="session"
                                        class="block mb-2 text-sm font-medium text-gray-900">Gelombang</label>
                                    <select id="session" name="session"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        required>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" value="{{ $user->identity }}" name="identity_user"
                                id="identity_user">
                            <div class="grid grid-cols-1">
                                <div>
                                    <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Tanggal
                                        Registrasi</label>
                                    <input type="date" name="date" id="date"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder="Tanggal Registrasi" required>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 md:gap-3">
                                <div>
                                    <label for="nominal" class="block mb-2 text-sm font-medium text-gray-900">Nominal
                                        Registrasi</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                            <span class="text-sm text-gray-500">Rp</span>
                                        </div>
                                        <input type="text" name="nominal" id="nominal"
                                            onkeyup="validateNumber(event)"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"placeholder="0"
                                            required>
                                    </div>
                                </div>
                                <div>
                                    <label for="deal" class="block mb-2 text-sm font-medium text-gray-900">Harga
                                        Deal</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                            <span class="text-sm text-gray-500">Rp</span>
                                        </div>
                                        <input type="text" name="deal" id="deal"
                                            onkeyup="validateNumber(event)"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                            placeholder="0" required>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="discount"
                                    class="block mb-2 text-sm font-medium text-gray-900">Potongan</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                        <span class="text-sm text-gray-500">Rp</span>
                                    </div>
                                    <input type="text" name="discount" id="discount"
                                        onkeyup="validateNumber(event)"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                        placeholder="0" required>
                                </div>
                            </div>
                            <div>
                                <label for="desc_discount"
                                    class="block mb-2 text-sm font-medium text-gray-900">Keterangan
                                    Potongan</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                        <i class="fa-solid fa-note-sticky text-gray-400"></i>
                                    </div>
                                    <input type="text" name="desc_discount" id="desc_discount"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                        placeholder="Keterangan Potongan">
                                </div>
                            </div>
                            <button type="submit"
                                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Registrasi
                                Sekarang!</button>
                            <p class="text-xs text-gray-600 text-center">Periksa terlebih dahulu apakah sudah benar?
                            </p>
                        </form>
                    </section>
                @else
                <p class="text-center text-sm text-gray-700"><i class="fa-solid fa-circle-xmark text-red-500"></i> Belum lengkap</p>
                @endif
            </div>
        </div>
    </div>
</div>
