@push('styles')
    <link href="{{ asset('css/select2-input.css') }}" rel="stylesheet" />
@endpush
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-3">
            <h2 class="font-bold text-xl text-gray-800 leading-tight py-2">
                {{ $applicant->name }}
            </h2>
            <div class="flex flex-col md:flex-row items-center gap-2">
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-2 border border-gray-200 px-3 py-1.5 rounded-lg">
                        <i class="fa-solid fa-map-location-dot text-gray-700"></i>
                        <span class="text-sm" id="wilayah"></span>
                    </div>
                    <div class="flex items-center gap-2 border border-gray-200 px-3 py-1.5 rounded-lg">
                        <i class="fa-solid fa-rectangle-list text-gray-700"></i>
                        <span class="text-sm">
                            @if ($programs == null)
                                <i class="fa-solid fa-wifi text-red-500"></i>
                            @else
                                <i class="fa-solid fa-wifi text-green-500"></i>
                            @endif
                        </span>
                    </div>
                </div>
                @if ($account == 0 && ($applicant->status_id == 3 || $applicant->status_id == 4))
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
        <form action="{{ route('database.update', $applicant->id) }}" method="POST" id="formChanges">
            @csrf
            @method('PATCH')
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="px-6 py-6 bg-white shadow sm:rounded-lg">
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
                            </header>
                            <hr class="mt-2 mb-8">
                            <section>
                                <div class="grid md:grid-cols-2 md:gap-6 mb-5">
                                    <div class="relative z-0 w-full group">
                                        <x-label for="pmb" :value="__('Tahun Akademik')" />
                                        <x-input id="pmb" type="number" name="pmb"
                                            value="{{ $applicant->pmb }}" placeholder="Tahun Akademik" required />
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
                                            @if ($applicant->programtype_id !== null)
                                                <option value="{{ $applicant->programtype_id }}" selected>
                                                    {{ $applicant->programType->name }}
                                                </option>
                                            @endif
                                            @foreach ($programtypes as $programtype)
                                                <option value="{{ $programtype->id }}">
                                                    {{ $programtype->name }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                        <p class="mt-2 text-xs text-gray-500">
                                            @if ($errors->has('programtype_id'))
                                                <span
                                                    class="text-red-500">{{ $errors->first('programtype_id') }}</span>
                                            @else
                                                <span class="text-red-500">*Wajib diisi.</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-{{ $programs == null ? '1' : '2' }} md:gap-6 mb-5">
                                    @if ($programs !== null)
                                        <div class="relative z-0 w-full group">
                                            <x-label for="program" :value="__('Program')" />
                                            <x-select id="program" name="program" required>
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
                                            </x-select>
                                            <p class="mt-2 text-xs text-gray-500">
                                                @if ($errors->has('program'))
                                                    <span class="text-red-500">{{ $errors->first('program') }}</span>
                                                @else
                                                    <span class="text-red-500">*Wajib diisi.</span>
                                                @endif
                                            </p>
                                        </div>
                                    @else
                                        <input type="hidden" name="program" id="program"
                                            value="{{ $applicant->program }}">
                                    @endif
                                    @if (Auth::check() && Auth::user()->role == 'P')
                                        <input type="hidden" value="{{ $applicant->identity_user }}"
                                            name="identity_user">
                                    @else
                                        <div class="relative z-0 w-full group">
                                            <x-label for="identity_user" :value="__('Presenter')" />
                                            <x-select id="identity_user" name="identity_user" required>
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
                                            </x-select>
                                            <p class="mt-2 text-xs text-gray-500">
                                                @if ($errors->has('identity_user'))
                                                    {{ $errors->first('identity_user') }}
                                                @endif
                                                @if ($applicant->identity_user == null)
                                                    <span class="text-red-500">*Wajib diisi.</span>
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                </div>

                                <div class="grid md:grid-cols-2 md:gap-6 mb-5">
                                    <div class="relative z-0 w-full group">
                                        <x-label for="source_id" :value="__('Sumber')" />
                                        <x-select id="source_id" name="source_id" required>
                                            <option value="{{ $applicant->source_id }}" selected>
                                                {{ $applicant->sourceSetting->name }}
                                            </option>
                                            @foreach ($sources as $source)
                                                <option value="{{ $source->id }}">
                                                    {{ $source->name }}
                                                </option>
                                            @endforeach
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
                                            <option value="{{ $applicant->status_id }}" selected>
                                                {{ $applicant->applicantStatus->name }}
                                            </option>
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status->id }}">
                                                    {{ $status->name }}
                                                </option>
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

                                <div class="grid md:grid-cols-2 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <div class="relative z-0 w-full group">
                                            <x-label for="email" :value="__('Email')" />
                                            <x-input id="email" type="email" name="email"
                                                value="{{ $applicant->email }}" placeholder="Email" />
                                            <p class="mt-2 text-xs text-gray-500">
                                                <span class="text-red-500">{{ $errors->first('email') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <div class="relative z-0 w-full group">
                                            <x-label for="phone" :value="__('No. Whatsapp')" />
                                            <x-input id="phone" type="number" name="phone"
                                                value="{{ $applicant->phone }}"
                                                placeholder="Tulis no. Whatsapp disini..." />
                                            <p class="mt-2 text-xs text-gray-500">
                                                <span class="text-red-500">{{ $errors->first('phone') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-1 md:gap-6">
                                    <div class="relative z-0 w-full group">
                                        <x-label for="note" :value="__('Catatan')" />
                                        <x-textarea id="note" type="note" name="note"
                                            value="{{ $applicant->note }}" placeholder="Catatan">
                                            {{ $applicant->note }}
                                        </x-textarea>
                                        <p class="mt-2 text-xs text-gray-500">
                                            <span class="text-red-500">{{ $errors->first('note') }}</span>
                                        </p>
                                    </div>
                                </div>

                            </section>
                        </section>
                    </div>
                </div>

                <div class="px-6 py-6 bg-white shadow sm:rounded-lg">
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

                                <div class="grid md:grid-cols-2 md:gap-6 mb-5">
                                    <div class="relative z-0 w-full group">
                                        <x-label for="name" :value="__('Nama Lengkap')" />
                                        <x-input id="name" type="text" name="name"
                                            value="{{ old('name', $applicant->name) }}"
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
                                        </x-select>
                                        <p class="mt-2 text-xs text-gray-500">
                                            <span class="text-red-500">{{ $errors->first('gender') }}</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-3 md:gap-6 mb-5">
                                    <div class="relative z-0 w-full group">
                                        <x-label for="place_of_birth" :value="__('Tempat Lahir')" />
                                        <x-input id="place_of_birth" type="text" name="place_of_birth"
                                            value="{{ old('place_of_birth', $applicant->place_of_birth) }}"
                                            placeholder="Tulis tempat lahir disini..." />
                                        <p class="mt-2 text-xs text-gray-500">
                                            <span class="text-red-500">{{ $errors->first('place_of_birth') }}</span>
                                        </p>
                                    </div>
                                    <div class="relative z-0 w-full group">
                                        <x-label for="date_of_birth" :value="__('Tanggal Lahir')" />
                                        <x-input id="date_of_birth" type="date" name="date_of_birth"
                                            value="{{ old('date_of_birth', $applicant->date_of_birth) }}"
                                            placeholder="Tulis tempat lahir disini..." />
                                        <p class="mt-2 text-xs text-gray-500">
                                            <span class="text-red-500">{{ $errors->first('date_of_birth') }}</span>
                                        </p>
                                    </div>
                                    <div class="relative z-0 w-full group">
                                        <x-label for="religion" :value="__('Agama')" />
                                        <x-select id="religion" name="religion" required>
                                            @if ($applicant->religion)
                                                <option value="{{ $applicant->religion }}">{{ $applicant->religion }}
                                                </option>
                                            @else
                                                <option value="0">Pilih Agama</option>
                                                <option value="Islam">Islam</option>
                                                <option value="Kristen">Kristen</option>
                                                <option value="Hindu">Hindu</option>
                                                <option value="Buddha">Buddha</option>
                                                <option value="Konghucu">Konghucu</option>
                                            @endif
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
                                        </x-select>
                                        <p class="mt-2 text-xs text-gray-500">
                                            <span class="text-red-500">{{ $errors->first('religion') }}</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-3 md:gap-6 mb-5">
                                    <div class="relative z-0 w-full group">
                                        <x-label for="education" :value="__('Pendidikan Terakhir')" />
                                        <x-input id="education" type="text" name="education"
                                            value="{{ old('education', $applicant->education) }}"
                                            placeholder="Tulis pendidikan terakhir disini..." />
                                        <p class="mt-2 text-xs text-gray-500">
                                            <span class="text-red-500">{{ $errors->first('education') }}</span>
                                        </p>
                                    </div>
                                    <div class="relative z-0 w-full group">
                                        <x-label for="major" :value="__('Jurusan')" />
                                        <x-input id="major" type="text" name="major"
                                            value="{{ old('major', $applicant->major) }}"
                                            placeholder="Tulis jurusan disini..." />
                                        <p class="mt-2 text-xs text-gray-500">
                                            <span class="text-red-500">{{ $errors->first('major') }}</span>
                                        </p>
                                    </div>
                                    <div class="relative z-0 w-full group">
                                        <x-label for="year" :value="__('Tahun Lulus')" />
                                        <x-input type="number" min="1945" max="3000" name="year"
                                            id="year" value="{{ old('year', $applicant->year) }}"
                                            placeholder="Tulis tahun lulus disini..." />
                                        <p class="mt-2 text-xs text-gray-500">
                                            <span class="text-red-500">{{ $errors->first('year') }}</span>
                                        </p>
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
                                            <x-input id="class" type="text" name="class"
                                                value="{{ old('class', $applicant->class) }}"
                                                placeholder="Tulis kelas disini..." />
                                            <p class="mt-2 text-xs text-gray-500">
                                                <span class="text-red-500">{{ $errors->first('class') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @if ($applicant->address == null)
                                    <div id="address-container" class="hidden mb-5">
                                        <div class="grid md:grid-cols-2 md:gap-6 mb-5">
                                            <div class="relative z-0 w-full group">
                                                <x-label for="provinces" :value="__('Provinsi')" />
                                                <x-select id="provinces" name="provinces">
                                                    <option value="">Pilih Provinsi</option>
                                                </x-select>
                                            </div>
                                            <div class="relative z-0 w-full group">
                                                <x-label for="regencies" :value="__('Kota')" />
                                                <x-select id="regencies" name="regencies">
                                                    <option value="">Pilih Kota / Kabupaten</option>
                                                </x-select>
                                            </div>
                                        </div>

                                        <div class="grid md:grid-cols-2 md:gap-6 mb-5">
                                            <div class="relative z-0 w-full group">
                                                <x-label for="districts" :value="__('Kecamatan')" />
                                                <x-select id="districts" name="districts">
                                                    <option value="">Pilih Kecamatan</option>
                                                </x-select>
                                            </div>
                                            <div class="relative z-0 w-full group">
                                                <x-label for="villages" :value="__('Kelurahan')" />
                                                <x-select id="villages" name="villages">
                                                    <option value="">Pilih Desa / Kelurahan</option>
                                                </x-select>
                                            </div>
                                        </div>

                                        <div class="grid md:grid-cols-3 md:gap-6">
                                            <div class="relative z-0 w-full group">
                                                <x-label for="rt" :value="__('RT')" />
                                                <x-input id="rt" type="number" name="rt"
                                                    :value="old('rt')" placeholder="Tulis RT disini..." />
                                                <p class="mt-2 text-xs text-gray-500">
                                                    <span class="text-red-500">{{ $errors->first('rt') }}</span>
                                                </p>
                                            </div>
                                            <div class="relative z-0 w-full group">
                                                <x-label for="rw" :value="__('RW')" />
                                                <x-input id="rw" type="number" name="rw"
                                                    :value="old('rw')" placeholder="Tulis RW disini..." />
                                                <p class="mt-2 text-xs text-gray-500">
                                                    <span class="text-red-500">{{ $errors->first('rw') }}</span>
                                                </p>
                                            </div>
                                            <div class="relative z-0 w-full group">
                                                <x-label for="postal_code" :value="__('Kode Pos')" />
                                                <x-input id="postal_code" type="number" name="postal_code"
                                                    :value="old('postal_code')" placeholder="Tulis kode pos disini..." />
                                                <p class="mt-2 text-xs text-gray-500">
                                                    <span
                                                        class="text-red-500">{{ $errors->first('postal_code') }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="grid md:grid-cols-1 md:gap-6 mb-5">
                                        <div class="relative z-0 w-full group">
                                            <x-label for="address" :value="__('Alamat')" />
                                            <x-textarea id="address" type="address" name="address"
                                                value="{{ $applicant->address }}"
                                                placeholder="Tulis alamat disini...">
                                                {{ $applicant->address }}
                                            </x-textarea>
                                            <p class="mt-2 text-xs text-gray-500">
                                                <span class="text-red-500">{{ $errors->first('address') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </section>
                        </section>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-start gap-5">
                    <div class="w-full md:w-1/2 px-6 py-6 bg-white shadow sm:rounded-lg">
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

                                    <div class="grid md:grid-cols-2 md:gap-6 mb-5">
                                        <div class="relative z-0 w-full group">
                                            <x-label for="father_name" :value="__('Nama Lengkap')" />
                                            <x-input id="father_name" type="text" name="father_name"
                                                value="{{ old('father_name', $father->name) }}"
                                                placeholder="Nama lengkap disini.." required />
                                            <p class="mt-2 text-xs text-gray-500">
                                                @if ($errors->has('father_name'))
                                                    <span
                                                        class="text-red-500">{{ $errors->first('father_name') }}</span>
                                                @else
                                                    <span class="text-red-500">*Wajib diisi.</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="relative z-0 w-full group">
                                            <x-label for="father_job" :value="__('Pekerjaan')" />
                                            <x-input id="father_job" type="text" name="father_job"
                                                value="{{ old('father_job', $father->job) }}"
                                                placeholder="Nama lengkap disini.." required />
                                            <p class="mt-2 text-xs text-gray-500">
                                                <span class="text-red-500">{{ $errors->first('father_job') }}</span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="grid md:grid-cols-2 md:gap-6 mb-5">
                                        <div class="relative z-0 w-full group">
                                            <x-label for="father_place_of_birth" :value="__('Tempat Lahir')" />
                                            <x-input id="father_place_of_birth" type="text"
                                                name="father_place_of_birth"
                                                value="{{ old('father_place_of_birth', $father->place_of_birth) }}"
                                                placeholder="Tulis tempat lahir disini..." />
                                            <p class="mt-2 text-xs text-gray-500">
                                                <span
                                                    class="text-red-500">{{ $errors->first('father_place_of_birth') }}</span>
                                            </p>
                                        </div>
                                        <div class="relative z-0 w-full group">
                                            <x-label for="father_date_of_birth" :value="__('Tanggal Lahir')" />
                                            <x-input id="father_date_of_birth" type="date"
                                                name="father_date_of_birth"
                                                value="{{ old('father_date_of_birth', $father->date_of_birth) }}"
                                                placeholder="Tulis tempat lahir disini..." />
                                            <p class="mt-2 text-xs text-gray-500">
                                                <span
                                                    class="text-red-500">{{ $errors->first('father_date_of_birth') }}</span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <div class="relative z-0 w-full group">
                                            <x-label for="father_education" :value="__('Pendidikan Terakhir')" />
                                            <x-input id="father_education" type="text" name="father_education"
                                                value="{{ old('father_education', $father->education) }}"
                                                placeholder="Tulis pendidikan terakhir disini..." />
                                            <p class="mt-2 text-xs text-gray-500">
                                                <span
                                                    class="text-red-500">{{ $errors->first('father_education') }}</span>
                                            </p>
                                        </div>
                                        <div class="relative z-0 w-full mb-6 group">
                                            <div class="relative z-0 w-full group">
                                                <x-label for="father_phone" :value="__('No. Whatsapp')" />
                                                <x-input id="father_phone" type="number" name="father_phone"
                                                    value="{{ $father->phone }}"
                                                    placeholder="Tulis no. Whatsapp disini..." />
                                                <p class="mt-2 text-xs text-gray-500">
                                                    <span
                                                        class="text-red-500">{{ $errors->first('father_phone') }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($father->address != null)
                                        <div class="grid md:grid-cols-1 md:gap-6">
                                            <div class="relative z-0 w-full group">
                                                <x-label for="father_address" :value="__('Alamat')" />
                                                <x-textarea id="father_address" type="father_address"
                                                    name="father_address"
                                                    value="{{ old('father_address', $father->address) }}"
                                                    placeholder="Tulis alamat disini...">
                                                    {{ $father->address }}
                                                </x-textarea>
                                                <p class="mt-2 text-xs text-gray-500">
                                                    <span
                                                        class="text-red-500">{{ $errors->first('father_address') }}</span>
                                                </p>
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
                                                <div class="grid md:grid-cols-2 md:gap-6 mb-5">
                                                    <div class="relative z-0 w-full group">
                                                        <x-label for="father_provinces" :value="__('Provinsi')" />
                                                        <x-select id="father_provinces" name="father_provinces">
                                                            <option value="">Pilih Provinsi</option>
                                                        </x-select>
                                                    </div>
                                                    <div class="relative z-0 w-full group">
                                                        <x-label for="father_regencies" :value="__('Kota')" />
                                                        <x-select id="father_regencies" name="father_regencies">
                                                            <option value="">Pilih Kota / Kabupaten</option>
                                                        </x-select>
                                                    </div>
                                                </div>
                                                <div class="grid md:grid-cols-2 md:gap-6 mb-5">
                                                    <div class="relative z-0 w-full group">
                                                        <x-label for="father_districts" :value="__('Kecamatan')" />
                                                        <x-select id="father_districts" name="father_districts">
                                                            <option value="">Pilih Kecamatan</option>
                                                        </x-select>
                                                    </div>
                                                    <div class="relative z-0 w-full group">
                                                        <x-label for="father_villages" :value="__('Kelurahan')" />
                                                        <x-select id="father_villages" name="father_villages">
                                                            <option value="">Pilih Desa / Kelurahan</option>
                                                        </x-select>
                                                    </div>
                                                </div>
                                                <div class="grid md:grid-cols-3 md:gap-6">
                                                    <div class="relative z-0 w-full group">
                                                        <x-label for="father_rt" :value="__('RT')" />
                                                        <x-input id="father_rt" type="number" name="father_rt"
                                                            :value="old('father_rt')" placeholder="Tulis RT disini..." />
                                                        <p class="mt-2 text-xs text-gray-500">
                                                            <span
                                                                class="text-red-500">{{ $errors->first('father_rt') }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="relative z-0 w-full group">
                                                        <x-label for="father_rw" :value="__('RW')" />
                                                        <x-input id="father_rw" type="number" name="father_rw"
                                                            :value="old('father_rw')" placeholder="Tulis RW disini..." />
                                                        <p class="mt-2 text-xs text-gray-500">
                                                            <span
                                                                class="text-red-500">{{ $errors->first('father_rw') }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="relative z-0 w-full group">
                                                        <x-label for="father_postal_code" :value="__('Kode Pos')" />
                                                        <x-input id="father_postal_code" type="number"
                                                            name="father_postal_code" :value="old('father_postal_code')"
                                                            placeholder="Tulis kode pos disini..." />
                                                        <p class="mt-2 text-xs text-gray-500">
                                                            <span
                                                                class="text-red-500">{{ $errors->first('father_postal_code') }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </section>
                            </section>
                        </div>
                    </div>

                    <div class="w-full md:w-1/2 px-6 py-6 bg-white shadow sm:rounded-lg">
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
                                    <div class="grid md:grid-cols-2 md:gap-6 mb-5">
                                        <div class="relative z-0 w-full group">
                                            <x-label for="mother_name" :value="__('Nama Lengkap')" />
                                            <x-input id="mother_name" type="text" name="mother_name"
                                                value="{{ old('mother_name', $mother->name) }}"
                                                placeholder="Nama lengkap disini.." required />
                                            <p class="mt-2 text-xs text-gray-500">
                                                @if ($errors->has('mother_name'))
                                                    <span
                                                        class="text-red-500">{{ $errors->first('mother_name') }}</span>
                                                @else
                                                    <span class="text-red-500">*Wajib diisi.</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="relative z-0 w-full group">
                                            <x-label for="mother_job" :value="__('Pekerjaan')" />
                                            <x-input id="mother_job" type="text" name="mother_job"
                                                value="{{ old('mother_job', $mother->job) }}"
                                                placeholder="Nama lengkap disini.." required />
                                            <p class="mt-2 text-xs text-gray-500">
                                                <span class="text-red-500">{{ $errors->first('mother_job') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="grid md:grid-cols-2 md:gap-6 mb-5">
                                        <div class="relative z-0 w-full group">
                                            <x-label for="mother_place_of_birth" :value="__('Tempat Lahir')" />
                                            <x-input id="mother_place_of_birth" type="text"
                                                name="mother_place_of_birth"
                                                value="{{ old('mother_place_of_birth', $mother->place_of_birth) }}"
                                                placeholder="Tulis tempat lahir disini..." />
                                            <p class="mt-2 text-xs text-gray-500">
                                                <span
                                                    class="text-red-500">{{ $errors->first('mother_place_of_birth') }}</span>
                                            </p>
                                        </div>
                                        <div class="relative z-0 w-full group">
                                            <x-label for="mother_date_of_birth" :value="__('Tanggal Lahir')" />
                                            <x-input id="mother_date_of_birth" type="date"
                                                name="mother_date_of_birth"
                                                value="{{ old('mother_date_of_birth', $mother->date_of_birth) }}"
                                                placeholder="Tulis tempat lahir disini..." />
                                            <p class="mt-2 text-xs text-gray-500">
                                                <span
                                                    class="text-red-500">{{ $errors->first('mother_date_of_birth') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="grid md:grid-cols-2 md:gap-6">
                                        <div class="relative z-0 w-full group">
                                            <x-label for="mother_education" :value="__('Pendidikan Terakhir')" />
                                            <x-input id="mother_education" type="text" name="mother_education"
                                                value="{{ old('mother_education', $mother->education) }}"
                                                placeholder="Tulis pendidikan terakhir disini..." />
                                            <p class="mt-2 text-xs text-gray-500">
                                                <span
                                                    class="text-red-500">{{ $errors->first('mother_education') }}</span>
                                            </p>
                                        </div>
                                        <div class="relative z-0 w-full mb-6 group">
                                            <div class="relative z-0 w-full group">
                                                <x-label for="mother_phone" :value="__('No. Whatsapp')" />
                                                <x-input id="mother_phone" type="number" name="mother_phone"
                                                    value="{{ $mother->phone }}"
                                                    placeholder="Tulis no. Whatsapp disini..." />
                                                <p class="mt-2 text-xs text-gray-500">
                                                    <span
                                                        class="text-red-500">{{ $errors->first('mother_phone') }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($mother->address != null)
                                        <div class="grid md:grid-cols-1 md:gap-6">
                                            <div class="relative z-0 w-full group">
                                                <x-label for="mother_address" :value="__('Alamat')" />
                                                <x-textarea id="mother_address" type="mother_address"
                                                    name="mother_address"
                                                    value="{{ old('mother_address', $mother->address) }}"
                                                    placeholder="Tulis alamat disini...">
                                                    {{ $father->address }}
                                                </x-textarea>
                                                <p class="mt-2 text-xs text-gray-500">
                                                    <span
                                                        class="text-red-500">{{ $errors->first('mother_address') }}</span>
                                                </p>
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
                                                <div class="grid md:grid-cols-2 md:gap-6 mb-5">
                                                    <div class="relative z-0 w-full group">
                                                        <x-label for="mother_provinces" :value="__('Provinsi')" />
                                                        <x-select id="mother_provinces" name="mother_provinces">
                                                            <option value="">Pilih Provinsi</option>
                                                        </x-select>
                                                    </div>
                                                    <div class="relative z-0 w-full group">
                                                        <x-label for="mother_regencies" :value="__('Kota')" />
                                                        <x-select id="mother_regencies" name="mother_regencies">
                                                            <option value="">Pilih Kota / Kabupaten</option>
                                                        </x-select>
                                                    </div>
                                                </div>
                                                <div class="grid md:grid-cols-2 md:gap-6 mb-5">
                                                    <div class="relative z-0 w-full group">
                                                        <x-label for="mother_districts" :value="__('Kecamatan')" />
                                                        <x-select id="mother_districts" name="mother_districts">
                                                            <option value="">Pilih Kecamatan</option>
                                                        </x-select>
                                                    </div>
                                                    <div class="relative z-0 w-full group">
                                                        <x-label for="mother_villages" :value="__('Kelurahan')" />
                                                        <x-select id="mother_villages" name="mother_villages">
                                                            <option value="">Pilih Desa / Kelurahan</option>
                                                        </x-select>
                                                    </div>
                                                </div>
                                                <div class="grid md:grid-cols-3 md:gap-6">
                                                    <div class="relative z-0 w-full group">
                                                        <x-label for="mother_rt" :value="__('RT')" />
                                                        <x-input id="mother_rt" type="number" name="mother_rt"
                                                            :value="old('mother_rt')" placeholder="Tulis RT disini..." />
                                                        <p class="mt-2 text-xs text-gray-500">
                                                            <span
                                                                class="text-red-500">{{ $errors->first('mother_rt') }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="relative z-0 w-full group">
                                                        <x-label for="mother_rw" :value="__('RW')" />
                                                        <x-input id="mother_rw" type="number" name="mother_rw"
                                                            :value="old('mother_rw')" placeholder="Tulis RW disini..." />
                                                        <p class="mt-2 text-xs text-gray-500">
                                                            <span
                                                                class="text-red-500">{{ $errors->first('mother_rw') }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="relative z-0 w-full group">
                                                        <x-label for="mother_postal_code" :value="__('Kode Pos')" />
                                                        <x-input id="mother_postal_code" type="number"
                                                            name="mother_postal_code" :value="old('mother_postal_code')"
                                                            placeholder="Tulis kode pos disini..." />
                                                        <p class="mt-2 text-xs text-gray-500">
                                                            <span
                                                                class="text-red-500">{{ $errors->first('mother_postal_code') }}</span>
                                                        </p>
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
            <div class="grid md:grid-cols-1 md:gap-6 mb-5">
                <div class="relative z-0 w-full group">
                    <x-label for="mother_address" :value="__('Alamat')" />
                    <x-textarea id="mother_address" type="mother_address" name="mother_address" value="{{ $applicant->address }}" placeholder="Tulis alamat disini...">{{ $applicant->address }}</x-textarea>
                    <p class="mt-2 text-xs text-gray-500">
                        <span class="text-red-500">{{ $errors->first('mother_address') }}</span>
                    </p>
                </div>
            </div>
            `;
        } else {
            content = `
            <div class="grid md:grid-cols-2 md:gap-6 mb-5">
                <div class="relative z-0 w-full group">
                    <x-label for="mother_provinces" :value="__('Provinsi')" />
                    <x-select id="mother_provinces" name="mother_provinces">
                        <option value="">Pilih Provinsi</option>
                    </x-select>
                </div>
                <div class="relative z-0 w-full group">
                    <x-label for="mother_regencies" :value="__('Kota')" />
                    <x-select id="mother_regencies" name="mother_regencies">
                        <option value="">Pilih Kota / Kabupaten</option>
                    </x-select>
                </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6 mb-5">
                <div class="relative z-0 w-full group">
                    <x-label for="mother_districts" :value="__('Kecamatan')" />
                    <x-select id="mother_districts" name="mother_districts">
                        <option value="">Pilih Kecamatan</option>
                    </x-select>
                </div>
                <div class="relative z-0 w-full group">
                    <x-label for="mother_villages" :value="__('Kelurahan')" />
                    <x-select id="mother_villages" name="mother_villages">
                        <option value="">Pilih Desa / Kelurahan</option>
                    </x-select>
                </div>
            </div>
            <div class="grid md:grid-cols-3 md:gap-6">
                <div class="relative z-0 w-full group">
                    <x-label for="mother_rt" :value="__('RT')" />
                    <x-input id="mother_rt" type="number" name="mother_rt" :value="old('mother_rt')"
                        placeholder="Tulis RT disini..." />
                    <p class="mt-2 text-xs text-gray-500">
                        <span class="text-red-500">{{ $errors->first('mother_rt') }}</span>
                    </p>
                </div>
                <div class="relative z-0 w-full group">
                    <x-label for="mother_rw" :value="__('RW')" />
                    <x-input id="mother_rw" type="number" name="mother_rw" :value="old('mother_rw')"
                        placeholder="Tulis RW disini..." />
                    <p class="mt-2 text-xs text-gray-500">
                        <span class="text-red-500">{{ $errors->first('mother_rw') }}</span>
                    </p>
                </div>
                <div class="relative z-0 w-full group">
                    <x-label for="mother_postal_code" :value="__('Kode Pos')" />
                    <x-input id="mother_postal_code" type="number" name="mother_postal_code" :value="old('mother_postal_code')"
                        placeholder="Tulis kode pos disini..." />
                    <p class="mt-2 text-xs text-gray-500">
                        <span class="text-red-500">{{ $errors->first('mother_postal_code') }}</span>
                    </p>
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
            <div class="grid md:grid-cols-1 md:gap-6 mb-5">
                <div class="relative z-0 w-full group">
                    <x-label for="father_address" :value="__('Alamat')" />
                    <x-textarea id="father_address" type="father_address" name="father_address" value="{{ $applicant->address }}"placeholder="Tulis alamat disini...">{{ $applicant->address }}</x-textarea>
                    <p class="mt-2 text-xs text-gray-500">
                        <span class="text-red-500">{{ $errors->first('father_address') }}</span>
                    </p>
                </div>
            </div>
            `;
        } else {
            content = `
            <div class="grid md:grid-cols-2 md:gap-6 mb-5">
                <div class="relative z-0 w-full group">
                    <x-label for="father_provinces" :value="__('Provinsi')" />
                    <x-select id="father_provinces" name="father_provinces">
                        <option value="">Pilih Provinsi</option>
                    </x-select>
                </div>
                <div class="relative z-0 w-full group">
                    <x-label for="father_regencies" :value="__('Kota')" />
                    <x-select id="father_regencies" name="father_regencies">
                        <option value="">Pilih Kota / Kabupaten</option>
                    </x-select>
                </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6 mb-5">
                <div class="relative z-0 w-full group">
                    <x-label for="father_districts" :value="__('Kecamatan')" />
                    <x-select id="father_districts" name="father_districts">
                        <option value="">Pilih Kecamatan</option>
                    </x-select>
                </div>
                <div class="relative z-0 w-full group">
                    <x-label for="father_villages" :value="__('Kelurahan')" />
                    <x-select id="father_villages" name="father_villages">
                        <option value="">Pilih Desa / Kelurahan</option>
                    </x-select>
                </div>
            </div>
            <div class="grid md:grid-cols-3 md:gap-6">
                <div class="relative z-0 w-full group">
                    <x-label for="father_rt" :value="__('RT')" />
                    <x-input id="father_rt" type="number" name="father_rt" :value="old('father_rt')"
                        placeholder="Tulis RT disini..." />
                    <p class="mt-2 text-xs text-gray-500">
                        <span class="text-red-500">{{ $errors->first('father_rt') }}</span>
                    </p>
                </div>
                <div class="relative z-0 w-full group">
                    <x-label for="father_rw" :value="__('RW')" />
                    <x-input id="father_rw" type="number" name="father_rw" :value="old('father_rw')"
                        placeholder="Tulis RW disini..." />
                    <p class="mt-2 text-xs text-gray-500">
                        <span class="text-red-500">{{ $errors->first('father_rw') }}</span>
                    </p>
                </div>
                <div class="relative z-0 w-full group">
                    <x-label for="father_postal_code" :value="__('Kode Pos')" />
                    <x-input id="father_postal_code" type="number" name="father_postal_code" :value="old('father_postal_code')"
                        placeholder="Tulis kode pos disini..." />
                    <p class="mt-2 text-xs text-gray-500">
                        <span class="text-red-500">{{ $errors->first('father_postal_code') }}</span>
                    </p>
                </div>
            </div>
            `;
        }
        fatherAddressContainer.innerHTML = content;
    }
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
<script>
    let phoneMotherInput = document.getElementById('mother_phone');
    phoneMotherInput.addEventListener('input', function() {
        let phone = phoneMotherInput.value;

        if (phone.startsWith('62')) {
            // Biarkan jika sudah dimulai dengan '62'
        } else if (phone.startsWith('0')) {
            // Ubah '0' menjadi '62' jika dimulai dengan '0'
            phoneMotherInput.value = '62' + phone.substring(1);
        } else {
            // Ubah angka selain '0' dan '62' menjadi '62'
            phoneMotherInput.value = '62';
        }
    });
</script>
<script>
    let phoneFatherInput = document.getElementById('father_phone');
    phoneFatherInput.addEventListener('input', function() {
        let phone = phoneFatherInput.value;

        if (phone.startsWith('62')) {
            // Biarkan jika sudah dimulai dengan '62'
        } else if (phone.startsWith('0')) {
            // Ubah '0' menjadi '62' jika dimulai dengan '0'
            phoneFatherInput.value = '62' + phone.substring(1);
        } else {
            // Ubah angka selain '0' dan '62' menjadi '62'
            phoneFatherInput.value = '62';
        }
    });
</script>

<script>
    $(document).ready(function() {
        $('.js-example-input-single').select2();
    });
</script>
