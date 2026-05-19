<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;

    protected $table = 'pengiriman';
    protected $fillable = ['transaksi_id', 'metode_pengiriman', 'alamat_tujuan', 'status_pengiriman', 'tgl_pengiriman'];
    
    protected $casts = [
        'tgl_pengiriman' => 'date',
    ];

    public function transaksi() { return $this->belongsTo(Transaksi::class); }
    public function suratJalan() { return $this->hasOne(SuratJalan::class); }
}
