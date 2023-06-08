<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
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
            <div class="bg-white overflow-hidden border md:rounded-xl">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('database.update', $applicant->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="name" id="name" value="{{ $applicant->name }}"
                                class="@error('name') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required />
                            {{ $errors->first('name') }}</small>
                            <label for="name"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama
                                lengkap</label>
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="number" name="phone" id="phone" value="{{ $applicant->phone }}"
                                class="@error('phone') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required />
                            {{ $errors->first('phone') }}</small>
                            <label for="phone"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">No.
                                Telpon (Whatsapp)</label>
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="school" id="school" value="{{ $applicant->school }}"
                                    class="@error('school') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required />
                                {{ $errors->first('school') }}</small>
                                <label for="school"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Asal
                                    sekolah</label>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="number" min="1945" max="3000" name="year" id="year"
                                    value="{{ $applicant->year }}"
                                    class="@error('year') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required />
                                {{ $errors->first('year') }}</small>
                                <label for="year"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tahun
                                    lulus</label>
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="source" class="sr-only">source</label>
                                <select id="source" name="source"
                                    class="@error('source') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                    @switch($applicant->source)
                                        @case(null)
                                            <option>Pilih sumber</option>
                                        @break

                                        @case(1)
                                            <option value="{{ $applicant->source }}">Website</option>
                                        @break

                                        @case(2)
                                            <option value="{{ $applicant->source }}">Presenter</option>
                                        @break
                                    @endswitch
                                    <option value="1">Tidak diketahui</option>
                                    <option value="2">Potensi</option>
                                    <option value="3">Daftar</option>
                                    <option value="4">Registrasi</option>
                                    <option value="5">Batal</option>
                                </select>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="status" class="sr-only">Status</label>
                                <select id="status" name="status"
                                    class="@error('status') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                    @switch($applicant->status)
                                        @case(null)
                                            <option>Pilih status</option>
                                        @break

                                        @case(1)
                                            <option value="{{ $applicant->status }}">Tidak diketahui</option>
                                        @break

                                        @case(2)
                                            <option value="{{ $applicant->status }}">Potensi</option>
                                        @break

                                        @case(3)
                                            <option value="{{ $applicant->status }}">Daftar</option>
                                        @break

                                        @case(4)
                                            <option value="{{ $applicant->status }}">Registrasi</option>
                                        @break

                                        @case(5)
                                            <option value="{{ $applicant->status }}">Batal</option>
                                        @break
                                    @endswitch
                                    <option value="1">Tidak diketahui</option>
                                    <option value="2">Potensi</option>
                                    <option value="3">Daftar</option>
                                    <option value="4">Registrasi</option>
                                    <option value="5">Batal</option>
                                </select>
                                {{ $errors->first('status') }}</small>
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="program" class="sr-only">Program</label>
                                <select id="program" name="program"
                                    class="@error('program') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                    @switch($applicant->program)
                                        @case(null)
                                            <option>Pilih program</option>
                                        @break

                                        @case(1)
                                            <option value="{{ $applicant->program }}">Manajemen Keuangan Perbankan</option>
                                        @break

                                        @case(2)
                                            <option value="{{ $applicant->program }}">Manajemen Pemasaran</option>
                                        @break
                                    @endswitch
                                    @foreach ($programs as $prog)
                                        <option value="{{ $prog['level'] }} {{ $prog['title'] }}">
                                            {{ $prog['level'] }} {{ $prog['title'] }}</option>
                                    @endforeach
                                </select>
                                {{ $errors->first('program') }}</small>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="presenter" class="sr-only">Presenter</label>
                                <select id="presenter" name="presenter"
                                    class="@error('presenter') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                    @switch($applicant->presenter)
                                        @case(null)
                                            <option>Pilih presenter</option>
                                        @break

                                        @case(1)
                                            <option value="{{ $applicant->presenter }}">Nurul Ahyar</option>
                                        @break

                                        @case(2)
                                            <option value="{{ $applicant->presenter }}">Harlip</option>
                                        @break
                                    @endswitch
                                    <option value="0">Nurul Ahyar</option>
                                    <option value="1">Harlip</option>
                                </select>
                                {{ $errors->first('presenter') }}</small>
                            </div>
                        </div>
                        <button type="submit"
                            class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2 text-center"><i
                                class="fa-solid fa-floppy-disk mr-1"></i> Simpan perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
