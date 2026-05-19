<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Mobil;
use App\Models\Pembeli;
use App\Models\Penjual;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin User ──
        $adminUser = User::create([
            'name' => 'Admin DriveHub',
            'username' => 'admin',
            'email' => 'admin@drivehub.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        Admin::create([
            'user_id' => $adminUser->id,
            'nama_lengkap' => 'Admin DriveHub',
            'no_pegawai' => 'ADM-001',
        ]);

        // ── Buyer User ──
        $buyerUser = User::create([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'role' => 'pembeli',
        ]);

        Pembeli::create([
            'user_id' => $buyerUser->id,
            'nama_lengkap' => 'John Doe',
            'alamat' => 'Jl. Sudirman No. 123, Jakarta Selatan',
            'no_hp' => '081234567890',
        ]);

        // ── Seller ──
        $penjual = Penjual::create([
            'nama_penjual' => 'DriveHub Official',
            'alamat' => 'Jakarta',
            'no_hp' => '02112345678',
        ]);

        // ── Cars ──
        $cars = [
            [
                'merk' => 'Honda', 'model' => 'CR-V 1.5 Turbo Prestige',
                'tahun_produksi' => 2020, 'warna' => 'Putih', 'nomor_polisi' => 'B 1234 ABC',
                'deskripsi' => 'Bensin', 'harga' => 485000000, 'transmisi' => 'A/T',
                'kilometer' => 42000, 'status_mobil' => 'Tersedia',
                'gambar' => 'images/cars/honda_crv.png',
            ],
            [
                'merk' => 'Toyota', 'model' => 'Camry 2.5 V',
                'tahun_produksi' => 2021, 'warna' => 'Hitam', 'nomor_polisi' => 'B 5678 DEF',
                'deskripsi' => 'Bensin', 'harga' => 545000000, 'transmisi' => 'A/T',
                'kilometer' => 25000, 'status_mobil' => 'Tersedia',
                'gambar' => 'images/cars/toyota_camry.png',
            ],
            [
                'merk' => 'Hyundai', 'model' => 'Ioniq 5 Signature Long Range',
                'tahun_produksi' => 2023, 'warna' => 'Silver', 'nomor_polisi' => 'B 9012 GHI',
                'deskripsi' => 'Listrik', 'harga' => 750000000, 'transmisi' => 'A/T',
                'kilometer' => 8000, 'status_mobil' => 'Tersedia',
                'gambar' => 'images/cars/hyundai_ioniq5.png',
            ],
            [
                'merk' => 'Mazda', 'model' => 'CX-5 2.5 Elite',
                'tahun_produksi' => 2019, 'warna' => 'Merah', 'nomor_polisi' => 'B 3456 JKL',
                'deskripsi' => 'Bensin', 'harga' => 430000000, 'transmisi' => 'A/T',
                'kilometer' => 55000, 'status_mobil' => 'Tersedia',
                'gambar' => 'images/cars/mazda_cx5.png',
            ],
            [
                'merk' => 'Toyota', 'model' => 'Kijang Innova 2.4 G Diesel',
                'tahun_produksi' => 2018, 'warna' => 'Abu-abu', 'nomor_polisi' => 'B 7890 MNO',
                'deskripsi' => 'Diesel', 'harga' => 320000000, 'transmisi' => 'A/T',
                'kilometer' => 75000, 'status_mobil' => 'Tersedia',
                'gambar' => 'images/cars/toyota_avanza.png',
            ],
            [
                'merk' => 'BMW', 'model' => '320i Sport',
                'tahun_produksi' => 2022, 'warna' => 'Putih', 'nomor_polisi' => 'B 2468 PQR',
                'deskripsi' => 'Bensin', 'harga' => 850000000, 'transmisi' => 'A/T',
                'kilometer' => 15000, 'status_mobil' => 'Tersedia',
                'gambar' => 'images/cars/bmw_320i.png',
            ],
            [
                'merk' => 'Honda', 'model' => 'Brio RS CVT',
                'tahun_produksi' => 2022, 'warna' => 'Kuning', 'nomor_polisi' => 'B 1357 STU',
                'deskripsi' => 'Bensin', 'harga' => 195000000, 'transmisi' => 'A/T',
                'kilometer' => 18000, 'status_mobil' => 'Tersedia',
                'gambar' => 'images/cars/hyundai_ioniq5.png',
            ],
            [
                'merk' => 'Suzuki', 'model' => 'Ertiga GX M/T',
                'tahun_produksi' => 2021, 'warna' => 'Putih', 'nomor_polisi' => 'D 4321 VWX',
                'deskripsi' => 'Bensin', 'harga' => 215000000, 'transmisi' => 'M/T',
                'kilometer' => 35000, 'status_mobil' => 'Tersedia',
                'gambar' => 'images/cars/honda_crv.png',
            ],
            [
                'merk' => 'Toyota', 'model' => 'Avanza Veloz 1.5 A/T',
                'tahun_produksi' => 2022, 'warna' => 'Hitam', 'nomor_polisi' => 'F 8765 YZA',
                'deskripsi' => 'Bensin', 'harga' => 265000000, 'transmisi' => 'A/T',
                'kilometer' => 22000, 'status_mobil' => 'Tersedia',
                'gambar' => 'images/cars/toyota_avanza.png',
            ],
            [
                'merk' => 'Mitsubishi', 'model' => 'Pajero Sport Dakar Ultimate',
                'tahun_produksi' => 2020, 'warna' => 'Hitam', 'nomor_polisi' => 'B 9999 BCD',
                'deskripsi' => 'Diesel', 'harga' => 520000000, 'transmisi' => 'A/T',
                'kilometer' => 48000, 'status_mobil' => 'Tersedia',
                'gambar' => 'images/cars/mazda_cx5.png',
            ],
            [
                'merk' => 'Honda', 'model' => 'Civic RS Turbo',
                'tahun_produksi' => 2023, 'warna' => 'Abu-abu', 'nomor_polisi' => 'B 1111 EFG',
                'deskripsi' => 'Bensin', 'harga' => 615000000, 'transmisi' => 'A/T',
                'kilometer' => 5000, 'status_mobil' => 'Tersedia',
                'gambar' => 'images/cars/toyota_camry.png',
            ],
            [
                'merk' => 'Suzuki', 'model' => 'XL7 Alpha A/T',
                'tahun_produksi' => 2021, 'warna' => 'Biru', 'nomor_polisi' => 'B 2222 HIJ',
                'deskripsi' => 'Bensin', 'harga' => 245000000, 'transmisi' => 'A/T',
                'kilometer' => 28000, 'status_mobil' => 'Tersedia',
                'gambar' => 'images/cars/honda_crv.png',
            ],
        ];

        // Assign images cyclically from available assets
        $images = [
            null, // Will use default fallback in blade
        ];

        foreach ($cars as $car) {
            Mobil::create(array_merge($car, [
                'penjual_id' => $penjual->id,
            ]));
        }
    }
}
