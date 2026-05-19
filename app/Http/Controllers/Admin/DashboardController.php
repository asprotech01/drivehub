<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use App\Models\Pembayaran;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMobil = Mobil::where('status_mobil', 'Tersedia')->count();

        $pendapatanBulanIni = Pembayaran::where('status_verifikasi', 'Valid')
            ->whereMonth('tgl_bayar', now()->month)
            ->whereYear('tgl_bayar', now()->year)
            ->sum('jumlah_bayar');

        $bookingBaru = Transaksi::where('status_transaksi', 'Menunggu Pembayaran Booking')
            ->orWhere('status_transaksi', 'Booking Berhasil')
            ->count();

        $menungguPengiriman = Transaksi::where('status_transaksi', 'Lunas')
            ->count();

        $recentTransactions = Transaksi::with(['pembeli.user', 'mobil'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $pendingPayments = Pembayaran::where('status_verifikasi', 'Menunggu Verifikasi')->count();

        return view('admin.dashboard', [
            'activePage' => 'dashboard',
            'pageTitle' => 'Dashboard',
            'totalMobil' => $totalMobil,
            'pendapatanBulanIni' => $pendapatanBulanIni,
            'bookingBaru' => $bookingBaru,
            'menungguPengiriman' => $menungguPengiriman,
            'recentTransactions' => $recentTransactions,
            'pendingPayments' => $pendingPayments,
        ]);
    }
}
