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
                <div class="grid md:grid-cols-2 md:gap-6 mb-4 lg:mb-0">
                    <div class="relative z-0 w-full group mb-4">
                        <x-label for="father_name" :value="__('Nama Lengkap')" />
                        <x-input id="father_name" type="text" name="father_name"
                            value="{{ old('father_name', $father->name) }}" placeholder="Nama lengkap disini.."
                            required />
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('father_name'))
                                <span class="text-red-500">{{ $errors->first('father_name') }}</span>
                            @else
                                <span class="text-red-500">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="father_job" :value="__('Pekerjaan')" />
                        <x-input id="father_job" type="text" name="father_job"
                            value="{{ old('father_job', $father->job) }}" placeholder="Nama lengkap disini.."
                            required />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('father_job') }}</span>
                        </p>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 md:gap-6 mb-4 lg:mb-0">
                    <div class="relative z-0 w-full group mb-4">
                        <x-label for="father_place_of_birth" :value="__('Tempat Lahir')" />
                        <x-input id="father_place_of_birth" type="text" name="father_place_of_birth"
                            value="{{ old('father_place_of_birth', $father->place_of_birth) }}"
                            placeholder="Tulis tempat lahir disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('father_place_of_birth') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="father_date_of_birth" :value="__('Tanggal Lahir')" />
                        <x-input id="father_date_of_birth" type="date" name="father_date_of_birth"
                            value="{{ old('father_date_of_birth', $father->date_of_birth) }}"
                            placeholder="Tulis tempat lahir disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('father_date_of_birth') }}</span>
                        </p>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full group mb-4">
                        <x-label for="father_education" :value="__('Pendidikan Terakhir')" />
                        <x-input id="father_education" type="text" name="father_education"
                            value="{{ old('father_education', $father->education) }}"
                            placeholder="Tulis pendidikan terakhir disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('father_education') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full mb-4 group">
                        <div class="relative z-0 w-full group">
                            <x-label for="father_phone" :value="__('No. Whatsapp')" />
                            <x-input id="father_phone" type="number" name="father_phone" value="{{ $father->phone }}"
                                placeholder="Tulis no. Whatsapp disini..." />
                            <p class="mt-2 text-xs text-gray-500">
                                <span class="text-red-500">{{ $errors->first('father_phone') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                @if ($father->address != null)
                <div class="grid md:grid-cols-1 md:gap-6">
                    <div class="relative z-0 w-full group">
                        <x-label for="father_address" :value="__('Alamat')" />
                        <x-textarea id="father_address" type="father_address" name="father_address" value="{{ old('father_address', $father->address) }}" placeholder="Tulis alamat disini...">{{ $father->address }}</x-textarea>
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('father_address') }}</span>
                        </p>
                    </div>
                </div>
                @else
                <div id="address-father-container" class="hidden">
                    @if ($applicant->address !== null)
                    <div class="flex mb-3">
                        <input id="father-checkbox" onclick="fatherAddress()" type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                        <label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900">Alamat
                            sama dengan
                            aplikan?</label>
                    </div>
                    @endif
                    <div id="father_address_container">
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full group mb-4">
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
                        <div class="grid md:grid-cols-2 md:gap-6 mb-4 lg:mb-0">
                            <div class="relative z-0 w-full group mb-4">
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
                            <div class="relative z-0 w-full group mb-4">
                                <x-label for="father_rt" :value="__('RT')" />
                                <x-input id="father_rt" type="number" name="father_rt" :value="old('father_rt')"
                                    placeholder="Tulis RT disini..." />
                                <p class="mt-2 text-xs text-gray-500">
                                    <span class="text-red-500">{{ $errors->first('father_rt') }}</span>
                                </p>
                            </div>
                            <div class="relative z-0 w-full group mb-4">
                                <x-label for="father_rw" :value="__('RW')" />
                                <x-input id="father_rw" type="number" name="father_rw" :value="old('father_rw')"
                                    placeholder="Tulis RW disini..." />
                                <p class="mt-2 text-xs text-gray-500">
                                    <span class="text-red-500">{{ $errors->first('father_rw') }}</span>
                                </p>
                            </div>
                            <div class="relative z-0 w-full group">
                                <x-label for="father_postal_code" :value="__('Kode Pos')" />
                                <x-input id="father_postal_code" type="number" name="father_postal_code"
                                    :value="old('father_postal_code')" placeholder="Tulis kode pos disini..." />
                                <p class="mt-2 text-xs text-gray-500">
                                    <span class="text-red-500">{{ $errors->first('father_postal_code') }}</span>
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
    @if ($father->address == null)
        <script src="{{ asset('js/indonesiaFather.js') }}"></script>
    @endif
    <script>
        let phoneFatherInput = document.getElementById('father_phone');
        phoneFatherInput.addEventListener('input', function() {
            let phone = phoneFatherInput.value;
            if (phone.startsWith('62')) {
            } else if (phone.startsWith('0')) {
                phoneFatherInput.value = '62' + phone.substring(1);
            } else {
                phoneFatherInput.value = '62';
            }
        });
    </script>
    <script>
        const fatherAddress = () => {
            let checkboxFather = document.getElementById('father-checkbox').checked;
            let fatherAddressContainer = document.getElementById('father_address_container');
            let content;
            if (checkboxFather == true) {
                content = `
                <div class="grid md:grid-cols-1 md:gap-6 mb-4 lg:mb-0">
                    <div class="relative z-0 w-full group">
                        <x-label for="father_address" :value="__('Alamat')" />
                        <x-textarea id="father_address" type="father_address" name="father_address" value="{{ old('father_address', $father->address) }}" placeholder="Tulis alamat disini...">{{ $father->address }}</x-textarea>
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('father_address') }}</span>
                        </p>
                    </div>
                </div>
            `;
            } else {
                content = `
                <div class="grid md:grid-cols-2 md:gap-6 mb-4 lg:mb-0">
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
                <div class="grid md:grid-cols-2 md:gap-6 mb-4 lg:mb-0">
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
                <div class="grid md:grid-cols-3 md:gap-6 mb-4 lg:mb-0">
                    <div class="relative z-0 w-full group">
                        <x-label for="father_rt" :value="__('RT')" />
                        <x-input id="father_rt" type="number" name="father_rt" :value="old('father_rt')" placeholder="Tulis RT disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('father_rt') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="father_rw" :value="__('RW')" />
                        <x-input id="father_rw" type="number" name="father_rw" :value="old('father_rw')" placeholder="Tulis RW disini..." />
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
@endpush
