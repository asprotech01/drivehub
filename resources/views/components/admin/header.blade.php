@php
    // Fetch live notifications dynamically for admin header
    $pendingVerifyPayments = \App\Models\Pembayaran::with(['transaksi.pembeli', 'transaksi.mobil'])
        ->where('status_verifikasi', 'Menunggu Verifikasi')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
        
    $pendingDeliveries = \App\Models\Transaksi::with(['pembeli', 'mobil'])
        ->where('status_transaksi', 'Lunas')
        ->orderBy('updated_at', 'desc')
        ->take(5)
        ->get();
        
    $totalNotifCount = $pendingVerifyPayments->count() + $pendingDeliveries->count();
@endphp

<!-- Admin Header Component -->
<header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0 z-10 shadow-sm">
    <div class="flex items-center gap-4">
        <button class="text-gray-500 hover:text-dark focus:outline-none md:hidden">
            <i class='bx bx-menu text-3xl'></i>
        </button>
        <h1 class="text-2xl font-bold text-dark hidden md:block">{{ $pageTitle ?? 'Dashboard' }}</h1>
    </div>

    <div class="flex items-center gap-6">
        <!-- Global Transactions Search Form -->
        <form action="{{ route('admin.orders.index') }}" method="GET" class="relative">
            <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg'></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari transaksi, pembeli, mobil..." class="pl-10 pr-4 py-2 bg-gray-100 border-transparent rounded-lg focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none text-sm w-64 transition-all text-dark font-medium">
        </form>

        <!-- Dynamic Notification Bell with Dropdown (Alpine.js) -->
        <div x-data="{ notifOpen: false }" class="relative">
            <button @click="notifOpen = !notifOpen" class="relative text-gray-500 hover:text-primary transition-colors focus:outline-none flex items-center">
                <i class='bx bx-bell text-2xl'></i>
                @if($totalNotifCount > 0)
                    <span class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-[9px] font-black w-4.5 h-4.5 rounded-full flex items-center justify-center border-2 border-white leading-none">
                        {{ $totalNotifCount }}
                    </span>
                @endif
            </button>

            <!-- Notification Dropdown Menu -->
            <div x-show="notifOpen" 
                 @click.outside="notifOpen = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                 class="absolute right-0 mt-3 w-80 bg-white rounded-2xl border border-gray-100 shadow-xl z-50 overflow-hidden" 
                 x-cloak>
                 
                <div class="p-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <span class="text-xs font-black text-dark uppercase tracking-wider">Notifikasi Baru</span>
                    <span class="bg-primary/10 text-primary text-[10px] font-black px-2 py-0.5 rounded-full">
                        {{ $totalNotifCount }} Tindakan
                    </span>
                </div>
                
                <div class="max-h-72 overflow-y-auto divide-y divide-gray-50">
                    <!-- Pending Verification Payments -->
                    @forelse($pendingVerifyPayments as $p)
                        <a href="{{ route('admin.payment.index') }}" class="p-4 hover:bg-gray-50 transition-colors flex gap-3 items-start">
                            <span class="bg-amber-50 text-amber-600 p-2 rounded-xl shrink-0 mt-0.5">
                                <i class='bx bx-wallet text-base'></i>
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-dark leading-tight">Verifikasi Pembayaran</p>
                                <p class="text-[10px] text-gray-500 mt-1 leading-normal">
                                    <span class="font-bold text-dark">{{ $p->transaksi->pembeli->nama_lengkap }}</span> mengunggah <span class="font-semibold text-primary">{{ $p->tipe_pembayaran }}</span> sebesar Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}
                                </p>
                                <span class="text-[8px] text-gray-400 font-bold uppercase tracking-wider block mt-1"><i class='bx bx-time-five'></i> {{ $p->created_at->diffForHumans() }}</span>
                            </div>
                        </a>
                    @empty
                    @endforelse

                    <!-- Pending Deliveries (Lunas) -->
                    @forelse($pendingDeliveries as $t)
                        <a href="{{ route('admin.delivery.index') }}" class="p-4 hover:bg-gray-50 transition-colors flex gap-3 items-start">
                            <span class="bg-green-50 text-green-600 p-2 rounded-xl shrink-0 mt-0.5">
                                <i class='bx bx-paper-plane text-base'></i>
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-dark leading-tight">Unit Siap Kirim</p>
                                <p class="text-[10px] text-gray-500 mt-1 leading-normal">
                                    Transaksi <span class="font-mono font-bold text-dark">#TRX-{{ str_pad($t->id, 4, '0', STR_PAD_LEFT) }}</span> ({{ $t->pembeli->nama_lengkap }}) sudah lunas. Jadwalkan pengiriman!
                                </p>
                                <span class="text-[8px] text-gray-400 font-bold uppercase tracking-wider block mt-1"><i class='bx bx-time-five'></i> {{ $t->updated_at->diffForHumans() }}</span>
                            </div>
                        </a>
                    @empty
                    @endforelse

                    @if($totalNotifCount === 0)
                        <div class="p-8 text-center text-gray-400">
                            <div class="w-12 h-12 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-2 border border-green-100">
                                <i class='bx bx-check-shield text-2xl text-green-500'></i>
                            </div>
                            <p class="text-xs font-bold text-dark">Sistem Terkendali</p>
                            <p class="text-[9px] uppercase tracking-wider text-gray-400 mt-0.5">Semua pembayaran & pengiriman telah selesai ditindaklanjuti.</p>
                        </div>
                    @endif
                </div>
                
                <a href="{{ route('admin.orders.index') }}" class="block text-center py-3 bg-gray-50 hover:bg-gray-100 text-[10px] font-black text-primary uppercase tracking-widest border-t border-gray-100 transition-colors">
                    Lihat Semua Transaksi
                </a>
            </div>
        </div>

        <!-- Admin Profile Avatar -->
        <div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center font-bold text-white shadow-sm border border-gray-600">
            @auth {{ strtoupper(substr(Auth::user()->name, 0, 2)) }} @else AD @endauth
        </div>
    </div>
</header>
