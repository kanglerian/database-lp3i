@push('styles')
    <link href="{{ asset('css/select2-input.css') }}" rel="stylesheet" />
@endpush
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 pb-3">
            <nav class="flex">
                <ol class="inline-flex items-center space-x-2 md:space-x-3">
                    <li class="inline-flex items-center">
                        @if (Auth::user()->role == 'S')
                            <a href="{{ route('dashboard.index') }}"
                                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">
                                <i class="fa-solid fa-compass mr-2"></i>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('user.index') }}"
                                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">
                                <i class="fa-solid fa-users mr-2"></i>
                                Akun
                            </a>
                        @endif
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Ubah Profil</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>
    <div class="py-10">
        <div class="max-w-7xl mx-auto px-5 md:p-0">
            @if (session('message'))
                <div id="alert" class="mx-2 mb-4 flex items-center p-4 bg-emerald-500 text-emerald-50 rounded-2xl"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-reguler">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            <div class="flex flex-col md:flex-row justify-start gap-5 p-4 md:p-0">
                @if ($user->role == 'S')
                    <div class="w-full md:w-2/3 flex flex-col gap-5">
                        <div class="w-full bg-gray-50 border border-gray-200 p-8 space-y-2 rounded-3xl">
                            <header>
                                <h2 class="text-xl font-bold text-gray-900">
                                    Program Studi
                                </h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    Ini adalah program studi yang dipilih:
                                </p>
                            </header>
                            <ul class="text-sm text-gray-800 space-y-1 list-disc ml-4">
                                <li>Tipe: <span class="underline font-bold">{{ $applicant->programType->name }}</span>
                                </li>
                                <li>Prodi 1: <span
                                        class="underline font-bold">{{ $applicant->program ?? 'Belum diketahui' }}</span>
                                </li>
                                <li>Prodi 2: <span
                                        class="underline font-bold">{{ $applicant->program_second ?? 'Belum diketahui' }}</span>
                                </li>
                            </ul>
                            <hr>
                            <p class="text-xs text-gray-700">Catatan: untuk mengubah program studi silahkan hubungi <a
                                    href="https://wa.me/{{ $applicant->presenter->phone }}">{{ $applicant->presenter->name }}</a>
                            </p>
                        </div>
                        <form action="{{ route('profile.update', $user->id) }}" class="flex flex-col items-start gap-5"
                            method="POST">
                            @csrf
                            @method('PATCH')
                            {{-- Biodata Aplikan --}}
                            @include('pages.database.edit.biodata')
                            @include('pages.database.edit.father')
                            @include('pages.database.edit.mother')

                            <button type="submit"
                                class="text-white bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm w-1/3 sm:w-auto px-5 py-2 text-center"><i
                                    class="fa-solid fa-floppy-disk mr-1"></i> Simpan perubahan</button>
                        </form>
                    </div>
                @endif
                <div class="w-full md:w-1/3 flex flex-col gap-5">
                    <form method="POST" class="p-8 bg-gray-50 border border-gray-200 rounded-3xl"
                        action="{{ route('profile.update_account', $user->id) }}">
                        @csrf
                        @method('PATCH')
                        <div>
                            <div>
                                <div class="relative z-0 w-full mb-6 group">
                                    <input type="text" name="name" maxlength="50" id="nameuser"
                                        value="{{ $user->name }}"
                                        class="@error('name') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" " required />
                                    <div class="text-sm text-gray-700 mt-3">
                                        {{ $errors->first('name') }}
                                    </div>
                                    <label for="name"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama
                                        lengkap</label>
                                </div>

                                @if ($user->role == 'P')
                                    <div class="relative z-0 w-full mb-6 group">
                                        <input type="text" name="code" maxlength="6" id="code"
                                            value="{{ $user->code }}"
                                            class="@error('code') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('code') }}
                                        </div>
                                        <label for="code"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Code
                                            Presenter (MisilV4)</label>
                                    </div>
                                @endif

                                <div class="relative z-0 w-full mb-6 group">
                                    <input type="number" name="phone" maxlength="14" id="phone"
                                        value="{{ $user->phone }}"
                                        class="@error('phone') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" " required />
                                    <div class="text-sm text-gray-700 mt-3">
                                        {{ $errors->first('phone') }}
                                    </div>
                                    <label for="phone"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">No.
                                        Telpon (Whatsapp)</label>
                                </div>

                                <div class="relative z-0 w-full mb-6 group">
                                    <input type="email" name="email" maxlength="50" id="email"
                                        value="{{ $user->email }}"
                                        class="@error('email') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" " required />
                                    <div class="text-sm text-gray-700 mt-3">
                                        {{ $errors->first('email') }}
                                    </div>
                                    <label for="email"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email</label>
                                </div>
                            </div>
                        </div>
                        <button type="submit"
                            class="text-white bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm w-full sm:w-auto px-5 py-2 text-center"><i
                                class="fa-solid fa-floppy-disk mr-1"></i> Simpan Perubahan</button>
                    </form>

                    <form method="POST" class="p-8 bg-gray-50 border border-gray-200 rounded-3xl"
                        action="{{ route('profile.change_password', $user->id) }}">
                        @csrf
                        @method('PATCH')
                        <div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="password" name="password" id="password"
                                    class="@error('password') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required />
                                <div class="text-sm text-gray-700 mt-3">
                                    {{ $errors->first('password') }}
                                </div>
                                <label for="password"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password
                                    Baru</label>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="@error('password_confirmation') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required />
                                <div class="text-sm text-gray-700 mt-3">
                                    {{ $errors->first('password_confirmation') }}
                                </div>
                                <label for="password_confirmation"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Konfirmasi
                                    Password</label>
                            </div>
                        </div>
                        <button type="submit"
                            class="text-white bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm w-full sm:w-auto px-5 py-2 text-center"><i
                                class="fa-solid fa-floppy-disk mr-1"></i> Ubah Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="{{ asset('js/indonesia.js') }}"></script>
<script src="{{ asset('js/indonesia-father.js') }}"></script>
<script src="{{ asset('js/indonesia-mother.js') }}"></script>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.js-example-input-single').select2({
                tags: true,
            });
        });
    </script>
@endpush
