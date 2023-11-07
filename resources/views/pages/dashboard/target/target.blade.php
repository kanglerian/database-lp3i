@if (Auth::user()->role == 'P')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-2 px-2">
        <div class="flex flex-wrap">
            <div class="block w-1/2 md:w-1/5 p-1">
                <div class="flex justify-between items-center px-5 py-3 bg-sky-500 text-white rounded-xl">
                    <h4>
                        <i class="fa-solid fa-bullseye mr-1"></i>
                        <span class="text-sm">Total Target</span>
                    </h4>
                    <span class="bg-sky-600 text-white text-sm px-2 py-1 rounded-lg" id="target_count">0</span>
                </div>
            </div>
            <div class="block w-1/2 md:w-1/5 p-1">
                <div class="flex justify-between items-center px-5 py-3 bg-emerald-500 text-white rounded-xl">
                    <h4>
                        <i class="fa-solid fa-person-circle-check mr-1"></i>
                        <span class="text-sm">Registrasi</span>
                    </h4>
                    <span class="bg-emerald-600 text-white text-sm px-2 py-1 rounded-lg" id="register_count">0</span>
                </div>
            </div>
            <div class="block w-1/2 md:w-1/5 p-1">
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
    </div>
@endif
