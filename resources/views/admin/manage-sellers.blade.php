@extends('layouts.admin')
@section('title', 'Kelola Penjual - Admin DriveHub')
@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col">
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
            <form action="{{ route('admin.penjual.index') }}" method="GET" class="relative w-full sm:w-96">
                <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg'></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama, alamat, no hp..." class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-primary outline-none text-sm transition-colors">
            </form>
            <button onclick="document.getElementById('addSellerModal').classList.remove('hidden')" class="w-full sm:w-auto bg-primary text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-primaryHover transition-colors flex items-center justify-center gap-2 shadow-sm">
                <i class='bx bx-plus text-xl'></i> Tambah Penjual Baru
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-medium">Nama Penjual</th>
                        <th class="px-6 py-4 font-medium">No. Telepon / HP</th>
                        <th class="px-6 py-4 font-medium">Alamat</th>
                        <th class="px-6 py-4 font-medium text-center">Jumlah Mobil</th>
                        <th class="px-6 py-4 font-medium text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    @forelse($sellers as $seller)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-dark text-base">{{ $seller->nama_penjual }}</td>
                        <td class="px-6 py-4 text-gray-700 font-semibold">{{ $seller->no_hp ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-600 max-w-xs truncate" title="{{ $seller->alamat }}">{{ $seller->alamat ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">
                                {{ $seller->mobils()->count() }} Mobil
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button"
                                        onclick="openEditSellerModal(this)"
                                        data-id="{{ $seller->id }}"
                                        data-nama="{{ $seller->nama_penjual }}"
                                        data-nopol="{{ $seller->no_hp }}"
                                        data-alamat="{{ $seller->alamat }}"
                                        class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-100 transition-colors" 
                                        title="Edit">
                                    <i class='bx bx-edit-alt'></i>
                                </button>
                                <form action="{{ route('admin.penjual.destroy', $seller->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus penjual ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-full bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-100 transition-colors" title="Hapus">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada data penjual.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sellers->hasPages())
        <div class="p-6 border-t border-gray-100 flex justify-between items-center">
            <span class="text-sm text-gray-500">Menampilkan {{ $sellers->firstItem() }}-{{ $sellers->lastItem() }} dari {{ $sellers->total() }} penjual</span>
            {{ $sellers->links() }}
        </div>
        @endif
    </div>

    <!-- Add Seller Modal -->
    <div id="addSellerModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-dark">Tambah Penjual Baru</h2>
                <button onclick="document.getElementById('addSellerModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class='bx bx-x text-2xl'></i></button>
            </div>
            <form action="{{ route('admin.penjual.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penjual</label>
                    <input type="text" name="nama_penjual" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" placeholder="Masukkan nama penjual">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon / HP</label>
                    <input type="text" name="no_hp" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" placeholder="Contoh: 08123456789">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                    <textarea name="alamat" rows="4" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none resize-none" placeholder="Tulis alamat lengkap..."></textarea>
                </div>
                <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-bold hover:bg-primaryHover transition-colors">Simpan Penjual</button>
            </form>
        </div>
    </div>

    <!-- Edit Seller Modal -->
    <div id="editSellerModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-dark">Edit Penjual</h2>
                <button onclick="document.getElementById('editSellerModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class='bx bx-x text-2xl'></i></button>
            </div>
            <form id="editSellerForm" action="" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penjual</label>
                    <input type="text" name="nama_penjual" id="edit_nama_penjual" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon / HP</label>
                    <input type="text" name="no_hp" id="edit_no_hp" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                    <textarea name="alamat" id="edit_alamat" rows="4" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none resize-none"></textarea>
                </div>
                <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-bold hover:bg-primaryHover transition-colors">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openEditSellerModal(button) {
            const id = button.getAttribute('data-id');
            const nama = button.getAttribute('data-nama');
            const nopol = button.getAttribute('data-nopol'); // note: utilizing nopol attribute as no_hp in html button
            const alamat = button.getAttribute('data-alamat');

            // Set Form action
            const form = document.getElementById('editSellerForm');
            form.action = `/admin/manage-sellers/${id}`;

            // Populate fields
            document.getElementById('edit_nama_penjual').value = nama;
            document.getElementById('edit_no_hp').value = nopol;
            document.getElementById('edit_alamat').value = alamat;

            // Open Modal
            document.getElementById('editSellerModal').classList.remove('hidden');
        }
    </script>
    @endpush
@endsection
