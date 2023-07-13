<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-md text-gray-800 leading-tight">
                Tambah Database Baru
            </h2>
            <div class="flex items-center gap-3">
                <button onclick="saveDatabase()"
                    class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2 text-center"><i
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
                                            class="@error('name') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " required />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('name') }}
                                        </div>
                                        <label for="name"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama
                                            lengkap</label>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <label for="gender" class="sr-only">Jenis Kelamin</label>
                                        <select id="gender" name="gender"
                                            class="@error('gender') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer"
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
                                            class="@error('place_of_birth') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('place_of_birth') }}
                                        </div>
                                        <label for="place_of_birth"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tempat
                                            Lahir</label>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="date" name="date_of_birth" id="date_of_birth"
                                            value="{{ old('date_of_birth') }}"
                                            class="@error('date_of_birth') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('date_of_birth') }}
                                        </div>
                                        <label for="date_of_birth"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tanggal
                                            Lahir</label>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <label for="religion" class="sr-only">Agama</label>
                                        <select id="religion" name="religion"
                                            class="@error('religion') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
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
                                <div class="grid md:grid-cols-2 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <label for="provinces" class="sr-only">Provinsi</label>
                                        <select id="provinces" name="provinces"
                                            class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer" disabled>
                                            <option value="">Pilih Provinsi</option>
                                        </select>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <label for="regencies" class="sr-only">Kota</label>
                                        <select id="regencies" name="regencies"
                                            class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                                            disabled>
                                            <option value="">Pilih Kota / Kabupaten</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-2 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <label for="districts" class="sr-only">Kecamatan</label>
                                        <select id="districts" name="districts"
                                            class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                                            disabled>
                                            <option value="">Pilih Kecamatan</option>
                                        </select>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <label for="villages" class="sr-only">Kelurahan</label>
                                        <select id="villages" name="villages"
                                            class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                                            disabled>
                                            <option value="">Pilih Desa / Kelurahan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-3 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" name="rt" id="rt"
                                            value="{{ old('rt') }}"
                                            class="@error('rt') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('rt') }}
                                        </div>
                                        <label for="rt"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">RT</label>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" name="rw" id="rw"
                                            value="{{ old('rw') }}"
                                            class="@error('rw') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('rw') }}
                                        </div>
                                        <label for="rw"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">RW</label>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" name="postal_code" id="postal_code"
                                            value="{{ old('postal_code') }}"
                                            class="@error('postal_code') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('postal_code') }}
                                        </div>
                                        <label for="postal_code"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Kode
                                            Pos</label>
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-2 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="email" name="email" id="email"
                                            value="{{ old('email') }}"
                                            class="@error('email') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('email') }}
                                        </div>
                                        <label for="email"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email</label>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="number" name="phone" id="phone"
                                            value="{{ old('phone') }}"
                                            class="@error('phone') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder="" />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('phone') }}
                                        </div>
                                        <label for="phone"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">No.
                                            Telpon (Whatsapp)</label>
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-3 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" name="education" id="education"
                                            value="{{ old('education') }}"
                                            class="@error('education') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('education') }}
                                        </div>
                                        <label for="education"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Pendidikan
                                            Terakhir</label>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" name="major" id="major"
                                            value="{{ old('major') }}"
                                            class="@error('major') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('major') }}
                                        </div>
                                        <label for="major"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jurusan</label>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="number" min="1945" max="3000" name="year"
                                            id="year" value="{{ old('year') }}"
                                            class="@error('year') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('year') }}
                                        </div>
                                        <label for="year"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tahun
                                            lulus</label>
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-2 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" name="school" id="school"
                                            value="{{ old('school') }}"
                                            class="@error('school') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('school') }}
                                        </div>
                                        <label for="school"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Asal
                                            sekolah</label>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" name="class" id="class"
                                            value="{{ old('class') }}"
                                            class="@error('class') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('class') }}
                                        </div>
                                        <label for="class"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Kelas</label>
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-2 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <label for="source" class="sr-only">Sumber</label>
                                        <select id="source" name="source"
                                            class="@error('source') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                            <option value="0" {{ old('source') == '0' ? 'selected' : '' }}>Pilih
                                                sumber
                                            </option>
                                            <option value="1" {{ old('source') == '1' ? 'selected' : '' }}>
                                                Website
                                            </option>
                                            <option value="2" {{ old('source') == '2' ? 'selected' : '' }}>
                                                Presenter</option>
                                        </select>
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('source') }}
                                        </div>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <label for="status" class="sr-only">Status</label>
                                        <select id="status" name="status"
                                            class="@error('status') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
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
                                            class="@error('program') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                            <option>Pilih program</option>
                                            @if ($programs == null)
                                            <option value="Belum diketahui">Belum diketahui</option> 
                                            @else
                                            @forelse ($programs as $prog)
                                                <option value="{{ $prog['level'] }} {{ $prog['title'] }}">
                                                    {{ $prog['level'] }}
                                                    {{ $prog['title'] }}</option>
                                            @empty
                                                <option value="Belum diketahui">Belum diketahui</option>
                                            @endforelse
                                            @endif
                                        </select>
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('program') }}
                                        </div>
                                    </div>
                                    @if (Auth::check() && Auth::user()->role == 'P')
                                        <input type="text" value="{{ Auth::user()->identity }}"
                                            name="identity_user">
                                    @else
                                        <div class="relative z-0 w-full mb-6 group">
                                            <label for="identity_user" class="sr-only">Presenter</label>
                                            <select id="identity_user" name="identity_user"
                                                class="@error('identity_user') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
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
                {{-- <div class="flex flex-col md:flex-row gap-5">
                    <div class="w-full md:w-1/2 px-6 pt-6 bg-white shadow sm:rounded-lg">
                        <div class="w-full">
                            <section>
                                <header>
                                    <h2 class="text-xl font-bold text-gray-900">
                                        Informasi Ayah
                                    </h2>
                                    <p class="mt-1 text-sm text-gray-600">
                                        Mahasiswa orangtua/wali mahasiswa Politeknik LP3I Kampus Tasikmalaya.
                                    </p>
                                </header>
                                <hr class="mt-2 mb-8">
                                <section>
                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" name="father_name" id="father_name"
                                                value="{{ old('father_name')}}"
                                                class="@error('father_name') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" " />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('father_name') }}
                                            </div>
                                            <label for="father_name"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama
                                                lengkap</label>
                                        </div>
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" name="father_job" id="father_job"
                                                value="{{ old('father_job') }}"
                                                class="@error('father_job') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" " />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('father_job') }}
                                            </div>
                                            <label for="father_job"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Pekerjaan</label>
                                        </div>
                                    </div>
                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" name="father_place_of_birth"
                                                id="father_place_of_birth"
                                                value="{{ old('father_place_of_birth') }}"
                                                class="@error('father_place_of_birth') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" " />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('father_place_of_birth') }}
                                            </div>
                                            <label for="father_place_of_birth"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tempat
                                                Lahir</label>
                                        </div>
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="date" name="father_date_of_birth"
                                                id="father_date_of_birth"
                                                value="{{ old('father_date_of_birth') }}"
                                                class="@error('father_date_of_birth') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" " />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('father_date_of_birth') }}
                                            </div>
                                            <label for="father_date_of_birth"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tanggal
                                                Lahir</label>
                                        </div>
                                    </div>
                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" name="father_education" id="father_education"
                                                value="{{ old('father_education') }}"
                                                class="@error('father_education') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" " />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('father_education') }}
                                            </div>
                                            <label for="father_education"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Pendidikan
                                                Terakhir</label>
                                        </div>
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="number" name="father_phone" id="father_phone"
                                                value="{{ old('father_phone') }}"
                                                class="@error('father_phone') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder="" required />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('father_phone') }}
                                            </div>
                                            <label for="father_phone"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">No.
                                                Telpon (Whatsapp)</label>
                                        </div>
                                    </div>
                                    <div class="grid md:grid-cols-1 md:gap-6">
                                        <div class="relative z-0 w-full mb-6 group">
                                            <textarea name="father_address" id="father_address"
                                            value="{{ old('father_address') }}"
                                                class="@error('father_address') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" ">{{ old('father_address') }}</textarea>
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('father_address') }}
                                            </div>
                                            <label for="father_address"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Alamat</label>
                                        </div>
                                    </div>
                                </section>
                            </section>
                        </div>
                    </div>

                    <div class="w-full md:w-1/2 px-6 pt-6 bg-white shadow sm:rounded-lg">
                        <div class="w-full">
                            <section>
                                <header>
                                    <h2 class="text-xl font-bold text-gray-900">
                                        Informasi Ibu
                                    </h2>
                                    <p class="mt-1 text-sm text-gray-600">
                                        Mahasiswa orangtua/wali mahasiswa Politeknik LP3I Kampus Tasikmalaya.
                                    </p>
                                </header>
                                <hr class="mt-2 mb-8">
                                <section>
                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" name="mother_name" id="mother_name"
                                                value="{{ old('mother_name') }}"
                                                class="@error('mother_name') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" " />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('mother_name') }}
                                            </div>
                                            <label for="mother_name"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama
                                                lengkap</label>
                                        </div>
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" name="mother_job" id="mother_job"
                                                value="{{ old('mother_job') }}"
                                                class="@error('mother_job') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" " />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('mother_job') }}
                                            </div>
                                            <label for="mother_job"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Pekerjaan</label>
                                        </div>
                                    </div>
                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" name="mother_place_of_birth"
                                                id="mother_place_of_birth"
                                                value="{{ old('mother_place_of_birth') }}"
                                                class="@error('mother_place_of_birth') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" " />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('mother_place_of_birth') }}
                                            </div>
                                            <label for="mother_place_of_birth"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tempat
                                                Lahir</label>
                                        </div>
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="date" name="mother_date_of_birth"
                                                id="mother_date_of_birth"
                                                value="{{ old('mother_date_of_birth') }}"
                                                class="@error('mother_date_of_birth') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" " />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('mother_date_of_birth') }}
                                            </div>
                                            <label for="mother_date_of_birth"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tanggal
                                                Lahir</label>
                                        </div>
                                    </div>
                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" name="mother_education" id="mother_education"
                                                value="{{ old('mother_education') }}"
                                                class="@error('mother_education') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" " />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('mother_education') }}
                                            </div>
                                            <label for="mother_education"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Pendidikan
                                                Terakhir</label>
                                        </div>
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="number" name="mother_phone" id="mother_phone"
                                                value="{{ old('mother_phone') }}"
                                                class="@error('mother_phone') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder="" required />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('mother_phone') }}
                                            </div>
                                            <label for="mother_phone"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">No.
                                                Telpon (Whatsapp)</label>
                                        </div>
                                    </div>
                                    <div class="grid md:grid-cols-1 md:gap-6">
                                        <div class="relative z-0 w-full mb-6 group">
                                            <textarea name="mother_address" id="mother_address"
                                            value="{{ old('mother_address') }}"
                                                class="@error('mother_address') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" ">{{ old('mother_address') }}</textarea>
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('mother_address') }}
                                            </div>
                                            <label for="mother_address"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Alamat</label>
                                        </div>
                                    </div>
                                </section>
                            </section>
                        </div>
                    </div>
                </div> --}}
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
