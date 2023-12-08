<div class="w-full px-6 py-6 bg-white shadow-sm sm:rounded-lg">
    <div class="w-full">
        <section>
            <header>
                <h2 class="text-xl font-bold text-gray-900">
                    Biodata Mahasiswa
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    Mahasiswa orangtua/wali mahasiswa Politeknik LP3I Kampus Tasikmalaya.
                </p>
            </header>
            <hr class="mt-2 mb-5">
            <section>
                <div class="grid grid-cols-1 mb-4">
                    @if ($applicant->program)
                        <div class="relative z-0 w-full group">
                            <h4 class="text-sm text-gray-700 mb-1">Program Studi:</h4>
                            <h2 class="text-lg font-bold text-gray-900">{{ $applicant->program }}</h2>
                        </div>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                    <div class="relative z-0 w-full group">
                        <x-label for="nik" :value="__('Nomor Induk Kependudukan')" />
                        <x-input id="nik" type="number" name="nik" value="{{ old('nik', $applicant->nik) }}"
                            placeholder="Nomor Induk Kependudukan" />
                        <p class="mt-2 text-xs text-gray-500">
                            @if (Auth::user()->role == 'S')
                                @if ($errors->has('nik'))
                                    <span class="text-red-500">{{ $errors->first('nik') }}</span>
                                @else
                                    <span class="text-red-500">*Wajib diisi.</span>
                                @endif
                            @else
                                <span class="text-red-500">{{ $errors->first('nik') }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="nisn" :value="__('Nomor Induk Siswa Nasional')" />
                        <x-input id="nisn" type="number" name="nisn"
                            value="{{ old('nisn', $applicant->nisn) }}" placeholder="Nomor Induk Siswa Nasional" />
                        <p class="mt-2 text-xs text-gray-500">
                            @if (Auth::user()->role == 'S')
                                @if ($errors->has('nisn'))
                                    <span class="text-red-500">{{ $errors->first('nisn') }}</span>
                                @else
                                    <span class="text-red-500">*Wajib diisi.</span>
                                @endif
                            @else
                                <span class="text-red-500">{{ $errors->first('nisn') }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                    <div class="relative z-0 w-full group">
                        <x-label for="kip" :value="__('No. Kartu Indonesia Pintar')" />
                        <x-input id="kip" type="number" name="kip" value="{{ old('kip', $applicant->kip) }}"
                            placeholder="Nomor Kartu Indonesia Pintar" />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('kip') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="income_parent" :value="__('Penghasilan Orang Tua')" />
                        <x-select id="income_parent" name="income_parent">
                            @if ($applicant->income_parent)
                                <option value="{{ $applicant->income_parent }}">{{ $applicant->income_parent }}
                                </option>
                            @else
                                <option value="null">Pilih</option>
                            @endif
                            <option value="< 1.000.000">
                                < 1.000.000</option>
                            <option value="1.000.000 - 2.000.000">1.000.000 - 2.000.000</option>
                            <option value="2.000.000 - 4.000.000">2.000.000 - 4.000.000</option>
                            <option value="> 5.000.000">> 5.000.000</option>
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('income_parent') }}</span>
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                    <div class="relative z-0 w-full group">
                        <x-label for="name" :value="__('Nama Lengkap')" />
                        <x-input id="name" type="text" name="name"
                            value="{{ old('name', $applicant->name) }}" placeholder="Nama lengkap disini.." required />
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
                            @if ($errors->has('gender'))
                                <span class="text-red-500">{{ $errors->first('gender') }}</span>
                            @else
                                <span class="text-red-500">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
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
                            @if ($errors->has('religion'))
                                <span class="text-red-500">{{ $errors->first('religion') }}</span>
                            @else
                                <span class="text-red-500">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                    <div class="relative z-0 w-full group">
                        <x-label for="education" :value="__('Pendidikan Terakhir')" />
                        <x-input id="education" type="text" name="education"
                            value="{{ old('education', $applicant->education) }}"
                            placeholder="Tulis pendidikan terakhir disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('education'))
                                <span class="text-red-500">{{ $errors->first('education') }}</span>
                            @else
                                <span class="text-red-500">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="school" :value="__('Sekolah')" />
                        <x-select id="school" name="school" class="js-example-input-single">
                            @if ($applicant->school)
                                <option value="{{ $applicant->SchoolApplicant->name }}">
                                    {{ $applicant->SchoolApplicant->name }}</option>
                            @else
                                <option>Pilih Sekolah</option>
                            @endif
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('school'))
                                <span class="text-red-500">{{ $errors->first('school') }}</span>
                            @else
                                <span class="text-red-500">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
                    <div class="relative z-0 w-full group">
                        <x-label for="major" :value="__('Jurusan')" />
                        <x-input id="major" type="text" name="major"
                            value="{{ old('major', $applicant->major) }}" placeholder="Tulis jurusan disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('major'))
                                <span class="text-red-500">{{ $errors->first('major') }}</span>
                            @else
                                <span class="text-red-500">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="year" :value="__('Tahun Lulus')" />
                        <x-input type="number" min="1945" max="3000" name="year" id="year"
                            value="{{ old('year', $applicant->year) }}" placeholder="Tulis tahun lulus disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('year'))
                                <span class="text-red-500">{{ $errors->first('year') }}</span>
                            @else
                                <span class="text-red-500">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="class" :value="__('Kelas')" />
                        <x-input id="class" type="text" name="class"
                            value="{{ old('class', $applicant->class) }}" placeholder="Tulis kelas disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('class') }}</span>
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
                    <div class="relative z-0 w-full group">
                        <div class="relative z-0 w-full group">
                            <x-label for="social_media" :value="__('Sosial Media')" />
                            <x-input id="social_media" type="text" name="social_media"
                                value="{{ old('social_media', $applicant->social_media) }}" placeholder="@" />
                            <p class="mt-2 text-xs text-gray-500">
                                <span class="text-red-500">{{ $errors->first('social_media') }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="achievement" :value="__('Prestasi')" />
                        <x-input id="achievement" type="text" name="achievement"
                            value="{{ old('achievement', $applicant->achievement) }}"
                            placeholder="Tulis prestasi disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('achievement') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="relation" :value="__('Relasi')" />
                        <x-input id="relation" type="text" name="relation"
                            value="{{ old('relation', $applicant->relation) }}"
                            placeholder="Tulis relasi disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('relation') }}</span>
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-1">
                    <div class="relative z-0 w-full group">
                        <x-label for="address" :value="__('Alamat')" />
                        <x-textarea id="address" type="address" name="address" value="{{ $applicant->address }}"
                            placeholder="Tulis alamat disini...">{{ $applicant->address }}</x-textarea>
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('address') }}</span>
                        </p>
                    </div>
                </div>
            </section>
        </section>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/api-notif.js') }}"></script>
    @if ($applicant->address == null)
        <script src="{{ asset('js/indonesia.js') }}"></script>
    @endif
    <script>
        $(document).ready(function() {
            $('.js-example-input-single').select2({
                tags: true,
            });
        });
    </script>
    <script>
        let phoneInput = document.getElementById('phone');
        phoneInput.addEventListener('input', function() {
            let phone = phoneInput.value;
            if (phone.startsWith("62")) {
                if (phone.length === 3 && (phone[2] === "0" || phone[2] !== "8")) {
                    phoneInput.value = '62';
                } else {
                    phoneInput.value = phone;
                }
            } else if (phone.startsWith("0")) {
                phoneInput.value = '62' + phone.substring(1);
            } else {
                phoneInput.value = '62';
            }
        });

        const saveChanges = () => {
            const form = document.getElementById('formChanges');
            form.submit();
        }
    </script>
@endpush
