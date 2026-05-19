@extends('layouts.admin')
@section('title', 'Pengiriman Mobil - Admin DriveHub')
@section('content')
<div x-data="{ activeTab: '' }" class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 flex flex-col">
    <!-- Interactive Premium Tabs Header -->
    <div class="flex flex-wrap gap-2 mb-8 border-b border-gray-100 pb-4">
        <button @click="activeTab = 'siap'" :class="activeTab === 'siap' ? 'border-primary text-primary font-bold bg-primary/5' : 'border-transparent text-gray-500 font-semibold hover:bg-gray-50'" class="px-5 py-3 border-b-2 rounded-xl transition-all focus:outline-none text-sm flex items-center gap-2">
            <i class='bx bx-time-five text-lg'></i> Siap Kirim/Ambil ({{ $siapKirim->count() }})
        </button>
        <button @click="activeTab = 'menunggu'" :class="activeTab === 'menunggu' ? 'border-primary text-primary font-bold bg-primary/5' : 'border-transparent text-gray-500 font-semibold hover:bg-gray-50'" class="px-5 py-3 border-b-2 rounded-xl transition-all focus:outline-none text-sm flex items-center gap-2">
            <i class='bx bx-loader-circle text-lg'></i> Menunggu Opsi Pembeli ({{ $menungguPilihan->count() }})
        </button>
        <button @click="activeTab = 'selesai'" :class="activeTab === 'selesai' ? 'border-primary text-primary font-bold bg-primary/5' : 'border-transparent text-gray-500 font-semibold hover:bg-gray-50'" class="px-5 py-3 border-b-2 rounded-xl transition-all focus:outline-none text-sm flex items-center gap-2">
            <i class='bx bx-check-double text-lg'></i> Selesai ({{ $selesai->count() }})
        </button>
    </div>


    <div class="space-y-6">
        <!-- 0. Pilih Kategori Placeholder -->
        <div x-show="!activeTab" x-cloak class="text-center py-20 bg-gray-50/50 rounded-[32px] border border-dashed border-gray-200">
            <div class="w-20 h-20 bg-primary/10 text-primary rounded-3xl flex items-center justify-center mx-auto mb-6 text-4xl">
                <i class='bx bx-navigation'></i>
            </div>
            <h3 class="text-xl font-bold text-dark mb-2">Pilih Kategori Pengiriman</h3>
            <p class="text-gray-500 text-sm max-w-sm mx-auto leading-relaxed">Silakan klik salah satu kategori tab di atas untuk melihat daftar transaksi dan melakukan tindakan pengiriman.</p>
        </div>
        <!-- 1. Siap Kirim Tab Content -->
        <div x-show="activeTab === 'siap'" x-cloak class="space-y-6">
            @forelse($siapKirim as $trx)
            <div class="border border-gray-100 rounded-3xl p-6 bg-gray-50/40 flex flex-col gap-6 relative overflow-hidden group hover:border-primary/20 hover:bg-white transition-all duration-300">
                <!-- Highlight accent line -->
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-primary"></div>
                
                <div class="flex flex-col lg:flex-row gap-6 items-start lg:items-center">
                    <div class="shrink-0">
                        <img src="{{ $trx->mobil->gambar_url }}" class="w-36 h-24 object-cover rounded-2xl shadow-sm border border-gray-100">
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="text-lg font-black text-dark leading-tight">{{ $trx->mobil->merk }} {{ $trx->mobil->model }}</h3>
                                <p class="text-[10px] text-gray-400 font-black tracking-widest uppercase">#TRX-{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}</p>
                            </div>
                            <span class="bg-blue-50 text-blue-700 px-4 py-1.5 rounded-full text-xs font-bold border border-blue-100">Menunggu Tindakan Admin</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-1 text-sm pt-1">
                            <p class="text-gray-500">Pelanggan: <span class="font-bold text-dark">{{ $trx->pembeli->nama_lengkap ?? '-' }}</span></p>
                            <p class="text-gray-500">Pilihan Serah Terima: <span class="font-bold text-primary">{{ $trx->pengiriman?->metode_pengiriman ?? 'Belum dipilih' }}</span></p>
                        </div>
                    </div>
                </div>

                <!-- Scheduling & Configuration Form -->
                <form action="{{ route('admin.delivery.update', $trx->id) }}" method="POST" class="bg-white border border-gray-100 rounded-2xl p-6 grid grid-cols-1 md:grid-cols-3 gap-6 shadow-sm">
                    @csrf
                    <input type="hidden" name="metode_pengiriman" value="{{ $trx->pengiriman?->metode_pengiriman }}">
                    
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Tanggal Pengiriman/Ambil</label>
                        <div class="relative">
                            <input type="date" name="tgl_pengiriman" value="{{ $trx->pengiriman?->tgl_pengiriman ? \Carbon\Carbon::parse($trx->pengiriman->tgl_pengiriman)->format('Y-m-d') : '' }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all font-semibold text-dark">
                        </div>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Alamat Tujuan / Serah Terima</label>
                        <input type="text" name="alamat_tujuan" value="{{ $trx->pengiriman?->alamat_tujuan ?? ($trx->pengiriman?->metode_pengiriman === 'Ambil di Showroom' ? 'Showroom DriveHub' : $trx->pembeli->alamat) }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all font-semibold text-dark">
                    </div>

                    <div class="md:col-span-3 flex flex-col sm:flex-row gap-3 justify-between pt-4 border-t border-gray-50">
                        <a href="{{ route('admin.delivery.surat-jalan', $trx->id) }}" target="_blank" class="px-5 py-3 border border-gray-200 text-gray-600 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
                            <i class='bx bx-printer text-lg'></i> Cetak Surat Jalan
                        </a>
                        
                        <div class="flex flex-col sm:flex-row gap-3">
                            <!-- Update Schedule only (retains current status) -->
                            <button type="submit" name="status" value="Mobil Diambil / Dikirim" class="px-5 py-3 border border-primary/20 text-primary bg-primary/5 rounded-xl text-sm font-bold hover:bg-primary hover:text-white transition-all flex items-center justify-center gap-2">
                                <i class='bx bx-save text-lg'></i> Simpan Jadwal & Alamat
                            </button>
                            
                            <!-- Mark Completed -->
                            <button type="submit" name="status" value="Transaksi Selesai" class="px-5 py-3 bg-green-500 text-white rounded-xl text-sm font-bold hover:bg-green-600 transition-all shadow-lg shadow-green-500/20 flex items-center justify-center gap-2">
                                <i class='bx bx-check-circle text-lg'></i> Konfirmasi Selesai & Serahkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            @empty
            <div class="text-center py-16 text-gray-400">
                <i class='bx bx-package text-6xl mb-4 text-gray-300'></i>
                <p class="font-bold text-gray-500">Tidak ada pengiriman siap dikirim.</p>
                <p class="text-xs text-gray-400">Semua mobil yang lunas sedang menunggu tindakan pelanggan atau sudah diselesaikan.</p>
            </div>
            @endforelse
        </div>

        <!-- 2. Menunggu Opsi Pembeli Tab Content -->
        <div x-show="activeTab === 'menunggu'" x-cloak class="space-y-4">
            @forelse($menungguPilihan as $trx)
            <div class="border border-gray-100 rounded-3xl p-6 bg-gray-50/20 flex flex-col md:flex-row gap-6 items-center">
                <div class="shrink-0">
                    <img src="{{ $trx->mobil->gambar_url }}" class="w-32 h-24 object-cover rounded-2xl border border-gray-100">
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-center mb-1">
                        <h3 class="text-base font-bold text-dark">{{ $trx->mobil->merk }} {{ $trx->mobil->model }}</h3>
                        <span class="bg-yellow-50 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold border border-yellow-100">Menunggu Pilihan</span>
                    </div>
                    <p class="text-sm text-gray-500 mb-1">Pelanggan: <span class="font-bold text-dark">{{ $trx->pembeli->nama_lengkap ?? '-' }}</span></p>
                    <p class="text-xs text-gray-400">Transaksi lunas. Menunggu pembeli memilih metode pengambilan atau pengiriman di profilnya.</p>
                </div>
            </div>
            @empty
            <div class="text-center py-16 text-gray-400">
                <i class='bx bx-user-voice text-6xl mb-4 text-gray-300'></i>
                <p class="font-bold text-gray-500">Tidak ada transaksi menunggu pilihan pembeli.</p>
            </div>
            @endforelse
        </div>

        <!-- 3. Selesai Tab Content -->
        <div x-show="activeTab === 'selesai'" x-cloak class="space-y-4">
            @forelse($selesai as $trx)
            <div class="border border-gray-100 rounded-3xl p-6 bg-gray-50/20 flex flex-col md:flex-row gap-6 items-center">
                <div class="shrink-0">
                    <img src="{{ $trx->mobil->gambar_url }}" class="w-32 h-24 object-cover rounded-2xl border border-gray-100">
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <h3 class="text-base font-bold text-dark">{{ $trx->mobil->merk }} {{ $trx->mobil->model }}</h3>
                            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest leading-none">#TRX-{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <span class="bg-green-50 text-green-700 px-3 py-1 rounded-full text-xs font-bold border border-green-100">Selesai / Terjual</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-y-1 text-xs pt-1 text-gray-500">
                        <p>Pelanggan: <span class="font-semibold text-dark">{{ $trx->pembeli->nama_lengkap ?? '-' }}</span></p>
                        <p>Metode: <span class="font-semibold text-primary">{{ $trx->pengiriman?->metode_pengiriman ?? '-' }}</span></p>
                        <p>Tanggal Penyerahan: <span class="font-semibold text-dark">{{ $trx->pengiriman?->tgl_pengiriman ? \Carbon\Carbon::parse($trx->pengiriman->tgl_pengiriman)->format('d M Y') : 'N/A' }}</span></p>
                    </div>
                </div>
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.delivery.surat-jalan', $trx->id) }}" target="_blank" class="w-full sm:w-auto px-5 py-3 border border-gray-200 hover:border-primary/30 hover:bg-primary/5 text-gray-700 hover:text-primary rounded-xl text-xs font-black transition-all flex items-center justify-center gap-2 shadow-sm">
                        <i class='bx bx-printer text-lg'></i> Lihat Surat Jalan
                    </a>
                </div>
            </div>
            @empty
            <div class="text-center py-16 text-gray-400">
                <i class='bx bx-check-shield text-6xl mb-4 text-gray-300'></i>
                <p class="font-bold text-gray-500">Belum ada pengiriman yang diselesaikan.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
