<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Pembayaran;
use App\Models\Admin;
use Illuminate\Http\Request;

class ManagePaymentsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Transaksi::with(['pembeli.user', 'mobil', 'pembayarans'])
            ->has('pembayarans') // Only show transactions that have at least one payment
            ->orderBy('updated_at', 'desc');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('pembeli', function($pq) use ($search) {
                      $pq->where('nama_lengkap', 'like', "%{$search}%");
                  })
                  ->orWhereHas('mobil', function($mq) use ($search) {
                      $mq->where('merk', 'like', "%{$search}%")
                        ->orWhere('model', 'like', "%{$search}%");
                  });
            });
        }

        if ($status) {
            $query->where('status_transaksi', $status);
        }

        $transaksis = $query->paginate(10);

        return view('admin.manage-payments.index', [
            'activePage' => 'manage-payments',
            'pageTitle' => 'Kelola Data Pembayaran',
            'transaksis' => $transaksis,
            'search' => $search,
            'status' => $status,
        ]);
    }

    public function forceApprove($id)
    {
        $pembayaran = Pembayaran::with('transaksi')->findOrFail($id);
        $pembayaran->update([
            'status_verifikasi' => 'Valid',
            'admin_id' => Admin::where('user_id', auth()->id())->first()?->id,
        ]);

        // Sync transaction status
        $transaksi = $pembayaran->transaksi;
        if ($pembayaran->tipe_pembayaran === 'Booking Fee') {
            $transaksi->update([
                'status_transaksi' => 'Booking Berhasil',
                'batas_pembayaran' => now()->addDays(7),
            ]);
        } elseif ($pembayaran->tipe_pembayaran === 'DP') {
            $transaksi->update([
                'status_transaksi' => 'DP Berhasil',
                'batas_pembayaran' => now()->addDays(14),
            ]);
        } elseif ($pembayaran->tipe_pembayaran === 'Pelunasan') {
            $transaksi->update([
                'status_transaksi' => 'Lunas',
            ]);
        }

        return redirect()->back()->with('success', 'Backup Plan Berhasil: Pembayaran #' . $pembayaran->id . ' telah di-verifikasi menjadi VALID.');
    }

    public function forceReject($id)
    {
        $pembayaran = Pembayaran::with('transaksi')->findOrFail($id);
        $pembayaran->update([
            'status_verifikasi' => 'Tidak Valid',
            'admin_id' => Admin::where('user_id', auth()->id())->first()?->id,
        ]);

        // If a payment is rolled back to invalid, let's revert transaction status to notify buyer
        $transaksi = $pembayaran->transaksi;
        if ($pembayaran->tipe_pembayaran === 'Booking Fee') {
            $transaksi->update([
                'status_transaksi' => 'Menunggu Pembayaran Booking',
            ]);
        } elseif ($pembayaran->tipe_pembayaran === 'DP') {
            $transaksi->update([
                'status_transaksi' => 'Menunggu DP',
            ]);
        } elseif ($pembayaran->tipe_pembayaran === 'Pelunasan') {
            $transaksi->update([
                'status_transaksi' => 'Menunggu Pelunasan',
            ]);
        }

        return redirect()->back()->with('success', 'Backup Plan Berhasil: Pembayaran #' . $pembayaran->id . ' telah di-tolak menjadi TIDAK VALID.');
    }
}
