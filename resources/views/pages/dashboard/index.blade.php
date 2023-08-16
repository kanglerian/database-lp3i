<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight py-2">
                @if (Auth::user()->role == 'S' && Auth::user()->status == 0)
                    Registrasi Pembayaran
                @else
                    Dashboard
                @endif
            </h2>
            @if (Auth::user()->status != 1)
                <div class="px-6 py-2 rounded-lg bg-red-500 text-white text-sm">
                    <p><i class="fa-solid fa-lock mr-1"></i> Akun anda belum di aktifkan.</p>
                </div>
            @else
                <div class="px-6 py-2 rounded-lg text-sm bg-white">
                    <p><i class="fa-regular fa-face-smile-beam mr-1"></i> Selamat datang,
                        {{ Auth::user()->name }}
                    </p>
                </div>
            @endif
        </div>
    </x-slot>

    @if (Auth::user()->role == 'S' && Auth::user()->status == 0)
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-5 px-5 md:px-0">
                <div class="w-full md:w-6/12 space-y-5 order-2 md:order-none">
                    <div class="space-y-1">
                        <h3 class="text-2xl font-bold text-gray-800">Silahkan untuk lakukan Transfer!</h3>
                        <p class="text-gray-700">Isi formulir pendaftaran dan raih kesempatan yang luar biasa di depan mata.</p>
                    </div>
                    <div class="flex flex-wrap items-end">
                        <div class="w-1/2 md:w-1/3 space-y-3 p-4">
                            <img src="{{ asset('logo/btn.png') }}" alt="">
                            <div class="flex justify-between items-center border px-3 py-1 rounded-lg">
                                <div>
                                    <h1 class="font-bold text-gray-800">BANK BTN</h1>
                                    <p class="text-sm text-gray-700">32902384902</p>
                                </div>
                                <button class="" onclick="alert('Copy to clipboard!')"><i
                                        class="fa-solid fa-clipboard text-gray-500 hover:text-blue-500"></i></button>
                            </div>
                        </div>
                        <div class="w-1/2 md:w-1/3 space-y-3 p-4">
                            <img src="{{ asset('logo/bni.png') }}" alt="">
                            <div class="flex justify-between items-center border px-3 py-1 rounded-lg">
                                <div>
                                    <h1 class="font-bold text-gray-800">BANK BNI</h1>
                                    <p class="text-sm text-gray-700">32902384902</p>
                                </div>
                                <button class="" onclick="alert('Copy to clipboard!')"><i
                                        class="fa-solid fa-clipboard text-gray-500 hover:text-blue-500"></i></button>
                            </div>
                        </div>
                        <div class="w-1/2 md:w-1/3 space-y-3 p-4">
                            <img src="{{ asset('logo/bsi.png') }}" alt="">
                            <div class="flex justify-between items-center border px-3 py-1 rounded-lg">
                                <div>
                                    <h1 class="font-bold text-gray-800">BANK BSI</h1>
                                    <p class="text-sm text-gray-700">32902384902</p>
                                </div>
                                <button class="" onclick="alert('Copy to clipboard!')"><i
                                        class="fa-solid fa-clipboard text-gray-500 hover:text-blue-500"></i></button>
                            </div>
                        </div>
                    </div>
                    <div>
                        @if (session('error'))
                            <div id="alert"
                                class="mx-2 mb-4 flex items-center p-4 mb-4 bg-red-500 text-white rounded-lg"
                                role="alert">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <div class="ml-3 text-sm font-medium">
                                    {{ session('error') }}
                                </div>
                            </div>
                        @endif
                        @if (session('message'))
                            <div id="alert"
                                class="mx-2 mb-4 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-lg"
                                role="alert">
                                <i class="fa-solid fa-circle-check"></i>
                                <div class="ml-3 text-sm font-medium">
                                    {{ session('message') }}
                                </div>
                            </div>
                        @endif
                        @if ($errors->first('berkas'))
                            <div id="alert"
                                class="mx-2 mb-4 flex items-center p-4 mb-4 bg-red-500 text-white rounded-lg"
                                role="alert">
                                <i class="fa-solid fa-circle-xmark"></i>
                                <div class="ml-3 text-sm font-medium">
                                    {{ $errors->first('berkas') }}
                                </div>
                            </div>
                        @endif
                        @forelse ($userupload as $suc)
                            <div class="flex items-center gap-2">
                                <button class="inline-block bg-green-500 hover:bg-green-600 px-3 py-1 rounded-md text-sm text-white">Bukti pembayaran sudah di unggah <i class="fa-solid fa-circle-check"></i></button>
                            </div>
                        @empty
                            @foreach ($fileupload as $upload)
                                <div class="flex items-center gap-5">
                                    <h2 class="font-bold text-gray-800">Upload Bukti Pembayaran:</h2>
                                    <form action="{{ route('upload.payment') }}" enctype="multipart/form-data"
                                        class="flex gap-2 items-center" method="POST">
                                        @csrf
                                        <div>
                                            <input type="hidden" name="name" value="{{ $upload->name }}">
                                            <input type="hidden" name="namefile" value="{{ $upload->namefile }}">
                                            <input type="file" name="berkas" id="berkas" class="text-sm"
                                                accept="{{ $upload->accept }}" style="width:95px">
                                            <button type="submit"
                                                class="inline-block bg-sky-500 hover:bg-sky-600 px-3 py-1 rounded-md text-xs text-white">
                                                <i class="fa-solid fa-upload"></i>
                                            </button>
                                        </div>
                                        <small>Maks: 1MB</small>
                                    </form>
                                </div>
                            @endforeach
                        @endforelse
                    </div>
                </div>
                <div class="w-full md:w-5/12 order-1 md:order-none">
                    <img src="{{ asset('img/payment.svg') }}" alt="">
                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>
