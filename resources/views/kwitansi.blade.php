<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi Pembayaran - DriveHub</title>
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
<body class="bg-gray-50 py-10 font-sans">
    <div class="max-w-3xl mx-auto bg-white p-10 shadow-sm border border-gray-200 print-border">
        <!-- Buttons Bar -->
        <div class="no-print flex justify-end gap-3 mb-8 border-b border-gray-100 pb-4">
            <button onclick="window.print()" class="bg-primary text-white px-5 py-2.5 rounded-xl font-bold flex items-center gap-2 hover:bg-primaryHover transition-all shadow-md shadow-primary/10">
                <i class='bx bx-printer text-lg'></i> Cetak Kwitansi
            </button>
            <a href="{{ url()->previous() }}" class="bg-gray-100 text-gray-700 px-5 py-2.5 rounded-xl font-bold hover:bg-gray-200 transition-all flex items-center">Kembali</a>
        </div>

        <!-- Header -->
        <div class="flex justify-between items-center border-b pb-6 mb-8">
            <div class="flex items-center gap-3">
                <img src="{{ asset('Assets/Logo/logo-dh.png') }}" class="h-10 object-contain">
                <h1 class="text-xl font-black text-dark tracking-tighter">DRIVEHUB</h1>
            </div>
            <div class="text-right">
                <h2 class="text-xl font-bold text-dark">KWITANSI</h2>
                <p class="text-xs text-gray-500 uppercase tracking-widest">No: KW/{{ $pembayaran->id }}/{{ date('Y') }}</p>
            </div>
        </div>

        <!-- Body -->
        <div class="space-y-6">
            <div class="flex border-b border-gray-100 pb-4">
                <div class="w-48 text-gray-500 text-sm">Telah terima dari</div>
                <div class="flex-1 font-bold text-dark">{{ $transaksi->pembeli->nama_lengkap }}</div>
            </div>
            <div class="flex border-b border-gray-100 pb-4">
                <div class="w-48 text-gray-500 text-sm">Uang sejumlah</div>
                <div class="flex-1 bg-gray-50 p-2 italic text-dark font-medium rounded">
                    Rp. {{ ucwords(\Illuminate\Support\Str::replace('-', ' ', \Illuminate\Support\Str::slug($pembayaran->jumlah_bayar))) }} 
                </div>
            </div>
            <div class="flex border-b border-gray-100 pb-4">
                <div class="w-48 text-gray-500 text-sm">Untuk pembayaran</div>
                <div class="flex-1 text-dark">
                    <span class="font-bold">{{ $pembayaran->tipe_pembayaran }}</span> untuk unit <span class="font-bold">{{ $transaksi->mobil->merk }} {{ $transaksi->mobil->model }} ({{ $transaksi->mobil->nomor_polisi }})</span>
                </div>
            </div>
        </div>

        <!-- Amount and Footer -->
        <div class="mt-12 flex justify-between items-end">
            <div class="bg-primary text-white p-4 rounded-lg">
                <span class="text-xs uppercase opacity-80 block mb-1">Terbilang (IDR)</span>
                <span class="text-2xl font-black">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }},-</span>
            </div>
            <div class="text-center w-48">
                <p class="text-sm text-gray-500 mb-16">Tangerang, {{ $pembayaran->updated_at->translatedFormat('d F Y') }}</p>
                <div class="border-b border-dark mx-4 mb-2"></div>
                <p class="text-sm font-bold text-dark">DriveHub Finance</p>
            </div>
        </div>

        <div class="mt-16 text-[10px] text-gray-400 text-center uppercase tracking-widest">
            Kwitansi ini sah dan merupakan bukti pembayaran resmi dari DriveHub Showroom.
        </div>
    </div>
</body>
</html>
