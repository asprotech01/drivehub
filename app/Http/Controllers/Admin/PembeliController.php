<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembeli;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class PembeliController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembeli::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
        }

        $buyers = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.manage-buyers', [
            'activePage' => 'manage-buyers',
            'pageTitle' => 'Kelola Pembeli',
            'buyers' => $buyers,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'foto_ktp' => 'nullable|image|max:5120',
        ]);

        // Auto-create User account
        $slugName = Str::slug($request->nama_lengkap);
        $randomSuffix = rand(100, 999);
        $email = $slugName . $randomSuffix . '@drivehub.com';
        $username = $slugName . rand(10, 99);

        $user = User::create([
            'name' => $request->nama_lengkap,
            'username' => $username,
            'email' => $email,
            'password' => Hash::make('password123'),
            'role' => 'pembeli',
        ]);

        $data = $request->except('foto_ktp');
        $data['user_id'] = $user->id;

        if ($request->hasFile('foto_ktp')) {
            $data['foto_ktp'] = $request->file('foto_ktp')->store('pembeli', 'public');
        }

        Pembeli::create($data);

        return redirect()->route('admin.pembeli.index')
            ->with('success', 'Pembeli berhasil ditambahkan! Akun user otomatis dibuat dengan email: ' . $email);
    }

    public function update(Request $request, $id)
    {
        $pembeli = Pembeli::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'foto_ktp' => 'nullable|image|max:5120',
        ]);

        $data = $request->except('foto_ktp');

        // Also update the linked user's name
        if ($pembeli->user) {
            $pembeli->user->update([
                'name' => $request->nama_lengkap,
            ]);
        }

        if ($request->hasFile('foto_ktp')) {
            $data['foto_ktp'] = $request->file('foto_ktp')->store('pembeli', 'public');
        }

        $pembeli->update($data);

        return redirect()->route('admin.pembeli.index')
            ->with('success', 'Data pembeli berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pembeli = Pembeli::findOrFail($id);

        if ($pembeli->transaksis()->count() > 0) {
            return redirect()->route('admin.pembeli.index')
                ->with('error', 'Pembeli tidak dapat dihapus karena memiliki riwayat transaksi!');
        }

        $user = $pembeli->user;
        $pembeli->delete();

        // Also delete the linked user account if it exists
        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.pembeli.index')
            ->with('success', 'Pembeli beserta akun user berhasil dihapus!');
    }
}
