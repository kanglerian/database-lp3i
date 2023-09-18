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
                            value="{{ old('mother_name', $mother->name) }}" placeholder="Nama lengkap disini.."
                            required />
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('mother_name'))
                                <span class="text-red-500">{{ $errors->first('mother_name') }}</span>
                            @else
                                <span class="text-red-500">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="mother_job" :value="__('Pekerjaan')" />
                        <x-input id="mother_job" type="text" name="mother_job"
                            value="{{ old('mother_job', $mother->job) }}" placeholder="Nama lengkap disini.."
                            required />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('mother_job') }}</span>
                        </p>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 md:gap-6 mb-5">
                    <div class="relative z-0 w-full group">
                        <x-label for="mother_place_of_birth" :value="__('Tempat Lahir')" />
                        <x-input id="mother_place_of_birth" type="text" name="mother_place_of_birth"
                            value="{{ old('mother_place_of_birth', $mother->place_of_birth) }}"
                            placeholder="Tulis tempat lahir disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('mother_place_of_birth') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="mother_date_of_birth" :value="__('Tanggal Lahir')" />
                        <x-input id="mother_date_of_birth" type="date" name="mother_date_of_birth"
                            value="{{ old('mother_date_of_birth', $mother->date_of_birth) }}"
                            placeholder="Tulis tempat lahir disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('mother_date_of_birth') }}</span>
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
                            <span class="text-red-500">{{ $errors->first('mother_education') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <div class="relative z-0 w-full group">
                            <x-label for="mother_phone" :value="__('No. Whatsapp')" />
                            <x-input id="mother_phone" type="number" name="mother_phone" value="{{ $mother->phone }}"
                                placeholder="Tulis no. Whatsapp disini..." />
                            <p class="mt-2 text-xs text-gray-500">
                                <span class="text-red-500">{{ $errors->first('mother_phone') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                @if ($father->address != null)
                    <div class="grid md:grid-cols-1 md:gap-6">
                        <div class="relative z-0 w-full group">
                            <x-label for="father_address" :value="__('Alamat')" />
                            <x-textarea id="father_address" type="father_address" name="father_address"
                                value="{{ old('father_address', $father->address) }}"
                                placeholder="Tulis alamat disini...">
                                {{ $father->address }}
                            </x-textarea>
                            <p class="mt-2 text-xs text-gray-500">
                                <span class="text-red-500">{{ $errors->first('father_address') }}</span>
                            </p>
                        </div>
                    </div>
                @else
                    <div id="address-mother-container" class="hidden">
                        @if ($applicant->address !== null)
                            <div class="flex mb-3">
                                <input id="mother-checkbox" onclick="motherAddress()" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                <label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900">Alamat
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
                                    <x-input id="mother_postal_code" type="number" name="mother_postal_code"
                                        :value="old('mother_postal_code')" placeholder="Tulis kode pos disini..." />
                                    <p class="mt-2 text-xs text-gray-500">
                                        <span class="text-red-500">{{ $errors->first('mother_postal_code') }}</span>
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

@push('scripts')
    @if ($mother->address == null)
        <script src="{{ asset('js/indonesiaMother.js') }}"></script>
    @endif
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
        const motherAddress = () => {
            let checkboxMother = document.getElementById('mother-checkbox').checked;
            let motherAddressContainer = document.getElementById('mother_address_container');
            let content;
            if (checkboxMother == true) {
                content = `
            <div class="grid md:grid-cols-1 md:gap-6 mb-5">
                <div class="relative z-0 w-full group">
                    <x-label for="mother_address" :value="__('Alamat')" />
                    <x-textarea id="mother_address" type="mother_address" name="mother_address" value="{{ $applicant->address }}"
                        placeholder="Tulis alamat disini...">
                        {{ $applicant->address }}
                    </x-textarea>
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
    </script>
@endpush
