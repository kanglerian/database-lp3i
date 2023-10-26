<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight py-2">
                {{ __('Tambah Akun Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('message'))
                <div id="alert" class="mx-2 mb-4 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-lg"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            <div class="bg-white overflow-hidden border md:rounded-xl">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('user.store') }}">
                        @csrf
                        <div class="grid md:grid-cols-1 md:gap-6 mb-4 lg:mb-0">
                            <div class="relative z-0 w-full lg:mb-4 group">
                                <x-label for="name" :value="__('Nama lengkap')" />
                                <x-input id="name" type="text" name="name" :value="old('name')"
                                    placeholder="Tulis nama lengkap disini..." required />
                                <p class="mt-2 text-xs text-gray-500">
                                    <span class="text-red-500">{{ $errors->first('name') }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-6 mb-4 lg:mb-0">
                            <div class="relative z-0 w-full group mb-4">
                                <x-label for="phone" :value="__('No. Telpon (Whatsapp)')" />
                                <x-input id="phone" type="text" name="phone" :value="old('phone')"
                                    placeholder="Tulis no. telpon / whatsapp disini..." required />
                                <p class="mt-2 text-xs text-gray-500">
                                    <span class="text-red-500">{{ $errors->first('phone') }}</span>
                                </p>
                            </div>
                            <div class="relative z-0 w-full group">
                                <x-label for="email" :value="__('Email')" />
                                <x-input id="email" type="email" name="email" :value="old('email')"
                                    placeholder="Tulis no. telpon / whatsapp disini..." required />
                                <p class="mt-2 text-xs text-gray-500">
                                    <span class="text-red-500">{{ $errors->first('email') }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-6 mb-4 lg:mb-0">
                            <div class="relative z-0 w-full group mb-4">
                                <x-label for="password" :value="__('Password')" />
                                <x-input id="password" type="password" name="password" :value="old('password')"
                                    placeholder="Tulis password disini..." required />
                                <p class="mt-2 text-xs text-gray-500">
                                    <span class="text-red-500">{{ $errors->first('password') }}</span>
                                </p>
                            </div>
                            <div class="relative z-0 w-full group">
                                <x-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                                <x-input id="password_confirmation" type="password" name="password_confirmation"
                                    placeholder="Tulis konfirmasi password disini..." required />
                                <p class="mt-2 text-xs text-gray-500">
                                    <span class="text-red-500">{{ $errors->first('password_confirmation') }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-6 mb-4 lg:mb-0">
                            <div class="relative z-0 w-full group mb-4">
                                <x-label for="role" :value="__('Peran')" />
                                <x-select id="role" name="role" required>
                                    <option>Pilih peran</option>
                                    <option value="P">Presenter</option>
                                    <option value="A">Administrator</option>
                                </x-select>
                            </div>
                            <div class="relative z-0 w-full group">
                                <x-label for="status" :value="__('Status')" />
                                <x-select id="status" name="status" required>
                                    <option>Pilih status</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </x-select>
                            </div>
                        </div>
                        <button type="submit"
                            class="text-white mt-5 bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2 text-center"><i
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
