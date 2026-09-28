@extends('layouts.vertical', ['title' => 'Kategori'])

@section('css')

@endsection

@section('content')
    @include('layouts.partials/page-title', ['title' => 'Kategori'] )

    <div class="card">
        <div class="card-header">
            <h6 class="card-title">Daftar Kategori</h6>
            {{-- <button class="btn btn-sm bg-primary text-white">
                <i class="size-4 me-1" data-lucide="plus"></i>Add user
            </button> --}}
            <button aria-controls="addkategoriModal" aria-expanded="false" aria-haspopup="dialog"
                class="btn btn-sm bg-primary text-white" data-hs-overlay="#addkategoriModal" type="button">
                <i class="size-4 ms-1" data-lucide="plus"></i>
                Add Kategori
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
                        @include('umkm.kategori-table')
                    </div>
                </div>
            </div>
            <div class="card-footer px-6 py-4 border-t border-default-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <!-- Teks Showing Dinamis -->
                <p class="text-default-500 text-sm">
                    Showing <b>{{ $kategoriList->firstItem() ?? 0 }}</b> to <b>{{ $kategoriList->lastItem() ?? 0 }}</b> of <b>{{ $kategoriList->total() }}</b> Results
                </p>

                <!-- Navigasi Tombol Pagination Dinamis -->
                @if ($kategoriList->hasPages())
                    <nav aria-label="Pagination" class="flex items-center gap-1.5">
                        
                        {{-- Tombol Previous --}}
                        @if ($kategoriList->onFirstPage())
                            <button class="btn btn-sm border bg-transparent border-default-200 text-default-400 opacity-50 cursor-not-allowed" type="button" disabled>
                                <i class="size-4 me-1" data-lucide="chevron-left"></i> Prev
                            </button>
                        @else
                            <a href="{{ $kategoriList->previousPageUrl() }}" class="btn btn-sm border bg-transparent border-default-200 text-default-600 hover:bg-primary/10 hover:text-primary hover:border-primary/10">
                                <i class="size-4 me-1" data-lucide="chevron-left"></i> Prev
                            </a>
                        @endif

                        {{-- Angka Halaman --}}
                        @foreach ($kategoriList->getUrlRange(1, $kategoriList->lastPage()) as $page => $url)
                            @if ($page == $kategoriList->currentPage())
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
                        @if ($kategoriList->hasMorePages())
                            <a href="{{ $kategoriList->nextPageUrl() }}" class="btn btn-sm border bg-transparent border-default-200 text-default-600 hover:bg-primary/10 hover:text-primary hover:border-primary/10">
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

    {{-- <div id="addkategoriModal"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
        role="dialog" tabindex="-1" aria-labelledby="addkategoriModal-label">
        
        <!-- Modal Container (Max Width diperlebar ke 640px agar area penulisan isi berita lebih leluasa) -->
        <div class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center" style="max-width: 640px;">
            
            <!-- Form Tambah Kategori -->
            <form action="{{ route('umkm.kategori.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="nama_kategori" class="block text-sm font-medium text-default-700 mb-2">Nama Kategori</label>
                    <input type="text" name="nama_kategori" id="nama_kategori" required class="form-input w-full rounded-md border-default-200" placeholder="Contoh: Batik & Kain">
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-medium text-default-700 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="2" class="form-input w-full rounded-md border-default-200" placeholder="Keterangan singkat..."></textarea>
                </div>

                <button type="submit" class="btn bg-primary text-white w-full">
                    <i data-lucide="plus" class="size-4 inline mr-1"></i> Simpan Kategori
                </button>
            </form>
        </div>
    </div> --}}

    <div id="addkategoriModal"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
        role="dialog" tabindex="-1" aria-labelledby="addkategoriModal-label">
        
        <!-- Modal Container (Max Width diperlebar ke 640px agar area penulisan isi berita lebih leluasa) -->
        <div class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center" style="max-width: 640px;">
            
            <!-- Form Tambah Kategori -->
            <form action="{{ route('umkm.kategori.store') }}" method="POST" enctype="multipart/form-data" 
                id="addKategoriForm"
                class="card w-full flex flex-col border border-default-200 shadow-lg rounded-xl pointer-events-auto bg-white dark:bg-neutral-800">
                @csrf

                <!-- Modal Header -->
                <div class="card-header flex items-center justify-between px-6 py-5 border-b border-default-200">
                    <h3 id="addkategoriModal-label" class="font-semibold text-lg text-default-800 dark:text-white">
                        Tambah Kategori Baru
                    </h3>
                    <button type="button" class="size-6 text-default-600 hover:text-default-900 flex items-center justify-center rounded-lg transition-all" aria-label="Close"
                        data-hs-overlay="#addkategoriModal">
                        <span class="sr-only">Close</span>
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="card-body px-6 py-5 space-y-4 max-h-[75vh] overflow-y-auto" data-simplebar> 
                    <div class="mb-4">
                        <label for="nama_kategori" class="block text-sm font-medium text-default-700 mb-2">Nama Kategori</label>
                        <input type="text" name="nama_kategori" id="nama_kategori" required class="form-input w-full rounded-md border-default-200" placeholder="Contoh: Batik & Kain">
                    </div>
                    <div class="mb-4">
                        <label for="deskripsi" class="block text-sm font-medium text-default-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="2" class="form-input w-full rounded-md border-default-200" placeholder="Keterangan singkat..."></textarea>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="card-footer px-6 py-4 border-t border-default-200 flex gap-3 justify-end items-center">
                    <button type="button" class="btn border border-default-200 text-default-700 hover:bg-default-100 px-4 py-2" data-hs-overlay="#addkategoriModal">
                        Batal
                    </button>
                    <button type="submit" class="btn bg-primary text-white hover:bg-primary-600 px-5 py-2">
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Berita -->
    <div id="editKategoriModal"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
        role="dialog" tabindex="-1" aria-labelledby="editKategoriModal-label">
        
        <div class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center" style="max-width: 640px;">
            
            <!-- Tag Form Diberi ID editUmkmForm -->
            <form action="" method="POST" id="editKategoriForm"
                class="card w-full flex flex-col border border-default-200 shadow-lg rounded-xl pointer-events-auto bg-white dark:bg-neutral-800">
                @csrf
                @method('PUT')

                <!-- Modal Header -->
                <div class="card-header flex items-center justify-between px-6 py-5 border-b border-default-200">
                    <h3 id="editKategoriModal-label" class="font-semibold text-lg text-default-800 dark:text-white">
                        Edit Kategori
                    </h3>
                    <button type="button" class="size-6 text-default-600 hover:text-default-900 flex items-center justify-center rounded-lg transition-all" aria-label="Close"
                        data-hs-overlay="#editKategoriModal">
                        <span class="sr-only">Close</span>
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="card-body px-6 py-5 space-y-4 max-h-[75vh] overflow-y-auto" data-simplebar>
                    
                    <div class="mb-4">
                        <label for="edit_nama_kategori" class="block text-sm font-medium text-default-700 mb-2">Nama Kategori</label>
                        <input type="text" name="nama_kategori" id="edit_nama_kategori" required class="form-input w-full rounded-md border-default-200" placeholder="Contoh: Batik & Kain">
                    </div>

                    <div class="mb-4">
                        <label for="edit_deskripsi" class="block text-sm font-medium text-default-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" id="edit_deskripsi" rows="2" class="form-input w-full rounded-md border-default-200" placeholder="Keterangan singkat..."></textarea>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="card-footer px-6 py-4 border-t border-default-200 flex gap-3 justify-end items-center">
                    <button type="button" class="btn border border-default-200 text-default-700 hover:bg-default-100 px-4 py-2" data-hs-overlay="#editKategoriModal">
                        Batal
                    </button>
                    <button type="submit" class="btn bg-primary text-white hover:bg-primary-600 px-5 py-2">
                        Update Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editButtons = document.querySelectorAll('.btn-edit-kategori');
            const editForm = document.getElementById('editKategoriForm');
            const inputNama = document.getElementById('edit_nama_kategori');
            const inputDeskripsi = document.getElementById('edit_deskripsi');

            editButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // Ambil data dari atribut tombol
                    const actionUrl = this.getAttribute('data-action');
                    const namaKategori = this.getAttribute('data-nama_kategori');
                    const deskripsi = this.getAttribute('data-deskripsi');

                    // Set action URL pada form modal edit
                    editForm.setAttribute('action', actionUrl);

                    // Isikan nilai ke input form
                    inputNama.value = namaKategori || '';
                    inputDeskripsi.value = deskripsi || '';
                });
            });
        });

        function confirmDeleteKategori(deleteUrl, namaKategori) {
            Swal.fire({
                title: 'Hapus Kategori?',
                text: `Kategori "${namaKategori}" akan dihapus secara permanen.`,
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
