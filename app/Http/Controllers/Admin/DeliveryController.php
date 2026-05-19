<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengiriman;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function index()
    {
        // Waiting for buyer to choose delivery method
        $menungguPilihan = Transaksi::with(['mobil', 'pembeli.user'])
            ->where('status_transaksi', 'Lunas')
            ->orderBy('updated_at', 'desc')
            ->get();

        // Buyer has chosen, admin needs to ship/deliver
        $siapKirim = Transaksi::with(['mobil', 'pembeli.user', 'pengiriman'])
            ->where('status_transaksi', 'Mobil Diambil / Dikirim')
            ->orderBy('updated_at', 'desc')
            ->get();

        $selesai = Transaksi::with(['mobil', 'pembeli.user', 'pengiriman'])
            ->where('status_transaksi', 'Transaksi Selesai')
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.delivery', [
            'activePage' => 'delivery',
            'pageTitle' => 'Pengiriman & Penyerahan',
            'menungguPilihan' => $menungguPilihan,
            'siapKirim' => $siapKirim,
            'selesai' => $selesai,
        ]);
    }

    public function updateStatus(Request $request, $transaksiId)
    {
        $transaksi = Transaksi::findOrFail($transaksiId);

        $request->validate([
            'status' => 'required|in:Mobil Diambil / Dikirim,Transaksi Selesai',
            'alamat_tujuan' => 'nullable|string',
            'metode_pengiriman' => 'nullable|string',
            'tgl_pengiriman' => 'nullable|date',
        ]);

        $transaksi->update(['status_transaksi' => $request->status]);

        if ($request->status === 'Transaksi Selesai') {
            $transaksi->mobil->update(['status_mobil' => 'Terjual']);
        }

        // Create or update pengiriman record
        Pengiriman::updateOrCreate(
            ['transaksi_id' => $transaksi->id],
            [
                'metode_pengiriman' => $request->metode_pengiriman ?? 'Pengiriman Mobil',
                'alamat_tujuan' => $request->alamat_tujuan ?? $transaksi->pembeli->alamat,
                'tgl_pengiriman' => $request->tgl_pengiriman,
                'status_pengiriman' => $request->status === 'Transaksi Selesai' ? 'Selesai' : 'Dalam Pengiriman',
            ]
        );

        return redirect()->route('admin.delivery.index')
            ->with('success', 'Status pengiriman berhasil diperbarui!');
    }

    public function suratJalan($transaksiId)
    {
        $transaksi = Transaksi::with(['mobil', 'pembeli', 'pengiriman'])
            ->whereIn('status_transaksi', ['Mobil Diambil / Dikirim', 'Transaksi Selesai'])
            ->findOrFail($transaksiId);

        return view('surat-jalan', compact('transaksi'));
    }
}
