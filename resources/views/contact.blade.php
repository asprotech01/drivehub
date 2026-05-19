@extends('layouts.guest')
@section('title', 'Hubungi Kami - DriveHub')
@section('content')
    <section class="relative bg-[#1e293b] pt-36 pb-24 overflow-hidden min-h-[90vh] flex items-center">
        <!-- Full-Bleed Background Image with Slate Parallax Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=1600&auto=format&fit=crop" class="w-full h-full object-cover opacity-40 scale-105 transform transition-all duration-1000">
            <div class="absolute inset-0 bg-gradient-to-tr from-[#1e293b] via-[#1e293b]/95 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="text-center mb-16 space-y-4">
                <div class="inline-flex items-center gap-2 bg-secondary/10 px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest text-secondary border border-secondary/20">
                    <i class='bx bxl-whatsapp text-sm'></i>
                    Layanan Chat 24/7 Terbuka
                </div>
                <h1 class="text-5xl md:text-7xl font-black text-white tracking-tighter uppercase leading-[0.95]">
                    HUBUNGI <br><span class="text-secondary italic">KAMI</span>
                </h1>
                <div class="w-20 h-1.5 bg-secondary mx-auto rounded-full mt-4"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <!-- Contact Info -->
                <div class="space-y-8">
                    <div class="flex items-start gap-6 bg-white/5 border border-white/10 p-8 rounded-[32px] backdrop-blur-md hover:bg-white/10 transition-all duration-300">
                        <div class="w-14 h-14 bg-secondary/10 text-secondary rounded-2xl flex items-center justify-center text-3xl shrink-0"><i class='bx bxl-whatsapp'></i></div>
                        <div>
                            <h4 class="text-xl font-black text-white uppercase tracking-tight mb-2">WhatsApp Customer Care</h4>
                            <p class="text-gray-400 mb-4 text-sm font-semibold">Layanan chat 24/7 untuk pertanyaan seputar unit dan transaksi.</p>
                            <a href="https://wa.me/6283890103616" class="text-secondary font-black text-lg hover:underline">0838-9010-3616</a>
                        </div>
                    </div>
                    <div class="flex items-start gap-6 bg-white/5 border border-white/10 p-8 rounded-[32px] backdrop-blur-md hover:bg-white/10 transition-all duration-300">
                        <div class="w-14 h-14 bg-secondary/10 text-secondary rounded-2xl flex items-center justify-center text-3xl shrink-0"><i class='bx bx-envelope'></i></div>
                        <div>
                            <h4 class="text-xl font-black text-white uppercase tracking-tight mb-2">Email Support</h4>
                            <p class="text-gray-400 mb-4 text-sm font-semibold">Kirimkan pertanyaan atau masukan Anda melalui email.</p>
                            <a href="mailto:support@drivehub.id" class="text-secondary font-black text-lg hover:underline">support@drivehub.id</a>
                        </div>
                    </div>
                    <div class="flex items-start gap-6 bg-white/5 border border-white/10 p-8 rounded-[32px] backdrop-blur-md hover:bg-white/10 transition-all duration-300">
                        <div class="w-14 h-14 bg-secondary/10 text-secondary rounded-2xl flex items-center justify-center text-3xl shrink-0"><i class='bx bx-map'></i></div>
                        <div>
                            <h4 class="text-xl font-black text-white uppercase tracking-tight mb-2">Kantor Pusat</h4>
                            <p class="text-gray-400 mb-4 text-sm font-semibold">Kunjungi showroom utama kami.</p>
                            <p class="text-white font-black text-lg leading-tight">Jl. Sudirman No. 123, Jakarta Selatan, Indonesia</p>
                        </div>
                    </div>
                </div>

                <!-- Form Contact -->
                <div class="bg-white rounded-[48px] shadow-[0_48px_100px_-15px_rgba(0,0,0,0.5)] border border-gray-100 p-8 md:p-12 relative animate-fade-in-up z-10">
                    <h3 class="text-2xl font-black text-dark mb-8 tracking-tighter uppercase text-center">Kirim Pesan</h3>
                    <form id="contactForm" class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-1">Nama Lengkap</label>
                            <input type="text" id="contactName" placeholder="Nama Anda" required class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-dark font-bold focus:ring-2 focus:ring-primary/20 transition-all shadow-sm">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-1">Alamat Email</label>
                            <input type="email" id="contactEmail" placeholder="email@contoh.com" required class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-dark font-bold focus:ring-2 focus:ring-primary/20 transition-all shadow-sm">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-1">Pesan Anda</label>
                            <textarea id="contactMessage" rows="4" placeholder="Tuliskan pesan atau pertanyaan Anda di sini..." required class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-dark font-bold focus:ring-2 focus:ring-primary/20 transition-all shadow-sm"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-secondary text-white py-5 rounded-[24px] font-black uppercase tracking-widest text-sm hover:bg-secondaryHover transition-all shadow-xl shadow-secondary/20 flex items-center justify-center gap-3">
                            Kirim Pesan Sekarang <i class='bx bxl-whatsapp text-2xl animate-bounce'></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const name = document.getElementById('contactName').value;
            const email = document.getElementById('contactEmail').value;
            const message = document.getElementById('contactMessage').value;

            const text = `Halo Customer Care DriveHub,\n\n` +
                         `📝 *Nama Lengkap:* ${name}\n` +
                         `✉️ *Alamat Email:* ${email}\n` +
                         `💬 *Pesan/Pertanyaan:* ${message}\n\n` +
                         `Mohon bantuannya. Terima kasih!`;

            const waUrl = `https://wa.me/6283890103616?text=${encodeURIComponent(text)}`;
            window.open(waUrl, '_blank');
        });
    </script>
@endsection
