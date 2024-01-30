<div class="p-6 bg-white shadow-sm sm:rounded-lg">
    <div class="w-full">
        <section>
            <header class="flex flex-col md:flex-row md:items-center justify-between">
                <div class="w-full md:w-auto">
                    <h2 class="text-xl font-bold text-gray-900">
                        Biodata Aplikan
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Calon Mahasiswa Politeknik LP3I Kampus Tasikmalaya.
                    </p>
                </div>
            </header>
            <hr class="my-3">
            <section>
                <div class="grid md:grid-cols-1 gap-3 mb-3">
                    <div class="relative z-0 w-full group">
                        <x-label for="name" :value="__('Nama Lengkap')" />
                        <x-input id="name" type="text" name="name" :value="old('name')"
                            placeholder="Nama lengkap disini.." required />
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('name'))
                                <span class="text-red-500 text-xs">{{ $errors->first('name') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-3 mb-3">
                    <div class="relative z-0 w-full group">
                        <x-label for="gender" :value="__('Jenis Kelamin')" />
                        <x-select id="gender" name="gender" required>
                            <option value="null">Pilih jenis kelamin</option>
                            <option value="1">Laki-laki</option>
                            <option value="0">Perempuan</option>
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('gender'))
                                <span class="text-red-500 text-xs">{{ $errors->first('gender') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="education" :value="__('Pendidikan Terakhir')" />
                        <x-select id="education" name="education" required>
                            <option>Pilih</option>
                            <option value="MA">MA</option>
                            <option value="SMA">SMA</option>
                            <option value="SMK">SMK</option>
                            <option value="PKBM">PKBM</option>
                            <option value="D3">D3</option>
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('education'))
                                <span class="text-red-500 text-xs">{{ $errors->first('education') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-3 mb-3">
                    <div class="relative z-0 w-full group">
                        <x-label for="status_education" :value="__('Status Sekolah')" />
                        <x-select id="status_education" name="status_education" required>
                            <option>Pilih</option>
                            <option value="S">Swasta</option>
                            <option value="N">Negeri</option>
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('education'))
                                <span class="text-red-500 text-xs">{{ $errors->first('education') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="school" :value="__('Sekolah')" />
                        <x-select id="school" name="school" class="js-example-input-single">
                            <option value="TIDAK DIKETAHUI">Pilih Sekolah</option>
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('school') }}</span>
                        </p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-3 mb-3">
                    <div class="relative z-0 w-full group">
                        <x-label for="email" :value="__('Email')" />
                        <x-input id="email" type="email" name="email" :value="old('email')"
                            placeholder="Tulis tempat lahir disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('email') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="phone" :value="__('No. Whatsapp')" />
                        <x-input id="phone" type="number" name="phone" :value="old('phone')"
                            placeholder="Tulis no. Whatsapp disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('phone') }}</span>
                        </p>
                    </div>
                </div>

                <button type="button" onclick="saveDatabase()"
                    class="text-white bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2 text-center"><i
                        class="fa-solid fa-floppy-disk mr-1"></i> Simpan</button>
            </section>
        </section>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.js-example-input-single').select2({
                tags: true,
            });
        });

        const saveDatabase = () => {
            const form = document.getElementById('formDatabase');
            form.submit();
        }

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
    </script>
@endpush
