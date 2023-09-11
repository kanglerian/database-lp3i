<x-guest-layout>
    <x-auth-card>
        @if (session('error'))
            <div id="alert" class="mx-2 mb-4 flex items-center p-4 mb-4 bg-red-500 text-white rounded-lg"
                role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div class="ml-3 text-sm font-medium">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mt-4">
                <x-label for="name" :value="__('Nama lengkap')" />
                <x-input id="name" class="block mt-1 w-full text-sm" type="text" name="name" :value="old('name')" placeholder="Masukkan Nama Lengkap Anda" required autofocus />
                <div class="text-xs text-red-700 mt-3">
                    {{ $errors->first('name') }}
                </div>
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />
                <x-input id="email" class="block mt-1 w-full text-sm" type="email" name="email" :value="old('email')"
                placeholder="Masukkan Alamat Email Anda" required />
                <div class="text-xs text-red-700 mt-3">
                    {{ $errors->first('email') }}
                </div>
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="phone" :value="__('No. Whatsapp')" />
                <x-input id="phone" class="block mt-1 w-full text-sm" type="number" name="phone" :value="old('phone')" placeholder="Masukkan Nomor WhatsApp Anda" required />
                <div class="text-xs text-red-700 mt-3">
                    {{ $errors->first('phone') }}
                </div>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />
                <x-input id="password" class="block mt-1 w-full text-sm" type="password" name="password" required
                    autocomplete="new-password" placeholder="Masukkan Password Anda" required />
                <div class="text-xs text-red-700 mt-3">
                    {{ $errors->first('password') }}
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Konfirmasi password')" />
                <x-input id="password_confirmation" class="block mt-1 w-full text-sm" type="password"
                    name="password_confirmation" placeholder="Konfirmasi Password Anda" required />
                <div class="text-xs text-red-700 mt-3">
                    {{ $errors->first('password') }}
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Sudah memiliki akun?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Daftar') }}
                </x-button>
            </div>

            <hr class="mt-5"/>
            <div class="mt-3">
                <p class="text-xs">Jika terjadi <code class="text-red-500">The email has already been taken.</code> atau <code class="text-red-500">The phone has already been taken.</code> Hubungi kami melalui Whatsapp 😊</p>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>