@extends('layouts.admin')
@section('title', 'Laporan Transaksi - Admin DriveHub')
@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col mb-8">
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6 print:hidden">
        <h2 class="text-lg font-bold text-dark">Ringkasan Bulan Ini ({{ now()->translatedFormat('F Y') }})</h2>
        <div class="flex gap-3">
            <button onclick="window.print()" class="bg-primary hover:bg-primaryHover text-white px-5 py-2.5 rounded-xl font-bold shadow-md hover:shadow-lg transition-all flex items-center gap-2 text-sm">
                <i class='bx bx-printer text-lg'></i> Cetak Laporan
            </button>
            <a href="{{ route('admin.reports.export') }}" class="bg-white text-dark px-5 py-2.5 rounded-xl font-bold border border-gray-200 hover:bg-gray-50 transition-all flex items-center gap-2 text-sm">
                <i class='bx bx-export text-lg'></i> Ekspor CSV
            </a>
        </div>
    </div>

    <!-- Header khusus cetak (hanya muncul saat diprint) -->
    <div class="hidden print:block mb-8 text-center">
        <h1 class="text-3xl font-black text-dark tracking-tight uppercase mb-1">Laporan Transaksi DriveHub</h1>
        <p class="text-gray-500 font-semibold">Ringkasan Transaksi Bulan Ini ({{ now()->translatedFormat('F Y') }})</p>
        <div class="border-b-2 border-gray-800 my-4"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="border border-gray-200 rounded-xl p-5 text-center">
            <p class="text-gray-500 text-sm font-medium mb-1">Total Penjualan</p>
            <h3 class="text-3xl font-extrabold text-primary mb-2">{{ $totalPenjualan }}</h3>
        </div>
        <div class="border border-gray-200 rounded-xl p-5 text-center">
            <p class="text-gray-500 text-sm font-medium mb-1">Total Pendapatan</p>
            <h3 class="text-3xl font-extrabold text-green-600 mb-2">Rp {{ number_format($totalPendapatan / 1000000, 1) }}M</h3>
        </div>
        <div class="border border-gray-200 rounded-xl p-5 text-center">
            <p class="text-gray-500 text-sm font-medium mb-1">Rata-rata Nilai Transaksi</p>
            <h3 class="text-3xl font-extrabold text-blue-600 mb-2">Rp {{ number_format($rataRata / 1000000, 0) }} Jt</h3>
        </div>
    </div>

    <!-- Transaction List -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-medium">ID</th>
                    <th class="px-6 py-4 font-medium">Pelanggan</th>
                    <th class="px-6 py-4 font-medium">Mobil</th>
                    <th class="px-6 py-4 font-medium">Total</th>
                    <th class="px-6 py-4 font-medium">Tanggal</th>
                    <th class="px-6 py-4 font-medium">Status</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100">
                @forelse($transaksis as $trx)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-dark">#TRX-{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-4">{{ $trx->pembeli->nama_lengkap ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $trx->mobil->merk }} {{ $trx->mobil->model }}</td>
                    <td class="px-6 py-4 font-medium">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $trx->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        @php $c = match($trx->status_transaksi) {
                            'Lunas','Transaksi Selesai' => 'bg-green-100 text-green-700',
                            'Dibatalkan' => 'bg-red-100 text-red-700',
                            default => 'bg-blue-100 text-blue-700',
                        }; @endphp
                        <span class="{{ $c }} px-3 py-1 rounded-full text-xs font-semibold">{{ $trx->status_transaksi }}</span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada transaksi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($transaksis->hasPages())
    <div class="mt-4 print:hidden">{{ $transaksis->links() }}</div>
    @endif
</div>

@push('styles')
<style>
    @media print {
        /* Sembunyikan sidebar, header, tombol tindakan, dan navigasi halaman */
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

        th, td {
            border-bottom: 1px solid #d1d5db !important;
            padding: 10px 12px !important;
            color: black !important;
        }
        
        /* Grid layout untuk summary cards pada kertas */
        .grid {
            display: grid !important;
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            gap: 1.5rem !important;
        }
        
        .rounded-xl {
            border-radius: 0.5rem !important;
            border: 1px solid #d1d5db !important;
            background: #f9fafb !important;
        }

        /* Hilangkan efek hover tabel */
        tr:hover {
            background-color: transparent !important;
        }
    }
</style>
@endpush
@endsection
