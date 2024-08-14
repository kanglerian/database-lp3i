@push('styles')
    <link href="{{ asset('css/select2-input.css') }}" rel="stylesheet" />
@endpush
<x-guest-layout>
    <x-auth-card-register>
        @if (session('error'))
            <div id="alert" class="flex items-center p-4 mb-3 bg-red-500 text-white rounded-lg"
                role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div class="ml-3 text-sm font-reguler">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        <div class="text-center bg-lp3i-500 py-5 rounded-2xl">
            <h2 class="text-xl font-bold text-white">Formulir Pendaftaran Online</h2>
        </div>
        <hr class="my-7">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="grid md:grid-cols-2 md:gap-6 mb-3 lg:mb-0">
                <div class="relative z-0 w-full group mb-3">
                    <x-label for="programtype_id" :value="__('Program Kuliah')" />
                    <x-select id="programtype_id" onchange="filterProgram()" name="programtype_id" required>
                        <option value="0">Pilih program</option>
                        @forelse ($programtypes as $programtype)
                            <option value="{{ $programtype->id }}">{{ $programtype->name }}</option>
                        @empty
                            <option value="Reguler">Reguler</option>
                        @endforelse
                    </x-select>
                    <p class="mt-2 text-xs text-gray-500">
                        @if ($errors->has('programtype_id'))
                            <span class="text-red-500 text-xs">{{ $errors->first('programtype_id') }}</span>
                        @else
                            <span class="text-red-500 text-xs">*Wajib diisi.</span>
                        @endif
                    </p>
                </div>
                <div class="relative z-0 w-full group">
                    <x-label for="program" :value="__('Program')" />
                    <x-select id="program" name="program" required disabled>
                        <option value="0">Pilih Program Studi</option>
                    </x-select>
                    <p class="mt-2 text-xs text-gray-500">
                        @if ($errors->has('program'))
                            <span class="text-red-500 text-xs">{{ $errors->first('program') }}</span>
                        @else
                            <span class="text-red-500 text-xs">*Wajib diisi.</span>
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
                    <x-input id="name" type="text" name="name" maxlength="50" :value="old('name')"
                        placeholder="Nama lengkap disini.." required />
                    <p class="mt-2 text-xs text-gray-500">
                        @if ($errors->has('name'))
                            <span class="text-red-500 text-xs">{{ $errors->first('name') }}</span>
                        @else
                            <span class="text-red-500 text-xs">*Wajib diisi.</span>
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
                            <span class="text-red-500 text-xs">{{ $errors->first('gender') }}</span>
                        @else
                            <span class="text-red-500 text-xs">*Wajib diisi.</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="grid md:grid-cols-3 md:gap-6 mb-3 lg:mb-0">
                <div class="relative z-0 w-full group mb-3">
                    <x-label for="place_of_birth" :value="__('Tempat Lahir')" />
                    <x-input id="place_of_birth" type="text" name="place_of_birth" maxlength="50" :value="old('place_of_birth')"
                        placeholder="Tulis tempat lahir disini..." />
                    <p class="mt-2 text-xs text-gray-500">
                        @if ($errors->has('place_of_birth'))
                            <span class="text-red-500 text-xs">{{ $errors->first('place_of_birth') }}</span>
                        @else
                            <span class="text-red-500 text-xs">*Wajib diisi.</span>
                        @endif
                    </p>
                </div>
                <div class="relative z-0 w-full group mb-3">
                    <x-label for="date_of_birth" :value="__('Tanggal Lahir')" />
                    <x-input id="date_of_birth" type="date" name="date_of_birth" :value="old('date_of_birth')"
                        placeholder="Tulis tempat lahir disini..." />
                    <p class="mt-2 text-xs text-gray-500">
                        @if ($errors->has('date_of_birth'))
                            <span class="text-red-500 text-xs">{{ $errors->first('date_of_birth') }}</span>
                        @else
                            <span class="text-red-500 text-xs">*Wajib diisi.</span>
                        @endif
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
                        @if ($errors->has('religion'))
                            <span class="text-red-500 text-xs">{{ $errors->first('religion') }}</span>
                        @else
                            <span class="text-red-500 text-xs">*Wajib diisi.</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 md:gap-6 mb-3 lg:mb-0">
                <div class="relative z-0 w-full group mb-3">
                    <x-label for="school" class="mb-[3px]" :value="__('Sekolah')" />
                    <x-select id="school" name="school" class="js-example-input-single">
                        <option>Pilih Sekolah</option>
                        @foreach ($schools as $school)
                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                        @endforeach
                    </x-select>
                    <p class="mt-2 text-xs text-gray-500">
                        @if ($errors->has('school'))
                            <span class="text-red-500 text-xs">{{ $errors->first('school') }}</span>
                        @else
                            <span class="text-red-500 text-xs">*Wajib diisi.</span>
                        @endif
                    </p>
                </div>
                <div class="relative z-0 w-full group">
                    <x-label for="year" :value="__('Tahun Lulus')" />
                    <x-input type="number" min="1945" max="3000" name="year" id="year"
                        :value="old('year')" placeholder="Tulis tahun lulus disini..." required />
                    <p class="mt-2 text-xs text-gray-500">
                        @if ($errors->has('year'))
                            <span class="text-red-500 text-xs">{{ $errors->first('year') }}</span>
                        @else
                            <span class="text-red-500 text-xs">*Wajib diisi.</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 md:gap-6 mb-3 lg:mb-0">
                <div class="relative z-0 w-full group mb-3">
                    <x-label for="major" :value="__('Jurusan')" />
                    <x-input id="major" type="text" name="major" maxlength="100" :value="old('major')"
                        placeholder="Tulis jurusan disini..." />
                    <p class="mt-2 text-xs text-gray-500">
                        @if ($errors->has('major'))
                            <span class="text-red-500 text-xs">{{ $errors->first('major') }}</span>
                        @else
                            <span class="text-red-500 text-xs">*Wajib diisi.</span>
                        @endif
                    </p>
                </div>
                <div class="relative z-0 w-full group">
                    <x-label for="class" :value="__('Kelas')" />
                    <x-input id="class" type="text" name="class" :value="old('class')"
                        placeholder="Tulis kelas disini..." />
                    <p class="mt-2 text-xs text-gray-500">
                        @if ($errors->has('class'))
                            <span class="text-red-500 text-xs">{{ $errors->first('class') }}</span>
                        @else
                            <span class="text-red-500 text-xs">*Wajib diisi.</span>
                        @endif
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
                        <x-input id="rt" type="text" name="rt" maxlength="2" :value="old('rt')"
                            placeholder="Tulis RT disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('rt') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group mb-3">
                        <x-label for="rw" :value="__('RW')" />
                        <x-input id="rw" type="number" name="rw" maxlength="2" :value="old('rw')"
                            placeholder="Tulis RW disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('rw') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="postal_code" :value="__('Kode Pos')" />
                        <x-input id="postal_code" type="number" name="postal_code" maxlength="7" :value="old('postal_code')"
                            placeholder="Tulis kode pos disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('postal_code') }}</span>
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
                    <x-input id="email" class="block mt-1 w-full text-sm" type="email" name="email" maxlength="50"
                        :value="old('email')" placeholder="Masukkan Alamat Email Anda" required />
                    <div class="text-xs text-red-700 mt-3">
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('email'))
                                <span class="text-red-500 text-xs">{{ $errors->first('email') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="relative z-0 w-full group">
                    <x-label for="phone" :value="__('No. Whatsapp')" />
                    <x-input id="phone" class="block mt-1 w-full text-sm" type="number" name="phone" maxlength="14"
                        :value="old('phone')" placeholder="Masukkan Nomor WhatsApp Anda" required />
                    <div class="text-xs text-red-700 mt-3">
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('phone'))
                                <span class="text-red-500 text-xs">{{ $errors->first('phone') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 md:gap-6 mb-3 lg:mb-0">
                <div class="relative z-0 w-full group mb-3">
                    <x-label for="password" :value="__('Password')" />
                    <div class="flex items-center gap-3 relative">
                        <x-input id="password" class="block mt-1 w-full text-sm" type="password" name="password"
                            required autocomplete="new-password" placeholder="Masukkan Password Anda" required />
                        <button type="button" class="absolute right-3 top-[18px] text-gray-300" id="see-password"
                            onclick="seePassword()"><i class="fa-solid fa-eye"></i></button>
                    </div>
                    <div class="text-xs text-red-700 mt-3">
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('password'))
                                <span class="text-red-500 text-xs">{{ $errors->first('password') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="relative z-0 w-full group">
                    <x-label for="password_confirmation" :value="__('Konfirmasi password')" />
                    <div class="flex items-center gap-3 relative">
                        <x-input id="password_confirmation" class="block mt-1 w-full text-sm" type="password"
                            name="password_confirmation" placeholder="Konfirmasi Password Anda" required />
                        <button type="button" class="absolute right-3 top-[18px] text-gray-300" id="see-password-confirmation"
                            onclick="seePasswordConfirmation()"><i class="fa-solid fa-eye"></i></button>
                    </div>
                    <div class="text-xs text-red-700 mt-3">
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('password'))
                                <span class="text-red-500 text-xs">{{ $errors->first('password') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <input type="hidden" name="pmb" maxlength="4" id="pmb" value="">

            <button type="submit" class="w-full text-white bg-lp3i-100 hover:bg-lp3i-200 font-medium rounded-xl text-sm mt-4 px-5 py-2.5 focus:outline-none">
                {{ __('Daftar') }}
            </button>

            <div class="text-center mt-3">
                <a class="underline text-sm text-gray-500 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Sudah memiliki akun?') }}
                </a>
            </div>
        </form>
    </x-auth-card-register>
</x-guest-layout>
<script src="{{ asset('js/indonesia.js') }}"></script>
<script src="{{ asset('js/axios.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.js-example-input-single').select2({
            tags: true,
        });
    });

    const filterProgram = async () => {
        let programType = document.getElementById('programtype_id').value;
        await axios.get('https://dashboard.politekniklp3i-tasikmalaya.ac.id/api/programs')
            .then((res) => {
                let programs = res.data;
                var results;
                let bucket = '';
                switch (programType) {
                    case "1":
                        results = programs.filter(program => program.regular === "1");
                        break;
                    case "2":
                        results = programs.filter(program => program.employee === "1");
                        break;
                    default:
                        document.getElementById('program').innerHTML =
                            `<option value="0">Pilih Program Studi</option>`;
                        document.getElementById('program').disabled = true;
                        break
                }
                if (programType != 0 && programType != 3) {
                    results.map((result) => {
                        console.log(result);
                        let option = '';
                        result.interest.map((inter, index) => {
                            option +=
                                `<option value="${result.level} ${result.title}">${inter.name}</option>`;
                        })
                        bucket += `
                    <optgroup label="${result.level} ${result.title} (${result.campus})">
                        ${option}
                    </optgroup>`;
                    });
                    document.getElementById('program').innerHTML = bucket;
                    document.getElementById('program').disabled = false;
                }
            })
            .catch((err) => {
                console.log(err.message);
            });

    }

    const seePassword = () => {
        let passwordElement = document.getElementById('password');
        let seeElement = document.getElementById('see-password');
        let attribute = passwordElement.getAttribute('type');
        if (attribute === 'text') {
            passwordElement.setAttribute('type', 'password');
            seeElement.innerHTML = '<i class="fa-solid fa-eye"></i>';
        } else {
            passwordElement.setAttribute('type', 'text');
            seeElement.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
        }
    }

    const seePasswordConfirmation = () => {
        let passwordElement = document.getElementById('password_confirmation');
        let seeElement = document.getElementById('see-password-confirmation');
        let attribute = passwordElement.getAttribute('type');
        if (attribute === 'text') {
            passwordElement.setAttribute('type', 'password');
            seeElement.innerHTML = '<i class="fa-solid fa-eye"></i>';
        } else {
            passwordElement.setAttribute('type', 'text');
            seeElement.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
        }
    }

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
