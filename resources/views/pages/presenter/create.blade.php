<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight py-2">
                {{ __('Tambah Presenter Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto px-5 md:p-0">
            @if (session('message'))
                <div id="alert" class="mx-2 mb-4 flex items-center p-4 bg-emerald-500 text-emerald-50 rounded-2xl"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-reguler">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            <div class="bg-white overflow-hidden border rounded-3xl">
                <div class="p-8 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('presenters.store') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="relative z-0 w-full group">
                                <x-label for="name" :value="__('Nama lengkap')" />
                                <x-input id="name" type="text" name="name" maxlength="50" :value="old('name')"
                                    placeholder="Tulis nama lengkap disini..." required />
                                <p class="mt-2 text-xs text-gray-500">
                                    <span class="text-red-500 text-xs">{{ $errors->first('name') }}</span>
                                </p>
                            </div>
                            <div class="relative z-0 w-full group">
                                <x-label for="gender" :value="__('Jenis Kelamin')" />
                                <x-select id="gender" name="gender" required>
                                    <option>Pilih gender</option>
                                    <option value="1">Laki-laki</option>
                                    <option value="0">Perempuan</option>
                                </x-select>
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-6 mb-4 lg:mb-0">
                            <div class="relative z-0 w-full group mb-4">
                                <x-label for="phone" :value="__('No. Telpon (Whatsapp)')" />
                                <x-input id="phone" type="number" name="phone" maxlength="14" :value="old('phone')"
                                    placeholder="Tulis no. telpon / whatsapp disini..." required />
                                <p class="mt-2 text-xs text-gray-500">
                                    <span class="text-red-500 text-xs">{{ $errors->first('phone') }}</span>
                                </p>
                            </div>
                            <div class="relative z-0 w-full group">
                                <x-label for="email" :value="__('Email')" />
                                <x-input id="email" type="email" name="email" maxlength="50"  :value="old('email')"
                                    placeholder="Tulis email disini..." required />
                                <p class="mt-2 text-xs text-gray-500">
                                    <span class="text-red-500 text-xs">{{ $errors->first('email') }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-6 mb-4 lg:mb-0">
                            <div class="relative z-0 w-full group mb-4">
                                <x-label for="password" :value="__('Password')" />
                                <x-input id="password" type="password" name="password" :value="old('password')"
                                    placeholder="Tulis password disini..." required />
                                <p class="mt-2 text-xs text-gray-500">
                                    <span class="text-red-500 text-xs">{{ $errors->first('password') }}</span>
                                </p>
                            </div>
                            <div class="relative z-0 w-full group">
                                <x-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                                <x-input id="password_confirmation" type="password" name="password_confirmation"
                                    :value="old('password_confirmation')" placeholder="Tulis konfirmasi password disini..." required />
                                <p class="mt-2 text-xs text-gray-500">
                                    <span class="text-red-500 text-xs">{{ $errors->first('password_confirmation') }}</span>
                                </p>
                            </div>
                        </div>
                        <button type="submit"
                            class="text-white bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm w-full sm:w-auto px-5 py-2 text-center"><i
                                class="fa-solid fa-floppy-disk mr-1"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    let phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function() {
        let phone = phoneInput.value;

        if (phone.startsWith('62')) {
        } else if (phone.startsWith('0')) {
            phoneInput.value = '62' + phone.substring(1);
        } else {
            phoneInput.value = '62';
        }
    });
</script>
