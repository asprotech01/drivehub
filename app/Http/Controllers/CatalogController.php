<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Mobil::query()->where('status_mobil', '!=', 'Terjual');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('merk', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Filter by brand
        if ($request->filled('merk')) {
            $query->whereIn('merk', (array) $request->merk);
        }

        // Filter by price range
        if ($request->filled('harga_min')) {
            $query->where('harga', '>=', $request->harga_min * 1000000);
        }
        if ($request->filled('harga_max')) {
            $query->where('harga', '<=', $request->harga_max * 1000000);
        }

        // Filter by year
        if ($request->filled('tahun_min')) {
            $query->where('tahun_produksi', '>=', $request->tahun_min);
        }
        if ($request->filled('tahun_max')) {
            $query->where('tahun_produksi', '<=', $request->tahun_max);
        }

        // Filter by transmission
        if ($request->filled('transmisi') && $request->transmisi !== 'Semua') {
            $query->where('transmisi', $request->transmisi);
        }

        // Sort
        switch ($request->sort) {
            case 'harga_asc':
                $query->orderBy('harga', 'asc');
                break;
            case 'harga_desc':
                $query->orderBy('harga', 'desc');
                break;
            case 'tahun_desc':
                $query->orderBy('tahun_produksi', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $mobils = $query->paginate(9);

        $brands = Mobil::where('status_mobil', '!=', 'Terjual')
            ->select('merk')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('merk')
            ->orderBy('count', 'desc')
            ->get();

        return view('catalog', [
            'activePage' => 'catalog',
            'mobils' => $mobils,
            'brands' => $brands,
        ]);
    }

    public function show($id)
    {
        $mobil = Mobil::with('penjual')->findOrFail($id);

        return view('car-detail', [
            'activePage' => 'catalog',
            'mobil' => $mobil,
        ]);
    }
}
