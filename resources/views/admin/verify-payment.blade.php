@extends('layouts.admin')
@section('title', 'Verifikasi Pembayaran - Admin DriveHub')
@section('content')
    <!-- Tabs Filter -->
    <div class="flex flex-wrap gap-2 mb-8 bg-white p-2 rounded-2xl border border-gray-100 w-fit">
        <a href="{{ route('admin.payment.index') }}" 
           class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ $currentTipe === 'all' ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-gray-500 hover:text-dark hover:bg-gray-50' }}">
            Semua
        </a>
        <a href="{{ route('admin.payment.index', ['tipe' => 'booking']) }}" 
           class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ $currentTipe === 'booking' ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-gray-500 hover:text-dark hover:bg-gray-50' }}">
            Booking Fee
        </a>
        <a href="{{ route('admin.payment.index', ['tipe' => 'dp']) }}" 
           class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ $currentTipe === 'dp' ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-gray-500 hover:text-dark hover:bg-gray-50' }}">
            DP
        </a>
        <a href="{{ route('admin.payment.index', ['tipe' => 'pelunasan']) }}" 
           class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ $currentTipe === 'pelunasan' ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-gray-500 hover:text-dark hover:bg-gray-50' }}">
            Pelunasan
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6">
    @forelse($pendingPayments as $payment)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row overflow-hidden">
        <div class="md:w-1/3 bg-gray-50 p-6 flex flex-col justify-center items-center border-b md:border-b-0 md:border-r border-gray-100">
            <div class="w-full aspect-[4/3] bg-gray-200 rounded-lg mb-4 overflow-hidden">
                @if($payment->bukti_pembayaran)
                    <img src="{{ asset('storage/' . $payment->bukti_pembayaran) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center"><i class='bx bx-image text-4xl text-gray-400'></i></div>
                @endif
            </div>
        </div>
        <div class="md:w-2/3 p-6 flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold mb-2 inline-block">Menunggu Verifikasi</span>
                        <h3 class="text-xl font-bold text-dark">#TRX-{{ str_pad($payment->transaksi->id, 4, '0', STR_PAD_LEFT) }}</h3>
                        <p class="text-gray-500 text-sm">{{ $payment->tipe_pembayaran }} via {{ $payment->metode_bayar }}</p>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-gray-500 mb-1">Nominal</div>
                        <div class="text-xl font-bold text-primary">Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-y-3 gap-x-8 text-sm mb-6 border-t border-gray-100 pt-4">
                    <div><span class="text-gray-500 block">Pelanggan</span><span class="font-medium text-dark">{{ $payment->transaksi->pembeli->nama_lengkap ?? '-' }}</span></div>
                    <div><span class="text-gray-500 block">Waktu</span><span class="font-medium text-dark">{{ $payment->created_at->diffForHumans() }}</span></div>
                    <div class="col-span-2"><span class="text-gray-500 block">Mobil</span><span class="font-medium text-dark">{{ $payment->transaksi->mobil->merk }} {{ $payment->transaksi->mobil->model }}</span></div>
                </div>
            </div>
            <div class="flex gap-3 justify-end border-t border-gray-100 pt-4">
                <form action="{{ route('admin.payment.reject', $payment->id) }}" method="POST">@csrf
                    <button type="submit" class="px-5 py-2.5 border border-red-300 text-red-600 rounded-lg font-semibold hover:bg-red-50 transition-colors">Tolak</button>
                </form>
                <form action="{{ route('admin.payment.approve', $payment->id) }}" method="POST">@csrf
                    <button type="submit" class="px-5 py-2.5 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition-colors shadow-sm flex items-center gap-2">
                        <i class='bx bx-check-circle text-lg'></i> Verifikasi Sah
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
        <i class='bx bx-check-double text-5xl text-green-400 mb-3'></i>
        <h3 class="text-xl font-bold text-dark mb-2">Semua Terverifikasi!</h3>
        <p class="text-gray-500">Tidak ada pembayaran yang menunggu verifikasi.</p>
    </div>
    @endforelse
</div>
@endsection
