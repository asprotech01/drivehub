@extends('layouts.admin')
@section('title', 'Kelola Data Pembayaran - Admin DriveHub')
@section('content')
<div x-data="{ activeTrxId: null, modalOpen: false, modalSrc: '', modalTitle: '' }" class="space-y-6">

    <!-- Search Bar & Filters -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
        <form action="{{ route('admin.payments.manage') }}" method="GET" class="flex flex-col lg:flex-row gap-4 items-center justify-between">
            <div class="flex items-center gap-3 w-full lg:w-auto">
                <span class="bg-primary/5 text-primary p-3 rounded-2xl">
                    <i class='bx bx-credit-card-front text-2xl'></i>
                </span>
                <div>
                    <h2 class="text-sm font-bold text-dark uppercase tracking-wide">Pencarian & Filter</h2>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">Kelola data bukti transfer & berkas KTP</p>
                </div>
            </div>
            
            <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto justify-end">
                <div class="relative flex-1 sm:w-64 w-full">
                    <i class='bx bx-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg'></i>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari Transaksi, Pembeli, Mobil..." class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-primary outline-none transition-all font-semibold text-dark">
                </div>
                
                <select name="status" class="py-3 px-4 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-primary outline-none transition-all font-semibold text-dark">
                    <option value="">Semua Status Transaksi</option>
                    <option value="Menunggu Pembayaran Booking" {{ $status === 'Menunggu Pembayaran Booking' ? 'selected' : '' }}>Menunggu Booking</option>
                    <option value="Booking Berhasil" {{ $status === 'Booking Berhasil' ? 'selected' : '' }}>Booking Berhasil</option>
                    <option value="Menunggu DP" {{ $status === 'Menunggu DP' ? 'selected' : '' }}>Menunggu DP</option>
                    <option value="DP Berhasil" {{ $status === 'DP Berhasil' ? 'selected' : '' }}>DP Berhasil</option>
                    <option value="Menunggu Pelunasan" {{ $status === 'Menunggu Pelunasan' ? 'selected' : '' }}>Menunggu Pelunasan</option>
                    <option value="Lunas" {{ $status === 'Lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="Mobil Diambil / Dikirim" {{ $status === 'Mobil Diambil / Dikirim' ? 'selected' : '' }}>Diambil / Dikirim</option>
                    <option value="Transaksi Selesai" {{ $status === 'Transaksi Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Dibatalkan" {{ $status === 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>

                <button type="submit" class="bg-primary text-white px-5 py-3 rounded-xl font-bold hover:bg-primaryHover transition-colors flex items-center gap-2 shadow-sm">
                    Filter <i class='bx bx-filter-alt'></i>
                </button>
                @if($search || $status)
                    <a href="{{ route('admin.payments.manage') }}" class="bg-gray-100 text-gray-600 px-5 py-3 rounded-xl font-bold hover:bg-gray-200 transition-colors flex items-center">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 rounded-2xl p-4 flex items-center gap-3">
        <i class='bx bx-check-circle text-2xl text-green-500'></i>
        <span class="text-sm font-semibold">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Instruction Helper Card -->
    <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-4 flex items-center gap-3 text-blue-800">
        <i class='bx bx-info-circle text-xl text-blue-500'></i>
        <p class="text-xs font-semibold">Silakan klik salah satu baris transaksi di bawah untuk menampilkan detail bukti pembayaran dan KTP pembeli.</p>
    </div>

    <!-- Transaction List Grid -->
    <div class="space-y-4">
        @forelse($transaksis as $trx)
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden hover:border-primary/20 transition-all duration-300">
            <!-- Transaction Card Header / Summary Row (Click to Toggle) -->
            <div @click="activeTrxId = (activeTrxId === {{ $trx->id }}) ? null : {{ $trx->id }}" 
                 class="p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 cursor-pointer hover:bg-gray-50/30 transition-colors select-none">
                
                <div class="space-y-1 flex-1">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="text-sm font-mono font-bold text-dark bg-gray-100 px-2.5 py-1 rounded-md">#TRX-{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}</span>
                        <h3 class="text-base font-black text-dark">{{ $trx->pembeli->nama_lengkap }}</h3>
                        
                        @php
                            $statusColor = match($trx->status_transaksi) {
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
                        <span class="{{ $statusColor }} px-2.5 py-1 rounded-full border text-[10px] font-black uppercase tracking-wide">
                            {{ $trx->status_transaksi }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 font-medium pt-1">
                        Mobil: <span class="font-bold text-dark">{{ $trx->mobil->merk }} {{ $trx->mobil->model }} ({{ $trx->mobil->nomor_polisi }} • {{ $trx->mobil->warna }} • {{ $trx->mobil->tahun_produksi }})</span>
                        • Kontak: <span class="font-semibold text-primary">{{ $trx->pembeli->no_hp ?? '-' }}</span>
                    </p>
                </div>
                
                <div class="flex items-center gap-3 w-full md:w-auto justify-between md:justify-end">
                    <div class="text-right hidden sm:block">
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block">Total Pembayaran Terunggah</span>
                        <span class="font-bold text-dark text-xs">{{ $trx->pembayarans->count() }} / 3 Tahap</span>
                    </div>
                    <button class="bg-gray-50 hover:bg-gray-100 text-gray-700 px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 border border-gray-100">
                        <span x-text="activeTrxId === {{ $trx->id }} ? 'Tutup Detail' : 'Lihat Bukti & Detail'"></span>
                        <i class='bx text-lg transition-transform duration-300' :class="activeTrxId === {{ $trx->id }} ? 'bx-chevron-up rotate-180 text-primary' : 'bx-chevron-down'"></i>
                    </button>
                </div>
            </div>

            <!-- Transaction Payments Grid (Hidden by default, expands on click) -->
            <div x-show="activeTrxId === {{ $trx->id }}" x-transition x-cloak class="border-t border-gray-100 p-6 bg-gray-50/10">
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                    
                    @php
                        $types = [
                            'Booking Fee' => ['title' => '1. Booking Fee', 'desc' => 'Uang Tanda Jadi Unit'],
                            'DP' => ['title' => '2. Uang Muka (DP)', 'desc' => 'DP & Berkas KTP Pembeli'],
                            'Pelunasan' => ['title' => '3. Pelunasan', 'desc' => 'Pelunasan Akhir Kendaraan']
                        ];
                    @endphp

                    @foreach($types as $typeKey => $typeData)
                        @php
                            $payment = $trx->pembayarans->where('tipe_pembayaran', $typeKey)->first();
                        @endphp

                        <div class="border border-gray-100 rounded-2xl p-5 bg-white flex flex-col justify-between space-y-4 shadow-sm hover:border-primary/10 transition-all">
                            <div>
                                <div class="flex justify-between items-center border-b border-gray-100 pb-3 mb-3">
                                    <div>
                                        <h4 class="font-black text-dark text-sm leading-tight">{{ $typeData['title'] }}</h4>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">{{ $typeData['desc'] }}</p>
                                    </div>
                                    @if($payment)
                                        @php
                                            $verifyBadge = match($payment->status_verifikasi) {
                                                'Valid' => 'bg-green-50 text-green-700 border-green-100',
                                                'Tidak Valid' => 'bg-red-50 text-red-700 border-red-100',
                                                default => 'bg-yellow-50 text-yellow-700 border-yellow-100',
                                            };
                                        @endphp
                                        <span class="{{ $verifyBadge }} text-[10px] font-bold px-2 py-0.5 rounded-full border">
                                            {{ $payment->status_verifikasi }}
                                        </span>
                                    @else
                                        <span class="bg-gray-50 text-gray-400 border border-gray-100 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                            Belum Diunggah
                                        </span>
                                    @endif
                                </div>

                                @if($payment)
                                    <div class="space-y-3">
                                        <!-- Payment Info Details -->
                                        <div class="grid grid-cols-2 gap-2 text-xs">
                                            <div>
                                                <span class="text-gray-400 block font-semibold text-[10px] uppercase">Jumlah Bayar</span>
                                                <span class="font-bold text-dark text-sm">Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</span>
                                            </div>
                                            <div>
                                                <span class="text-gray-400 block font-semibold text-[10px] uppercase">Metode</span>
                                                <span class="font-bold text-dark">{{ $payment->metode_bayar }}</span>
                                            </div>
                                            <div class="col-span-2">
                                                <span class="text-gray-400 block font-semibold text-[10px] uppercase">Tanggal Bayar</span>
                                                <span class="font-bold text-dark">{{ $payment->created_at->format('d M Y - H:i') }}</span>
                                            </div>
                                        </div>

                                        <!-- Proof of Payment Thumbnail -->
                                        <div class="space-y-1.5">
                                            <span class="text-gray-400 block font-semibold text-[10px] uppercase">Bukti Pembayaran</span>
                                            @if($payment->bukti_pembayaran)
                                                <div @click="modalOpen = true; modalSrc = '{{ asset('storage/' . $payment->bukti_pembayaran) }}'; modalTitle = 'Bukti Pembayaran {{ $typeKey }} - TRX-{{ $trx->id }}'" class="group relative w-full h-24 bg-gray-100 rounded-xl overflow-hidden cursor-pointer border border-gray-200 shadow-inner">
                                                    <img src="{{ asset('storage/' . $payment->bukti_pembayaran) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                                    <div class="absolute inset-0 bg-dark/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs font-bold transition-all gap-1.5">
                                                        <i class='bx bx-zoom-in text-lg'></i> Lihat Bukti
                                                    </div>
                                                </div>
                                            @else
                                                <div class="w-full h-24 bg-gray-50 rounded-xl border border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400 text-xs">
                                                    <i class='bx bx-image-alt text-2xl mb-1'></i> Bukti tidak ada
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Special KTP Display (For DP Only) -->
                                        @if($typeKey === 'DP')
                                            <div class="space-y-1.5 pt-2 border-t border-gray-100">
                                                <span class="text-gray-400 block font-semibold text-[10px] uppercase">Berkas KTP Pembeli (Untuk DP)</span>
                                                @if($trx->pembeli->foto_ktp)
                                                    <div @click="modalOpen = true; modalSrc = '{{ asset('storage/' . $trx->pembeli->foto_ktp) }}'; modalTitle = 'KTP Pembeli: {{ $trx->pembeli->nama_lengkap }}'" class="group relative w-full h-24 bg-gray-100 rounded-xl overflow-hidden cursor-pointer border border-gray-200 shadow-inner">
                                                        <img src="{{ asset('storage/' . $trx->pembeli->foto_ktp) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                                        <div class="absolute inset-0 bg-dark/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs font-bold transition-all gap-1.5">
                                                            <i class='bx bx-id-card text-lg'></i> Lihat KTP
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="w-full h-24 bg-red-50 text-red-500 rounded-xl border border-dashed border-red-100 flex flex-col items-center justify-center text-center p-2 text-xs">
                                                        <i class='bx bx-error-alt text-xl mb-1'></i> KTP Belum Diunggah
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="h-40 flex flex-col items-center justify-center text-center text-gray-400">
                                        <i class='bx bx-time-five text-3xl mb-1.5 text-gray-300'></i>
                                        <p class="text-xs font-bold">Menunggu Pembeli</p>
                                        <p class="text-[9px] uppercase tracking-wider text-gray-400 mt-0.5">Belum diunggah oleh pembeli</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Action Buttons (Backup Plan) -->
                            @if($payment)
                            <div class="pt-3 border-t border-gray-100 flex gap-2 w-full justify-between items-center">
                                <span class="text-[9px] font-black uppercase text-gray-400 leading-none">Backup Plan:</span>
                                <div class="flex gap-2">
                                    <!-- Re-approve / Force Valid -->
                                    <form action="{{ route('admin.payments.forceApprove', $payment->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin MENYAHKAN (Valid) pembayaran ini secara paksa sebagai rencana cadangan?')" class="px-3 py-1.5 bg-green-500 text-white rounded-lg text-[10px] font-bold hover:bg-green-600 transition-colors flex items-center gap-1">
                                            <i class='bx bx-check'></i> Sahkan
                                        </button>
                                    </form>
                                    <!-- Re-reject / Force Invalid -->
                                    <form action="{{ route('admin.payments.forceReject', $payment->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin MENOLAK (Tidak Valid) pembayaran ini secara paksa sebagai rencana cadangan?')" class="px-3 py-1.5 bg-red-500 text-white rounded-lg text-[10px] font-bold hover:bg-red-600 transition-colors flex items-center gap-1">
                                            <i class='bx bx-x'></i> Tolak
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endif
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-3xl border border-gray-100 p-12 text-center shadow-sm">
            <i class='bx bx-credit-card text-5xl text-gray-300 mb-3'></i>
            <h3 class="text-lg font-bold text-dark mb-1">Tidak Ada Data Pembayaran</h3>
            <p class="text-gray-500 text-xs">Belum ada transaksi dengan riwayat pembayaran yang terdaftar di sistem.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $transaksis->appends(request()->query())->links() }}
    </div>

    <!-- Interactive Lightbox Image Preview Modal (Alpine.js) -->
    <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 z-50 bg-dark/95 backdrop-blur-sm flex flex-col justify-center items-center p-4" x-cloak>
        <!-- Close Button -->
        <button @click="modalOpen = false" class="absolute top-6 right-6 text-white hover:text-gray-300 text-4xl focus:outline-none transition-all">
            <i class='bx bx-x'></i>
        </button>

        <div class="w-full max-w-3xl flex flex-col items-center" @click.outside="modalOpen = false">
            <h3 class="text-white text-lg font-bold mb-4 tracking-wide text-center" x-text="modalTitle"></h3>
            <div class="w-full aspect-[4/3] sm:aspect-video bg-gray-900 rounded-3xl overflow-hidden border border-gray-800 shadow-2xl flex items-center justify-center">
                <img :src="modalSrc" class="max-w-full max-h-full object-contain">
            </div>
            <p class="text-gray-400 text-xs mt-4 uppercase tracking-widest font-semibold">Klik di luar gambar atau tombol X untuk menutup</p>
        </div>
    </div>

</div>
@endsection
