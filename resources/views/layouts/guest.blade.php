<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DriveHub - Jual Beli Mobil Bekas Terpercaya')</title>
    <meta name="description" content="@yield('meta_description', 'Platform jual beli mobil bekas terpercaya. Menghadirkan transparansi, keamanan, dan kenyamanan dalam setiap transaksi.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: '#1E3A8A', primaryHover: '#1e40af',
                        secondary: '#3B82F6', secondaryHover: '#2563EB',
                        dark: '#111827', light: '#F3F4F6',
                    }
                }
            }
        }
    </script>
    <style>
        .glass-effect { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .animate-fade-in-up { animation: fadeInUp 0.6s ease-out; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        
        /* Vertical Scroll Animation */
        .animate-vertical-scroll {
            animation: verticalScroll 8s infinite cubic-bezier(0.65, 0, 0.35, 1);
        }
        @keyframes verticalScroll {
            0%, 20% { transform: translateY(0); }
            25%, 45% { transform: translateY(-1.1em); }
            50%, 70% { transform: translateY(-2.2em); }
            75%, 100% { transform: translateY(-3.3em); }
        }
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>

<body x-data="{ 
    showLogin: false, 
    showRegister: false,
    openLogin() { this.showLogin = true; this.showRegister = false; },
    openRegister() { this.showRegister = true; this.showLogin = false; },
    close() { this.showLogin = false; this.showRegister = false; }
}" 
@open-login.window="openLogin()" 
@open-register.window="openRegister()"
class="font-sans text-gray-800 bg-gray-50 antialiased">

    @include('components.navbar', ['activePage' => $activePage ?? 'home'])

    <main>
        @if(session('success'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 5000)" 
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="fixed top-28 right-6 z-[9999] max-w-sm w-full bg-white/95 border border-green-200 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] p-4 backdrop-blur-md flex items-start gap-3"
                 x-cloak>
                <div class="w-8 h-8 bg-green-100 rounded-xl flex items-center justify-center text-green-600 text-lg shrink-0">
                    <i class='bx bx-check-circle'></i>
                </div>
                <div class="flex-1">
                    <div class="text-xs font-black text-dark uppercase tracking-wide">Sukses</div>
                    <div class="text-xs text-gray-500 font-semibold mt-0.5 leading-relaxed">{{ session('success') }}</div>
                </div>
                <button @click="show = false" class="text-gray-400 hover:text-dark transition-colors"><i class='bx bx-x text-xl'></i></button>
            </div>
        @endif
        @if(session('error'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 5000)" 
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="fixed top-28 right-6 z-[9999] max-w-sm w-full bg-white/95 border border-red-200 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] p-4 backdrop-blur-md flex items-start gap-3"
                 x-cloak>
                <div class="w-8 h-8 bg-red-100 rounded-xl flex items-center justify-center text-red-600 text-lg shrink-0">
                    <i class='bx bx-error-circle'></i>
                </div>
                <div class="flex-1">
                    <div class="text-xs font-black text-dark uppercase tracking-wide">Terjadi Kesalahan</div>
                    <div class="text-xs text-gray-500 font-semibold mt-0.5 leading-relaxed">{{ session('error') }}</div>
                </div>
                <button @click="show = false" class="text-gray-400 hover:text-dark transition-colors"><i class='bx bx-x text-xl'></i></button>
            </div>
        @endif

        @yield('content')
    </main>

    @include('components.footer')

    <!-- Alpine.js for Modals -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')

    <!-- Login/Register Modals -->
    <div class="relative z-[9999]">
        <!-- Login Modal -->
        <div x-show="showLogin" x-cloak class="fixed inset-0 bg-dark/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div @click.away="close()" class="bg-white rounded-[40px] shadow-2xl w-full max-w-md overflow-hidden animate-fade-in-up">
                <div class="p-10 relative">
                    <button @click="close()" class="absolute top-8 right-8 text-gray-400 hover:text-dark transition-colors text-2xl"><i class='bx bx-x'></i></button>
                    
                    <div class="text-center mb-8">
                        <img src="{{ asset('Assets/Logo/logo-dh.png') }}" class="h-14 w-auto mx-auto mb-4" alt="DriveHub Logo">
                        <h2 class="text-3xl font-black text-dark tracking-tighter uppercase">Selamat <span class="text-primary italic">Datang</span></h2>
                        <p class="text-gray-400 text-sm font-medium mt-1">Masuk untuk melanjutkan ke DriveHub</p>
                    </div>

                    <form action="{{ route('login') }}" method="POST" class="space-y-5">
                        @csrf
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-1">Email</label>
                            <input type="email" name="email" required class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-dark font-bold focus:ring-2 focus:ring-primary/20 transition-all outline-none" placeholder="Masukkan alamat email Anda">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-1">Password</label>
                            <input type="password" name="password" required class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-dark font-bold focus:ring-2 focus:ring-primary/20 transition-all outline-none" placeholder="Masukkan kata sandi Anda">
                        </div>
                        <button type="submit" class="w-full bg-dark text-white py-5 rounded-[24px] font-black uppercase tracking-widest text-sm hover:bg-gray-800 transition-all shadow-xl shadow-gray-200 mt-4">Masuk</button>
                    </form>

                    <div class="mt-8 text-center text-xs font-bold text-gray-400 uppercase tracking-widest">
                        Belum punya akun? <button @click="openRegister()" class="text-primary hover:underline">Daftar sekarang</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Register Modal -->
        <div x-show="showRegister" x-cloak class="fixed inset-0 bg-dark/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div @click.away="close()" class="bg-white rounded-[40px] shadow-2xl w-full max-w-md overflow-hidden animate-fade-in-up">
                <div class="p-10 relative">
                    <button @click="close()" class="absolute top-8 right-8 text-gray-400 hover:text-dark transition-colors text-2xl"><i class='bx bx-x'></i></button>
                    
                    <div class="text-center mb-8">
                        <img src="{{ asset('Assets/Logo/logo-dh.png') }}" class="h-14 w-auto mx-auto mb-4" alt="DriveHub Logo">
                        <h2 class="text-3xl font-black text-dark tracking-tighter uppercase">Buat <span class="text-primary italic">Akun</span></h2>
                        <p class="text-gray-400 text-sm font-medium mt-1">Bergabung dengan komunitas DriveHub</p>
                    </div>

                    <form action="{{ route('register') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-1">Nama Lengkap</label>
                            <input type="text" name="name" required class="w-full bg-gray-50 border-none rounded-2xl px-6 py-3.5 text-dark font-bold focus:ring-2 focus:ring-primary/20 transition-all outline-none" placeholder="Masukkan nama lengkap Anda">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-1">Email</label>
                                <input type="email" name="email" required class="w-full bg-gray-50 border-none rounded-2xl px-6 py-3.5 text-dark font-bold focus:ring-2 focus:ring-primary/20 transition-all outline-none" placeholder="Masukkan alamat email Anda">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-1">No. WhatsApp</label>
                                <input type="text" name="no_hp" required class="w-full bg-gray-50 border-none rounded-2xl px-6 py-3.5 text-dark font-bold focus:ring-2 focus:ring-primary/20 transition-all outline-none" placeholder="Masukkan nomor WhatsApp aktif Anda">
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-1">Alamat Lengkap</label>
                            <input type="text" name="alamat" required class="w-full bg-gray-50 border-none rounded-2xl px-6 py-3.5 text-dark font-bold focus:ring-2 focus:ring-primary/20 transition-all outline-none" placeholder="Masukkan alamat lengkap Anda">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-1">Password</label>
                            <input type="password" name="password" required class="w-full bg-gray-50 border-none rounded-2xl px-6 py-3.5 text-dark font-bold focus:ring-2 focus:ring-primary/20 transition-all outline-none" placeholder="Masukkan kata sandi Anda">
                        </div>
                        <button type="submit" class="w-full bg-dark text-white py-5 rounded-[24px] font-black uppercase tracking-widest text-sm hover:bg-gray-800 transition-all shadow-xl shadow-gray-200 mt-4">Daftar</button>
                    </form>

                    <div class="mt-8 text-center text-xs font-bold text-gray-400 uppercase tracking-widest">
                        Sudah punya akun? <button @click="openLogin()" class="text-primary hover:underline">Masuk di sini</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</html>