@extends('layouts.vertical', ['title' => 'Kegiatan'])

@section('css')

@endsection

@section('content')
    @include('layouts.partials/page-title', ['title' => 'Kegiatan'] )

    <div class="card">
        <div class="card-header">
            <h6 class="card-title">Daftar Kegiatan</h6>
            {{-- <button class="btn btn-sm bg-primary text-white">
                <i class="size-4 me-1" data-lucide="plus"></i>Add user
            </button> --}}
            <button aria-controls="addKegiatanModal" aria-expanded="false" aria-haspopup="dialog"
                class="btn btn-sm bg-primary text-white" data-hs-overlay="#addKegiatanModal" type="button">
                <i class="size-4 ms-1" data-lucide="plus"></i>
                Add Kegiatan
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
                        @include('konten-publikasi.kalender-kegiatan-table')
                    </div>
                </div>
            </div>
            <div class="card-footer px-6 py-4 border-t border-default-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <!-- Teks Showing Dinamis -->
                <p class="text-default-500 text-sm">
                    Showing <b>{{ $kegiatanList->firstItem() ?? 0 }}</b> to <b>{{ $kegiatanList->lastItem() ?? 0 }}</b> of <b>{{ $kegiatanList->total() }}</b> Results
                </p>

                <!-- Navigasi Tombol Pagination Dinamis -->
                @if ($kegiatanList->hasPages())
                    <nav aria-label="Pagination" class="flex items-center gap-1.5">
                        
                        {{-- Tombol Previous --}}
                        @if ($kegiatanList->onFirstPage())
                            <button class="btn btn-sm border bg-transparent border-default-200 text-default-400 opacity-50 cursor-not-allowed" type="button" disabled>
                                <i class="size-4 me-1" data-lucide="chevron-left"></i> Prev
                            </button>
                        @else
                            <a href="{{ $kegiatanList->previousPageUrl() }}" class="btn btn-sm border bg-transparent border-default-200 text-default-600 hover:bg-primary/10 hover:text-primary hover:border-primary/10">
                                <i class="size-4 me-1" data-lucide="chevron-left"></i> Prev
                            </a>
                        @endif

                        {{-- Angka Halaman --}}
                        @foreach ($kegiatanList->getUrlRange(1, $kegiatanList->lastPage()) as $page => $url)
                            @if ($page == $kegiatanList->currentPage())
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
                        @if ($kegiatanList->hasMorePages())
                            <a href="{{ $kegiatanList->nextPageUrl() }}" class="btn btn-sm border bg-transparent border-default-200 text-default-600 hover:bg-primary/10 hover:text-primary hover:border-primary/10">
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

    <div id="addKegiatanModal"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
        role="dialog" tabindex="-1" aria-labelledby="addKegiatanModal-label">
        
        <!-- Modal Container (Max Width diperlebar ke 640px agar area penulisan isi kegiatan lebih leluasa) -->
        <div class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center" style="max-width: 640px;">
    
            <form action="{{ route('publikasi.kalender.store') }}" method="POST" enctype="multipart/form-data" 
                id="addKegiatanForm"
                class="card w-full flex flex-col border border-default-200 shadow-lg rounded-xl pointer-events-auto bg-white dark:bg-neutral-800">
                @csrf

                <!-- Modal Header -->
                <div class="card-header flex items-center justify-between px-6 py-5 border-b border-default-200">
                    <h3 id="addKegiatanModal-label" class="font-semibold text-lg text-default-800 dark:text-white">
                        Tambah Kegiatan Baru
                    </h3>
                    <button type="button" class="size-6 text-default-600 hover:text-default-900 flex items-center justify-center rounded-lg transition-all" aria-label="Close"
                        data-hs-overlay="#addKegiatanModal">
                        <span class="sr-only">Close</span>
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="card-body px-6 py-5 space-y-4 max-h-[75vh] overflow-y-auto" data-simplebar>
                    
                    <!-- Nama Kegiatan -->
                    <div class="mb-2">
                        <label for="nama_kegiatan" class="block text-sm font-medium text-default-800 mb-1">Nama Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" id="nama_kegiatan" name="nama_kegiatan" class="form-input w-full" placeholder="Contoh: Rapat Koordinasi UMKM" required>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-2">
                        <label for="deskripsi" class="block text-sm font-medium text-default-800 mb-1">Deskripsi Ringkas</label>
                        <textarea id="deskripsi" name="deskripsi" rows="3" class="form-input w-full" placeholder="Jelaskan secara singkat agenda kegiatan..."></textarea>
                    </div>

                    <!-- Grid Tanggal -->
                    <div class="grid grid-cols-2 gap-3 mb-2">
                        <div>
                            <label for="tanggal_mulai" class="block text-sm font-medium text-default-800 mb-1">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="form-input w-full" required>
                        </div>
                        <div>
                            <label for="tanggal_selesai" class="block text-sm font-medium text-default-800 mb-1">Tanggal Selesai</label>
                            <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="form-input w-full">
                        </div>
                    </div>

                    <!-- Grid Waktu -->
                    <div class="grid grid-cols-2 gap-3 mb-2">
                        <div>
                            <label for="waktu_mulai" class="block text-sm font-medium text-default-800 mb-1">Waktu Mulai</label>
                            <input type="time" id="waktu_mulai" name="waktu_mulai" class="form-input w-full">
                        </div>
                        <div>
                            <label for="waktu_selesai" class="block text-sm font-medium text-default-800 mb-1">Waktu Selesai</label>
                            <input type="time" id="waktu_selesai" name="waktu_selesai" class="form-input w-full">
                        </div>
                    </div>

                    <!-- Lokasi & Penyelenggara -->
                    <div class="grid grid-cols-2 gap-3 mb-2">
                        <div>
                            <label for="lokasi" class="block text-sm font-medium text-default-800 mb-1">Lokasi</label>
                            <input type="text" id="lokasi" name="lokasi" class="form-input w-full" placeholder="Contoh: Gedung Serbaguna">
                        </div>
                        <div>
                            <label for="penyelenggara" class="block text-sm font-medium text-default-800 mb-1">Penyelenggara</label>
                            <input type="text" id="penyelenggara" name="penyelenggara" class="form-input w-full" placeholder="Contoh: Diskominfo / Diskopumdag">
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-2">
                        <label for="status" class="block text-sm font-medium text-default-800 mb-1">Status Kegiatan <span class="text-danger">*</span></label>
                        <select id="status" name="status" class="form-select w-full" required>
                            <option value="mendatang">Mendatang</option>
                            <option value="berlangsung">Berlangsung</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="card-footer px-6 py-4 border-t border-default-200 flex gap-3 justify-end items-center">
                    <button type="button" class="btn border border-default-200 text-default-700 hover:bg-default-100 px-4 py-2" data-hs-overlay="#addKegiatanModal">
                        Batal
                    </button>
                    <button type="submit" class="btn bg-primary text-white hover:bg-primary-600 px-5 py-2">
                        Simpan Kegiatan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Kegiatan -->
    <div id="editKegiatanModal"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
        role="dialog" tabindex="-1" aria-labelledby="editKegiatanModal-label">
        
        <!-- Modal Container dengan Max Width 640px -->
        <div class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center" style="max-width: 640px;">
            
            <form id="editKegiatanForm" method="POST" enctype="multipart/form-data" 
                class="card w-full flex flex-col border border-default-200 shadow-lg rounded-xl pointer-events-auto bg-white dark:bg-neutral-800">
                @csrf
                @method('PUT')

                <!-- Header -->
                <div class="card-header flex items-center justify-between px-6 py-5 border-b border-default-200">
                    <h3 id="editKegiatanModal-label" class="font-semibold text-lg text-default-800 dark:text-white">
                        Edit Kegiatan
                    </h3>
                    <button type="button" class="size-6 text-default-600 hover:text-default-900 flex items-center justify-center rounded-lg transition-all" aria-label="Close" data-hs-overlay="#editKegiatanModal">
                        <span class="sr-only">Close</span>
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                </div>

                <!-- Body -->
                <div class="card-body px-6 py-5 space-y-4 max-h-[75vh] overflow-y-auto" data-simplebar>
                    
                    <!-- ID Kegiatan Hidden -->
                    <input type="hidden" id="edit_kegiatan_id" name="kegiatan_id">

                    <!-- Nama Kegiatan -->
                    <div class="mb-2">
                        <label for="edit_nama_kegiatan" class="block text-sm font-medium text-default-800 mb-1">Nama Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" id="edit_nama_kegiatan" name="nama_kegiatan" class="form-input w-full" placeholder="Contoh: Rapat Koordinasi UMKM" required>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-2">
                        <label for="edit_deskripsi" class="block text-sm font-medium text-default-800 mb-1">Deskripsi Ringkas</label>
                        <textarea id="edit_deskripsi" name="deskripsi" rows="3" class="form-input w-full" placeholder="Jelaskan secara singkat agenda kegiatan..."></textarea>
                    </div>

                    <!-- Grid Tanggal -->
                    <div class="grid grid-cols-2 gap-3 mb-2">
                        <div>
                            <label for="edit_tanggal_mulai" class="block text-sm font-medium text-default-800 mb-1">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" id="edit_tanggal_mulai" name="tanggal_mulai" class="form-input w-full" required>
                        </div>
                        <div>
                            <label for="edit_tanggal_selesai" class="block text-sm font-medium text-default-800 mb-1">Tanggal Selesai</label>
                            <input type="date" id="edit_tanggal_selesai" name="tanggal_selesai" class="form-input w-full">
                        </div>
                    </div>

                    <!-- Grid Waktu -->
                    <div class="grid grid-cols-2 gap-3 mb-2">
                        <div>
                            <label for="edit_waktu_mulai" class="block text-sm font-medium text-default-800 mb-1">Waktu Mulai</label>
                            <input type="time" id="edit_waktu_mulai" name="waktu_mulai" class="form-input w-full">
                        </div>
                        <div>
                            <label for="edit_waktu_selesai" class="block text-sm font-medium text-default-800 mb-1">Waktu Selesai</label>
                            <input type="time" id="edit_waktu_selesai" name="waktu_selesai" class="form-input w-full">
                        </div>
                    </div>

                    <!-- Lokasi & Penyelenggara -->
                    <div class="grid grid-cols-2 gap-3 mb-2">
                        <div>
                            <label for="edit_lokasi" class="block text-sm font-medium text-default-800 mb-1">Lokasi</label>
                            <input type="text" id="edit_lokasi" name="lokasi" class="form-input w-full" placeholder="Contoh: Gedung Serbaguna">
                        </div>
                        <div>
                            <label for="edit_penyelenggara" class="block text-sm font-medium text-default-800 mb-1">Penyelenggara</label>
                            <input type="text" id="edit_penyelenggara" name="penyelenggara" class="form-input w-full" placeholder="Contoh: Diskominfo / Diskopumdag">
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-2">
                        <label for="edit_status" class="block text-sm font-medium text-default-800 mb-1">Status Kegiatan <span class="text-danger">*</span></label>
                        <select id="edit_status" name="status" class="form-select w-full" required>
                            <option value="mendatang">Mendatang</option>
                            <option value="berlangsung">Berlangsung</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>

                </div>

                <!-- Footer -->
                <div class="card-footer px-6 py-4 border-t border-default-200 flex gap-3 justify-end items-center">
                    <button type="button" class="btn border border-default-200 text-default-700 hover:bg-default-100 px-4 py-2" data-hs-overlay="#editKegiatanModal">
                        Batal
                    </button>
                    <button type="submit" class="btn bg-primary text-white hover:bg-primary-600 px-5 py-2">
                        Perbarui Kegiatan
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // 1. Handler Autofill Data untuk Modal Edit Kegiatan
            document.querySelectorAll('.btn-edit-kegiatan').forEach(button => {
                button.addEventListener('click', function () {
                    const form = document.getElementById('editKegiatanForm');
                    if (!form) return;

                    // Set URL Action secara dinamis pada Form Edit
                    form.action = this.dataset.action;

                    // Field Teks, Date, dan Time
                    const fields = [
                        'nama_kegiatan', 
                        'deskripsi', 
                        'tanggal_mulai', 
                        'tanggal_selesai', 
                        'waktu_mulai', 
                        'waktu_selesai', 
                        'lokasi', 
                        'penyelenggara'
                    ];

                    fields.forEach(field => {
                        if (form.elements[field]) {
                            form.elements[field].value = this.dataset[field] || '';
                        }
                    });

                    // Field Select Status
                    if (form.elements['status']) {
                        const statusVal = String(this.dataset.status || '').toLowerCase().trim();
                        form.elements['status'].value = statusVal;
                    }
                });
            });

            // 2. Reset Form Tambah saat Modal Ditutup
            const addModal = document.getElementById('addKegiatanModal');
            if (addModal) {
                addModal.addEventListener('hidden.hs.overlay', () => {
                    const addForm = document.getElementById('addKegiatanForm');
                    if (addForm) addForm.reset();
                });
            }

        });

        // 3. SweetAlert Confirm Delete untuk Kegiatan
        function confirmDeleteKegiatan(deleteUrl, namaKegiatan) {
            Swal.fire({
                title: 'Hapus Kegiatan?',
                text: `Kegiatan "${namaKegiatan}" akan dihapus secara permanen.`,
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
                    if (deleteForm) {
                        deleteForm.action = deleteUrl;
                        deleteForm.submit();
                    }
                }
            });
        }
    </script>
@endsection
