<x-guest-layout>
    <x-auth-card-login>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full text-sm" type="email" name="email" maxlength="50"
                    :value="old('email', $request->email)" placeholder="Masukan email" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password Baru')" />
                <div class="flex items-center gap-3 relative">
                    <x-input id="password" class="block w-full text-sm" type="password" name="password"
                        placeholder="Masukan kata sandi baru" required autocomplete="current-password" />
                    <button type="button" class="absolute right-3 top-[18px] text-gray-300" id="see-password"
                        onclick="seePassword()"><i class="fa-solid fa-eye"></i></button>
                </div>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                <div class="flex items-center gap-3 relative">
                    <x-input id="password_confirmation" class="block w-full text-sm" type="password" name="password_confirmation"
                        placeholder="Masukan kata sandi baru" required autocomplete="current-password" />
                    <button type="button" class="absolute right-3 top-[18px] text-gray-300" id="see-confirm-password"
                        onclick="seeConfirmPassword()"><i class="fa-solid fa-eye"></i></button>
                </div>
            </div>

            <button type="submit"
                class="w-full text-white bg-lp3i-100 hover:bg-lp3i-200 font-medium rounded-xl text-sm mt-4 px-5 py-2.5 focus:outline-none">
                <span>{{ __('Reset Password') }}</span>
            </button>
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
            const seeConfirmPassword = () => {
                let passwordElement = document.getElementById('password_confirmation');
                let seeElement = document.getElementById('see-confirm-password');
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

