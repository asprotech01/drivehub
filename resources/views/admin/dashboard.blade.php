@extends('layouts.admin')
@section('title', 'Dashboard - Admin DriveHub')
@section('content')
    <!-- Top Section: Welcome & Actions -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
        <div>
            <h1 class="text-3xl font-black text-dark tracking-tighter">Dashboard Overview</h1>
            <p class="text-gray-500">Selamat datang kembali, Admin. Berikut ringkasan performa DriveHub hari ini.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.mobil.index') }}" class="bg-primary text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-primary/20 hover:bg-primaryHover transition-all flex items-center gap-2">
                <i class='bx bx-plus-circle text-xl'></i> Tambah Unit
            </a>
            <a href="{{ route('admin.reports.export') }}" class="bg-white text-dark px-6 py-3 rounded-2xl font-bold border border-gray-200 hover:bg-gray-50 transition-all flex items-center gap-2">
                <i class='bx bx-export text-xl'></i> Ekspor Laporan
            </a>
        </div>
    </div>

    <!-- Statistic Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">
        <!-- Revenue Card -->
        <div class="bg-dark rounded-[32px] p-8 text-white relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform">
                <i class='bx bx-trending-up text-7xl'></i>
            </div>
            <div class="relative z-10">
                <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-4">Total Pendapatan</p>
                <h3 class="text-3xl font-black mb-2">Rp {{ number_format($pendapatanBulanIni / 1000000, 1) }}M</h3>
                <div class="flex items-center gap-2 text-green-400 text-xs font-bold">
                    <i class='bx bx-up-arrow-alt'></i> +12.5% <span class="text-gray-500 font-medium">vs bln lalu</span>
                </div>
            </div>
        </div>

        <!-- Active Inventory -->
        <div class="bg-white rounded-[32px] p-8 border border-gray-100 shadow-sm hover:shadow-xl transition-all group">
            <div class="w-14 h-14 bg-blue-50 text-primary rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition-transform">
                <i class='bx bx-car'></i>
            </div>
            <p class="text-gray-500 text-xs font-bold uppercase tracking-widest mb-1">Unit Aktif</p>
            <h3 class="text-3xl font-black text-dark">{{ $totalMobil }} Mobil</h3>
            <p class="text-[10px] text-gray-400 mt-2 font-bold uppercase">Ready to Sale</p>
        </div>

        <!-- New Bookings -->
        <div class="bg-white rounded-[32px] p-8 border border-gray-100 shadow-sm hover:shadow-xl transition-all group">
            <div class="w-14 h-14 bg-yellow-50 text-secondary rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition-transform">
                <i class='bx bx-calendar-check'></i>
            </div>
            <p class="text-gray-500 text-xs font-bold uppercase tracking-widest mb-1">Booking Baru</p>
            <h3 class="text-3xl font-black text-dark">{{ $bookingBaru }} Pesanan</h3>
            <p class="text-[10px] text-yellow-600 mt-2 font-bold uppercase">Menunggu Verifikasi</p>
        </div>

        <!-- Deliveries -->
        <div class="bg-white rounded-[32px] p-8 border border-gray-100 shadow-sm hover:shadow-xl transition-all group">
            <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition-transform">
                <i class='bx bx-paper-plane'></i>
            </div>
            <p class="text-gray-500 text-xs font-bold uppercase tracking-widest mb-1">Pengiriman</p>
            <h3 class="text-3xl font-black text-dark">{{ $menungguPengiriman }} Unit</h3>
            <p class="text-[10px] text-purple-600 mt-2 font-bold uppercase">Proses Logistik</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Recent Transactions -->
        <div class="xl:col-span-2 bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                <h2 class="text-xl font-black text-dark tracking-tight">Transaksi Terbaru</h2>
                <a href="{{ route('admin.reports') }}" class="text-sm font-bold text-primary hover:underline">Semua Transaksi</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">
                            <th class="px-8 py-5">ID & Pelanggan</th>
                            <th class="px-8 py-5">Unit Mobil</th>
                            <th class="px-8 py-5 text-right">Nilai</th>
                            <th class="px-8 py-5 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($recentTransactions as $trx)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="font-bold text-dark text-sm">#TRX-{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}</div>
                                <div class="text-[10px] text-gray-500 font-medium">{{ $trx->pembeli->nama_lengkap ?? 'Guest' }}</div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="text-sm font-bold text-dark">{{ $trx->mobil->merk }}</div>
                                <div class="text-[10px] text-gray-500">{{ $trx->mobil->model }} ({{ $trx->mobil->tahun_produksi }})</div>
                            </td>
                            <td class="px-8 py-6 text-right font-black text-dark text-sm">
                                Rp {{ number_format($trx->total_harga / 1000000, 0) }} Jt
                            </td>
                            <td class="px-8 py-6 text-center">
                                @php
                                    $statusClasses = [
                                        'Menunggu Pembayaran Booking' => 'bg-yellow-50 text-yellow-600',
                                        'Booking Berhasil' => 'bg-blue-50 text-blue-600',
                                        'Lunas' => 'bg-green-50 text-green-600',
                                        'Transaksi Selesai' => 'bg-green-50 text-green-600',
                                        'Dibatalkan' => 'bg-red-50 text-red-600',
                                    ];
                                @endphp
                                <span class="{{ $statusClasses[$trx->status_transaksi] ?? 'bg-gray-50 text-gray-500' }} px-3 py-1.5 rounded-xl text-[10px] font-black uppercase">
                                    {{ $trx->status_transaksi }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions & Alerts -->
        <div class="space-y-8">
            <div class="bg-white rounded-[32px] p-8 border border-gray-100 shadow-sm">
                <h2 class="text-xl font-black text-dark tracking-tight mb-8">Perlu Perhatian</h2>
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-yellow-100 text-yellow-600 flex items-center justify-center text-2xl shrink-0"><i class='bx bx-time-five'></i></div>
                        <div>
                            <h4 class="font-bold text-dark text-sm">Validasi Pembayaran</h4>
                            <p class="text-xs text-gray-500 mt-1 mb-3">Ada {{ $pendingPayments }} pembayaran baru yang belum dikonfirmasi.</p>
                            <a href="{{ route('admin.payment.index') }}" class="inline-block bg-yellow-500 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-yellow-600 transition-all">Lihat Antrian</a>
                        </div>
                    </div>
                    <hr class="border-gray-50">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center text-2xl shrink-0"><i class='bx bx-check-double'></i></div>
                        <div>
                            <h4 class="font-bold text-dark text-sm">Update Inventori</h4>
                            <p class="text-xs text-gray-500 mt-1 mb-3">Pastikan stok mobil tetap update dengan unit baru.</p>
                            <a href="{{ route('admin.mobil.index') }}" class="inline-block bg-primary text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-primaryHover transition-all">Kelola Stok</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Promotion / Tip Card -->
            <div class="bg-gradient-to-br from-secondary to-orange-400 rounded-[32px] p-8 text-dark relative overflow-hidden group">
                <i class='bx bxs-bulb absolute top-0 right-0 text-8xl text-white/20 -mr-4 -mt-4 transform group-hover:rotate-12 transition-transform'></i>
                <h3 class="text-xl font-black mb-2 relative z-10">Admin Tips</h3>
                <p class="text-sm font-medium text-dark/70 relative z-10 leading-relaxed">Gunakan fitur laporan bulanan untuk melihat tren mobil yang paling banyak dicari pembeli.</p>
            </div>
        </div>
    </div>
@endsection
