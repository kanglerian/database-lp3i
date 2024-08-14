<x-app-layout>
    @push('styles')
        <style>
            .js-example-input-single {
                display: flex;
                width: 100% !important;
            }

            .select2-selection {
                font-size: 12px !important;
                border-radius: 0.75rem !important;
                padding-top: 18px !important;
                padding-bottom: 18px !important;
                background: #ffffff !important;
                border: 1px solid #d1d5db !important;
            }

            .select2-results__option {
                font-size: 12px !important;
            }

            .select2-selection__rendered {
                position: absolute;
                top: 5px !important;
                font-size: 12px !important;
                left: 5px !important;
            }

            .select2-selection__arrow {
                position: absolute;
                top: 6px !important;
                right: 5px !important;
            }
        </style>
    @endpush
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 pb-3">
            <nav class="flex">
                <ol class="inline-flex items-center space-x-2 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('recommendation.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">
                            <i class="fa-solid fa-database mr-2"></i>
                            Data Rekomendasi
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Detail Data
                                [{{ $data->name }}]</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-5 md:p-0 space-y-5">
            @if (session('message'))
                <div id="alert" class="flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-xl"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-reguler">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div id="alert" class="flex items-center p-4 mb-4 bg-red-500 text-red-50 rounded-xl" role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <section>
                <form method="POST" action="{{ route('recommendation.update_admin', $data->id) }}"
                    class="w-full flex flex-col items-start gap-5">
                    @csrf
                    @method('PATCH')
                    <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama
                                lengkap</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $data->name) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5"
                                placeholder="Nama lengkap" required />
                            @if ($errors->has('name'))
                                <span class="ml-2 mt-2 text-red-500 text-xs">{{ $errors->first('name') }}</span>
                            @else
                                <span class="ml-2 mt-2 text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </div>
                        <div>
                            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">No.
                                Telpon</label>
                            <input type="number" id="phone" name="phone" value="{{ old('phone', $data->phone) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5"
                                placeholder="No. Telpon" required />
                            @if ($errors->has('phone'))
                                <span class="ml-2 mt-2 text-red-500 text-xs">{{ $errors->first('phone') }}</span>
                            @else
                                <span class="ml-2 mt-2 text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </div>
                        <div>
                            <label for="school_id" class="block mb-2 text-sm font-medium text-gray-900">Sekolah</label>
                            <select id="school_id" name="school_id" style="width: 100%"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 js-example-input-single"
                                required>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('school_id'))
                                <span class="ml-2 mt-2 text-red-500 text-xs">{{ $errors->first('school_id') }}</span>
                            @else
                                <span class="ml-2 mt-2 text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </div>
                        <div>
                            <label for="class" class="block mb-2 text-sm font-medium text-gray-900">Kelas</label>
                            <input type="text" id="class" name="class"
                                value="{{ old('class', $data->class) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5"
                                placeholder="Kelas" required />
                            @if ($errors->has('class'))
                                <span class="ml-2 mt-2 text-red-500 text-xs">{{ $errors->first('class') }}</span>
                            @else
                                <span class="ml-2 mt-2 text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </div>
                        <div>
                            <label for="year" class="block mb-2 text-sm font-medium text-gray-900">Tahun
                                lulus</label>
                            <input type="number" id="year" name="year" value="{{ old('year', $data->year) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5"
                                placeholder="Tahun lulus" required />
                            @if ($errors->has('year'))
                                <span class="ml-2 mt-2 text-red-500 text-xs">{{ $errors->first('year') }}</span>
                            @else
                                <span class="ml-2 mt-2 text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </div>
                        <div>
                            <label for="plan" class="block mb-2 text-sm font-medium text-gray-900">Rencana Setelah
                                Lulus</label>
                            <select id="plan" name="plan" value="{{ old('plan', $data->plan) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5">
                                <option value="{{ $data->plan }}">{{ $data->plan ?? 'Pilih' }}
                                </option>
                                <option value="Belum diketahui">Belum diketahui</option>
                                <option value="Kuliah">Kuliah</option>
                                <option value="Kerja">Kerja</option>
                                <option value="Wirausaha">Wirausaha</option>
                            </select>
                            @if ($errors->has('plant'))
                                <p class="mt-2 text-red-500 text-xs">{{ $errors->first('plant') }}</p>
                            @endif
                        </div>
                        <div>
                            <label for="parent_phone" class="block mb-2 text-sm font-medium text-gray-900">No. Telpon
                                Orang Tua</label>
                            <input type="number" id="parent_phone" name="parent_phone"
                                value="{{ old('parent_phone', $data->parent_phone) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5"
                                placeholder="No. Telpon orang tua" />
                            @if ($errors->has('parent_phone'))
                                <p class="ml-2 mt-2 text-red-500 text-xs">{{ $errors->first('parent_phone') }}</p>
                            @endif
                        </div>
                        <div>
                            <label for="parent_job" class="block mb-2 text-sm font-medium text-gray-900">Pekerjaan Orang
                                Tua</label>
                            <input type="text" id="parent_job" name="parent_job"
                                value="{{ old('parent_job', $data->parent_job) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5"
                                placeholder="Pekerjaan orang tua" />
                            @if ($errors->has('parent_job'))
                                <p class="ml-2 mt-2 text-red-500 text-xs">{{ $errors->first('parent_job') }}</p>
                            @endif
                        </div>
                        <div>
                            <label for="income_parent" class="block mb-2 text-sm font-medium text-gray-900">Pendapatan
                                Orangtua</label>
                            <select id="income_parent" name="income_parent"
                                value="{{ old('income_parent', $data->income_parent) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2.5"
                                required>
                                <option value="{{ $data->income_parent }}">{{ $data->income_parent ?? 'Pilih' }}
                                </option>
                                <option value="Belum diketahui">Belum diketahui</option>
                                <option value="< 1.000.000">< 1.000.000</option>
                                <option value="1.000.000 - 2.000.000">1.000.000 - 2.000.000</option>
                                <option value="2.000.000 - 4.000.000">2.000.000 - 4.000.000</option>
                                <option value="> 5.000.000">> 5.000.000</option>
                            </select>
                            @if ($errors->has('income_parent'))
                                <p class="ml-2 mt-2 text-red-500 text-xs">{{ $errors->first('income_parent') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="w-full grid grid-cols-1">
                        <div>
                            <label for="address" class="block mb-2 text-sm font-medium text-gray-900">Alamat</label>
                            <textarea id="address" name="address" rows="4" value="{{ old('address', $data->address) }}"
                                class="block px-4 py-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-xl border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Alamat">{{ old('address', $data->address) }}</textarea>
                            @if ($errors->has('address'))
                                <p class="ml-2 mt-2 text-red-500 text-xs">{{ $errors->first('address') }}</p>
                            @endif
                        </div>
                    </div>
                    <button type="submit"
                        class="text-white bg-lp3i-200 hover:bg-lp3i-300 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5"><i
                            class="fa-solid fa-floppy-disk mr-1"></i> Simpan Perubahan</button>
                </form>
            </section>
        </div>

    </div>
</x-app-layout>
