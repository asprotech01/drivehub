@extends('layouts.admin')
@section('title', 'Kelola Mobil - Admin DriveHub')
@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col">
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
            <form action="{{ route('admin.mobil.index') }}" method="GET" class="relative w-full sm:w-96">
                <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg'></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama mobil..." class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-primary outline-none text-sm transition-colors">
            </form>
            <button onclick="document.getElementById('addCarModal').classList.remove('hidden')" class="w-full sm:w-auto bg-primary text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-primaryHover transition-colors flex items-center justify-center gap-2 shadow-sm">
                <i class='bx bx-plus text-xl'></i> Tambah Mobil Baru
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-medium">Mobil</th>
                        <th class="px-6 py-4 font-medium">Harga</th>
                        <th class="px-6 py-4 font-medium">Stok/Status</th>
                        <th class="px-6 py-4 font-medium">Tanggal Masuk</th>
                        <th class="px-6 py-4 font-medium text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    @forelse($mobils as $mobil)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <img src="{{ $mobil->gambar_url }}" class="w-16 h-12 object-cover rounded-md shadow-sm">
                                <div>
                                    <div class="font-bold text-dark text-base">{{ $mobil->merk }} {{ $mobil->model }}</div>
                                    <div class="text-xs text-gray-500">{{ $mobil->tahun_produksi }} • {{ $mobil->transmisi }} • {{ $mobil->warna }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-bold text-dark">Rp {{ number_format($mobil->harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusColor = match($mobil->status_mobil) {
                                    'Tersedia' => 'bg-green-100 text-green-700',
                                    'Booked' => 'bg-yellow-100 text-yellow-700',
                                    'Terjual' => 'bg-gray-100 text-gray-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp
                            <span class="{{ $statusColor }} px-3 py-1 rounded-full text-xs font-semibold">{{ $mobil->status_mobil }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $mobil->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('catalog.show', $mobil->id) }}" class="w-8 h-8 rounded-full bg-gray-50 text-gray-600 flex items-center justify-center hover:bg-gray-100 transition-colors" title="Lihat">
                                    <i class='bx bx-show'></i>
                                </a>
                                <button type="button"
                                        onclick="openEditModal(this)"
                                        data-id="{{ $mobil->id }}"
                                        data-merk="{{ $mobil->merk }}"
                                        data-model="{{ $mobil->model }}"
                                        data-tahun="{{ $mobil->tahun_produksi }}"
                                        data-warna="{{ $mobil->warna }}"
                                        data-nopol="{{ $mobil->nomor_polisi }}"
                                        data-transmisi="{{ $mobil->transmisi }}"
                                        data-harga="{{ $mobil->harga }}"
                                        data-kilometer="{{ $mobil->kilometer }}"
                                        data-deskripsi="{{ $mobil->deskripsi }}"
                                        data-status="{{ $mobil->status_mobil }}"
                                        class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-100 transition-colors" 
                                        title="Edit">
                                    <i class='bx bx-edit-alt'></i>
                                </button>
                                <form action="{{ route('admin.mobil.destroy', $mobil->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus mobil ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-full bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-100 transition-colors" title="Hapus">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada data mobil.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($mobils->hasPages())
        <div class="p-6 border-t border-gray-100 flex justify-between items-center">
            <span class="text-sm text-gray-500">Menampilkan {{ $mobils->firstItem() }}-{{ $mobils->lastItem() }} dari {{ $mobils->total() }} mobil</span>
            {{ $mobils->links() }}
        </div>
        @endif
    </div>

    <!-- Add Car Modal -->
    <div id="addCarModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-dark">Tambah Mobil Baru</h2>
                <button onclick="document.getElementById('addCarModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class='bx bx-x text-2xl'></i></button>
            </div>
            <form action="{{ route('admin.mobil.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Merek</label>
                        <input type="text" name="merk" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" placeholder="Merek mobil (contoh: Honda)">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                        <input type="text" name="model" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" placeholder="Model & tipe (contoh: CR-V 1.5)">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                        <input type="number" name="tahun_produksi" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" placeholder="Tahun pembuatan (contoh: 2020)">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Warna</label>
                        <input type="text" name="warna" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" placeholder="Warna sesuai STNK (contoh: Putih)">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. Polisi</label>
                        <input type="text" name="nomor_polisi" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" placeholder="Nomor plat (contoh: B 1234 ABC)">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Transmisi</label>
                        <select name="transmisi" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none">
                            <option value="A/T">Automatic (A/T)</option>
                            <option value="M/T">Manual (M/T)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                        <input type="number" name="harga" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" placeholder="Harga tanpa titik (contoh: 485000000)">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kilometer</label>
                        <input type="number" name="kilometer" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" placeholder="Jarak tempuh KM (contoh: 42000)">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bahan Bakar / Deskripsi</label>
                    <input type="text" name="deskripsi" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" placeholder="Jenis bahan bakar (contoh: Bensin)">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Mobil</label>
                    <input type="file" name="gambar" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>
                <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-bold hover:bg-primaryHover transition-colors">Simpan Mobil</button>
            </form>
        </div>
    </div>

    <!-- Edit Car Modal -->
    <div id="editCarModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-dark">Edit Mobil</h2>
                <button onclick="document.getElementById('editCarModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class='bx bx-x text-2xl'></i></button>
            </div>
            <form id="editCarForm" action="" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Merek</label>
                        <input type="text" name="merk" id="edit_merk" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" placeholder="Merek mobil (contoh: Honda)">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                        <input type="text" name="model" id="edit_model" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" placeholder="Model & tipe (contoh: CR-V 1.5)">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                        <input type="number" name="tahun_produksi" id="edit_tahun_produksi" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" placeholder="Tahun pembuatan (contoh: 2020)">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Warna</label>
                        <input type="text" name="warna" id="edit_warna" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" placeholder="Warna sesuai STNK (contoh: Putih)">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. Polisi</label>
                        <input type="text" name="nomor_polisi" id="edit_nomor_polisi" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" placeholder="Nomor plat (contoh: B 1234 ABC)">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Transmisi</label>
                        <select name="transmisi" id="edit_transmisi" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none">
                            <option value="A/T">Automatic (A/T)</option>
                            <option value="M/T">Manual (M/T)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                        <input type="number" name="harga" id="edit_harga" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" placeholder="Harga tanpa titik (contoh: 485000000)">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kilometer</label>
                        <input type="number" name="kilometer" id="edit_kilometer" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" placeholder="Jarak tempuh KM (contoh: 42000)">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Mobil</label>
                        <select name="status_mobil" id="edit_status_mobil" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none">
                            <option value="Tersedia">Tersedia</option>
                            <option value="Booked">Booked</option>
                            <option value="Terjual">Terjual</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bahan Bakar / Deskripsi</label>
                    <input type="text" name="deskripsi" id="edit_deskripsi" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" placeholder="Jenis bahan bakar (contoh: Bensin)">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Mobil (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="file" name="gambar" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>
                <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-bold hover:bg-primaryHover transition-colors">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openEditModal(button) {
            const id = button.getAttribute('data-id');
            const merk = button.getAttribute('data-merk');
            const model = button.getAttribute('data-model');
            const tahun = button.getAttribute('data-tahun');
            const warna = button.getAttribute('data-warna');
            const nopol = button.getAttribute('data-nopol');
            const transmisi = button.getAttribute('data-transmisi');
            const harga = button.getAttribute('data-harga');
            const kilometer = button.getAttribute('data-kilometer');
            const deskripsi = button.getAttribute('data-deskripsi');
            const status = button.getAttribute('data-status');

            // Set form action URL
            const form = document.getElementById('editCarForm');
            form.action = `/admin/manage-cars/${id}`;

            // Populate fields
            document.getElementById('edit_merk').value = merk;
            document.getElementById('edit_model').value = model;
            document.getElementById('edit_tahun_produksi').value = tahun;
            document.getElementById('edit_warna').value = warna;
            document.getElementById('edit_nomor_polisi').value = nopol;
            document.getElementById('edit_transmisi').value = transmisi;
            document.getElementById('edit_harga').value = harga;
            document.getElementById('edit_kilometer').value = kilometer;
            document.getElementById('edit_deskripsi').value = deskripsi || '';
            document.getElementById('edit_status_mobil').value = status;

            // Show modal
            document.getElementById('editCarModal').classList.remove('hidden');
        }
    </script>
    @endpush
@endsection
