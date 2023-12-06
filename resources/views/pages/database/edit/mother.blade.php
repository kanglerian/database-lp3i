<div class="w-full px-6 py-6 bg-white shadow sm:rounded-lg">
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
                            <span class="text-red-500">{{ $errors->first('mother_name') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="mother_job" :value="__('Pekerjaan')" />
                        <x-input id="mother_job" type="text" name="mother_job"
                            value="{{ old('mother_job', $mother->job) }}" placeholder="Tulis pekerjaan ibu disini.." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('mother_job') }}</span>
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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                    <div class="relative z-0 w-full group">
                        <x-label for="mother_education" :value="__('Pendidikan Terakhir')" />
                        <x-input id="mother_education" type="text" name="mother_education"
                            value="{{ old('mother_education', $mother->education) }}"
                            placeholder="Tulis pendidikan terakhir disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('mother_education') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="mother_phone" :value="__('No. Whatsapp')" />
                        <x-input id="mother_phone" type="number" name="mother_phone" value="{{ $mother->phone }}"
                            placeholder="Tulis no. Whatsapp disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('mother_phone') }}</span>
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-1">
                    <div class="relative z-0 w-full group">
                        <x-label for="mother_address" :value="__('Alamat')" />
                        <x-textarea id="mother_address" type="mother_address" name="mother_address"
                            value="{{ old('mother_address', $mother->address) }}"
                            placeholder="Tulis alamat disini...">{{ $mother->address }}</x-textarea>
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('mother_address') }}</span>
                        </p>
                    </div>
                </div>

            </section>
        </section>
    </div>
</div>
