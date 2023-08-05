<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center gap-3">
            <h2 class="font-bold text-xl text-gray-800 leading-tight py-2">
                {{ $applicant->name }}
            </h2>
            <div class="flex items-center gap-3">
                @if ($account == 0 && ($applicant->status == '3' || $applicant->status == '4'))
                    <form action="{{ route('profile.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="identity" value="{{ $applicant->identity }}">
                        <input type="hidden" name="name" value="{{ $applicant->name }}">
                        <input type="hidden" name="email" value="{{ $applicant->email }}">
                        <input type="hidden" name="phone" value="{{ $applicant->phone }}">
                        <button type="submit"
                            class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2 text-center"><i
                                class="fa-solid fa-user-plus"></i> Buat Akun</button>
                    </form>
                @elseif($account > 0)
                    <span
                        class="text-white bg-green-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2 text-center"><i
                            class="fa-solid fa-circle-check"></i> Sudah Memiliki Akun</span>
                @endif
                <button onclick="saveChanges()"
                    class="text-white bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2 text-center"><i
                        class="fa-solid fa-floppy-disk mr-1"></i> Simpan perubahan</button>
            </div>
            </div?>
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
        <form action="{{ route('database.update', $applicant->id) }}" method="POST" id="formChanges">
            @csrf
            @method('PATCH')
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="px-6 pt-6 bg-white shadow sm:rounded-lg">
                    <div class="w-full">
                        <section>
                            <header class="flex flex-col md:flex-row md:items-center justify-between gap-5">
                                <div class="w-full md:w-auto">
                                    <h2 class="text-xl font-bold text-gray-900">
                                        Informasi Aplikan
                                    </h2>
                                    <p class="mt-1 text-sm text-gray-600">
                                        Mahasiswa orangtua/wali mahasiswa Politeknik LP3I Kampus Tasikmalaya.
                                    </p>
                                </div>
                                <div class="w-full md:w-1/5">
                                    <label for="pmb" class="block mb-2 text-sm font-medium text-gray-900">Tahun PMB</label>
                                    <input type="number" id="pmb" name="pmb" value="{{ $applicant->pmb }}" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Tahun Penerimaan Mahasiswa Baru" required>
                                  </div>
                            </header>
                            <hr class="mt-2 mb-8">
                            <section>
                                <div class="grid md:grid-cols-{{ $programs == null ? '1' : '2' }} md:gap-6">
                                    @if ($programs !== null)
                                        <div class="relative z-0 w-full mb-6 group">
                                            <label for="program" class="sr-only">Program</label>
                                            <select id="program" name="program"
                                                class="@error('program') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                                                required>
                                                @if ($applicant->program == null)
                                                    <option value="Pilih program">Pilih program</option>
                                                    <option value="Belum diketahui">Belum diketahui</option>
                                                    @foreach ($programs as $prog)
                                                        <option value="{{ $prog['level'] }} {{ $prog['title'] }}">
                                                            {{ $prog['level'] }} {{ $prog['title'] }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="{{ $applicant->program }}">
                                                        {{ $applicant->program }}
                                                    </option>
                                                    @foreach ($programs as $prog)
                                                        <option value="{{ $prog['level'] }} {{ $prog['title'] }}">
                                                            {{ $prog['level'] }} {{ $prog['title'] }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('program') }}
                                            </div>
                                        </div>
                                    @else
                                        <input type="hidden" name="program" id="program" value="{{ $applicant->program }}">
                                    @endif
                                    @if (Auth::check() && Auth::user()->role == 'P')
                                        <input type="hidden" value="{{ $applicant->identity_user }}"
                                            name="identity_user">
                                    @else
                                        <div class="relative z-0 w-full mb-6 group">
                                            <label for="identity_user" class="sr-only">Presenter</label>
                                            <select id="identity_user" name="identity_user"
                                                class="@error('identity_user') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                                                required>
                                                @if ($applicant->identity_user == null)
                                                    <option value="Pilih presenter">Pilih presenter</option>
                                                    @foreach ($presenters as $presenter)
                                                        <option value="{{ $presenter->identity }}">
                                                            {{ $presenter->name }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="{{ $applicant->identity_user }}">
                                                        {{ $applicant->presenter->name }}
                                                    </option>
                                                    @foreach ($presenters as $presenter)
                                                        <option value="{{ $presenter->identity }}">
                                                            {{ $presenter->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('identity_user') }}
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="grid md:grid-cols-2 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <label for="source" class="sr-only">Sumber</label>
                                        <select id="source" name="source"
                                            class="@error('source') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                                            required>
                                            <option value="{{ $applicant->source }}" selected>
                                                {{ $applicant->sourceSetting->name }}
                                            </option>
                                            @foreach ($sources as $source)
                                            <option value="{{ $source->id }}">
                                                {{ $source->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('source') }}
                                        </div>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <label for="status" class="sr-only">Status</label>
                                        <select id="status" name="status"
                                            class="@error('status') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                                            required>
                                            @switch($applicant->status)
                                                @case('1')
                                                    <option value="1">Tidak diketahui</option>
                                                    <option value="2">Potensi</option>
                                                    <option value="3">Daftar</option>
                                                    <option value="4">Registrasi</option>
                                                    <option value="5">Batal</option>
                                                @break

                                                @case('2')
                                                    <option value="2">Potensi</option>
                                                    <option value="1">Tidak diketahui</option>
                                                    <option value="3">Daftar</option>
                                                    <option value="4">Registrasi</option>
                                                    <option value="5">Batal</option>
                                                @break

                                                @case('3')
                                                    <option value="3">Daftar</option>
                                                    <option value="1">Tidak diketahui</option>
                                                    <option value="2">Potensi</option>
                                                    <option value="4">Registrasi</option>
                                                    <option value="5">Batal</option>
                                                @break

                                                @case('4')
                                                    <option value="4">Registrasi</option>
                                                    <option value="1">Tidak diketahui</option>
                                                    <option value="2">Potensi</option>
                                                    <option value="3">Daftar</option>
                                                    <option value="5">Batal</option>
                                                @break

                                                @case('5')
                                                    <option value="5">Batal</option>
                                                    <option value="1">Tidak diketahui</option>
                                                    <option value="2">Potensi</option>
                                                    <option value="3">Daftar</option>
                                                    <option value="4">Registrasi</option>
                                                @break
                                            @endswitch
                                        </select>
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('status') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-2 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="email" name="email" id="email"
                                            value="{{ $applicant->email }}"
                                            class="@error('email') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " required />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('email') }}
                                        </div>
                                        <label for="email"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email</label>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="number" name="phone" id="phone"
                                            value="{{ $applicant->phone }}"
                                            class="@error('phone') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder="" required />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('phone') }}
                                        </div>
                                        <label for="phone"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">No.
                                            Telpon (Whatsapp)</label>
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-1 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <textarea name="note" id="note" value="{{ old('note', $applicant->note) }}"
                                            class="@error('note') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" ">{{ old('note', $applicant->note) }}</textarea>
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('note') }}
                                        </div>
                                        <label for="note"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Catatan</label>
                                    </div>
                                </div>

                            </section>
                        </section>
                    </div>
                </div>

                <div class="px-6 pt-6 bg-white shadow sm:rounded-lg">
                    <div class="w-full">
                        <section>
                            <header>
                                <h2 class="text-xl font-bold text-gray-900">
                                    Biodata Aplikan
                                </h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    Mahasiswa orangtua/wali mahasiswa Politeknik LP3I Kampus Tasikmalaya.
                                </p>
                            </header>
                            <hr class="mt-2 mb-8">
                            <section>
                                <div class="grid md:grid-cols-2 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" name="name" id="name"
                                            value="{{ old('name', $applicant->name) }}"
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
                                            @switch($applicant->gender)
                                                @case('0')
                                                    <option value="0">Perempuan</option>
                                                    <option value="1">Laki-laki</option>
                                                @break

                                                @case('1')
                                                    <option value="1">Laki-laki</option>
                                                    <option value="0">Perempuan</option>
                                                @break

                                                @default
                                                    <option value="1">Laki-laki</option>
                                                    <option value="0">Perempuan</option>
                                                @break
                                            @endswitch
                                        </select>
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('gender') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-3 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" name="place_of_birth" id="place_of_birth"
                                            value="{{ old('place_of_birth', $applicant->place_of_birth) }}"
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
                                            value="{{ old('date_of_birth', $applicant->date_of_birth) }}"
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
                                            class="@error('religion') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                                            required>
                                            <option value="{{ $applicant->religion }}">{{ $applicant->religion }}
                                            </option>
                                            @switch($applicant->religion)
                                                @case('Islam')
                                                    <option value="Kristen">Kristen</option>
                                                    <option value="Hindu">Hindu</option>
                                                    <option value="Buddha">Buddha</option>
                                                    <option value="Konghucu">Konghucu</option>
                                                @break

                                                @case('Kristen')
                                                    <option value="Islam">Islam</option>
                                                    <option value="Hindu">Hindu</option>
                                                    <option value="Buddha">Buddha</option>
                                                    <option value="Konghucu">Konghucu</option>
                                                @break

                                                @case('Hindu')
                                                    <option value="Islam">Islam</option>
                                                    <option value="Kristen">Kristen</option>
                                                    <option value="Buddha">Buddha</option>
                                                    <option value="Konghucu">Konghucu</option>
                                                @break

                                                @case('Buddha')
                                                    <option value="Islam">Islam</option>
                                                    <option value="Kristen">Kristen</option>
                                                    <option value="Hindu">Hindu</option>
                                                    <option value="Konghucu">Konghucu</option>
                                                @break

                                                @case('Konghucu')
                                                    <option value="Islam">Islam</option>
                                                    <option value="Kristen">Kristen</option>
                                                    <option value="Hindu">Hindu</option>
                                                    <option value="Buddha">Buddha</option>
                                                @break
                                            @endswitch
                                        </select>
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('religion') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-3 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" name="education" id="education"
                                            value="{{ old('education', $applicant->education) }}"
                                            class="@error('education') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('education') }}
                                        </div>
                                        <label for="school"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Pendidikan
                                            Terakhir</label>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" name="major" id="major"
                                            value="{{ old('major', $applicant->major) }}"
                                            class="@error('major') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('major') }}
                                        </div>
                                        <label for="school"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jurusan</label>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="number" min="1945" max="3000" name="year"
                                            id="year" value="{{ old('year', $applicant->year) }}"
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
                                            value="{{ old('school', $applicant->school) }}"
                                            class="@error('school') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('school') }}
                                        </div>
                                        <label for="school"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Asal
                                            Sekolah</label>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" name="class" id="class"
                                            value="{{ old('class', $applicant->class) }}"
                                            class="@error('class') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('class') }}
                                        </div>
                                        <label for="school"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Kelas</label>
                                    </div>
                                </div>
                                @if ($applicant->address == null)
                                    <div id="address-container" class="hidden">
                                        <div class="grid md:grid-cols-2 md:gap-6">
                                            <div class="relative z-0 w-full mb-6 group">
                                                <label for="provinces" class="sr-only">Provinsi</label>
                                                <select id="provinces" name="provinces"
                                                    class="@error('provinces') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                                    <option value="">Pilih Provinsi</option>
                                                </select>
                                            </div>
                                            <div class="relative z-0 w-full mb-6 group">
                                                <label for="regencies" class="sr-only">Kota / Kabupaten</label>
                                                <select id="regencies" name="regencies"
                                                    class="@error('regencies') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                                                    disabled>
                                                    <option value="">Pilih Kota / Kabupaten</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="grid md:grid-cols-2 md:gap-6">
                                            <div class="relative z-0 w-full mb-6 group">
                                                <label for="districts" class="sr-only">Kecamatan</label>
                                                <select id="districts" name="districts"
                                                    class="@error('districts') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                                                    disabled>
                                                    <option value="">Pilih Kecamatan</option>
                                                </select>
                                            </div>
                                            <div class="relative z-0 w-full mb-6 group">
                                                <label for="villages" class="sr-only">Desa / Kelurahan</label>
                                                <select id="villages" name="villages"
                                                    class="@error('villages') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer"
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
                                @else
                                    <div class="grid md:grid-cols-1 md:gap-6">
                                        <div class="relative z-0 w-full mb-6 group">
                                            <textarea name="address" id="address" cols="30" rows="2"
                                                value="{{ old('address', $applicant->address) }}"
                                                class="@error('address') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" ">{{ $applicant->address }}</textarea>
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('address') }}
                                            </div>
                                            <label for="address"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Alamat</label>
                                        </div>
                                    </div>
                                @endif
                            </section>
                        </section>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-start gap-5">
                    <div class="w-full md:w-1/2 px-6 pt-6 bg-white shadow sm:rounded-lg">
                        <div class="w-full">
                            <section>
                                <header>
                                    <h2 class="text-xl font-bold text-gray-900">
                                        Biodata Ayah
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
                                                value="{{ old('father_name', $father->name) }}"
                                                class="@error('father_name') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" " required />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('father_name') }}
                                            </div>
                                            <label for="father_name"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama
                                                lengkap</label>
                                        </div>
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" name="father_job" id="father_job"
                                                value="{{ old('father_job', $father->job) }}"
                                                class="@error('father_job') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" " required />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('father_job') }}
                                            </div>
                                            <label for="father_job"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Pekerjaan</label>
                                        </div>
                                    </div>
                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" name="father_place_of_birth"
                                                id="father_place_of_birth"
                                                value="{{ old('father_place_of_birth', $father->place_of_birth) }}"
                                                class="@error('father_place_of_birth') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" " />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('father_place_of_birth') }}
                                            </div>
                                            <label for="father_place_of_birth"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tempat
                                                Lahir</label>
                                        </div>
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="date" name="father_date_of_birth"
                                                id="father_date_of_birth"
                                                value="{{ old('father_date_of_birth', $father->date_of_birth) }}"
                                                class="@error('father_date_of_birth') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" " />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('father_date_of_birth') }}
                                            </div>
                                            <label for="father_date_of_birth"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tanggal
                                                Lahir</label>
                                        </div>
                                    </div>
                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" name="father_education" id="father_education"
                                                value="{{ old('father_education', $father->education) }}"
                                                class="@error('father_education') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" " />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('father_education') }}
                                            </div>
                                            <label for="father_education"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Pendidikan
                                                Terakhir</label>
                                        </div>
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="number" name="father_phone" id="father_phone"
                                                value="{{ $father->phone }}"
                                                class="@error('father_phone') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder="" required />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('father_phone') }}
                                            </div>
                                            <label for="father_phone"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">No.
                                                Telpon (Whatsapp)</label>
                                        </div>
                                    </div>
                                    @if ($father->address != null)
                                        <div class="grid md:grid-cols-1 md:gap-6">
                                            <div class="relative z-0 w-full mb-6 group">
                                                <textarea name="father_address" rows="2" id="father_address"
                                                    value="{{ old('father_address', $father->address) }}"
                                                    class="@error('father_address') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                    placeholder=" ">{{ old('father_address', $father->address) }}</textarea>
                                                <div class="text-sm text-gray-700 mt-3">
                                                    {{ $errors->first('father_address') }}
                                                </div>
                                                <label for="father_address"
                                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Alamat</label>
                                            </div>
                                        </div>
                                    @else
                                        <div id="address-father-container" class="hidden">
                                            @if ($applicant->address !== null)
                                                <div class="flex mb-3">
                                                    <input id="father-checkbox" onclick="fatherAddress()"
                                                        type="checkbox" value=""
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                                    <label for="default-checkbox"
                                                        class="ml-2 text-sm font-medium text-gray-900">Alamat
                                                        sama dengan
                                                        aplikan?</label>
                                                </div>
                                            @endif
                                            <div id="father_address_container">
                                                <div class="grid md:grid-cols-2 md:gap-6">
                                                    <div class="relative z-0 w-full mb-6 group">
                                                        <label for="father_provinces" class="sr-only">Provinsi</label>
                                                        <select id="father_provinces" name="father_provinces"
                                                            class="@error('father_provinces') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                                            <option value="">Pilih Provinsi</option>
                                                        </select>
                                                    </div>
                                                    <div class="relative z-0 w-full mb-6 group">
                                                        <label for="father_regencies" class="sr-only">Kota /
                                                            Kabupaten</label>
                                                        <select id="father_regencies" name="father_regencies"
                                                            class="@error('father_regencies') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                                                            disabled>
                                                            <option value="">Pilih Kota / Kabupaten</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="grid md:grid-cols-2 md:gap-6">
                                                    <div class="relative z-0 w-full mb-6 group">
                                                        <label for="father_districts"
                                                            class="sr-only">Kecamatan</label>
                                                        <select id="father_districts" name="father_districts"
                                                            class="@error('father_districts') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                                                            disabled>
                                                            <option value="">Pilih Kecamatan</option>
                                                        </select>
                                                    </div>
                                                    <div class="relative z-0 w-full mb-6 group">
                                                        <label for="father_villages" class="sr-only">Desa /
                                                            Kelurahan</label>
                                                        <select id="father_villages" name="father_villages"
                                                            class="@error('father_villages') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                                                            disabled>
                                                            <option value="">Pilih Desa / Kelurahan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="grid md:grid-cols-3 md:gap-6">
                                                    <div class="relative z-0 w-full mb-6 group">
                                                        <input type="text" name="father_rt" id="father_rt"
                                                            value="{{ old('father_rt') }}"
                                                            class="@error('father_rt') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                            placeholder=" " />
                                                        <div class="text-sm text-gray-700 mt-3">
                                                            {{ $errors->first('father_rt') }}
                                                        </div>
                                                        <label for="father_rt"
                                                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">RT</label>
                                                    </div>
                                                    <div class="relative z-0 w-full mb-6 group">
                                                        <input type="text" name="father_rw" id="father_rw"
                                                            value="{{ old('father_rw') }}"
                                                            class="@error('father_rw') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                            placeholder=" " />
                                                        <div class="text-sm text-gray-700 mt-3">
                                                            {{ $errors->first('father_rw') }}
                                                        </div>
                                                        <label for="father_rw"
                                                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">RW</label>
                                                    </div>
                                                    <div class="relative z-0 w-full mb-6 group">
                                                        <input type="text" name="father_postal_code"
                                                            id="father_postal_code"
                                                            value="{{ old('father_postal_code') }}"
                                                            class="@error('father_postal_code') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                            placeholder=" " />
                                                        <div class="text-sm text-gray-700 mt-3">
                                                            {{ $errors->first('father_postal_code') }}
                                                        </div>
                                                        <label for="father_postal_code"
                                                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Kode
                                                            Pos</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </section>
                            </section>
                        </div>
                    </div>

                    <div class="w-full md:w-1/2 px-6 pt-6 bg-white shadow sm:rounded-lg">
                        <div class="w-full">
                            <section>
                                <header>
                                    <h2 class="text-xl font-bold text-gray-900">
                                        Biodata Ibu
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
                                                value="{{ old('mother_name', $mother->name) }}"
                                                class="@error('mother_name') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" " required />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('mother_name') }}
                                            </div>
                                            <label for="mother_name"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama
                                                lengkap</label>
                                        </div>
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" name="mother_job" id="mother_job"
                                                value="{{ old('mother_job', $mother->job) }}"
                                                class="@error('mother_job') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" " required />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('mother_job') }}
                                            </div>
                                            <label for="mother_job"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Pekerjaan</label>
                                        </div>
                                    </div>
                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" name="mother_place_of_birth"
                                                id="mother_place_of_birth"
                                                value="{{ old('mother_place_of_birth', $mother->place_of_birth) }}"
                                                class="@error('mother_place_of_birth') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" " />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('mother_place_of_birth') }}
                                            </div>
                                            <label for="mother_place_of_birth"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tempat
                                                Lahir</label>
                                        </div>
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="date" name="mother_date_of_birth"
                                                id="mother_date_of_birth"
                                                value="{{ old('mother_date_of_birth', $mother->date_of_birth) }}"
                                                class="@error('mother_date_of_birth') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" " />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('mother_date_of_birth') }}
                                            </div>
                                            <label for="mother_date_of_birth"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tanggal
                                                Lahir</label>
                                        </div>
                                    </div>
                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="text" name="mother_education" id="mother_education"
                                                value="{{ old('mother_education', $mother->education) }}"
                                                class="@error('mother_education') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" " />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('mother_education') }}
                                            </div>
                                            <label for="mother_education"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Pendidikan
                                                Terakhir</label>
                                        </div>
                                        <div class="relative z-0 w-full mb-6 group">
                                            <input type="number" name="mother_phone" id="mother_phone"
                                                value="{{ $mother->phone }}"
                                                class="@error('mother_phone') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                placeholder="" required />
                                            <div class="text-sm text-gray-700 mt-3">
                                                {{ $errors->first('mother_phone') }}
                                            </div>
                                            <label for="mother_phone"
                                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">No.
                                                Telpon (Whatsapp)</label>
                                        </div>
                                    </div>
                                    @if ($mother->address != null)
                                        <div class="grid md:grid-cols-1 md:gap-6">
                                            <div class="relative z-0 w-full mb-6 group">
                                                <textarea name="mother_address" id="mother_address" rows="2"
                                                    value="{{ old('mother_address', $mother->address) }}"
                                                    class="@error('mother_address') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                    placeholder=" ">{{ old('mother_address', $mother->address) }}</textarea>
                                                <div class="text-sm text-gray-700 mt-3">
                                                    {{ $errors->first('mother_address') }}
                                                </div>
                                                <label for="mother_address"
                                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Alamat</label>
                                            </div>
                                        </div>
                                    @else
                                        <div id="address-mother-container" class="hidden">
                                            @if ($applicant->address !== null)
                                                <div class="flex mb-3">
                                                    <input id="mother-checkbox" onclick="motherAddress()"
                                                        type="checkbox" value=""
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                                    <label for="default-checkbox"
                                                        class="ml-2 text-sm font-medium text-gray-900">Alamat
                                                        sama dengan
                                                        aplikan?</label>
                                                </div>
                                            @endif
                                            <div id="mother_address_container">
                                                <div class="grid md:grid-cols-2 md:gap-6">
                                                    <div class="relative z-0 w-full mb-6 group">
                                                        <label for="mother_provinces" class="sr-only">Provinsi</label>
                                                        <select id="mother_provinces" name="mother_provinces"
                                                            class="@error('mother_provinces') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                                            <option value="">Pilih Provinsi</option>
                                                        </select>
                                                    </div>
                                                    <div class="relative z-0 w-full mb-6 group">
                                                        <label for="mother_regencies" class="sr-only">Kota /
                                                            Kabupaten</label>
                                                        <select id="mother_regencies" name="mother_regencies"
                                                            class="@error('mother_regencies') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                                                            disabled>
                                                            <option>Pilih Kota / Kabupaten</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="grid md:grid-cols-2 md:gap-6">
                                                    <div class="relative z-0 w-full mb-6 group">
                                                        <label for="mother_districts"
                                                            class="sr-only">Kecamatan</label>
                                                        <select id="mother_districts" name="mother_districts"
                                                            class="@error('mother_districts') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                                                            disabled>
                                                            <option>Pilih Kecamatan</option>
                                                        </select>
                                                    </div>
                                                    <div class="relative z-0 w-full mb-6 group">
                                                        <label for="mother_villages" class="sr-only">Desa /
                                                            Kelurahan</label>
                                                        <select id="mother_villages" name="mother_villages"
                                                            class="@error('mother_villages') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                                                            disabled>
                                                            <option>Pilih Desa / Kelurahan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="grid md:grid-cols-3 md:gap-6">
                                                    <div class="relative z-0 w-full mb-6 group">
                                                        <input type="text" name="mother_rt" id="mother_rt"
                                                            value="{{ old('mother_rt') }}"
                                                            class="@error('mother_rt') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                            placeholder=" " />
                                                        <div class="text-sm text-gray-700 mt-3">
                                                            {{ $errors->first('mother_rt') }}
                                                        </div>
                                                        <label for="mother_rt"
                                                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">RT</label>
                                                    </div>
                                                    <div class="relative z-0 w-full mb-6 group">
                                                        <input type="text" name="mother_rw" id="mother_rw"
                                                            value="{{ old('mother_rw') }}"
                                                            class="@error('mother_rw') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                            placeholder=" " />
                                                        <div class="text-sm text-gray-700 mt-3">
                                                            {{ $errors->first('mother_rw') }}
                                                        </div>
                                                        <label for="mother_rw"
                                                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">RW</label>
                                                    </div>
                                                    <div class="relative z-0 w-full mb-6 group">
                                                        <input type="text" name="mother_postal_code"
                                                            id="mother_postal_code"
                                                            value="{{ old('mother_postal_code') }}"
                                                            class="@error('mother_postal_code') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                            placeholder=" " />
                                                        <div class="text-sm text-gray-700 mt-3">
                                                            {{ $errors->first('mother_postal_code') }}
                                                        </div>
                                                        <label for="mother_postal_code"
                                                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Kode
                                                            Pos</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </section>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
