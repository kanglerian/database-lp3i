<div class="w-full px-6 py-6 bg-white shadow-sm sm:rounded-lg">
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
            <hr class="mt-2 mb-5">
            <section>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                    <div class="relative z-0 w-full group">
                        <x-label for="father_name" :value="__('Nama Lengkap')" />
                        <x-input id="father_name" type="text" name="father_name"
                            value="{{ old('father_name', $father->name) }}" placeholder="Nama lengkap disini.." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('father_name') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="father_job" :value="__('Pekerjaan')" />
                        <x-input id="father_job" type="text" name="father_job"
                            value="{{ old('father_job', $father->job) }}" placeholder="Tulis pekerjaan ibu disini.." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('father_job') }}</span>
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                    <div class="relative z-0 w-full group">
                        <x-label for="father_place_of_birth" :value="__('Tempat Lahir')" />
                        <x-input id="father_place_of_birth" type="text" name="father_place_of_birth"
                            value="{{ old('father_place_of_birth', $father->place_of_birth) }}"
                            placeholder="Tulis tempat lahir disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('father_place_of_birth') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="father_date_of_birth" :value="__('Tanggal Lahir')" />
                        <x-input id="father_date_of_birth" type="date" name="father_date_of_birth"
                            value="{{ old('father_date_of_birth', $father->date_of_birth) }}"
                            placeholder="Tulis tempat lahir disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('father_date_of_birth') }}</span>
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                    <div class="relative z-0 w-full group">
                        <x-label for="father_education" :value="__('Pendidikan Terakhir')" />
                        <x-input id="father_education" type="text" name="father_education"
                            value="{{ old('father_education', $father->education) }}"
                            placeholder="Tulis pendidikan terakhir disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('father_education') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="father_phone" :value="__('No. Whatsapp')" />
                        <x-input id="father_phone" type="number" name="father_phone" value="{{ $father->phone }}"
                            placeholder="Tulis no. Whatsapp disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('father_phone') }}</span>
                        </p>
                    </div>
                </div>
                <div class="@if ($father->address) hidden @endif" id="address-container-father">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-4">
                        <div class="relative z-0 w-full group">
                            <x-label for="father_place" :value="__('Jl/Kp/Perum')" />
                            <x-input id="father_place" type="text" name="father_place" placeholder="Jl. / Kp. / Perum"
                                required />
                        </div>
                        <div class="relative z-0 w-full group">
                            <x-label for="father_rt" :value="__('RT')" />
                            <x-input id="father_rt" type="text" name="father_rt" placeholder="RT." required />
                        </div>
                        <div class="relative z-0 w-full group">
                            <x-label for="father_rw" :value="__('RW')" />
                            <x-input id="father_rw" type="text" name="father_rw" placeholder="RW." required />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div class="relative z-0 w-full group">
                            <x-label for="father_provinces" :value="__('Provinsi')" />
                            <x-select id="father_provinces" name="father_provinces" required disabled></x-select>
                        </div>
                        <div class="relative z-0 w-full group">
                            <x-label for="father_regencies" :value="__('Kota/Kabupaten')" />
                            <x-select id="father_regencies" name="father_regencies" required disabled>
                                <option>Pilih Kota / Kabupaten</option>
                            </x-select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-4">
                        <div class="relative z-0 w-full group">
                            <x-label for="father_districts" :value="__('Kecamatan')" />
                            <x-select id="father_districts" name="father_districts" required disabled>
                                <option>Pilih Kecamatan</option>
                            </x-select>
                        </div>
                        <div class="relative z-0 w-full group">
                            <x-label for="father_villages" :value="__('Desa/Kelurahan')" />
                            <x-select id="father_villages" name="father_villages" required disabled>
                                <option>Pilih Desa / Kelurahan</option>
                            </x-select>
                        </div>
                        <div class="relative z-0 w-full group">
                            <x-label for="father_postal_code" :value="__('Kode Pos')" />
                            <x-input id="father_postal_code" type="text" name="father_postal_code" placeholder="Kode Pos"
                                required />
                        </div>
                    </div>
                </div>
                @if ($father->address)
                <div class="space-y-2" id="address-content-father">
                    <h3 class="font-bold text-gray-900 text-sm">Alamat:</h3>
                    <input type="hidden" id="father_address" name="father_address" value="{{ $father->address }}">
                    <p class="text-sm text-gray-700">{{ $father->address }}</p>
                    <span onclick="editAddressFather()"
                        class="inline-block cursor-pointer text-xs bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-1.5 rounded-lg">Ubah
                        Alamat</span>
                </div>
                @endif
            </section>
        </section>
    </div>
</div>
