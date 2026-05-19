<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratJalan extends Model
{
    use HasFactory;

    protected $table = 'surat_jalan';
    protected $fillable = ['pengiriman_id', 'no_surat_jalan', 'tanggal_kirim', 'alamat_tujuan', 'status_pengiriman'];

    public function pengiriman() { return $this->belongsTo(Pengiriman::class); }
}
