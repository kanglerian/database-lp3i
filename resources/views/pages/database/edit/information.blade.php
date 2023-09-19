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
                <div class="grid md:grid-cols-2 md:gap-6 mb-4 md:mb-0">
                    <div class="relative z-0 w-full group mb-4">
                        <x-label for="pmb" :value="__('Tahun Akademik')" />
                        <x-input id="pmb" type="number" name="pmb" value="{{ $applicant->pmb }}"
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
                                <span class="text-red-500">{{ $errors->first('programtype_id') }}</span>
                            @else
                                <span class="text-red-500">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="grid md:grid-cols-{{ $programs == null ? '1' : '2' }} md:gap-6 mb-4 lg:mb-0">
                    @if ($programs !== null)
                        <div class="relative z-0 w-full group mb-4">
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
                        <input type="hidden" name="program" id="program" value="{{ $applicant->program }}">
                    @endif
                    @if (Auth::check() && Auth::user()->role == 'P')
                        <input type="hidden" value="{{ $applicant->identity_user }}" name="identity_user">
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
                                    <span class="text-red-500">{{ $errors->first('identity_user') }}</span>
                                @else
                                    <span class="text-red-500">*Wajib diisi.</span>
                                @endif
                            </p>
                        </div>
                    @endif
                </div>

                <div class="grid md:grid-cols-2 md:gap-6 mb-4 lg:mb-0">
                    <div class="relative z-0 w-full group mb-4">
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

                <div class="grid md:grid-cols-2 md:gap-6 mb-4 lg:mb-0">
                    <div class="relative z-0 w-full group mb-4">
                        <div class="relative z-0 w-full group">
                            <x-label for="email" :value="__('Email')" />
                            <x-input id="email" type="email" name="email" value="{{ $applicant->email }}"
                                placeholder="Email" />
                            <p class="mt-2 text-xs text-gray-500">
                                @if ($errors->has('email'))
                                    <span class="text-red-500">{{ $errors->first('email') }}</span>
                                @else
                                    <span class="text-red-500">*Wajib diisi.</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="relative z-0 w-full group">
                        <div class="relative z-0 w-full group">
                            <x-label for="phone" :value="__('No. Whatsapp')" />
                            <x-input id="phone" type="number" name="phone" value="{{ $applicant->phone }}"
                                placeholder="Tulis no. Whatsapp disini..." />
                            <p class="mt-2 text-xs text-gray-500">
                                @if ($errors->has('phone'))
                                    <span class="text-red-500">{{ $errors->first('phone') }}</span>
                                @else
                                    <span class="text-red-500">*Wajib diisi.</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid md:grid-cols-1 md:gap-6 mb-4">
                    <div class="relative z-0 w-full group">
                        <x-label for="note" :value="__('Catatan')" />
                        <x-textarea id="note" type="note" name="note" value="{{ $applicant->note }}"
                            placeholder="Catatan">
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
