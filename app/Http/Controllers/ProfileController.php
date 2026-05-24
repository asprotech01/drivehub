<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pembeli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show the user profile page.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Ensure regular user has a Pembeli record, load it
        $pembeli = null;
        if ($user->role === 'pembeli') {
            $pembeli = $user->pembeli;
            
            // If doesn't exist, create an empty one
            if (!$pembeli) {
                $pembeli = Pembeli::create([
                    'user_id' => $user->id,
                    'nama_lengkap' => $user->name,
                    'no_hp' => '',
                    'alamat' => '',
                ]);
            }
        }

        return view('profile', [
            'activePage' => 'profile',
            'user' => $user,
            'pembeli' => $pembeli,
        ]);
    }

    /**
     * Update the user profile data.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:user,email,' . $user->id,
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'foto_ktp' => 'nullable|image|max:2048', // Max 2MB
        ];

        // If user wants to change password
        if ($request->filled('new_password')) {
            $rules['old_password'] = 'required|string';
            $rules['new_password'] = 'required|string|min:8|confirmed';
        }

        $request->validate($rules, [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah digunakan oleh pengguna lain.',
            'no_hp.required' => 'Nomor WhatsApp wajib diisi.',
            'alamat.required' => 'Alamat lengkap wajib diisi.',
            'foto_ktp.image' => 'Berkas KTP harus berupa gambar.',
            'foto_ktp.max' => 'Ukuran gambar KTP maksimal 2MB.',
            'old_password.required' => 'Kata sandi saat ini wajib diisi jika ingin mengubah kata sandi.',
            'new_password.required' => 'Kata sandi baru wajib diisi.',
            'new_password.min' => 'Kata sandi baru minimal harus 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        // Check current password if new password is being set
        if ($request->filled('new_password')) {
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'Kata sandi saat ini salah.'])->withInput();
            }
            
            $user->password = Hash::make($request->new_password);
        }

        // Update User
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        // Update Pembeli
        if ($user->role === 'pembeli') {
            $pembeli = $user->pembeli ?: new Pembeli(['user_id' => $user->id]);
            
            $pembeli->nama_lengkap = $request->name;
            $pembeli->no_hp = $request->no_hp;
            $pembeli->alamat = $request->alamat;

            // Handle KTP Upload
            if ($request->hasFile('foto_ktp')) {
                // Delete old KTP if exists
                if ($pembeli->foto_ktp) {
                    Storage::disk('public')->delete($pembeli->foto_ktp);
                }
                
                $ktpPath = $request->file('foto_ktp')->store('ktp', 'public');
                $pembeli->foto_ktp = $ktpPath;
            }

            $pembeli->save();
        }

        return redirect()->route('profile.index')->with('success', 'Profil Anda berhasil diperbarui!');
    }
}
