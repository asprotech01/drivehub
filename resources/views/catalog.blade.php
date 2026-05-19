@extends('layouts.guest')
@section('title', 'Katalog Mobil - DriveHub')
@section('content')
    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pt-36">

        <!-- Breadcrumb & Header -->
        <div class="mb-8">
            <div class="flex items-center text-sm text-gray-500 mb-2">
                <a href="{{ route('home') }}" class="hover:text-primary">Beranda</a>
                <i class='bx bx-chevron-right mx-1'></i>
                <span class="text-gray-800 font-medium">Beli Mobil Bekas</span>
            </div>
            <h1 class="text-3xl font-bold text-dark">Temukan Mobil Impianmu</h1>
            <p class="text-gray-500 mt-2">Menampilkan {{ $mobils->total() }} mobil bekas bersertifikat DriveHub.</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">

            <!-- Filter Sidebar -->
            <aside class="w-full lg:w-72 flex-shrink-0">
                <form action="{{ route('catalog.index') }}" method="GET" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sticky top-28">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="font-bold text-lg text-dark flex items-center gap-2"><i class='bx bx-filter-alt'></i> Filter</h2>
                        <a href="{{ route('catalog.index') }}" class="text-sm text-primary font-medium hover:underline">Reset</a>
                    </div>

                    <!-- Merek Filter -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-800 mb-3 text-sm">Merek</h3>
                        <div class="space-y-2 max-h-40 overflow-y-auto pr-2">
                            @foreach($brands as $brand)
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" name="merk[]" value="{{ $brand->merk }}"
                                    {{ in_array($brand->merk, (array) request('merk', [])) ? 'checked' : '' }}
                                    class="w-4 h-4 text-primary rounded border-gray-300 focus:ring-primary accent-primary">
                                <span class="text-gray-600 text-sm group-hover:text-primary transition-colors">{{ $brand->merk }} ({{ $brand->count }})</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    <hr class="border-gray-100 my-4">

                    <!-- Harga Filter -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-800 mb-3 text-sm">Harga (Juta Rp)</h3>
                        <div class="flex items-center gap-2">
                            <input type="number" name="harga_min" placeholder="Min" value="{{ request('harga_min') }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                            <span class="text-gray-400">-</span>
                            <input type="number" name="harga_max" placeholder="Max" value="{{ request('harga_max') }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                        </div>
                    </div>
                    <hr class="border-gray-100 my-4">

                    <!-- Transmisi Filter -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-800 mb-3 text-sm">Transmisi</h3>
                        <div class="flex gap-2">
                            @foreach(['Semua', 'A/T', 'M/T'] as $trans)
                            <label class="flex-1 text-center cursor-pointer">
                                <input type="radio" name="transmisi" value="{{ $trans }}" class="peer sr-only"
                                    {{ request('transmisi', 'Semua') === $trans ? 'checked' : '' }}>
                                <div class="px-3 py-2 rounded-lg border border-gray-200 text-sm peer-checked:bg-primary/10 peer-checked:border-primary peer-checked:text-primary font-medium transition-colors">{{ $trans }}</div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primaryHover transition-colors mt-2">
                        Terapkan Filter
                    </button>
                </form>
            </aside>

            <!-- Catalog Section -->
            <div class="flex-1">
                <!-- Search & Sort Bar -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 mb-6 flex flex-col sm:flex-row gap-4 justify-between items-center">
                    <form action="{{ route('catalog.index') }}" method="GET" class="relative w-full sm:w-96">
                        <i class='bx bx-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xl'></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Honda Brio..." class="w-full pl-11 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </form>
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <span class="text-sm text-gray-500 whitespace-nowrap">Urutkan:</span>
                        <form id="sortForm" action="{{ route('catalog.index') }}" method="GET">
                            @foreach(request()->except('sort') as $key => $val)
                                @if(is_array($val))
                                    @foreach($val as $v)
                                        <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                    @endforeach
                                @else
                                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                                @endif
                            @endforeach
                            <select name="sort" onchange="this.form.submit()" class="w-full sm:w-48 border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none bg-gray-50">
                                <option value="terbaru" {{ request('sort') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                <option value="harga_asc" {{ request('sort') === 'harga_asc' ? 'selected' : '' }}>Harga: Rendah - Tinggi</option>
                                <option value="harga_desc" {{ request('sort') === 'harga_desc' ? 'selected' : '' }}>Harga: Tinggi - Rendah</option>
                                <option value="tahun_desc" {{ request('sort') === 'tahun_desc' ? 'selected' : '' }}>Tahun: Paling Baru</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Car Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($mobils as $mobil)
                        @include('components.car-card', ['mobil' => $mobil, 'showHeart' => true])
                    @empty
                        <div class="col-span-full text-center py-16 text-gray-500">
                            <i class='bx bx-search-alt text-5xl mb-3'></i>
                            <p class="text-lg font-medium">Tidak ada mobil ditemukan</p>
                            <p class="text-sm">Coba ubah filter atau kata kunci pencarian Anda.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($mobils->hasPages())
                <div class="flex justify-center mt-10">
                    {{ $mobils->withQueryString()->links() }}
                </div>
                @endif

            </div>
        </div>
    </main>
@endsection
