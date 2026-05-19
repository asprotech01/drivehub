@extends('layouts.guest')
@section('title', 'Kebijakan Privasi - DriveHub')
@section('content')
    <section class="relative bg-[#1e293b] pt-36 pb-24 overflow-hidden min-h-[90vh] flex items-center">
        <!-- Full-Bleed Background Image with Slate Parallax Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?q=80&w=1600&auto=format&fit=crop" class="w-full h-full object-cover opacity-40 scale-105 transform transition-all duration-1000">
            <div class="absolute inset-0 bg-gradient-to-tr from-[#1e293b] via-[#1e293b]/95 to-transparent"></div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="text-center mb-16 space-y-4">
                <div class="inline-flex items-center gap-2 bg-secondary/10 px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest text-secondary border border-secondary/20">
                    <i class='bx bx-shield-quarter text-sm'></i>
                    Keamanan Data Pelanggan Mutlak
                </div>
                <h1 class="text-5xl md:text-7xl font-black text-white tracking-tighter uppercase leading-[0.95]">
                    KEBIJAKAN <br><span class="text-secondary italic">PRIVASI</span>
                </h1>
                <div class="w-20 h-1.5 bg-secondary mx-auto rounded-full mt-4"></div>
            </div>

            <!-- KTP Security Guarantee Box (Highlight) -->
            <div class="bg-gradient-to-r from-emerald-500/10 to-teal-500/10 border border-emerald-500/30 rounded-[32px] p-8 md:p-10 mb-12 relative overflow-hidden backdrop-blur-md shadow-2xl">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 rounded-full -mr-16 -mt-16"></div>
                <div class="flex items-start gap-6 relative z-10">
                    <div class="w-14 h-14 bg-emerald-500 text-white rounded-2xl flex items-center justify-center text-3xl shrink-0 shadow-lg shadow-emerald-500/20">
                        <i class='bx bx-fingerprint'></i>
                    </div>
                    <div class="space-y-3">
                        <h3 class="text-xl font-black text-white uppercase tracking-tight">Jaminan Perlindungan Mutlak Foto KTP</h3>
                        <p class="text-gray-300 text-sm leading-relaxed font-semibold">
                            Kami sangat menghargai privasi dan kepercayaan Anda. Mengikuti standar regulasi <span class="text-emerald-400 font-bold">Undang-Undang Perlindungan Data Pribadi (UU PDP) Indonesia</span>, DriveHub memberikan jaminan penuh bahwa:
                        </p>
                        <ul class="space-y-2 text-xs font-semibold text-gray-400 list-disc list-inside">
                            <li><span class="text-white font-bold">Enkripsi Tingkat Tinggi:</span> Seluruh foto KTP yang Anda unggah secara otomatis dienkripsi menggunakan protokol keamanan AES-256 tingkat militer.</li>
                            <li><span class="text-white font-bold">Hanya Untuk Berkas Resmi:</span> Foto KTP Anda digunakan <span class="text-emerald-400 font-bold">hanya dan terbatas</span> untuk keperluan pengurusan administrasi kepemilikan kendaraan resmi (Balik Nama STNK & BPKB) serta proses faktur pembayaran.</li>
                            <li><span class="text-white font-bold">Anti-Penyalahgunaan:</span> DriveHub <span class="text-red-400 font-bold">menjamin 100%</span> bahwa foto KTP Anda tidak akan pernah dijual, disebarluaskan, atau disalahgunakan untuk pinjaman online, pihak ketiga, maupun kepentingan periklanan.</li>
                            <li><span class="text-white font-bold">Penghapusan Data Otomatis:</span> Setelah proses pengiriman kendaraan dan berkas balik nama selesai, data dokumen identitas Anda akan diarsipkan dalam server offline yang terproteksi ketat dan dihapus secara berkala dari sistem publik.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Standard Privacy Sections -->
            <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-[48px] p-8 md:p-12 text-gray-300 font-semibold space-y-10 shadow-2xl">
                <div class="space-y-4">
                    <h3 class="text-2xl font-black text-white uppercase tracking-tight">1. Pengumpulan Informasi Pribadi</h3>
                    <p class="text-sm text-gray-400 leading-relaxed">
                        Kami mengumpulkan data pribadi Anda ketika Anda mendaftar di situs kami, membuat pesanan unit, mengisi formulir penjualan mobil, atau berkomunikasi dengan layanan customer care kami. Informasi ini mencakup nama lengkap, alamat email, nomor telepon, alamat pengiriman, informasi kendaraan Anda, serta dokumen identitas yang diperlukan untuk proses legalisasi kendaraan bermotor.
                    </p>
                </div>

                <div class="space-y-4">
                    <h3 class="text-2xl font-black text-white uppercase tracking-tight">2. Penggunaan Informasi Anda</h3>
                    <p class="text-sm text-gray-400 leading-relaxed">
                        Setiap informasi yang kami kumpulkan dari Anda dapat digunakan untuk salah satu tujuan berikut:
                    </p>
                    <ul class="list-disc list-inside text-sm text-gray-400 pl-4 space-y-2 leading-relaxed">
                        <li>Memproses transaksi pembelian dan pengiriman mobil impian Anda.</li>
                        <li>Menghubungi Anda terkait status pesanan, pembayaran, dan progres kelola dokumen STNK/BPKB.</li>
                        <li>Membantu proses balik nama STNK dan BPKB baru atas nama Anda sesuai transaksi pembelian.</li>
                        <li>Meningkatkan layanan pelanggan dan efisiensi platform DriveHub.</li>
                    </ul>
                </div>

                <div class="space-y-4">
                    <h3 class="text-2xl font-black text-white uppercase tracking-tight">3. Protokol Keamanan Transaksi & Data</h3>
                    <p class="text-sm text-gray-400 leading-relaxed">
                        Kami menerapkan berbagai langkah keamanan berlapis untuk menjaga keselamatan data pribadi Anda. Pengiriman data sensitif (seperti kredensial masuk, riwayat transaksi, bukti pembayaran, dan dokumen kepemilikan) menggunakan enkripsi Secure Socket Layer (SSL). Semua server kami dilindungi oleh firewall modern dan sistem deteksi intrusi aktif yang diawasi 24 jam sehari oleh tim cyber security profesional.
                    </p>
                </div>

                <div class="space-y-4">
                    <h3 class="text-2xl font-black text-white uppercase tracking-tight">4. Hak Akses dan Kendali Data Anda</h3>
                    <p class="text-sm text-gray-400 leading-relaxed">
                        Sebagai pelanggan setia DriveHub, Anda memiliki hak penuh untuk meminta akses, koreksi, memperbarui, atau penghapusan data pribadi Anda yang tersimpan di sistem kami. Jika Anda ingin mengajukan permintaan terkait privasi data Anda, silakan hubungi tim Customer Support kami melalui kontak WhatsApp Resmi yang tertera di halaman Hubungi Kami.
                    </p>
                </div>

                <div class="pt-8 border-t border-white/10 text-center">
                    <p class="text-xs text-gray-500">Terakhir Diperbarui: 18 Mei 2026 • © DriveHub Indonesia. Seluruh hak cipta dilindungi undang-undang.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
