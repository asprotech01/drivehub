<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use Illuminate\Http\Request;

class MobilController extends Controller
{
    public function index(Request $request)
    {
        $query = Mobil::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('merk', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }

        $mobils = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.manage-cars', [
            'activePage' => 'manage-cars',
            'pageTitle' => 'Kelola Mobil',
            'mobils' => $mobils,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'merk' => 'required|string|max:100',
            'model' => 'required|string|max:255',
            'tahun_produksi' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'warna' => 'required|string|max:50',
            'nomor_polisi' => 'required|string|max:20',
            'harga' => 'required|numeric|min:0',
            'transmisi' => 'required|string',
            'kilometer' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:5120',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('mobil', 'public');
        }

        Mobil::create($data);

        return redirect()->route('admin.mobil.index')
            ->with('success', 'Mobil berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $mobil = Mobil::findOrFail($id);

        $request->validate([
            'merk' => 'required|string|max:100',
            'model' => 'required|string|max:255',
            'tahun_produksi' => 'required|integer',
            'warna' => 'required|string|max:50',
            'nomor_polisi' => 'required|string|max:20',
            'harga' => 'required|numeric|min:0',
            'transmisi' => 'required|string',
            'kilometer' => 'required|integer|min:0',
            'status_mobil' => 'nullable|string|in:Tersedia,Booked,Terjual',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:5120',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('mobil', 'public');
        }

        $mobil->update($data);

        return redirect()->route('admin.mobil.index')
            ->with('success', 'Data mobil berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $mobil = Mobil::findOrFail($id);
        $mobil->delete();

        return redirect()->route('admin.mobil.index')
            ->with('success', 'Mobil berhasil dihapus!');
    }
}
