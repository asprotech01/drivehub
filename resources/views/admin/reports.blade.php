@extends('layouts.admin')
@section('title', 'Laporan Transaksi - Admin DriveHub')
@section('content')

<!-- Wrapper Utama -->
<div class="space-y-6">

    <!-- Header & Tombol Aksi Utama -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col sm:flex-row justify-between items-center gap-4 print:hidden">
        <div>
            <h1 class="text-2xl font-bold text-dark tracking-tight">Laporan Transaksi</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau performa penjualan, pendapatan, dan statistik transaksi.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <button onclick="window.print()" class="bg-blue-50 hover:bg-blue-100 text-blue-700 px-5 py-2.5 rounded-xl font-bold transition-all flex items-center gap-2 text-sm">
                <i class='bx bx-printer text-lg animate-pulse'></i> Cetak PDF / Laporan
            </button>
            <a href="{{ route('admin.reports.export', request()->query()) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl font-bold shadow-md hover:shadow-lg transition-all flex items-center gap-2 text-sm">
                <i class='bx bx-spreadsheet text-lg'></i> Ekspor Excel (.xlsx)
            </a>
        </div>
    </div>

    <!-- Kop Cetak Khusus (Hanya muncul saat diprint) -->
    <div class="hidden print:block mb-8 text-center">
        <h1 class="text-3xl font-black text-dark tracking-tight uppercase mb-1">DRIVEHUB</h1>
        <p class="text-gray-500 font-bold text-sm tracking-widest uppercase">Laporan Analisis & Ringkasan Transaksi Bulanan</p>
        <div class="border-b-4 border-double border-gray-800 my-4"></div>
        <div class="grid grid-cols-2 text-left text-xs text-gray-600 mb-6 gap-2">
            <div>
                <p><span class="font-semibold">Periode Laporan:</span> 
                    @if(request('start_date') && request('end_date'))
                        {{ date('d M Y', strtotime(request('start_date'))) }} - {{ date('d M Y', strtotime(request('end_date'))) }}
                    @elseif(request('start_date'))
                        Mulai {{ date('d M Y', strtotime(request('start_date'))) }}
                    @elseif(request('end_date'))
                        Hingga {{ date('d M Y', strtotime(request('end_date'))) }}
                    @else
                        Bulan Ini ({{ now()->translatedFormat('F Y') }})
                    @endif
                </p>
                <p><span class="font-semibold">Filter Status:</span> {{ request('status') ?: 'Semua Status' }}</p>
            </div>
            <div class="text-right">
                <p><span class="font-semibold">Tanggal Cetak:</span> {{ now()->translatedFormat('d F Y H:i') }}</p>
                <p><span class="font-semibold">Operator:</span> Administrator System</p>
            </div>
        </div>
    </div>

    <!-- Dashboard Ringkasan Premium (Summary Cards) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1: Total Penjualan -->
        <div class="bg-gradient-to-br from-indigo-900 via-blue-900 to-indigo-950 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 text-white/10 text-9xl font-black select-none pointer-events-none transform group-hover:scale-110 transition-transform duration-500">
                <i class='bx bx-shopping-bag'></i>
            </div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div>
                    <p class="text-indigo-200/80 text-xs font-semibold uppercase tracking-wider">Total Transaksi</p>
                    <h3 class="text-4xl font-extrabold tracking-tight mt-1">{{ $totalPenjualan }}</h3>
                </div>
                <div class="bg-white/10 p-3 rounded-xl backdrop-blur-md border border-white/10">
                    <i class='bx bx-shopping-bag text-2xl text-indigo-300'></i>
                </div>
            </div>
            <p class="text-xs text-indigo-200/70 relative z-10 flex items-center gap-1">
                <i class='bx bx-info-circle text-sm'></i> 
                {{ request('start_date') || request('end_date') ? 'Berdasarkan filter tanggal' : 'Jumlah transaksi sukses bulan ini' }}
            </p>
        </div>

        <!-- Card 2: Total Pendapatan -->
        <div class="bg-gradient-to-br from-emerald-800 via-teal-800 to-emerald-950 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 text-white/10 text-9xl font-black select-none pointer-events-none transform group-hover:scale-110 transition-transform duration-500">
                <i class='bx bx-wallet'></i>
            </div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div>
                    <p class="text-emerald-200/80 text-xs font-semibold uppercase tracking-wider">Total Pendapatan</p>
                    <h3 class="text-3xl font-extrabold tracking-tight mt-2">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-white/10 p-3 rounded-xl backdrop-blur-md border border-white/10">
                    <i class='bx bx-wallet text-2xl text-emerald-300'></i>
                </div>
            </div>
            <p class="text-xs text-emerald-200/70 relative z-10 flex items-center gap-1">
                <i class='bx bx-info-circle text-sm'></i> 
                {{ request('start_date') || request('end_date') ? 'Berdasarkan filter tanggal' : 'Total dana masuk tervalidasi bulan ini' }}
            </p>
        </div>

        <!-- Card 3: Rata-rata Nilai Transaksi -->
        <div class="bg-gradient-to-br from-blue-800 via-indigo-800 to-blue-950 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 text-white/10 text-9xl font-black select-none pointer-events-none transform group-hover:scale-110 transition-transform duration-500">
                <i class='bx bx-trending-up'></i>
            </div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div>
                    <p class="text-blue-200/80 text-xs font-semibold uppercase tracking-wider">Rata-rata Transaksi</p>
                    <h3 class="text-3xl font-extrabold tracking-tight mt-2">Rp {{ number_format($rataRata, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-white/10 p-3 rounded-xl backdrop-blur-md border border-white/10">
                    <i class='bx bx-trending-up text-2xl text-blue-300'></i>
                </div>
            </div>
            <p class="text-xs text-blue-200/70 relative z-10 flex items-center gap-1">
                <i class='bx bx-info-circle text-sm'></i> Rata-rata nilai mobil terjual
            </p>
        </div>
    </div>

    <!-- Form Filter Interaktif (Panel Kontrol) -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 print:hidden">
        <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-4 flex items-center gap-2">
            <i class='bx bx-filter-alt text-lg text-primary'></i> Panel Filter Transaksi
        </h2>
        <form method="GET" action="{{ route('admin.reports') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4">
            
            <!-- Filter Tanggal Mulai -->
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-semibold text-gray-500">Tanggal Mulai</label>
                <div class="relative">
                    <i class='bx bx-calendar absolute left-3 top-3 text-gray-400 text-lg'></i>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                </div>
            </div>

            <!-- Filter Tanggal Selesai -->
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-semibold text-gray-500">Tanggal Selesai</label>
                <div class="relative">
                    <i class='bx bx-calendar absolute left-3 top-3 text-gray-400 text-lg'></i>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                </div>
            </div>

            <!-- Filter Status -->
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-semibold text-gray-500">Status</label>
                <div class="relative">
                    <i class='bx bx-select-multiple absolute left-3 top-3 text-gray-400 text-lg'></i>
                    <select name="status" class="w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent appearance-none bg-white transition-all">
                        <option value="">Semua Status</option>
                        <option value="Lunas" {{ request('status') === 'Lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="Transaksi Selesai" {{ request('status') === 'Transaksi Selesai' ? 'selected' : '' }}>Transaksi Selesai</option>
                        <option value="Mobil Diambil / Dikirim" {{ request('status') === 'Mobil Diambil / Dikirim' ? 'selected' : '' }}>Mobil Diambil / Dikirim</option>
                        <option value="Menunggu Pembayaran Booking" {{ request('status') === 'Menunggu Pembayaran Booking' ? 'selected' : '' }}>Menunggu Pembayaran Booking</option>
                        <option value="Dibatalkan" {{ request('status') === 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
            </div>

            <!-- Pencarian Teks -->
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-semibold text-gray-500">Pencarian</label>
                <div class="relative">
                    <i class='bx bx-search absolute left-3 top-3 text-gray-400 text-lg'></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="ID, mobil, pelanggan..." class="w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                </div>
            </div>

            <!-- Tombol Submit & Reset -->
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-primary hover:bg-primaryHover text-white py-2.5 rounded-xl font-bold transition-all shadow-md flex justify-center items-center gap-1.5 text-sm">
                    <i class='bx bx-check-double text-lg'></i> Terapkan
                </button>
                @if(request('start_date') || request('end_date') || request('status') || request('search'))
                    <a href="{{ route('admin.reports') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 p-2.5 rounded-xl font-bold transition-all flex justify-center items-center" title="Reset Filter">
                        <i class='bx bx-refresh text-xl'></i>
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Tabel Daftar Transaksi Premium -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center print:hidden">
            <h3 class="font-bold text-gray-800">Daftar Transaksi Terkini</h3>
            <span class="text-xs font-semibold bg-gray-50 text-gray-500 px-3 py-1.5 rounded-lg border border-gray-100">
                Menampilkan {{ $transaksis->count() }} dari {{ $transaksis->total() }} total data
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/75 border-b border-gray-100 text-gray-500 text-xs uppercase tracking-wider font-semibold">
                        <th class="px-6 py-4">ID Transaksi</th>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4">Mobil</th>
                        <th class="px-6 py-4">Total Harga</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    @forelse($transaksis as $trx)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-gray-900 tracking-tight">
                            #TRX-{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-800">{{ $trx->pembeli->nama_lengkap ?? '-' }}</div>
                            <div class="text-xs text-gray-400 mt-0.5">{{ $trx->pembeli->user->email ?? '' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-800">{{ $trx->mobil->merk ?? '-' }} {{ $trx->mobil->model ?? '' }}</div>
                            <div class="text-xs text-gray-400 mt-0.5">Tahun {{ $trx->mobil->tahun ?? '' }} • Transmisi {{ $trx->mobil->transmisi ?? '' }}</div>
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-900">
                            Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $trx->created_at->translatedFormat('d M Y') }}
                            <div class="text-xs text-gray-400 mt-0.5">{{ $trx->created_at->format('H:i') }} WIB</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php 
                                $c = match($trx->status_transaksi) {
                                    'Lunas', 'Transaksi Selesai', 'Mobil Diambil / Dikirim' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                    'Dibatalkan' => 'bg-rose-50 text-rose-700 border-rose-100',
                                    default => 'bg-amber-50 text-amber-700 border-amber-100',
                                }; 
                            @endphp
                            <span class="{{ $c }} px-3 py-1.5 rounded-full text-xs font-bold border inline-block tracking-wide shadow-sm">
                                {{ $trx->status_transaksi }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <i class='bx bx-folder-open text-5xl text-gray-300'></i>
                                <p class="text-gray-500 font-medium">Tidak ada data transaksi yang ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transaksis->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 print:hidden bg-gray-50/30">
            {{ $transaksis->links() }}
        </div>
        @endif
    </div>

</div>

@push('styles')
<style>
    @media print {
        aside, 
        header, 
        .print\:hidden,
        .pagination,
        nav {
            display: none !important;
        }
        
        main {
            padding: 0 !important;
            margin: 0 !important;
            background: white !important;
            overflow: visible !important;
            height: auto !important;
        }

        body {
            background: white !important;
            color: black !important;
            overflow: visible !important;
            height: auto !important;
        }

        .bg-white {
            background-color: white !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
        }

        .border {
            border-color: #d1d5db !important;
        }

        table {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        th {
            background-color: #f3f4f6 !important;
            color: #111827 !important;
            font-weight: bold !important;
            border-bottom: 2px solid #9ca3af !important;
        }

        th, td {
            border-bottom: 1px solid #d1d5db !important;
            padding: 8px 10px !important;
            color: black !important;
        }
        
        .grid {
            display: grid !important;
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            gap: 1.5rem !important;
        }
        
        .rounded-2xl {
            border-radius: 0.75rem !important;
            border: 1px solid #9ca3af !important;
            background: #f9fafb !important;
            color: black !important;
        }

        /* Hilangkan warna gradasi saat print agar hemat tinta */
        .bg-gradient-to-br {
            background: #f3f4f6 !important;
            color: black !important;
            box-shadow: none !important;
            border: 1px solid #d1d5db !important;
        }

        .bg-gradient-to-br p, .bg-gradient-to-br h3, .bg-gradient-to-br i {
            color: black !important;
        }

        tr:hover {
            background-color: transparent !important;
        }
    }
</style>
@endpush
@endsection
