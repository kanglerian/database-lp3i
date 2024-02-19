@if ($registration)
    <!-- Main modal -->
    <div id="modal-check" tabindex="-1" aria-hidden="true"
        class="hidden flex justify-center items-center fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="fixed top-0 left-0 right-0 bottom-0 bg-black opacity-50"></div>
        <div class="relative w-full max-w-4xl max-h-full">
            <!-- Modal content -->
            <div class="w-full bg-white rounded-2xl shadow">
                <div class="flex justify-between items-center p-5">
                    <div class="space-y-1 mb-3">
                        <h3 class="text-lg font-bold text-gray-900">Periksa Mahasiswa Baru</h3>
                        <p class="text-sm text-gray-600">Harap diperiksa kembali data diri calon mahasiswa.</p>
                    </div>
                    <div class="relative">
                        <button type="button" onclick="modalCheck()"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                            data-modal-hide="modal-registrasi">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
                <hr>
                <div class="grid grid-cols-1 mx-auto p-8">
                    <div class="flex justify-center w-full mx-auto">
                        <ol
                            class="grid grid-cols-1 md:grid-cols-5 gap-5 items-center w-full text-sm font-medium text-center text-gray-500">
                            <li onclick="checkNext(1)" class="cursor-pointer flex justify-center items-center">
                                <span class="flex items-center text-sm gap-2">
                                    <span class="bg-gray-100 block px-2 py-1 rounded-lg text-gray-900">1</span>
                                    <span class="text-sky-500" id="check-1-title">Info Siswa</span>
                                </span>
                            </li>
                            <hr>
                            <li onclick="checkNext(2)" class="cursor-pointer flex justify-center items-center">
                                <span class="flex items-center text-sm gap-2">
                                    <span class="bg-gray-100 block px-2 py-1 rounded-lg text-gray-900">2</span>
                                    <span class="text-gray-700" id="check-2-title">Orang Tua</span>
                                </span>
                            </li>
                            <hr>
                            <li onclick="checkNext(3)" class="cursor-pointer flex justify-center items-center">
                                <span class="flex items-center text-sm gap-2">
                                    <span class="bg-gray-100 block px-2 py-1 rounded-lg text-gray-900">3</span>
                                    <span class="text-gray-700" id="check-3-title">Info PMB</span>
                                </span>
                            </li>
                        </ol>
                    </div>
                </div>
                <hr class="mb-6">

                <section class="px-8 pb-8">

                    {{-- Info Siswa --}}
                    <section class="flex flex-col md:flex-row justify-between gap-5" id="check-1">
                        @if ($profile->avatar)
                            <div class="flex flex-col items-center w-full md:w-1/4 space-y-2">
                                <img src="{{ env('API_LP3I') }}/pmbonline/download?identity={{ $profile->identity }}&filename={{ $profile->identity }}-{{ $profile->avatar }}"
                                    alt="Avatar" width="100%" height="100%" class="items-right rounded-xl">
                            </div>
                        @else
                            <div class="flex flex-col items-center w-full md:w-1/4 space-y-2">
                                <div
                                    style="border: 1px dotted black; height: 130px; width: 130px;display: flex;justify-content: center;align-items:center">
                                    <p>Pas foto 4x3</p>
                                </div>
                            </div>
                        @endif
                        <div class="w-full md:w-3/4 text-sm">
                            <section class="space-y-2">
                                <div>
                                    <span>Nomor Induk Kependudukan:</span>
                                    @if ($user->nik)
                                        <span class="underline font-medium mr-2">{{ $user->nik }}</span>
                                        <i class="fa-solid fa-circle-check text-green-500"></i>
                                    @else
                                        <span>________________</span>
                                        <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                    @endif
                                </div>
                                <div>
                                    <span>Nomor Induk Siswa Nasional:</span>
                                    @if ($user->nisn)
                                        <span class="underline font-medium">{{ $user->nisn }}</span>
                                        <i class="fa-solid fa-circle-check text-green-500"></i>
                                    @else
                                        <span>________________</span>
                                        <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                    @endif
                                </div>
                                <div>
                                    <span>Nama Lengkap:</span>
                                    @if ($user->name)
                                        <span class="underline font-medium">{{ $user->name }}</span>
                                        <i class="fa-solid fa-circle-check text-green-500"></i>
                                    @else
                                        <span>________________</span>
                                        <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                    @endif
                                </div>
                                <div>
                                    <span>Tempat Lahir:</span>
                                    @if ($user->place_of_birth)
                                        <span class="underline font-medium">{{ $user->place_of_birth }}</span>
                                        <i class="fa-solid fa-circle-check text-green-500"></i>
                                    @else
                                        <span>________________</span>
                                        <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                    @endif
                                </div>
                                <div>
                                    <span>Tanggal Lahir:</span>
                                    @if ($user->date_of_birth)
                                        <span class="underline font-medium">{{ $user->date_of_birth }}</span>
                                        <i class="fa-solid fa-circle-check text-green-500"></i>
                                    @else
                                        <span>________________</span>
                                        <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                    @endif
                                </div>
                                <div>
                                    <span>Jenis Kelamin:</span>
                                    <span
                                        class="underline font-medium">{{ $user->gender ? 'Laki-laki' : 'Perempuan' }}</span>
                                    <i class="fa-solid fa-circle-check text-green-500"></i>
                                </div>
                                <div>
                                    <span>Alamat:</span>
                                    @if ($user->address)
                                        <span class="underline font-medium">{{ $user->address }}</span>
                                        <i class="fa-solid fa-circle-check text-green-500"></i>
                                    @else
                                        <span>________________</span>
                                        <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                    @endif
                                </div>
                            </section>

                            <a href="{{ route('database.edit', $user->id) }}"
                                class="cursor-pointer text-center inline-block bg-yellow-500 hover:bg-yellow-600 text-xs text-white px-5 py-2 rounded-lg"><i
                                    class="fa-regular fa-pen-to-square"></i> Ubah data</a>
                            <button onclick="checkNext(2)"
                                class="mt-4 bg-sky-500 hover:bg-sky-600 px-5 py-2 text-xs rounded-lg text-white">Lanjutkan
                                <i class="fa-solid fa-arrow-right-long"></i></button>
                        </div>
                    </section>

                    {{-- Orang Tua --}}
                    <section class="hidden" id="check-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <section class="space-y-2 text-sm">
                                <h2 class="font-bold text-lg">Biodata Ayah</h2>
                                <div>
                                    <span>Nama Lengkap:</span>
                                    @if ($user->father->name)
                                        <span class="underline font-medium">{{ $user->father->name }}</span>
                                        <i class="fa-solid fa-circle-check text-green-500"></i>
                                    @else
                                        <span>________________</span>
                                        <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                    @endif
                                </div>
                                <div>
                                    <span>Pekerjaan:</span>
                                    @if ($user->father->job)
                                        <span class="underline font-medium">{{ $user->father->job }}</span>
                                        <i class="fa-solid fa-circle-check text-green-500"></i>
                                    @else
                                        <span>________________</span>
                                        <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                    @endif
                                </div>
                                <div>
                                    <span>No. Telpon:</span>
                                    @if ($user->father->phone)
                                        <span class="underline font-medium">{{ $user->father->phone }}</span>
                                        <i class="fa-solid fa-circle-check text-green-500"></i>
                                    @else
                                        <span>________________</span>
                                        <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                    @endif
                                </div>
                            </section>
                            <section class="space-y-2 text-sm">
                                <h2 class="font-bold text-lg">Biodata Ibu</h2>
                                <div>
                                    <span>Nama Lengkap:</span>
                                    @if ($user->mother->name)
                                        <span class="underline font-medium">{{ $user->mother->name }}</span>
                                        <i class="fa-solid fa-circle-check text-green-500"></i>
                                    @else
                                        <span>________________</span>
                                        <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                    @endif
                                </div>
                                <div>
                                    <span>Pekerjaan:</span>
                                    @if ($user->mother->job)
                                        <span class="underline font-medium">{{ $user->mother->job }}</span>
                                        <i class="fa-solid fa-circle-check text-green-500"></i>
                                    @else
                                        <span>________________</span>
                                        <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                    @endif
                                </div>
                                <div>
                                    <span>No. Telpon:</span>
                                    @if ($user->mother->phone)
                                        <span class="underline font-medium">{{ $user->mother->phone }}</span>
                                        <i class="fa-solid fa-circle-check text-green-500"></i>
                                    @else
                                        <span>________________</span>
                                        <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                    @endif
                                </div>
                            </section>
                        </div>
                        <section class="space-y-3 text-sm mt-3">
                            <div>
                                <span>Penghasilan Orang Tua:</span>
                                @if ($user->income_parent)
                                    <span class="underline font-medium">{{ $user->income_parent }}</span>
                                    <i class="fa-solid fa-circle-check text-green-500"></i>
                                @else
                                    <span>________________</span>
                                    <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                @endif
                            </div>
                            <p class="text-xs text-gray-700 mt-3"><span class="font-bold">Catatan:</span> Silahkan
                                untuk isi data orang tua. Untuk No. Telpon boleh salah satu saja.</p>
                        </section>

                        <a href="{{ route('database.edit', $user->id) }}"
                            class="cursor-pointer text-center inline-block bg-yellow-500 hover:bg-yellow-600 text-xs text-white px-5 py-2 rounded-lg"><i
                                class="fa-regular fa-pen-to-square"></i> Ubah data</a>
                        <button onclick="checkNext(3)"
                            class="mt-4 bg-sky-500 hover:bg-sky-600 px-5 py-2 text-xs rounded-lg text-white">Lanjutkan
                            <i class="fa-solid fa-arrow-right-long"></i></button>
                    </section>

                    {{-- Info PMB --}}
                    <section class="hidden" id="check-3">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <section class="space-y-2 text-sm">
                                <div>
                                    <span>Program Studi:</span>
                                    @if ($user->programtype_id)
                                        <span class="underline font-medium">{{ $user->programtype->name }}</span>
                                        <i class="fa-solid fa-circle-check text-green-500"></i>
                                    @else
                                        <span>________________</span>
                                        <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                    @endif
                                </div>
                                <div>
                                    <span>Program Studi:</span>
                                    @if ($user->program)
                                        <span class="underline font-medium">{{ $user->program }}</span>
                                        <i class="fa-solid fa-circle-check text-green-500"></i>
                                    @else
                                        <span>________________</span>
                                        <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                    @endif
                                </div>
                                <div>
                                    <span>Presenter:</span>
                                    @if ($user->presenter)
                                        <span class="underline font-medium">{{ $user->presenter->name }}</span>
                                        <i class="fa-solid fa-circle-check text-green-500"></i>
                                    @else
                                        <span>________________</span>
                                        <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                    @endif
                                </div>
                                <div>
                                    <span>Jurusan:</span>
                                    @if ($user->major)
                                        <span class="underline font-medium">{{ $user->major }}</span>
                                        <i class="fa-solid fa-circle-check text-green-500"></i>
                                    @else
                                        <span>________________</span>
                                        <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                    @endif
                                </div>
                                <div>
                                    <span>Asal Sekolah:</span>
                                    @if ($user->school)
                                        <span class="underline font-medium">{{ $user->SchoolApplicant->name }}</span>
                                        <i class="fa-solid fa-circle-check text-green-500"></i>
                                    @else
                                        <span>________________</span>
                                        <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                    @endif
                                </div>
                                <div>
                                    <span>Tahun Lulus:</span>
                                    @if ($user->year)
                                        <span class="underline font-medium">{{ $user->year }}</span>
                                        <i class="fa-solid fa-circle-check text-green-500"></i>
                                    @else
                                        <span>________________</span>
                                        <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                    @endif
                                </div>
                            </section>
                            <section class="space-y-2 text-sm">
                                <div>
                                    <span>PMB:</span>
                                    @if ($user->pmb)
                                        <span class="underline font-medium">{{ $user->pmb }}</span>
                                        <i class="fa-solid fa-circle-check text-green-500"></i>
                                    @else
                                        <span>________________</span>
                                        <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                    @endif
                                </div>
                                <div>
                                    <span>Email:</span>
                                    @if ($user->email)
                                        <span class="underline font-medium">{{ $user->email }}</span>
                                        <i class="fa-solid fa-circle-check text-green-500"></i>
                                    @else
                                        <span>________________</span>
                                        <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                    @endif
                                </div>
                                <div>
                                    <span>No. Telpon:</span>
                                    @if ($user->phone)
                                        <span class="underline font-medium">{{ $user->phone }}</span>
                                        <i class="fa-solid fa-circle-check text-green-500"></i>
                                    @else
                                        <span>________________</span>
                                        <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                    @endif
                                </div>
                                <div>
                                    <span>Sumber Database:</span>
                                    @if ($user->source_id)
                                        <span class="underline font-medium">{{ $user->sourcesetting->name }}</span>
                                        <i class="fa-solid fa-circle-check text-green-500"></i>
                                    @else
                                        <span>________________</span>
                                        <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                    @endif
                                </div>
                                <div>
                                    <span>Sumber Informasi:</span>
                                    @if ($user->source_daftar_id)
                                        <span
                                            class="underline font-medium">{{ $user->sourcedaftarsetting->name }}</span>
                                        <i class="fa-solid fa-circle-check text-green-500"></i>
                                    @else
                                        <span>________________</span>
                                        <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                    @endif
                                </div>
                            </section>
                        </div>

                        <a href="{{ route('database.edit', $user->id) }}"
                            class="cursor-pointer text-center inline-block bg-yellow-500 hover:bg-yellow-600 text-xs text-white px-5 py-2 rounded-lg"><i
                                class="fa-regular fa-pen-to-square"></i> Ubah data</a>
                        <button onclick="modalCheck()"
                            class="mt-4 bg-sky-500 hover:bg-sky-600 px-5 py-2 text-xs rounded-lg text-white">Lanjutkan Integrasi
                            <i class="fa-solid fa-arrow-right-long"></i></button>
                    </section>

                </section>
            </div>
        </div>
    </div>
