<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight py-2">
                Tambah Database Baru
            </h2>
            <div class="flex items-center gap-3">
                <button onclick="saveDatabase()"
                    class="text-white bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2 text-center"><i
                        class="fa-solid fa-floppy-disk mr-1"></i> Simpan</button>
            </div>
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
                            <header>
                                <h2 class="text-xl font-bold text-gray-900">
                                    Informasi Aplikan
                                </h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    Mahasiswa orangtua/wali mahasiswa Politeknik LP3I Kampus Tasikmalaya.
                                </p>
                            </header>
                            <hr class="mt-2 mb-8">
                            <section>
                                <div class="grid md:grid-cols-2 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                                            class="@error('name') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " required />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('name') }}
                                        </div>
                                        <label for="name"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama
                                            lengkap</label>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <label for="gender" class="sr-only">Jenis Kelamin</label>
                                        <select id="gender" name="gender"
                                            class="@error('gender') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                                            required>
                                            <option value="1">Laki-laki</option>
                                            <option value="0">Perempuan</option>
                                        </select>
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('gender') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-3 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" name="place_of_birth" id="place_of_birth"
                                            value="{{ old('place_of_birth') }}"
                                            class="@error('place_of_birth') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('place_of_birth') }}
                                        </div>
                                        <label for="place_of_birth"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tempat
                                            Lahir</label>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="date" name="date_of_birth" id="date_of_birth"
                                            value="{{ old('date_of_birth') }}"
                                            class="@error('date_of_birth') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('date_of_birth') }}
                                        </div>
                                        <label for="date_of_birth"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tanggal
                                            Lahir</label>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <label for="religion" class="sr-only">Agama</label>
                                        <select id="religion" name="religion"
                                            class="@error('religion') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                            <option value="Islam">Islam</option>
                                            <option value="Kristen">Kristen</option>
                                            <option value="Hindu">Hindu</option>
                                            <option value="Buddha">Buddha</option>
                                            <option value="Konghucu">Konghucu</option>
                                        </select>
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('religion') }}
                                        </div>
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
                                        <input type="email" name="email" id="email"
                                            value="{{ old('email') }}"
                                            class="@error('email') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('email') }}
                                        </div>
                                        <label for="email"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email</label>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="number" name="phone" id="phone"
                                            value="{{ old('phone') }}"
                                            class="@error('phone') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder="" />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('phone') }}
                                        </div>
                                        <label for="phone"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">No.
                                            Telpon (Whatsapp)</label>
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-3 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" name="education" id="education"
                                            value="{{ old('education') }}"
                                            class="@error('education') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('education') }}
                                        </div>
                                        <label for="education"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Pendidikan
                                            Terakhir</label>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" name="major" id="major"
                                            value="{{ old('major') }}"
                                            class="@error('major') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('major') }}
                                        </div>
                                        <label for="major"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jurusan</label>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="number" min="1945" max="3000" name="year"
                                            id="year" value="{{ old('year') }}"
                                            class="@error('year') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('year') }}
                                        </div>
                                        <label for="year"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tahun
                                            lulus</label>
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-2 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" name="school" id="school"
                                            value="{{ old('school') }}"
                                            class="@error('school') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('school') }}
                                        </div>
                                        <label for="school"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Asal
                                            sekolah</label>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" name="class" id="class"
                                            value="{{ old('class') }}"
                                            class="@error('class') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('class') }}
                                        </div>
                                        <label for="class"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Kelas</label>
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-2 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <label for="source" class="sr-only">Sumber</label>
                                        <select id="source" name="source"
                                            class="@error('source') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                            <option value="0">Pilih sumber</option>
                                            @if (sizeof($sources) > 0)
                                                @foreach ($sources as $source)
                                                    <option value="{{ $source->id }}">{{ $source->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('source') }}
                                        </div>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <label for="status" class="sr-only">Status</label>
                                        <select id="status" name="status"
                                            class="@error('status') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Pilih
                                                status
                                            </option>
                                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Tidak
                                                diketahui
                                            </option>
                                            <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>
                                                Potensi
                                            </option>
                                            <option value="3" {{ old('status') == '3' ? 'selected' : '' }}>Daftar
                                            </option>
                                            <option value="4" {{ old('status') == '4' ? 'selected' : '' }}>
                                                Registrasi
                                            </option>
                                            <option value="5" {{ old('status') == '5' ? 'selected' : '' }}>Batal
                                            </option>
                                        </select>
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('status') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-2 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <label for="program" class="sr-only">Program</label>
                                        <select id="program" name="program"
                                            class="@error('program') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer">
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
                                        </select>
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('program') }}
                                        </div>
                                    </div>
                                    @if (Auth::check() && Auth::user()->role == 'P')
                                        <input type="hidden" value="{{ Auth::user()->identity }}"
                                            name="identity_user">
                                    @else
                                        <div class="relative z-0 w-full mb-6 group">
                                            <label for="identity_user" class="sr-only">Presenter</label>
                                            <select id="identity_user" name="identity_user"
                                                class="@error('identity_user') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                                <option>Pilih presenter</option>
                                                @foreach ($users as $presenter)
                                                    <option value="{{ $presenter->identity }}">{{ $presenter->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('identity_user') }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
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
    const saveDatabase = () => {
        const form = document.getElementById('formDatabase');
        form.submit();
    }
</script>
