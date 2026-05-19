<!-- Admin Sidebar Component -->
<aside class="w-64 bg-dark text-white flex flex-col h-full shrink-0 shadow-xl z-20 transition-all duration-300">
    <div class="h-20 flex items-center px-6 border-b border-gray-800">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <img class="h-8 w-auto bg-white p-1 rounded-md" src="{{ asset('Assets/Logo/logo-dh.png') }}" alt="DriveHub Logo">
            <span class="font-bold text-xl tracking-tight">DriveHub Admin</span>
        </a>
    </div>

    <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
        <p class="px-2 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Menu Utama</p>

        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ ($activePage ?? '') === 'dashboard' ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} font-medium transition-colors mb-1">
            <i class='bx bx-grid-alt text-xl'></i> Dashboard
        </a>
        <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ ($activePage ?? '') === 'manage-orders' ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} font-medium transition-colors mb-1">
            <i class='bx bx-shopping-bag text-xl'></i> Kelola Pesanan
        </a>
        <a href="{{ route('admin.mobil.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ ($activePage ?? '') === 'manage-cars' ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} font-medium transition-colors mb-1">
            <i class='bx bx-car text-xl'></i> Kelola Mobil
        </a>
        <a href="{{ route('admin.payment.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ ($activePage ?? '') === 'verify-payment' ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} font-medium transition-colors mb-1">
            <i class='bx bx-wallet text-xl'></i> Verifikasi Pembayaran
            @php $pendingCount = \App\Models\Pembayaran::where('status_verifikasi', 'Menunggu Verifikasi')->count(); @endphp
            @if($pendingCount > 0)
                <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
            @endif
        </a>
        <a href="{{ route('admin.payments.manage') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ ($activePage ?? '') === 'manage-payments' ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} font-medium transition-colors mb-1">
            <i class='bx bx-credit-card-front text-xl'></i> Kelola Data Pembayaran
        </a>
        <a href="{{ route('admin.delivery.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ ($activePage ?? '') === 'delivery' ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} font-medium transition-colors mb-1">
            <i class='bx bx-paper-plane text-xl'></i> Pengiriman Mobil
        </a>

        <p class="px-2 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 mt-6">Master Data</p>
        <a href="{{ route('admin.penjual.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ ($activePage ?? '') === 'manage-sellers' ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} font-medium transition-colors mb-1">
            <i class='bx bx-store text-xl'></i> Kelola Penjual
        </a>
        <a href="{{ route('admin.pembeli.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ ($activePage ?? '') === 'manage-buyers' ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} font-medium transition-colors mb-1">
            <i class='bx bx-user-check text-xl'></i> Kelola Pembeli
        </a>
        <a href="{{ route('admin.user.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ ($activePage ?? '') === 'manage-users' ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} font-medium transition-colors mb-1">
            <i class='bx bx-user text-xl'></i> Kelola User
        </a>
        <a href="{{ route('admin.documents.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ ($activePage ?? '') === 'manage-documents' ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} font-medium transition-colors mb-1">
            <i class='bx bx-file text-xl'></i> Dokumen Kendaraan
        </a>

        <p class="px-2 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 mt-6">Analisis</p>
        <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ ($activePage ?? '') === 'reports' ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} font-medium transition-colors mb-1">
            <i class='bx bx-line-chart text-xl'></i> Laporan Transaksi
        </a>
    </div>

    <div class="p-4 border-t border-gray-800">
        <div class="flex items-center gap-3 mb-4 px-2">
            <div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center font-bold">
                @auth {{ strtoupper(substr(Auth::user()->name, 0, 2)) }} @else AD @endauth
            </div>
            <div>
                <p class="text-sm font-medium text-white">@auth {{ Auth::user()->name }} @else Admin @endauth</p>
                <p class="text-xs text-gray-400">@auth {{ Auth::user()->email }} @else admin@drivehub.com @endauth</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-gray-800 rounded-lg transition-colors">
                <i class='bx bx-log-out text-lg'></i> Keluar
            </button>
        </form>
    </div>
</aside>
