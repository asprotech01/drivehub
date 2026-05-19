<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Pembeli;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function create($mobilId)
    {
        $mobil = Mobil::where('status_mobil', 'Tersedia')->findOrFail($mobilId);

        return view('booking', [
            'mobil' => $mobil,
        ]);
    }

    public function store(Request $request, $mobilId)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'email' => 'required|email',
            'alamat' => 'required|string',
        ]);

        $mobil = Mobil::where('status_mobil', 'Tersedia')->findOrFail($mobilId);

        // Create or update pembeli profile (without KTP for now)
        $pembeli = Pembeli::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'nama_lengkap' => $request->nama_lengkap,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
            ]
        );

        // Create transaction
        $transaksi = Transaksi::create([
            'pembeli_id' => $pembeli->id,
            'mobil_id' => $mobil->id,
            'tgl_transaksi' => now(),
            'batas_pembayaran' => now()->addHours(24), // Deadline to pay booking fee
            'status_transaksi' => 'Menunggu Pembayaran Booking',
            'total_harga' => $mobil->harga,
        ]);

        // Update car status
        $mobil->update(['status_mobil' => 'Booked']);

        return redirect()->route('payment.create', $transaksi->id)
            ->with('success', 'Booking berhasil! Silakan bayar Booking Fee sebesar Rp 500.000.');
    }
}
