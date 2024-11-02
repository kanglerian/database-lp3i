<x-app-layout>
    <x-slot name="header">
        <nav class="flex">
            <ol class="inline-flex items-center space-x-2 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('presenters.index') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">
                        <i class="fa-solid fa-users mr-2"></i>
                        Presenter
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $presenter->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>


    <main class="max-w-7xl mx-auto">
        <section class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <a href="{{ route('presenters.sales_volume', $presenter->id) }}"
                class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer px-6 py-5 rounded-3xl transition ease-in-out space-y-2">
                <h2 class="font-bold space-x-1">
                    <i class="fa-solid fa-users"></i>
                    <span>Sales Volume</span>
                </h2>
                <p class="text-sm">Lihat data volume penjualan untuk memahami tren dan meningkatkan strategi penjualan.</p>
                <i class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
            </a>
            <a href="{{ route('presenters.sales_revenue', $presenter->id) }}"
                class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer px-6 py-5 rounded-3xl transition ease-in-out space-y-2">
                <h2 class="font-bold space-x-1">
                    <i class="fa-solid fa-wallet"></i>
                    <span>Sales Revenue</span>
                </h2>
                <p class="text-xs">Telusuri total pendapatan dari penjualan untuk mengevaluasi pencapaian finansial dan kinerja tim.</p>
                <i class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
            </a>
            <a href="{{ route('presenters.sales_database', $presenter->id) }}"
                class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer px-6 py-5 rounded-3xl transition ease-in-out space-y-2">
                <h2 class="font-bold space-x-1">
                    <i class="fa-solid fa-database"></i>
                    <span>Target Database</span>
                </h2>
                <p class="text-xs">Akses dan kelola database target untuk memperluas jaringan prospek dan meningkatkan peluang penjualan.</p>
                <i class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
            </a>
        </section>
    </main>
</x-app-layout>
