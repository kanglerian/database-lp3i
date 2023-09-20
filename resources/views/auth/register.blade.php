@push('styles')
    <link href="{{ asset('css/select2-input.css') }}" rel="stylesheet" />
@endpush
<x-guest-layout>
    <x-auth-card-register>
        @if (session('error'))
            <div id="alert" class="mx-2 mb-3 flex items-center p-4 mb-3 bg-red-500 text-white rounded-lg"
                role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div class="ml-3 text-sm font-medium">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        <div class="text-center bg-lp3i-500 py-5 rounded-lg">
            <h2 class="text-xl font-bold text-white">Formulir Pendaftaran Online</h2>
        </div>
        <hr class="my-7">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="grid md:grid-cols-2 md:gap-6 mb-3 lg:mb-0">
                <div class="relative z-0 w-full group mb-3">
                    <x-label for="programtype_id" :value="__('Program Kuliah')" />
                    <x-select id="programtype_id" name="programtype_id" required>
                        <option value="0">Pilih program</option>
                        @forelse ($programtypes as $programtype)
                            <option value="{{ $programtype->id }}">{{ $programtype->name }}</option>
                        @empty
                            <option value="Reguler Pagi">Reguler Pagi</option>
                        @endforelse
                    </x-select>
                    <p class="mt-2 text-xs text-gray-500">
                        @if ($errors->has('programtype_id'))
                            <span class="text-red-500">{{ $errors->first('programtype_id') }}</span>
                        @else
                            <span class="text-red-500">*Wajib diisi.</span>
                        @endif
                    </p>
                </div>
                <div class="relative z-0 w-full group">
                    <x-label for="program" :value="__('Program')" />
                    <x-select id="program" name="program" required>
                        <option value="0">Pilih program</option>
                        @if ($programs == null)
                            <option value="Belum diketahui">Belum diketahui</option>
                        @else
                            @foreach ($programs as $prog)
                                <option value="{{ $prog['level'] }} {{ $prog['title'] }}">
                                    {{ $prog['level'] }}
                                    {{ $prog['title'] }}</option>
                            @endforeach
                        @endif
                    </x-select>
                    <p class="mt-2 text-xs text-gray-500">
                        @if ($errors->has('program'))
                            <span class="text-red-500">{{ $errors->first('program') }}</span>
                        @else
                            <span class="text-red-500">*Wajib diisi.</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="inline-flex items-center justify-center w-full">
                <hr class="w-64 h-px my-8 bg-gray-200 border-0">
                <span class="absolute px-3 font-medium text-gray-900 -translate-x-1/2 bg-white left-1/2">Biodata</span>
            </div>

            <div class="grid md:grid-cols-2 md:gap-6 mb-3 lg:mb-0">
                <div class="relative z-0 w-full group mb-3">
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

            <div class="grid md:grid-cols-3 md:gap-6 mb-3 lg:mb-0">
                <div class="relative z-0 w-full group mb-3">
                    <x-label for="place_of_birth" :value="__('Tempat Lahir')" />
                    <x-input id="place_of_birth" type="text" name="place_of_birth" :value="old('place_of_birth')"
                        placeholder="Tulis tempat lahir disini..." />
                    <p class="mt-2 text-xs text-gray-500">
                        <span class="text-red-500">{{ $errors->first('place_of_birth') }}</span>
                    </p>
                </div>
                <div class="relative z-0 w-full group mb-3">
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

            <div class="grid md:grid-cols-3 md:gap-6 mb-3 lg:mb-0">
                <div class="relative z-0 w-full group mb-3">
                    <x-label for="education" :value="__('Pendidikan Terakhir')" />
                    <x-input id="education" type="text" name="education" :value="old('education')"
                        placeholder="Tulis pendidikan terakhir disini..." />
                    <p class="mt-2 text-xs text-gray-500">
                        <span class="text-red-500">{{ $errors->first('education') }}</span>
                    </p>
                </div>
                <div class="relative z-0 w-full group mb-3">
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

            <div class="grid md:grid-cols-2 md:gap-6 mb-3 lg:mb-0">
                <div class="relative z-0 w-full group mb-3">
                    <x-label for="school" :value="__('Sekolah')" />
                    <x-select id="school" name="school" class="js-example-input-single">
                        <option value="0">Pilih Sekolah</option>
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
                    <x-input id="class" type="text" name="class" :value="old('class')"
                        placeholder="Tulis kelas disini..." />
                    <p class="mt-2 text-xs text-gray-500">
                        <span class="text-red-500">{{ $errors->first('class') }}</span>
                    </p>
                </div>
            </div>

            <div id="address-container" class="hidden">
                <div class="grid md:grid-cols-2 md:gap-6 mb-3 lg:mb-0">
                    <div class="relative z-0 w-full group mb-3">
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
                <div class="grid md:grid-cols-2 md:gap-6 mb-3 lg:mb-0">
                    <div class="relative z-0 w-full group mb-3">
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
                <div class="grid md:grid-cols-3 md:gap-6 mb-3 lg:mb-0">
                    <div class="relative z-0 w-full group mb-3">
                        <x-label for="rt" :value="__('RT')" />
                        <x-input id="rt" type="number" name="rt" :value="old('rt')"
                            placeholder="Tulis RT disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('rt') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group mb-3">
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

            <div class="inline-flex items-center justify-center w-full">
                <hr class="w-64 h-px my-8 bg-gray-200 border-0">
                <span class="absolute px-3 font-medium text-gray-900 -translate-x-1/2 bg-white left-1/2">Pendaftaran
                    Akun</span>
            </div>

            <div class="grid md:grid-cols-2 md:gap-6 mb-3 lg:mb-0">
                <div class="relative z-0 w-full group mb-3">
                    <x-label for="email" :value="__('Email')" />
                    <x-input id="email" class="block mt-1 w-full text-sm" type="email" name="email"
                        :value="old('email')" placeholder="Masukkan Alamat Email Anda" required />
                    <div class="text-xs text-red-700 mt-3">
                        {{ $errors->first('email') }}
                    </div>
                </div>
                <div class="relative z-0 w-full group">
                    <x-label for="phone" :value="__('No. Whatsapp')" />
                    <x-input id="phone" class="block mt-1 w-full text-sm" type="number" name="phone"
                        :value="old('phone')" placeholder="Masukkan Nomor WhatsApp Anda" required />
                    <div class="text-xs text-red-700 mt-3">
                        {{ $errors->first('phone') }}
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 md:gap-6 mb-3 lg:mb-0">
                <div class="relative z-0 w-full group mb-3">
                    <x-label for="password" :value="__('Password')" />
                    <x-input id="password" class="block mt-1 w-full text-sm" type="password" name="password"
                        required autocomplete="new-password" placeholder="Masukkan Password Anda" required />
                    <div class="text-xs text-red-700 mt-3">
                        {{ $errors->first('password') }}
                    </div>
                </div>
                <div class="relative z-0 w-full group">
                    <x-label for="password_confirmation" :value="__('Konfirmasi password')" />
                    <x-input id="password_confirmation" class="block mt-1 w-full text-sm" type="password"
                        name="password_confirmation" placeholder="Konfirmasi Password Anda" required />
                    <div class="text-xs text-red-700 mt-3">
                        {{ $errors->first('password') }}
                    </div>
                </div>
            </div>

            <input type="hidden" name="pmb" id="pmb" value="">

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Sudah memiliki akun?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Daftar') }}
                </x-button>
            </div>

            <hr class="mt-5" />
            <div class="mt-3">
                <p class="text-xs">Jika terjadi <code class="text-red-500">The email has already been
                        taken.</code>
                    atau
                    <code class="text-red-500">The phone has already been taken.</code> Hubungi kami melalui
                    Whatsapp
                    😊
                </p>
            </div>
        </form>
    </x-auth-card-register>
</x-guest-layout>
<script src="{{ asset('js/indonesia.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.js-example-input-single').select2();
    });

    const getYearPMB = () => {
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear();
        const currentMonth = currentDate.getMonth();
        const startYear = currentMonth >= 9 ? currentYear + 1 : currentYear;
        document.getElementById('pmb').value = startYear;
    }
    getYearPMB();
    let phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function() {
        let phone = phoneInput.value;

        if (phone.startsWith('62')) {} else if (phone.startsWith('0')) {
            phoneInput.value = '62' + phone.substring(1);
        } else {
            phoneInput.value = '62';
        }
    });
</script>