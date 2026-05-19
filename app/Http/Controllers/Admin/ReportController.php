<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Transaksi;
use App\Models\Mobil;

class ReportController extends Controller
{
    public function index()
    {
        $totalPenjualan = Transaksi::whereIn('status_transaksi', ['Lunas', 'Mobil Diambil / Dikirim', 'Transaksi Selesai'])
            ->whereMonth('created_at', now()->month)
            ->count();

        $totalPendapatan = Pembayaran::where('status_verifikasi', 'Valid')
            ->whereMonth('tgl_bayar', now()->month)
            ->sum('jumlah_bayar');

        $rataRata = $totalPenjualan > 0 ? $totalPendapatan / $totalPenjualan : 0;

        $transaksis = Transaksi::with(['pembeli.user', 'mobil', 'pembayarans'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.reports', [
            'activePage' => 'reports',
            'pageTitle' => 'Laporan Transaksi',
            'totalPenjualan' => $totalPenjualan,
            'totalPendapatan' => $totalPendapatan,
            'rataRata' => $rataRata,
            'transaksis' => $transaksis,
        ]);
    }

    public function export()
    {
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=laporan-transaksi-" . date('Y-m-d') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $transaksis = Transaksi::with(['pembeli.user', 'mobil'])
            ->orderBy('created_at', 'desc')
            ->get();

        $callback = function() use($transaksis) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM to make Excel read it correctly with accents/chars
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // CSV Header
            fputcsv($file, ['ID Transaksi', 'Pelanggan', 'Mobil', 'Total Harga', 'Tanggal', 'Status']);

            foreach ($transaksis as $trx) {
                fputcsv($file, [
                    '#TRX-' . str_pad($trx->id, 4, '0', STR_PAD_LEFT),
                    $trx->pembeli->nama_lengkap ?? '-',
                    $trx->mobil->merk . ' ' . $trx->mobil->model,
                    $trx->total_harga,
                    $trx->created_at->format('d M Y H:i'),
                    $trx->status_transaksi
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
