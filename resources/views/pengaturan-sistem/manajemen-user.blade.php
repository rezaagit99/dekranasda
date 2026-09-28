@extends('layouts.vertical', ['title' => 'Manajemen Pengguna'])

@section('css')

@endsection

@section('content')
    @include('layouts.partials/page-title', ['title' => 'Manajemen Pengguna'] )

    <div class="card">
        <div class="card-header">
            <h6 class="card-title">Daftar Pengguna</h6>
            {{-- <button class="btn btn-sm bg-primary text-white">
                <i class="size-4 me-1" data-lucide="plus"></i>Add user
            </button> --}}
            <button aria-controls="addUserModal" aria-expanded="false" aria-haspopup="dialog"
                class="btn btn-sm bg-primary text-white" data-hs-overlay="#addUserModal" type="button">
                <i class="size-4 ms-1" data-lucide="plus"></i>
                Add User
            </button>
            <form id="global-delete-form" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
        <div class="card-header">
            <div class="md:flex items-center md:space-y-0 space-y-4 gap-3">
                <div class="relative">
                    <input class="form-input form-input-sm ps-9" placeholder="Search for name,email" type="email"/>
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3">
                        <i class="size-3.5 flex items-center text-default-500 fill-default-100"
                           data-lucide="search"></i>
                    </div>
                </div>
                <select class="form-input form-input-sm">
                    <option selected="">select status</option>
                    <option>Hidden</option>
                    <option>Rejected</option>
                    <option>Verified</option>
                    <option>Waiting</option>
                </select>
            </div>
            <div class="flex gap-2 items-center flex-wrap">
                <button
                    class="btn btn-sm bg-transparent border border-dashed border-primary text-primary hover:bg-primary/10"
                    type="button">
                    <i class="size-4" data-lucide="download"></i>
                    Import
                </button>
                <button
                    class="btn btn-sm size-7.5 bg-default-100 text-default-500 hover:bg-default-1500 hover:text-white"
                    type="button">
                    <i class="size-4" data-lucide="sliders-horizontal"></i>
                </button>
            </div>
        </div>
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="min-w-full inline-block align-middle">
                    <div class="overflow-hidden">
                        @include('pengaturan-sistem.manajemen-user-table')
                    </div>
                </div>
            </div>
            <div class="card-footer px-6 py-4 border-t border-default-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <!-- Teks Showing Dinamis -->
                <p class="text-default-500 text-sm">
                    Showing <b>{{ $users->firstItem() ?? 0 }}</b> to <b>{{ $users->lastItem() ?? 0 }}</b> of <b>{{ $users->total() }}</b> Results
                </p>

                <!-- Navigasi Tombol Pagination Dinamis -->
                @if ($users->hasPages())
                    <nav aria-label="Pagination" class="flex items-center gap-1.5">
                        
                        {{-- Tombol Previous --}}
                        @if ($users->onFirstPage())
                            <button class="btn btn-sm border bg-transparent border-default-200 text-default-400 opacity-50 cursor-not-allowed" type="button" disabled>
                                <i class="size-4 me-1" data-lucide="chevron-left"></i> Prev
                            </button>
                        @else
                            <a href="{{ $users->previousPageUrl() }}" class="btn btn-sm border bg-transparent border-default-200 text-default-600 hover:bg-primary/10 hover:text-primary hover:border-primary/10">
                                <i class="size-4 me-1" data-lucide="chevron-left"></i> Prev
                            </a>
                        @endif

                        {{-- Angka Halaman --}}
                        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                            @if ($page == $users->currentPage())
                                {{-- Halaman Aktif --}}
                                <span class="btn size-8 bg-primary text-white flex items-center justify-center rounded-md text-sm font-medium">
                                    {{ $page }}
                                </span>
                            @else
                                {{-- Halaman Lain --}}
                                <a href="{{ $url }}" class="btn size-8 bg-transparent border border-default-200 text-default-600 hover:bg-primary/10 hover:text-primary hover:border-primary/10 flex items-center justify-center rounded-md text-sm">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- Tombol Next --}}
                        @if ($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}" class="btn btn-sm border bg-transparent border-default-200 text-default-600 hover:bg-primary/10 hover:text-primary hover:border-primary/10">
                                Next <i class="size-4 ms-1" data-lucide="chevron-right"></i>
                            </a>
                        @else
                            <button class="btn btn-sm border bg-transparent border-default-200 text-default-400 opacity-50 cursor-not-allowed" type="button" disabled>
                                Next <i class="size-4 ms-1" data-lucide="chevron-right"></i>
                            </button>
                        @endif

                    </nav>
                @endif
            </div>
        </div>
    </div>

    <div id="addUserModal"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
        role="dialog" tabindex="-1" aria-labelledby="addUserModal-label">
        
        <!-- Modal Container dengan Max Width 520px -->
        <div class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center" style="max-width: 520px;">
            
            <!-- Form Tambah User -->
            <form action="{{ route('manajemen-user.store') }}" method="POST" enctype="multipart/form-data" 
                class="card w-full flex flex-col border border-default-200 shadow-lg rounded-xl pointer-events-auto bg-white">
                @csrf

                <!-- Modal Header -->
                <div class="card-header flex items-center justify-between px-6 py-5 border-b border-default-200">
                    <h3 id="addUserModal-label" class="font-semibold text-lg text-default-800 dark:text-white">
                        Tambah Pengguna
                    </h3>
                    <button type="button" class="size-6 text-default-600 hover:text-default-900 flex items-center justify-center rounded-lg transition-all" aria-label="Close"
                        data-hs-overlay="#addUserModal">
                        <span class="sr-only">Close</span>
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="card-body px-6 py-5 space-y-4.5 max-h-[70vh] overflow-y-auto" data-simplebar>
                    
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-input" placeholder="Masukkan nama lengkap" required>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="inline-block mt-2 mb-1.5 text-sm text-default-800 font-medium">Email <span class="text-danger">*</span></label>
                        <input type="email" id="email" name="email" class="form-input" placeholder="contoh@email.com" required>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="inline-block mt-2 mb-1.5 text-sm text-default-800 font-medium">
                            Password <span class="text-danger">*</span>
                        </label>
                        
                        <div class="relative flex items-center">
                            <input type="password" 
                                id="password" 
                                name="password" 
                                class="form-input w-full pe-10" 
                                placeholder="••••••••" 
                                required>
                            
                            <button type="button" 
                                    id="togglePassword" 
                                    class="toggle-password-btn absolute end-3 inset-y-0 flex items-center text-default-400 hover:text-default-600 cursor-pointer z-10">
                                <i id="passwordIcon" class="size-4" data-lucide="eye"></i>
                            </button>
                        </div>
                        
                        <span class="text-xs text-default-400">Password minimal 8 karakter.</span>
                    </div>

                    <!-- Role & Status -->
                    <div class="grid grid-cols-2 gap-4 mt-2">
                        <div>
                            <label for="role_id" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Role <span class="text-danger">*</span></label>
                            <select id="role_id" name="role_id" class="form-input" required>
                                <option value="" selected disabled>Pilih Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->role_id }}">{{ Str::headline($role->role_nama) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="status" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Status <span class="text-danger">*</span></label>
                            <select id="status" name="status" class="form-input" required>
                                <option value="" selected disabled>Pilih Status</option>
                                <option value="terverifikasi">Terverifikasi</option>
                                <option value="menunggu">Menunggu</option>
                                <option value="ditolak">Ditolak</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <!-- Kolom UMKM (Sembunyi secara default / hidden) -->
                    <div id="container_umkm" class="hidden mt-2">
                        <label for="umkm_id" class="inline-block mb-1.5 text-sm text-default-800 font-medium">
                            Pilih UMKM <span class="text-danger">*</span>
                        </label>
                        <select id="umkm_id" name="umkm_id" class="form-input">
                            <option value="" selected disabled>-- Pilih UMKM --</option>
                            @foreach($umkmsUnassigned as $u)
                                <option value="{{ $u->umkm_id }}">{{ $u->nama_umkm }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- No Telp & Instagram -->
                    <div class="grid grid-cols-2 gap-4 mt-2">
                        <div>
                            <label for="no_telp" class="inline-block mb-1.5 text-sm text-default-800 font-medium">No. Telp/WA</label>
                            <input type="text" id="no_telp" name="no_telp" class="form-input" placeholder="08123456789">
                        </div>
                        <div>
                            <label for="instagram" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Instagram</label>
                            <div class="flex rounded-md shadow-xs">
                                <span class="px-3 inline-flex items-center min-w-max border border-e-0 border-default-200 rounded-s-md bg-default-100 text-sm text-default-500">@</span>
                                <input type="text" id="instagram" name="instagram" class="form-input rounded-s-none" placeholder="username">
                            </div>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label for="alamat" class="inline-block mt-2 mb-1.5 text-sm text-default-800 font-medium">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="2" class="form-input" placeholder="Masukkan alamat singkat"></textarea>
                    </div>

                    <!-- Foto Profil -->
                    <div>
                        <label class="inline-block mt-2 mb-1.5 text-sm text-default-800 font-medium">Foto Profil</label>
                        <div class="relative w-full">
                            <input type="file" id="foto" name="foto" accept="image/*" 
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                                onchange="document.getElementById('file-name').textContent = this.files[0]?.name || 'Pilih foto profil...'; document.getElementById('file-name').classList.remove('text-default-400'); document.getElementById('file-name').classList.add('text-default-800');">
                            
                            <div class="flex items-center justify-between w-full border border-default-200 rounded-lg p-1.5 bg-white cursor-pointer hover:border-default-400 transition-all">
                                <span id="file-name" class="text-sm text-default-400 px-2 truncate">Pilih foto profil...</span>
                                <span class="px-3 py-1.5 rounded-md bg-default-100 text-default-700 text-xs font-medium hover:bg-default-200 shrink-0">
                                    Browse
                                </span>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-default-400">PNG, JPG, atau WEBP (Maks. 2MB)</p>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="card-footer px-6 py-4 border-t border-default-200 flex gap-3 justify-end items-center">
                    <button type="button" class="btn border border-default-200 text-default-700 hover:bg-default-100 px-4 py-2" data-hs-overlay="#addUserModal">
                        Batal
                    </button>
                    <button type="submit" class="btn bg-primary text-white hover:bg-primary-600 px-5 py-2">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit User -->
    <div id="editUserModal"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
        role="dialog" tabindex="-1" aria-labelledby="editUserModal-label">
        
        <div class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center" style="max-width: 520px;">
            
            <form id="editUserForm" method="POST" enctype="multipart/form-data" 
                class="card w-full flex flex-col border border-default-200 shadow-lg rounded-xl pointer-events-auto bg-white">
                @csrf
                @method('PUT')

                <!-- Header -->
                <div class="card-header flex items-center justify-between px-6 py-5 border-b border-default-200">
                    <h3 id="editUserModal-label" class="font-semibold text-lg text-default-800">
                        Edit Pengguna
                    </h3>
                    <button type="button" class="size-6 text-default-600 hover:text-default-900 flex items-center justify-center rounded-lg" aria-label="Close" data-hs-overlay="#editUserModal">
                        <span class="sr-only">Close</span>
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                </div>

                <!-- Body -->
                <div class="card-body px-6 py-5 space-y-4 max-h-[70vh] overflow-y-auto">
                    
                    <div>
                        <label for="edit_name" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" id="edit_name" name="name" class="form-input w-full" required>
                    </div>

                    <div>
                        <label for="edit_email" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Email <span class="text-danger">*</span></label>
                        <input type="email" id="edit_email" name="email" class="form-input w-full" required>
                    </div>

                    <div>
                        <label for="edit_password" class="inline-block mb-1.5 text-sm text-default-800 font-medium">
                            Password <span class="text-xs text-default-400 font-normal">(Kosongkan jika tidak diubah)</span>
                        </label>
                        
                        <div class="relative flex items-center">
                            <input type="password" 
                                id="edit_password" 
                                name="password" 
                                class="form-input w-full pe-10" 
                                placeholder="••••••••">
                            
                            <button type="button" 
                                    class="toggle-password-btn absolute end-3 inset-y-0 flex items-center text-default-400 hover:text-default-600 cursor-pointer z-10"
                                    data-target="#edit_password">
                                <i class="password-icon size-4" data-lucide="eye"></i>
                            </button>
                        </div>
                        
                        <span class="text-xs text-default-400">Password minimal 8 karakter.</span>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="edit_role_id" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Role <span class="text-danger">*</span></label>
                            <select id="edit_role_id" name="role_id" class="form-input w-full" required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->role_id }}">{{ Str::headline($role->role_nama) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="edit_status" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Status <span class="text-danger">*</span></label>
                            <select id="edit_status" name="status" class="form-input w-full" required>
                                <option value="terverifikasi">Terverifikasi</option>
                                <option value="menunggu">Menunggu</option>
                                <option value="ditolak">Ditolak</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <!-- Container Dropdown UMKM (Sembunyi secara default) -->
                    <div id="edit_container_umkm" class="hidden">
                        <label for="edit_umkm_id" class="inline-block mb-1.5 text-sm text-default-800 font-medium">
                            Pilih UMKM <span class="text-danger">*</span>
                        </label>
                        <select id="edit_umkm_id" name="umkm_id" class="form-input w-full">
                            <option value="" selected disabled>-- Pilih UMKM --</option>
                            @foreach($umkmsAll as $umkm)
                                {{-- Menampilkan semua UMKM, tapi yang sudah ada pemiliknya tidak bisa dipilih kecuali milik user sendiri --}}
                                <option value="{{ $umkm->umkm_id }}" 
                                        data-owner="{{ $umkm->user->id ?? '' }}">
                                    {{ $umkm->nama_umkm }} {{ $umkm->user ? ' (Sudah ada pemilik)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="edit_no_telp" class="inline-block mb-1.5 text-sm text-default-800 font-medium">No. Telp/WA</label>
                            <input type="text" id="edit_no_telp" name="no_telp" class="form-input w-full">
                        </div>
                        <div>
                            <label for="edit_instagram" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Instagram</label>
                            <div class="flex rounded-md shadow-xs">
                                <span class="px-3 inline-flex items-center min-w-max border border-e-0 border-default-200 rounded-s-md bg-default-100 text-sm text-default-500">@</span>
                                <input type="text" id="edit_instagram" name="instagram" class="form-input w-full rounded-s-none">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="edit_alamat" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Alamat</label>
                        <textarea id="edit_alamat" name="alamat" rows="2" class="form-input w-full"></textarea>
                    </div>

                    <div>
                        <label class="inline-block mb-1.5 text-sm text-default-800 font-medium">Foto Profil</label>
                        <div class="relative w-full">
                            <input type="file" id="edit_foto" name="foto" accept="image/*" 
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                                onchange="document.getElementById('edit-file-name').textContent = this.files[0]?.name || 'Ganti foto profil...';">
                            
                            <div class="flex items-center justify-between w-full border border-default-200 rounded-lg p-1.5 bg-white cursor-pointer hover:border-default-400">
                                <span id="edit-file-name" class="text-sm text-default-400 px-2 truncate">Ganti foto profil...</span>
                                <span class="px-3 py-1.5 rounded-md bg-default-100 text-default-700 text-xs font-medium shrink-0">Browse</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Footer -->
                <div class="card-footer px-6 py-4 border-t border-default-200 flex gap-3 justify-end items-center">
                    <button type="button" class="btn border border-default-200 text-default-700 hover:bg-default-100 px-4 py-2" data-hs-overlay="#editUserModal">
                        Batal
                    </button>
                    <button type="submit" class="btn bg-primary text-white hover:bg-primary-600 px-5 py-2">
                        Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // --- ELEMENT SELECTION ---
            const togglePasswordBtn = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');

            const roleSelect = document.getElementById('role_id');
            const containerUmkm = document.getElementById('container_umkm');
            const umkmSelect = document.getElementById('umkm_id');

            const editRoleSelect = document.getElementById('edit_role_id');
            const editContainerUmkm = document.getElementById('edit_container_umkm');
            const editUmkmSelect = document.getElementById('edit_umkm_id');


            // --- TOGGLE VISIBILITAS UMKM (TAMBAH USER) ---
            function toggleUmkmDropdown() {
                if (roleSelect && roleSelect.value == '3') {
                    containerUmkm.classList.remove('hidden');
                    umkmSelect.setAttribute('required', 'required');
                } else if (containerUmkm) {
                    containerUmkm.classList.add('hidden');
                    umkmSelect.removeAttribute('required');
                    umkmSelect.value = '';
                }
            }

            if (roleSelect) {
                roleSelect.addEventListener('change', toggleUmkmDropdown);
            }


            // --- TOGGLE VISIBILITAS UMKM (EDIT USER) ---
            function toggleEditUmkmDropdown() {
                if (editRoleSelect && editRoleSelect.value == '3') {
                    editContainerUmkm.classList.remove('hidden');
                    editUmkmSelect.setAttribute('required', 'required');
                } else if (editContainerUmkm) {
                    editContainerUmkm.classList.add('hidden');
                    editUmkmSelect.removeAttribute('required');
                    editUmkmSelect.value = '';
                }
            }

            if (editRoleSelect) {
                editRoleSelect.addEventListener('change', toggleEditUmkmDropdown);
            }


            // --- FUNGSI UTAMA 1: VIA OBJECT (window.openEditModal) ---
            window.openEditModal = function(userData) {
                const form = document.getElementById('editUserForm');
                if (!form) return;

                form.action = `/manajemen-user/${userData.id}`;

                document.getElementById('edit_name').value = userData.name || '';
                document.getElementById('edit_email').value = userData.email || '';
                document.getElementById('edit_role_id').value = userData.role_id || '';
                document.getElementById('edit_status').value = userData.status || '';
                document.getElementById('edit_no_telp').value = userData.no_telp || '';
                document.getElementById('edit_instagram').value = userData.instagram || '';
                document.getElementById('edit_alamat').value = userData.alamat || '';
                document.getElementById('edit_password').value = '';

                // Jalankan toggle untuk cek role_id
                toggleEditUmkmDropdown();

                // Jika role UMKM, pasang nilainya
                if (userData.role_id == '3') {
                    editUmkmSelect.value = userData.umkm_id || '';
                }

                if (typeof HSOverlay !== 'undefined') {
                    HSOverlay.open(document.getElementById('editUserModal'));
                }
            };


            // --- FUNGSI UTAMA 2: VIA DATASET BUTTON (.btn-edit) ---
            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function () {
                    const form = document.getElementById('editUserForm');
                    if (!form) return;

                    // 1. Assign Action Route
                    if (this.dataset.action) {
                        form.action = this.dataset.action;
                    }

                    // 2. Mapping Standard Text Fields
                    const textFields = ['name', 'email', 'no_telp', 'instagram', 'alamat'];
                    textFields.forEach(field => {
                        const input = document.getElementById(`edit_${field}`) || form.elements[field];
                        if (input) {
                            input.value = this.dataset[field] || '';
                        }
                    });

                    // 3. Set Role ID
                    const roleValue = String(this.dataset.roleId || this.dataset.role || '').trim();
                    if (editRoleSelect) {
                        editRoleSelect.value = roleValue;
                    }

                    // 4. JALANKAN TOGGLE VISIBILITAS UMKM
                    toggleEditUmkmDropdown();

                    // 5. Isikan nilainya jika Role UMKM
                    if (roleValue === '3' && editUmkmSelect) {
                        editUmkmSelect.value = this.dataset.umkmId || this.dataset.umkm || '';
                    }

                    // 6. Mapping Select Status
                    if (form.elements['status']) {
                        const statusValue = String(this.dataset.status || '').toLowerCase().trim();
                        form.elements['status'].value = statusValue;
                    }

                    // 7. Reset Password & Label File
                    if (form.elements['password']) form.elements['password'].value = '';

                    const fileNameLabel = document.getElementById('edit-file-name');
                    if (fileNameLabel) fileNameLabel.textContent = 'Ganti foto profil...';
                });
            });


            // --- PASSWORD TOGGLES ---
            if (togglePasswordBtn && passwordInput) {
                togglePasswordBtn.addEventListener('click', () => {
                    const isPassword = passwordInput.type === 'password';
                    passwordInput.type = isPassword ? 'text' : 'password';

                    if (passwordIcon) {
                        passwordIcon.setAttribute('data-lucide', isPassword ? 'eye-off' : 'eye');
                        if (typeof lucide !== 'undefined' && lucide.createIcons) {
                            lucide.createIcons();
                        }
                    }
                });
            }

            document.addEventListener('click', (e) => {
                const toggleBtn = e.target.closest('.toggle-password-btn');
                if (!toggleBtn) return;

                const targetSelector = toggleBtn.dataset.target;
                const targetInput = document.querySelector(targetSelector);
                const icon = toggleBtn.querySelector('.password-icon');

                if (targetInput) {
                    const isPassword = targetInput.type === 'password';
                    targetInput.type = isPassword ? 'text' : 'password';

                    if (icon) {
                        icon.setAttribute('data-lucide', isPassword ? 'eye-off' : 'eye');
                        if (typeof lucide !== 'undefined' && lucide.createIcons) {
                            lucide.createIcons();
                        }
                    }
                }
            });

        });

        // Handler Confirm Delete SweetAlert2
        function confirmDelete(deleteUrl, userName) {
            Swal.fire({
                title: 'Hapus User?',
                text: `Data "${userName}" akan dihapus secara permanen.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn bg-danger text-white px-4 py-2 rounded-lg',
                    cancelButton: 'btn bg-default-200 text-default-700 px-4 py-2 rounded-lg ms-2'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    const deleteForm = document.getElementById('global-delete-form');
                    deleteForm.action = deleteUrl;
                    deleteForm.submit();
                }
            });
        }
    </script>
@endsection
