<x-app-layout>
  <x-slot name="header">
      <div class="flex flex-col md:flex-row justify-between items-center gap-5 pb-3">
          <h2 class="font-bold text-xl text-gray-800 leading-tight">
              {{ __('Daftar Akun') }}
          </h2>
      </div>
  </x-slot>

  <div class="py-4">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">
        <table>
          <thead>
            <tr>
              <th>No.</th>
              <th>Nama</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($applicants as $applicant)
            <tr>
              <td>1</td>
              <td>nama</td>
            </tr>
            @empty
            <tr>
              <td colspan="2">Tidak ada</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
  </div>
</x-app-layout>
