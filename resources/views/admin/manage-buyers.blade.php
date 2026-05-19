@extends('layouts.admin')
@section('title', 'Kelola Pembeli - Admin DriveHub')
@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col">
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
            <form action="{{ route('admin.pembeli.index') }}" method="GET" class="relative w-full sm:w-96">
                <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg'></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama, alamat, no hp..." class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-primary outline-none text-sm transition-colors">
            </form>
            <button onclick="document.getElementById('addBuyerModal').classList.remove('hidden')" class="w-full sm:w-auto bg-primary text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-primaryHover transition-colors flex items-center justify-center gap-2 shadow-sm">
                <i class='bx bx-plus text-xl'></i> Tambah Pembeli Baru
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-medium">Pembeli</th>
                        <th class="px-6 py-4 font-medium">Akun Otomatis Terhubung</th>
                        <th class="px-6 py-4 font-medium">No. Telepon / HP</th>
                        <th class="px-6 py-4 font-medium">Alamat</th>
                        <th class="px-6 py-4 font-medium text-center">Foto KTP</th>
                        <th class="px-6 py-4 font-medium text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    @forelse($buyers as $buyer)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-dark text-base">{{ $buyer->nama_lengkap }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($buyer->user)
                                <div class="font-semibold text-gray-800">{{ $buyer->user->email }}</div>
                                <div class="text-xs text-gray-400 font-mono">Username: {{ $buyer->user->username }}</div>
                            @else
                                <span class="text-red-500 text-xs font-semibold">Tidak terhubung</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-700 font-semibold">{{ $buyer->no_hp ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-600 max-w-xs truncate" title="{{ $buyer->alamat }}">{{ $buyer->alamat ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($buyer->foto_ktp)
                                <a href="{{ asset('storage/' . $buyer->foto_ktp) }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs text-secondary hover:text-secondaryHover font-semibold transition-colors bg-blue-50 px-2.5 py-1.5 rounded-lg border border-blue-100">
                                    <i class='bx bx-id-card text-base'></i> Lihat KTP
                                </a>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button"
                                        onclick="openEditBuyerModal(this)"
                                        data-id="{{ $buyer->id }}"
                                        data-nama="{{ $buyer->nama_lengkap }}"
                                        data-nopol="{{ $buyer->no_hp }}"
                                        data-alamat="{{ $buyer->alamat }}"
                                        class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-100 transition-colors" 
                                        title="Edit">
                                    <i class='bx bx-edit-alt'></i>
                                </button>
                                <form action="{{ route('admin.pembeli.destroy', $buyer->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pembeli ini? Akun user terhubung juga akan dihapus.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-full bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-100 transition-colors" title="Hapus">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada data pembeli.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($buyers->hasPages())
        <div class="p-6 border-t border-gray-100 flex justify-between items-center">
            <span class="text-sm text-gray-500">Menampilkan {{ $buyers->firstItem() }}-{{ $buyers->lastItem() }} dari {{ $buyers->total() }} pembeli</span>
            {{ $buyers->links() }}
        </div>
        @endif
    </div>

    <!-- Add Buyer Modal -->
    <div id="addBuyerModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-bold text-dark">Tambah Pembeli Baru</h2>
                    <p class="text-xs text-gray-400 font-bold uppercase mt-0.5">Akun User & Password otomatis dibuat sistem</p>
                </div>
                <button onclick="document.getElementById('addBuyerModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class='bx bx-x text-2xl'></i></button>
            </div>
            <form action="{{ route('admin.pembeli.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" placeholder="Masukkan nama lengkap pembeli">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon / HP</label>
                    <input type="text" name="no_hp" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none" placeholder="Contoh: 08123456789">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                    <textarea name="alamat" rows="3" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none resize-none" placeholder="Tulis alamat lengkap..."></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto KTP</label>
                    <input type="file" name="foto_ktp" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>
                <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-bold hover:bg-primaryHover transition-colors">Simpan Pembeli</button>
            </form>
        </div>
    </div>

    <!-- Edit Buyer Modal -->
    <div id="editBuyerModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-dark">Edit Pembeli</h2>
                <button onclick="document.getElementById('editBuyerModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class='bx bx-x text-2xl'></i></button>
            </div>
            <form id="editBuyerForm" action="" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="edit_nama_lengkap" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon / HP</label>
                    <input type="text" name="no_hp" id="edit_no_hp" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                    <textarea name="alamat" id="edit_alamat" rows="3" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-primary outline-none resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto KTP (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="file" name="foto_ktp" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>
                <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-bold hover:bg-primaryHover transition-colors">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openEditBuyerModal(button) {
            const id = button.getAttribute('data-id');
            const nama = button.getAttribute('data-nama');
            const nopol = button.getAttribute('data-nopol'); // using nopol for no_hp
            const alamat = button.getAttribute('data-alamat');

            // Set Form action
            const form = document.getElementById('editBuyerForm');
            form.action = `/admin/manage-buyers/${id}`;

            // Populate fields
            document.getElementById('edit_nama_lengkap').value = nama;
            document.getElementById('edit_no_hp').value = nopol;
            document.getElementById('edit_alamat').value = alamat;

            // Open Modal
            document.getElementById('editBuyerModal').classList.remove('hidden');
        }
    </script>
    @endpush
@endsection
