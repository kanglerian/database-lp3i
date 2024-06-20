<x-guest-layout>
    <x-auth-card-login>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />


        <div class="mb-4 text-sm text-gray-600">
            <p>Lupa password? Santai aja. Cukup kasih tau email kamu, nanti kami kirim link reset password biar kamu
                bisa bikin password baru sendiri.</p>
        </div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full text-sm" type="email" name="email" maxlength="50"
                    :value="old('email')" placeholder="Masukan email" required autofocus />
            </div>

            <button type="submit"
                class="w-full text-white bg-lp3i-100 hover:bg-lp3i-200 font-medium rounded-xl text-sm mt-4 px-5 py-2.5 focus:outline-none">
                <span>{{ __('Email Password Reset Link') }}</span>
            </button>

            <div class="text-center mt-3">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Ingat kembali?') }}
                </a>
            </div>
        </form>

    </x-auth-card-login>
</x-guest-layout>