@endif

<script>
    const checkNext = (page) => {
        switch (page) {
            case 1:
                document.getElementById('check-1').style.display = 'flex';
                document.getElementById('check-2').style.display = 'none';
                document.getElementById('check-3').style.display = 'none';

                document.getElementById('check-1-title').style.color = '#0ea5e9';
                document.getElementById('check-2-title').style.color = '#374151';
                document.getElementById('check-3-title').style.color = '#374151';
                break;
            case 2:
                document.getElementById('check-1').style.display = 'none';
                document.getElementById('check-2').style.display = 'block';
                document.getElementById('check-3').style.display = 'none';

                document.getElementById('check-1-title').style.color = '#374151';
                document.getElementById('check-2-title').style.color = '#0ea5e9';
                document.getElementById('check-3-title').style.color = '#374151';
                break;
            case 3:
                document.getElementById('check-1').style.display = 'none';
                document.getElementById('check-2').style.display = 'none';
                document.getElementById('check-3').style.display = 'block';

                document.getElementById('check-1-title').style.color = '#374151';
                document.getElementById('check-2-title').style.color = '#374151';
                document.getElementById('check-3-title').style.color = '#0ea5e9';
                break;
            default:
                document.getElementById('check-1').style.display = 'flex';
                document.getElementById('check-2').style.display = 'none';
                document.getElementById('check-3').style.display = 'none';

                document.getElementById('check-1-title').style.color = '#0ea5e9';
                document.getElementById('check-2-title').style.color = '#374151';
                document.getElementById('check-3-title').style.color = '#374151';
                break;
        }
    }
</script>
