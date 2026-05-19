@extends('layouts.admin')
@section('title', 'Detail Pesanan - Admin DriveHub')
@section('content')
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 font-semibold transition-colors">
            <i class='bx bx-left-arrow-alt text-2xl'></i> Kembali ke Daftar Pesanan
        </a>
    </div>

    <!-- Header Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Detail Info (Left Column - 2/3 Width) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Unit & Transaction Info -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-6">
                <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                    <div>
                        <h2 class="text-xl font-bold text-dark">Detail Kendaraan & Pesanan</h2>
                        <p class="text-xs text-gray-400 font-mono">#TRX-{{ str_pad($transaksi->id, 4, '0', STR_PAD_LEFT) }} • {{ $transaksi->tgl_transaksi->format('d M Y H:i') }}</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-6">
                    <img src="{{ $transaksi->mobil->gambar_url }}" class="w-full sm:w-48 h-36 object-cover rounded-2xl shadow-sm border border-gray-100 shrink-0">
                    <div class="flex-1 space-y-3">
                        <h3 class="text-lg font-black text-dark">{{ $transaksi->mobil->merk }} {{ $transaksi->mobil->model }}</h3>
                        <div class="grid grid-cols-2 gap-y-2 text-sm text-gray-600">
                            <div>
                                <span class="text-gray-400 block text-xs font-semibold uppercase">No. Polisi (Plat)</span>
                                <span class="font-bold text-dark font-mono">{{ $transaksi->mobil->nomor_polisi }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-xs font-semibold uppercase">Tahun Produksi</span>
                                <span class="font-bold text-dark">{{ $transaksi->mobil->tahun_produksi }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-xs font-semibold uppercase">Transmisi / Warna</span>
                                <span class="font-bold text-dark">{{ $transaksi->mobil->transmisi }} • {{ $transaksi->mobil->warna }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-xs font-semibold uppercase">Kilometer</span>
                                <span class="font-bold text-dark">{{ number_format($transaksi->mobil->kilometer, 0, ',', '.') }} Km</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-2xl p-4 flex justify-between items-center">
                    <span class="text-sm text-gray-500 font-semibold">Total Nilai Transaksi:</span>
                    <span class="text-2xl font-black text-primary">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Customer Profile -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
                <h2 class="text-xl font-bold text-dark border-b border-gray-100 pb-3">Profil Pembeli</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                    <div>
                        <span class="text-gray-400 block text-xs font-semibold uppercase">Nama Lengkap</span>
                        <span class="font-bold text-dark text-base">{{ $transaksi->pembeli->nama_lengkap }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400 block text-xs font-semibold uppercase">No. Telepon / HP</span>
                        <span class="font-bold text-dark text-base">{{ $transaksi->pembeli->no_hp ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400 block text-xs font-semibold uppercase">Akun Sistem</span>
                        <span class="font-bold text-dark">{{ $transaksi->pembeli->user->name }} ({{ $transaksi->pembeli->user->email }})</span>
                    </div>
                    <div>
                        <span class="text-gray-400 block text-xs font-semibold uppercase">Alamat Pengiriman</span>
                        <span class="font-bold text-dark leading-relaxed">{{ $transaksi->pembeli->alamat ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment List & Receipts panel -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
                <h2 class="text-xl font-bold text-dark border-b border-gray-100 pb-3">Daftar Pembayaran & Kwitansi Resmi</h2>
                <div class="space-y-4">
                    @forelse($transaksi->pembayarans as $pembayaran)
                    <div class="border border-gray-100 rounded-2xl p-5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-gray-50/20 group hover:border-primary/20 hover:bg-white transition-all duration-300">
                        <div class="space-y-1.5">
                            <div class="flex items-center gap-2.5">
                                <span class="bg-primary/5 text-primary text-xs font-black px-2.5 py-1 rounded-md uppercase tracking-wider">{{ $pembayaran->tipe_pembayaran }}</span>
                                @php
                                    $verifyColor = match($pembayaran->status_verifikasi) {
                                        'Valid' => 'bg-green-50 text-green-700 border-green-100',
                                        'Tidak Valid' => 'bg-red-50 text-red-700 border-red-100',
                                        default => 'bg-yellow-50 text-yellow-700 border-yellow-100',
                                    };
                                @endphp
                                <span class="{{ $verifyColor }} text-[10px] font-bold px-2 py-0.5 rounded-full border">
                                    {{ $pembayaran->status_verifikasi }}
                                </span>
                            </div>
                            <div class="text-lg font-black text-dark">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</div>
                            <div class="text-xs text-gray-500 font-semibold">
                                Metode: {{ $pembayaran->metode_bayar }} • Tanggal: {{ $pembayaran->tgl_bayar ? \Carbon\Carbon::parse($pembayaran->tgl_bayar)->format('d M Y') : 'N/A' }}
                            </div>
                        </div>

                        <div>
                            @if($pembayaran->status_verifikasi === 'Valid')
                                <a href="{{ route('admin.orders.kwitansi', [$transaksi->id, $pembayaran->id]) }}" target="_blank" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-green-500 text-white hover:bg-green-600 px-4 py-2.5 rounded-xl text-xs font-black transition-colors shadow-sm">
                                    <i class='bx bx-printer text-base'></i> Cetak Kwitansi
                                </a>
                            @else
                                <span class="text-xs text-gray-400 font-semibold italic">Kwitansi akan aktif setelah Pembayaran diverifikasi Valid</span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-400 border border-dashed border-gray-200 rounded-2xl">
                        <i class='bx bx-wallet text-4xl mb-2 text-gray-300'></i>
                        <p class="text-xs font-bold text-gray-500">Belum ada riwayat pembayaran untuk pesanan ini.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Side Panel (Order Status & Control) -->
        <div class="space-y-6">
            <!-- Current Status Box -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest leading-none">Status Transaksi Saat Ini</h3>
                @php
                    $statusColor = match($transaksi->status_transaksi) {
                        'Menunggu Pembayaran Booking' => 'bg-yellow-50 text-yellow-700 border-yellow-100',
                        'Booking Berhasil' => 'bg-blue-50 text-blue-700 border-blue-100',
                        'Menunggu DP' => 'bg-amber-50 text-amber-700 border-amber-100',
                        'DP Berhasil' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                        'Menunggu Pelunasan' => 'bg-orange-50 text-orange-700 border-orange-100',
                        'Lunas' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                        'Mobil Diambil / Dikirim' => 'bg-teal-50 text-teal-700 border-teal-100',
                        'Transaksi Selesai' => 'bg-green-100 text-green-800 border-green-200',
                        'Dibatalkan' => 'bg-red-50 text-red-700 border-red-100',
                        default => 'bg-gray-50 text-gray-700 border-gray-100',
                    };
                @endphp
                <div class="{{ $statusColor }} text-center py-4 rounded-2xl border text-base font-black tracking-wide">
                    {{ $transaksi->status_transaksi }}
                </div>
            </div>

            <!-- Status Control Form -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
                <h3 class="text-base font-bold text-dark border-b border-gray-100 pb-3">Perbarui Status Transaksi</h3>
                <form action="{{ route('admin.orders.updateStatus', $transaksi->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-2 uppercase">Pilih Status Baru</label>
                        <select name="status_transaksi" required class="w-full border border-gray-200 rounded-xl px-3 py-3 text-sm focus:border-primary outline-none text-dark font-semibold">
                            <option value="Menunggu Pembayaran Booking" {{ $transaksi->status_transaksi === 'Menunggu Pembayaran Booking' ? 'selected' : '' }}>Menunggu Pembayaran Booking</option>
                            <option value="Booking Berhasil" {{ $transaksi->status_transaksi === 'Booking Berhasil' ? 'selected' : '' }}>Booking Berhasil</option>
                            <option value="Menunggu DP" {{ $transaksi->status_transaksi === 'Menunggu DP' ? 'selected' : '' }}>Menunggu DP</option>
                            <option value="DP Berhasil" {{ $transaksi->status_transaksi === 'DP Berhasil' ? 'selected' : '' }}>DP Berhasil</option>
                            <option value="Menunggu Pelunasan" {{ $transaksi->status_transaksi === 'Menunggu Pelunasan' ? 'selected' : '' }}>Menunggu Pelunasan</option>
                            <option value="Lunas" {{ $transaksi->status_transaksi === 'Lunas' ? 'selected' : '' }}>Lunas</option>
                            <option value="Mobil Diambil / Dikirim" {{ $transaksi->status_transaksi === 'Mobil Diambil / Dikirim' ? 'selected' : '' }}>Mobil Diambil / Dikirim</option>
                            <option value="Transaksi Selesai" {{ $transaksi->status_transaksi === 'Transaksi Selesai' ? 'selected' : '' }}>Transaksi Selesai</option>
                            <option value="Dibatalkan" {{ $transaksi->status_transaksi === 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-primary text-white py-3.5 rounded-xl font-bold hover:bg-primaryHover transition-colors flex items-center justify-center gap-2">
                        <i class='bx bx-save text-lg'></i> Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
