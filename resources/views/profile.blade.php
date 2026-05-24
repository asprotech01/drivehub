@extends('layouts.guest')
@section('title', 'Profil Saya - DriveHub')

@push('styles')
<style>
    .profile-card {
        background: linear-gradient(135deg, #1E3A8A 0%, #1e40af 100%);
    }
    .custom-input:focus {
        border-color: #1E3A8A;
        box-shadow: 0 0 0 4px rgba(30, 58, 138, 0.1);
    }
</style>
@endpush

@section('content')
<div class="pt-32 pb-24 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Success/Error Alert -->
        @if(session('success'))
            <div class="mb-8 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl flex items-center gap-3 shadow-sm animate-fade-in-up">
                <i class='bx bx-check-circle text-2xl shrink-0'></i>
                <div class="font-bold text-sm">{{ session('success') }}</div>
            </div>
        @endif
        
        @if($errors->any())
            <div class="mb-8 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl shadow-sm animate-fade-in-up">
                <div class="flex items-center gap-3 mb-2">
                    <i class='bx bx-error-circle text-2xl shrink-0'></i>
                    <span class="font-black text-sm uppercase tracking-wide">Terjadi Kesalahan</span>
                </div>
                <ul class="list-disc list-inside text-xs font-semibold space-y-1 pl-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Profile Header Card -->
        <div class="profile-card rounded-[32px] p-8 md:p-12 text-white shadow-xl mb-12 flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
            <div class="absolute -right-16 -bottom-16 w-64 h-64 bg-white/5 rounded-full pointer-events-none"></div>
            <div class="absolute -left-16 -top-16 w-48 h-48 bg-white/5 rounded-full pointer-events-none"></div>
            
            <div class="flex flex-col md:flex-row items-center gap-6 relative z-10">
                <div class="w-24 h-24 rounded-full bg-white/10 backdrop-blur-md border-4 border-white/20 flex items-center justify-center font-black text-3xl text-white shadow-inner uppercase">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div class="text-center md:text-left space-y-1">
                    <h1 class="text-3xl font-black tracking-tight leading-none">{{ $user->name }}</h1>
                    <p class="text-white/70 font-semibold text-sm">{{ $user->email }}</p>
                    <div class="inline-flex items-center gap-1.5 bg-white/10 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider mt-2">
                        <i class='bx bx-shield-quarter'></i> Status: {{ ucfirst($user->role) }}
                    </div>
                </div>
            </div>
            
            <div class="flex items-center gap-3 relative z-10">
                <a href="{{ route('transaction.status') }}" class="bg-white text-primary px-6 py-3.5 rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-gray-100 transition-all shadow-lg shadow-blue-950/20">
                    <i class='bx bx-receipt text-base align-middle mr-1.5'></i> Pesanan Saya
                </a>
            </div>
        </div>

        <!-- Main Form Grid -->
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left: Account Details (2 cols on large screen) -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white rounded-[32px] p-8 md:p-10 border border-gray-100 shadow-xl shadow-gray-200/50">
                        <h3 class="text-xl font-black text-dark uppercase tracking-tight mb-8 flex items-center gap-3">
                            <i class='bx bx-user-circle text-2xl text-primary'></i> Informasi Pribadi
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-1">Nama Lengkap</label>
                                <div class="relative">
                                    <i class='bx bx-user absolute left-4 top-1/2 -translate-y-1/2 text-xl text-gray-400'></i>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl pl-12 pr-6 py-4 text-dark font-bold text-sm custom-input transition-all outline-none" placeholder="Masukkan nama lengkap">
                                </div>
                            </div>
                            
                            <!-- Email -->
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-1">Email</label>
                                <div class="relative">
                                    <i class='bx bx-envelope absolute left-4 top-1/2 -translate-y-1/2 text-xl text-gray-400'></i>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl pl-12 pr-6 py-4 text-dark font-bold text-sm custom-input transition-all outline-none" placeholder="Masukkan email">
                                </div>
                            </div>

                            <!-- WhatsApp/Phone -->
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-1">No. WhatsApp</label>
                                <div class="relative">
                                    <i class='bx bxl-whatsapp absolute left-4 top-1/2 -translate-y-1/2 text-xl text-gray-400'></i>
                                    <input type="text" name="no_hp" value="{{ old('no_hp', $pembeli ? $pembeli->no_hp : '') }}" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl pl-12 pr-6 py-4 text-dark font-bold text-sm custom-input transition-all outline-none" placeholder="Contoh: 081234567890">
                                </div>
                            </div>

                            <!-- Empty space for grid alignment if needed, or something else -->
                            <div class="hidden md:block"></div>

                            <!-- Address -->
                            <div class="space-y-2 md:col-span-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-1">Alamat Lengkap</label>
                                <div class="relative">
                                    <i class='bx bx-map-pin absolute left-4 top-5 text-xl text-gray-400'></i>
                                    <textarea name="alamat" rows="4" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl pl-12 pr-6 py-4 text-dark font-bold text-sm custom-input transition-all outline-none resize-none" placeholder="Masukkan alamat domisili lengkap Anda">{{ old('alamat', $pembeli ? $pembeli->alamat : '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Password & Identity Card -->
                <div class="space-y-8">
                    
                    <!-- KTP Upload Card -->
                    <div class="bg-white rounded-[32px] p-8 border border-gray-100 shadow-xl shadow-gray-200/50">
                        <h3 class="text-xl font-black text-dark uppercase tracking-tight mb-6 flex items-center gap-3">
                            <i class='bx bx-id-card text-2xl text-primary'></i> Kartu Identitas (KTP)
                        </h3>
                        
                        <div class="space-y-4">
                            <!-- KTP Preview Container -->
                            <div class="w-full h-40 bg-gray-50 border-2 border-dashed border-gray-200 rounded-2xl overflow-hidden relative flex flex-col items-center justify-center group transition-colors hover:border-primary/50">
                                <img id="ktp-preview" src="{{ $pembeli && $pembeli->foto_ktp ? asset('storage/' . $pembeli->foto_ktp) : '' }}" class="w-full h-full object-cover {{ $pembeli && $pembeli->foto_ktp ? '' : 'hidden' }}">
                                
                                <div id="ktp-placeholder" class="text-center p-4 {{ $pembeli && $pembeli->foto_ktp ? 'hidden' : '' }}">
                                    <i class='bx bx-cloud-upload text-4xl text-gray-300 group-hover:text-primary transition-colors mb-2'></i>
                                    <p class="text-xs font-bold text-gray-400 group-hover:text-gray-500 transition-colors uppercase tracking-wider">Unggah Foto KTP</p>
                                    <p class="text-[9px] text-gray-400 font-semibold mt-1">Format JPG, PNG (Maks 2MB)</p>
                                </div>
                            </div>
                            
                            <!-- Input File Button -->
                            <div class="relative">
                                <input type="file" name="foto_ktp" id="foto_ktp_input" accept="image/*" class="hidden">
                                <button type="button" onclick="document.getElementById('foto_ktp_input').click()" class="w-full bg-gray-100 hover:bg-gray-200 text-dark font-black uppercase text-[10px] tracking-widest py-3.5 rounded-xl transition-all">
                                    Pilih Berkas
                                </button>
                            </div>
                            
                            @if($pembeli && $pembeli->foto_ktp)
                                <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 flex items-start gap-2">
                                    <i class='bx bx-info-circle text-blue-600 text-lg shrink-0 mt-0.5'></i>
                                    <p class="text-[10px] text-blue-800 font-medium leading-relaxed">
                                        Foto KTP Anda sudah tersimpan dengan aman di sistem. Anda dapat mengunggah berkas baru untuk mengubahnya.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Security / Change Password -->
                    <div class="bg-white rounded-[32px] p-8 border border-gray-100 shadow-xl shadow-gray-200/50">
                        <h3 class="text-xl font-black text-dark uppercase tracking-tight mb-6 flex items-center gap-3">
                            <i class='bx bx-lock-alt text-2xl text-primary'></i> Keamanan Kata Sandi
                        </h3>
                        
                        <div class="space-y-4">
                            <!-- Toggle switch description -->
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide leading-relaxed">
                                Isi bagian di bawah ini HANYA jika Anda ingin mengganti kata sandi.
                            </p>
                            
                            <!-- Current Password -->
                            <div class="space-y-2">
                                <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 px-1">Kata Sandi Saat Ini</label>
                                <div class="relative">
                                    <i class='bx bx-lock absolute left-4 top-1/2 -translate-y-1/2 text-xl text-gray-400'></i>
                                    <input type="password" name="old_password" class="w-full bg-gray-50 border border-gray-100 rounded-2xl pl-12 pr-6 py-3.5 text-dark font-bold text-xs custom-input transition-all outline-none" placeholder="Masukkan kata sandi saat ini">
                                </div>
                            </div>
                            
                            <!-- New Password -->
                            <div class="space-y-2">
                                <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 px-1">Kata Sandi Baru</label>
                                <div class="relative">
                                    <i class='bx bx-lock-open absolute left-4 top-1/2 -translate-y-1/2 text-xl text-gray-400'></i>
                                    <input type="password" name="new_password" class="w-full bg-gray-50 border border-gray-100 rounded-2xl pl-12 pr-6 py-3.5 text-dark font-bold text-xs custom-input transition-all outline-none" placeholder="Kata sandi baru (min 8 karakter)">
                                </div>
                            </div>
                            
                            <!-- Confirm New Password -->
                            <div class="space-y-2">
                                <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 px-1">Konfirmasi Kata Sandi Baru</label>
                                <div class="relative">
                                    <i class='bx bx-check-shield absolute left-4 top-1/2 -translate-y-1/2 text-xl text-gray-400'></i>
                                    <input type="password" name="new_password_confirmation" class="w-full bg-gray-50 border border-gray-100 rounded-2xl pl-12 pr-6 py-3.5 text-dark font-bold text-xs custom-input transition-all outline-none" placeholder="Ketik ulang kata sandi baru">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Action Bar -->
                <div class="col-span-1 lg:col-span-3 flex justify-end gap-4 mt-4">
                    <button type="submit" class="bg-primary hover:bg-primaryHover text-white px-10 py-5 rounded-[24px] font-black uppercase tracking-widest text-sm transition-all shadow-xl shadow-blue-900/10 flex items-center gap-2">
                        <i class='bx bx-save text-xl'></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection

@push('scripts')
<script>
    // Realtime image upload preview
    document.getElementById('foto_ktp_input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const previewImg = document.getElementById('ktp-preview');
                const placeholder = document.getElementById('ktp-placeholder');
                
                previewImg.src = event.target.result;
                previewImg.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
