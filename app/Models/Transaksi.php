<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $fillable = ['pembeli_id', 'mobil_id', 'tgl_transaksi', 'batas_pembayaran', 'status_transaksi', 'total_harga'];

    protected $casts = [
        'batas_pembayaran' => 'datetime',
        'tgl_transaksi' => 'datetime',
    ];

    public function pembeli() { return $this->belongsTo(Pembeli::class); }
    public function mobil() { return $this->belongsTo(Mobil::class); }
    public function pembayarans() { return $this->hasMany(Pembayaran::class); }
    public function pengiriman() { return $this->hasOne(Pengiriman::class); }
}
