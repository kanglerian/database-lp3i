@if (Auth::user()->role == 'P')
    <section class="max-w-7xl mx-auto">
        <div class="bg-white p-5 md:rounded-xl border border-gray-100">
            <h2 class="font-bold text-gray-900 text-xl">Informasi Target Perolehan</h2>
            <p class="text-sm text-gray-700">Berikut ini adalah data target perolehan mahasiswa baru.</p>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-3">
                <div class="flex justify-between items-center px-5 py-3 bg-sky-500 text-white rounded-xl">
                    <h4>
                        <i class="fa-solid fa-bullseye mr-1"></i>
                        <span class="text-sm">Total Target</span>
                    </h4>
                    <span class="bg-sky-600 text-white text-sm px-2 py-1 rounded-lg" id="target_count">0</span>
                </div>
                <div class="flex justify-between items-center px-5 py-3 bg-emerald-500 text-white rounded-xl">
                    <h4>
                        <i class="fa-solid fa-person-circle-check mr-1"></i>
                        <span class="text-sm">Registrasi</span>
                    </h4>
                    <span class="bg-emerald-600 text-white text-sm px-2 py-1 rounded-lg" id="register_count">0</span>
                </div>
                <div id="container-animate"
                    class="relative flex justify-between items-center px-5 py-3 bg-red-500 text-white rounded-xl">
                    <h4>
                        <i class="fa-solid fa-person-circle-xmark mr-1"></i>
                        <span class="text-sm">Sisa Target</span>
                    </h4>
                    <span class="bg-red-600 text-white text-sm px-2 py-1 rounded-lg" id="result_count">0</span>
                    <div class="hidden absolute top-[-60px] right-0" id="animate">
                        <dotlottie-player src="{{ asset('animations/win.lottie') }}" background="transparent"
                            speed="1" style="width: 150px; height: 150px" direction="1" mode="normal" loop
                            autoplay></dotlottie-player>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
