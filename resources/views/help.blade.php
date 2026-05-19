@extends('layouts.guest')
@section('title', 'Pusat Bantuan - DriveHub')
@section('content')
    <section class="relative bg-[#1e293b] pt-36 pb-24 overflow-hidden min-h-[90vh] flex items-center">
        <!-- Full-Bleed Background Image with Slate Parallax Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1486006920555-c77dce18193b?q=80&w=1600&auto=format&fit=crop" class="w-full h-full object-cover opacity-40 scale-105 transform transition-all duration-1000">
            <div class="absolute inset-0 bg-gradient-to-tr from-[#1e293b] via-[#1e293b]/95 to-transparent"></div>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="text-center mb-16 space-y-4">
                <div class="inline-flex items-center gap-2 bg-secondary/10 px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest text-secondary border border-secondary/20">
                    <i class='bx bx-support text-sm'></i>
                    Panduan Lengkap & Dukungan Teknis
                </div>
                <h1 class="text-5xl md:text-7xl font-black text-white tracking-tighter uppercase leading-[0.95]">
                    PUSAT <br><span class="text-secondary italic">BANTUAN</span>
                </h1>
                <div class="w-20 h-1.5 bg-secondary mx-auto rounded-full mt-4"></div>
            </div>

            <!-- Quick Contacts Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
                <a href="https://wa.me/6283890103616" class="bg-white/5 border border-white/10 hover:bg-white/10 hover:border-secondary/30 rounded-[32px] p-8 flex items-center gap-6 transition-all duration-300 backdrop-blur-md shadow-lg group">
                    <div class="w-14 h-14 bg-secondary/10 rounded-2xl flex items-center justify-center text-3xl text-secondary group-hover:scale-110 transition-transform"><i class='bx bxl-whatsapp'></i></div>
                    <div>
                        <h4 class="text-lg font-black text-white uppercase tracking-tight">Hubungi via WhatsApp</h4>
                        <p class="text-xs text-gray-400 font-semibold mt-1">Dapatkan panduan langsung dari agen kami dalam 5 menit.</p>
                    </div>
                </a>
                <a href="{{ route('faq') }}" class="bg-white/5 border border-white/10 hover:bg-white/10 hover:border-secondary/30 rounded-[32px] p-8 flex items-center gap-6 transition-all duration-300 backdrop-blur-md shadow-lg group">
                    <div class="w-14 h-14 bg-secondary/10 rounded-2xl flex items-center justify-center text-3xl text-secondary group-hover:scale-110 transition-transform"><i class='bx bx-question-mark'></i></div>
                    <div>
                        <h4 class="text-lg font-black text-white uppercase tracking-tight">Lihat Halaman FAQ</h4>
                        <p class="text-xs text-gray-400 font-semibold mt-1">Temukan jawaban atas pertanyaan umum secara instan.</p>
                    </div>
                </a>
            </div>

            <!-- Step Guides Panels -->
            <div class="space-y-12">
                <!-- Guide 1: Cara Membeli Mobil -->
                <div class="bg-white/5 border border-white/10 rounded-[48px] p-8 md:p-12 backdrop-blur-md shadow-2xl">
                    <h3 class="text-2xl font-black text-white uppercase tracking-tight mb-8 flex items-center gap-4">
                        <span class="w-10 h-10 bg-secondary/10 rounded-xl flex items-center justify-center text-secondary text-xl"><i class='bx bx-shopping-bag'></i></span>
                        Panduan Pembelian Mobil
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="space-y-4">
                            <div class="w-10 h-10 bg-secondary text-white rounded-full flex items-center justify-center font-black text-sm shadow-lg shadow-secondary/20">1</div>
                            <h4 class="text-lg font-black text-white uppercase">Pilih & Booking Unit</h4>
                            <p class="text-xs text-gray-400 leading-relaxed font-semibold">Cari mobil impian Anda di katalog online kami, klik tombol booking, dan selesaikan pembayaran booking fee Rp 2.500.000 untuk mengunci unit pilihan Anda agar tidak dibeli orang lain.</p>
                        </div>
                        <div class="space-y-4">
                            <div class="w-10 h-10 bg-secondary text-white rounded-full flex items-center justify-center font-black text-sm shadow-lg shadow-secondary/20">2</div>
                            <h4 class="text-lg font-black text-white uppercase">Verifikasi & Bayar</h4>
                            <p class="text-xs text-gray-400 leading-relaxed font-semibold">Unggah foto KTP Anda (keamanan dijamin terenkripsi mutlak) serta bukti pembayaran pelunasan transfer bank resmi. Tim finance kami akan melakukan verifikasi data dalam waktu singkat.</p>
                        </div>
                        <div class="space-y-4">
                            <div class="w-10 h-10 bg-secondary text-white rounded-full flex items-center justify-center font-black text-sm shadow-lg shadow-secondary/20">3</div>
                            <h4 class="text-lg font-black text-white uppercase">Pengiriman Unit</h4>
                            <p class="text-xs text-gray-400 leading-relaxed font-semibold">Truk towing eksklusif kami akan mengirimkan mobil langsung ke alamat rumah Anda secara gratis. Lakukan pemeriksaan akhir dan tanda tangani Surat Jalan.</p>
                        </div>
                    </div>
                </div>

                <!-- Guide 2: Cara Menjual Mobil -->
                <div class="bg-white/5 border border-white/10 rounded-[48px] p-8 md:p-12 backdrop-blur-md shadow-2xl">
                    <h3 class="text-2xl font-black text-white uppercase tracking-tight mb-8 flex items-center gap-4">
                        <span class="w-10 h-10 bg-secondary/10 rounded-xl flex items-center justify-center text-secondary text-xl"><i class='bx bx-dollar-circle'></i></span>
                        Panduan Penjualan Mobil
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="space-y-4">
                            <div class="w-10 h-10 bg-secondary text-white rounded-full flex items-center justify-center font-black text-sm shadow-lg shadow-secondary/20">1</div>
                            <h4 class="text-lg font-black text-white uppercase">Ajukan Detail Mobil</h4>
                            <p class="text-xs text-gray-400 leading-relaxed font-semibold">Masukkan detail merek, model, tahun, jarak tempuh, serta harga ekspektasi mobil bekas Anda melalui formulir halaman Jual Mobil.</p>
                        </div>
                        <div class="space-y-4">
                            <div class="w-10 h-10 bg-secondary text-white rounded-full flex items-center justify-center font-black text-sm shadow-lg shadow-secondary/20">2</div>
                            <h4 class="text-lg font-black text-white uppercase">Inspeksi Profesional</h4>
                            <p class="text-xs text-gray-400 leading-relaxed font-semibold">Tentukan lokasi dan waktu inspeksi. Tim inspektur ahli kami akan datang memeriksa kelayakan fisik mobil Anda secara gratis dan menyeluruh.</p>
                        </div>
                        <div class="space-y-4">
                            <div class="w-10 h-10 bg-secondary text-white rounded-full flex items-center justify-center font-black text-sm shadow-lg shadow-secondary/20">3</div>
                            <h4 class="text-lg font-black text-white uppercase">Pencairan Dana</h4>
                            <p class="text-xs text-gray-400 leading-relaxed font-semibold">Jika Anda menyetujui tawaran harga terbaik dari hasil inspeksi kami, seluruh dana pembayaran akan ditransfer ke rekening bank Anda dalam waktu kurang dari 24 jam.</p>
                        </div>
                    </div>
                </div>

                <!-- Guide 3: Kelola Dokumen Kendaraan -->
                <div class="bg-white/5 border border-white/10 rounded-[48px] p-8 md:p-12 backdrop-blur-md shadow-2xl">
                    <h3 class="text-2xl font-black text-white uppercase tracking-tight mb-8 flex items-center gap-4">
                        <span class="w-10 h-10 bg-secondary/10 rounded-xl flex items-center justify-center text-secondary text-xl"><i class='bx bx-file'></i></span>
                        Panduan Kelola Dokumen & Balik Nama
                    </h3>
                    <div class="space-y-6 text-sm text-gray-400 font-semibold leading-relaxed">
                        <p>
                            DriveHub menyediakan layanan prima berupa pengurusan ganti nama STNK dan BPKB baru sesuai dengan nama identitas KTP pembeli. Tujuannya adalah untuk memberikan ketenangan pikiran mutlak agar Anda tidak perlu repot mengurus surat-surat kendaraan ke kantor Samsat secara mandiri.
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                            <div class="border-l-4 border-secondary pl-6 space-y-2">
                                <h4 class="text-lg font-black text-white uppercase">Proses Balik Nama STNK</h4>
                                <p class="text-xs text-gray-400 leading-relaxed">Estimasi waktu proses pengerjaan ganti nama STNK baru adalah sekitar <span class="text-white font-bold">2 Minggu</span> hari kerja setelah dokumen kepemilikan dan identitas pembeli lengkap kami verifikasi.</p>
                            </div>
                            <div class="border-l-4 border-secondary pl-6 space-y-2">
                                <h4 class="text-lg font-black text-white uppercase">Proses Balik Nama BPKB</h4>
                                <p class="text-xs text-gray-400 leading-relaxed">Estimasi waktu penerbitan buku BPKB baru atas nama pembeli adalah sekitar <span class="text-white font-bold">2 Bulan</span> hari kerja dari Samsat setempat. Kami akan menyimpan dan mengawal proses BPKB Anda hingga selesai aman dan siap dikirimkan ke rumah.</p>
                            </div>
                        </div>
                        <p class="pt-4 text-xs text-gray-500 italic">
                            *Catatan: Tim administrasi kami menjamin kerahasiaan 100% foto KTP dan dokumen identitas Anda selama proses ini berlangsung (Sesuai Kebijakan Privasi Perlindungan KTP UU PDP).
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
