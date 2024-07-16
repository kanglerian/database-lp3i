@push('styles')
    <link href="{{ asset('css/select2-input.css') }}" rel="stylesheet" />
@endpush
<x-guest-layout>
    <section class="flex items-center justify-center md:h-screen bg-gray-50 py-5">
        <div class="max-w-4xl flex flex-col items-center w-full mx-auto gap-10">
            <div class="w-full flex items-center justify-center">
                <a href="{{ route('welcome') }}" class="flex items-center gap-5">
                    <img src="{{ asset('img/lp3i-logo.svg') }}" alt="Politeknik LP3I Kampus Tasikmalaya" class="w-48">
                    <img src="{{ asset('logo/logo-kampusglobalmandiri.png') }}" alt="Kampus Global Mandiri"
                        class="w-36">
                </a>
            </div>
            <header class="text-center space-y-1">
                <h2 class="font-bold text-2xl">Form Data Rekomendasi KKN</h2>
                <p class="text-gray-700">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consequuntur, sapiente?</p>
            </header>
            <form method="POST" action="{{ route('recommendation-data.store-kkn') }}" class="w-full mx-auto space-y-5 px-10 md:px-0">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label for="text" class="block mb-2 text-sm font-medium text-gray-900">Nama lengkap</label>
                        <input type="text" id="name" name="name"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-3"
                            placeholder="Nama lengkap" required />
                    </div>
                    <div>
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">No. Whatsapp</label>
                        <input type="number" id="phone" name="phone"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-3"
                            placeholder="No. Whatsapp" required />
                    </div>
                    <div>
                        <x-label for="school_id" class="mb-[3px]" :value="__('Sekolah')" />
                        <x-select id="school_id" name="school_id" class="js-example-input-single">
                            <option>Pilih Sekolah</option>
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </x-select>
                    </div>
                    <div>
                        <label for="year" class="block mb-2 text-sm font-medium text-gray-900">Tahun lulus</label>
                        <input type="number" id="year" name="year"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-3"
                            placeholder="Tahun lulus" required />
                    </div>
                    <div>
                        <label for="income_parent" class="block mb-2 text-sm font-medium text-gray-900">Pendapatan Orang
                            tua</label>
                        <select id="income_parent" name="income_parent"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-3" required>
                            <option value="">Pilih</option>
                            <option value="< 1.000.000">< 1.000.000</option>
                            <option value="1.000.000 - 2.000.000">1.000.000 - 2.000.000</option>
                            <option value="2.000.000 - 4.000.000">2.000.000 - 4.000.000</option>
                            <option value="> 5.000.000">> 5.000.000</option>
                        </select>
                    </div>
                    <div>
                        <label for="class" class="block mb-2 text-sm font-medium text-gray-900">Kelas</label>
                        <input type="text" id="class" name="class"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-3"
                            placeholder="Kelas" required />
                    </div>
                </div>
                <div class="grid grid-cols-1">
                    <div>
                        <label for="address" class="block mb-2 text-sm font-medium text-gray-900">Alamat</label>
                        <textarea id="address" name="address" rows="4"
                            class="block px-4 py-3 w-full text-sm text-gray-900 bg-white rounded-xl border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Tulis alamat lengkap disini..."></textarea>
                    </div>
                </div>
                <div class="flex justify-center">
                    <button type="submit"
                        class="w-full md:w-1/3 text-white bg-lp3i-300 hover:bg-lp3i-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center">
                        <i class="fa fa-solid fa-save"></i>
                        <span>Tambah Data Rekomendasi</span>
                    </button>
                </div>
            </form>
        </div>
    </section>
    <script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-input-single').select2({
                tags: true,
            });
        });

        let phoneInput = document.getElementById('phone');
        phoneInput.addEventListener('input', function() {
            let phone = phoneInput.value;
            if (phone.startsWith("62")) {
                if (phone.length === 3 && (phone[2] === "0" || phone[2] !== "8")) {
                    phoneInput.value = '62';
                } else {
                    phoneInput.value = phone;
                }
            } else if (phone.startsWith("0")) {
                phoneInput.value = '62' + phone.substring(1);
            } else {
                phoneInput.value = '62';
            }
        });
    </script>
</x-guest-layout>
