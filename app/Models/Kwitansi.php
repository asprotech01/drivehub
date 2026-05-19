<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kwitansi extends Model
{
    use HasFactory;

    protected $table = 'kwitansi';
    protected $fillable = ['pembayaran_id', 'no_kwitansi', 'tanggal', 'jumlah'];

    public function pembayaran() { return $this->belongsTo(Pembayaran::class); }
}
