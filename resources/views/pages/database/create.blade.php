@push('styles')
    <link href="{{ asset('css/select2-input.css') }}" rel="stylesheet" />
@endpush
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight py-2">
                Tambah Database Baru
            </h2>
        </div>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('error'))
                <div id="alert" class="mx-2 mb-4 flex items-center p-4 mb-4 bg-red-400 text-white rounded-lg"
                    role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('error') }}
                    </div>
                </div>
            @endif
            @if (session('message'))
                <div id="alert" class="mx-2 mb-4 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-lg"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
        </div>
        <form method="POST" action="{{ route('database.store') }}" id="formDatabase">
            @csrf
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="px-6 pt-6 bg-white shadow sm:rounded-lg">
                    <div class="w-full">
                        <section>
                            <header class="flex flex-col md:flex-row md:items-center justify-between gap-5 py-3">
                                <div class="w-full md:w-auto">
                                    <h2 class="text-xl font-bold text-gray-900">
                                        Informasi Aplikan
                                    </h2>
                                    <p class="mt-1 text-sm text-gray-600">
                                        Mahasiswa orangtua/wali mahasiswa Politeknik LP3I Kampus Tasikmalaya.
                                    </p>
                                </div>
                            </header>
                            <hr class="mt-2 mb-5">
                            <section>
                                <div class="grid md:grid-cols-2 md:gap-6">

                                    <div class="relative z-0 w-full group">
                                        <x-label for="pmb" :value="__('Tahun Akademik')" />
                                        <x-input id="pmb" type="number" name="pmb" :value="old('pmb')"
                                            placeholder="Tahun Akademik" required />
                                        <p class="mt-2 text-xs text-gray-500">
                                            @if ($errors->has('pmb'))
                                                <span class="text-red-500">{{ $errors->first('pmb') }}</span>
                                            @else
                                                <span class="text-red-500">*Wajib diisi.</span>
                                            @endif
                                        </p>
                                    </div>

                                    <div class="relative z-0 w-full group">
                                        <x-label for="programtype_id" :value="__('Program Kuliah')" />
                                        <x-select id="programtype_id" name="programtype_id" required>
                                            @forelse ($programtypes as $programtype)
                                                <option value="{{ $programtype->id }}">{{ $programtype->name }}</option>
                                            @empty
                                                <option value="Reguler Pagi">Reguler Pagi</option>
                                            @endforelse
                                        </x-select>
                                        <p class="mt-2 text-xs text-gray-500">
                                            @if ($errors->has('programtype_id'))
                                                <span class="text-red-500">{{ $errors->first('programtype_id') }}</span>
                                            @else
                                                <span class="text-red-500">*Wajib diisi.</span>
                                            @endif
                                        </p>
                                    </div>

                                </div>

                                <hr class="my-5">

                                <div class="grid md:grid-cols-2 md:gap-6 mb-5">
                                    <div class="relative z-0 w-full group">
                                        <x-label for="name" :value="__('Nama Lengkap')" />
                                        <x-input id="name" type="text" name="name" :value="old('name')"
                                            placeholder="Nama lengkap disini.." required />
                                        <p class="mt-2 text-xs text-gray-500">
                                            @if ($errors->has('name'))
                                                <span class="text-red-500">{{ $errors->first('name') }}</span>
                                            @else
                                                <span class="text-red-500">*Wajib diisi.</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="relative z-0 w-full group">
                                        <x-label for="gender" :value="__('Jenis Kelamin')" />
                                        <x-select id="gender" name="gender" required>
                                            <option value="1">Laki-laki</option>
                                            <option value="0">Perempuan</option>
                                        </x-select>
                                        <p class="mt-2 text-xs text-gray-500">
                                            <span class="text-red-500">{{ $errors->first('gender') }}</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-3 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <div class="relative z-0 w-full group">
                                            <x-label for="place_of_birth" :value="__('Tempat Lahir')" />
                                            <x-input id="place_of_birth" type="text" name="place_of_birth"
                                                :value="old('place_of_birth')" placeholder="Tulis tempat lahir disini..." />
                                            <p class="mt-2 text-xs text-gray-500">
                                                <span
                                                    class="text-red-500">{{ $errors->first('place_of_birth') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <div class="relative z-0 w-full group">
                                            <x-label for="date_of_birth" :value="__('Tanggal Lahir')" />
                                            <x-input id="date_of_birth" type="date" name="date_of_birth"
                                                :value="old('date_of_birth')" placeholder="Tulis tempat lahir disini..." />
                                            <p class="mt-2 text-xs text-gray-500">
                                                <span class="text-red-500">{{ $errors->first('date_of_birth') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="relative z-0 w-full group">
                                        <x-label for="religion" :value="__('Agama')" />
                                        <x-select id="religion" name="religion" required>
                                            <option value="Islam">Islam</option>
                                            <option value="Kristen">Kristen</option>
                                            <option value="Hindu">Hindu</option>
                                            <option value="Buddha">Buddha</option>
                                            <option value="Konghucu">Konghucu</option>
                                        </x-select>
                                        <p class="mt-2 text-xs text-gray-500">
                                            <span class="text-red-500">{{ $errors->first('religion') }}</span>
                                        </p>
                                    </div>
                                </div>


                                <div id="address-container" class="hidden">
                                    <div class="grid md:grid-cols-2 md:gap-6">

                                        <div class="relative z-0 w-full mb-6 group">
                                            <label for="provinces" class="sr-only">Provinsi</label>
                                            <select id="provinces" name="provinces"
                                                class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                                                disabled>
                                                <option value="">Pilih Provinsi</option>
                                            </select>
                                        </div>

                                        <div class="relative z-0 w-full mb-6 group">
                                            <label for="regencies" class="sr-only">Kota</label>
                                            <select id="regencies" name="regencies"
                                                class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                                                disabled>
                                                <option value="">Pilih Kota / Kabupaten</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <div class="relative z-0 w-full mb-6 group">
                                            <label for="districts" class="sr-only">Kecamatan</label>
                                            <select id="districts" name="districts"
                                                class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                                                disabled>
                                                <option value="">Pilih Kecamatan</option>
                                            </select>
                                        </div>
                                        <div class="relative z-0 w-full mb-6 group">
                                            <label for="villages" class="sr-only">Kelurahan</label>
                                            <select id="villages" name="villages"
                                                class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                                                disabled>
                                                <option value="">Pilih Desa / Kelurahan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grid md:grid-cols-3 md:gap-6">
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" name="rt" id="rt"
                                                value="{{ old('rt') }}"
                                                class="@error('rt') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" " />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('rt') }}
                                            </div>
                                            <label for="rt"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">RT</label>
                                        </div>
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" name="rw" id="rw"
                                                value="{{ old('rw') }}"
                                                class="@error('rw') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" " />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('rw') }}
                                            </div>
                                            <label for="rw"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">RW</label>
                                        </div>
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" name="postal_code" id="postal_code"
                                                value="{{ old('postal_code') }}"
                                                class="@error('postal_code') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" " />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('postal_code') }}
                                            </div>
                                            <label for="postal_code"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Kode
                                                Pos</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-2 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <div class="relative z-0 w-full group">
                                            <x-label for="email" :value="__('Email')" />
                                            <x-input id="email" type="email" name="email" :value="old('email')"
                                                placeholder="Tulis tempat lahir disini..." />
                                            <p class="mt-2 text-xs text-gray-500">
                                                <span class="text-red-500">{{ $errors->first('email') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <div class="relative z-0 w-full group">
                                            <x-label for="phone" :value="__('No. Whatsapp')" />
                                            <x-input id="phone" type="number" name="phone" :value="old('phone')"
                                                placeholder="Tulis no. Whatsapp disini..." />
                                            <p class="mt-2 text-xs text-gray-500">
                                                <span class="text-red-500">{{ $errors->first('phone') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-3 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <div class="relative z-0 w-full group">
                                            <x-label for="education" :value="__('Pendidikan Terakhir')" />
                                            <x-input id="education" type="text" name="education"
                                                :value="old('education')" placeholder="Tulis pendidikan terakhir disini..." />
                                            <p class="mt-2 text-xs text-gray-500">
                                                <span class="text-red-500">{{ $errors->first('education') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <div class="relative z-0 w-full group">
                                            <x-label for="major" :value="__('Jurusan')" />
                                            <x-input id="major" type="text" name="major" :value="old('major')"
                                                placeholder="Tulis jurusan disini..." />
                                            <p class="mt-2 text-xs text-gray-500">
                                                <span class="text-red-500">{{ $errors->first('major') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <div class="relative z-0 w-full group">
                                            <x-label for="year" :value="__('Tahun Lulus')" />
                                            <x-input type="number" min="1945" max="3000" name="year"
                                                id="year" :value="old('year')"
                                                placeholder="Tulis tahun lulus disini..." />
                                            <p class="mt-2 text-xs text-gray-500">
                                                <span class="text-red-500">{{ $errors->first('year') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-2 md:gap-6">
                                    <div class="relative z-0 w-full group">
                                        <x-label for="school" :value="__('Sekolah')" />
                                        <x-select id="school" name="school" class="js-example-input-single">
                                            <option value="0">Pilih Sekolah</option>
                                            @foreach ($schools as $school)
                                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                                            @endforeach
                                        </x-select>
                                        <p class="mt-2 text-xs text-gray-500">
                                            <span class="text-red-500">{{ $errors->first('school') }}</span>
                                        </p>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <div class="relative z-0 w-full group">
                                            <x-label for="class" :value="__('Kelas')" />
                                            <x-input id="class" type="text" name="class" :value="old('class')"
                                                placeholder="Tulis kelas disini..." />
                                            <p class="mt-2 text-xs text-gray-500">
                                                <span class="text-red-500">{{ $errors->first('class') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-2 md:gap-6 mb-5">
                                    <div class="relative z-0 w-full group">
                                        <x-label for="source_id" :value="__('Sumber')" />
                                        <x-select id="source_id" name="source_id" required>
                                            <option value="0">Pilih sumber</option>
                                            @if (sizeof($sources) > 0)
                                                @foreach ($sources as $source)
                                                    <option value="{{ $source->id }}">{{ $source->name }}</option>
                                                @endforeach
                                            @endif
                                        </x-select>
                                        <p class="mt-2 text-xs text-gray-500">
                                            @if ($errors->has('source_id'))
                                                <span class="text-red-500">{{ $errors->first('source_id') }}</span>
                                            @else
                                                <span class="text-red-500">*Wajib diisi.</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="relative z-0 w-full group">
                                        <x-label for="status_id" :value="__('Status')" />
                                        <x-select id="status_id" name="status_id" required>
                                            <option value="0">Pilih status</option>
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                                            @endforeach
                                        </x-select>
                                        <p class="mt-2 text-xs text-gray-500">
                                            @if ($errors->has('status_id'))
                                                <span class="text-red-500">{{ $errors->first('status_id') }}</span>
                                            @else
                                                <span class="text-red-500">*Wajib diisi.</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-2 md:gap-6 mb-2">
                                    <div class="relative z-0 w-full group">
                                        <x-label for="program" :value="__('Program')" />
                                        <x-select id="program" name="program" required>
                                            <option>Pilih program</option>
                                            @if ($programs == null)
                                                <option value="Belum diketahui">Belum diketahui</option>
                                            @else
                                                <option value="Belum diketahui">Belum diketahui</option>
                                                @foreach ($programs as $prog)
                                                    <option value="{{ $prog['level'] }} {{ $prog['title'] }}">
                                                        {{ $prog['level'] }}
                                                        {{ $prog['title'] }}</option>
                                                @endforeach
                                            @endif
                                        </x-select>
                                        <p class="mt-2 text-xs text-gray-500">
                                            @if ($errors->has('program'))
                                                <span class="text-red-500">{{ $errors->first('program') }}</span>
                                            @else
                                                <span class="text-red-500">*Wajib diisi.</span>
                                            @endif
                                        </p>
                                    </div>
                                    @if (Auth::check() && Auth::user()->role == 'P')
                                        <input type="hidden" value="{{ Auth::user()->identity }}"
                                            name="identity_user">
                                    @else
                                        <div class="relative z-0 w-full group">
                                            <x-label for="identity_user" :value="__('Presenter')" />
                                            <x-select id="identity_user" name="identity_user" required>
                                                <option>Pilih presenter</option>
                                                @foreach ($users as $presenter)
                                                    <option value="{{ $presenter->identity }}">{{ $presenter->name }}
                                                    </option>
                                                @endforeach
                                            </x-select>
                                            <p class="mt-2 text-xs text-gray-500">
                                                @if ($errors->has('identity_user'))
                                                    <span
                                                        class="text-red-500">{{ $errors->first('identity_user') }}</span>
                                                @else
                                                    <span class="text-red-500">*Wajib diisi.</span>
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                </div>

                                <button type="button" onclick="saveDatabase()"
                                    class="text-white bg-lp3i-100 my-5 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2 text-center"><i
                                        class="fa-solid fa-floppy-disk mr-1"></i> Simpan</button>
                            </section>
                        </section>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('js/indonesia.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.js-example-input-single').select2();
    });

    const saveDatabase = () => {
        const form = document.getElementById('formDatabase');
        form.submit();
    }

    const getYearPMB = () => {
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear();
        const currentMonth = currentDate.getMonth();
        const startYear = currentMonth >= 9 ? currentYear + 1 : currentYear;
        document.getElementById('pmb').value = startYear;
    }
    getYearPMB();
</script>

<script>
    let phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function() {
        let phone = phoneInput.value;

        if (phone.startsWith('62')) {
            // Biarkan jika sudah dimulai dengan '62'
        } else if (phone.startsWith('0')) {
            // Ubah '0' menjadi '62' jika dimulai dengan '0'
            phoneInput.value = '62' + phone.substring(1);
        } else {
            // Ubah angka selain '0' dan '62' menjadi '62'
            phoneInput.value = '62';
        }
    });
</script>
