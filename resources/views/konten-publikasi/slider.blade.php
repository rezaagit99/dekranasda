@extends('layouts.vertical', ['title' => 'Slider Banner'])

@section('css')

@endsection

@section('content')
    @include('layouts.partials/page-title', ['title' => 'Slider Banner'] )

    <div class="card">
        <!-- Header Utama Card -->
        <div class="card-header">
            <h6 class="card-title">Daftar Slider Banner</h6>
            <button aria-controls="addSliderModal" aria-expanded="false" aria-haspopup="dialog"
                class="btn btn-sm bg-primary text-white" data-hs-overlay="#addSliderModal" type="button">
                <i class="size-4 ms-1" data-lucide="plus"></i>
                Add Slider
            </button>
            <form id="global-delete-form" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>

        <!-- Header Bar Filter & Search -->
        <div class="card-header">
            <div class="md:flex items-center md:space-y-0 space-y-4 gap-3">
                <div class="relative">
                    <input class="form-input form-input-sm ps-9" placeholder="Search for slider..." type="text"/>
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3">
                        <i class="size-3.5 flex items-center text-default-500 fill-default-100"
                           data-lucide="search"></i>
                    </div>
                </div>
                <select class="form-input form-input-sm">
                    <option selected="">select status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="flex gap-2 items-center flex-wrap">
                <button
                    class="btn btn-sm size-7.5 bg-default-100 text-default-500 hover:bg-default-150 hover:text-white"
                    type="button">
                    <i class="size-4" data-lucide="sliders-horizontal"></i>
                </button>
            </div>
        </div>

        <!-- Body Table & Pagination -->
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="min-w-full inline-block align-middle">
                    <div class="overflow-hidden">
                        @include('konten-publikasi.slider-table')
                    </div>
                </div>
            </div>

            <!-- Footer Pagination Dinamis -->
            <div class="card-footer px-6 py-4 border-t border-default-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-default-500 text-sm">
                    Showing <b>{{ $sliderList->firstItem() ?? 0 }}</b> to <b>{{ $sliderList->lastItem() ?? 0 }}</b> of <b>{{ $sliderList->total() }}</b> Results
                </p>

                @if ($sliderList->hasPages())
                    <nav aria-label="Pagination" class="flex items-center gap-1.5">
                        
                        {{-- Prev --}}
                        @if ($sliderList->onFirstPage())
                            <button class="btn btn-sm border bg-transparent border-default-200 text-default-400 opacity-50 cursor-not-allowed" type="button" disabled>
                                <i class="size-4 me-1" data-lucide="chevron-left"></i> Prev
                            </button>
                        @else
                            <a href="{{ $sliderList->previousPageUrl() }}" class="btn btn-sm border bg-transparent border-default-200 text-default-600 hover:bg-primary/10 hover:text-primary hover:border-primary/10">
                                <i class="size-4 me-1" data-lucide="chevron-left"></i> Prev
                            </a>
                        @endif

                        {{-- Numbers --}}
                        @foreach ($sliderList->getUrlRange(1, $sliderList->lastPage()) as $page => $url)
                            @if ($page == $sliderList->currentPage())
                                <span class="btn size-8 bg-primary text-white flex items-center justify-center rounded-md text-sm font-medium">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="btn size-8 bg-transparent border border-default-200 text-default-600 hover:bg-primary/10 hover:text-primary hover:border-primary/10 flex items-center justify-center rounded-md text-sm">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if ($sliderList->hasMorePages())
                            <a href="{{ $sliderList->nextPageUrl() }}" class="btn btn-sm border bg-transparent border-default-200 text-default-600 hover:bg-primary/10 hover:text-primary hover:border-primary/10">
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

    <!-- ================= MODAL ADD SLIDER ================= -->
    <div id="addSliderModal"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
        role="dialog" tabindex="-1" aria-labelledby="addSliderModal-label">
        
        <div class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center" style="max-width: 640px;">
            
            <form action="{{ route('publikasi.slider.store') }}" method="POST" enctype="multipart/form-data" 
                id="addSliderForm"
                class="card w-full flex flex-col border border-default-200 shadow-lg rounded-xl pointer-events-auto bg-white dark:bg-neutral-800">
                @csrf

                <div class="card-header flex items-center justify-between px-6 py-5 border-b border-default-200">
                    <h3 id="addSliderModal-label" class="font-semibold text-lg text-default-800 dark:text-white">
                        Tambah Slider Baru
                    </h3>
                    <button type="button" class="size-6 text-default-600 hover:text-default-900 flex items-center justify-center rounded-lg transition-all" aria-label="Close"
                        data-hs-overlay="#addSliderModal">
                        <span class="sr-only">Close</span>
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                </div>

                <div class="card-body px-6 py-5 space-y-4 max-h-[75vh] overflow-y-auto" data-simplebar>
                    
                    <!-- Judul Slider -->
                    <div class="mb-2">
                        <label for="judul" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Judul Slider</label>
                        <input type="text" id="judul" name="judul" class="form-input" placeholder="Masukkan judul promo/slider...">
                    </div>

                    <!-- Deskripsi Slider -->
                    <div class="mb-2">
                        <label for="deskripsi" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Deskripsi Slider</label>
                        <textarea id="deskripsi" name="deskripsi" class="form-input" placeholder="Masukkan ringkasan deskripsi..." rows="3"></textarea>
                    </div>

                    <!-- Link Tujuan -->
                    <div class="mb-2">
                        <label for="link" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Link Tujuan (Optional)</label>
                        <input type="url" id="link" name="link" class="form-input" placeholder="https://contoh.com/halaman-promo">
                    </div>

                    <!-- Gambar Banner -->
                    <div class="mb-2">
                        <label class="inline-block mb-1.5 text-sm text-default-800 font-medium">Gambar Banner <span class="text-danger">*</span></label>
                        <div class="relative w-full">
                            <input type="file" id="gambar" name="gambar" accept="image/png, image/jpeg, image/webp" required
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                                onchange="document.getElementById('slider-file-name').textContent = this.files[0]?.name || 'Pilih gambar banner...'; document.getElementById('slider-file-name').classList.remove('text-default-400'); document.getElementById('slider-file-name').classList.add('text-default-800');">
                            
                            <div class="flex items-center justify-between w-full border border-default-200 rounded-lg p-1.5 bg-white cursor-pointer hover:border-default-400 transition-all">
                                <span id="slider-file-name" class="text-sm text-default-400 px-2 truncate">Pilih gambar banner...</span>
                                <span class="px-3 py-1.5 rounded-md bg-default-100 text-default-700 text-xs font-medium hover:bg-default-200 shrink-0">
                                    Browse
                                </span>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-default-400">PNG, JPG, atau WEBP (Maksimal 2MB)</p>
                    </div>

                    <!-- Urutan & Status -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="urutan" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Urutan Tampil</label>
                            <input type="number" id="urutan" name="urutan" class="form-input" value="0">
                        </div>
                        <div>
                            <label for="status" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Status <span class="text-danger">*</span></label>
                            <select id="status" name="status" class="form-input" required>
                                <option value="active" selected>Active (Aktif)</option>
                                <option value="inactive">Inactive (Nonaktif)</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="card-footer px-6 py-4 border-t border-default-200 flex gap-3 justify-end items-center">
                    <button type="button" class="btn border border-default-200 text-default-700 hover:bg-default-100 px-4 py-2" data-hs-overlay="#addSliderModal">
                        Batal
                    </button>
                    <button type="submit" class="btn bg-primary text-white hover:bg-primary-600 px-5 py-2">
                        Simpan Slider
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================= MODAL EDIT SLIDER ================= -->
    <div id="editSliderModal"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
        role="dialog" tabindex="-1" aria-labelledby="editSliderModal-label">
        
        <div class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center" style="max-width: 640px;">
            
            <form action="" method="POST" enctype="multipart/form-data" 
                id="editSliderForm"
                class="card w-full flex flex-col border border-default-200 shadow-lg rounded-xl pointer-events-auto bg-white dark:bg-neutral-800">
                @csrf
                @method('PUT')

                <div class="card-header flex items-center justify-between px-6 py-5 border-b border-default-200">
                    <h3 id="editSliderModal-label" class="font-semibold text-lg text-default-800 dark:text-white">
                        Edit Data Slider
                    </h3>
                    <button type="button" class="size-6 text-default-600 hover:text-default-900 flex items-center justify-center rounded-lg transition-all" aria-label="Close"
                        data-hs-overlay="#editSliderModal">
                        <span class="sr-only">Close</span>
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                </div>

                <div class="card-body px-6 py-5 space-y-4 max-h-[75vh] overflow-y-auto" data-simplebar>
                    
                    <!-- Judul Slider -->
                    <div class="mb-2">
                        <label for="edit_judul" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Judul Slider</label>
                        <input type="text" id="edit_judul" name="judul" class="form-input" placeholder="Masukkan judul promo/slider...">
                    </div>

                    <!-- Deskripsi Slider -->
                    <div class="mb-2">
                        <label for="edit_deskripsi" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Deskripsi Slider</label>
                        <textarea id="edit_deskripsi" name="deskripsi" class="form-input" placeholder="Masukkan ringkasan deskripsi..." rows="3"></textarea>
                    </div>

                    <!-- Link Tujuan -->
                    <div class="mb-2">
                        <label for="edit_link" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Link Tujuan</label>
                        <input type="url" id="edit_link" name="link" class="form-input" placeholder="https://contoh.com/halaman-promo">
                    </div>

                    <!-- Gambar Banner (Preview & Upload) -->
                    <div class="mb-2">
                        <label class="inline-block mb-1.5 text-sm text-default-800 font-medium">Ganti Banner (Opsional)</label>

                        <!-- Preview Foto Lama -->
                        <div id="edit_preview_container" class="mb-3 hidden">
                            <span class="block text-xs text-default-500 mb-1">Banner Saat Ini:</span>
                            <img id="edit_preview_img" src="" alt="Preview Banner" class="h-28 w-auto object-cover rounded-lg border border-default-200">
                        </div>

                        <div class="relative w-full">
                            <input type="file" id="edit_gambar" name="gambar" accept="image/png, image/jpeg, image/webp" 
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                                onchange="document.getElementById('edit-slider-file-name').textContent = this.files[0]?.name || 'Pilih gambar baru...'; document.getElementById('edit-slider-file-name').classList.remove('text-default-400'); document.getElementById('edit-slider-file-name').classList.add('text-default-800');">
                            
                            <div class="flex items-center justify-between w-full border border-default-200 rounded-lg p-1.5 bg-white cursor-pointer hover:border-default-400 transition-all">
                                <span id="edit-slider-file-name" class="text-sm text-default-400 px-2 truncate">Pilih gambar baru...</span>
                                <span class="px-3 py-1.5 rounded-md bg-default-100 text-default-700 text-xs font-medium hover:bg-default-200 shrink-0">
                                    Browse
                                </span>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-default-400">Kosongkan jika tidak ingin mengganti banner. (Maksimal 2MB)</p>
                    </div>

                    <!-- Urutan & Status -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="edit_urutan" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Urutan Tampil</label>
                            <input type="number" id="edit_urutan" name="urutan" class="form-input">
                        </div>
                        <div>
                            <label for="edit_status" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Status <span class="text-danger">*</span></label>
                            <select id="edit_status" name="status" class="form-input" required>
                                <option value="active">Active (Aktif)</option>
                                <option value="inactive">Inactive (Nonaktif)</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="card-footer px-6 py-4 border-t border-default-200 flex gap-3 justify-end items-center">
                    <button type="button" class="btn border border-default-200 text-default-700 hover:bg-default-100 px-4 py-2" data-hs-overlay="#editSliderModal">
                        Batal
                    </button>
                    <button type="submit" class="btn bg-primary text-white hover:bg-primary-600 px-5 py-2">
                        Perbarui Slider
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // Handler Modal Edit Slider
            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function () {
                    const form = document.getElementById('editSliderForm');
                    if (!form) return;

                    // Set Form Action Route
                    form.action = this.dataset.action;

                    // Set Input Values
                    document.getElementById('edit_judul').value = this.dataset.judul || '';
                    document.getElementById('edit_deskripsi').value = this.dataset.deskripsi || '';
                    document.getElementById('edit_link').value = this.dataset.link || '';
                    document.getElementById('edit_urutan').value = this.dataset.urutan || 0;
                    document.getElementById('edit_status').value = this.dataset.status || 'active';

                    // Reset File Input Display Text
                    const fileNameDisplay = document.getElementById('edit-slider-file-name');
                    if (fileNameDisplay) {
                        fileNameDisplay.textContent = 'Pilih gambar baru...';
                        fileNameDisplay.classList.add('text-default-400');
                        fileNameDisplay.classList.remove('text-default-800');
                    }

                    // Set Image Preview
                    const previewContainer = document.getElementById('edit_preview_container');
                    const previewImg = document.getElementById('edit_preview_img');

                    if (this.dataset.preview && previewContainer && previewImg) {
                        previewImg.src = this.dataset.preview;
                        previewContainer.classList.remove('hidden');
                    } else if (previewContainer) {
                        previewContainer.classList.add('hidden');
                    }
                });
            });

        });

        // SweetAlert Confirm Delete Slider
        function confirmDeleteSlider(deleteUrl, sliderTitle) {
            Swal.fire({
                title: 'Hapus Slider?',
                text: sliderTitle ? `Slider "${sliderTitle}" akan dihapus permanen.` : 'Slider ini akan dihapus permanen.',
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