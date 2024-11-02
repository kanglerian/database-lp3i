@if (Auth::user()->role !== 'S' && Auth::user()->role !== 'K')
    @if($approval_count > 0)
    <div class="grid grid-cols-1 gap-4">
        <div class="bg-gray-50 relative overflow-x-auto border border-gray-200 rounded-3xl">
            <header class="px-6 py-5 space-y-1">
                <h1 class="flex items-center gap-2 font-bold text-gray-700">
                    <span>Permintaan Approval Daftar</span>
                    <span class="inline-block bg-red-500 px-2 py-1 rounded-lg text-xs text-white">
                        {{ $approval_count }}
                    </span>
                </h1>
                <p class="text-gray-600 text-sm">Ini adalah data pendaftaran yang belum disetujui.</p>
            </header>
            <hr class="mb-5">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No.
                        </th>
                        <th scope="col" class="px-6 py-3">
                            PMB
                        </th>
                        <th scope="col" class="px-6 py-3">
                            No. Kwitansi
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nominal Daftar
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Tanggal
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama Lengkap
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($approval as $number => $approve)
                        <tr class="{{ $number % 2 == 0 ? 'border-b bg-gray-50' : 'bg-white' }}">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $number + 1 }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $approve->applicant ? $approve->applicant->pmb : 'Belum diketahui' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $approve->receipt }}
                            </td>
                            <td class="px-6 py-4">
                                Rp{{ number_format($approve->nominal, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $approve->date }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('database.show', $approve->identity_user) }}" target="_blank" class="font-bold underline">
                                    {{ $approve->applicant ? $approve->applicant->name : 'Belum diketahui' }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('enrollment.approve', $approve->id) }}" method="post" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 transition-all ease-in-out text-white px-4 py-2 rounded-xl text-xs"><i class="fa-solid fa-user-check"></i> <span>Approve</span></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-b border-t">
                            <td colspan="7" class="px-6 py-4 text-center">Data belum ada</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <hr class="mb-5">
            <div class="px-5 pb-5">
                <p class="text-gray-500 text-xs">Catatan: Catatan: Silahkan untuk klik menu <a href="{{ route('payment.index') }}" class="underline">Payment</a> untuk melihat informasi lebih lanjut.</p>
            </div>
        </div>
    </div>
    @endif
@endif
