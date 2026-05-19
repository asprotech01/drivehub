@extends('layouts.guest')
@section('title', 'Tentang Kami - DriveHub')
@section('content')
    <section class="relative bg-[#1e293b] pt-36 pb-24 overflow-hidden min-h-[90vh] flex items-center">
        <!-- Full-Bleed Background Image with Slate Parallax Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?q=80&w=1600&auto=format&fit=crop" class="w-full h-full object-cover opacity-40 scale-105 transform transition-all duration-1000">
            <div class="absolute inset-0 bg-gradient-to-tr from-[#1e293b] via-[#1e293b]/95 to-transparent"></div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="text-center mb-16 space-y-4">
                <div class="inline-flex items-center gap-2 bg-secondary/10 px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest text-secondary border border-secondary/20">
                    <i class='bx bx-info-circle text-sm'></i>
                    Revolusi Industri Mobil Bekas
                </div>
                <h1 class="text-5xl md:text-7xl font-black text-white tracking-tighter uppercase leading-[0.95]">
                    TENTANG <br><span class="text-secondary italic">DRIVEHUB</span>
                </h1>
                <div class="w-20 h-1.5 bg-secondary mx-auto rounded-full mt-4"></div>
            </div>

            <div class="space-y-12 text-center">
                <p class="text-lg text-gray-300 font-semibold leading-relaxed max-w-3xl mx-auto">
                    DriveHub lahir dari visi untuk merevolusi industri jual beli mobil bekas di Indonesia. Kami memahami bahwa membeli mobil adalah salah satu keputusan finansial terbesar bagi banyak orang, dan kami percaya proses tersebut harus didasari oleh transparansi dan kepercayaan mutlak.
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-8">
                    <div class="bg-white/5 border border-white/10 p-10 rounded-[40px] text-left hover:bg-white/10 hover:shadow-2xl hover:scale-[1.02] transition-all duration-300 backdrop-blur-md">
                        <div class="w-12 h-12 bg-secondary/10 rounded-2xl flex items-center justify-center text-secondary text-2xl mb-6"><i class='bx bx-paper-plane'></i></div>
                        <h3 class="text-2xl font-black text-white uppercase tracking-tight mb-4">Misi Kami</h3>
                        <p class="text-xs text-gray-400 font-semibold leading-relaxed">Memberdayakan pelanggan dengan menyediakan data yang jujur, unit yang tersertifikasi, dan layanan purna jual yang tidak tertandingi.</p>
                    </div>
                    <div class="bg-white/5 border border-white/10 p-10 rounded-[40px] text-left hover:bg-white/10 hover:shadow-2xl hover:scale-[1.02] transition-all duration-300 backdrop-blur-md">
                        <div class="w-12 h-12 bg-secondary/10 rounded-2xl flex items-center justify-center text-secondary text-2xl mb-6"><i class='bx bx-navigation'></i></div>
                        <h3 class="text-2xl font-black text-white uppercase tracking-tight mb-4">Visi Kami</h3>
                        <p class="text-xs text-gray-400 font-semibold leading-relaxed">Menjadi ekosistem otomotif paling terpercaya di Asia Tenggara, di mana setiap transaksi membawa kebahagiaan bagi pemilik baru.</p>
                    </div>
                </div>

                <p class="pt-8 text-sm text-gray-500 font-semibold max-w-2xl mx-auto leading-relaxed">
                    Didukung oleh teknologi inspeksi modern dan tim ahli yang berpengalaman, DriveHub memastikan setiap mobil yang ada di katalog kami adalah unit terbaik yang bebas dari kecelakaan besar dan kerusakan banjir.
                </p>
            </div>
        </div>
    </section>
@endsection
