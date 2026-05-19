@extends('layouts.guest')
@section('title', 'Dealer Kami - Lokasi Showroom DriveHub')
@section('content')
    <section class="relative bg-[#1e293b] pt-36 pb-24 overflow-hidden min-h-[90vh] flex items-center">
        <!-- Full-Bleed Background Image with Slate Parallax Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1563720223185-11003d516935?q=80&w=1600&auto=format&fit=crop" class="w-full h-full object-cover opacity-40 scale-105 transform transition-all duration-1000">
            <div class="absolute inset-0 bg-gradient-to-tr from-[#1e293b] via-[#1e293b]/95 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="text-center mb-16 space-y-4">
                <div class="inline-flex items-center gap-2 bg-secondary/10 px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest text-secondary border border-secondary/20">
                    <i class='bx bx-map text-sm'></i>
                    Temukan Showroom Terdekat
                </div>
                <h1 class="text-5xl md:text-7xl font-black text-white tracking-tighter uppercase leading-[0.95]">
                    DEALER <br><span class="text-secondary italic">KAMI</span>
                </h1>
                <div class="w-20 h-1.5 bg-secondary mx-auto rounded-full mt-4"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Dealer 1 -->
                <div class="bg-white/5 border border-white/10 rounded-[48px] overflow-hidden group hover:border-secondary/30 hover:bg-white/10 hover:shadow-2xl transition-all duration-500 backdrop-blur-md shadow-sm">
                    <div class="aspect-video bg-gray-900 relative overflow-hidden">
                        <!-- Luxury Showroom Interior - Tangerang -->
                        <img src="https://images.unsplash.com/photo-1617788138017-80ad40651399?q=80&w=800&auto=format&fit=crop" alt="Showroom Tangerang" class="w-full h-full object-cover opacity-75 group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#1e293b] via-[#1e293b]/40 to-transparent flex items-end p-10">
                            <h3 class="text-3xl font-black text-white uppercase tracking-tighter">Tangerang</h3>
                        </div>
                    </div>
                    <div class="p-10 space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-secondary/10 rounded-xl flex items-center justify-center text-secondary text-xl shrink-0"><i class='bx bx-map'></i></div>
                            <p class="text-gray-300 font-semibold pt-1.5 text-sm">Jl. BSD Boulevard No. 45, Tangerang</p>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-secondary/10 rounded-xl flex items-center justify-center text-secondary text-xl shrink-0"><i class='bx bx-time'></i></div>
                            <p class="text-gray-300 font-semibold pt-1.5 text-sm">09:00 - 18:00 (Setiap Hari)</p>
                        </div>
                        <a href="https://maps.google.com" target="_blank" class="inline-block bg-secondary text-white px-8 py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-secondaryHover transition-all shadow-md">Lihat di Maps</a>
                    </div>
                </div>

                <!-- Dealer 2 -->
                <div class="bg-white/5 border border-white/10 rounded-[48px] overflow-hidden group hover:border-secondary/30 hover:bg-white/10 hover:shadow-2xl transition-all duration-500 backdrop-blur-md shadow-sm">
                    <div class="aspect-video bg-gray-900 relative overflow-hidden">
                        <!-- Luxury Showroom Interior - Jakarta Selatan -->
                        <img src="https://images.unsplash.com/photo-1563720223185-11003d516935?q=80&w=800&auto=format&fit=crop" alt="Showroom Jakarta" class="w-full h-full object-cover opacity-75 group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#1e293b] via-[#1e293b]/40 to-transparent flex items-end p-10">
                            <h3 class="text-3xl font-black text-white uppercase tracking-tighter">Jakarta Selatan</h3>
                        </div>
                    </div>
                    <div class="p-10 space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-secondary/10 rounded-xl flex items-center justify-center text-secondary text-xl shrink-0"><i class='bx bx-map'></i></div>
                            <p class="text-gray-300 font-semibold pt-1.5 text-sm">Jl. Sudirman No. 123, Jakarta Selatan</p>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-secondary/10 rounded-xl flex items-center justify-center text-secondary text-xl shrink-0"><i class='bx bx-time'></i></div>
                            <p class="text-gray-300 font-semibold pt-1.5 text-sm">09:00 - 18:00 (Setiap Hari)</p>
                        </div>
                        <a href="https://maps.google.com" target="_blank" class="inline-block bg-secondary text-white px-8 py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-secondaryHover transition-all shadow-md">Lihat di Maps</a>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
