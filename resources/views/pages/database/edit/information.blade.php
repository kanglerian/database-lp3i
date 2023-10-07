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
                <x-input class="hidden" name="isread" value="{{ $applicant->isread }}"/>
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

                <div
                    class="grid md:grid-cols-{{ $programs == null || Auth::user()->role == 'P' ? '1' : '2' }} md:gap-6 mb-4 lg:mb-0">
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

                <div class="grid md:grid-cols-3 md:gap-6 mb-4 lg:mb-0">
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
                    <div class="relative z-0 w-full group mb-4">
                        <x-label for="c" :value="__('Keterangan Follow Up')" />
                        <x-select id="followup_id" name="followup_id">
                            @if ($applicant->followup_id)
                                <option value="{{ $applicant->followup_id }}">{{ $applicant->FollowUp->name }}
                                </option>
                            @else
                                <option value="null">Pilih keterangan</option>
                            @endif
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

                <div class="grid md:grid-cols-2 md:gap-6 mb-4 lg:mb-0">
                    <div class="relative z-0 w-full group mb-4">
                        <x-label for="known" :value="__('Mengetahui LP3I?')" />
                        <x-select id="known" name="known">
                            @if ($applicant->known != null)
                                @switch($applicant->known)
                                    @case(1)
                                        <option value="1">Ya</option>
                                    @break

                                    @case(0)
                                        <option value="0">Tidak</option>
                                    @break
                                @endswitch
                            @else
                                <option value="null">Pilih</option>
                            @endif
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('known') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group mb-4">
                        <x-label for="come" :value="__('Datang Ke Kampus?')" />
                        <x-select id="come" name="come">
                            @if ($applicant->come)
                                @switch($applicant->come)
                                    @case(1)
                                        <option value="1">Ya</option>
                                    @break

                                    @case(0)
                                        <option value="0">Tidak</option>
                                    @break
                                @endswitch
                            @else
                                <option value="null">Pilih</option>
                            @endif
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('come') }}</span>
                        </p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 md:gap-6 mb-4 lg:mb-0">
                    <div class="relative z-0 w-full group mb-4">
                        <x-label for="planning" :value="__('Rencana Setelah Lulus')" />
                        <x-select id="planning" name="planning">
                            @if ($applicant->planning != null)
                            <option value="{{$applicant->planning}}">{{$applicant->planning}}</option>
                            @else
                                <option value="null">Pilih</option>
                            @endif
                            <option value="Kuliah">Kuliah</option>
                            <option value="Kerja">Kerja</option>
                            <option value="Bisnis">Bisnis</option>
                            <option value="Nikah">Nikah</option>
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('planning') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group mb-4">
                        <x-label for="other_campus" :value="__('Pilihan Kampus Selain LP3I')" />
                        <x-input id="other_campus" type="text" name="other_campus" value="{{ $applicant->other_campus }}"
                            placeholder="Kampus Pilihan Lain" />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500">{{ $errors->first('other_campus') }}</span>
                        </p>
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
