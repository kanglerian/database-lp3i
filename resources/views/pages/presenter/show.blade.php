<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight py-2">
                Detail Presenter: {{ $presenter->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('message'))
                <div id="alert" class="mx-2 mb-4 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-lg"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            <button type="button" onclick="modalTarget()"
                class="bg-lp3i-100 hover:bg-lp3i-200 px-4 py-2 rounded-lg text-white text-sm">Tambah Target</button>

            <div class="py-5">
                <ul>
                    @foreach ($targets as $target)
                        <li>{{ $target->date }} - Gel. {{ $target->session }}: {{ $target->total }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @include('pages.presenter.modal.target')
</x-app-layout>

<script>
    const modalTarget = () => {
        let modal = document.getElementById('modal-target');
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }
</script>
