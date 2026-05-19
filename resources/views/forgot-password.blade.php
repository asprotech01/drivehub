@extends('layouts.auth')
@section('title', 'Lupa Password - DriveHub')
@section('content')
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="p-8">
            <div class="flex justify-center mb-6">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img class="h-10 w-auto" src="{{ asset('Assets/Logo/logo-dh.png') }}" alt="DriveHub Logo">
                    <span class="font-bold text-2xl text-primary tracking-tight">DriveHub</span>
                </a>
            </div>

            <h2 class="text-2xl font-bold text-center text-dark mb-2">Lupa Kata Sandi?</h2>
            <p class="text-center text-gray-500 text-sm mb-8">Masukkan alamat email Anda yang terdaftar, kami akan mengirimkan tautan untuk mereset kata sandi Anda.</p>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Demo Link for Local Testing --}}
            @if(session('demo_link'))
                <div class="bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded-xl mb-6 text-sm">
                    <div class="font-bold mb-1 flex items-center gap-1.5 text-blue-900">
                        <i class='bx bx-info-circle text-lg'></i> Developer Testing Tool:
                    </div>
                    <p class="mb-3 text-xs">Karena berada di server lokal, email tidak dikirim secara nyata tetapi dicatat di log. Silakan klik tombol di bawah untuk langsung mencoba halaman reset:</p>
                    <a href="{{ session('demo_link') }}" class="inline-flex items-center justify-center w-full bg-blue-600 text-white text-xs font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors shadow">
                        Buka Halaman Reset Kata Sandi &rarr;
                    </a>
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required value="{{ old('email') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="Masukkan alamat email Anda">
                </div>

                <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-bold hover:bg-primaryHover transition-colors mt-4">
                    Kirim Tautan Reset
                </button>
            </form>

            <div class="mt-6 text-center text-sm text-gray-600">
                Kembali ke <a href="{{ route('login') }}" class="text-primary font-bold hover:underline">Halaman Masuk</a>
            </div>

        </div>
    </div>
@endsection
