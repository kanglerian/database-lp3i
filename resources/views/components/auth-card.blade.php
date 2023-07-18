<div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 bg-gray-50 px-5">
    <div class="w-full flex items-center justify-center">
        <a href="{{ route('welcome') }}">
            <img src="{{ asset('img/lp3i-logo.svg') }}" alt="Politeknik LP3I Kampus Tasikmalaya" class="w-56 text-center">
        </a>
    </div>
    <div class="w-full sm:max-w-md mt-6 p-6 bg-white shadow-md overflow-hidden rounded-lg">
        {{ $slot }}
    </div>
</div>
