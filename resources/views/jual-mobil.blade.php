@extends('layouts.guest')
@section('title', 'Jual Mobil Bekas Harga Tinggi - DriveHub')
@section('content')
    <!-- Hero Jual Mobil -->
    <section class="relative bg-[#1e293b] pt-36 pb-24 overflow-hidden min-h-[90vh] flex items-center">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1563720223185-11003d516935?q=80&w=1600&auto=format&fit=crop" class="w-full h-full object-cover opacity-45 scale-105 transform transition-all duration-1000">
            <div class="absolute inset-0 bg-gradient-to-tr from-[#1e293b] via-[#1e293b]/95 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-8 text-white">
                    <div class="inline-flex items-center gap-2 bg-secondary/10 px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest text-secondary border border-secondary/20">
                        <i class='bx bx-dollar-circle text-sm'></i>
                        Harga Terbaik & Transparan
                    </div>
                    <h1 class="text-5xl md:text-7xl font-black text-white tracking-tighter leading-[0.95] uppercase">
                        JUAL MOBIL <br> <span class="text-secondary italic">TANPA RIBET</span> <br> DI DRIVEHUB.
                    </h1>
                    <p class="text-lg text-gray-400 max-w-md font-medium leading-relaxed">
                        Dapatkan penawaran harga tertinggi hanya dalam 1 jam. Proses cepat, aman, dan uang langsung cair.
                    </p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4">
                        <div class="flex items-center gap-4 bg-white/5 border border-white/10 p-4 rounded-2xl backdrop-blur-md">
                            <div class="w-12 h-12 bg-secondary/10 rounded-xl flex items-center justify-center text-2xl text-secondary"><i class='bx bx-check-shield'></i></div>
                            <div>
                                <div class="text-[9px] font-black text-gray-400 uppercase tracking-wider">Layanan</div>
                                <div class="text-xs font-black text-white uppercase tracking-wider">Inspeksi 100% Gratis</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 bg-white/5 border border-white/10 p-4 rounded-2xl backdrop-blur-md">
                            <div class="w-12 h-12 bg-secondary/10 rounded-xl flex items-center justify-center text-2xl text-secondary"><i class='bx bx-bolt-circle'></i></div>
                            <div>
                                <div class="text-[9px] font-black text-gray-400 uppercase tracking-wider">Kecepatan</div>
                                <div class="text-xs font-black text-white uppercase tracking-wider">Dana Cair 1 Jam</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Jual Mobil -->
                <div class="bg-white rounded-[48px] shadow-[0_48px_100px_-15px_rgba(0,0,0,0.5)] border border-gray-100 p-8 md:p-12 relative animate-fade-in-up z-10">
                    <h3 class="text-2xl font-black text-dark mb-8 tracking-tighter uppercase text-center">Cek Harga Mobil Anda</h3>
                    
                    <form id="jualMobilForm" class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-1">Merek Mobil</label>
                                <select id="merk" required onchange="updateModels()" class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-dark font-bold focus:ring-2 focus:ring-primary/20 transition-all appearance-none shadow-sm">
                                    <option value="">Pilih Merek</option>
                                    <option value="Toyota">Toyota</option>
                                    <option value="Honda">Honda</option>
                                    <option value="Daihatsu">Daihatsu</option>
                                    <option value="Suzuki">Suzuki</option>
                                    <option value="Mitsubishi">Mitsubishi</option>
                                    <option value="Nissan">Nissan</option>
                                    <option value="Hyundai">Hyundai</option>
                                    <option value="Wuling">Wuling</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-1">Model / Varian</label>
                                <select id="model" required class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-dark font-bold focus:ring-2 focus:ring-primary/20 transition-all appearance-none shadow-sm">
                                    <option value="">Pilih Model</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-1">Tahun Produksi</label>
                                <input type="number" id="tahun" placeholder="2018" required class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-dark font-bold focus:ring-2 focus:ring-primary/20 transition-all shadow-sm">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-1">Transmisi</label>
                                <select id="transmisi" required class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-dark font-bold focus:ring-2 focus:ring-primary/20 transition-all appearance-none shadow-sm">
                                    <option value="Automatic">Automatic (A/T)</option>
                                    <option value="Manual">Manual (M/T)</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-1">Estimasi Kilometer</label>
                            <input type="text" id="kilometer" placeholder="Contoh: 50.000" required class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-dark font-bold focus:ring-2 focus:ring-primary/20 transition-all shadow-sm">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-1">Lokasi Anda</label>
                            <input type="text" id="lokasi" placeholder="Contoh: Jakarta Selatan" required class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 text-dark font-bold focus:ring-2 focus:ring-primary/20 transition-all shadow-sm">
                        </div>

                        <button type="submit" class="w-full bg-secondary text-white py-5 rounded-[24px] font-black uppercase tracking-widest text-sm hover:bg-secondaryHover transition-all shadow-xl shadow-secondary/20 flex items-center justify-center gap-3 mt-4 hover:scale-[1.02] transform duration-300">
                            Dapatkan Penawaran <i class='bx bxl-whatsapp text-2xl animate-bounce'></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Steps Section -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-4xl font-black text-dark tracking-tighter uppercase mb-4">3 Langkah Mudah</h2>
                <p class="text-gray-500 font-medium">Jual mobil Anda dalam hitungan jam, bukan hari.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="text-center space-y-6">
                    <div class="w-20 h-20 bg-white rounded-[32px] shadow-xl flex items-center justify-center text-3xl font-black text-primary mx-auto">1</div>
                    <h4 class="text-xl font-black text-dark uppercase tracking-tight">Isi Data Mobil</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">Masukkan detail mobil Anda melalui formulir di atas untuk mendapatkan estimasi harga awal.</p>
                </div>
                <div class="text-center space-y-6">
                    <div class="w-20 h-20 bg-white rounded-[32px] shadow-xl flex items-center justify-center text-3xl font-black text-primary mx-auto">2</div>
                    <h4 class="text-xl font-black text-dark uppercase tracking-tight">Inspeksi Gratis</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">Pilih lokasi inspeksi (bisa di rumah Anda) untuk pengecekan kondisi mobil secara menyeluruh.</p>
                </div>
                <div class="text-center space-y-6">
                    <div class="w-20 h-20 bg-white rounded-[32px] shadow-xl flex items-center justify-center text-3xl font-black text-primary mx-auto">3</div>
                    <h4 class="text-xl font-black text-dark uppercase tracking-tight">Cairkan Dana</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">Jika setuju dengan penawaran akhir, uang akan langsung ditransfer ke rekening Anda dalam 1 jam.</p>
                </div>
            </div>
        </div>
    </section>

    <script>
        const carData = {
            'Toyota': ['86', 'AGYA', 'ALPHARD', 'ALTIS', 'AVANZA', 'C-HR', 'CALYA', 'CAMRY', 'FORTUNER', 'INNOVA'],
            'Honda': ['ACCORD', 'BR-V', 'BRIO', 'CITY', 'CIVIC', 'CR-V', 'HR-V', 'JAZZ', 'MOBILIO', 'WR-V'],
            'Daihatsu': ['AYLA', 'LUXIO', 'ROCKY', 'SIGRA', 'SIRION', 'TERIOS', 'XENIA', 'GRAN MAX'],
            'Suzuki': ['BALENO', 'ERTIGA', 'IGNIS', 'JIMNY', 'S-CROSS', 'SWIFT', 'XL7', 'KARIMUN'],
            'Mitsubishi': ['XPANDER', 'PAJERO SPORT', 'OUTLANDER', 'TRITON', 'MIRAGE', 'L300'],
            'Nissan': ['ELGRAND', 'GRAND LIVINA', 'KICKS', 'MARCH', 'SERENA', 'TERRA', 'X-TRAIL'],
            'Hyundai': ['CRETA', 'IONIQ 5', 'PALISADE', 'SANTA FE', 'STARGAZER', 'TUCSON'],
            'Wuling': ['ALMAZ', 'ALMAZ RS', 'ALVEZ', 'AIR EV', 'CONFERO', 'CORTEZ']
        };

        function updateModels() {
            const merkSelect = document.getElementById('merk');
            const modelSelect = document.getElementById('model');
            const merk = merkSelect.value;
            
            // Clear current options
            modelSelect.innerHTML = '<option value="">Pilih Model</option>';
            
            if (merk && carData[merk]) {
                carData[merk].forEach(model => {
                    const option = document.createElement('option');
                    option.value = model;
                    option.textContent = model;
                    modelSelect.appendChild(option);
                });
            }
        }

        // Handle Query Parameters from Homepage
        window.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const merkParam = urlParams.get('merk');
            const modelParam = urlParams.get('model');

            if (merkParam) {
                const merkSelect = document.getElementById('merk');
                merkSelect.value = merkParam;
                updateModels();

                if (modelParam) {
                    const modelSelect = document.getElementById('model');
                    // Find if the model exists in the newly populated list
                    const exists = Array.from(modelSelect.options).some(opt => opt.value === modelParam);
                    if (exists) {
                        modelSelect.value = modelParam;
                    }
                }
            }
        });

        document.getElementById('jualMobilForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const merk = document.getElementById('merk').value;
            const model = document.getElementById('model').value;
            const tahun = document.getElementById('tahun').value;
            const transmisi = document.getElementById('transmisi').value;
            const km = document.getElementById('kilometer').value;
            const lokasi = document.getElementById('lokasi').value;

            const message = `Halo DriveHub, saya ingin menjual mobil saya:\n\n` +
                            `🚗 *Merek:* ${merk}\n` +
                            `📦 *Model:* ${model}\n` +
                            `📅 *Tahun:* ${tahun}\n` +
                            `⚙️ *Transmisi:* ${transmisi}\n` +
                            `🛣️ *KM:* ${km}\n` +
                            `📍 *Lokasi:* ${lokasi}\n\n` +
                            `Mohon bantu proses untuk estimasi harganya. Terima kasih!`;

            const waUrl = `https://wa.me/6283890103616?text=${encodeURIComponent(message)}`;
            window.open(waUrl, '_blank');
        });
    </script>
@endsection
