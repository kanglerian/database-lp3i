@if (Auth::user()->role !== 'S' && Auth::user()->role !== 'K')
    <div class="max-w-7xl px-5 mx-auto">
        <div class="grid grid-cols-1 gap-4">
            <div class="bg-gray-50 relative overflow-x-auto border border-gray-200 rounded-3xl">
                <header class="px-6 py-5 space-y-1">
                    <h1 class="flex items-center gap-2 font-bold text-gray-700">
                        <span>Database: Harta Gono Gini</span>
                        <span class="inline-block bg-red-500 px-2 py-1 rounded-lg text-xs text-white">
                            {{ $databasesAdminstratorCount }}
                        </span>
                    </h1>
                    <p class="text-gray-600 text-sm">Ini adalah data yang belum dibagikan ke Presenter.</p>
                </header>
                <hr class="mb-5">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                No.
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Sumber Database
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Sumber Database
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Asal Sekolah
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Tahun Lulus
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($databasesAdministrator as $number => $database)
                            <tr class="{{ $number % 2 == 0 ? 'border-b bg-gray-50' : 'bg-white' }}">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $number + 1 }}
                                </th>
                                <td class="px-6 py-4">
                                    @if (Auth::user()->role == 'A')
                                        <a href="{{ route('database.show', $database->identity) }}"
                                            class="underline font-bold">{{ $database->name }}</a>
                                    @else
                                        {{ $database->name }}
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    {{ $database->sourceSetting->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $database->school ? $database->schoolApplicant->name : 'Tidak diketahui' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $database->year ? $database->year : 'Tidak diketahui' }}
                                </td>
                            </tr>
                        @empty
                            <tr class="border-b border-t">
                                <td colspan="5" class="px-6 py-4 text-center">Data belum ada</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if ($databasesAdminstratorCount > count($databasesAdministrator))
                        <tfoot>
                            <tr class="bg-red-500 text-white">
                                <td colspan="5" class="text-center text-xs px-3 py-2">Data sudah lebih dari
                                    {{ count($databasesAdministrator) }}, silahkan cek melalui menu <a
                                        href="{{ route('database.index') }}" class="underline">Database</a></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
                <hr class="mb-5">
                <div class="px-5 pb-5">
                    <p class="text-gray-500 text-xs">Catatan: Silahkan untuk dibagikan melalui menu <a
                            href="{{ route('database.index') }}" class="underline">Database</a>, kemudian
                        ubah presenter di profil calon mahasiswa baru oleh Administrator.</p>
                </div>
            </div>
        </div>
    </div>
@endif
