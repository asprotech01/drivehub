<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PaymentVerificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with(['transaksi.mobil', 'transaksi.pembeli.user'])
            ->where('status_verifikasi', 'Menunggu Verifikasi');

        if ($request->has('tipe') && in_array($request->tipe, ['booking', 'dp', 'pelunasan'])) {
            $mappedTipe = match($request->tipe) {
                'booking' => 'Booking Fee',
                'dp' => 'DP',
                'pelunasan' => 'Pelunasan',
            };
            $query->where('tipe_pembayaran', $mappedTipe);
        }

        $pendingPayments = $query->orderBy('created_at', 'desc')->get();

        return view('admin.verify-payment', [
            'activePage' => 'verify-payment',
            'pageTitle' => 'Verifikasi Pembayaran',
            'pendingPayments' => $pendingPayments,
            'currentTipe' => $request->tipe ?? 'all',
        ]);
    }

    public function approve($id)
    {
        $pembayaran = Pembayaran::with('transaksi')->findOrFail($id);
        $pembayaran->update([
            'status_verifikasi' => 'Valid',
            'admin_id' => \App\Models\Admin::where('user_id', auth()->id())->first()?->id,
        ]);

        // Update transaction status & deadlines
        $transaksi = $pembayaran->transaksi;
        if ($pembayaran->tipe_pembayaran === 'Booking Fee') {
            $transaksi->update([
                'status_transaksi' => 'Booking Berhasil',
                'batas_pembayaran' => now()->addDays(7), // 1 week to pay DP
            ]);
        } elseif ($pembayaran->tipe_pembayaran === 'DP') {
            $transaksi->update([
                'status_transaksi' => 'DP Berhasil',
                'batas_pembayaran' => now()->addDays(14), // 2 weeks to pay full amount while STNK processed
            ]);
        } elseif ($pembayaran->tipe_pembayaran === 'Pelunasan') {
            $transaksi->update(['status_transaksi' => 'Lunas']);
        }

        return redirect()->route('admin.payment.index')
            ->with('success', 'Pembayaran #' . $pembayaran->id . ' berhasil diverifikasi!');
    }

    public function reject($id)
    {
        $pembayaran = Pembayaran::with('transaksi')->findOrFail($id);
        $pembayaran->update([
            'status_verifikasi' => 'Tidak Valid',
            'admin_id' => \App\Models\Admin::where('user_id', auth()->id())->first()?->id,
        ]);

        return redirect()->route('admin.payment.index')
            ->with('success', 'Pembayaran #' . $pembayaran->id . ' ditolak.');
    }
}
