@extends('layouts.auth')
@section('title', 'Reset Password - DriveHub')
@section('content')
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="p-8">
            <div class="flex justify-center mb-6">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img class="h-10 w-auto" src="{{ asset('Assets/Logo/logo-dh.png') }}" alt="DriveHub Logo">
                    <span class="font-bold text-2xl text-primary tracking-tight">DriveHub</span>
                </a>
            </div>

            <h2 class="text-2xl font-bold text-center text-dark mb-2">Reset Kata Sandi</h2>
            <p class="text-center text-gray-500 text-sm mb-8">Silakan isi formulir di bawah ini untuk membuat kata sandi baru untuk akun Anda.</p>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required value="{{ old('email', $email) }}" readonly class="w-full bg-gray-100 border border-gray-300 rounded-lg px-4 py-2.5 outline-none cursor-not-allowed text-gray-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                    <div class="relative">
                        <input type="password" name="password" required class="w-full border border-gray-300 rounded-lg pl-4 pr-10 py-2.5 focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="Masukkan kata sandi baru">
                        <i class='bx bx-hide absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 cursor-pointer hover:text-gray-600' onclick="this.previousElementSibling.type = this.previousElementSibling.type === 'password' ? 'text' : 'password'; this.classList.toggle('bx-hide'); this.classList.toggle('bx-show');"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" required class="w-full border border-gray-300 rounded-lg pl-4 pr-10 py-2.5 focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="Konfirmasi kata sandi baru">
                        <i class='bx bx-hide absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 cursor-pointer hover:text-gray-600' onclick="this.previousElementSibling.type = this.previousElementSibling.type === 'password' ? 'text' : 'password'; this.classList.toggle('bx-hide'); this.classList.toggle('bx-show');"></i>
                    </div>
                </div>

                <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-bold hover:bg-primaryHover transition-colors mt-4">
                    Perbarui Kata Sandi
                </button>
            </form>

            <div class="mt-6 text-center text-sm text-gray-600">
                Kembali ke <a href="{{ route('login') }}" class="text-primary font-bold hover:underline">Halaman Masuk</a>
            </div>

        </div>
    </div>
@endsection
