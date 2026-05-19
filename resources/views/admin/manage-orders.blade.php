@extends('layouts.admin')
@section('title', 'Kelola Pesanan - Admin DriveHub')
@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col">
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="relative w-full sm:w-96">
                <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg'></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pembeli, mobil, plat nomor, atau status..." class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-primary outline-none text-sm transition-colors">
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-medium">ID Pesanan</th>
                        <th class="px-6 py-4 font-medium">Pembeli</th>
                        <th class="px-6 py-4 font-medium">Mobil</th>
                        <th class="px-6 py-4 font-medium">Total Harga</th>
                        <th class="px-6 py-4 font-medium">Status Pesanan</th>
                        <th class="px-6 py-4 font-medium">Tanggal</th>
                        <th class="px-6 py-4 font-medium text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-mono font-bold text-gray-400">
                            #TRX-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-dark text-base">{{ $order->pembeli->nama_lengkap }}</div>
                            <div class="text-xs text-gray-500">{{ $order->pembeli->no_hp }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-800">{{ $order->mobil->merk }} {{ $order->mobil->model }}</div>
                            <div class="text-xs text-gray-500 font-mono">{{ $order->mobil->nomor_polisi }}</div>
                        </td>
                        <td class="px-6 py-4 font-bold text-dark">
                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusColor = match($order->status_transaksi) {
                                    'Menunggu Pembayaran Booking' => 'bg-yellow-50 text-yellow-700 border-yellow-100',
                                    'Booking Berhasil' => 'bg-blue-50 text-blue-700 border-blue-100',
                                    'Menunggu DP' => 'bg-amber-50 text-amber-700 border-amber-100',
                                    'DP Berhasil' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                                    'Menunggu Pelunasan' => 'bg-orange-50 text-orange-700 border-orange-100',
                                    'Lunas' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                    'Mobil Diambil / Dikirim' => 'bg-teal-50 text-teal-700 border-teal-100',
                                    'Transaksi Selesai' => 'bg-green-100 text-green-800 border-green-200',
                                    'Dibatalkan' => 'bg-red-50 text-red-700 border-red-100',
                                    default => 'bg-gray-50 text-gray-700 border-gray-100',
                                };
                            @endphp
                            <span class="{{ $statusColor }} px-3 py-1.5 rounded-full text-xs font-bold border">
                                {{ $order->status_transaksi }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ $order->tgl_transaksi->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center gap-1 bg-primary/5 text-primary hover:bg-primary hover:text-white px-3 py-2 rounded-xl text-xs font-bold transition-all" title="Detail Pesanan">
                                <i class='bx bx-search-alt text-base'></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">Belum ada data pesanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
        <div class="p-6 border-t border-gray-100 flex justify-between items-center">
            <span class="text-sm text-gray-500">Menampilkan {{ $orders->firstItem() }}-{{ $orders->lastItem() }} dari {{ $orders->total() }} pesanan</span>
            {{ $orders->links() }}
        </div>
        @endif
    </div>
@endsection
