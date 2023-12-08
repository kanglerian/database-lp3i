<div class="p-6 bg-white shadow-sm sm:rounded-lg">
    <div class="w-full">
        <section>
            <header class="flex flex-col md:flex-row md:items-center justify-between">
                <div class="w-full md:w-auto">
                    <h2 class="text-xl font-bold text-gray-900">
                        Informasi Aplikan
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Mahasiswa orangtua/wali mahasiswa Politeknik LP3I Kampus Tasikmalaya.
                    </p>
                </div>
            </header>
            <hr class="my-3">
            <section>
                <div class="grid md:grid-cols-2 gap-3 mb-3">
                    <div class="relative z-0 w-full group">
                        <x-label for="pmb" :value="__('Tahun Akademik')" />
                        <x-input id="pmb" type="number" name="pmb" :value="old('pmb')"
                            placeholder="Tahun Akademik" required />
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
                            <option value="0">Pilih program</option>
                            @forelse ($programtypes as $programtype)
                                <option value="{{ $programtype->id }}">{{ $programtype->name }}</option>
                            @empty
                                <option value="Reguler Pagi">Reguler Pagi</option>
                            @endforelse
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('programtype_id'))
                                <span class="text-red-500">{{ $errors->first('programtype_id') }}</span>
                            @else
                                <span class="text-red-500">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-3 mb-3">
                    <div class="relative z-0 w-full group">
                        <x-label for="program" :value="__('Program Studi 1')" />
                        <x-select id="program" name="program" required>
                            <option>Pilih program</option>
                            @if ($programs == null)
                                <option value="Belum diketahui">Belum diketahui</option>
                            @else
                                <option value="Belum diketahui">Belum diketahui</option>
                                @foreach ($programs as $prog)
                                    <option value="{{ $prog['level'] }} {{ $prog['title'] }}">
                                        {{ $prog['level'] }}
                                        {{ $prog['title'] }}</option>
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
                    <div class="relative z-0 w-full group">
                        <x-label for="program_second" :value="__('Program Studi 2')" />
                        <x-select id="program_second" name="program_second" required>
                            <option>Pilih program</option>
                            @if ($programs == null)
                                <option value="Belum diketahui">Belum diketahui</option>
                            @else
                                <option value="Belum diketahui">Belum diketahui</option>
                                @foreach ($programs as $prog)
                                    <option value="{{ $prog['level'] }} {{ $prog['title'] }}">
                                        {{ $prog['level'] }}
                                        {{ $prog['title'] }}</option>
                                @endforeach
                            @endif
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('program_second'))
                                <span class="text-red-500">{{ $errors->first('program_second') }}</span>
                            @else
                                <span class="text-red-500">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-3 mb-3">
                    @if (Auth::check() && Auth::user()->role == 'P')
                        <input type="hidden" value="{{ Auth::user()->identity }}" name="identity_user">
                    @else
                        <div class="relative z-0 w-full group">
                            <x-label for="identity_user" :value="__('Presenter')" />
                            <x-select id="identity_user" name="identity_user" required>
                                <option value="0">Pilih presenter</option>
                                @foreach ($users as $presenter)
                                    <option value="{{ $presenter->identity }}">{{ $presenter->name }}
                                    </option>
                                @endforeach
                            </x-select>
                            <p class="mt-2 text-xs text-gray-500">
                                @if ($errors->has('identity_user'))
                                    <span class="text-red-500">{{ $errors->first('identity_user') }}</span>
                                @else
                                    <span class="text-red-500">*Wajib diisi.</span>
                                @endif
                            </p>
                        </div>
                    @endif
                    <div class="relative z-0 w-full group">
                        <x-label for="source_id" :value="__('Sumber')" />
                        <x-select id="source_id" name="source_id" required>
                            <option value="0">Pilih sumber</option>
                            @if (sizeof($sources) > 0)
                                @foreach ($sources as $source)
                                    <option value="{{ $source->id }}">{{ $source->name }}</option>
                                @endforeach
                            @endif
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('source_id'))
                                <span class="text-red-500">{{ $errors->first('source_id') }}</span>
                            @else
                                <span class="text-red-500">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-3 mb-3">
                    <div class="relative z-0 w-full group">
                        <x-label for="followup_id" :value="__('Keterangan Follow Up')" />
                        <x-select id="followup_id" name="followup_id" required>
                            <option value="null">Pilih keterangan</option>
                            @foreach ($follows as $follow)
                                <option value="{{ $follow->id }}">{{ $follow->name }}</option>
                            @endforeach
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('followup_id'))
                                <span class="text-red-500">{{ $errors->first('followup_id') }}</span>
                            @else
                                <span class="text-red-500">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="status_id" :value="__('Status')" />
                        <x-select id="status_id" name="status_id" required>
                            <option value="0">Pilih status</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}">{{ $status->name }}</option>
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

                <div class="grid md:grid-cols-1 md:gap-6">
                    <div class="relative z-0 w-full group">
                        <x-label for="note" :value="__('Catatan')" />
                        <x-textarea id="note" type="note" name="note" value="{{ old('note') }}"
                            placeholder="Catatan">
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
@push('scripts')
    <script src="{{ asset('js/api-notif.js') }}"></script>
    <script>
        const getYearPMB = () => {
            const currentDate = new Date();
            const currentYear = currentDate.getFullYear();
            const currentMonth = currentDate.getMonth();
            const startYear = currentMonth >= 9 ? currentYear + 1 : currentYear;
            document.getElementById('pmb').value = startYear;
        }
        getYearPMB();
    </script>
@endpush
