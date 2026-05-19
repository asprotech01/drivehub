<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $fillable = ['transaksi_id', 'admin_id', 'tipe_pembayaran', 'metode_bayar', 'tgl_bayar', 'jumlah_bayar', 'status_verifikasi', 'bukti_pembayaran', 'catatan'];

    public function transaksi() { return $this->belongsTo(Transaksi::class); }
    public function admin() { return $this->belongsTo(Admin::class); }
    public function kwitansi() { return $this->hasOne(Kwitansi::class); }
}
