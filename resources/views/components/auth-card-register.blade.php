<div class="my-8 flex-col justify-center items-center px-5">
    <div class="w-full flex items-center justify-center">
        <a href="{{ route('welcome') }}">
            <img src="{{ asset('img/lp3i-logo.svg') }}" alt="Politeknik LP3I Kampus Tasikmalaya" class="w-56 text-center">
        </a>
    </div>
    <div class="w-full flex items-center justify-center">
        <div class="w-full lg:w-7/12 mt-6 p-6 bg-white shadow-lg rounded-lg">
            {{ $slot }}
        </div>
    </div>
</div>
