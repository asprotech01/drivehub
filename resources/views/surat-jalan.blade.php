<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Jalan - DriveHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0052CC',
                        primaryHover: '#0747A6',
                        dark: '#1F2937',
                    }
                }
            }
        }
    </script>
    <style>
        @media print {
            @page {
                size: auto;
                margin: 0;
            }
            .no-print { display: none !important; }
            body { 
                background: white; 
                margin: 10mm 15mm;
            }
            .print-border { 
                border: none !important; 
                box-shadow: none !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>
<body class="bg-gray-100 py-10 font-sans">
    <div class="max-w-4xl mx-auto bg-white p-12 shadow-sm border border-gray-200 print-border">
        <!-- Buttons Bar -->
        <div class="no-print flex justify-end gap-3 mb-8 border-b border-gray-100 pb-4">
            <button onclick="window.print()" class="bg-primary text-white px-5 py-2.5 rounded-xl font-bold flex items-center gap-2 hover:bg-primaryHover transition-all shadow-md shadow-primary/10">
                <i class='bx bx-printer text-lg'></i> Cetak Surat Jalan
            </button>
            <a href="{{ url()->previous() }}" class="bg-gray-100 text-gray-700 px-5 py-2.5 rounded-xl font-bold hover:bg-gray-200 transition-all flex items-center">Kembali</a>
        </div>

        <!-- Header -->
        <div class="flex justify-between items-start border-b-4 border-primary pb-6 mb-8">
            <div class="flex items-center gap-3">
                <img src="{{ asset('Assets/Logo/logo-dh.png') }}" class="h-12 object-contain">
                <div>
                    <h1 class="text-2xl font-black text-primary tracking-tighter">DRIVEHUB</h1>
                    <p class="text-xs text-gray-500 font-bold tracking-widest uppercase">Premium Used Car Showroom</p>
                </div>
            </div>
            <div class="text-right">
                <h2 class="text-2xl font-bold text-dark">SURAT JALAN</h2>
                <p class="text-gray-500">Nomor: #SJ-{{ date('Ymd') }}-{{ str_pad($transaksi->id, 4, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        <!-- Info -->
        <div class="grid grid-cols-2 gap-12 mb-10">
            <div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Penerima / Alamat Tujuan</h3>
                <p class="font-bold text-lg text-dark mb-1">{{ $transaksi->pembeli->nama_lengkap }}</p>
                <p class="text-gray-600 leading-relaxed">{{ $transaksi->pengiriman->alamat_tujuan }}</p>
                <p class="text-gray-600 mt-2">Telp: {{ $transaksi->pembeli->no_hp }}</p>
            </div>
            <div class="text-right">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Tanggal Pengiriman</h3>
                <p class="font-bold text-lg text-dark">{{ now()->translatedFormat('d F Y') }}</p>
                <p class="text-gray-600 mt-4 italic">Kurir: DriveHub Logistics Team</p>
            </div>
        </div>

        <!-- Table -->
        <table class="w-full mb-12">
            <thead>
                <tr class="bg-gray-50 text-left">
                    <th class="p-4 border-b border-gray-200">Deskripsi Kendaraan</th>
                    <th class="p-4 border-b border-gray-200">No. Polisi</th>
                    <th class="p-4 border-b border-gray-200 text-center">Warna</th>
                    <th class="p-4 border-b border-gray-200 text-right">Tahun</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="p-4 border-b border-gray-100">
                        <div class="font-bold text-dark">{{ $transaksi->mobil->merk }} {{ $transaksi->mobil->model }}</div>
                        <div class="text-xs text-gray-500">Kondisi: Certified Pre-Owned</div>
                    </td>
                    <td class="p-4 border-b border-gray-100 font-mono font-bold">{{ $transaksi->mobil->nomor_polisi }}</td>
                    <td class="p-4 border-b border-gray-100 text-center">{{ $transaksi->mobil->warna }}</td>
                    <td class="p-4 border-b border-gray-100 text-right">{{ $transaksi->mobil->tahun_produksi }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Checklist -->
        <div class="mb-12">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Kelengkapan Dokumen & Unit</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="flex items-center gap-3 text-sm"><div class="w-4 h-4 border border-gray-300 rounded flex items-center justify-center"><i class='bx bx-check text-xs'></i></div> STNK Asli</div>
                <div class="flex items-center gap-3 text-sm"><div class="w-4 h-4 border border-gray-300 rounded flex items-center justify-center"><i class='bx bx-check text-xs'></i></div> BPKB & Faktur</div>
                <div class="flex items-center gap-3 text-sm"><div class="w-4 h-4 border border-gray-300 rounded flex items-center justify-center"><i class='bx bx-check text-xs'></i></div> Kunci Cadangan</div>
                <div class="flex items-center gap-3 text-sm"><div class="w-4 h-4 border border-gray-300 rounded flex items-center justify-center"><i class='bx bx-check text-xs'></i></div> Buku Servis & Garansi</div>
            </div>
        </div>

        <!-- Footer / Signatures -->
        <div class="grid grid-cols-3 gap-8 text-center pt-10">
            <div>
                <p class="text-xs text-gray-400 uppercase mb-16">Dilepas Oleh,</p>
                <div class="border-b border-gray-300 mx-4"></div>
                <p class="text-sm font-bold text-dark mt-2">Staff Showroom</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase mb-16">Dibawa Oleh,</p>
                <div class="border-b border-gray-300 mx-4"></div>
                <p class="text-sm font-bold text-dark mt-2">Driver / Towing</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase mb-16">Diterima Oleh,</p>
                <div class="border-b border-gray-300 mx-4"></div>
                <p class="text-sm font-bold text-dark mt-2">Pembeli / Penerima</p>
            </div>
        </div>

        <div class="mt-20 text-[10px] text-gray-400 text-center uppercase tracking-widest">
            Surat jalan ini merupakan bukti serah terima kendaraan yang sah. <br> Harap diperiksa kembali kondisi unit sebelum menandatangani dokumen ini.
        </div>
    </div>
</body>
</html>
