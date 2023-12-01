<div class="px-6 py-6 bg-white shadow sm:rounded-lg">
    <div class="w-full">
        <section>
            <header class="flex flex-col md:flex-row md:items-center justify-between gap-5 py-3">
                <div class="w-full md:w-auto">
                    <h2 class="text-xl font-bold text-gray-900">
                        Biodata Aplikan
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Calon Mahasiswa Politeknik LP3I Kampus Tasikmalaya.
                    </p>
                </div>
            </header>
            <hr class="mt-3 mb-5">
            <section>
                <div class="grid md:grid-cols-2 md:gap-6 mb-4 lg:mb-0">
                    <div class="relative z-0 w-full group mb-4">
                        <x-label for="name" :value="__('Nama Lengkap')" />
                        <x-input id="name" type="text" name="name" :value="old('name')"
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
                            <option value="null">Pilih jenis kelamin</option>
                            <option value="1">Laki-laki</option>
                            <option value="0">Perempuan</option>
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

                <div class="grid md:grid-cols-3 md:gap-6 mb-4 lg:mb-0">
                    <div class="relative z-0 w-full group mb-4">
                        <x-label for="place_of_birth" :value="__('Tempat Lahir')" />
                        <x-input id="place_of_birth" type="text" name="place_of_birth" :value="old('place_of_birth')"
                            placeholder="Tulis tempat lahir disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('place_of_birth') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group mb-4">
                        <x-label for="date_of_birth" :value="__('Tanggal Lahir')" />
                        <x-input id="date_of_birth" type="date" name="date_of_birth" :value="old('date_of_birth')"
                            placeholder="Tulis tempat lahir disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('date_of_birth') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="religion" :value="__('Agama')" />
                        <x-select id="religion" name="religion">
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Konghucu">Konghucu</option>
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('religion') }}</span>
                        </p>
                    </div>
                </div>

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

                <div class="grid md:grid-cols-3 md:gap-6 mb-4 lg:mb-0">
                    <div class="relative z-0 w-full mb-6 group mb-4">
                        <x-label for="email" :value="__('Email')" />
                        <x-input id="email" type="email" name="email" :value="old('email')"
                            placeholder="Tulis tempat lahir disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('email') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group mb-4">
                        <x-label for="phone" :value="__('No. Whatsapp')" />
                        <x-input id="phone" type="number" name="phone" :value="old('phone')"
                            placeholder="Tulis no. Whatsapp disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('phone') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="social_media" :value="__('Sosial Media')" />
                        <x-input id="social_media" type="text" name="social_media" :value="old('social_media')"
                            placeholder="Tulis username disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('social_media') }}</span>
                        </p>
                    </div>
                </div>

                <div class="grid md:grid-cols-3 md:gap-6 mb-4 lg:mb-0">
                    <div class="relative z-0 w-full group mb-4">
                        <x-label for="education" :value="__('Pendidikan Terakhir')" />
                        <x-input id="education" type="text" name="education" :value="old('education')"
                            placeholder="Tulis pendidikan terakhir disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('education') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group mb-4">
                        <x-label for="major" :value="__('Jurusan')" />
                        <x-input id="major" type="text" name="major" :value="old('major')"
                            placeholder="Tulis jurusan disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('major') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="year" :value="__('Tahun Lulus')" />
                        <x-input type="number" min="1945" max="3000" name="year" id="year"
                            :value="old('year')" placeholder="Tulis tahun lulus disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('year') }}</span>
                        </p>
                    </div>
                </div>

                <div class="grid md:grid-cols-3 md:gap-6 mb-4 lg:mb-0">
                    <div class="relative z-0 w-full group mb-4">
                        <x-label for="school" :value="__('Sekolah')" />
                        <x-select id="school" name="school" class="js-example-input-single">
                            <option value="TIDAK DIKETAHUI">Pilih Sekolah</option>
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('school') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group mb-4">
                        <div class="relative z-0 w-full group">
                            <x-label for="class" :value="__('Kelas')" />
                            <x-input id="class" type="text" name="class" :value="old('class')"
                                placeholder="Tulis kelas disini..." />
                            <p class="mt-2 text-xs text-gray-500">
                                <span class="text-red-500">{{ $errors->first('class') }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="relative z-0 w-full group">
                        <div class="relative z-0 w-full group">
                            <x-label for="achievement" :value="__('Prestasi')" />
                            <x-input id="achievement" type="text" name="achievement" :value="old('achievement')"
                                placeholder="Tulis prestasi disini..." />
                            <p class="mt-2 text-xs text-gray-500">
                                <span class="text-red-500">{{ $errors->first('achievement') }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid md:grid-cols-3 md:gap-6 mb-4 lg:mb-0">
                    <div class="relative z-0 w-full group mb-4">
                        <x-label for="kip" :value="__('Nomor KIP')" />
                        <x-input id="kip" type="number" name="kip" value="{{ old('kip') }}"
                            placeholder="Tulis nomor KIP disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('kip') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group mb-4">
                        <x-label for="income_parent" :value="__('Penghasilan Orang Tua')" />
                        <x-select id="income_parent" name="income_parent">
                            <option value="null">Pilih</option>
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
                    <div class="relative z-0 w-full group">
                        <x-label for="relation" :value="__('Relasi')" />
                        <x-input id="relation" type="text" name="relation" :value="old('relation')"
                            placeholder="Tulis relasi disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('relation') }}</span>
                        </p>
                    </div>
                </div>

                <button type="button" onclick="saveDatabase()"
                    class="text-white bg-lp3i-100 mt-3 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2 text-center"><i
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
