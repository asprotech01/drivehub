@extends('layouts.guest')
@section('title', 'Pertanyaan Umum (FAQ) - DriveHub')
@section('content')
    <section class="relative bg-[#1e293b] pt-36 pb-24 overflow-hidden min-h-[90vh] flex items-center">
        <!-- Full-Bleed Background Image with Slate Parallax Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1506015391300-4802dc74de2e?q=80&w=1600&auto=format&fit=crop" class="w-full h-full object-cover opacity-40 scale-105 transform transition-all duration-1000">
            <div class="absolute inset-0 bg-gradient-to-tr from-[#1e293b] via-[#1e293b]/95 to-transparent"></div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="text-center mb-16 space-y-4">
                <div class="inline-flex items-center gap-2 bg-secondary/10 px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest text-secondary border border-secondary/20">
                    <i class='bx bx-question-mark text-sm'></i>
                    Jawaban Cepat Untuk Anda
                </div>
                <h1 class="text-5xl md:text-7xl font-black text-white tracking-tighter uppercase leading-[0.95]">
                    PERTANYAAN <br><span class="text-secondary italic">UMUM (FAQ)</span>
                </h1>
                <div class="w-20 h-1.5 bg-secondary mx-auto rounded-full mt-4"></div>
            </div>

            <!-- Interactive Accordions Container -->
            <div class="space-y-12">
                <!-- Kategori 1: Pembelian & Unit -->
                <div class="space-y-4">
                    <h3 class="text-xs font-black uppercase tracking-widest text-secondary px-4">A. Pembelian & Kualitas Unit</h3>
                    <div class="space-y-3">
                        <!-- Q1 -->
                        <div x-data="{ open: false }" class="bg-white/5 border border-white/10 rounded-[32px] overflow-hidden transition-all duration-300 backdrop-blur-md">
                            <button @click="open = !open" class="w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none">
                                <span class="font-black text-white text-base tracking-tight pr-4">1. Apakah semua mobil bekas di DriveHub terjamin kualitasnya?</span>
                                <i class="bx text-2xl transition-transform duration-300 text-secondary" :class="open ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                            </button>
                            <div x-show="open" x-transition.duration.300ms class="px-8 pb-6 text-sm text-gray-400 font-semibold leading-relaxed border-t border-white/5 pt-4">
                                Tentu saja. Semua unit di katalog DriveHub wajib melewati inspeksi ketat 175 titik yang dipimpin oleh tim inspektur profesional independen kami. Pengecekan ini mencakup kondisi mesin, transmisi, kelistrikan, sasis, hingga detail eksterior dan interior untuk memastikan unit dalam keadaan prima dan siap pakai.
                            </div>
                        </div>

                        <!-- Q2 -->
                        <div x-data="{ open: false }" class="bg-white/5 border border-white/10 rounded-[32px] overflow-hidden transition-all duration-300 backdrop-blur-md">
                            <button @click="open = !open" class="w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none">
                                <span class="font-black text-white text-base tracking-tight pr-4">2. Bagaimana mekanisme garansi 1 tahun di DriveHub?</span>
                                <i class="bx text-2xl transition-transform duration-300 text-secondary" :class="open ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                            </button>
                            <div x-show="open" x-transition.duration.300ms class="px-8 pb-6 text-sm text-gray-400 font-semibold leading-relaxed border-t border-white/5 pt-4">
                                Garansi 1 tahun kami mencakup komponen-komponen vital kendaraan, khususnya mesin dan transmisi. Jika terjadi kerusakan teknis selama masa garansi (bukan akibat kelalaian pemakaian atau kecelakaan), Anda dapat membawanya ke bengkel rekanan resmi kami dan kami akan menanggung seluruh biaya perbaikan.
                            </div>
                        </div>

                        <!-- Q3 -->
                        <div x-data="{ open: false }" class="bg-white/5 border border-white/10 rounded-[32px] overflow-hidden transition-all duration-300 backdrop-blur-md">
                            <button @click="open = !open" class="w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none">
                                <span class="font-black text-white text-base tracking-tight pr-4">3. Apakah saya bisa mengembalikan mobil jika tidak merasa cocok?</span>
                                <i class="bx text-2xl transition-transform duration-300 text-secondary" :class="open ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                            </button>
                            <div x-show="open" x-transition.duration.300ms class="px-8 pb-6 text-sm text-gray-400 font-semibold leading-relaxed border-t border-white/5 pt-4">
                                Ya! DriveHub menyediakan program <span class="text-white font-bold">Jaminan 5 Hari Uang Kembali</span>. Jika dalam kurun waktu 5 hari setelah penerimaan unit Anda merasa mobil tersebut tidak cocok, Anda dapat mengajukan pengembalian unit dan kami akan mengembalikan dana Anda 100% penuh tanpa potongan biaya administrasi, asalkan kondisi mobil tetap sama saat dikirimkan.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kategori 2: Administrasi & Dokumen -->
                <div class="space-y-4">
                    <h3 class="text-xs font-black uppercase tracking-widest text-secondary px-4">B. Administrasi & Keamanan Dokumen</h3>
                    <div class="space-y-3">
                        <!-- Q4 -->
                        <div x-data="{ open: false }" class="bg-white/5 border border-white/10 rounded-[32px] overflow-hidden transition-all duration-300 backdrop-blur-md">
                            <button @click="open = !open" class="w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none">
                                <span class="font-black text-white text-base tracking-tight pr-4">4. Apakah aman mengunggah foto KTP saya di platform DriveHub?</span>
                                <i class="bx text-2xl transition-transform duration-300 text-secondary" :class="open ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                            </button>
                            <div x-show="open" x-transition.duration.300ms class="px-8 pb-6 text-sm text-gray-400 font-semibold leading-relaxed border-t border-white/5 pt-4 space-y-3">
                                <p>
                                    <span class="text-emerald-400 font-bold">Dijamin Aman 100%.</span> Kami menerapkan kebijakan perlindungan privasi yang sangat ketat sesuai regulasi resmi UU Perlindungan Data Pribadi (UU PDP). 
                                </p>
                                <p>
                                    Foto KTP Anda dienkripsi secara penuh dengan sistem AES-256 kelas militer dan <span class="text-white font-bold">hanya digunakan untuk keperluan administrasi resmi kendaraan</span> (proses faktur, pengurusan STNK & BPKB baru atas nama Anda di kantor Samsat). Kami menjamin data identitas Anda tidak akan pernah bocor, disalahgunakan untuk pinjaman online, atau diserahkan ke pihak ketiga yang tidak berkepentingan.
                                </p>
                            </div>
                        </div>

                        <!-- Q5 -->
                        <div x-data="{ open: false }" class="bg-white/5 border border-white/10 rounded-[32px] overflow-hidden transition-all duration-300 backdrop-blur-md">
                            <button @click="open = !open" class="w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none">
                                <span class="font-black text-white text-base tracking-tight pr-4">5. Berapa lama proses balik nama STNK dan BPKB baru?</span>
                                <i class="bx text-2xl transition-transform duration-300 text-secondary" :class="open ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                            </button>
                            <div x-show="open" x-transition.duration.300ms class="px-8 pb-6 text-sm text-gray-400 font-semibold leading-relaxed border-t border-white/5 pt-4">
                                Setelah dokumen identitas (KTP) Anda terverifikasi oleh tim administrasi kami, kami akan langsung memproses ganti nama STNK dan BPKB baru di instansi Samsat setempat. Estimasi waktu penyelesaian adalah <span class="text-white font-bold">2 Minggu</span> untuk penerbitan STNK baru, dan <span class="text-white font-bold">2 Bulan</span> untuk penerbitan BPKB baru. Anda dapat memantau progres kelola dokumen ini secara langsung di halaman dashboard akun Anda.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kategori 3: Pembayaran & Pengiriman -->
                <div class="space-y-4">
                    <h3 class="text-xs font-black uppercase tracking-widest text-secondary px-4">C. Pembayaran & Pengiriman</h3>
                    <div class="space-y-3">
                        <!-- Q6 -->
                        <div x-data="{ open: false }" class="bg-white/5 border border-white/10 rounded-[32px] overflow-hidden transition-all duration-300 backdrop-blur-md">
                            <button @click="open = !open" class="w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none">
                                <span class="font-black text-white text-base tracking-tight pr-4">6. Apakah metode pembayaran DriveHub aman?</span>
                                <i class="bx text-2xl transition-transform duration-300 text-secondary" :class="open ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                            </button>
                            <div x-show="open" x-transition.duration.300ms class="px-8 pb-6 text-sm text-gray-400 font-semibold leading-relaxed border-t border-white/5 pt-4">
                                Sangat aman. Seluruh transaksi pembayaran dilakukan melalui transfer rekening bank resmi korporat atas nama PT DriveHub Indonesia (bukan atas nama perorangan). Setiap transfer wajib diunggah bukti transaksinya di halaman "Upload Pembayaran" untuk diverifikasi secara cepat oleh admin keuangan kami guna menghindari penipuan.
                            </div>
                        </div>

                        <!-- Q7 -->
                        <div x-data="{ open: false }" class="bg-white/5 border border-white/10 rounded-[32px] overflow-hidden transition-all duration-300 backdrop-blur-md">
                            <button @click="open = !open" class="w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none">
                                <span class="font-black text-white text-base tracking-tight pr-4">7. Bagaimana proses pengiriman mobil ke rumah pelanggan?</span>
                                <i class="bx text-2xl transition-transform duration-300 text-secondary" :class="open ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                            </button>
                            <div x-show="open" x-transition.duration.300ms class="px-8 pb-6 text-sm text-gray-400 font-semibold leading-relaxed border-t border-white/5 pt-4">
                                Setelah pembayaran lunas dan terverifikasi, tim ekspedisi internal DriveHub akan menyiapkan unit Anda (meliputi cuci bersih, poles ringan, dan pengisian bensin). Kami akan mengirimkan mobil langsung ke alamat garasi rumah Anda menggunakan truk towing eksklusif kami secara gratis untuk wilayah Jabodetabek. Penerima wajib menunjukkan identitas asli saat serah terima unit beserta penandatanganan Surat Jalan resmi.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
