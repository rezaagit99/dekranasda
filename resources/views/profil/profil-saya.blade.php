@extends('layouts.vertical', ['title' => 'Profil Saya'])

@section('css')

@endsection

@section('content')
    @include('layouts.partials/page-title', ['title' => 'Profil Saya'] )

    <div class="container-fluid p-6 space-y-6">

        <!-- Header Halaman -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-default-800">Profil Saya</h2>
                <p class="text-xs text-default-500 mt-0.5">Kelola informasi data diri dan pengaturan akun Anda.</p>
            </div>
        </div>

        <!-- Alert Success / Error Notification -->
        @if(session('success'))
            <div class="p-4 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 rounded-lg bg-danger/10 border border-danger/20 text-danger text-sm space-y-1">
                <span class="font-medium">Terjadi kesalahan pada input data:</span>
                <ul class="list-disc list-inside text-xs">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profil-saya.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- SECTION 1: DATA AKUN PENGGUNA (Tampil untuk Semua Role) -->
            <div class="card bg-white p-6 rounded-xl border border-default-200 shadow-sm space-y-5">
                <div class="flex items-center justify-between border-b border-default-200 pb-4">
                    <h3 class="text-base font-semibold text-default-800 flex items-center gap-2">
                        <i data-lucide="user-cog" class="size-5 text-primary"></i> Data Akun Pengguna
                    </h3>
                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-primary/10 text-primary capitalize">
                        Role: {{ strtoupper($user->role->role_nama ?? 'User') }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="inline-block mb-1.5 text-sm text-default-800 font-medium">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-input w-full" required>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="inline-block mb-1.5 text-sm text-default-800 font-medium">
                            Email <span class="text-danger">*</span>
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-input w-full" required>
                    </div>

                    <!-- Password Baru (Opsional) -->
                    <div>
                        <label for="password" class="inline-block mb-1.5 text-sm text-default-800 font-medium">
                            Password Baru <span class="text-xs text-default-400 font-normal">(Kosongkan jika tidak diubah)</span>
                        </label>
                        <div class="relative flex items-center">
                            <input type="password" id="password" name="password" class="form-input w-full pe-10" placeholder="••••••••">
                            <button type="button" class="toggle-password-btn absolute end-3 inset-y-0 flex items-center text-default-400 hover:text-default-600 cursor-pointer z-10" data-target="#password">
                                <i class="password-icon size-4" data-lucide="eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- No Telp / WA -->
                    <div>
                        <label for="no_telp" class="inline-block mb-1.5 text-sm text-default-800 font-medium">No. Telp / WhatsApp</label>
                        <input type="text" id="no_telp" name="no_telp" value="{{ old('no_telp', $user->no_telp) }}" class="form-input w-full" placeholder="08123456789">
                    </div>

                    <!-- Instagram -->
                    <div>
                        <label for="instagram" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Instagram</label>
                        <div class="flex rounded-md shadow-xs">
                            <span class="px-3 inline-flex items-center min-w-max border border-e-0 border-default-200 rounded-s-md bg-default-100 text-sm text-default-500">@</span>
                            <input type="text" id="instagram" name="instagram" value="{{ old('instagram', $user->instagram) }}" class="form-input w-full rounded-s-none" placeholder="username">
                        </div>
                    </div>

                    <!-- Foto Profil -->
                    <div>
                        <label class="inline-block mb-1.5 text-sm text-default-800 font-medium">Foto Profil</label>
                        <div class="relative w-full">
                            <input type="file" id="foto" name="foto" accept="image/*" 
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                                onchange="document.getElementById('profile-file-name').textContent = this.files[0]?.name || 'Pilih foto profil baru...';">
                            
                            <div class="flex items-center justify-between w-full border border-default-200 rounded-lg p-1.5 bg-white cursor-pointer hover:border-default-400">
                                <span id="profile-file-name" class="text-sm text-default-400 px-2 truncate">Pilih foto profil baru...</span>
                                <span class="px-3 py-1.5 rounded-md bg-default-100 text-default-700 text-xs font-medium shrink-0">Browse</span>
                            </div>
                        </div>
                    </div>

                    <!-- Alamat Pengguna -->
                    <div class="md:col-span-2">
                        <label for="alamat" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Alamat Tempat Tinggal</label>
                        <textarea id="alamat" name="alamat" rows="2" class="form-input w-full" placeholder="Alamat lengkap pengguna...">{{ old('alamat', $user->alamat) }}</textarea>
                    </div>
                </div>
            </div>


            <!-- SECTION 2: DATA UMKM (Hanya Tampil untuk Role 3 / UMKM) -->
            @if($user->role_id == 3)
                <div class="card bg-white p-6 rounded-xl border border-default-200 shadow-sm space-y-5">
                    <div class="border-b border-default-200 pb-4">
                        <h3 class="text-base font-semibold text-default-800 flex items-center gap-2">
                            <i data-lucide="store" class="size-5 text-primary"></i> Data Usaha / UMKM
                        </h3>
                        <p class="text-xs text-default-400 mt-0.5">Informasi profil usaha UMKM yang terikat dengan akun Anda.</p>
                    </div>

                    <div class="space-y-4">
                        <!-- Nama UMKM -->
                        <div class="mt-2">
                            <label for="nama_umkm" class="inline-block mb-1.5 text-sm text-default-800 font-medium">
                                Nama UMKM <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="nama_umkm" name="nama_umkm" 
                                value="{{ old('nama_umkm', optional($user->umkmByUser)->nama_umkm) }}" 
                                class="form-input w-full" placeholder="Masukkan nama UMKM..." required>
                        </div>

                        <!-- Kategori (Hardcoded Select) -->
                        <div>
                            <label for="kategori" class="inline-block mb-1.5 text-sm text-default-800 font-medium">
                                Kategori <span class="text-danger">*</span>
                            </label>
                            <select id="kategori" name="kategori" class="form-input w-full" required>
                                <option value="" disabled {{ old('kategori', optional($user->umkmByUser)->kategori) == '' ? 'selected' : '' }}>-- Pilih Kategori --</option>
                                <option value="Kuliner" {{ old('kategori', optional($user->umkmByUser)->kategori) == 'Kuliner' ? 'selected' : '' }}>Kuliner</option>
                                <option value="Fashion" {{ old('kategori', optional($user->umkmByUser)->kategori) == 'Fashion' ? 'selected' : '' }}>Fashion</option>
                                <option value="Kerajinan" {{ old('kategori', optional($user->umkmByUser)->kategori) == 'Kerajinan' ? 'selected' : '' }}>Kerajinan / Makanan Khas</option>
                                <option value="Pertanian" {{ old('kategori', optional($user->umkmByUser)->kategori) == 'Pertanian' ? 'selected' : '' }}>Pertanian / Perkebunan</option>
                                <option value="Jasa" {{ old('kategori', optional($user->umkmByUser)->kategori) == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                                <option value="Lainnya" {{ old('kategori', optional($user->umkmByUser)->kategori) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>

                        <!-- Alamat UMKM -->
                        <div>
                            <label for="alamat_umkm" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Alamat UMKM</label>
                            <textarea id="alamat_umkm" name="alamat_umkm" rows="3" class="form-input w-full" placeholder="Masukkan alamat lengkap UMKM...">{{ old('alamat_umkm', optional($user->umkmByUser)->alamat) }}</textarea>
                        </div>

                        <!-- Deskripsi UMKM -->
                        <div>
                            <label for="deskripsi_umkm" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Deskripsi UMKM</label>
                            <textarea id="deskripsi_umkm" name="deskripsi_umkm" rows="3" class="form-input w-full" placeholder="Masukkan ringkasan profil/produk UMKM...">{{ old('deskripsi_umkm', optional($user->umkmByUser)->deskripsi) }}</textarea>
                        </div>

                        <!-- Foto / Logo UMKM -->
                        <div>
                            <label class="inline-block mb-1.5 text-sm text-default-800 font-medium">Foto / Logo UMKM</label>

                            <!-- Preview Foto/Logo yang Ada / Baru -->
                            <div class="mb-3 flex items-center gap-4">
                                <div class="relative size-20 rounded-lg border border-default-200 bg-default-50 overflow-hidden flex items-center justify-center shrink-0">
                                    @if(optional($user->umkmByUser)->foto_umkm)
                                        <img id="umkm-logo-preview" 
                                            src="{{ asset('storage/' . $user->umkmByUser->foto_umkm) }}?v={{ time() }}" 
                                            alt="Logo UMKM" 
                                            class="w-full h-full object-cover">
                                    @else
                                        <img id="umkm-logo-preview" 
                                            src="" 
                                            alt="Preview Logo" 
                                            class="w-full h-full object-cover hidden">
                                        <i id="umkm-logo-icon" data-lucide="store" class="size-8 text-default-400"></i>
                                    @endif
                                </div>
                                <div class="text-xs text-default-500">
                                    <p class="font-medium text-default-700 mb-1">Preview Logo UMKM</p>
                                    <p>Format yang didukung: PNG, JPG, atau WEBP.</p>
                                    <p>Ukuran maksimal: 2MB</p>
                                </div>
                            </div>

                            <!-- Input File Upload -->
                            <div class="relative w-full">
                                <input type="file" id="foto_umkm" name="foto_umkm" accept="image/*" 
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                                    onchange="previewUmkmLogo(event)">
                                
                                <div class="flex items-center justify-between w-full border border-default-200 rounded-lg p-1.5 bg-white cursor-pointer hover:border-default-400 transition-all">
                                    <span id="umkm-file-name" class="text-sm text-default-400 px-2 truncate">
                                        {{ optional($user->umkmByUser)->foto_umkm ? basename($user->umkmByUser->foto_umkm) : 'Pilih foto atau logo UMKM...' }}
                                    </span>
                                    <span class="px-3 py-1.5 rounded-md bg-default-100 text-default-700 text-xs font-medium shrink-0">Browse</span>
                                </div>
                            </div>
                        </div>

                        <!-- Status (Read-Only untuk UMKM, Dropdown untuk Super Admin) -->
                        <div>
                            <label class="inline-block mb-1.5 text-sm text-default-800 font-medium">
                                Status <span class="text-danger">*</span>
                            </label>

                            @if(auth()->user()->role_id == 1)
                                {{-- Super Admin BISA UBAH --}}
                                <select id="status_umkm" name="status_umkm" class="form-select w-full" required>
                                    <option value="published" {{ old('status_umkm', optional($user->umkmByUser)->status) == 'published' ? 'selected' : '' }}>Published (Langsung Terbit)</option>
                                    <option value="draft" {{ old('status_umkm', optional($user->umkmByUser)->status) == 'draft' ? 'selected' : '' }}>Draft (Pending Verification)</option>
                                </select>
                            @else
                                {{-- Role UMKM HANYA LIHAT (READ ONLY) --}}
                                <div class="p-3 bg-default-50 border border-default-200 rounded-lg flex items-center justify-between">
                                    @php
                                        $status = strtolower(optional($user->umkmByUser)->status ?? 'draft');
                                    @endphp

                                    @if($status == 'published' || $status == 'terbit')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-600 border border-emerald-500/20">
                                            <span class="size-1.5 rounded-full bg-emerald-500"></span>
                                            Published (Langsung Terbit)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-600 border border-amber-500/20">
                                            <span class="size-1.5 rounded-full bg-amber-500"></span>
                                            Draft / Menunggu Verifikasi
                                        </span>
                                    @endif

                                    <span class="text-xs text-default-400 italic">*Status hanya dapat diubah oleh Super Admin</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif


            <!-- Footer Action Button -->
            <div class="flex justify-end gap-3">
                <button type="submit" class="btn bg-primary text-white hover:bg-primary-600 px-6 py-2.5 rounded-lg font-medium flex items-center gap-2">
                    <i data-lucide="save" class="size-4"></i> Simpan Perubahan Profil
                </button>
            </div>

        </form>
    </div>

@endsection

@section('scripts')
    <script>
        function previewUmkmLogo(event) {
            const input = event.target;
            const fileNameSpan = document.getElementById('umkm-file-name');
            const previewImg = document.getElementById('umkm-logo-preview');
            const defaultIcon = document.getElementById('umkm-logo-icon');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Set nama file pada input custom
                if (fileNameSpan) {
                    fileNameSpan.textContent = file.name;
                }

                // Baca file dan tampilkan preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (previewImg) {
                        previewImg.src = e.target.result;
                        previewImg.classList.remove('hidden');
                    }
                    if (defaultIcon) {
                        defaultIcon.classList.add('hidden');
                    }
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
