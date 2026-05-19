@extends('layouts.guest')
@section('title', $mobil->merk . ' ' . $mobil->model . ' - DriveHub')
@section('content')
<style>.hide-scrollbar::-webkit-scrollbar { display: none; } .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }</style>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pt-36">

        <!-- Breadcrumb -->
        <div class="flex items-center text-sm text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-primary">Beranda</a>
            <i class='bx bx-chevron-right mx-1'></i>
            <a href="{{ route('catalog.index') }}" class="hover:text-primary">Mobil Bekas</a>
            <i class='bx bx-chevron-right mx-1'></i>
            <span class="text-gray-800 font-medium">{{ $mobil->merk }} {{ $mobil->model }}</span>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">

            <!-- Left Column: Gallery & Details -->
            <div class="w-full lg:w-2/3">

                <!-- Main Gallery -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-200 mb-8">
                    <div class="relative aspect-[16/9] bg-gray-100">
                        <img id="main-image" src="{{ $mobil->gambar_url }}" alt="{{ $mobil->merk }} {{ $mobil->model }}" class="w-full h-full object-cover">
                        @if($mobil->status_mobil === 'Tersedia')
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-4 py-1.5 text-sm font-bold text-dark rounded-full shadow-sm flex items-center gap-2">
                            <i class='bx bxs-check-shield text-green-500'></i> DriveHub Certified
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Highlights -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center">
                        <i class='bx bx-tachometer text-3xl text-gray-400 mb-2'></i>
                        <span class="text-xs text-gray-500 mb-1">Kilometer</span>
                        <span class="font-bold text-dark">{{ number_format($mobil->kilometer) }} km</span>
                    </div>
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center">
                        <i class='bx bx-cog text-3xl text-gray-400 mb-2'></i>
                        <span class="text-xs text-gray-500 mb-1">Transmisi</span>
                        <span class="font-bold text-dark">{{ $mobil->transmisi === 'A/T' ? 'Automatic' : 'Manual' }}</span>
                    </div>
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center">
                        <i class='bx bx-gas-pump text-3xl text-gray-400 mb-2'></i>
                        <span class="text-xs text-gray-500 mb-1">Bahan Bakar</span>
                        <span class="font-bold text-dark">{{ $mobil->deskripsi ?? 'Bensin' }}</span>
                    </div>
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center">
                        <i class='bx bx-calendar text-3xl text-gray-400 mb-2'></i>
                        <span class="text-xs text-gray-500 mb-1">Tahun</span>
                        <span class="font-bold text-dark">{{ $mobil->tahun_produksi }}</span>
                    </div>
                </div>

                <!-- Car Specs Section -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 md:p-8 mb-8">
                    <h3 class="text-xl font-bold text-dark mb-6 border-b border-gray-100 pb-4">Spesifikasi Lengkap</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4">
                        <div class="flex justify-between py-3 border-b border-gray-50"><span class="text-gray-500">Merek</span><span class="font-semibold text-dark">{{ $mobil->merk }}</span></div>
                        <div class="flex justify-between py-3 border-b border-gray-50"><span class="text-gray-500">Model</span><span class="font-semibold text-dark">{{ $mobil->model }}</span></div>
                        <div class="flex justify-between py-3 border-b border-gray-50"><span class="text-gray-500">Warna</span><span class="font-semibold text-dark">{{ $mobil->warna }}</span></div>
                        <div class="flex justify-between py-3 border-b border-gray-50"><span class="text-gray-500">No. Polisi</span><span class="font-semibold text-dark">{{ $mobil->nomor_polisi }}</span></div>
                        <div class="flex justify-between py-3 border-b border-gray-50"><span class="text-gray-500">STNK</span><span class="font-semibold text-dark">{{ $mobil->status_stnk }}</span></div>
                        <div class="flex justify-between py-3 border-b border-gray-50"><span class="text-gray-500">BPKB</span><span class="font-semibold text-dark">{{ $mobil->status_bpkb }}</span></div>
                    </div>
                </div>

                <!-- Inspection Report -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 md:p-8">
                    <h3 class="text-xl font-bold text-dark mb-6 border-b border-gray-100 pb-4">Laporan Inspeksi 175 Titik</h3>
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-green-100 text-green-500 flex items-center justify-center shrink-0 mt-1"><i class='bx bx-check'></i></div>
                            <div><h4 class="font-semibold text-dark">Bebas Tabrakan Besar & Banjir</h4><p class="text-gray-500 text-sm mt-1">Struktur rangka dalam kondisi sempurna.</p></div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-green-100 text-green-500 flex items-center justify-center shrink-0 mt-1"><i class='bx bx-check'></i></div>
                            <div><h4 class="font-semibold text-dark">Mesin & Transmisi Optimal</h4><p class="text-gray-500 text-sm mt-1">Performa mesin halus, transmisi responsif.</p></div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-green-100 text-green-500 flex items-center justify-center shrink-0 mt-1"><i class='bx bx-check'></i></div>
                            <div><h4 class="font-semibold text-dark">Kelistrikan Berfungsi Penuh</h4><p class="text-gray-500 text-sm mt-1">Semua fitur elektronik berfungsi normal 100%.</p></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Price & Action -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sticky top-28">
                    <h1 class="text-2xl font-bold text-dark mb-2">{{ $mobil->merk }} {{ $mobil->model }}</h1>
                    <div class="text-sm text-gray-500 mb-6 flex items-center gap-2">
                        <i class='bx bx-map'></i> {{ $mobil->warna }} • {{ $mobil->tahun_produksi }}
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl mb-6 border border-gray-100">
                        <div class="text-sm text-gray-500 mb-1">Harga Tunai</div>
                        <div class="text-3xl font-extrabold text-primary">Rp {{ number_format($mobil->harga, 0, ',', '.') }}</div>
                    </div>

                    <!-- Actions -->
                    <div class="space-y-3 mb-8">
                        @if($mobil->status_mobil === 'Tersedia')
                            @auth
                                <a href="{{ route('booking.create', $mobil->id) }}" class="flex items-center justify-center gap-2 w-full bg-primary text-white py-4 rounded-xl font-bold text-lg hover:bg-primaryHover transition-transform transform hover:-translate-y-1 shadow-md">
                                    Booking Sekarang <i class='bx bx-right-arrow-alt text-2xl'></i>
                                </a>
                            @else
                                <button @click="showLogin = true" class="flex items-center justify-center gap-2 w-full bg-primary text-white py-4 rounded-xl font-bold text-lg hover:bg-primaryHover transition-transform transform hover:-translate-y-1 shadow-md">
                                    Booking Sekarang <i class='bx bx-right-arrow-alt text-2xl'></i>
                                </button>
                            @endauth
                        @else
                            <div class="flex items-center justify-center gap-2 w-full bg-gray-300 text-gray-600 py-4 rounded-xl font-bold text-lg cursor-not-allowed">
                                Mobil Sudah Di-booking
                            </div>
                        @endif
                        
                        <a href="https://wa.me/6283890103616?text=Halo DriveHub, saya tertarik dengan unit {{ $mobil->merk }} {{ $mobil->model }} ({{ $mobil->tahun_produksi }})" target="_blank" class="flex items-center justify-center gap-2 w-full bg-green-500 text-white py-3.5 rounded-xl font-semibold hover:bg-green-600 transition-colors shadow-sm">
                            <i class='bx bxl-whatsapp text-xl'></i> Tanya via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommended Cars Section -->
        <div class="mt-20 border-t border-gray-100 pt-16 mb-16">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-3xl font-black text-dark tracking-tighter">Mobil Serupa <span class="text-primary italic">Untuk Anda</span></h2>
                    <p class="text-gray-500">Pilihan alternatif dengan kriteria yang mirip.</p>
                </div>
                <a href="{{ route('catalog.index') }}" class="text-primary font-bold hover:underline">Lihat Semua Katalog</a>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    // Simulate similar cars - in real world this should be from controller
                    $similarCars = \App\Models\Mobil::where('id', '!=', $mobil->id)
                        ->where('merk', $mobil->merk)
                        ->take(4)
                        ->get();
                    
                    if($similarCars->isEmpty()) {
                        $similarCars = \App\Models\Mobil::where('id', '!=', $mobil->id)
                            ->take(4)
                            ->get();
                    }
                @endphp
                @foreach($similarCars as $similar)
                    @include('components.car-card', ['mobil' => $similar])
                @endforeach
            </div>
        </div>
    </main>
@endsection
