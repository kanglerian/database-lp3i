@push('styles')
    <link href="{{ asset('css/select2-input.css') }}" rel="stylesheet" />
@endpush
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-3">
            <h2 class="font-bold text-xl text-gray-800 leading-tight py-2">
                {{ $applicant->name }}
            </h2>
            <div class="flex flex-col md:flex-row items-center gap-2">
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-2 border border-gray-200 px-3 py-1.5 rounded-lg">
                        <i class="fa-solid fa-map-location-dot text-gray-700"></i>
                        <span class="text-sm" id="wilayah"></span>
                    </div>
                    <div class="flex items-center gap-2 border border-gray-200 px-3 py-1.5 rounded-lg">
                        <i class="fa-solid fa-rectangle-list text-gray-700"></i>
                        <span class="text-sm">
                            @if ($programs == null)
                                <i class="fa-solid fa-wifi text-red-500"></i>
                            @else
                                <i class="fa-solid fa-wifi text-green-500"></i>
                            @endif
                        </span>
                    </div>
                </div>
                @if ($account == 0 && ($applicant->status_id == 3 || $applicant->status_id == 4))
                    <form action="{{ route('profile.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="identity" value="{{ $applicant->identity }}">
                        <input type="hidden" name="name" value="{{ $applicant->name }}">
                        <input type="hidden" name="email" value="{{ $applicant->email }}">
                        <input type="hidden" name="phone" value="{{ $applicant->phone }}">
                        <button type="submit"
                            class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2 text-center"><i
                                class="fa-solid fa-user-plus"></i> Buat Akun</button>
                    </form>
                @elseif($account > 0)
                    <span
                        class="text-white bg-green-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2 text-center"><i
                            class="fa-solid fa-circle-check"></i> Sudah Memiliki Akun</span>
                @endif
                <button onclick="saveChanges()"
                    class="text-white bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2 text-center"><i
                        class="fa-solid fa-floppy-disk mr-1"></i> Simpan perubahan</button>
            </div>
            </div?>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('error'))
                <div id="alert" class="mx-2 mb-4 flex items-center p-4 mb-4 bg-red-400 text-white rounded-lg"
                    role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('error') }}
                    </div>
                </div>
            @endif
            @if (session('message'))
                <div id="alert" class="mx-2 mb-4 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-lg"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
        </div>
        <form action="{{ route('database.update', $applicant->id) }}" method="POST" id="formChanges">
            @csrf
            @method('PATCH')
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="px-6 py-6 bg-white shadow sm:rounded-lg">
                    <div class="w-full">
                        <section>
                            <header class="flex flex-col md:flex-row md:items-center justify-between gap-5">
                                <div class="w-full md:w-auto">
                                    <h2 class="text-xl font-bold text-gray-900">
                                        Informasi Aplikan
                                    </h2>
                                    <p class="mt-1 text-sm text-gray-600">
                                        Mahasiswa orangtua/wali mahasiswa Politeknik LP3I Kampus Tasikmalaya.
                                    </p>
                                </div>
                            </header>
                            <hr class="mt-2 mb-8">
                            <section>
                                <div class="grid md:grid-cols-2 md:gap-6 mb-5">
                                    <div class="relative z-0 w-full group">
                                        <x-label for="pmb" :value="__('Tahun Akademik')" />
                                        <x-input id="pmb" type="number" name="pmb"
                                            value="{{ $applicant->pmb }}" placeholder="Tahun Akademik" required />
                                        <p class="mt-2 text-xs text-gray-500">
                                            @if ($errors->has('pmb'))
                                                <span class="text-red-500">{{ $errors->first('pmb') }}</span>
                                            @else
                                                <span class="text-red-500">*Wajib diisi.</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="relative z-0 w-full group">
                                        <x-label for="programtype_id" :value="__('Program Kuliah')" />
                                        <x-select id="programtype_id" name="programtype_id" required>
                                            @if ($applicant->programtype_id !== null)
                                                <option value="{{ $applicant->programtype_id }}" selected>
                                                    {{ $applicant->programType->name }}
                                                </option>
                                            @endif
                                            @foreach ($programtypes as $programtype)
                                                <option value="{{ $programtype->id }}">
                                                    {{ $programtype->name }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                        <p class="mt-2 text-xs text-gray-500">
                                            @if ($errors->has('programtype_id'))
                                                <span
                                                    class="text-red-500">{{ $errors->first('programtype_id') }}</span>
                                            @else
                                                <span class="text-red-500">*Wajib diisi.</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-{{ $programs == null ? '1' : '2' }} md:gap-6 mb-5">
                                    @if ($programs !== null)
                                        <div class="relative z-0 w-full group">
                                            <x-label for="program" :value="__('Program')" />
                                            <x-select id="program" name="program" required>
                                                @if ($applicant->program == null)
                                                    <option value="Pilih program">Pilih program</option>
                                                    <option value="Belum diketahui">Belum diketahui</option>
                                                    @foreach ($programs as $prog)
                                                        <option value="{{ $prog['level'] }} {{ $prog['title'] }}">
                                                            {{ $prog['level'] }} {{ $prog['title'] }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="{{ $applicant->program }}">
                                                        {{ $applicant->program }}
                                                    </option>
                                                    @foreach ($programs as $prog)
                                                        <option value="{{ $prog['level'] }} {{ $prog['title'] }}">
                                                            {{ $prog['level'] }} {{ $prog['title'] }}</option>
                                                    @endforeach
                                                @endif
                                            </x-select>
                                            <p class="mt-2 text-xs text-gray-500">
                                                @if ($errors->has('program'))
                                                    <span class="text-red-500">{{ $errors->first('program') }}</span>
                                                @else
                                                    <span class="text-red-500">*Wajib diisi.</span>
                                                @endif
                                            </p>
                                        </div>
                                    @else
                                        <input type="hidden" name="program" id="program"
                                            value="{{ $applicant->program }}">
                                    @endif
                                    @if (Auth::check() && Auth::user()->role == 'P')
                                        <input type="hidden" value="{{ $applicant->identity_user }}"
                                            name="identity_user">
                                    @else
                                        <div class="relative z-0 w-full group">
                                            <x-label for="identity_user" :value="__('Presenter')" />
                                            <x-select id="identity_user" name="identity_user" required>
                                                @if ($applicant->identity_user == null)
                                                    <option value="Pilih presenter">Pilih presenter</option>
                                                    @foreach ($presenters as $presenter)
                                                        <option value="{{ $presenter->identity }}">
                                                            {{ $presenter->name }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="{{ $applicant->identity_user }}">
                                                        {{ $applicant->presenter->name }}
                                                    </option>
                                                    @foreach ($presenters as $presenter)
                                                        <option value="{{ $presenter->identity }}">
                                                            {{ $presenter->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </x-select>
                                            <p class="mt-2 text-xs text-gray-500">
                                                @if ($errors->has('identity_user'))
                                                    {{ $errors->first('identity_user') }}
                                                @endif
                                                @if ($applicant->identity_user == null)
                                                    <span class="text-red-500">*Wajib diisi.</span>
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                </div>

                                <div class="grid md:grid-cols-2 md:gap-6 mb-5">
                                    <div class="relative z-0 w-full group">
                                        <x-label for="source_id" :value="__('Sumber')" />
                                        <x-select id="source_id" name="source_id" required>
                                            <option value="{{ $applicant->source_id }}" selected>
                                                {{ $applicant->sourceSetting->name }}
                                            </option>
                                            @foreach ($sources as $source)
                                                <option value="{{ $source->id }}">
                                                    {{ $source->name }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                        <p class="mt-2 text-xs text-gray-500">
                                            @if ($errors->has('source_id'))
                                                <span class="text-red-500">{{ $errors->first('source_id') }}</span>
                                            @else
                                                <span class="text-red-500">*Wajib diisi.</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="relative z-0 w-full group">
                                        <x-label for="status_id" :value="__('Status')" />
                                        <x-select id="status_id" name="status_id" required>
                                            <option value="{{ $applicant->status_id }}" selected>
                                                {{ $applicant->applicantStatus->name }}
                                            </option>
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status->id }}">
                                                    {{ $status->name }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                        <p class="mt-2 text-xs text-gray-500">
                                            @if ($errors->has('status_id'))
                                                <span class="text-red-500">{{ $errors->first('status_id') }}</span>
                                            @else
                                                <span class="text-red-500">*Wajib diisi.</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-2 md:gap-6">
                                    <div class="relative z-0 w-full mb-6 group">
                                        <div class="relative z-0 w-full group">
                                            <x-label for="email" :value="__('Email')" />
                                            <x-input id="email" type="email" name="email"
                                                value="{{ $applicant->email }}" placeholder="Email" />
                                            <p class="mt-2 text-xs text-gray-500">
                                                <span class="text-red-500">{{ $errors->first('email') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="relative z-0 w-full mb-6 group">
                                        <div class="relative z-0 w-full group">
                                            <x-label for="phone" :value="__('No. Whatsapp')" />
                                            <x-input id="phone" type="number" name="phone"
                                                value="{{ $applicant->phone }}"
                                                placeholder="Tulis no. Whatsapp disini..." />
                                            <p class="mt-2 text-xs text-gray-500">
                                                <span class="text-red-500">{{ $errors->first('phone') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-1 md:gap-6">
                                    <div class="relative z-0 w-full group">
                                        <x-label for="note" :value="__('Catatan')" />
                                        <x-textarea id="note" type="note" name="note"
                                            value="{{ $applicant->note }}" placeholder="Catatan">
                                            {{ $applicant->note }}
                                        </x-textarea>
                                        <p class="mt-2 text-xs text-gray-500">
                                            <span class="text-red-500">{{ $errors->first('note') }}</span>
                                        </p>
                                    </div>
                                </div>

                            </section>
                        </section>
                    </div>
                </div>
                
                @include('database.edit.biodata')

                <div class="flex flex-col md:flex-row items-start gap-5">
                    @include('database.edit.father')
                    @include('database.edit.mother')
                </div>

            </div>
        </form>
    </div>
</x-app-layout>
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.js-example-input-single').select2();
        });

        let phoneInput = document.getElementById('phone');
        phoneInput.addEventListener('input', function() {
            let phone = phoneInput.value;
            if (phone.startsWith('62')) {
            } else if (phone.startsWith('0')) {
                phoneInput.value = '62' + phone.substring(1);
            } else {
                phoneInput.value = '62';
            }
        });

        const saveChanges = () => {
            const form = document.getElementById('formChanges');
            form.submit();
        }
    </script>
@endpush