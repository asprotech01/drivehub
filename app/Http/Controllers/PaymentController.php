<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function create($transaksiId)
    {
        $transaksi = Transaksi::with(['mobil', 'pembeli'])
            ->whereHas('pembeli', fn($q) => $q->where('user_id', Auth::id()))
            ->findOrFail($transaksiId);

        $paymentType = 'Booking Fee';
        $amount = 500000;

        if (in_array($transaksi->status_transaksi, ['Booking Berhasil', 'Menunggu DP'])) {
            $paymentType = 'DP';
            $amount = $transaksi->total_harga * 0.3;
        } elseif (in_array($transaksi->status_transaksi, ['DP Berhasil', 'Menunggu Pelunasan'])) {
            $paymentType = 'Pelunasan';
            // Total - Booking Fee (500rb) - DP (30%)
            $amount = $transaksi->total_harga - 500000 - ($transaksi->total_harga * 0.3);
        }

        return view('payment-upload', [
            'transaksi' => $transaksi,
            'paymentType' => $paymentType,
            'amount' => $amount,
        ]);
    }



    public function cancelBooking($id)
{
    $transaksi = Transaksi::with(['pembayarans', 'mobil', 'pembeli'])
        ->findOrFail($id);

    if ($transaksi->pembeli->user_id !== auth()->id()) {
        abort(403);
    }

    $bookingPayment = $transaksi->pembayarans
        ->where('tipe_pembayaran', 'Booking Fee')
        ->first();

    if (!$bookingPayment || $bookingPayment->status_verifikasi !== 'Menunggu Verifikasi') {
        return back()->with('error', 'Booking tidak dapat dibatalkan.');
    }

    $transaksi->update([
    'status_transaksi' => 'Dibatalkan'
]);

$bookingPayment->update([
    'status_verifikasi' => 'Dibatalkan'
]);

if ($transaksi->mobil) {
    $transaksi->mobil->update([
        'status_mobil' => 'Tersedia'
    ]);
}

    return redirect()
        ->route('transaction.show', $transaksi->id)
        ->with('success', 'Booking berhasil dibatalkan.');
}

    public function store(Request $request, $transaksiId)
    {
        $transaksi = Transaksi::with('pembeli')
            ->whereHas('pembeli', fn($q) => $q->where('user_id', Auth::id()))
            ->findOrFail($transaksiId);

        $rules = [
            'bukti_pembayaran' => 'required|image|max:5120',
        ];

        // If paying DP, KTP is required
        $isDP = in_array($transaksi->status_transaksi, ['Booking Berhasil', 'Menunggu DP']);
        if ($isDP) {
            $rules['foto_ktp'] = 'required|image|max:5120';
        }

        $request->validate($rules);

        $path = $request->file('bukti_pembayaran')->store('bukti-pembayaran', 'public');

        $paymentType = 'Booking Fee';
        $amount = 500000;

        if ($isDP) {
            $paymentType = 'DP';
            $amount = $transaksi->total_harga * 0.3;
            
            // Save KTP to pembeli profile
            if ($request->hasFile('foto_ktp')) {
                $ktpPath = $request->file('foto_ktp')->store('ktp', 'public');
                $transaksi->pembeli->update(['foto_ktp' => $ktpPath]);
            }
        } elseif (in_array($transaksi->status_transaksi, ['DP Berhasil', 'Menunggu Pelunasan'])) {
            $paymentType = 'Pelunasan';
            $amount = $transaksi->total_harga - 500000 - ($transaksi->total_harga * 0.3);
        }

        Pembayaran::create([
            'transaksi_id' => $transaksi->id,
            'tipe_pembayaran' => $paymentType,
            'metode_bayar' => 'Transfer Bank',
            'tgl_bayar' => now(),
            'jumlah_bayar' => $amount,
            'status_verifikasi' => 'Menunggu Verifikasi',
            'bukti_pembayaran' => $path,
        ]);

        return redirect()->route('transaction.show', $transaksi->id)
            ->with('success', 'Bukti pembayaran ' . $paymentType . ' berhasil diupload! Menunggu verifikasi admin.');
    }
}
