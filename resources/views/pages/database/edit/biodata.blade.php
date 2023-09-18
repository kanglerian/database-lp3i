<div class="w-full px-6 py-6 bg-white shadow sm:rounded-lg">
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
            <hr class="mt-2 mb-8">
            <section>
                <div class="grid md:grid-cols-2 md:gap-6 mb-4 lg:mb-0">
                    <div class="relative z-0 w-full group mb-4">
                        <x-label for="name" :value="__('Nama Lengkap')" />
                        <x-input id="name" type="text" name="name" value="{{ old('name', $applicant->name) }}"
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
                            @if ($errors->has('name'))
                                <span class="text-red-500">{{ $errors->first('gender') }}</span>
                            @else
                                <span class="text-red-500">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="grid md:grid-cols-3 md:gap-6 mb-4 lg:mb-0">
                    <div class="relative z-0 w-full group mb-4">
                        <x-label for="place_of_birth" :value="__('Tempat Lahir')" />
                        <x-input id="place_of_birth" type="text" name="place_of_birth"
                            value="{{ old('place_of_birth', $applicant->place_of_birth) }}"
                            placeholder="Tulis tempat lahir disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('place_of_birth') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group mb-4">
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
                        <x-select id="religion" name="religion">
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

                <div class="grid md:grid-cols-3 md:gap-6 mb-4 lg:mb-0">
                    <div class="relative z-0 w-full group mb-4">
                        <x-label for="education" :value="__('Pendidikan Terakhir')" />
                        <x-input id="education" type="text" name="education"
                            value="{{ old('education', $applicant->education) }}"
                            placeholder="Tulis pendidikan terakhir disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('education') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group mb-4">
                        <x-label for="major" :value="__('Jurusan')" />
                        <x-input id="major" type="text" name="major"
                            value="{{ old('major', $applicant->major) }}" placeholder="Tulis jurusan disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('major') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="year" :value="__('Tahun Lulus')" />
                        <x-input type="number" min="1945" max="3000" name="year" id="year"
                            value="{{ old('year', $applicant->year) }}" placeholder="Tulis tahun lulus disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('year') }}</span>
                        </p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full group mb-4">
                        <x-label for="school" :value="__('Sekolah')" />
                        <x-select id="school" name="school" class="js-example-input-single">
                            @if ($applicant->school)
                                <option value="{{ $applicant->SchoolApplicant->id }}">
                                    {{ $applicant->SchoolApplicant->name }}</option>
                            @else
                                <option value="0">Pilih Sekolah</option>
                            @endif
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('school') }}</span>
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
                @if ($applicant->address == null)
                    <div id="address-container" class="hidden">
                        <div class="grid md:grid-cols-2 md:gap-6 mb-4 lg:mb-0">
                            <div class="relative z-0 w-full group mb-4">
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

                        <div class="grid md:grid-cols-2 md:gap-6 mb-4 lg:mb-0">
                            <div class="relative z-0 w-full group mb-4">
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

                        <div class="grid md:grid-cols-3 md:gap-6 mb-4 lg:mb-0">
                            <div class="relative z-0 w-full group mb-4">
                                <x-label for="rt" :value="__('RT')" />
                                <x-input id="rt" type="number" name="rt" :value="old('rt')"
                                    placeholder="Tulis RT disini..." />
                                <p class="mt-2 text-xs text-gray-500">
                                    <span class="text-red-500">{{ $errors->first('rt') }}</span>
                                </p>
                            </div>
                            <div class="relative z-0 w-full group mb-4">
                                <x-label for="rw" :value="__('RW')" />
                                <x-input id="rw" type="number" name="rw" :value="old('rw')"
                                    placeholder="Tulis RW disini..." />
                                <p class="mt-2 text-xs text-gray-500">
                                    <span class="text-red-500">{{ $errors->first('rw') }}</span>
                                </p>
                            </div>
                            <div class="relative z-0 w-full group">
                                <x-label for="postal_code" :value="__('Kode Pos')" />
                                <x-input id="postal_code" type="number" name="postal_code" :value="old('postal_code')"
                                    placeholder="Tulis kode pos disini..." />
                                <p class="mt-2 text-xs text-gray-500">
                                    <span class="text-red-500">{{ $errors->first('postal_code') }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="grid md:grid-cols-1 md:gap-6">
                        <div class="relative z-0 w-full group">
                            <x-label for="address" :value="__('Alamat')" />
                            <x-textarea id="address" type="address" name="address"
                                value="{{ $applicant->address }}"
                                placeholder="Tulis alamat disini...">{{ $applicant->address }}</x-textarea>
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

@push('scripts')
    @if ($applicant->address == null)
        <script src="{{ asset('js/api-notif.js') }}"></script>
        <script src="{{ asset('js/indonesia.js') }}"></script>
    @endif
    <script>
        $(document).ready(function() {
            $('.js-example-input-single').select2();
        });
    </script>
    <script>
        let phoneInput = document.getElementById('phone');
        phoneInput.addEventListener('input', function() {
            let phone = phoneInput.value;
            if (phone.startsWith('62')) {} else if (phone.startsWith('0')) {
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
