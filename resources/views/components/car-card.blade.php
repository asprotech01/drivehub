<!-- Car Card Component -->
@props(['mobil', 'showHeart' => false])

<!-- Car Card Component -->
@props(['mobil', 'showHeart' => false])

<div class="bg-white rounded-[32px] overflow-hidden border border-gray-100 hover:border-primary/20 hover:shadow-[0_20px_50px_rgba(0,0,0,0.05)] transition-all duration-500 group flex flex-col">
    <div class="relative overflow-hidden aspect-[4/3]">
        <img src="{{ $mobil->gambar_url }}" 
             alt="{{ $mobil->merk }} {{ $mobil->model }}" 
             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
        
        @if($mobil->status_mobil === 'Tersedia')
        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-3 py-1.5 text-[10px] font-black text-dark rounded-xl shadow-sm flex items-center gap-1.5 uppercase tracking-widest border border-gray-50">
            <i class='bx bxs-check-shield text-primary text-sm'></i> Certified
        </div>
        @endif

        <div class="absolute bottom-4 left-4 right-4 translate-y-full group-hover:translate-y-0 transition-transform duration-500">
            <a href="{{ route('catalog.show', $mobil->id) }}" class="block w-full text-center bg-dark text-white text-xs font-black uppercase tracking-widest py-4 rounded-2xl shadow-xl">Detail Mobil</a>
        </div>
    </div>
    <div class="p-8 flex-1 flex flex-col">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h3 class="text-xl font-black text-dark tracking-tighter line-clamp-1 uppercase">{{ $mobil->merk }} <span class="text-gray-300">{{ $mobil->model }}</span></h3>
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">{{ $mobil->tahun_produksi }} • {{ $mobil->transmisi }}</div>
            </div>
            @if($showHeart)
                <button class="text-gray-300 hover:text-red-500 transition-colors"><i class='bx bxs-heart text-2xl'></i></button>
            @endif
        </div>
        
        <div class="flex items-center gap-4 text-[10px] font-black uppercase tracking-widest text-gray-400 mb-6 pb-6 border-b border-gray-50">
            <div class="flex items-center gap-1"><i class='bx bx-tachometer text-sm'></i> {{ number_format($mobil->kilometer) }} KM</div>
            <div class="flex items-center gap-1"><i class='bx bx-palette text-sm'></i> {{ $mobil->warna }}</div>
        </div>

        <div class="mt-auto">
            <div class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-1">Harga Tunai</div>
            <div class="text-2xl font-black text-primary tracking-tighter">Rp {{ number_format($mobil->harga / 1000000, 0) }}<span class="text-sm"> JT</span></div>
        </div>
    </div>
</div>
