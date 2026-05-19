<?php
$modelsPath = __DIR__ . '/app/Models';

$models = [
    'Pembeli' => [
        'table' => 'pembeli',
        'fillable' => ['user_id', 'nama_lengkap', 'alamat', 'no_hp', 'foto_ktp'],
        'relations' => "public function user() { return \$this->belongsTo(User::class); }\n    public function transaksis() { return \$this->hasMany(Transaksi::class); }"
    ],
    'Admin' => [
        'table' => 'admin',
        'fillable' => ['user_id', 'nama_lengkap', 'no_pegawai'],
        'relations' => "public function user() { return \$this->belongsTo(User::class); }"
    ],
    'Penjual' => [
        'table' => 'penjual',
        'fillable' => ['nama_penjual', 'alamat', 'no_hp'],
        'relations' => "public function mobils() { return \$this->hasMany(Mobil::class); }"
    ],
    'Mobil' => [
        'table' => 'mobil',
        'fillable' => ['penjual_id', 'merk', 'model', 'tahun_produksi', 'warna', 'nomor_polisi', 'deskripsi', 'harga', 'transmisi', 'kilometer', 'gambar', 'status_mobil', 'status_stnk', 'status_bpkb'],
        'relations' => "public function penjual() { return \$this->belongsTo(Penjual::class); }\n    public function transaksis() { return \$this->hasMany(Transaksi::class); }"
    ],
    'Transaksi' => [
        'table' => 'transaksi',
        'fillable' => ['pembeli_id', 'mobil_id', 'tgl_transaksi', 'batas_pembayaran', 'status_transaksi', 'total_harga'],
        'relations' => "public function pembeli() { return \$this->belongsTo(Pembeli::class); }\n    public function mobil() { return \$this->belongsTo(Mobil::class); }\n    public function pembayarans() { return \$this->hasMany(Pembayaran::class); }\n    public function pengiriman() { return \$this->hasOne(Pengiriman::class); }"
    ],
    'Pembayaran' => [
        'table' => 'pembayaran',
        'fillable' => ['transaksi_id', 'admin_id', 'tipe_pembayaran', 'metode_bayar', 'tgl_bayar', 'jumlah_bayar', 'status_verifikasi', 'bukti_pembayaran', 'catatan'],
        'relations' => "public function transaksi() { return \$this->belongsTo(Transaksi::class); }\n    public function admin() { return \$this->belongsTo(Admin::class); }\n    public function kwitansi() { return \$this->hasOne(Kwitansi::class); }"
    ],
    'Pengiriman' => [
        'table' => 'pengiriman',
        'fillable' => ['transaksi_id', 'metode_pengiriman', 'alamat_tujuan', 'status_pengiriman'],
        'relations' => "public function transaksi() { return \$this->belongsTo(Transaksi::class); }\n    public function suratJalan() { return \$this->hasOne(SuratJalan::class); }"
    ],
    'SuratJalan' => [
        'table' => 'surat_jalan',
        'fillable' => ['pengiriman_id', 'no_surat_jalan', 'tanggal_kirim', 'alamat_tujuan', 'status_pengiriman'],
        'relations' => "public function pengiriman() { return \$this->belongsTo(Pengiriman::class); }"
    ],
    'Kwitansi' => [
        'table' => 'kwitansi',
        'fillable' => ['pembayaran_id', 'no_kwitansi', 'tanggal', 'jumlah'],
        'relations' => "public function pembayaran() { return \$this->belongsTo(Pembayaran::class); }"
    ]
];

foreach ($models as $name => $data) {
    $fillables = "'" . implode("', '", $data['fillable']) . "'";
    $content = "<?php\n\nnamespace App\Models;\n\nuse Illuminate\Database\Eloquent\Factories\HasFactory;\nuse Illuminate\Database\Eloquent\Model;\n\nclass $name extends Model\n{\n    use HasFactory;\n\n    protected \$table = '{$data['table']}';\n    protected \$fillable = [$fillables];\n\n    {$data['relations']}\n}\n";
    file_put_contents("$modelsPath/$name.php", $content);
}

// Update User model
$userModelPath = $modelsPath . '/User.php';
$userContent = file_get_contents($userModelPath);
if (!str_contains($userContent, 'role')) {
    $userContent = str_replace("'name',", "'name', 'username', 'role',", $userContent);
    $userContent = str_replace("class User extends Authenticatable\n{", "class User extends Authenticatable\n{\n    public function pembeli() { return \$this->hasOne(Pembeli::class); }\n    public function admin() { return \$this->hasOne(Admin::class); }\n", $userContent);
    file_put_contents($userModelPath, $userContent);
}

echo "Models generated.\n";
