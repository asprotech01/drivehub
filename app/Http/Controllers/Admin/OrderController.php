<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['mobil', 'pembeli']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('status_transaksi', 'like', "%{$search}%")
                  ->orWhereHas('pembeli', function ($q) use ($search) {
                      $q->where('nama_lengkap', 'like', "%{$search}%");
                  })
                  ->orWhereHas('mobil', function ($q) use ($search) {
                      $q->where('merk', 'like', "%{$search}%")
                        ->orWhere('model', 'like', "%{$search}%")
                        ->orWhere('nomor_polisi', 'like', "%{$search}%");
                  });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.manage-orders', [
            'activePage' => 'manage-orders',
            'pageTitle' => 'Kelola Data Pesanan',
            'orders' => $orders,
        ]);
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['mobil', 'pembeli.user', 'pembayarans', 'pengiriman'])
            ->findOrFail($id);

        return view('admin.order-detail', [
            'activePage' => 'manage-orders',
            'pageTitle' => 'Detail Pesanan',
            'transaksi' => $transaksi,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'status_transaksi' => 'required|string',
        ]);

        $transaksi->update([
            'status_transaksi' => $request->status_transaksi,
        ]);

        // If transaction is cancelled, free up the car
        if ($request->status_transaksi === 'Dibatalkan') {
            $transaksi->mobil->update(['status_mobil' => 'Tersedia']);
        }

        return redirect()->route('admin.orders.show', $transaksi->id)
            ->with('success', 'Status transaksi berhasil diperbarui!');
    }

    public function kwitansi($id, $pembayaranId)
    {
        $transaksi = Transaksi::with(['mobil', 'pembeli'])
            ->findOrFail($id);

        $pembayaran = Pembayaran::where('transaksi_id', $transaksi->id)
            ->where('status_verifikasi', 'Valid')
            ->findOrFail($pembayaranId);

        return view('kwitansi', compact('transaksi', 'pembayaran'));
    }
}
