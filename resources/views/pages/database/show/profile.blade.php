<x-app-layout>
    <x-slot name="header">
        @include('pages.database.components.navigation')
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
        @if (session('error'))
            <div id="alert" class="mx-2 flex items-center p-4 bg-red-500 text-white rounded-lg" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div class="ml-3 text-sm font-medium">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        @if (session('message'))
            <div id="alert" class="mx-2 flex items-center p-4 bg-emerald-400 text-white rounded-lg" role="alert">
                <i class="fa-solid fa-circle-check"></i>
                <div class="ml-3 text-sm font-medium">
                    {{ session('message') }}
                </div>
            </div>
        @endif
        @if ($errors->first('berkas'))
            <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-red-500 text-white rounded-lg" role="alert">
                <i class="fa-solid fa-circle-xmark"></i>
                <div class="ml-3 text-sm font-medium">
                    {{ $errors->first('berkas') }}
                </div>
            </div>
        @endif
    </div>

    <div id="identity_user" class="hidden">{{ $user->identity }}</div>

    <div class="max-w-7xl mx-auto flex flex-col md:flex-row py-4 sm:px-6 lg:px-8 gap-5 mt-3">
        <div class="w-full md:w-4/6 mx-auto space-y-6">
            <div class="p-8 bg-white shadow-sm sm:rounded-lg">
                <div class="w-full">
                    <section>
                        <header class="flex md:justify-between flex-col md:flex-row items-start md:items-center gap-3">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">
                                    Daftar Riwayat Hidup
                                </h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    Mahasiswa orangtua/wali mahasiswa Politeknik LP3I Kampus Tasikmalaya.
                                </p>
                            </div>
                            <div class="flex gap-2">
                                @if ($account > 0 && $user->programtype_id && $user->program)
                                    <a href="{{ route('database.print', $user->identity) }}"
                                        class="inline-block bg-lp3i-100 hover:bg-lp3i-200 px-3 py-1 rounded-md text-xs text-white"><i
                                            class="fa-solid fa-print"></i></a>
                                @else
                                    @if (!$user->programtype_id && !$user->program)
                                        <button onclick="return alert('Program Studi / Program Kuliah belum dipilih.')"
                                            class="inline-block bg-gray-200 text-gray-600 px-3 py-1 rounded-md text-xs"><i
                                                class="fa-solid fa-print"></i></button>
                                    @endif
                                @endif
                                <a href="{{ route('database.edit', $user->id) }}"
                                    class="inline-block bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded-md text-xs text-white"><i
                                        class="fa-regular fa-pen-to-square"></i></a>
                                @if (!$user->is_daftar && !$user->is_register)
                                    <button class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded-md text-xs text-white"
                                        onclick="event.preventDefault(); deleteRecord({{ $user->id }})">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                @endif
                            </div>
                        </header>
                        <hr class="my-3">
                        <section class="space-y-5">
                            <div class="space-y-1">
                                <h2 class="text-lg font-bold text-gray-900">Biodata Mahasiswa</h2>
                                <ul class="text-sm space-y-1 text-gray-800">
                                    <li class="space-x-2">
                                        <span>Nama Lengkap:</span>
                                        <span class="border-b">{{ $user->name == null ? '___' : $user->name }}</span>
                                    </li>
                                    @if (Auth::user()->role == 'A')
                                        <li class="space-x-2">
                                            <span>Presenter:</span>
                                            <span
                                                class="border-b">{{ $user->identity_user == null ? '___' : $user->presenter->name }}</span>
                                        </li>
                                    @endif
                                    <li class="space-x-2">
                                        <span>Program Kuliah:</span>
                                        <span
                                            class="border-b">{{ $user->programtype_id == null ? '___' : $user->programtype->name }}</span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Program Studi:</span>
                                        <span
                                            class="border-b">{{ $user->program == null ? '___' : $user->program }}</span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Tempat / Tanggal Lahir:</span>
                                        <span class="border-b">
                                            {{ $user->place_of_birth == null ? '___' : $user->place_of_birth }}
                                            /
                                            {{ $user->date_of_birth == null ? '___' : $user->date_of_birth }}
                                    </li>
                                    <li class="space-x-2">
                                        <span>Pendidikan Terakhir:</span>
                                        <span class="border-b">
                                            {{ $user->SchoolApplicant == null ? '___' : $user->SchoolApplicant->name }}
                                        </span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Alamat:</span>
                                        <span class="border-b">
                                            {{ $user->address == null ? '___' : $user->address }}
                                        </span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>No. Telpon:</span>
                                        <span class="border-b">
                                            {{ $user->phone == null ? '___' : $user->phone }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="space-y-1">
                                <h2 class="text-lg font-bold text-gray-900">Biodata Ayah</h2>
                                <ul class="text-sm space-y-1 text-gray-800">
                                    <li class="space-x-2">
                                        <span>Nama Lengkap:</span>
                                        <span
                                            class="border-b">{{ $father->name == null ? '___' : $father->name }}</span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Pekerjaan:</span>
                                        <span class="border-b">{{ $father->job == null ? '___' : $father->job }}</span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Tempat / Tanggal Lahir:</span>
                                        <span class="border-b">
                                            {{ $father->place_of_birth == null ? '___' : $father->place_of_birth }}
                                            /
                                            {{ $father->date_of_birth == null ? '___' : $father->date_of_birth }}
                                    </li>
                                    <li class="space-x-2">
                                        <span>Pendidikan Terakhir:</span>
                                        <span class="border-b">
                                            {{ $father->education == null ? '___' : $father->education }}
                                        </span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Alamat:</span>
                                        <span class="border-b">
                                            {{ $father->address == null ? '___' : $father->address }}
                                        </span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>No. Telpon:</span>
                                        <span class="border-b">
                                            {{ $father->phone == null ? '___' : $father->phone }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="space-y-1">
                                <h2 class="text-lg font-bold text-gray-900">Biodata Ibu</h2>
                                <ul class="text-sm space-y-1 text-gray-800">
                                    <li class="space-x-2">
                                        <span>Nama Lengkap:</span>
                                        <span
                                            class="border-b">{{ $mother->name == null ? '___' : $mother->name }}</span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Pekerjaan:</span>
                                        <span class="border-b">{{ $mother->job == null ? '___' : $mother->job }}</span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Tempat / Tanggal Lahir:</span>
                                        <span class="border-b">
                                            {{ $mother->place_of_birth == null ? '___' : $mother->place_of_birth }}
                                            /
                                            {{ $mother->date_of_birth == null ? '___' : $mother->date_of_birth }}
                                    </li>
                                    <li class="space-x-2">
                                        <span>Pendidikan Terakhir:</span>
                                        <span class="border-b">
                                            {{ $mother->education == null ? '___' : $mother->education }}
                                        </span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Alamat:</span>
                                        <span class="border-b">
                                            {{ $mother->address == null ? '___' : $mother->address }}
                                        </span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>No. Telpon:</span>
                                        <span class="border-b">
                                            {{ $mother->phone == null ? '___' : $mother->phone }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </section>
                    </section>
                </div>
            </div>
        </div>

        <div class="w-full md:w-2/6 mx-auto space-y-6">
            <div class="p-8 bg-white shadow-sm sm:rounded-lg">
                <div class="w-full">
                    <section>
                        <header class="flex md:justify-between flex-col md:flex-row items-start md:items-center gap-3">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">
                                    Pengaturan
                                </h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    Berikut ini pengaturan mahasiswa.
                                </p>
                            </div>
                        </header>
                        <hr class="my-3">
                        <section class="flex flex-col justify-between gap-3">
                            @if ($account == 0 && $user->is_applicant == 1)
                                <button type="button" onclick="modalAccount()"
                                    class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg text-white text-sm">
                                    <i class="fa-solid fa-user-plus mr-1"></i>
                                    <span>Buat Akun</span>
                                </button>
                                <p class="text-xs text-center text-gray-700">
                                    Untuk registrasi, buat akun terlebih dahulu.
                                </p>
                            @elseif($account > 0)
                                <span
                                    class="text-white bg-emerald-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs w-full sm:w-auto px-5 py-2.5 text-center"><i
                                        class="fa-solid fa-circle-check"></i> Sudah Memiliki Akun</span>
                                @if ($user->identity_user === '6281313608558')
                                    <p class="text-xs text-center text-gray-500">
                                        Belum bisa dijadikan aplikan, karena presenter belum diubah dari
                                        Administrator.
                                    </p>
                                @endif
                            @endif
                            <div>
                                <form action="{{ route('database.is_schoolarship', $user->id) }}" method="get">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" value="{{ $user->schoolarship }}"
                                            class="sr-only peer" {{ $user->schoolarship == 1 ? 'checked' : '' }}>
                                        <button type="submit"
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                        </button>
                                        <span class="ml-3 text-sm font-medium text-gray-900">Beasiswa</span>
                                    </label>
                                </form>
                            </div>
                            @if ($user->identity_user !== '6281313608558')
                                <div class="flex justify-between items-center gap-2">
                                    @if ($user->is_applicant)
                                        <form class="space-y-3"
                                            action="{{ route('statusdatabaseaplikan.destroy', $user->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" class="sr-only peer" checked>
                                                <button type="submit"
                                                    {{ $user->is_register || $user->is_daftar ? 'disabled' : '' }}
                                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></button>
                                                <span class="ml-3 text-sm font-medium text-emerald-600">Aplikan</span>
                                            </label>
                                        </form>
                                    @else
                                        <form action="{{ route('database.is_applicant', $user->id) }}"
                                            method="get">
                                            <input type="hidden" name="change_pmb" value="{{ $user->pmb }}">
                                            <input type="hidden" id="session_aplikan" name="session">
                                            <input type="hidden" name="identity_user"
                                                value="{{ $user->identity }}">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" class="sr-only peer">
                                                <button type="submit"
                                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                                </button>
                                                <span class="ml-3 text-sm font-medium text-gray-900">Aplikan</span>
                                            </label>
                                        </form>
                                    @endif
                                    @if ($user->is_applicant && $status_applicant)
                                        <div class="flex items-center gap-3 mt-1">
                                            <button onclick="modalEditAplikan()">
                                                <i
                                                    class="fa-solid fa-pen-to-square text-yellow-500 hover:text-yellow-600"></i>
                                            </button>
                                            <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                        </div>
                                    @endif
                                </div>
                            @endif
                            @if ($user->is_applicant == 1)
                                <div class="flex justify-between items-center gap-2">
                                    @if ($user->is_daftar && $enrollment)
                                        <form class="space-y-3"
                                            action="{{ route('statusdatabasedaftar.destroy', $user->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" class="sr-only peer" checked>
                                                <button type="submit" {{ $user->is_register ? 'disabled' : '' }}
                                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></button>
                                                <span class="ml-3 text-sm font-medium text-emerald-600">Daftar</span>
                                            </label>
                                        </form>
                                        <div class="flex items-center gap-3 mt-1">
                                            <button onclick="modalEditDaftar()">
                                                <i
                                                    class="fa-solid fa-pen-to-square text-yellow-500 hover:text-yellow-600"></i>
                                            </button>
                                            <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                        </div>
                                    @else
                                        <div class="mt-1">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"class="sr-only peer">
                                                <button disabled
                                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                                </button>
                                                <span class="ml-3 text-sm font-medium text-gray-900">Daftar</span>
                                            </label>
                                        </div>
                                        <button type="button" onclick="modalDaftar()"
                                            class="text-white bg-red-500 hover:bg-red-600 font-medium rounded-lg text-xs px-5 py-2.5 text-center inline-flex items-center mr-2"><i
                                                class="fa-solid fa-receipt mr-1"></i>
                                            Masukan nominal
                                        </button>
                                    @endif
                                </div>
                            @endif
                            @if ($user->is_applicant == 1 && $user->is_daftar == 1 && $account > 0)
                                <div class="flex justify-between items-center gap-2">
                                    @if ($user->is_register && $registration)
                                        <form class="space-y-3"
                                            action="{{ route('statusdatabaseregistrasi.destroy', $user->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" class="sr-only peer" checked>
                                                <button type="submit"
                                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></button>
                                                <span
                                                    class="ml-3 text-sm font-medium text-emerald-600">Registrasi</span>
                                            </label>
                                        </form>
                                        <div class="flex items-center gap-3 mt-1">
                                            <button onclick="modalEditRegistrasi()">
                                                <i
                                                    class="fa-solid fa-pen-to-square text-yellow-500 hover:text-yellow-600"></i>
                                            </button>
                                            <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                        </div>
                                    @else
                                        <div class="mt-1">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"class="sr-only peer">
                                                <button disabled
                                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                                </button>
                                                <span class="ml-3 text-sm font-medium text-gray-900">Registrasi</span>
                                            </label>
                                        </div>
                                        <button type="button" onclick="modalRegistrasi()"
                                            class="text-white bg-red-500 hover:bg-red-600 font-medium rounded-lg text-xs px-5 py-2.5 text-center inline-flex items-center mr-2"><i
                                                class="fa-solid fa-receipt mr-1"></i>
                                            Masukan nominal
                                        </button>
                                    @endif
                                </div>
                            @endif
                            @if (
                                $user->pmb &&
                                    $user->nik &&
                                    $user->nisn &&
                                    $user->name &&
                                    $user->gender !== null &&
                                    $user->date_of_birth &&
                                    $user->place_of_birth &&
                                    $user->programtype_id &&
                                    $user->address &&
                                    $user->program &&
                                    $user->presenter &&
                                    $user->school &&
                                    $user->education &&
                                    $user->year &&
                                    $user->major &&
                                    $user->email &&
                                    $user->phone)
                                @if ($user->is_applicant == 1 && $user->is_daftar == 1 && $user->is_register == 1 && $account > 0 && $registration)
                                    <hr class="my-2">
                                    <button onclick="getTokenMisil()"
                                        class="text-center text-xs bg-sky-500 hover:bg-sky-600 text-white px-5 py-2.5 rounded-lg"><i
                                            class="fa-solid fa-circle-nodes"></i> Integrasi dengan MISIL</button>
                                    @if ($integration_misil)
                                        <p class="text-xs text-center text-gray-500">Aplikan sudah
                                            terintegrasi.<br />Jika
                                            ada
                                            perubahan boleh klik lagi!</p>
                                    @endif
                                @endif
                            @else
                                @if ($user->is_applicant == 1 && $user->is_daftar == 1 && $user->is_register == 1 && $account > 0 && $registration)
                                    <hr class="my-2">
                                    <button onclick="modalCheck()"
                                        class="text-center text-xs bg-red-500 hover:bg-red-600 text-white px-5 py-2.5 rounded-lg"><i
                                            class="fa-solid fa-circle-nodes"></i> Periksa Kelengkapan
                                        Integrasi</button>
                                    <p class="text-xs text-center text-gray-500">Fitur ini belum dapat dilakukan karena
                                        biodata belum lengkap. <a href="{{ route('database.edit', $user->id) }}"
                                            class="underline">Ubah sekarang</a></p>
                                @endif
                            @endif
                        </section>
                    </section>
                </div>
            </div>
            <div class="p-8 bg-white shadow-sm sm:rounded-lg">
                <div class="w-full">
                    <section>
                        <header class="flex md:justify-between flex-col md:flex-row items-start md:items-center gap-3">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">
                                    Informasi Aplikan
                                </h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    Berikut ini adalah informasi tentang status aplikan.
                                </p>
                            </div>
                        </header>
                        <hr class="my-3">
                        <section class="flex flex-col gap-3">
                            @if ($user->is_applicant && $status_applicant)
                                <div class="space-y-2">
                                    <h2 class="text-sm font-semibold text-gray-900">Aplikan:</h2>
                                    <ul class="max-w-md space-y-1 text-sm text-gray-500 list-inside">
                                        <li class="flex items-center space-x-2">
                                            <i class="block fa-regular fa-calendar text-gray-400"></i>
                                            <span class="inline-block mr-2">Tanggal:
                                                <span class="underline">{{ $status_applicant->date }}</span>
                                            </span>
                                        </li>
                                        <li class="flex items-center space-x-2">
                                            <i class="block fa-solid fa-timeline text-gray-400"></i>
                                            <span class="inline-block mr-2">Gelombang:
                                                <span class="underline">{{ $status_applicant->session }}</span>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <p class="text-sm text-gray-600">
                                    <i class="fa-solid fa-circle-xmark text-red-500 mr-1"></i>
                                    <span>Belum aplikan</span>
                                </p>
                            @endif
                            @if ($enrollment)
                                <div class="space-y-2">
                                    <h2 class="text-sm font-semibold text-gray-900">Daftar:</h2>
                                    <ul class="max-w-md space-y-1 text-sm text-gray-500 list-inside">
                                        <li class="flex items-center space-x-2">
                                            <i class="block fa-solid fa-receipt text-gray-400"></i>
                                            <span class="inline-block mr-2">No. Kwitansi:
                                                <span class="underline">{{ $enrollment->receipt }}</span>
                                            </span>
                                        </li>
                                        <li class="flex items-center space-x-2">
                                            <i class="block fa-regular fa-calendar text-gray-400"></i>
                                            <span class="inline-block mr-2">Tanggal:
                                                <span class="underline">{{ $enrollment->date }}</span>
                                            </span>
                                        </li>
                                        <li class="flex items-center space-x-2">
                                            <i class="block fa-solid fa-timeline text-gray-400"></i>
                                            <span class="inline-block mr-2">Gelombang:
                                                <span class="underline">{{ $enrollment->session }}</span>
                                            </span>
                                        </li>
                                        <li class="flex items-center space-x-2">
                                            <i class="fa-regular fa-note-sticky block text-gray-400"></i>
                                            <span class="inline-block mr-2">Keterangan:
                                                <span class="underline">{{ $enrollment->register }}</span>
                                            </span>
                                        </li>
                                        <li class="flex items-center space-x-2">
                                            <i class="fa-regular fa-note-sticky block text-gray-400"></i>
                                            <span class="inline-block mr-2">Keterangan Daftar:
                                                <span class="underline">{{ $enrollment->register_end }}</span>
                                            </span>
                                        </li>
                                        <li class="flex items-center space-x-2">
                                            <i class="fa-solid fa-coins block text-gray-400"></i>
                                            <span class="inline-block mr-2">Nominal:
                                                <span
                                                    class="underline">Rp{{ number_format($enrollment->nominal, 0, ',', '.') }}</span>
                                            </span>
                                        </li>
                                        @if ($enrollment->repayment)
                                            <li class="flex items-center space-x-2">
                                                <i class="block fa-regular fa-calendar text-gray-400"></i>
                                                <span class="inline-block mr-2">Pengembalian BK:
                                                    <span class="underline">{{ $enrollment->repayment }}</span>
                                                </span>
                                            </li>
                                            <li class="flex items-center space-x-2">
                                                <i class="fa-solid fa-money-bill-transfer block text-gray-400"></i>
                                                <span class="inline-block mr-2">Debit:
                                                    <span
                                                        class="underline">Rp{{ number_format($enrollment->debit, 0, ',', '.') }}</span>
                                                </span>
                                            </li>
                                        @endif
                                        <li class="flex items-center space-x-2">
                                            <i class="fa-regular fa-credit-card block text-gray-400"></i>
                                            <span class="inline-block mr-2">Kas Pendaftaran:
                                                <span
                                                    class="underline">Rp{{ number_format($enrollment->nominal - $enrollment->debit, 0, ',', '.') }}</span>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <p class="text-sm text-gray-600">
                                    <i class="fa-solid fa-circle-xmark text-red-500 mr-1"></i>
                                    <span>Belum daftar</span>
                                </p>
                            @endif
                            @if ($registration)
                                <div class="space-y-2">
                                    <h2 class="text-sm font-semibold text-gray-900">Registrasi:</h2>
                                    <ul class="max-w-md space-y-1 text-sm text-gray-500 list-inside">
                                        <li class="flex items-center space-x-2">
                                            <i class="block fa-regular fa-calendar text-gray-400"></i>
                                            <span class="inline-block mr-2">Tanggal:
                                                <span class="underline">{{ $registration->date }}</span>
                                            </span>
                                        </li>
                                        <li class="flex items-center space-x-2">
                                            <i class="fa-solid fa-coins block text-gray-400"></i>
                                            <span class="inline-block mr-2">Nominal:
                                                <span
                                                    class="underline">Rp{{ number_format($registration->nominal, 0, ',', '.') }}</span>
                                            </span>
                                        </li>
                                        <li class="flex items-center space-x-2">
                                            <i class="block fa-solid fa-money-bills text-gray-400"></i>
                                            <span class="inline-block mr-2">Harga Deal:
                                                <span
                                                    class="underline">Rp{{ number_format($registration->deal, 0, ',', '.') }}</span>
                                            </span>
                                        </li>
                                        <li class="flex items-center space-x-2">
                                            <i class="block fa-solid fa-percent text-gray-400"></i>
                                            <span class="inline-block mr-2">Potongan:
                                                <span
                                                    class="underline">Rp{{ number_format($registration->discount, 0, ',', '.') }}</span>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <p class="text-sm text-gray-600">
                                    <i class="fa-solid fa-circle-xmark text-red-500 mr-1"></i>
                                    <span>Belum registrasi</span>
                                </p>
                            @endif
                        </section>
                    </section>
                </div>
            </div>
        </div>
    </div>
    @include('pages.database.show.modal.account')
    @include('pages.database.show.modal.aplikan')
    @include('pages.database.show.modal.daftar')
    @if ($account)
        @include('pages.database.show.modal.registrasi')
    @endif
    @if ($registration && $enrollment && $account)
        @include('pages.database.show.modal.check')
    @endif
</x-app-layout>

@if (!$user->is_applicant && !$status_applicant)
    <script>
        const aplikanSetting = () => {
            const currentDate = new Date();
            const currentMonth = currentDate.getMonth() + 1;

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

            document.getElementById('session_aplikan').value = session;
        }

        aplikanSetting();
    </script>
@endif

<script>
    const validateNumber = (e) => {
        let number = e.target.value.replace(/[^0-9]/g, '');
        let parsedNumber = parseInt(number);

        if (!isNaN(parsedNumber)) {
            let formattedNumber = parsedNumber.toLocaleString('id-ID');
            e.target.value = formattedNumber;
        } else {
            e.target.value = null;
        }
    }
</script>
<script>
    const modalAccount = () => {
        let modal = document.getElementById('modal-account');
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }

    const modalRegistrasi = () => {
        let modal = document.getElementById('modal-registrasi');
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }

    const modalEditRegistrasi = () => {
        let modal = document.getElementById('modal-edit-registrasi');
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }

    const modalEditAplikan = () => {
        let modal = document.getElementById('modal-edit-aplikan');
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }

    const modalDaftar = () => {
        let modal = document.getElementById('modal-daftar');
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }

    const modalEditDaftar = () => {
        let modal = document.getElementById('modal-edit-daftar');
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }

    const modalCheck = () => {
        let modal = document.getElementById('modal-check');
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }

    const deleteRecord = (id) => {
        if (confirm('Apakah kamu yakin akan menghapus data?')) {
            $.ajax({
                url: `/database/${id}`,
                type: 'POST',
                data: {
                    '_method': 'DELETE',
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    window.location.href = '/database';
                },
                error: function(xhr, status, error) {
                    alert('Error deleting record');
                    console.log(error);
                }
            })
        }
    }
</script>
<script src="{{ asset('js/axios.min.js') }}"></script>
<script>
    const saveAplikan = async (data, token, identity) => {
        const headers = {
            'X-Auth-Token': `${token}`,
            'X-Fullname': 'Database Marketing',
            'X-Url': '#/dashboard-mkt',
            'X-User': 'integrasi',
            'Content-Type': 'application/json',
        };
        let bucket = [data, headers];
        await axios.post(`https://api.politekniklp3i-tasikmalaya.ac.id/misil/integration`, bucket)
            .then(async (response) => {
                alert(response.data.message);
                await axios.post(`/integration`, {
                        identity_user: identity,
                        platform: 'misil',
                    })
                    .then((response) => {
                        location.reload();
                    })
                    .catch((error) => {
                        console.log(error.message);
                    });
            })
            .catch((error) => {
                console.log(error.message);
            });
    }
    const getTokenMisil = async () => {
        let identityVal = document.getElementById('identity_user').innerText;

        try {
            const database = axios.get(`/api/database/${identityVal}`);
            const programs = axios.get(`https://dashboard.politekniklp3i-tasikmalaya.ac.id/api/programs`);
            const misilAuth = axios.post(
                `https://api.politekniklp3i-tasikmalaya.ac.id/misil/token`, {
                    namaUser: "integrasi",
                    kataSandi: "IntegrasiMisil311"
                });
            await axios.all([database, programs, misilAuth])
                .then(axios.spread((database, programs, misilAuth) => {
                    let token = misilAuth.data.messages['X-AUTH-TOKEN']
                    let program_studi = database.data.user.program;
                    let program = programs.data.find((result) =>
                        `${result.level} ${result.title}` == program_studi)

                    // Aplikan Datang
                    let method = 'simpan';
                    let nik = database.data.user.nik;
                    let tahun_akademik =
                        `${database.data.user.pmb}/${parseInt(database.data.user.pmb) + 1}`;
                    let nama_lengkap = database.data.user.name;
                    let tempat_lahir = database.data.user.place_of_birth;
                    let tgl_lahir = database.data.user.date_of_birth;
                    let jenis_kelamin = database.data.user.gender == 1 ? 'L' : 'P';
                    let no_hp = database.data.user.phone;
                    let whatsapp = database.data.user.phone;
                    let facebook = '-';
                    let instagram = '-';
                    let pendidikan_terakhir = database.data.user.education;
                    let asal_sekolah = database.data.user.school_applicant.name;
                    let jurusan_sekolah = database.data.user.major;
                    let tahun_lulus = database.data.user.year;
                    let email = database.data.user.email;
                    let nama_ortu = database.data.user.father.name || database.data.user.mother.name;
                    let pekerjaan_ortu = database.data.user.father.job || database.data.user.mother.job;
                    let penghasilan_ortu = database.data.user.income_parent;
                    let nohp_ortu = database.data.user.father.phone || database.data.user.mother.phone;
                    let kode_jurusan = program.code;
                    let sumber_informasi = database.data.user.source_daftar_setting.name;
                    let sumber_aplikan = database.data.user.source_setting.name;
                    let kode_presenter = database.data.user.presenter.code;
                    let gelombang = database.data.registration.session;
                    let tgl_datang = database.data.registration.date;
                    let kode_siswa = "-";

                    console.log(database.data.user.presenter.code);

                    // Daftar
                    let isnew = true;
                    let kode_aplikan = null;
                    let tgl_daftar = database.data.enrollment.date;
                    let gelombang_daftar = database.data.registration.session;
                    let nomor_bukti = database.data.enrollment.receipt;
                    let biaya_pendaftaran = database.data.enrollment.nominal;
                    let diskon = 0;
                    let sumber_daftar = sumber_informasi;
                    let keterangan = database.data.enrollment.register;
                    let ket_daftar = database.data.enrollment.register_end;

                    const addressParts = database.data.user.address.split(', ');
                    const addressRtRw = addressParts[1].split(' ');

                    const data = {
                        // Aplikan datang
                        method,
                        nik,
                        tahun_akademik,
                        tahun_akademik,
                        nama_lengkap,
                        tempat_lahir,
                        tgl_lahir,
                        jenis_kelamin,
                        no_hp,
                        dusun: addressParts[0],
                        rtrw: `${addressRtRw[1]}/${addressRtRw[3]}`,
                        kelurahan: addressParts[2].replace('Desa/Kelurahan ',
                            ''),
                        kecamatan: addressParts[3].replace('Kecamatan ',
                            ''),
                        kota: addressParts[4].replace('Kota/Kabupaten ',
                            ''),
                        kode_pos: addressParts[6].replace('Kode Pos ',
                            ''),
                        whatsapp,
                        facebook,
                        instagram,
                        pendidikan_terakhir,
                        asal_sekolah,
                        jurusan_sekolah,
                        tahun_lulus,
                        email,
                        nama_ortu,
                        pekerjaan_ortu,
                        penghasilan_ortu,
                        nohp_ortu,
                        kode_jurusan,
                        sumber_informasi,
                        sumber_aplikan,
                        kode_presenter,
                        gelombang,
                        tgl_datang,
                        kode_siswa,
                        // Aplikan Daftar
                        isnew,
                        kode_aplikan,
                        tgl_daftar,
                        gelombang_daftar,
                        nomor_bukti,
                        biaya_pendaftaran,
                        diskon,
                        sumber_daftar,
                        keterangan,
                        ket_daftar,
                    }
                    saveAplikan(data, token, identityVal);
                }))
                .catch((error) => {
                    console.log(error);
                });
        } catch (error) {
            console.log(error);
        }
    }
</script>
