<x-app-layout>
    @push('styles')
    <link href="{{ asset('css/select2-input.css') }}" rel="stylesheet" />
    <style>
        .js-example-input-single {
            width: 100%;
        }

        .select2-selection {
            border-radius: 0.75rem !important;
            padding-top: 22px !important;
            padding-bottom: 22px !important;
        }

        .select2-selection__rendered {
            top: -13px !important;
        }
    </style>
@endpush
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 pb-3">
            <nav class="flex">
                <ol class="inline-flex items-center space-x-2 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('schools.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">
                            <i class="fa-solid fa-school mr-2"></i>
                            Sekolah
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Detail sekolah</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

    </x-slot>

    <section class="space-y-5 py-5">

        <section class="max-w-7xl mx-auto">
            @if (session('message'))
                <div id="alert" class="flex items-center p-4 mb-4 bg-emerald-500 text-emerald-50 rounded-2xl"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-reguler">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div id="alert" class="flex items-center p-4 mb-4 bg-red-500 text-red-50 rounded-xl"
                    role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div class="ml-3 text-sm font-reguler">
                        {{ session('error') }}
                    </div>
                </div>
            @endif
        </section>

        <section class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between">
                <div class="w-full md:w-4/6 p-3">
                    <div class="bg-white border border-gray-100 rounded-3xl space-y-3 p-8">
                        <form action="{{ route('schools.update', $school->id) }}" class="space-y-3" id="school-form"
                            method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="relative z-0 w-full group">
                                    <x-label for="name" :value="__('Nama Sekolah')" />
                                    <x-input id="name" type="text" name="name" maxlength="100"
                                        value="{{ $school->name }}" placeholder="Nama sekolah disini.." required />
                                    <div class="text-xs mt-1 text-red-600">
                                        {{ $errors->first('name') }}
                                    </div>
                                </div>
                                <div class="relative z-0 w-full group">
                                    <x-label for="type" :value="__('Jenis Sekolah')" />
                                    <x-select id="type" name="type" required>
                                        @switch($school->type)
                                            @case('SMA')
                                                <option value="SMA" selected>SMA</option>
                                                <option value="SMK">SMK</option>
                                                <option value="MA">MA</option>
                                                <option value="Paket">Paket</option>
                                            @break

                                            @case('SMK')
                                                <option value="SMA">SMA</option>
                                                <option value="SMK" selected>SMK</option>
                                                <option value="MA">MA</option>
                                                <option value="Paket">Paket</option>
                                            @break

                                            @case('MA')
                                                <option value="SMA">SMA</option>
                                                <option value="SMK">SMK</option>
                                                <option value="MA" selected>MA</option>
                                                <option value="Paket">Paket</option>
                                            @break

                                            @case('Paket')
                                                <option value="SMA">SMA</option>
                                                <option value="SMK">SMK</option>
                                                <option value="MA">MA</option>
                                                <option value="Paket" selected>Paket</option>
                                            @break

                                            @default
                                                <option>Pilih</option>
                                                <option value="SMA">SMA</option>
                                                <option value="SMK">SMK</option>
                                                <option value="MA">MA</option>
                                                <option value="Paket">Paket</option>
                                            @break
                                        @endswitch
                                    </x-select>
                                    <div class="text-xs mt-1 text-red-600">
                                        {{ $errors->first('type') }}
                                    </div>
                                </div>
                                <div class="relative z-0 w-full group">
                                    <x-label for="lat" :value="__('Lattitude')" />
                                    <x-input id="lat" type="number" name="lat" maxlength="8" minlength="7"
                                        value="{{ $school->lat }}" placeholder="Lattitude" required />
                                    <div class="text-xs mt-1 text-red-600">
                                        {{ $errors->first('lat') }}
                                    </div>
                                </div>
                                <div class="relative z-0 w-full group">
                                    <x-label for="lng" :value="__('Longitude')" />
                                    <x-input id="lng" type="number" name="lng" maxlength="8" minlength="7"
                                        value="{{ $school->lng }}" placeholder="Longitude" required />
                                    <div class="text-xs mt-1 text-red-600">
                                        {{ $errors->first('lng') }}
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="relative z-0 w-full group">
                                    <x-label for="status" :value="__('Status Sekolah')" />
                                    <x-select id="status" name="status" required>
                                        @switch($school->status)
                                            @case('N')
                                                <option value="N" selected>Negeri</option>
                                                <option value="S">Swasta</option>
                                            @break

                                            @case('S')
                                                <option value="N">Negeri</option>
                                                <option value="S" selected>Swasta</option>
                                            @break

                                            @default
                                                <option>Pilih</option>
                                                <option value="N">Negeri</option>
                                                <option value="S">Swasta</option>
                                            @break
                                        @endswitch
                                    </x-select>
                                    <div class="text-xs mt-1 text-red-600">
                                        {{ $errors->first('status') }}
                                    </div>
                                </div>
                                <div class="relative z-0 w-full group">
                                    <x-label for="provinces" :value="__('Provinsi')" />
                                    <x-select id="provinces" required>
                                        <option value="">Pilih Provinsi</option>
                                    </x-select>
                                </div>
                                <div class="relative z-0 w-full group">
                                    <x-label for="regencies" :value="__('Kota')" />
                                    <x-select id="regencies" name="region" disabled required>
                                        <option value="">Pilih Kota / Kabupaten</option>
                                    </x-select>
                                    <div class="text-xs mt-1 text-red-600">
                                        {{ $errors->first('region') }}
                                    </div>
                                </div>
                                <select id="districts" hidden></select>
                                <select id="villages" hidden></select>
                            </div>
                            <div>
                                <button type="button" onclick="updateSchool()"
                                    class="bg-lp3i-100 hover:bg-lp3i-200 text-white px-5 py-2 rounded-xl text-sm">
                                    <i class="fa-regular fa-floppy-disk"></i> Simpan Perubahan</button>
                                <button type="button" onclick="deleteSchool('{{ $school->id }}')"
                                    class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-xl text-sm"><i
                                        class="fa-regular fa-trash-can"></i> Hapus</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </section>

    @push('scripts')
        <script src="{{ asset('js/indonesia.js') }}"></script>
        <script src="{{ asset('js/axios.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.js-example-input-single').select2({
                    tags: true,
                    placeholder: 'Pilih sekolah',
                });
                const maxLength = 2;
                $(document).on('keydown', '.select2-search__field', function() {
                    // if (this.value.length > maxLength) {
                    //     this.value = this.value.substring(0, maxLength);
                    //     alert('Maximum length of school name is ' + maxLength + ' characters.');
                    // }
                    alert('oey');
                });
            });

            const updateSchool = () => {
                document.getElementById('school-form').submit();
            }

            const deleteSchool = (id) => {
                let deleteConfirm = confirm('Apakah anda yakin akan menghapus sekolah?');
                if (deleteConfirm) {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                    fetch(`/schools/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                            }
                        })
                        .then((response) => {
                            if (!response.ok) {
                                alert('Network response was not ok.')
                            }
                            return response.json();
                        })
                        .then((data) => {
                            alert(data.message);
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }
            }
        </script>
    @endpush
</x-app-layout>
