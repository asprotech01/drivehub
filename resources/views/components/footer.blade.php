<footer class="bg-[#0f172a] pt-24 pb-12 border-t border-white/5 text-gray-400">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-16 mb-16">
            <!-- Brand Info -->
            <div class="space-y-8">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('Assets/Logo/logo-dh.png') }}" class="h-9 w-auto bg-white p-1 rounded-xl" alt="DriveHub Logo">
                    <span class="font-black text-2xl text-white tracking-tighter uppercase">Drive<span class="text-primary">Hub</span></span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed font-medium">
                    Platform kurasi mobil bekas terbaik dengan standar inspeksi tertinggi di Indonesia. Transparansi adalah prioritas kami.
                </p>
                <div class="flex space-x-3">
                    <a href="#" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white transition-all"><i class='bx bxl-facebook text-xl'></i></a>
                    <a href="#" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white transition-all"><i class='bx bxl-instagram text-xl'></i></a>
                    <a href="#" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white transition-all"><i class='bx bxl-youtube text-xl'></i></a>
                    <a href="#" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white transition-all"><i class='bx bxl-tiktok text-xl'></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-white font-black text-xs uppercase tracking-widest mb-8">Layanan Utama</h4>
                <ul class="space-y-4">
                    <li><a href="{{ route('catalog.index') }}" class="text-gray-500 hover:text-primary transition-all text-sm font-bold uppercase tracking-wide">Beli Mobil Bekas</a></li>
                    <li><a href="{{ route('jual-mobil') }}" class="text-gray-500 hover:text-primary transition-all text-sm font-bold uppercase tracking-wide">Jual Mobil Anda</a></li>
                    <li><a href="#" class="text-gray-500 hover:text-primary transition-all text-sm font-bold uppercase tracking-wide">Estimasi Harga</a></li>
                    <li><a href="#" class="text-gray-500 hover:text-primary transition-all text-sm font-bold uppercase tracking-wide">Inspeksi Mobil</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div>
                <h4 class="text-white font-black text-xs uppercase tracking-widest mb-8">Informasi</h4>
                <ul class="space-y-4">
                    <li><a href="{{ route('dealer') }}" class="text-gray-500 hover:text-primary transition-all text-sm font-bold uppercase tracking-wide">Dealer Kami</a></li>
                    <li><a href="{{ route('about') }}" class="text-gray-500 hover:text-primary transition-all text-sm font-bold uppercase tracking-wide">Tentang DriveHub</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-500 hover:text-primary transition-all text-sm font-bold uppercase tracking-wide">Hubungi Kami</a></li>
                    <li><a href="{{ route('privacy') }}" class="text-gray-500 hover:text-primary transition-all text-sm font-bold uppercase tracking-wide">Kebijakan Privasi</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div>
                <h4 class="text-white font-black text-xs uppercase tracking-widest mb-8">Kantor Pusat</h4>
                <p class="text-gray-400 text-sm leading-relaxed font-medium mb-4">
                    Jl. BSD Boulevard No. 45, Tangerang<br>
                    Indonesia, 15310
                </p>
                <div class="pt-4 border-t border-white/5">
                    <div class="text-xs font-black text-white uppercase tracking-widest mb-2">Customer Care</div>
                    <a href="https://wa.me/6283890103616" class="text-primary font-black text-lg hover:underline transition-all">0838-9010-3616</a>
                </div>
            </div>
        </div>

        <div class="pt-12 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest">&copy; {{ date('Y') }} DRIVEHUB INDONESIA. ALL RIGHTS RESERVED.</p>
            <div class="flex items-center gap-6 text-gray-600 text-xs">
                <i class='bx bxs-shield-check text-2xl text-primary'></i>
                <i class='bx bxs-certification text-2xl'></i>
                <i class='bx bxs-credit-card text-2xl'></i>
            </div>
        </div>
    </div>
</footer>