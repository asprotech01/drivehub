<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penjual;
use Illuminate\Http\Request;

class PenjualController extends Controller
{
    public function index(Request $request)
    {
        $query = Penjual::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_penjual', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
        }

        $sellers = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.manage-sellers', [
            'activePage' => 'manage-sellers',
            'pageTitle' => 'Kelola Penjual',
            'sellers' => $sellers,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_penjual' => 'required|string|max:100',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:20',
        ]);

        Penjual::create($request->all());

        return redirect()->route('admin.penjual.index')
            ->with('success', 'Penjual berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $penjual = Penjual::findOrFail($id);

        $request->validate([
            'nama_penjual' => 'required|string|max:100',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:20',
        ]);

        $penjual->update($request->all());

        return redirect()->route('admin.penjual.index')
            ->with('success', 'Data penjual berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $penjual = Penjual::findOrFail($id);
        
        // Prevent deletion if the seller still has registered cars
        if ($penjual->mobils()->count() > 0) {
            return redirect()->route('admin.penjual.index')
                ->with('error', 'Penjual tidak dapat dihapus karena memiliki mobil terdaftar!');
        }

        $penjual->delete();

        return redirect()->route('admin.penjual.index')
            ->with('success', 'Penjual berhasil dihapus!');
    }
}
