<x-guest-layout>
    <x-auth-card-login>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full text-sm" type="email" name="email" :value="old('email')"
                    placeholder="Masukan email" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />
                <div class="flex items-center gap-3 relative">
                    <x-input id="password" class="block w-full text-sm" type="password" name="password"
                        placeholder="Masukan kata sandi" required autocomplete="current-password" />
                    <button type="button" class="absolute right-3 top-[18px] text-gray-700" id="see-password" onclick="seePassword()"><i
                            class="fa-solid fa-eye"></i></button>
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                    {{ __('Belum memiliki akun?') }}
                </a>

                <x-button class="ml-3 rounded-xl">
                    {{ __('Masuk') }}
                </x-button>
            </div>
        </form>

        <script>
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
        </script>

    </x-auth-card-login>
</x-guest-layout>
