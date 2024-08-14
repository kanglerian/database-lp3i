<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
  @if (session('error'))
      <div id="alert" class="mx-2 mb-4 flex items-center p-4 mb-4 bg-red-400 text-white rounded-xl"
          role="alert">
          <i class="fa-solid fa-circle-exclamation"></i>
          <div class="ml-3 text-sm font-reguler">
              {{ session('error') }}
          </div>
      </div>
  @endif
  @if (session('message'))
      <div id="alert" class="mx-2 mb-4 flex items-center p-4 bg-emerald-500 text-emerald-50 rounded-xl"
          role="alert">
          <i class="fa-solid fa-circle-check"></i>
          <div class="ml-3 text-sm font-reguler">
              {{ session('message') }}
          </div>
      </div>
  @endif
</div>
