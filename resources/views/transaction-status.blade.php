@extends('layouts.guest')
@section('title', 'Status Transaksi - DriveHub')
@section('content')
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 pt-32">
        <!-- Background Decorations -->
        <div class="absolute top-40 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl -z-10"></div>
        <div class="absolute bottom-40 left-0 w-64 h-64 bg-secondary/5 rounded-full blur-3xl -z-10"></div>

        @if($transaksi)
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Main Content: Timeline & Actions -->
            <div class="flex-1 space-y-8">
                
                <!-- Status Header Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-primary px-8 py-4 flex justify-between items-center">
                        <span class="text-white/80 text-xs font-bold uppercase tracking-widest">ID Transaksi: #TRX-{{ str_pad($transaksi->id, 4, '0', STR_PAD_LEFT) }}</span>
                        @php
                            $statusColors = [
                                'Menunggu Pembayaran Booking' => 'bg-yellow-400 text-dark',
                                'Booking Berhasil' => 'bg-blue-400 text-white',
                                'Menunggu DP' => 'bg-yellow-400 text-dark',
                                'DP Berhasil' => 'bg-blue-400 text-white',
                                'Menunggu Pelunasan' => 'bg-orange-400 text-white',
                                'Lunas' => 'bg-green-400 text-white',
                                'Mobil Diambil / Dikirim' => 'bg-purple-400 text-white',
                                'Transaksi Selesai' => 'bg-green-400 text-white',
                                'Dibatalkan' => 'bg-red-400 text-white',
                            ];
                        @endphp
                        <span class="{{ $statusColors[$transaksi->status_transaksi] ?? 'bg-gray-400 text-white' }} px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter">
                            {{ $transaksi->status_transaksi }}
                        </span>
                    </div>
                    <div class="p-8">
                        <div class="flex flex-col md:flex-row gap-8 items-center mb-8">
                            <img src="{{ $transaksi->mobil->gambar_url }}" class="w-full md:w-48 h-32 object-cover rounded-2xl shadow-lg transform -rotate-2">
                            <div class="text-center md:text-left flex-1">
                                <h1 class="text-3xl font-black text-dark tracking-tighter mb-2">{{ $transaksi->mobil->merk }} {{ $transaksi->mobil->model }}</h1>
                                <p class="text-gray-500 mb-4">{{ $transaksi->mobil->tahun_produksi }} • {{ $transaksi->mobil->transmisi === 'A/T' ? 'Automatic' : 'Manual' }} • {{ $transaksi->mobil->warna }}</p>
                                <div class="text-2xl font-black text-primary">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</div>
                            </div>
                        </div>

                        <!-- Main Action Section -->
                        <div class="p-8 bg-gray-50 rounded-[32px] border border-gray-100 relative overflow-hidden group">
                            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                                <i class='bx bxs-badge-check text-8xl'></i>
                            </div>
                            
                            @php
                                $bookingPayment = $transaksi->pembayarans->where('tipe_pembayaran', 'Booking Fee')->first();
                                $dpPayment = $transaksi->pembayarans->where('tipe_pembayaran', 'DP')->first();
                                $pelunasanPayment = $transaksi->pembayarans->where('tipe_pembayaran', 'Pelunasan')->first();
                            @endphp

                            @if($transaksi->status_transaksi === 'Menunggu Pembayaran Booking')
                                @if(!$bookingPayment)
                                    <div class="text-center space-y-6">
                                        <h3 class="text-2xl font-black text-dark">Amankan Mobil Impian Anda!</h3>
                                        <p class="text-gray-500 text-sm max-w-md mx-auto leading-relaxed">Silakan lakukan pembayaran Booking Fee sebesar <strong>Rp 500.000</strong> ke salah satu rekening DriveHub di samping untuk memesan unit ini.</p>
                                        <div class="flex justify-center pt-2">
                                            <a href="{{ route('payment.create', $transaksi->id) }}" class="bg-primary text-white px-10 py-4 rounded-2xl font-bold hover:bg-primaryHover transition-all shadow-xl shadow-primary/20 flex items-center justify-center gap-2">
                                                Bayar Booking Fee <i class='bx bx-right-arrow-alt text-2xl'></i>
                                            </a>
                                        </div>
                                        <p class="text-[10px] text-red-400 font-bold uppercase tracking-widest">Batas Waktu: {{ $transaksi->batas_pembayaran ? $transaksi->batas_pembayaran->format('d M Y H:i') : '24 Jam' }}</p>
                                    </div>
                                @elseif($bookingPayment->status_verifikasi === 'Menunggu Verifikasi')
    <div class="text-center py-6 space-y-4">
        
        <div class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-3xl flex items-center justify-center mx-auto text-3xl animate-pulse">
            <i class='bx bx-time-five'></i>
        </div>

        <h3 class="text-2xl font-black text-dark">
            Verifikasi Booking Fee
        </h3>

        <p class="text-gray-500 text-sm max-w-md mx-auto leading-relaxed">
            Bukti transfer Booking Fee Anda telah kami terima dan sedang dalam proses verifikasi oleh admin. Mohon tunggu beberapa saat, kami akan segera memprosesnya.
        </p>

        <!-- Tombol Pembatalan -->
        <div class="pt-2">
            <form action="{{ route('transaction.cancel-booking', $transaksi->id) }}" 
                  method="POST"
                  onsubmit="return confirm('Apakah Anda yakin ingin membatalkan booking ini?')">
                @csrf

                <button type="submit"
                    class="px-8 py-3 rounded-2xl font-bold border border-red-200 text-red-500 hover:bg-red-50 transition-all">
                    Batalkan Booking
                </button>
            </form>
        </div>

    </div>
                                @elseif($bookingPayment->status_verifikasi === 'Tidak Valid')
                                    <div class="text-center space-y-6">
                                        <div class="w-16 h-16 bg-red-100 text-red-600 rounded-3xl flex items-center justify-center mx-auto text-3xl">
                                            <i class='bx bx-x-circle'></i>
                                        </div>
                                        <h3 class="text-2xl font-black text-dark">Pembayaran Tidak Valid</h3>
                                        <p class="text-red-500 text-sm max-w-md mx-auto leading-relaxed">Bukti pembayaran Booking Fee Anda ditolak oleh admin karena tidak sesuai atau tidak terbaca. Silakan lakukan upload ulang.</p>
                                        <div class="flex justify-center pt-2">
                                            <a href="{{ route('payment.create', $transaksi->id) }}" class="bg-primary text-white px-10 py-4 rounded-2xl font-bold hover:bg-primaryHover transition-all shadow-xl shadow-primary/20 flex items-center justify-center gap-2">
                                                Upload Ulang Bukti Pembayaran <i class='bx bx-upload text-2xl'></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif

                            @elseif($transaksi->status_transaksi === 'Booking Berhasil')
                                @if(!$dpPayment)
                                    <div class="text-center space-y-6">
                                        <h3 class="text-2xl font-black text-dark">Satu Langkah Lagi!</h3>
                                        <p class="text-gray-500 text-sm max-w-md mx-auto leading-relaxed">Booking fee Anda telah terverifikasi. Sekarang, silakan lakukan pembayaran DP 30% dan lengkapi data KTP Anda untuk memproses STNK.</p>
                                        <div class="flex flex-col sm:flex-row gap-4 justify-center pt-2">
                                            <a href="{{ route('payment.create', $transaksi->id) }}" class="bg-primary text-white px-10 py-4 rounded-2xl font-bold hover:bg-primaryHover transition-all shadow-xl shadow-primary/20 flex items-center justify-center gap-2">
                                                Bayar DP & Upload KTP <i class='bx bx-right-arrow-alt text-2xl'></i>
                                            </a>
                                            <form action="{{ route('transaction.cancel', $transaksi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan?')">
                                                @csrf
                                                <button type="submit" class="w-full sm:w-auto px-10 py-4 rounded-2xl font-bold border border-red-200 text-red-500 hover:bg-red-50 transition-all">Batalkan</button>
                                            </form>
                                        </div>
                                        <p class="text-[10px] text-red-400 font-bold uppercase tracking-widest">Deadline DP: {{ $transaksi->batas_pembayaran ? $transaksi->batas_pembayaran->format('d M Y') : 'N/A' }}</p>
                                    </div>
                                @elseif($dpPayment->status_verifikasi === 'Menunggu Verifikasi')
                                    <div class="text-center py-6 space-y-4">
                                        <div class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-3xl flex items-center justify-center mx-auto text-3xl animate-pulse">
                                            <i class='bx bx-time-five'></i>
                                        </div>
                                        <h3 class="text-2xl font-black text-dark">Verifikasi DP & KTP</h3>
                                        <p class="text-gray-500 text-sm max-w-md mx-auto leading-relaxed">Pembayaran DP & data KTP Anda sedang diverifikasi oleh admin. Kami akan segera memulai pengurusan administrasi kendaraan setelah diverifikasi.</p>
                                    </div>
                                @elseif($dpPayment->status_verifikasi === 'Tidak Valid')
                                    <div class="text-center space-y-6">
                                        <div class="w-16 h-16 bg-red-100 text-red-600 rounded-3xl flex items-center justify-center mx-auto text-3xl">
                                            <i class='bx bx-x-circle'></i>
                                        </div>
                                        <h3 class="text-2xl font-black text-dark">Verifikasi DP Ditolak</h3>
                                        <p class="text-red-500 text-sm max-w-md mx-auto leading-relaxed">Pembayaran DP atau data KTP Anda ditolak oleh admin. Silakan upload ulang bukti DP & foto KTP yang valid.</p>
                                        <div class="flex justify-center pt-2">
                                            <a href="{{ route('payment.create', $transaksi->id) }}" class="bg-primary text-white px-10 py-4 rounded-2xl font-bold hover:bg-primaryHover transition-all shadow-xl shadow-primary/20 flex items-center justify-center gap-2">
                                                Upload Ulang DP & KTP <i class='bx bx-upload text-2xl'></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif

                            @elseif($transaksi->status_transaksi === 'DP Berhasil')
                                @if(!$pelunasanPayment)
                                    <div class="text-center space-y-6">
                                        <h3 class="text-2xl font-black text-dark">STNK Sedang Diproses</h3>
                                        <p class="text-gray-500 text-sm max-w-md mx-auto leading-relaxed">Tim kami sedang mengurus administrasi kendaraan Anda. Silakan selesaikan pelunasan sisa pembayaran agar mobil siap dikirim.</p>
                                        <a href="{{ route('payment.create', $transaksi->id) }}" class="bg-primary text-white px-10 py-4 rounded-2xl font-bold hover:bg-primaryHover transition-all shadow-xl shadow-primary/20 inline-flex items-center gap-2">
                                            Lakukan Pelunasan <i class='bx bx-wallet text-2xl'></i>
                                        </a>
                                    </div>
                                @elseif($pelunasanPayment->status_verifikasi === 'Menunggu Verifikasi')
                                    <div class="text-center py-6 space-y-4">
                                        <div class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-3xl flex items-center justify-center mx-auto text-3xl animate-pulse">
                                            <i class='bx bx-time-five'></i>
                                        </div>
                                        <h3 class="text-2xl font-black text-dark">Verifikasi Pelunasan</h3>
                                        <p class="text-gray-500 text-sm max-w-md mx-auto leading-relaxed">Bukti pelunasan pembayaran Anda sedang diproses dan diverifikasi oleh admin. Kami akan segera memberi tahu Anda untuk metode serah terima kendaraan.</p>
                                    </div>
                                @elseif($pelunasanPayment->status_verifikasi === 'Tidak Valid')
                                    <div class="text-center space-y-6">
                                        <div class="w-16 h-16 bg-red-100 text-red-600 rounded-3xl flex items-center justify-center mx-auto text-3xl">
                                            <i class='bx bx-x-circle'></i>
                                        </div>
                                        <h3 class="text-2xl font-black text-dark">Pelunasan Ditolak</h3>
                                        <p class="text-red-500 text-sm max-w-md mx-auto leading-relaxed">Bukti pembayaran pelunasan Anda ditolak oleh admin. Silakan periksa kembali dan upload bukti pelunasan yang valid.</p>
                                        <div class="flex justify-center pt-2">
                                            <a href="{{ route('payment.create', $transaksi->id) }}" class="bg-primary text-white px-10 py-4 rounded-2xl font-bold hover:bg-primaryHover transition-all shadow-xl shadow-primary/20 flex items-center justify-center gap-2">
                                                Upload Ulang Pelunasan <i class='bx bx-upload text-2xl'></i>
                                            </a>
                                        </div>

                                    </div>
                                @endif

                            @elseif($transaksi->status_transaksi === 'Lunas')
                                <div class="space-y-6">
                                    <h3 class="text-2xl font-black text-dark text-center">Metode Pengiriman</h3>
                                    <form action="{{ route('transaction.delivery.choice', $transaksi->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @csrf
                                        <label class="relative cursor-pointer">
                                            <input type="radio" name="metode_pengiriman" value="Ambil di Showroom" class="peer sr-only" required>
                                            <div class="p-6 rounded-3xl border-2 border-gray-100 peer-checked:border-primary peer-checked:bg-primary/5 transition-all text-center">
                                                <i class='bx bx-store text-4xl text-gray-400 peer-checked:text-primary mb-2'></i>
                                                <div class="font-bold text-dark">Ambil Sendiri</div>
                                            </div>
                                        </label>
                                        <label class="relative cursor-pointer">
                                            <input type="radio" name="metode_pengiriman" value="Kirim ke Rumah" class="peer sr-only">
                                            <div class="p-6 rounded-3xl border-2 border-gray-100 peer-checked:border-primary peer-checked:bg-primary/5 transition-all text-center">
                                                <i class='bx bx-home-alt text-4xl text-gray-400 peer-checked:text-primary mb-2'></i>
                                                <div class="font-bold text-dark">Kirim ke Rumah</div>
                                            </div>
                                        </label>
                                        <button type="submit" class="md:col-span-2 bg-primary text-white py-4 rounded-2xl font-bold shadow-xl shadow-primary/20">Konfirmasi Opsi</button>
                                    </form>
                                </div>
                            @elseif($transaksi->status_transaksi === 'Mobil Diambil / Dikirim')
                                <div class="text-center py-8 space-y-6">
                                    <div class="w-20 h-20 bg-purple-100 text-purple-600 rounded-3xl flex items-center justify-center mx-auto text-4xl animate-bounce-slow">
                                        <i class='bx bx-paper-plane'></i>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-black text-dark mb-2">Dalam Perjalanan</h3>
                                        <p class="text-gray-500 text-sm max-w-md mx-auto leading-relaxed">
                                            @if($transaksi->pengiriman?->tgl_pengiriman)
                                                Mobil Anda dijadwalkan untuk dikirim/diambil pada tanggal <strong>{{ \Carbon\Carbon::parse($transaksi->pengiriman->tgl_pengiriman)->format('d M Y') }}</strong>.
                                            @else
                                                Mobil Anda sedang disiapkan oleh tim DriveHub untuk serah terima.
                                            @endif
                                        </p>
                                    </div>
                                    
                                    <form action="{{ route('transaction.confirm-receipt', $transaksi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin telah menerima unit mobil ini dengan baik dan ingin menyelesaikan transaksi?')" class="pt-2">
                                        @csrf
                                        <button type="submit" class="bg-green-500 text-white px-10 py-4 rounded-2xl font-bold hover:bg-green-600 transition-all shadow-xl shadow-green-500/20 inline-flex items-center gap-2">
                                            <i class='bx bx-check-double text-2xl'></i> Konfirmasi Penerimaan Mobil
                                        </button>
                                    </form>
                                </div>
                            @elseif($transaksi->status_transaksi === 'Transaksi Selesai')
                                <div class="text-center py-8">
                                    <div class="w-20 h-20 bg-green-100 text-green-600 rounded-3xl flex items-center justify-center mx-auto mb-6 text-4xl">
                                        <i class='bx bx-party'></i>
                                    </div>
                                    <h3 class="text-2xl font-black text-dark mb-2">Transaksi Selesai!</h3>
                                    <p class="text-gray-500 text-sm">Terima kasih telah mempercayakan pembelian kendaraan Anda kepada DriveHub!</p>
                                </div>
                            @elseif($transaksi->status_transaksi === 'Dibatalkan')
                                <div class="text-center py-8">
                                    <div class="w-20 h-20 bg-red-100 text-red-600 rounded-3xl flex items-center justify-center mx-auto mb-6 text-4xl">
                                        <i class='bx bx-x-circle'></i>
                                    </div>
                                    <h3 class="text-2xl font-black text-dark mb-2">Transaksi Dibatalkan</h3>
                                    <p class="text-gray-500 text-sm">Pesanan ini telah dibatalkan.</p>
                                </div>
                            @else
                                <div class="text-center py-8 text-gray-400 italic">
                                    Menunggu proses verifikasi admin...
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Detailed Timeline -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h3 class="text-xl font-black text-dark mb-8 tracking-tighter">Riwayat Aktivitas</h3>
                    @php
                        $steps = [
                            ['status' => 'Menunggu Pembayaran Booking', 'label' => 'Booking Dibuat', 'icon' => 'bx-receipt'],
                            ['status' => 'Booking Berhasil', 'label' => 'Booking Fee Terverifikasi', 'icon' => 'bx-check-circle'],
                            ['status' => 'DP Berhasil', 'label' => 'DP & KTP Terverifikasi', 'icon' => 'bx-id-card'],
                            ['status' => 'Lunas', 'label' => 'Pelunasan Terverifikasi', 'icon' => 'bx-wallet'],
                            ['status' => 'Mobil Diambil / Dikirim', 'label' => 'Proses Pengiriman', 'icon' => 'bx-car'],
                            ['status' => 'Transaksi Selesai', 'label' => 'Transaksi Selesai', 'icon' => 'bx-party'],
                        ];
                        $statusOrder = array_column($steps, 'status');
                        $currentIndex = array_search($transaksi->status_transaksi, $statusOrder);
                        if ($currentIndex === false) $currentIndex = 0;
                    @endphp
                    
                    <div class="space-y-8 relative before:absolute before:left-6 before:top-4 before:bottom-4 before:w-0.5 before:bg-gray-100">
                        @foreach($steps as $index => $step)
                        <div class="flex items-start gap-6 relative">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl z-10 
                                {{ $index < $currentIndex ? 'bg-primary text-white' : ($index === $currentIndex ? 'bg-secondary text-dark animate-pulse' : 'bg-gray-50 text-gray-300') }}
                                border-4 border-white shadow-sm">
                                <i class='bx {{ $step['icon'] }}'></i>
                            </div>
                            <div class="pt-2">
                                <h4 class="font-bold {{ $index <= $currentIndex ? 'text-dark' : 'text-gray-300' }}">{{ $step['label'] }}</h4>
                                <p class="text-xs text-gray-400 mt-1 uppercase tracking-widest font-bold">
                                    {{ $index === $currentIndex ? 'Sedang Berlangsung' : ($index < $currentIndex ? 'Selesai' : 'Tahap Berikutnya') }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sidebar: Info & Help -->
            <div class="w-full lg:w-80 space-y-6">
                <!-- My Transactions List -->
                @if($transaksis->count() > 1)
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-black text-dark mb-4 text-sm tracking-widest uppercase">Daftar Transaksi</h3>
                    <div class="space-y-3">
                        @foreach($transaksis as $t)
                        <a href="{{ route('transaction.show', $t->id) }}" class="flex items-center justify-between p-3 rounded-2xl transition-colors {{ $t->id === $transaksi->id ? 'bg-primary/5 border border-primary/20' : 'bg-gray-50 hover:bg-gray-100' }} group">
                            <div class="flex-1 min-w-0 pr-2">
                                <span class="text-xs font-bold text-dark block truncate">{{ $t->mobil->merk }} {{ $t->mobil->model }}</span>
                                <span class="text-[9px] font-bold text-gray-400 uppercase">#TRX-{{ str_pad($t->id, 4, '0', STR_PAD_LEFT) }} • {{ $t->status_transaksi }}</span>
                            </div>
                            <i class='bx bx-chevron-right text-gray-400 group-hover:text-primary transition-colors shrink-0'></i>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Payment Receipt Section -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-black text-dark mb-4 text-sm tracking-widest uppercase">Bukti Bayar</h3>
                    <div class="space-y-3">
                        @forelse($transaksi->pembayarans->where('status_verifikasi', 'Valid') as $pay)
                        <a href="{{ route('transaction.kwitansi', [$transaksi->id, $pay->id]) }}" target="_blank" class="flex items-center justify-between p-3 bg-gray-50 rounded-2xl hover:bg-primary/5 transition-colors group">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-primary shadow-sm"><i class='bx bx-printer'></i></div>
                                <span class="text-xs font-bold text-dark">{{ $pay->tipe_pembayaran }}</span>
                            </div>
                            <i class='bx bx-chevron-right text-gray-400 group-hover:text-primary transition-colors'></i>
                        </a>
                        @empty
                        <p class="text-xs text-gray-400 italic">Belum ada kwitansi tersedia.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Support Section -->
                <div class="bg-dark rounded-3xl p-8 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-primary/20 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <h3 class="text-xl font-black mb-4">Butuh Bantuan?</h3>
                    <p class="text-sm text-gray-400 mb-6 leading-relaxed">Tim support kami siap membantu Anda 24/7 jika ada kendala dalam transaksi.</p>
                    <a href="#" class="flex items-center justify-center gap-2 w-full bg-primary py-4 rounded-2xl font-bold hover:bg-primaryHover transition-all shadow-lg">
                        <i class='bx bxl-whatsapp text-xl'></i> Chat WhatsApp
                    </a>
                </div>

                <!-- Return Home -->
                <a href="{{ route('home') }}" class="flex items-center justify-center gap-2 w-full border border-gray-200 py-4 rounded-2xl font-bold text-gray-500 hover:bg-gray-50 transition-all">
                    <i class='bx bx-left-arrow-alt text-xl'></i> Kembali ke Beranda
                </a>
            </div>

        </div>
        @else
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-12 text-center">
            <i class='bx bx-receipt text-6xl text-gray-300 mb-4'></i>
            <h2 class="text-2xl font-bold text-dark mb-2">Belum Ada Transaksi</h2>
            <p class="text-gray-500 mb-6">Anda belum memiliki transaksi apapun. Mulai jelajahi katalog mobil kami!</p>
            <a href="{{ route('catalog.index') }}" class="inline-block bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primaryHover transition-colors">
                Jelajahi Katalog
            </a>
        </div>
        @endif
    </div>
@endsection
