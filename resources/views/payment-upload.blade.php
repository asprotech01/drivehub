@extends('layouts.guest')
@section('title', 'Upload Bukti Pembayaran - DriveHub')
@section('content')
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-24">

        <div class="mb-12 text-center lg:text-left">
            <h1 class="text-4xl font-black text-dark tracking-tighter uppercase mb-2">Konfirmasi <span class="text-primary italic">Pembayaran</span></h1>
            <p class="text-gray-500 font-medium">Lakukan transfer sesuai detail di bawah untuk memproses pesanan Anda.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Left Column: Payment Details & Form -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Countdown & Amount Card -->
                <div class="bg-white rounded-[40px] p-10 shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-gray-50 relative overflow-hidden">
                    <div class="absolute top-0 right-0 bg-red-500 text-white px-8 py-2 rounded-bl-3xl font-black text-[10px] uppercase tracking-widest animate-pulse">
                        Selesaikan Sebelum: {{ $transaksi->batas_pembayaran ? $transaksi->batas_pembayaran->format('H:i') : '24 Jam' }}
                    </div>

                    <div class="space-y-6">
                        <div class="text-[10px] font-black uppercase tracking-widest text-gray-400">Total Yang Harus Dibayar ({{ $paymentType }})</div>
                        <div class="text-5xl font-black text-primary tracking-tighter">Rp {{ number_format($amount, 0, ',', '.') }}</div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4">
                            <div class="p-6 rounded-3xl bg-gray-50 border border-gray-100 group hover:border-primary transition-all">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="font-black text-xl text-blue-800 italic">BCA</div>
                                    <button onclick="navigator.clipboard.writeText('883123456789')" class="text-primary text-sm font-black uppercase tracking-widest hover:underline">Salin</button>
                                </div>
                                <div class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">No. Rekening</div>
                                <div class="text-lg font-black text-dark">8831 2345 6789</div>
                                <div class="text-xs font-medium text-gray-500">a.n PT DriveHub Indonesia</div>
                            </div>
                            <div class="p-6 rounded-3xl bg-gray-50 border border-gray-100 group hover:border-primary transition-all">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="font-black text-xl text-orange-600 italic">BNI</div>
                                    <button onclick="navigator.clipboard.writeText('0987654321')" class="text-primary text-sm font-black uppercase tracking-widest hover:underline">Salin</button>
                                </div>
                                <div class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">No. Rekening</div>
                                <div class="text-lg font-black text-dark">0987 6543 21</div>
                                <div class="text-xs font-medium text-gray-500">a.n PT DriveHub Indonesia</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Upload -->
                <form action="{{ route('payment.store', $transaksi->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    
                    @if($paymentType === 'DP')
                    <div class="bg-primary/5 rounded-[40px] p-10 border border-primary/10">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-12 bg-primary rounded-2xl flex items-center justify-center text-white text-xl shadow-lg shadow-primary/20"><i class='bx bx-id-card'></i></div>
                            <h3 class="text-xl font-black text-dark uppercase tracking-tight">Verifikasi Identitas (KTP)</h3>
                        </div>
                        <p class="text-gray-500 text-sm font-medium mb-8 leading-relaxed">Untuk pembayaran DP, kami memerlukan foto KTP Anda untuk keperluan administrasi pengurusan surat kendaraan (STNK/BPKB).</p>
                        
                        <label class="group relative block w-full aspect-video bg-white rounded-3xl border-2 border-dashed border-primary/20 hover:border-primary transition-all cursor-pointer overflow-hidden">
                            <div class="absolute inset-0 flex flex-col items-center justify-center p-8 text-center group-hover:scale-105 transition-transform">
                                <i class='bx bx-cloud-upload text-5xl text-gray-300 group-hover:text-primary mb-4 transition-colors'></i>
                                <span class="text-sm font-black text-dark uppercase tracking-widest">Pilih Foto KTP</span>
                                <span class="text-[10px] text-gray-400 font-bold uppercase mt-1">JPG, PNG, PDF (Maks 5MB)</span>
                            </div>
                            <input type="file" name="foto_ktp" required class="hidden" accept="image/*">
                        </label>
                    </div>
                    @endif

                    <div class="bg-white rounded-[40px] p-10 shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-gray-50">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary text-xl font-black"><i class='bx bx-upload'></i></div>
                            <h2 class="text-2xl font-black text-dark uppercase tracking-tight">Bukti Transfer</h2>
                        </div>

                        <label class="group relative block w-full h-48 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-100 hover:border-primary transition-all cursor-pointer overflow-hidden mb-6">
                            <div class="absolute inset-0 flex flex-col items-center justify-center p-8 text-center group-hover:scale-105 transition-transform">
                                <i class='bx bx-receipt text-5xl text-gray-300 group-hover:text-primary mb-2 transition-colors'></i>
                                <span class="text-sm font-black text-dark uppercase tracking-widest">Pilih Bukti Pembayaran</span>
                            </div>
                            <input type="file" name="bukti_pembayaran" required class="hidden" accept="image/*">
                        </label>

                        <button type="submit" class="w-full bg-primary text-white py-6 rounded-[24px] font-black uppercase tracking-widest text-sm hover:bg-primaryHover transition-all shadow-2xl shadow-primary/20 flex items-center justify-center gap-3">
                            Konfirmasi Pembayaran <i class='bx bx-check-double text-2xl'></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right Column: Summary Info -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-[40px] shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-gray-50 p-8 sticky top-32">
                    <h3 class="font-black text-dark uppercase tracking-tight mb-8">Informasi Pesanan</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gray-50 rounded-xl overflow-hidden shrink-0">
                                <img src="{{ $transaksi->mobil->gambar_url }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <div class="text-xs font-black text-dark uppercase">{{ $transaksi->mobil->merk }} {{ $transaksi->mobil->model }}</div>
                                <div class="text-[10px] text-gray-400 font-bold uppercase">{{ $transaksi->mobil->tahun_produksi }}</div>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-50 space-y-3">
                            <div class="flex justify-between text-[10px] font-black uppercase tracking-widest text-gray-400">
                                <span>ID Transaksi</span>
                                <span class="text-dark">#TRX-{{ $transaksi->id }}</span>
                            </div>
                            <div class="flex justify-between text-[10px] font-black uppercase tracking-widest text-gray-400">
                                <span>Tipe Pembayaran</span>
                                <span class="text-primary">{{ $paymentType }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
