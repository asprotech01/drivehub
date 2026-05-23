@extends('layouts.guest')
@section('title', 'DriveHub - Jual Beli Mobil Bekas Terpercaya')

@push('styles')
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    .hero-swiper { width: 100%; border-radius: 48px; overflow: hidden; height: 500px; }
    .swiper-button-next, .swiper-button-prev { 
        background: white; width: 44px; height: 44px; border-radius: 50%; 
        color: #111827; box-shadow: 0 4px 12px rgba(0,0,0,0.1); 
    }
    .swiper-button-next:after, .swiper-button-prev:after { font-size: 18px; font-weight: bold; }
    .swiper-pagination-bullet { background: #cbd5e1; opacity: 1; }
    .swiper-pagination-bullet-active { background: #3B82F6; width: 24px; border-radius: 4px; }
    
    /* Background Pattern */
    .bg-pattern {
        background-image: radial-gradient(#1E3A8A 1px, transparent 1px);
        background-size: 24px 24px;
    }
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="pt-32 pb-12 bg-[#0f172a]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Main Carousel -->
            <div class="swiper hero-swiper mb-12 shadow-2xl">
                <div class="swiper-wrapper">
                    <!-- Slide 1 -->
                    <div class="swiper-slide relative">
                        <img src="https://images.unsplash.com/photo-1617788138017-80ad40651399?q=80&w=1200&auto=format&fit=crop" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-dark/80 via-dark/40 to-transparent flex items-center p-16">
                            <div class="max-w-xl space-y-6 text-white">
                                <span class="bg-secondary/20 backdrop-blur-md border border-secondary/30 text-secondary text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-xl">DriveHub Exclusive Promo</span>
                                <h2 class="text-5xl font-black uppercase tracking-tighter leading-none">Promo Megasale <br><span class="text-secondary">DriveHub Certified</span></h2>
                                <p class="text-lg font-medium opacity-90">Dapatkan cashback hingga Rp 15 Juta, bunga mulai 0%, dan garansi mesin + transmisi gratis 1 tahun!</p>
                                <a href="{{ route('catalog.index') }}" class="inline-block bg-secondary text-white px-8 py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-secondaryHover transition-all shadow-lg shadow-secondary/20">Ambil Promo</a>
                            </div>
                        </div>
                        <!-- Branded Watermark Logo inside slide -->
                        <div class="absolute top-8 right-8 bg-dark/40 backdrop-blur-md px-4 py-2.5 rounded-2xl border border-white/10 flex items-center gap-2 shadow-lg">
                            <span class="text-white font-black tracking-tight text-sm uppercase">Drive<span class="text-secondary">Hub</span></span>
                            <span class="w-1.5 h-1.5 bg-secondary rounded-full animate-ping"></span>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="swiper-slide relative">
                        <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=1200&auto=format&fit=crop" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-dark/80 via-dark/40 to-transparent flex items-center p-16">
                            <div class="max-w-xl space-y-6 text-white">
                                <span class="bg-white/10 backdrop-blur-md border border-white/20 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-xl">DriveHub Quality Check</span>
                                <h2 class="text-5xl font-black uppercase tracking-tighter leading-none">Garansi Aman <br><span class="text-secondary italic">Inspeksi 175 Titik</span></h2>
                                <p class="text-lg font-medium opacity-90">Setiap mobil melalui inspeksi ketat untuk menjamin 100% bebas dari banjir, tabrakan besar, dan manipulasi odometer.</p>
                                <a href="{{ route('why-us') }}" class="inline-block bg-primary text-white px-8 py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-primaryHover transition-all shadow-lg shadow-primary/20">Lihat Standar Kami</a>
                            </div>
                        </div>
                        <!-- Branded Watermark Logo inside slide -->
                        <div class="absolute top-8 right-8 bg-dark/40 backdrop-blur-md px-4 py-2.5 rounded-2xl border border-white/10 flex items-center gap-2 shadow-lg">
                            <span class="text-white font-black tracking-tight text-sm uppercase">Drive<span class="text-secondary">Hub</span></span>
                            <span class="w-1.5 h-1.5 bg-secondary rounded-full animate-ping"></span>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>

            <!-- Beli Mobil Section -->
            <div class="max-w-7xl mx-auto mt-8 relative z-20 bg-white rounded-[48px] shadow-[0_40px_100px_-15px_rgba(0,0,0,0.15)] overflow-hidden border border-gray-50">
                
                <!-- Beli Mobil -->
                <div class="p-8 md:p-12 flex flex-col">
                    <div class="flex items-center gap-2 mb-8">
                        <h2 class="text-2xl font-black text-dark uppercase tracking-tight">Beli Mobil</h2>
                    </div>

                    <form action="{{ route('catalog.index') }}" method="GET" class="relative mb-6">
                        <i class='bx bx-search absolute left-6 top-1/2 -translate-y-1/2 text-2xl text-gray-400'></i>
                        <input type="text" name="search" placeholder="Cari mobil menurut Merek, Model, atau Kata Kunci" class="w-full bg-gray-50 border-none rounded-2xl py-5 pl-16 pr-8 text-dark font-bold focus:ring-2 focus:ring-primary/10 outline-none">
                    </form>

                    <!-- Brand Grid -->
                    <div class="grid grid-cols-4 md:grid-cols-8 gap-6 mb-6">
                        @php
                            $brands_list = [
                                ['name' => 'Honda', 'logo' => 'https://cdn.jsdelivr.net/gh/filippofilip95/car-logos-dataset@master/logos/thumb/honda.png'],
                                ['name' => 'Toyota', 'logo' => 'https://cdn.jsdelivr.net/gh/filippofilip95/car-logos-dataset@master/logos/thumb/toyota.png'],
                                ['name' => 'Suzuki', 'logo' => 'https://cdn.jsdelivr.net/gh/filippofilip95/car-logos-dataset@master/logos/thumb/suzuki.png'],
                                ['name' => 'Nissan', 'logo' => 'https://cdn.jsdelivr.net/gh/filippofilip95/car-logos-dataset@master/logos/thumb/nissan.png'],
                                ['name' => 'Mitsubishi', 'logo' => 'https://cdn.jsdelivr.net/gh/filippofilip95/car-logos-dataset@master/logos/thumb/mitsubishi.png'],
                                ['name' => 'Daihatsu', 'logo' => 'https://cdn.jsdelivr.net/gh/filippofilip95/car-logos-dataset@master/logos/thumb/daihatsu.png'],
                                ['name' => 'Mazda', 'logo' => 'https://cdn.jsdelivr.net/gh/filippofilip95/car-logos-dataset@master/logos/thumb/mazda.png'],
                                ['name' => 'Hyundai', 'logo' => 'https://cdn.jsdelivr.net/gh/filippofilip95/car-logos-dataset@master/logos/thumb/hyundai.png'],
                            ];
                        @endphp
                        @foreach($brands_list as $b)
                        <a href="{{ route('catalog.index', ['search' => $b['name']]) }}" class="group text-center space-y-2">
                            <div class="aspect-square bg-white border border-gray-100 rounded-2xl flex items-center justify-center p-3 group-hover:border-primary group-hover:shadow-lg transition-all">
                                <img src="{{ $b['logo'] }}" class="w-full h-full object-contain grayscale group-hover:grayscale-0 transition-all">
                            </div>
                            <span class="text-[9px] font-black uppercase tracking-widest text-gray-400 group-hover:text-dark transition-colors">{{ $b['name'] }}</span>
                        </a>
                        @endforeach
                    </div>

                    <!-- Type Grid -->
                    <div class="grid grid-cols-4 md:grid-cols-8 gap-4 mb-6">
                        @php
                            $types_list = [
                                ['name' => 'Hatchback', 'icon' => 'bx-car'],
                                ['name' => 'MPV', 'icon' => 'bxs-car'],
                                ['name' => 'SUV', 'icon' => 'bxs-truck'],
                                ['name' => 'Sedan', 'icon' => 'bxs-car-garage'],
                                ['name' => 'Wagon', 'icon' => 'bx-car'],
                                ['name' => 'Coupe', 'icon' => 'bxs-car'],
                                ['name' => 'Van', 'icon' => 'bxs-bus'],
                                ['name' => 'Truck', 'icon' => 'bxs-truck'],
                            ];
                        @endphp
                        @foreach($types_list as $t)
                        <a href="{{ route('catalog.index', ['search' => $t['name']]) }}" class="group text-center space-y-3">
                            <i class='bx {{ $t['icon'] }} text-3xl text-gray-300 group-hover:text-primary transition-colors'></i>
                            <div class="text-[9px] font-black uppercase tracking-widest text-gray-400 group-hover:text-dark transition-colors">{{ $t['name'] }}</div>
                        </a>
                        @endforeach
                    </div>

                    <!-- Category Filters -->
                    <div class="flex flex-wrap gap-3 mb-4">
                        <a href="{{ route('catalog.index', ['max_price' => 150000000]) }}" class="bg-gray-50 px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest text-gray-500 hover:bg-primary/5 hover:text-primary transition-all">Di bawah Rp 150 Juta</a>
                        <a href="{{ route('catalog.index', ['min_price' => 150000000, 'max_price' => 250000000]) }}" class="bg-gray-50 px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest text-gray-500 hover:bg-primary/5 hover:text-primary transition-all">Rp 150 - 250 Juta</a>
                        <a href="{{ route('catalog.index', ['min_price' => 250000000, 'max_price' => 350000000]) }}" class="bg-gray-50 px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest text-gray-500 hover:bg-primary/5 hover:text-primary transition-all">Rp 250 - 350 Juta</a>
                        <a href="{{ route('catalog.index', ['min_price' => 350000000]) }}" class="bg-gray-50 px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest text-gray-500 hover:bg-primary/5 hover:text-primary transition-all">Di atas Rp 350 Juta</a>
                        <a href="{{ route('catalog.index') }}" class="bg-primary/5 px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest text-primary hover:bg-primary hover:text-white transition-all">Tampilkan Semua</a>
                    </div>

                    <!-- Bottom Banner -->
                    <div class="bg-secondary/5 rounded-3xl p-6 flex flex-col md:flex-row items-center justify-between gap-6 border border-secondary/10 mt-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-secondary rounded-full flex items-center justify-center text-white text-2xl"><i class='bx bx-search-alt'></i></div>
                            <div>
                                <h4 class="font-black text-dark text-sm uppercase">Lagi cari mobil?</h4>
                                <p class="text-xs text-gray-500 font-medium">Biarkan kami membantu menemukan mobil yang Anda inginkan.</p>
                            </div>
                        </div>
                        <a href="{{ route('contact') }}" class="bg-secondary text-white px-8 py-3 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-secondaryHover transition-all shadow-lg shadow-secondary/20">Cari Mobil</a>
                    </div>
                </div>


            </div>
        </div>
    </section>

    <!-- Keunggulan DriveHub -->
    <section class="py-24 bg-[#f1f5f9] relative overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-[0.05] bg-pattern"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16 space-y-4">
                <div class="text-xs font-black text-primary uppercase tracking-[0.3em]">Keunggulan Kami</div>
                <h2 class="text-4xl md:text-5xl font-black text-dark tracking-tighter uppercase leading-none">Standar Baru <br> <span class="text-primary italic">Pasar Mobil Bekas</span></h2>
                <p class="text-gray-500 font-medium max-w-2xl mx-auto">Kami menghadirkan transparansi dan kualitas tanpa kompromi untuk setiap unit yang Anda beli.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-12 rounded-[48px] shadow-xl shadow-blue-900/5 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 group">
                    <div class="w-16 h-16 bg-primary/5 rounded-3xl flex items-center justify-center text-4xl text-primary mb-10 group-hover:bg-primary group-hover:text-white transition-all">
                        <i class='bx bx-check-shield'></i>
                    </div>
                    <h3 class="text-2xl font-black text-dark mb-4 tracking-tight uppercase">Inspeksi 175 Titik</h3>
                    <p class="text-gray-500 text-sm leading-relaxed font-medium">Laporan kondisi mobil lengkap dan transparan, mencakup mesin, eksterior, dan interior.</p>
                </div>
                <div class="bg-white p-12 rounded-[48px] shadow-xl shadow-blue-900/5 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 group">
                    <div class="w-16 h-16 bg-primary/5 rounded-3xl flex items-center justify-center text-4xl text-primary mb-10 group-hover:bg-primary group-hover:text-white transition-all">
                        <i class='bx bx-timer'></i>
                    </div>
                    <h3 class="text-2xl font-black text-dark mb-4 tracking-tight uppercase">Garansi 1 Tahun</h3>
                    <p class="text-gray-500 text-sm leading-relaxed font-medium">Jaminan ketenangan pikiran untuk perbaikan mesin dan transmisi selama setahun penuh.</p>
                </div>
                <div class="bg-white p-12 rounded-[48px] shadow-xl shadow-blue-900/5 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 group">
                    <div class="w-16 h-16 bg-primary/5 rounded-3xl flex items-center justify-center text-4xl text-primary mb-10 group-hover:bg-primary group-hover:text-white transition-all">
                        <i class='bx bx-money-withdraw'></i>
                    </div>
                    <h3 class="text-2xl font-black text-dark mb-4 tracking-tight uppercase">5 Hari Refund</h3>
                    <p class="text-gray-500 text-sm leading-relaxed font-medium">Beli tanpa risiko. Jika tidak cocok, kembalikan dalam 5 hari untuk pengembalian dana penuh.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Cars -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-16">
                <div>
                    <h2 class="text-4xl font-black text-dark uppercase tracking-tighter leading-none">Pilihan <span class="text-primary italic">Mobil Bekas</span></h2>
                    <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mt-2">Kualitas Terjamin & Bergaransi</p>
                </div>
                <a href="{{ route('catalog.index') }}" class="text-primary font-black uppercase tracking-widest text-[10px] hover:underline flex items-center gap-2">Lihat Semua <i class='bx bx-right-arrow-alt text-xl'></i></a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($featuredCars as $mobil)
                    @include('components.car-card', ['mobil' => $mobil])
                @endforeach
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-dark relative overflow-hidden rounded-[64px] py-20 px-8">
                <div class="absolute top-0 right-0 w-64 h-64 bg-primary opacity-10 rounded-full -mr-32 -mt-32"></div>
                <div class="max-w-3xl mx-auto relative z-10 text-center">
                    <h2 class="text-3xl md:text-5xl font-black text-white mb-6 tracking-tighter uppercase leading-none">Cari mobil impian <br> <span class="text-primary italic">Tanpa Ribet</span></h2>
                    <p class="text-gray-400 mb-10 font-medium">Berlangganan newsletter kami untuk update stok terbaru dan promo eksklusif.</p>
                    <form action="#" class="flex flex-col md:flex-row gap-4 max-w-2xl mx-auto">
                        <input type="email" placeholder="Alamat Email Anda" class="flex-1 bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:bg-white/10 outline-none transition-all placeholder-gray-500 font-medium">
                        <button type="submit" class="bg-primary text-white px-10 py-4 rounded-2xl font-black uppercase text-xs tracking-[0.2em] hover:bg-primaryHover transition-all shadow-xl shadow-primary/20">Berlangganan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    const swiper = new Swiper('.hero-swiper', {
        loop: true,
        autoplay: { delay: 5000 },
        pagination: { el: '.swiper-pagination', clickable: true },
        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
    });
    

    
    window.addEventListener('scroll', () => {
        const nav = document.getElementById('navbar');
        if (window.scrollY > 20) {
            nav.classList.add('shadow-md');
        } else {
            nav.classList.remove('shadow-md');
        }
    });
</script>
@endpush