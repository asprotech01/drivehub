@extends('layouts.admin')
@section('title', 'Dokumen Kendaraan - Admin DriveHub')
@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col">
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
            <form action="{{ route('admin.documents.index') }}" method="GET" class="relative w-full sm:w-96">
                <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg'></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan merek, model, atau plat nomor..." class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-primary outline-none text-sm transition-colors">
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-medium">Kendaraan</th>
                        <th class="px-6 py-4 font-medium">Status Penjualan</th>
                        <th class="px-6 py-4 font-medium text-center">Status STNK (Balik Nama)</th>
                        <th class="px-6 py-4 font-medium text-center">Status BPKB (Balik Nama)</th>
                        <th class="px-6 py-4 font-medium text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    @forelse($cars as $car)
                    @php
                        $lastTrx = $car->transaksis->first();
                        $buyerName = $lastTrx?->pembeli?->nama_lengkap;
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <img src="{{ $car->gambar_url }}" class="w-16 h-12 object-cover rounded-md shadow-sm border border-gray-100 shrink-0">
                                <div>
                                    <div class="font-bold text-dark text-base">{{ $car->merk }} {{ $car->model }}</div>
                                    <div class="text-xs text-gray-500 font-mono">{{ $car->nomor_polisi }} • {{ $car->warna }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($buyerName)
                                <div class="text-xs font-black uppercase text-amber-600 tracking-wider mb-0.5">Terjual</div>
                                <div class="font-bold text-gray-800 text-sm" title="Proses Balik Nama untuk pelanggan ini">
                                    {{ $buyerName }}
                                </div>
                            @else
                                <span class="bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full text-xs font-bold border border-emerald-100">Tersedia / Showroom</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($car->status_stnk === 'Ada')
                                <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 px-3 py-1.5 rounded-full text-xs font-bold border border-green-200">
                                    <i class='bx bx-check-circle text-sm'></i> STNK Ready
                                </span>
                            @elseif(str_contains($car->status_stnk, 'Proses'))
                                <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 px-3 py-1.5 rounded-full text-xs font-bold border border-amber-100 animate-pulse">
                                    <i class='bx bx-timer text-sm'></i> Proses (Est. 2 Minggu)
                                </span>
                            @elseif(str_contains($car->status_stnk, 'Selesai'))
                                <span class="inline-flex items-center gap-1.5 bg-teal-50 text-teal-700 px-3 py-1.5 rounded-full text-xs font-bold border border-teal-100">
                                    <i class='bx bx-check-double text-sm'></i> STNK Baru Selesai
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-600 px-3 py-1.5 rounded-full text-xs font-bold border border-gray-200">
                                    {{ $car->status_stnk }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($car->status_bpkb === 'Ada')
                                <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 px-3 py-1.5 rounded-full text-xs font-bold border border-green-200">
                                    <i class='bx bx-check-circle text-sm'></i> BPKB Ready
                                </span>
                            @elseif(str_contains($car->status_bpkb, 'Proses'))
                                <span class="inline-flex items-center gap-1.5 bg-purple-50 text-purple-700 px-3 py-1.5 rounded-full text-xs font-bold border border-purple-100 animate-pulse">
                                    <i class='bx bx-timer text-sm'></i> Proses (Est. 2 Bulan)
                                </span>
                            @elseif(str_contains($car->status_bpkb, 'Selesai'))
                                <span class="inline-flex items-center gap-1.5 bg-teal-50 text-teal-700 px-3 py-1.5 rounded-full text-xs font-bold border border-teal-100">
                                    <i class='bx bx-check-double text-sm'></i> BPKB Baru Selesai
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-600 px-3 py-1.5 rounded-full text-xs font-bold border border-gray-200">
                                    {{ $car->status_bpkb }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button type="button" 
                                    onclick="openEditDocModal(this)"
                                    data-id="{{ $car->id }}"
                                    data-stnk="{{ $car->status_stnk }}"
                                    data-bpkb="{{ $car->status_bpkb }}"
                                    data-title="{{ $car->merk }} {{ $car->model }}"
                                    data-buyer="{{ $buyerName ?? '' }}"
                                    class="inline-flex items-center gap-1.5 bg-primary/5 text-primary hover:bg-primary hover:text-white px-3 py-2 rounded-xl text-xs font-bold transition-all">
                                <i class='bx bx-edit-alt text-base'></i> Perbarui Status
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada data kendaraan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($cars->hasPages())
        <div class="p-6 border-t border-gray-100 flex justify-between items-center">
            <span class="text-sm text-gray-500">Menampilkan {{ $cars->firstItem() }}-{{ $cars->lastItem() }} dari {{ $cars->total() }} kendaraan</span>
            {{ $cars->links() }}
        </div>
        @endif
    </div>

    <!-- Edit Document Modal -->
    <div id="editDocModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-black text-dark">Proses Balik Nama Dokumen</h2>
                    <p id="editDocCarTitle" class="text-xs text-gray-400 font-bold uppercase mt-0.5"></p>
                </div>
                <button onclick="document.getElementById('editDocModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class='bx bx-x text-2xl'></i></button>
            </div>
            <form id="editDocForm" action="" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                
                <div id="buyerProcessAlert" class="bg-amber-50 border border-amber-200 rounded-xl p-4 hidden">
                    <p class="text-xs text-amber-800 font-semibold leading-relaxed flex items-center gap-2">
                        <i class='bx bx-user-circle text-base shrink-0'></i>
                        Proses balik nama akan disesuaikan atas nama pembeli: <span id="buyerProcessName" class="font-black text-dark"></span>
                    </p>
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 mb-2 uppercase tracking-wider">Status STNK (Proses 2 Minggu)</label>
                    <select name="status_stnk" id="edit_status_stnk" required class="w-full border border-gray-200 rounded-xl px-3 py-3 text-sm focus:border-primary outline-none font-semibold text-dark">
                        <option value="Ada">Ada / Ready (Asli)</option>
                        <option value="Proses Balik Nama STNK (Estimasi 2 Minggu)">Proses Balik Nama STNK (Estimasi 2 Minggu)</option>
                        <option value="Selesai Balik Nama (STNK Baru)">Selesai Balik Nama (STNK Baru)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-400 mb-2 uppercase tracking-wider">Status BPKB (Proses 2 Bulan)</label>
                    <select name="status_bpkb" id="edit_status_bpkb" required class="w-full border border-gray-200 rounded-xl px-3 py-3 text-sm focus:border-primary outline-none font-semibold text-dark">
                        <option value="Ada">Ada / Ready (Asli)</option>
                        <option value="Proses Balik Nama BPKB (Estimasi 2 Bulan)">Proses Balik Nama BPKB (Estimasi 2 Bulan)</option>
                        <option value="Selesai Balik Nama (BPKB Baru)">Selesai Balik Nama (BPKB Baru)</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-primary text-white py-3.5 rounded-xl font-bold hover:bg-primaryHover transition-colors flex items-center justify-center gap-2 shadow-sm">
                    <i class='bx bx-save text-lg'></i> Simpan Dokumen
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openEditDocModal(button) {
            const id = button.getAttribute('data-id');
            const stnk = button.getAttribute('data-stnk');
            const bpkb = button.getAttribute('data-bpkb');
            const title = button.getAttribute('data-title');
            const buyer = button.getAttribute('data-buyer');

            // Set Action URL
            const form = document.getElementById('editDocForm');
            form.action = `/admin/documents/${id}`;

            // Populate fields
            document.getElementById('editDocCarTitle').innerText = title;
            document.getElementById('edit_status_stnk').value = stnk;
            document.getElementById('edit_status_bpkb').value = bpkb;

            // Handle Buyer Alert
            const alertBox = document.getElementById('buyerProcessAlert');
            const alertName = document.getElementById('buyerProcessName');
            if (buyer && buyer.trim() !== '') {
                alertBox.classList.remove('hidden');
                alertName.innerText = buyer;
            } else {
                alertBox.classList.add('hidden');
            }

            // Show Modal
            document.getElementById('editDocModal').classList.remove('hidden');
        }
    </script>
    @endpush
@endsection
