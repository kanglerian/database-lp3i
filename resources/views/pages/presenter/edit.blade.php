<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight py-2">
            {{ __('Edit Database') }}
        </h2>
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
            <div class="flex flex-col md:flex-row justify-center gap-5 p-4 md:p-0">
                <div class="w-full md:w-2/3 p-6 bg-white border-b border-gray-200 rounded-xl">
                    <form method="POST" action="{{ route('presenter.update', $presenter->id) }}">
                        @csrf
                        @method('PATCH')
                        <div>
                            <div>

                                <div class="relative z-0 w-full mb-6 group">
                                    <input type="text" name="name" id="name" value="{{ $presenter->name }}"
                                        class="@error('name') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" " required />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('name') }}
                                        </div>
                                    <label for="name"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama
                                        lengkap</label>
                                </div>

                                <div class="relative z-0 w-full mb-6 group">
                                    <input type="number" name="phone" id="phone" value="{{ $presenter->phone }}"
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
                                    <input type="email" name="email" id="email" value="{{ $presenter->email }}"
                                        class="@error('email') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" " required />
                                        <div class="text-sm text-gray-700 mt-3">
                                            {{ $errors->first('email') }}
                                        </div>
                                    <label for="email"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email</label>
                                </div>

                                <div class="relative z-0 w-full mb-6 group">
                                    <label for="status" class="sr-only">Status</label>
                                    <select id="status" name="status"
                                    class="@error('status') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                                    required>
                                    @switch($presenter->status)
                                        @case("0")
                                            <option value="0">Tidak aktif</option>
                                            <option value="1">Aktif</option>
                                        @break
                                        @case("1")
                                            <option value="1">Aktif</option>
                                            <option value="0">Tidak aktif</option>
                                        @break
                                    @endswitch
                                </select>
                                <div class="text-sm text-gray-700 mt-3">
                                    {{ $errors->first('status') }}
                                </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit"
                            class="text-white bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2 text-center"><i
                                class="fa-solid fa-floppy-disk mr-1"></i> Simpan Perubahan</button>
                    </form>
                </div>
                <div class="w-full md:w-1/3 p-6 bg-white border-b border-gray-200 rounded-xl">
                    <form method="POST" action="{{ route('presenter.password', $presenter->id) }}">
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
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password Baru</label>
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
                            class="text-white bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2 text-center"><i
                                class="fa-solid fa-floppy-disk mr-1"></i> Ubah Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>