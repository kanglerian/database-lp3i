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

    <div class="max-w-7xl mx-auto flex flex-col md:flex-row py-4 sm:px-6 lg:px-8 gap-5 mt-3">
        <div class="w-full md:w-4/6 mx-auto space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
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
                                <a href="{{ route('database.print', $user->identity) }}"
                                    class="inline-block bg-lp3i-100 hover:bg-lp3i-200 px-3 py-1 rounded-md text-xs text-white"><i
                                        class="fa-solid fa-print"></i></a>
                                <a href="{{ route('database.edit', $user->id) }}"
                                    class="inline-block bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded-md text-xs text-white"><i
                                        class="fa-regular fa-pen-to-square"></i></a>
                                <button class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded-md text-xs text-white"
                                    onclick="event.preventDefault(); deleteRecord({{ $user->id }})">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
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
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
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
                        <section class="flex flex-col gap-3">
                            <div>
                                <form action="{{ route('database.is_applicant', $user->id) }}" method="get">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" value="{{ $user->is_applicant }}" class="sr-only peer"
                                            {{ $user->is_applicant == 1 ? 'checked' : '' }}>
                                        <button type="submit"
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                        </button>
                                        <span class="ml-3 text-sm font-medium text-gray-900">Aplikan</span>
                                    </label>
                                </form>
                            </div>
                            <div class="flex justify-between items-center gap-2">
                                <form action="{{ route('database.is_daftar', $user->id) }}" method="get">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" value="{{ $user->is_daftar }}" class="sr-only peer"
                                            {{ $user->is_daftar == 1 ? 'checked' : '' }}>
                                        <button type="submit"
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                        </button>
                                        <span class="ml-3 text-sm font-medium text-gray-900">Daftar</span>
                                    </label>
                                </form>
                                @if ($user->is_daftar)
                                    <button type="button" onclick="alert('Belum berfungsi!')"
                                        class="text-white bg-red-500 hover:bg-red-600 font-medium rounded-lg text-xs px-5 py-2.5 text-center inline-flex items-center mr-2"><i
                                            class="fa-solid fa-receipt mr-1"></i>
                                        Masukan nominal
                                    </button>
                                @endif
                            </div>
                            <div class="flex justify-between items-center gap-2">
                                <form action="{{ route('database.is_register', $user->id) }}" method="get">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" value="{{ $user->is_register }}" class="sr-only peer"
                                            {{ $user->is_register == 1 ? 'checked' : '' }}>
                                        <button type="submit"
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                        </button>
                                        <span class="ml-3 text-sm font-medium text-gray-900">Registrasi</span>
                                    </label>
                                </form>
                                @if ($user->is_register)
                                    @if ($registration)
                                        <div class="flex items-center gap-3 mt-1">
                                            <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                            <i class="fa-solid fa-receipt text-gray-400"></i>
                                            <i class="fa-solid fa-money-bills text-gray-400"></i>
                                            <i class="fa-solid fa-percent text-gray-400"></i>
                                        </div>
                                    @else
                                        <button type="button" onclick="modalRegistrasi()"
                                            class="text-white bg-red-500 hover:bg-red-600 font-medium rounded-lg text-xs px-5 py-2.5 text-center inline-flex items-center mr-2"><i
                                                class="fa-solid fa-receipt mr-1"></i>
                                            Masukan nominal
                                        </button>
                                    @endif
                                @endif
                            </div>
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
                        </section>
                    </section>
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    <section>
                        <header class="flex md:justify-between flex-col md:flex-row items-start md:items-center gap-3">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">
                                    Daftar & Registrasi
                                </h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    Berikut ini biaya dari daftar & registrasi.
                                </p>
                            </div>
                        </header>
                        <hr class="my-3">
                        <section class="flex flex-col gap-3">
                            {{-- @if ($registration)
                                <h2 class="text-base font-semibold text-gray-900">Daftar:</h2>
                                <ul class="max-w-md space-y-1 text-sm text-gray-500 list-inside">
                                    <li class="flex items-center space-x-2">
                                        <i class="block fa-solid fa-receipt text-gray-400"></i>
                                        <span class="inline-block mr-2">Nominal: Rp{{ number_format($registration->nominal, 0, ',', '.') }}</span>
                                    </li>
                                    <li class="flex items-center space-x-2">
                                        <i class="block fa-solid fa-money-bills text-gray-400"></i>
                                        <span class="inline-block mr-2">Harga Deal: Rp{{ number_format($registration->deal, 0, ',', '.') }}</span>
                                    </li>
                                    <li class="flex items-center space-x-2">
                                        <i class="block fa-solid fa-percent text-gray-400"></i>
                                        <span class="inline-block mr-2">Potongan: Rp{{ number_format($registration->discount, 0, ',', '.') }}</span>
                                    </li>
                                </ul>
                            @else
                                <p class="text-sm text-gray-600"><i class="fa-solid fa-circle-xmark text-red-500 mr-1"></i> Belum daftar</p>
                            @endif --}}
                            @if ($registration)
                                <h2 class="text-base font-semibold text-gray-900">Registrasi:</h2>
                                <ul class="max-w-md space-y-1 text-sm text-gray-500 list-inside">
                                    <li class="flex items-center space-x-2">
                                        <i class="block fa-solid fa-receipt text-gray-400"></i>
                                        <span class="inline-block mr-2">Nominal: Rp{{ number_format($registration->nominal, 0, ',', '.') }}</span>
                                    </li>
                                    <li class="flex items-center space-x-2">
                                        <i class="block fa-solid fa-money-bills text-gray-400"></i>
                                        <span class="inline-block mr-2">Harga Deal: Rp{{ number_format($registration->deal, 0, ',', '.') }}</span>
                                    </li>
                                    <li class="flex items-center space-x-2">
                                        <i class="block fa-solid fa-percent text-gray-400"></i>
                                        <span class="inline-block mr-2">Potongan: Rp{{ number_format($registration->discount, 0, ',', '.') }}</span>
                                    </li>
                                </ul>
                            @else
                                <p class="text-sm text-gray-600"><i class="fa-solid fa-circle-xmark text-red-500 mr-1"></i> Belum registrasi</p>
                            @endif
                        </section>
                    </section>
                </div>
            </div>
        </div>
    </div>
    @include('pages.database.show.modal.daftar')
    @include('pages.database.show.modal.registrasi')
</x-app-layout>

<script>
    const modalRegistrasi = () => {
        let modal = document.getElementById('modal-registrasi');
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