<script src="{{ asset('js/axios.min.js') }}"></script>

@if ($applicant->address == null)
    <script src="{{ asset('js/indonesia.js') }}"></script>
@endif
@if ($father->address == null)
    <script src="{{ asset('js/indonesiaFather.js') }}"></script>
@endif
@if ($mother->address == null)
    <script src="{{ asset('js/indonesiaMother.js') }}"></script>
@endif
<script>
    const saveChanges = () => {
        const form = document.getElementById('formChanges');
        form.submit();
    }

    const motherAddress = () => {
        let checkboxMother = document.getElementById('mother-checkbox').checked;
        let motherAddressContainer = document.getElementById('mother_address_container');
        let content;
        if (checkboxMother == true) {
            content = `
            <div class="grid md:grid-cols-1 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                    <textarea name="mother_address" id="mother_address" rows="2" value="{{ $applicant->address }}" class="@error('mother_address') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" ">{{ $applicant->address }}</textarea>
                    <div class="text-sm text-gray-700 mt-3">
                        {{ $errors->first('mother_address') }}
                    </div>
                    <label for="mother_address" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Alamat</label>
                </div>
            </div>
            `;
        } else {
            content = `
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="mother_provinces" class="sr-only">Provinsi</label>
                        <select id="mother_provinces" name="mother_provinces"class="@error('mother_provinces') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                            <option value="">Pilih Provinsi</option>
                        </select>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="mother_regencies" class="sr-only">Kota/Kabupaten</label>
                        <select id="mother_regencies" name="mother_regencies" class="@error('mother_regencies') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer" disabled>
                            <option>Pilih Kota / Kabupaten</option>
                        </select>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="mother_districts" class="sr-only">Kecamatan</label>
                        <select id="mother_districts" name="mother_districts" class="@error('mother_districts') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer" disabled>
                            <option>Pilih Kecamatan</option>
                        </select>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="mother_villages" class="sr-only">Desa/Kelurahan</label>
                        <select id="mother_villages" name="mother_villages" class="@error('mother_villages') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer" disabled>
                            <option>Pilih Desa / Kelurahan</option>
                        </select>
                    </div>
                </div>
                <div class="grid md:grid-cols-3 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="mother_rt" id="mother_rt" value="{{ old('mother_rt') }}" class="@error('mother_rt') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                        <div class="text-sm text-gray-700 mt-3">
                            {{ $errors->first('mother_rt') }}
                        </div>
                        <label for="mother_rt" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">RT</label>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="mother_rw" id="mother_rw" value="{{ old('mother_rw') }}" class="@error('mother_rw') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                        <div class="text-sm text-gray-700 mt-3">
                            {{ $errors->first('mother_rw') }}
                        </div>
                        <label for="mother_rw" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">RW</label>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="mother_postal_code" id="mother_postal_code" value="{{ old('mother_postal_code') }}" class="@error('mother_postal_code') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                        <div class="text-sm text-gray-700 mt-3">
                            {{ $errors->first('mother_postal_code') }}
                        </div>
                        <label for="mother_postal_code" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Kode Pos</label>
                    </div>
                </div>
            `;
        }
        motherAddressContainer.innerHTML = content;
    }

    const fatherAddress = () => {
        let checkboxFather = document.getElementById('father-checkbox').checked;
        let fatherAddressContainer = document.getElementById('father_address_container');
        let content;
        if (checkboxFather == true) {
            content = `
            <div class="grid md:grid-cols-1 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                    <textarea name="father_address" id="father_address" rows="2" value="{{ $applicant->address }}" class="@error('father_address') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" ">{{ $applicant->address }}</textarea>
                    <div class="text-sm text-gray-700 mt-3">
                        {{ $errors->first('father_address') }}
                    </div>
                    <label for="father_address" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Alamat</label>
                </div>
            </div>
            `;
        } else {
            content = `
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="father_provinces" class="sr-only">Provinsi</label>
                        <select id="father_provinces" name="father_provinces"class="@error('father_provinces') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                            <option value="">Pilih Provinsi</option>
                        </select>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="father_regencies" class="sr-only">Kota/Kabupaten</label>
                        <select id="father_regencies" name="father_regencies" class="@error('father_regencies') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer" disabled>
                            <option>Pilih Kota / Kabupaten</option>
                        </select>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="father_districts" class="sr-only">Kecamatan</label>
                        <select id="father_districts" name="father_districts" class="@error('father_districts') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer" disabled>
                            <option>Pilih Kecamatan</option>
                        </select>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="father_villages" class="sr-only">Desa/Kelurahan</label>
                        <select id="father_villages" name="father_villages" class="@error('father_villages') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer" disabled>
                            <option>Pilih Desa / Kelurahan</option>
                        </select>
                    </div>
                </div>
                <div class="grid md:grid-cols-3 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="father_rt" id="father_rt" value="{{ old('father_rt') }}" class="@error('father_rt') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                        <div class="text-sm text-gray-700 mt-3">
                            {{ $errors->first('father_rt') }}
                        </div>
                        <label for="father_rt" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">RT</label>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="father_rw" id="father_rw" value="{{ old('father_rw') }}" class="@error('father_rw') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                        <div class="text-sm text-gray-700 mt-3">
                            {{ $errors->first('father_rw') }}
                        </div>
                        <label for="father_rw" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">RW</label>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="father_postal_code" id="father_postal_code" value="{{ old('father_postal_code') }}" class="@error('father_postal_code') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                        <div class="text-sm text-gray-700 mt-3">
                            {{ $errors->first('father_postal_code') }}
                        </div>
                        <label for="father_postal_code" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Kode Pos</label>
                    </div>
                </div>
            `;
        }
        fatherAddressContainer.innerHTML = content;
    }
</script>
