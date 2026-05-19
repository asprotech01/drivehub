@extends('layouts.auth')
@section('title', 'Daftar - DriveHub')
@section('content')
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="p-8">
            <div class="flex justify-center mb-6">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img class="h-10 w-auto" src="{{ asset('Assets/Logo/logo-dh.png') }}" alt="DriveHub Logo">
                    <span class="font-bold text-2xl text-primary tracking-tight">DriveHub</span>
                </a>
            </div>

            <h2 class="text-2xl font-bold text-center text-dark mb-2">Buat Akun Baru</h2>
            <p class="text-center text-gray-500 text-sm mb-8">Bergabunglah dan temukan mobil impian Anda dengan mudah.</p>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" required value="{{ old('name') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="Masukkan nama lengkap Anda">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required value="{{ old('email') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="Masukkan alamat email Anda">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Handphone</label>
                    <input type="tel" name="phone" required value="{{ old('phone') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="Masukkan nomor WhatsApp aktif Anda">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input type="password" name="password" required class="w-full border border-gray-300 rounded-lg pl-4 pr-10 py-2.5 focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="Masukkan kata sandi Anda (minimal 8 karakter)">
                        <i class='bx bx-hide absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 cursor-pointer hover:text-gray-600' onclick="this.previousElementSibling.type = this.previousElementSibling.type === 'password' ? 'text' : 'password'; this.classList.toggle('bx-hide'); this.classList.toggle('bx-show');"></i>
                    </div>
                </div>

                <div class="pt-2">
                    <label class="flex items-start gap-2 cursor-pointer">
                        <input type="checkbox" required class="mt-1 w-4 h-4 text-primary rounded border-gray-300 focus:ring-primary accent-primary">
                        <span class="text-xs text-gray-500">Saya menyetujui <a href="#" class="text-primary hover:underline">Syarat & Ketentuan</a> serta <a href="#" class="text-primary hover:underline">Kebijakan Privasi</a> DriveHub.</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-bold hover:bg-primaryHover transition-colors mt-4">
                    Daftar Sekarang
                </button>
            </form>

            <div class="mt-6 text-center text-sm text-gray-600">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-primary font-bold hover:underline">Masuk di sini</a>
            </div>
        </div>
    </div>
@endsection
