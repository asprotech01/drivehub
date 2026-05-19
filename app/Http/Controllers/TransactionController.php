<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function status()
    {
        $transaksis = collect();

        if (Auth::check()) {
            $transaksis = Transaksi::with(['mobil', 'pembayarans', 'pengiriman'])
                ->whereHas('pembeli', fn($q) => $q->where('user_id', Auth::id()))
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('transaction-status', [
            'activePage' => 'transaction',
            'transaksis' => $transaksis,
            'transaksi' => $transaksis->first(),
        ]);
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['mobil', 'pembayarans', 'pembeli', 'pengiriman'])
            ->whereHas('pembeli', fn($q) => $q->where('user_id', Auth::id()))
            ->findOrFail($id);

        return view('transaction-status', [
            'activePage' => 'transaction',
            'transaksi' => $transaksi,
            'transaksis' => collect([$transaksi]),
        ]);
    }

    public function updateDeliveryChoice(Request $request, $id)
    {
        $request->validate([
            'metode_pengiriman' => 'required|in:Ambil di Showroom,Kirim ke Rumah',
        ]);

        $transaksi = Transaksi::with('pembeli')
            ->whereHas('pembeli', fn($q) => $q->where('user_id', Auth::id()))
            ->where('status_transaksi', 'Lunas')
            ->findOrFail($id);

        // Update transaction status
        $transaksi->update(['status_transaksi' => 'Mobil Diambil / Dikirim']);

        // Create pengiriman record
        \App\Models\Pengiriman::updateOrCreate(
            ['transaksi_id' => $transaksi->id],
            [
                'metode_pengiriman' => $request->metode_pengiriman === 'Kirim ke Rumah' ? 'Pengiriman Mobil' : 'Ambil di Showroom',
                'alamat_tujuan' => $request->metode_pengiriman === 'Kirim ke Rumah' ? $transaksi->pembeli->alamat : 'Showroom DriveHub',
                'status_pengiriman' => 'Menunggu Diproses',
            ]
        );

        return redirect()->route('transaction.show', $transaksi->id)
            ->with('success', 'Pilihan pengiriman berhasil disimpan! Tim kami akan segera menyiapkan unit Anda.');
    }

    public function cancel($id)
    {
        $transaksi = Transaksi::with('mobil')
            ->whereHas('pembeli', fn($q) => $q->where('user_id', Auth::id()))
            ->where('status_transaksi', 'Booking Berhasil')
            ->findOrFail($id);

        // Reset car status
        $transaksi->mobil->update(['status_mobil' => 'Tersedia']);

        // Update transaction status
        $transaksi->update(['status_transaksi' => 'Dibatalkan']);

        return redirect()->route('transaction.status')
            ->with('success', 'Pesanan Anda telah dibatalkan. Pengembalian dana Booking Fee akan diproses oleh admin.');
    }

    public function confirmReceipt($id)
    {
        $transaksi = Transaksi::with(['mobil', 'pengiriman'])
            ->whereHas('pembeli', fn($q) => $q->where('user_id', Auth::id()))
            ->where('status_transaksi', 'Mobil Diambil / Dikirim')
            ->findOrFail($id);

        $transaksi->update(['status_transaksi' => 'Transaksi Selesai']);
        $transaksi->mobil->update(['status_mobil' => 'Terjual']);

        if ($transaksi->pengiriman) {
            $transaksi->pengiriman->update(['status_pengiriman' => 'Selesai']);
        }

        return redirect()->route('transaction.show', $transaksi->id)
            ->with('success', 'Selamat! Anda telah mengonfirmasi penerimaan mobil. Proses transaksi kini resmi selesai.');
    }

    public function kwitansi($id, $pembayaranId)
    {
        $transaksi = Transaksi::with(['mobil', 'pembeli'])
            ->whereHas('pembeli', fn($q) => $q->where('user_id', Auth::id()))
            ->findOrFail($id);

        $pembayaran = \App\Models\Pembayaran::where('transaksi_id', $transaksi->id)
            ->where('status_verifikasi', 'Valid')
            ->findOrFail($pembayaranId);

        return view('kwitansi', compact('transaksi', 'pembayaran'));
    }
}
