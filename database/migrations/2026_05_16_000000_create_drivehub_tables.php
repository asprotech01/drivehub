<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Update user table
        Schema::table('user', function (Blueprint $table) {
            $table->string('username')->after('name')->nullable();
            $table->enum('role', ['pembeli', 'admin', 'penjual'])->default('pembeli')->after('password');
        });

        // Table pembeli
        Schema::create('pembeli', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->text('alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('foto_ktp')->nullable();
            $table->timestamps();
        });

        // Table admin
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->string('no_pegawai')->nullable();
            $table->timestamps();
        });

        // Table penjual
        Schema::create('penjual', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penjual');
            $table->text('alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->timestamps();
        });

        // Table mobil
        Schema::create('mobil', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penjual_id')->nullable()->constrained('penjual')->onDelete('set null');
            $table->string('merk');
            $table->string('model');
            $table->integer('tahun_produksi');
            $table->string('warna');
            $table->string('nomor_polisi');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 15, 2);
            $table->string('transmisi');
            $table->integer('kilometer');
            $table->string('gambar')->nullable();
            $table->enum('status_mobil', ['Tersedia', 'Booked', 'Terjual'])->default('Tersedia');
            $table->enum('status_stnk', ['Ada', 'Tidak Ada'])->default('Ada');
            $table->enum('status_bpkb', ['Ada', 'Tidak Ada'])->default('Ada');
            $table->timestamps();
        });

        // Table transaksi
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembeli_id')->constrained('pembeli')->onDelete('cascade');
            $table->foreignId('mobil_id')->constrained('mobil')->onDelete('cascade');
            $table->dateTime('tgl_transaksi');
            $table->dateTime('batas_pembayaran')->nullable();
            $table->enum('status_transaksi', [
                'Menunggu Pembayaran Booking', 
                'Booking Berhasil', 
                'Menunggu DP', 
                'DP Berhasil', 
                'Menunggu Pelunasan', 
                'Lunas', 
                'Mobil Diambil / Dikirim',
                'Transaksi Selesai',
                'Dibatalkan'
            ])->default('Menunggu Pembayaran Booking');
            $table->decimal('total_harga', 15, 2);
            $table->timestamps();
        });

        // Table pembayaran
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('transaksi')->onDelete('cascade');
            $table->foreignId('admin_id')->nullable()->constrained('admin')->onDelete('set null');
            $table->enum('tipe_pembayaran', ['Booking Fee', 'DP', 'Pelunasan']);
            $table->enum('metode_bayar', ['Transfer Bank', 'Cash', 'Kredit']);
            $table->dateTime('tgl_bayar')->nullable();
            $table->decimal('jumlah_bayar', 15, 2);
            $table->enum('status_verifikasi', ['Menunggu Verifikasi', 'Valid', 'Tidak Valid'])->default('Menunggu Verifikasi');
            $table->string('bukti_pembayaran')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        // Table pengiriman
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('transaksi')->onDelete('cascade');
            $table->enum('metode_pengiriman', ['Ambil di Showroom', 'Pengiriman Mobil']);
            $table->text('alamat_tujuan')->nullable();
            $table->date('tgl_pengiriman')->nullable();
            $table->enum('status_pengiriman', ['Menunggu Diproses', 'Dalam Pengiriman', 'Selesai'])->default('Menunggu Diproses');
            $table->timestamps();
        });

        // Table surat_jalan
        Schema::create('surat_jalan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengiriman_id')->constrained('pengiriman')->onDelete('cascade');
            $table->string('no_surat_jalan');
            $table->dateTime('tanggal_kirim');
            $table->text('alamat_tujuan');
            $table->enum('status_pengiriman', ['Menyiapkan', 'Dikirim', 'Selesai'])->default('Menyiapkan');
            $table->timestamps();
        });

        // Table kwitansi
        Schema::create('kwitansi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembayaran_id')->constrained('pembayaran')->onDelete('cascade');
            $table->string('no_kwitansi');
            $table->dateTime('tanggal');
            $table->decimal('jumlah', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kwitansi');
        Schema::dropIfExists('surat_jalan');
        Schema::dropIfExists('pengiriman');
        Schema::dropIfExists('pembayaran');
        Schema::dropIfExists('transaksi');
        Schema::dropIfExists('mobil');
        Schema::dropIfExists('penjual');
        Schema::dropIfExists('admin');
        Schema::dropIfExists('pembeli');

        Schema::table('user', function (Blueprint $table) {
            $table->dropColumn(['username', 'role']);
        });
    }
};
