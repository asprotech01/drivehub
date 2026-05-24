<nav class="fixed top-0 w-full z-50 bg-white border-b border-gray-100 transition-all duration-300" id="navbar">
    <!-- Top Utility Bar (Optional, can be integrated into main) -->
    <div class="hidden lg:block bg-gray-50 border-b border-gray-100 py-1.5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center text-[10px] font-bold uppercase tracking-widest text-gray-400">
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-1"><i class='bx bx-map-pin text-primary'></i> Lokasi: <span class="text-dark">Kota Tangerang</span></div>
                <div class="flex items-center gap-1"><i class='bx bx-time text-primary'></i> Jam Kerja: <span class="text-dark">09:00 - 18:00</span></div>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('help') }}" class="hover:text-primary transition-colors">Bantuan</a>
                <a href="{{ route('faq') }}" class="hover:text-primary transition-colors">FAQ</a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group shrink-0">
                <img src="{{ asset('Assets/Logo/logo-dh.png') }}" class="h-10 w-auto group-hover:scale-105 transition-transform" alt="DriveHub Logo">
                <span class="font-black text-2xl text-dark tracking-tighter uppercase">Drive<span class="text-primary">Hub</span></span>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex space-x-6 items-center">
                <a href="{{ route('catalog.index') }}" class="text-xs font-bold uppercase tracking-widest whitespace-nowrap {{ ($activePage ?? '') === 'catalog' ? 'text-primary' : 'text-dark hover:text-primary' }} transition-all">Beli Mobil</a>
                <a href="{{ route('dealer') }}" class="text-xs font-bold uppercase tracking-widest whitespace-nowrap {{ ($activePage ?? '') === 'dealer' ? 'text-primary' : 'text-dark hover:text-primary' }} transition-all">Dealer Kami</a>
                <a href="{{ route('contact') }}" class="text-xs font-bold uppercase tracking-widest whitespace-nowrap {{ ($activePage ?? '') === 'contact' ? 'text-primary' : 'text-dark hover:text-primary' }} transition-all">Hubungi Kami</a>
                
                <!-- Dropdown -->
                <div class="relative group">
                    <button class="flex items-center gap-1 text-xs font-bold uppercase tracking-widest whitespace-nowrap text-dark group-hover:text-primary transition-all outline-none">
                        Selengkapnya <i class='bx bx-chevron-down text-base transition-transform group-hover:rotate-180'></i>
                    </button>
                    <div class="absolute top-full -left-4 w-48 bg-white shadow-2xl rounded-2xl border border-gray-50 p-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all mt-2 transform group-hover:translate-y-0 translate-y-2">
                        <a href="{{ route('why-us') }}" class="block px-4 py-3 text-xs font-bold text-dark hover:bg-gray-50 rounded-xl transition-all">Kenapa DriveHub?</a>
                        <a href="{{ route('about') }}" class="block px-4 py-3 text-xs font-bold text-dark hover:bg-gray-50 rounded-xl transition-all">Tentang Kami</a>
                        <a href="{{ route('help') }}" class="block px-4 py-3 text-xs font-bold text-dark hover:bg-gray-50 rounded-xl transition-all border-t border-gray-50 mt-1">Pusat Bantuan</a>
                        <a href="{{ route('faq') }}" class="block px-4 py-3 text-xs font-bold text-dark hover:bg-gray-50 rounded-xl transition-all">Pertanyaan (FAQ)</a>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="hidden lg:flex items-center space-x-4 shrink-0">
                @auth
                    <div class="flex items-center gap-4">
                        <span class="text-xs font-medium text-gray-500 whitespace-nowrap">
                            Halo, <a href="{{ route('profile.index') }}" class="font-bold text-dark hover:text-primary transition-colors">{{ Auth::user()->name }}</a>!
                        </span>
                        <a href="{{ route('transaction.status') }}" class="text-xs font-bold uppercase tracking-widest whitespace-nowrap {{ ($activePage ?? '') === 'transaction' ? 'text-primary' : 'text-gray-400 hover:text-primary' }} transition-colors">Pesanan Saya</a>
                        
                        <div class="flex items-center gap-2 border-l border-gray-100 pl-4">
                            <!-- Logout Button -->
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="w-10 h-10 rounded-full bg-gray-50 text-gray-500 hover:text-red-500 hover:bg-red-50 transition-all flex items-center justify-center text-lg border border-gray-100 shadow-sm" title="Keluar">
                                    <i class='bx bx-log-out'></i>
                                </button>
                            </form>
                            
                            <!-- Profile Button (Icon) to the right of Logout -->
                            <a href="{{ route('profile.index') }}" class="w-10 h-10 rounded-full {{ ($activePage ?? '') === 'profile' ? 'bg-primary text-white shadow-md shadow-primary/20' : 'bg-gray-50 text-gray-600 hover:text-primary hover:bg-blue-50 border border-gray-100' }} transition-all flex items-center justify-center text-lg shadow-sm" title="Profil Saya">
                                <i class='bx bx-user'></i>
                            </a>
                        </div>
                    </div>
                @else
                    <button @click="showLogin = true" class="text-xs font-bold uppercase tracking-widest text-dark hover:text-primary transition-colors">Masuk</button>
                    <button @click="showRegister = true" class="bg-dark text-white px-6 py-3 rounded-xl font-bold uppercase text-[10px] tracking-[0.2em] hover:bg-gray-800 transition-all shadow-xl shadow-gray-200">Daftar</button>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="lg:hidden flex items-center gap-4">
                <a href="https://wa.me/6283890103616" class="text-[#25D366] text-3xl"><i class='bx bxl-whatsapp'></i></a>
                <button id="mobile-menu-btn" class="text-dark focus:outline-none">
                    <i class='bx bx-menu-alt-right text-4xl'></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="lg:hidden hidden bg-white border-t border-gray-50 shadow-2xl overflow-y-auto max-h-[80vh]">
        <div class="px-6 py-8 space-y-6">
            @auth
                <!-- Mobile Greeting -->
                <div class="bg-gray-50 p-4 rounded-2xl flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-black text-sm uppercase">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="text-[9px] font-black text-gray-400 uppercase tracking-wider">Selamat Datang</div>
                        <div class="text-sm font-bold text-dark">{{ Auth::user()->name }}</div>
                    </div>
                </div>
            @endauth
            <div class="space-y-4">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Main Menu</p>
                <a href="{{ route('catalog.index') }}" class="block text-xl font-black text-dark">Beli Mobil</a>
                <a href="{{ route('dealer') }}" class="block text-xl font-black text-dark">Dealer Kami</a>
                <a href="{{ route('contact') }}" class="block text-xl font-black text-dark">Hubungi Kami</a>
                {{-- <a href="{{ route('jual-mobil') }}" class="block text-xl font-black text-dark">Jual Mobil</a> --}}
            </div>
            <hr class="border-gray-50">
            <div class="space-y-4">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Layanan & Info</p>
                <a href="{{ route('about') }}" class="block text-sm font-bold text-gray-600">Tentang Kami</a>
                <a href="{{ route('help') }}" class="block text-sm font-bold text-gray-600 border-t border-gray-50 pt-2">Pusat Bantuan</a>
                <a href="{{ route('faq') }}" class="block text-sm font-bold text-gray-600">Pertanyaan (FAQ)</a>
            </div>
            <div class="pt-6 grid grid-cols-2 gap-4">
                @auth
                    <a href="{{ route('profile.index') }}" class="bg-primary/5 text-primary py-4 rounded-2xl font-bold text-center text-sm">Profil Saya</a>
                    <a href="{{ route('transaction.status') }}" class="bg-primary text-white py-4 rounded-2xl font-bold text-center text-sm">Pesanan Saya</a>
                    <form method="POST" action="{{ route('logout') }}" class="col-span-2">
                        @csrf
                        <button type="submit" class="w-full bg-red-50 text-red-500 hover:bg-red-100 py-4 rounded-2xl font-bold text-sm transition-colors flex items-center justify-center gap-1.5"><i class='bx bx-log-out text-lg'></i> Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-center bg-gray-50 text-dark py-4 rounded-2xl font-bold border border-gray-100">Masuk</a>
                    <a href="{{ route('register') }}" class="text-center bg-dark text-white py-4 rounded-2xl font-bold">Daftar</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
    document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>

<script>
    document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
        const icon = this.querySelector('i');
        icon.classList.toggle('bx-menu');
        icon.classList.toggle('bx-x');
    });
</script>