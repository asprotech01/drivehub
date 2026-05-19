@extends('layouts.guest')
@section('title', 'Halaman Tidak Ditemukan - DriveHub')
@section('content')
<div class="min-h-[70vh] flex items-center justify-center pt-20">
    <div class="text-center px-4">
        <h1 class="text-9xl font-extrabold text-primary animate-bounce">404</h1>
        <h2 class="text-3xl font-bold text-dark mt-4 mb-6">Ops! Halaman Hilang di Jalan</h2>
        <p class="text-gray-500 max-w-md mx-auto mb-10 text-lg">Halaman yang Anda cari mungkin sudah dipindahkan, dihapus, atau tidak pernah ada. Mari kembali ke jalur yang benar.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('home') }}" class="bg-primary text-white px-8 py-4 rounded-xl font-bold hover:bg-primaryHover transition-all shadow-lg flex items-center justify-center gap-2">
                <i class='bx bx-home-alt text-xl'></i> Kembali ke Beranda
            </a>
            <a href="{{ route('catalog.index') }}" class="border border-gray-300 text-dark px-8 py-4 rounded-xl font-bold hover:bg-gray-50 transition-all flex items-center justify-center gap-2">
                <i class='bx bx-search text-xl'></i> Cari Mobil Lain
            </a>
        </div>
    </div>
</div>
@endsection
