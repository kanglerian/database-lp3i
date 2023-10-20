<div class="flex items-center flex-wrap gap-5">
    <a href="{{ route('database.index') }}"
        class="inline-block border border-gray-400 hover:bg-gray-400 hover:text-white text-gray-500 px-4 py-2 rounded-lg text-sm"><i
            class="fa-solid fa-arrow-left"></i> Kembali</a>
    <a href="{{ route('database.show', $user->identity) }}"
        class="{{ request()->segment(1) == 'database' ? 'inline-flex items-center px-1 pt-1 border-b-2 border-lp3i-100 text-sm font-medium leading-8 text-gray-900 focus:outline-none focus:border-lp3i-300 transition duration-150 ease-in-out' : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-8 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out' }} "><i
            class="fa-regular fa-id-card mr-2"></i> Profil</a>
    @if ($user->phone)
        <a href="{{ route('database.chat', $user->identity) }}"
            class="{{ request()->segment(1) == 'chat' ? 'inline-flex items-center px-1 pt-1 border-b-2 border-lp3i-100 text-sm font-medium leading-8 text-gray-900 focus:outline-none focus:border-lp3i-300 transition duration-150 ease-in-out' : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-8 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out' }}"><i
                class="fa-regular fa-comments mr-2"></i> Chat</a>
    @endif
    <a href="{{ route('database.file', $user->identity) }}"
        class="{{ request()->segment(1) == 'file' ? 'inline-flex items-center px-1 pt-1 border-b-2 border-lp3i-100 text-sm font-medium leading-8 text-gray-900 focus:outline-none focus:border-lp3i-300 transition duration-150 ease-in-out' : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-8 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out' }}"><i
            class="fa-regular fa-folder-open mr-2"></i> Berkas</a>
    <a href="{{ route('database.achievement', $user->identity) }}"
        class="{{ request()->segment(1) == 'achievement' ? 'inline-flex items-center px-1 pt-1 border-b-2 border-lp3i-100 text-sm font-medium leading-8 text-gray-900 focus:outline-none focus:border-lp3i-300 transition duration-150 ease-in-out' : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-8 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out' }}"><i class="fa-solid fa-trophy mr-2"></i> Prestasi
    </a>
    <a href="{{ route('database.organization', $user->identity) }}"
        class="{{ request()->segment(1) == 'organization' ? 'inline-flex items-center px-1 pt-1 border-b-2 border-lp3i-100 text-sm font-medium leading-8 text-gray-900 focus:outline-none focus:border-lp3i-300 transition duration-150 ease-in-out' : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-8 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out' }}"><i class="fa-solid fa-sitemap mr-2"></i> Pengalaman Organisasi
    </a>
</div>
