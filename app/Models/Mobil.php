<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;

    protected $table = 'mobil';
    protected $fillable = ['penjual_id', 'merk', 'model', 'tahun_produksi', 'warna', 'nomor_polisi', 'deskripsi', 'harga', 'transmisi', 'kilometer', 'gambar', 'status_mobil', 'status_stnk', 'status_bpkb'];

    public function penjual() { return $this->belongsTo(Penjual::class); }
    public function transaksis() { return $this->hasMany(Transaksi::class); }

    public function getGambarUrlAttribute()
    {
        if ($this->gambar) {
            if (str_starts_with($this->gambar, 'images/')) {
                return asset($this->gambar);
            }
            return asset('storage/' . $this->gambar);
        }
        return asset('images/cars/honda_crv.png');
    }
}
