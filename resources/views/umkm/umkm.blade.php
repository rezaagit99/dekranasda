@extends('layouts.vertical', ['title' => 'UMKM'])

@section('css')

@endsection

@section('content')
    @include('layouts.partials/page-title', ['title' => 'UMKM'] )

    <div class="card">
        <div class="card-header">
            <h6 class="card-title">Daftar UMKM</h6>
            {{-- <button class="btn btn-sm bg-primary text-white">
                <i class="size-4 me-1" data-lucide="plus"></i>Add user
            </button> --}}
            <button aria-controls="addumkmModal" aria-expanded="false" aria-haspopup="dialog"
                class="btn btn-sm bg-primary text-white" data-hs-overlay="#addumkmModal" type="button">
                <i class="size-4 ms-1" data-lucide="plus"></i>
                Add UMKM
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
                        @include('umkm.umkm-table')
                    </div>
                </div>
            </div>
            <div class="card-footer px-6 py-4 border-t border-default-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <!-- Teks Showing Dinamis -->
                <p class="text-default-500 text-sm">
                    Showing <b>{{ $umkmList->firstItem() ?? 0 }}</b> to <b>{{ $umkmList->lastItem() ?? 0 }}</b> of <b>{{ $umkmList->total() }}</b> Results
                </p>

                <!-- Navigasi Tombol Pagination Dinamis -->
                @if ($umkmList->hasPages())
                    <nav aria-label="Pagination" class="flex items-center gap-1.5">
                        
                        {{-- Tombol Previous --}}
                        @if ($umkmList->onFirstPage())
                            <button class="btn btn-sm border bg-transparent border-default-200 text-default-400 opacity-50 cursor-not-allowed" type="button" disabled>
                                <i class="size-4 me-1" data-lucide="chevron-left"></i> Prev
                            </button>
                        @else
                            <a href="{{ $umkmList->previousPageUrl() }}" class="btn btn-sm border bg-transparent border-default-200 text-default-600 hover:bg-primary/10 hover:text-primary hover:border-primary/10">
                                <i class="size-4 me-1" data-lucide="chevron-left"></i> Prev
                            </a>
                        @endif

                        {{-- Angka Halaman --}}
                        @foreach ($umkmList->getUrlRange(1, $umkmList->lastPage()) as $page => $url)
                            @if ($page == $umkmList->currentPage())
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
                        @if ($umkmList->hasMorePages())
                            <a href="{{ $umkmList->nextPageUrl() }}" class="btn btn-sm border bg-transparent border-default-200 text-default-600 hover:bg-primary/10 hover:text-primary hover:border-primary/10">
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

    <div id="addumkmModal"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
        role="dialog" tabindex="-1" aria-labelledby="addumkmModal-label">
        
        <!-- Modal Container (Max Width diperlebar ke 640px agar area penulisan isi berita lebih leluasa) -->
        <div class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center" style="max-width: 640px;">
            
            <!-- Form Tambah UMKM -->
            <form action="{{ route('umkm.umkm.store') }}" method="POST" enctype="multipart/form-data" 
                id="addUmkmForm"
                class="card w-full flex flex-col border border-default-200 shadow-lg rounded-xl pointer-events-auto bg-white dark:bg-neutral-800">
                @csrf

                <!-- Modal Header -->
                <div class="card-header flex items-center justify-between px-6 py-5 border-b border-default-200">
                    <h3 id="addumkmModal-label" class="font-semibold text-lg text-default-800 dark:text-white">
                        Tambah UMKM Baru
                    </h3>
                    <button type="button" class="size-6 text-default-600 hover:text-default-900 flex items-center justify-center rounded-lg transition-all" aria-label="Close"
                        data-hs-overlay="#addumkmModal">
                        <span class="sr-only">Close</span>
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="card-body px-6 py-5 space-y-4 max-h-[75vh] overflow-y-auto" data-simplebar>
                    
                    <!-- Nama UMKM -->
                    <div class="mb-2">
                        <label for="nama_umkm" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Nama UMKM <span class="text-danger">*</span></label>
                        <input type="text" id="nama_umkm" name="nama_umkm" class="form-input" placeholder="Masukkan nama UMKM..." required>
                    </div>

                    <!-- Kategori -->
                    {{-- <div class="mb-2">
                        <label for="kategori" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Kategori <span class="text-danger">*</span></label>
                        <select id="kategori" name="kategori" class="form-input" required>
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            <option value="Kuliner">Kuliner</option>
                            <option value="Fashion">Fashion</option>
                            <option value="Kerajinan">Kerajinan / Makanan Khas</option>
                            <option value="Pertanian">Pertanian / Perkebunan</option>
                            <option value="Jasa">Jasa</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div> --}}

                    <!-- Alamat UMKM -->
                    <div class="mb-2">
                        <label for="alamat" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Alamat UMKM</label>
                        <textarea id="alamat" name="alamat" class="form-input" placeholder="Masukkan alamat lengkap UMKM..." rows="2"></textarea>
                    </div>

                    <!-- Deskripsi UMKM -->
                    <div class="mb-2">
                        <label for="deskripsi" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Deskripsi UMKM</label>
                        <textarea id="deskripsi" name="deskripsi" class="form-input" placeholder="Masukkan ringkasan profil/produk UMKM..." rows="3"></textarea>
                    </div>

                    <!-- Foto / Logo UMKM -->
                    <div class="mb-2">
                        <label class="inline-block mb-1.5 text-sm text-default-800 font-medium">Foto / Logo UMKM</label>
                        <div class="relative w-full">
                            <!-- Input File Asli -->
                            <input type="file" id="foto_umkm" name="foto_umkm" accept="image/png, image/jpeg, image/webp" 
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                                onchange="document.getElementById('umkm-file-name').textContent = this.files[0]?.name || 'Pilih foto atau logo UMKM...'; document.getElementById('umkm-file-name').classList.remove('text-default-400'); document.getElementById('umkm-file-name').classList.add('text-default-800');">
                            
                            <!-- Custom Box Display -->
                            <div class="flex items-center justify-between w-full border border-default-200 rounded-lg p-1.5 bg-white dark:bg-neutral-800 cursor-pointer hover:border-default-400 transition-all">
                                <span id="umkm-file-name" class="text-sm text-default-400 px-2 truncate">Pilih foto atau logo UMKM...</span>
                                <span class="px-3 py-1.5 rounded-md bg-default-100 text-default-700 text-xs font-medium hover:bg-default-200 shrink-0">
                                    Browse
                                </span>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-default-400">PNG, JPG, atau WEBP (Maksimal 2MB)</p>
                    </div>

                    <!-- Status Publikasi -->
                    <div class="mb-2">
                        <label for="status" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Status <span class="text-danger">*</span></label>
                        <select id="status" name="status" class="form-input" required>
                            <option value="menunggu" selected>Menunggu</option>
                            <option value="published" selected>Published (Langsung Terbit)</option>
                            <option value="archived">Archived (Arsip)</option>
                        </select>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="card-footer px-6 py-4 border-t border-default-200 flex gap-3 justify-end items-center">
                    <button type="button" class="btn border border-default-200 text-default-700 hover:bg-default-100 px-4 py-2" data-hs-overlay="#addumkmModal">
                        Batal
                    </button>
                    <button type="submit" class="btn bg-primary text-white hover:bg-primary-600 px-5 py-2">
                        Simpan UMKM
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Berita -->
    <div id="editUmkmModal"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
        role="dialog" tabindex="-1" aria-labelledby="editUmkmModal-label">
        
        <div class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center" style="max-width: 640px;">
            
            <!-- Tag Form Diberi ID editUmkmForm -->
            <form action="" method="POST" enctype="multipart/form-data" id="editUmkmForm"
                class="card w-full flex flex-col border border-default-200 shadow-lg rounded-xl pointer-events-auto bg-white dark:bg-neutral-800">
                @csrf
                @method('PUT')

                <!-- Modal Header -->
                <div class="card-header flex items-center justify-between px-6 py-5 border-b border-default-200">
                    <h3 id="editUmkmModal-label" class="font-semibold text-lg text-default-800 dark:text-white">
                        Edit Data UMKM
                    </h3>
                    <button type="button" class="size-6 text-default-600 hover:text-default-900 flex items-center justify-center rounded-lg transition-all" aria-label="Close"
                        data-hs-overlay="#editUmkmModal">
                        <span class="sr-only">Close</span>
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="card-body px-6 py-5 space-y-4 max-h-[75vh] overflow-y-auto" data-simplebar>
                    
                    <!-- Nama UMKM -->
                    <div class="mb-2">
                        <label for="edit_nama_umkm" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Nama UMKM <span class="text-danger">*</span></label>
                        <input type="text" id="edit_nama_umkm" name="nama_umkm" class="form-input" placeholder="Masukkan nama UMKM..." required>
                    </div>

                    <!-- Kategori -->
                    {{-- <div class="mb-2">
                        <label for="edit_kategori" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Kategori <span class="text-danger">*</span></label>
                        <select id="edit_kategori" name="kategori" class="form-input" required>
                            <option value="" disabled>-- Pilih Kategori --</option>
                            <option value="Kuliner">Kuliner</option>
                            <option value="Fashion">Fashion</option>
                            <option value="Kerajinan">Kerajinan / Makanan Khas</option>
                            <option value="Pertanian">Pertanian / Perkebunan</option>
                            <option value="Jasa">Jasa</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div> --}}

                    <!-- Alamat UMKM -->
                    <div class="mb-2">
                        <label for="edit_alamat" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Alamat UMKM</label>
                        <textarea id="edit_alamat" name="alamat" class="form-input" placeholder="Masukkan alamat lengkap UMKM..." rows="2"></textarea>
                    </div>

                    <!-- Deskripsi UMKM -->
                    <div class="mb-2">
                        <label for="edit_deskripsi" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Deskripsi UMKM</label>
                        <textarea id="edit_deskripsi" name="deskripsi" class="form-input" placeholder="Masukkan ringkasan profil UMKM..." rows="3"></textarea>
                    </div>

                    <!-- Foto / Logo UMKM -->
                    <div class="mb-2">
                        <label class="inline-block mb-1.5 text-sm text-default-800 font-medium">Ganti Foto / Logo UMKM</label>
                        
                        <!-- Preview Foto Lama jika ada -->
                        <div id="edit_preview_container" class="mb-2 hidden">
                            <img id="edit_preview_img" src="" alt="Preview Foto UMKM" class="size-20 object-cover rounded-lg border border-default-200 mb-1">
                            <p class="text-xs text-default-400">Foto saat ini</p>
                        </div>

                        <div class="relative w-full">
                            <input type="file" id="edit_foto_umkm" name="foto_umkm" accept="image/png, image/jpeg, image/webp" 
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                                onchange="document.getElementById('edit-umkm-file-name').textContent = this.files[0]?.name || 'Pilih foto/logo baru jika ingin mengganti...'; document.getElementById('edit-umkm-file-name').classList.remove('text-default-400'); document.getElementById('edit-umkm-file-name').classList.add('text-default-800');">
                            
                            <div class="flex items-center justify-between w-full border border-default-200 rounded-lg p-1.5 bg-white dark:bg-neutral-800 cursor-pointer hover:border-default-400 transition-all">
                                <span id="edit-umkm-file-name" class="text-sm text-default-400 px-2 truncate">Pilih foto/logo baru jika ingin mengganti...</span>
                                <span class="px-3 py-1.5 rounded-md bg-default-100 text-default-700 text-xs font-medium hover:bg-default-200 shrink-0">
                                    Browse
                                </span>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-default-400">Biarkan kosong jika tidak ingin mengubah foto. PNG, JPG, WEBP (Max 2MB)</p>
                    </div>

                    <!-- Status Publikasi -->
                    <div class="mb-2">
                        <label for="edit_status" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Status <span class="text-danger">*</span></label>
                        <select id="edit_status" name="status" class="form-input" required>
                            <option value="published">Published (Terbit)</option>
                            <option value="archived">Archived (Arsip)</option>
                        </select>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="card-footer px-6 py-4 border-t border-default-200 flex gap-3 justify-end items-center">
                    <button type="button" class="btn border border-default-200 text-default-700 hover:bg-default-100 px-4 py-2" data-hs-overlay="#editUmkmModal">
                        Batal
                    </button>
                    <button type="submit" class="btn bg-primary text-white hover:bg-primary-600 px-5 py-2">
                        Perbarui UMKM
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // Target tombol dengan class .btn-edit
            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function () {
                    // Targetkan elemen FORM, bukan div modal
                    const form = document.getElementById('editUmkmForm');
                    if (!form) return;

                    // Update form action route (misal: /umkm/1)
                    form.action = this.dataset.action;

                    // Isi nilai input modal dari dataset tombol
                    const namaInput = document.getElementById('edit_nama_umkm');
                    // const kategoriInput = document.getElementById('edit_kategori');
                    const alamatInput = document.getElementById('edit_alamat');
                    const deskripsiInput = document.getElementById('edit_deskripsi');
                    const statusInput = document.getElementById('edit_status');

                    if (namaInput) namaInput.value = this.dataset.nama_umkm || '';
                    // if (kategoriInput) kategoriInput.value = this.dataset.kategori || '';
                    if (alamatInput) alamatInput.value = this.dataset.alamat || '';
                    if (deskripsiInput) deskripsiInput.value = this.dataset.deskripsi || '';
                    if (statusInput) statusInput.value = this.dataset.status || 'published';

                    // Preview Foto lama jika ada
                    const previewContainer = document.getElementById('edit_preview_container');
                    const previewImg = document.getElementById('edit_preview_img');
                    const fileNameText = document.getElementById('edit-umkm-file-name');

                    if (this.dataset.preview && previewContainer && previewImg) {
                        previewImg.src = this.dataset.preview;
                        previewContainer.classList.remove('hidden');
                    } else if (previewContainer) {
                        previewContainer.classList.add('hidden');
                    }

                    // Reset text placeholder input file
                    if (fileNameText) {
                        fileNameText.textContent = 'Pilih foto/logo baru jika ingin mengganti...';
                        fileNameText.classList.add('text-default-400');
                        fileNameText.classList.remove('text-default-800');
                    }
                });
            });

        }); // <-- Disesuaikan di sini (ditambahkan `);`)

        function confirmDeleteUmkm(deleteUrl, namaUmkm) {
            Swal.fire({
                title: 'Hapus UMKM?',
                text: `Data UMKM "${namaUmkm}" akan dihapus secara permanen.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn bg-danger text-white px-4 py-2 rounded-lg',
                    cancelButton: 'btn bg-default-200 text-default-700 px-4 py-2 rounded-lg ms-2'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    const deleteForm = document.getElementById('global-delete-form');
                    if (deleteForm) {
                        deleteForm.action = deleteUrl;
                        deleteForm.submit();
                    }
                }
            });
        }
    </script>
@endsection
