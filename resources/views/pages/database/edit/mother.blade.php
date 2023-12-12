<div class="w-full px-6 py-6 bg-white shadow-sm sm:rounded-lg">
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
            <hr class="mt-2 mb-5">
            <section>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                    <div class="relative z-0 w-full group">
                        <x-label for="mother_name" :value="__('Nama Lengkap')" />
                        <x-input id="mother_name" type="text" name="mother_name"
                            value="{{ old('mother_name', $mother->name) }}" placeholder="Nama lengkap disini.." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('mother_name') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="mother_job" :value="__('Pekerjaan')" />
                        <x-input id="mother_job" type="text" name="mother_job"
                            value="{{ old('mother_job', $mother->job) }}" placeholder="Tulis pekerjaan ibu disini.." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('mother_job') }}</span>
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                    <div class="relative z-0 w-full group">
                        <x-label for="mother_place_of_birth" :value="__('Tempat Lahir')" />
                        <x-input id="mother_place_of_birth" type="text" name="mother_place_of_birth"
                            value="{{ old('mother_place_of_birth', $mother->place_of_birth) }}"
                            placeholder="Tulis tempat lahir disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('mother_place_of_birth') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="mother_date_of_birth" :value="__('Tanggal Lahir')" />
                        <x-input id="mother_date_of_birth" type="date" name="mother_date_of_birth"
                            value="{{ old('mother_date_of_birth', $mother->date_of_birth) }}"
                            placeholder="Tulis tempat lahir disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('mother_date_of_birth') }}</span>
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                    <div class="relative z-0 w-full group">
                        <x-label for="mother_education" :value="__('Pendidikan Terakhir')" />
                        <x-input id="mother_education" type="text" name="mother_education"
                            value="{{ old('mother_education', $mother->education) }}"
                            placeholder="Tulis pendidikan terakhir disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('mother_education') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="mother_phone" :value="__('No. Whatsapp')" />
                        <x-input id="mother_phone" type="number" name="mother_phone" value="{{ $mother->phone }}"
                            placeholder="Tulis no. Whatsapp disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('mother_phone') }}</span>
                        </p>
                    </div>
                </div>

                <div class="@if ($mother->address) hidden @endif" id="address-container-mother">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-4">
                        <div class="relative z-0 w-full group">
                            <x-label for="mother_place" :value="__('Jl/Kp/Perum')" />
                            <x-input id="mother_place" type="text" name="mother_place" placeholder="Jl. / Kp. / Perum"
                                required />
                        </div>
                        <div class="relative z-0 w-full group">
                            <x-label for="mother_rt" :value="__('RT')" />
                            <x-input id="mother_rt" type="text" name="mother_rt" placeholder="RT." required />
                        </div>
                        <div class="relative z-0 w-full group">
                            <x-label for="mother_rw" :value="__('RW')" />
                            <x-input id="mother_rw" type="text" name="mother_rw" placeholder="RW." required />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div class="relative z-0 w-full group">
                            <x-label for="mother_provinces" :value="__('Provinsi')" />
                            <x-select id="mother_provinces" name="mother_provinces" required disabled></x-select>
                        </div>
                        <div class="relative z-0 w-full group">
                            <x-label for="mother_regencies" :value="__('Kota/Kabupaten')" />
                            <x-select id="mother_regencies" name="mother_regencies" required disabled>
                                <option>Pilih Kota / Kabupaten</option>
                            </x-select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-4">
                        <div class="relative z-0 w-full group">
                            <x-label for="mother_districts" :value="__('Kecamatan')" />
                            <x-select id="mother_districts" name="mother_districts" required disabled>
                                <option>Pilih Kecamatan</option>
                            </x-select>
                        </div>
                        <div class="relative z-0 w-full group">
                            <x-label for="mother_villages" :value="__('Desa/Kelurahan')" />
                            <x-select id="mother_villages" name="mother_villages" required disabled>
                                <option>Pilih Desa / Kelurahan</option>
                            </x-select>
                        </div>
                        <div class="relative z-0 w-full group">
                            <x-label for="mother_postal_code" :value="__('Kode Pos')" />
                            <x-input id="mother_postal_code" type="text" name="mother_postal_code" placeholder="Kode Pos"
                                required />
                        </div>
                    </div>
                </div>
                @if ($mother->address)
                <div class="space-y-2" id="address-content-mother">
                    <h3 class="font-bold text-gray-900 text-sm">Alamat:</h3>
                    <input type="hidden" id="mother_address" name="mother_address" value="{{ $mother->address }}">
                    <p class="text-sm text-gray-700">{{ $mother->address }}</p>
                    <span onclick="editAddressMother()"
                        class="inline-block cursor-pointer text-xs bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-1.5 rounded-lg">Ubah
                        Alamat</span>
                </div>
                @endif
            </section>
        </section>
    </div>
</div>
