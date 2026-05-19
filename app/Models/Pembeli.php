<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembeli extends Model
{
    use HasFactory;

    protected $table = 'pembeli';
    protected $fillable = ['user_id', 'nama_lengkap', 'alamat', 'no_hp', 'foto_ktp'];

    public function user() { return $this->belongsTo(User::class); }
    public function transaksis() { return $this->hasMany(Transaksi::class); }
}
