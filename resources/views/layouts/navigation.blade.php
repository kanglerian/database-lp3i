<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 py-2">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 py-3">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard.index') }}">
                        <img src="{{ asset('img/lp3i-logo.svg') }}" alt="Politeknik LP3I Kampus Tasikmalaya"
                            class="w-40 text-center">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard.index')" :active="request()->routeIs('dashboard.index')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @if ((Auth::check() && Auth::user()->status == '1' && Auth::user()->role == 'P') || Auth::user()->role == 'A')
                        <x-nav-link :href="route('database.index')" :active="request()->routeIs(['database.index', 'database.create', 'database.edit', 'database.show', 'histories.show'])">
                            {{ __('Database') }}
                        </x-nav-link>
                    @endif
                    @if (Auth::check() && Auth::user()->status == '1' && Auth::user()->role == 'A')
                        <x-nav-link :href="route('presenter.index')" :active="request()->routeIs(['presenter.index', 'presenter.create', 'presenter.edit'])">
                            {{ __('Presenter') }}
                        </x-nav-link>
                    @endif
                    @if (Auth::check() && Auth::user()->status == '1' && Auth::user()->role == 'A')
                        <x-nav-link :href="route('user.index')" :active="request()->routeIs(['user.index', 'user.create', 'user.edit', 'user.show'])">
                            {{ __('Akun') }}
                        </x-nav-link>
                    @endif
                    @if (Auth::check() && Auth::user()->status == '1' && Auth::user()->role == 'A')
                        <x-nav-link :href="route('setting.index')" :active="request()->routeIs(['setting.index', 'setting.create', 'setting.edit', 'setting.show'])">
                            {{ __('Pengaturan') }}
                        </x-nav-link>
                    @endif
                    @if (Auth::check() && Auth::user()->status == '1' && Auth::user()->role == 'S')
                        <x-nav-link :href="route('userupload.edit', Auth::user()->identity)" :active="request()->routeIs(['userupload.index', 'userupload.create', 'userupload.edit'])">
                            {{ __('Upload Berkas') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex gap-3 bg-slate-50 px-4 py-2 rounded-lg items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            @if (Auth::user()->avatar)
                                <img src="https://api.politekniklp3i-tasikmalaya.ac.id/pmbonline/download/{{ Auth::user()->identity }}/{{ Auth::user()->identity }}-{{ Auth::user()->avatar }}"
                                    alt="Avatar" class="h-8 rounded-full">
                            @else
                                <img src="{{ asset('img/avatar.png') }}" alt="Avatar" class="h-8 rounded-full">
                            @endif
                            <div class="flex flex-col items-start">
                                <span class="font-bold">{{ Auth::user()->name }}</span>
                                <span class="text-xs">
                                    @switch(Auth::user()->role)
                                        @case('A')
                                            Administrator
                                        @break

                                        @case('P')
                                            Presenter
                                        @break

                                        @case('S')
                                            Student
                                        @break
                                    @endswitch
                                    ({{ Auth::user()->identity }})
                                </span>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            @if (Auth::check() && Auth::user()->status == '1')
                                <x-dropdown-link :href="route('profile.edit', Auth::user()->id)">
                                    {{ __('Edit Profile') }}
                                </x-dropdown-link>
                            @endif
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard.index')" :active="request()->routeIs('dashboard.index')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @if ((Auth::check() && Auth::user()->status == '1' && Auth::user()->role == 'P') || Auth::user()->role == 'A')
                <x-responsive-nav-link :href="route('database.index')" :active="request()->routeIs('database')">
                    {{ __('Database') }}
                </x-responsive-nav-link>
            @endif
            @if (Auth::check() && Auth::user()->status == '1' && Auth::user()->role == 'A')
                <x-responsive-nav-link :href="route('presenter.index')" :active="request()->routeIs('presenter')">
                    {{ __('Presenter') }}
                </x-responsive-nav-link>
            @endif
            @if (Auth::check() && Auth::user()->status == '1' && Auth::user()->role == 'A')
                <x-responsive-nav-link :href="route('user.index')" :active="request()->routeIs('user')">
                    {{ __('Akun') }}
                </x-responsive-nav-link>
            @endif
            @if (Auth::check() && Auth::user()->status == '1' && Auth::user()->role == 'A')
                <x-responsive-nav-link :href="route('setting.index')" :active="request()->routeIs('setting')">
                    {{ __('Pengaturan') }}
                </x-responsive-nav-link>
            @endif
            @if (Auth::check() && Auth::user()->status == '1' && Auth::user()->role == 'S')
                <x-responsive-nav-link :href="route('userupload.index')" :active="request()->routeIs('userupload')">
                    {{ __('Upload') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}
                    ({{ Auth::user()->identity }})</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
