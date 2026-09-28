@extends('layouts.vertical', ['title' => 'Produk UMKM'])

@section('css')

@endsection

@section('content')
    @include('layouts.partials/page-title', ['title' => 'Produk UMKM'] )

    <div class="card">
        <div class="card-header">
            <h6 class="card-title">Daftar Produk</h6>
            {{-- <button class="btn btn-sm bg-primary text-white">
                <i class="size-4 me-1" data-lucide="plus"></i>Add user
            </button> --}}
            <button aria-controls="addprodukModal" aria-expanded="false" aria-haspopup="dialog"
                class="btn btn-sm bg-primary text-white" data-hs-overlay="#addprodukModal" type="button">
                <i class="size-4 ms-1" data-lucide="plus"></i>
                Add Produk
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
                        @include('umkm.produk-table')
                    </div>
                </div>
            </div>
            <div class="card-footer px-6 py-4 border-t border-default-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <!-- Teks Showing Dinamis -->
                <p class="text-default-500 text-sm">
                    Showing <b>{{ $produkList->firstItem() ?? 0 }}</b> to <b>{{ $produkList->lastItem() ?? 0 }}</b> of <b>{{ $produkList->total() }}</b> Results
                </p>

                <!-- Navigasi Tombol Pagination Dinamis -->
                @if ($produkList->hasPages())
                    <nav aria-label="Pagination" class="flex items-center gap-1.5">
                        
                        {{-- Tombol Previous --}}
                        @if ($produkList->onFirstPage())
                            <button class="btn btn-sm border bg-transparent border-default-200 text-default-400 opacity-50 cursor-not-allowed" type="button" disabled>
                                <i class="size-4 me-1" data-lucide="chevron-left"></i> Prev
                            </button>
                        @else
                            <a href="{{ $produkList->previousPageUrl() }}" class="btn btn-sm border bg-transparent border-default-200 text-default-600 hover:bg-primary/10 hover:text-primary hover:border-primary/10">
                                <i class="size-4 me-1" data-lucide="chevron-left"></i> Prev
                            </a>
                        @endif

                        {{-- Angka Halaman --}}
                        @foreach ($produkList->getUrlRange(1, $produkList->lastPage()) as $page => $url)
                            @if ($page == $produkList->currentPage())
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
                        @if ($produkList->hasMorePages())
                            <a href="{{ $produkList->nextPageUrl() }}" class="btn btn-sm border bg-transparent border-default-200 text-default-600 hover:bg-primary/10 hover:text-primary hover:border-primary/10">
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

    <div id="addprodukModal"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
        role="dialog" tabindex="-1" aria-labelledby="addprodukModal-label">
        
        <!-- Modal Container -->
        <div class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center" style="max-width: 640px;">
            
            <!-- Form Tambah Produk -->
            <form action="{{ route('umkm.produk.store') }}" method="POST" enctype="multipart/form-data" 
                id="addProdukForm"
                class="card w-full flex flex-col border border-default-200 shadow-lg rounded-xl pointer-events-auto bg-white dark:bg-neutral-800">
                @csrf

                <!-- Modal Header -->
                <div class="card-header flex items-center justify-between px-6 py-5 border-b border-default-200">
                    <h3 id="addprodukModal-label" class="font-semibold text-lg text-default-800 dark:text-white">
                        Tambah Produk Baru
                    </h3>
                    <button type="button" class="size-6 text-default-600 hover:text-default-900 flex items-center justify-center rounded-lg transition-all" aria-label="Close"
                        data-hs-overlay="#addprodukModal">
                        <span class="sr-only">Close</span>
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="card-body px-6 py-5 space-y-4 max-h-[75vh] overflow-y-auto" data-simplebar>
                    
                    <!-- Pemilik UMKM -->
                    @if(auth()->check() && auth()->user()->role_id == 3)
                        <input type="hidden" name="umkm_id" value="{{ auth()->user()->umkmByUser->umkm_id ?? '' }}">

                        <div class="mb-2">
                            <label class="inline-block mb-1.5 text-sm text-default-800 font-medium">
                                Pemilik UMKM
                            </label>
                            <input type="text" 
                                class="form-input bg-default-100 cursor-not-allowed text-default-600" 
                                value="{{ auth()->user()->umkmByUser->nama_umkm ?? 'UMKM Anda' }}" 
                                readonly disabled>
                        </div>
                    @else
                        <div class="mb-2">
                            <label for="add_umkm_id" class="inline-block mb-1.5 text-sm text-default-800 font-medium">
                                Pemilik UMKM <span class="text-danger">*</span>
                            </label>
                            <select id="add_umkm_id" name="umkm_id" class="form-input" required>
                                <option value="" disabled selected>-- Pilih UMKM --</option>
                                @foreach($umkmList as $u)
                                    <option value="{{ $u->umkm_id }}">{{ $u->nama_umkm }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <!-- Nama Produk -->
                    <div class="mb-2">
                        <label for="add_nama_produk" class="inline-block mb-1.5 text-sm text-default-800 font-medium">
                            Nama Produk <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="add_nama_produk" name="nama_produk" class="form-input" placeholder="Masukkan nama produk..." required>
                    </div>

                    <!-- Kategori Produk (DARI TABEL KATEGORIS) -->
                    <div class="mb-2">
                        <label for="add_kategori_id" class="inline-block mb-1.5 text-sm text-default-800 font-medium">
                            Kategori Produk <span class="text-danger">*</span>
                        </label>
                        <select id="add_kategori_id" name="kategori_id" class="form-input" required>
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->kategori_id }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Harga Produk -->
                    <div class="mb-2">
                        <label for="add_harga" class="inline-block mb-1.5 text-sm text-default-800 font-medium">
                            Harga (Rp) <span class="text-danger">*</span>
                        </label>
                        <input type="number" id="add_harga" name="harga" class="form-input" placeholder="Contoh: 25000" min="0" required>
                    </div>

                    <!-- Deskripsi Produk -->
                    <div class="mb-2">
                        <label for="add_deskripsi" class="inline-block mb-1.5 text-sm text-default-800 font-medium">
                            Deskripsi Produk
                        </label>
                        <textarea id="add_deskripsi" name="deskripsi" class="form-input" placeholder="Masukkan deskripsi detail produk..." rows="3"></textarea>
                    </div>

                    <!-- Foto Produk -->
                    <div class="mb-2">
                        <label class="inline-block mb-1.5 text-sm text-default-800 font-medium">Foto Produk</label>
                        <div class="relative w-full">
                            <input type="file" id="add_foto_produk" name="foto_produk[]" accept="image/png, image/jpeg, image/webp" 
                                multiple
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                                onchange="
                                    const count = this.files.length;
                                    const label = count > 0 ? count + ' foto dipilih' : 'Pilih foto produk...';
                                    const nameEl = document.getElementById('produk-file-name');
                                    nameEl.textContent = label;
                                    nameEl.classList.remove('text-default-400');
                                    nameEl.classList.add('text-default-800');
                                ">
                            
                            <div class="flex items-center justify-between w-full border border-default-200 rounded-lg p-1.5 bg-white dark:bg-neutral-800 cursor-pointer hover:border-default-400 transition-all">
                                <span id="produk-file-name" class="text-sm text-default-400 px-2 truncate">Pilih foto produk...</span>
                                <span class="px-3 py-1.5 rounded-md bg-default-100 text-default-700 text-xs font-medium hover:bg-default-200 shrink-0">
                                    Browse
                                </span>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-default-400">Pilih satu atau lebih gambar (PNG, JPG, WEBP - Maksimal 2MB per file)</p>
                    </div>

                    <!-- Status Stok -->
                    <div class="mb-2">
                        <label for="add_status" class="inline-block mb-1.5 text-sm text-default-800 font-medium">
                            Status Stok <span class="text-danger">*</span>
                        </label>
                        <select id="add_status" name="status" class="form-input" required>
                            <option value="available" selected>Tersedia (Available)</option>
                            <option value="out_of_stock">Habis (Out of Stock)</option>
                        </select>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="card-footer px-6 py-4 border-t border-default-200 flex gap-3 justify-end items-center">
                    <button type="button" class="btn border border-default-200 text-default-700 hover:bg-default-100 px-4 py-2" data-hs-overlay="#addprodukModal">
                        Batal
                    </button>
                    <button type="submit" class="btn bg-primary text-white hover:bg-primary-600 px-5 py-2">
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Produk -->
    <div id="editProdukModal"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
        role="dialog" tabindex="-1" aria-labelledby="editProdukModal-label">
        
        <div class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center" style="max-width: 640px;">
            
            <!-- Form Edit Produk (ID: #editProdukForm) -->
            <form action="" method="POST" enctype="multipart/form-data" 
                id="editProdukForm"
                class="card w-full flex flex-col border border-default-200 shadow-lg rounded-xl pointer-events-auto bg-white dark:bg-neutral-800">
                @csrf
                @method('PUT')

                <!-- Modal Header -->
                <div class="card-header flex items-center justify-between px-6 py-5 border-b border-default-200">
                    <h3 id="editProdukModal-label" class="font-semibold text-lg text-default-800 dark:text-white">
                        Edit Data Produk
                    </h3>
                    <button type="button" class="size-6 text-default-600 hover:text-default-900 flex items-center justify-center rounded-lg transition-all" aria-label="Close"
                        data-hs-overlay="#editProdukModal">
                        <span class="sr-only">Close</span>
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="card-body px-6 py-5 space-y-4 max-h-[75vh] overflow-y-auto" data-simplebar>
                    
                    <!-- Pemilik UMKM -->
                    @if(auth()->check() && auth()->user()->role === 'umkm')
                        <input type="hidden" name="umkm_id" id="edit_umkm_id_hidden" value="{{ auth()->user()->umkm->umkm_id ?? '' }}">
                    @else
                        <div class="mb-2">
                            <label for="edit_umkm_id" class="inline-block mb-1.5 text-sm text-default-800 font-medium">
                                Pemilik UMKM <span class="text-danger">*</span>
                            </label>
                            <select id="edit_umkm_id" name="umkm_id" class="form-input" required>
                                <option value="" disabled>-- Pilih UMKM --</option>
                                @foreach($umkmList as $u)
                                    <option value="{{ $u->umkm_id }}">{{ $u->nama_umkm }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <!-- Nama Produk -->
                    <div class="mb-2">
                        <label for="edit_nama_produk" class="inline-block mb-1.5 text-sm text-default-800 font-medium">
                            Nama Produk <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="edit_nama_produk" name="nama_produk" class="form-input" placeholder="Masukkan nama produk..." required>
                    </div>

                    <!-- Kategori Produk -->
                    <div class="mb-2">
                        <label for="edit_kategori_id" class="inline-block mb-1.5 text-sm text-default-800 font-medium">
                            Kategori Produk <span class="text-danger">*</span>
                        </label>
                        <select id="edit_kategori_id" name="kategori_id" class="form-input" required>
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->kategori_id }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Harga Produk & Views (Disusun Berdampingan 2 Kolom) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
                        <div>
                            <label for="edit_harga" class="inline-block mb-1.5 text-sm text-default-800 font-medium">
                                Harga (Rp) <span class="text-danger">*</span>
                            </label>
                            <input type="number" id="edit_harga" name="harga" class="form-input" placeholder="Contoh: 25000" min="0" required>
                        </div>

                        <!-- Kolom Views (Read-Only) -->
                        <div>
                            <label for="edit_views" class="inline-block mb-1.5 text-sm text-default-800 font-medium">
                                Total Dilihat (Views)
                            </label>
                            <div class="relative">
                                <input type="text" id="edit_views" class="form-input bg-default-100 text-default-600 cursor-not-allowed pr-10" readonly disabled placeholder="0">
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi Produk -->
                    <div class="mb-2">
                        <label for="edit_deskripsi_produk" class="inline-block mb-1.5 text-sm text-default-800 font-medium">
                            Deskripsi Produk
                        </label>
                        <textarea id="edit_deskripsi_produk" name="deskripsi" class="form-input" placeholder="Masukkan deskripsi detail produk..." rows="3"></textarea>
                    </div>

                    <!-- Foto Produk -->
                    <div class="mb-2">
                        <label class="inline-block mb-1.5 text-sm text-default-800 font-medium">Foto Produk</label>

                        <!-- Container Preview Foto Lama -->
                        <div id="edit_preview_produk_container" class="mb-3 hidden">
                            <p class="text-xs text-default-600 font-medium mb-1.5">Foto saat ini (Klik tombol merah ✖ untuk menghapus foto):</p>
                            
                            <!-- Grid Foto Lama -->
                            <div id="edit_preview_produk_list" class="flex flex-wrap gap-2">
                                <!-- Foto akan di-render secara dinamis oleh JS di sini -->
                            </div>

                            <!-- Input Hidden untuk Menampung List Foto yang Dihapus -->
                            <div id="deleted_fotos_inputs"></div>
                        </div>

                        <!-- Upload Foto Baru -->
                        <div class="relative w-full">
                            <input type="file" id="edit_foto_produk" name="foto_produk[]" accept="image/png, image/jpeg, image/webp" 
                                multiple
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                                onchange="
                                    const count = this.files.length;
                                    const label = count > 0 ? count + ' foto baru dipilih' : 'Tambah foto baru...';
                                    const nameEl = document.getElementById('edit-produk-file-name');
                                    nameEl.textContent = label;
                                    nameEl.classList.remove('text-default-400');
                                    nameEl.classList.add('text-default-800');
                                ">
                            
                            <div class="flex items-center justify-between w-full border border-default-200 rounded-lg p-1.5 bg-white dark:bg-neutral-800 cursor-pointer hover:border-default-400 transition-all">
                                <span id="edit-produk-file-name" class="text-sm text-default-400 px-2 truncate">Tambah foto baru...</span>
                                <span class="px-3 py-1.5 rounded-md bg-default-100 text-default-700 text-xs font-medium hover:bg-default-200 shrink-0">
                                    Browse
                                </span>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-default-400">Pilih gambar baru jika ingin menambah foto (PNG, JPG, WEBP - Max 2MB)</p>
                    </div>

                    <!-- Status Stok -->
                    <div class="mb-2">
                        <label for="edit_status_produk" class="inline-block mb-1.5 text-sm text-default-800 font-medium">
                            Status Stok <span class="text-danger">*</span>
                        </label>
                        <select id="edit_status_produk" name="status" class="form-input" required>
                            <option value="available">Tersedia (Available)</option>
                            <option value="out_of_stock">Habis (Out of Stock)</option>
                        </select>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="card-footer px-6 py-4 border-t border-default-200 flex gap-3 justify-end items-center">
                    <button type="button" class="btn border border-default-200 text-default-700 hover:bg-default-100 px-4 py-2" data-hs-overlay="#editProdukModal">
                        Batal
                    </button>
                    <button type="submit" class="btn bg-primary text-white hover:bg-primary-600 px-5 py-2">
                        Perbarui Produk
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const editProdukButtons = document.querySelectorAll('.btn-edit-produk');
    
            editProdukButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // 1. Ambil data dari tombol
                    const actionUrl  = this.getAttribute('data-action');
                    const umkmId     = this.getAttribute('data-umkm_id');
                    const namaProduk = this.getAttribute('data-nama_produk');
                    const kategoriId = this.getAttribute('data-kategori_id');
                    const harga      = this.getAttribute('data-harga');
                    const views      = this.getAttribute('data-views');
                    const deskripsi  = this.getAttribute('data-deskripsi');
                    const status     = this.getAttribute('data-status');
                    
                    // Parse JSON foto
                    const rawFotos   = this.getAttribute('data-fotos');
                    let fotos        = [];
                    try {
                        fotos = JSON.parse(rawFotos);
                    } catch (e) {
                        fotos = [];
                    }

                    // 2. Set Action Form & Reset Input
                    const form = document.getElementById('editProdukForm');
                    form.setAttribute('action', actionUrl);

                    document.getElementById('edit_foto_produk').value = '';
                    document.getElementById('edit-produk-file-name').textContent = 'Tambah foto baru...';
                    document.getElementById('deleted_fotos_inputs').innerHTML = ''; // Clear input foto yang dihapus

                    // 3. Populate Input Field Biasa
                    document.getElementById('edit_nama_produk').value = namaProduk || '';
                    document.getElementById('edit_harga').value = harga || '';
                    document.getElementById('edit_views').value = views || '';
                    document.getElementById('edit_deskripsi_produk').value = deskripsi || '';
                    document.getElementById('edit_status_produk').value = status || 'available';

                    const selectKategori = document.getElementById('edit_kategori_id');
                    if (selectKategori) selectKategori.value = kategoriId || '';

                    const selectUmkm = document.getElementById('edit_umkm_id');
                    if (selectUmkm) selectUmkm.value = umkmId || '';

                    // 4. Render Foto-foto Lama
                    const container = document.getElementById('edit_preview_produk_container');
                    const listDiv   = document.getElementById('edit_preview_produk_list');
                    listDiv.innerHTML = ''; 

                    if (Array.isArray(fotos) && fotos.length > 0) {
                        fotos.forEach((fotoPath) => {
                            const imgUrl = `/storage/${fotoPath}`;
                            
                            // Container foto dengan margin ekstra untuk tempat tombol 'X'
                            const photoWrapper = document.createElement('div');
                            photoWrapper.className = 'relative inline-block pt-1.5 pr-1.5 mb-2';

                            photoWrapper.innerHTML = `
                                <!-- Frame Gambar -->
                                <div class="size-20 rounded-lg overflow-hidden border border-default-200 bg-default-100">
                                    <img src="${imgUrl}" class="size-full object-cover">
                                </div>

                                <!-- Tombol Hapus Merah (Pasti Kelihatan) -->
                                <button type="button" 
                                    class="btn-delete-single-foto absolute top-0 right-0 z-20 bg-red-600 hover:bg-red-700 text-white size-5 rounded-full flex items-center justify-center text-[10px] font-bold shadow-md cursor-pointer transition-transform hover:scale-110"
                                    title="Hapus foto ini">
                                    ✕
                                </button>
                            `;

                            // Event Listener untuk Hapus Foto
                            const btnDelete = photoWrapper.querySelector('.btn-delete-single-foto');
                            btnDelete.addEventListener('click', function (e) {
                                e.preventDefault(); // Mencegah event bawaan

                                // 1. Buat input hidden penanda foto ini dihapus
                                const deletedContainer = document.getElementById('deleted_fotos_inputs');
                                const hiddenInput = document.createElement('input');
                                hiddenInput.type = 'hidden';
                                hiddenInput.name = 'delete_fotos[]';
                                hiddenInput.value = fotoPath;
                                deletedContainer.appendChild(hiddenInput);

                                // 2. Hapus elemen foto dari layar
                                photoWrapper.remove();

                                // 3. Sembunyikan container jika semua foto lama sudah habis
                                if (listDiv.children.length === 0) {
                                    container.classList.add('hidden');
                                }
                            });

                            listDiv.appendChild(photoWrapper);
                        });

                        container.classList.remove('hidden');
                    } else {
                        container.classList.add('hidden');
                    }
                });
            });

        }); // <-- Disesuaikan di sini (ditambahkan `);`)

        function confirmDeleteProduk(deleteUrl, namaProduk) {
            Swal.fire({
                title: 'Hapus Produk?',
                text: `Produk "${namaProduk}" akan dihapus secara permanen.`,
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
                    // Ambil form tersembunyi
                    const deleteForm = document.getElementById('global-delete-form');
                    if (deleteForm) {
                        deleteForm.action = deleteUrl; // Set route action
                        deleteForm.submit(); // Jalankan submit form
                    }
                }
            });
        }
    </script>
@endsection
