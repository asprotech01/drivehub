<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Mobil::with('transaksis.pembeli');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('merk', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('nomor_polisi', 'like', "%{$search}%");
        }

        $cars = $query->orderBy('updated_at', 'desc')->paginate(10);

        return view('admin.manage-documents', [
            'activePage' => 'manage-documents',
            'pageTitle' => 'Kelola Dokumen Kendaraan',
            'cars' => $cars,
        ]);
    }

    public function update(Request $request, $id)
    {
        $car = Mobil::findOrFail($id);

        $request->validate([
            'status_stnk' => 'required|string|max:100',
            'status_bpkb' => 'required|string|max:100',
        ]);

        $car->update([
            'status_stnk' => $request->status_stnk,
            'status_bpkb' => $request->status_bpkb,
        ]);

        return redirect()->route('admin.documents.index')
            ->with('success', 'Status dokumen kendaraan berhasil diperbarui!');
    }
}
