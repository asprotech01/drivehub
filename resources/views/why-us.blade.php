@extends('layouts.guest')
@section('title', 'Kenapa DriveHub? - Keunggulan Kami')
@section('content')
    <section class="relative bg-[#1e293b] pt-36 pb-24 overflow-hidden min-h-[90vh] flex items-center">
        <!-- Full-Bleed Background Image with Slate Parallax Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1486006920555-c77dce18193b?q=80&w=1600&auto=format&fit=crop" class="w-full h-full object-cover opacity-40 scale-105 transform transition-all duration-1000">
            <div class="absolute inset-0 bg-gradient-to-tr from-[#1e293b] via-[#1e293b]/95 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="text-center mb-16 space-y-4">
                <div class="inline-flex items-center gap-2 bg-secondary/10 px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest text-secondary border border-secondary/20">
                    <i class='bx bx-check-shield text-sm'></i>
                    Standar Kualitas Tertinggi
                </div>
                <h1 class="text-5xl md:text-7xl font-black text-white tracking-tighter uppercase leading-[0.95]">
                    KENAPA MEMILIH <br><span class="text-secondary italic">DRIVEHUB?</span>
                </h1>
                <div class="w-20 h-1.5 bg-secondary mx-auto rounded-full mt-4"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="bg-white/5 border border-white/10 p-10 rounded-[40px] hover:bg-white/10 hover:shadow-2xl hover:scale-[1.02] hover:-translate-y-1 transition-all duration-500 group backdrop-blur-md">
                    <div class="w-16 h-16 bg-secondary/10 rounded-2xl flex items-center justify-center text-3xl text-secondary mb-8 group-hover:bg-secondary group-hover:text-white transition-all shadow-sm"><i class='bx bx-check-shield'></i></div>
                    <h3 class="text-2xl font-black text-white uppercase tracking-tight mb-4">Inspeksi 175 Titik</h3>
                    <p class="text-gray-400 text-sm leading-relaxed font-semibold">Pengecekan menyeluruh mulai dari mesin, transmisi, kaki-kaki, hingga sistem elektronik untuk memastikan unit sempurna.</p>
                </div>
                <!-- Card 2 -->
                <div class="bg-white/5 border border-white/10 p-10 rounded-[40px] hover:bg-white/10 hover:shadow-2xl hover:scale-[1.02] hover:-translate-y-1 transition-all duration-500 group backdrop-blur-md">
                    <div class="w-16 h-16 bg-secondary/10 rounded-2xl flex items-center justify-center text-3xl text-secondary mb-8 group-hover:bg-secondary group-hover:text-white transition-all shadow-sm"><i class='bx bx-refresh'></i></div>
                    <h3 class="text-2xl font-black text-white uppercase tracking-tight mb-4">5 Hari Uang Kembali</h3>
                    <p class="text-gray-400 text-sm leading-relaxed font-semibold">Tidak puas dengan mobil pilihan Anda? Kembalikan dalam 5 hari dan dapatkan refund penuh tanpa potongan.</p>
                </div>
                <!-- Card 3 -->
                <div class="bg-white/5 border border-white/10 p-10 rounded-[40px] hover:bg-white/10 hover:shadow-2xl hover:scale-[1.02] hover:-translate-y-1 transition-all duration-500 group backdrop-blur-md">
                    <div class="w-16 h-16 bg-secondary/10 rounded-2xl flex items-center justify-center text-3xl text-secondary mb-8 group-hover:bg-secondary group-hover:text-white transition-all shadow-sm"><i class='bx bx-car'></i></div>
                    <h3 class="text-2xl font-black text-white uppercase tracking-tight mb-4">Bukan Bekas Banjir</h3>
                    <p class="text-gray-400 text-sm leading-relaxed font-semibold">Kami menjamin 100% unit kami bebas dari kerusakan akibat banjir maupun kecelakaan besar (major accident).</p>
                </div>
                <!-- Card 4 -->
                <div class="bg-white/5 border border-white/10 p-10 rounded-[40px] hover:bg-white/10 hover:shadow-2xl hover:scale-[1.02] hover:-translate-y-1 transition-all duration-500 group backdrop-blur-md">
                    <div class="w-16 h-16 bg-secondary/10 rounded-2xl flex items-center justify-center text-3xl text-secondary mb-8 group-hover:bg-secondary group-hover:text-white transition-all shadow-sm"><i class='bx bx-file'></i></div>
                    <h3 class="text-2xl font-black text-white uppercase tracking-tight mb-4">Dokumen Lengkap</h3>
                    <p class="text-gray-400 text-sm leading-relaxed font-semibold">Seluruh surat-surat kendaraan (STNK, BPKB, Faktur) telah diverifikasi keaslian dan legalitasnya.</p>
                </div>
                <!-- Card 5 -->
                <div class="bg-white/5 border border-white/10 p-10 rounded-[40px] hover:bg-white/10 hover:shadow-2xl hover:scale-[1.02] hover:-translate-y-1 transition-all duration-500 group backdrop-blur-md">
                    <div class="w-16 h-16 bg-secondary/10 rounded-2xl flex items-center justify-center text-3xl text-secondary mb-8 group-hover:bg-secondary group-hover:text-white transition-all shadow-sm"><i class='bx bx-wrench'></i></div>
                    <h3 class="text-2xl font-black text-white uppercase tracking-tight mb-4">Garansi 1 Tahun</h3>
                    <p class="text-gray-400 text-sm leading-relaxed font-semibold">Memberikan rasa aman ekstra dengan garansi mesin dan transmisi selama 1 tahun penuh.</p>
                </div>
                <!-- Card 6 -->
                <div class="bg-white/5 border border-white/10 p-10 rounded-[40px] hover:bg-white/10 hover:shadow-2xl hover:scale-[1.02] hover:-translate-y-1 transition-all duration-500 group backdrop-blur-md">
                    <div class="w-16 h-16 bg-secondary/10 rounded-2xl flex items-center justify-center text-3xl text-secondary mb-8 group-hover:bg-secondary group-hover:text-white transition-all shadow-sm"><i class='bx bx-home-heart'></i></div>
                    <h3 class="text-2xl font-black text-white uppercase tracking-tight mb-4">Kirim ke Rumah</h3>
                    <p class="text-gray-400 text-sm leading-relaxed font-semibold">Cukup duduk manis di rumah, kami akan mengirimkan mobil impian Anda langsung ke garasi Anda.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
