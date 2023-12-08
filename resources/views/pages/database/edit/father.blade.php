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
                            <span class="text-red-500">{{ $errors->first('father_name') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="father_job" :value="__('Pekerjaan')" />
                        <x-input id="father_job" type="text" name="father_job"
                            value="{{ old('father_job', $father->job) }}" placeholder="Tulis pekerjaan ibu disini.." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('father_job') }}</span>
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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                    <div class="relative z-0 w-full group">
                        <x-label for="father_education" :value="__('Pendidikan Terakhir')" />
                        <x-input id="father_education" type="text" name="father_education"
                            value="{{ old('father_education', $father->education) }}"
                            placeholder="Tulis pendidikan terakhir disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('father_education') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="father_phone" :value="__('No. Whatsapp')" />
                        <x-input id="father_phone" type="number" name="father_phone" value="{{ $father->phone }}"
                            placeholder="Tulis no. Whatsapp disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('father_phone') }}</span>
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-1">
                    <div class="relative z-0 w-full group">
                        <x-label for="father_address" :value="__('Alamat')" />
                        <x-textarea id="father_address" type="father_address" name="father_address"
                            value="{{ old('father_address', $father->address) }}"
                            placeholder="Tulis alamat disini...">{{ $father->address }}</x-textarea>
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('father_address') }}</span>
                        </p>
                    </div>
                </div>
            </section>
        </section>
    </div>
</div>
