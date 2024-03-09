<div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 px-5">
    <div class="w-full flex items-center justify-center">
        <a href="{{ route('welcome') }}" class="flex items-center gap-5">
            <img src="{{ asset('img/lp3i-logo.svg') }}" alt="Politeknik LP3I Kampus Tasikmalaya" class="w-48">
            <img src="{{ asset('logo/logo-kampusglobalmandiri.png') }}" alt="Kampus Global Mandiri" class="w-40">
        </a>
    </div>
    <div class="w-full sm:max-w-md mt-6 p-8 bg-white border border-gray-100 rounded-3xl">
        {{ $slot }}
    </div>
</div>
