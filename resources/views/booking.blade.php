@extends('layouts.guest')
@section('title', 'Booking Mobil - DriveHub')
@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-24">

        <div class="mb-12">
            <h1 class="text-4xl font-black text-dark tracking-tighter uppercase mb-2">Selesaikan <span class="text-primary italic">Booking</span></h1>
            <p class="text-gray-500 font-medium">Amankan unit impian Anda sebelum diambil pembeli lain.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            <!-- Left Column: Form -->
            <div class="lg:col-span-2">
                <form action="{{ route('booking.store', $mobil->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <!-- Data Diri Card -->
                    <div class="bg-white rounded-[40px] p-10 shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-gray-50">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary text-xl font-black">1</div>
                            <h2 class="text-2xl font-black text-dark uppercase tracking-tight">Konfirmasi Data Diri</h2>
                        </div>

                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-1">Nama Lengkap (Sesuai KTP)</label>
                                <input type="text" name="nama_lengkap" required value="{{ old('nama_lengkap', Auth::user()->pembeli->nama_lengkap ?? Auth::user()->name) }}" class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-dark font-bold focus:ring-2 focus:ring-primary/20 transition-all outline-none" placeholder="Masukkan nama lengkap">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-1">Nomor WhatsApp</label>
                                    <input type="tel" name="no_hp" required value="{{ old('no_hp', Auth::user()->pembeli->no_hp ?? '') }}" class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-dark font-bold focus:ring-2 focus:ring-primary/20 transition-all outline-none" placeholder="0812xxxx">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-1">Email</label>
                                    <input type="email" name="email" required value="{{ old('email', Auth::user()->email ?? '') }}" class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-dark font-bold focus:ring-2 focus:ring-primary/20 transition-all outline-none" placeholder="email@contoh.com">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-1">Alamat Lengkap Domisili</label>
                                <textarea rows="3" name="alamat" required class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-dark font-bold focus:ring-2 focus:ring-primary/20 transition-all outline-none" placeholder="Masukkan alamat lengkap">{{ old('alamat', Auth::user()->pembeli->alamat ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-primary text-white py-6 rounded-[24px] font-black uppercase tracking-widest text-sm hover:bg-primaryHover transition-all shadow-2xl shadow-primary/20 flex items-center justify-center gap-3">
                        Lanjut ke Pembayaran <i class='bx bx-right-arrow-alt text-2xl'></i>
                    </button>
                </form>
            </div>

            <!-- Right Column: Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-[40px] shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-gray-50 p-8 sticky top-32">
                    <h3 class="font-black text-dark uppercase tracking-tight mb-6 border-b border-gray-50 pb-4">Ringkasan Unit</h3>

                    <div class="flex gap-6 mb-8">
                        <div class="w-24 h-20 rounded-2xl overflow-hidden shrink-0 shadow-sm">
                            <img src="{{ $mobil->gambar_url }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-black text-dark text-sm uppercase leading-tight">{{ $mobil->merk }} {{ $mobil->model }}</h4>
                            <p class="text-xs text-gray-400 font-bold uppercase mt-1">{{ $mobil->tahun_produksi }} • {{ $mobil->transmisi }}</p>
                        </div>
                    </div>

                    <div class="space-y-4 text-xs font-bold uppercase tracking-widest text-gray-400 mb-8">
                        <div class="flex justify-between">
                            <span>Harga Unit</span>
                            <span class="text-dark">Rp {{ number_format($mobil->harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Biaya Admin</span>
                            <span class="text-green-500">Gratis</span>
                        </div>
                    </div>

                    <div class="bg-primary/5 rounded-3xl p-6">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-[10px] font-black uppercase tracking-widest text-primary">Booking Fee</span>
                            <span class="text-xl font-black text-primary">Rp 500.000</span>
                        </div>
                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-tighter mt-2 leading-relaxed">
                            *Booking Fee akan memotong total harga mobil dan dapat di-refund 100% jika transaksi batal.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
