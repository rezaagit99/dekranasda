@extends('layouts.vertical', ['title' => 'Video'])

@section('css')

@endsection

@section('content')
    @include('layouts.partials/page-title', ['title' => 'Video'] )

    <div class="card">
        <div class="card-header">
            <h6 class="card-title">Daftar Video</h6>
            {{-- <button class="btn btn-sm bg-primary text-white">
                <i class="size-4 me-1" data-lucide="plus"></i>Add user
            </button> --}}
            <button aria-controls="addVideoModal" aria-expanded="false" aria-haspopup="dialog"
                class="btn btn-sm bg-primary text-white" data-hs-overlay="#addVideoModal" type="button">
                <i class="size-4 ms-1" data-lucide="plus"></i>
                Add Video
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
                        @include('konten-publikasi.video-table')
                    </div>
                </div>
            </div>
            <div class="card-footer px-6 py-4 border-t border-default-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <!-- Teks Showing Dinamis -->
                <p class="text-default-500 text-sm">
                    Showing <b>{{ $videoList->firstItem() ?? 0 }}</b> to <b>{{ $videoList->lastItem() ?? 0 }}</b> of <b>{{ $videoList->total() }}</b> Results
                </p>

                <!-- Navigasi Tombol Pagination Dinamis -->
                @if ($videoList->hasPages())
                    <nav aria-label="Pagination" class="flex items-center gap-1.5">
                        
                        {{-- Tombol Previous --}}
                        @if ($videoList->onFirstPage())
                            <button class="btn btn-sm border bg-transparent border-default-200 text-default-400 opacity-50 cursor-not-allowed" type="button" disabled>
                                <i class="size-4 me-1" data-lucide="chevron-left"></i> Prev
                            </button>
                        @else
                            <a href="{{ $videoList->previousPageUrl() }}" class="btn btn-sm border bg-transparent border-default-200 text-default-600 hover:bg-primary/10 hover:text-primary hover:border-primary/10">
                                <i class="size-4 me-1" data-lucide="chevron-left"></i> Prev
                            </a>
                        @endif

                        {{-- Angka Halaman --}}
                        @foreach ($videoList->getUrlRange(1, $videoList->lastPage()) as $page => $url)
                            @if ($page == $videoList->currentPage())
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
                        @if ($videoList->hasMorePages())
                            <a href="{{ $videoList->nextPageUrl() }}" class="btn btn-sm border bg-transparent border-default-200 text-default-600 hover:bg-primary/10 hover:text-primary hover:border-primary/10">
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

    <div id="addVideoModal"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
        role="dialog" tabindex="-1" aria-labelledby="addVideoModal-label">
        
        <!-- Modal Container (Max Width diperlebar ke 640px agar area penulisan isi berita lebih leluasa) -->
        <div class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center" style="max-width: 640px;">
            
            <!-- Form Tambah Berita -->
            <form action="{{ route('publikasi.video.store') }}" method="POST" id="addVideoForm"
                class="card w-full flex flex-col border border-default-200 shadow-lg rounded-xl pointer-events-auto bg-white dark:bg-neutral-800">
                @csrf

                <!-- Modal Header -->
                <div class="card-header flex items-center justify-between px-6 py-5 border-b border-default-200">
                    <h3 id="addVideoModal-label" class="font-semibold text-lg text-default-800 dark:text-white">
                        Tambah Video Baru
                    </h3>
                    <button type="button" class="size-6 text-default-600 hover:text-default-900 flex items-center justify-center rounded-lg transition-all" aria-label="Close"
                        data-hs-overlay="#addVideoModal">
                        <span class="sr-only">Close</span>
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="card-body px-6 py-5 space-y-4 max-h-[75vh] overflow-y-auto" data-simplebar>
                    
                    <!-- Judul Video -->
                    <div class="mb-2">
                        <label for="judul" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Judul Video <span class="text-danger">*</span></label>
                        <input type="text" id="judul" name="judul" class="form-input" placeholder="Masukkan judul video..." required>
                    </div>

                    <!-- URL YouTube -->
                    <div class="mb-2">
                        <label for="url_youtube" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Link / URL YouTube <span class="text-danger">*</span></label>
                        <div class="relative">
                            <input type="url" id="url_youtube" name="url_youtube" class="form-input ps-10" placeholder="https://www.youtube.com/watch?v=..." required>
                            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3 text-default-400">
                                <i data-lucide="youtube" class="size-4"></i>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-default-400">Contoh: https://www.youtube.com/watch?v=dQw4w9WgXcQ atau https://youtu.be/dQw4w9WgXcQ</p>
                    </div>

                    <!-- Deskripsi Video -->
                    <div class="mb-2">
                        <label for="deskripsi" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Deskripsi Video</label>
                        <textarea id="deskripsi" name="deskripsi" class="form-input" placeholder="Masukkan deskripsi ringkas video..." rows="3"></textarea>
                    </div>

                    <!-- Status Publikasi -->
                    <div class="mb-2">
                        <label for="status" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Status <span class="text-danger">*</span></label>
                        <select id="status" name="status" class="form-input" required>
                            <option value="published" selected>Published (Terbit)</option>
                            <option value="archived">Archived (Arsip)</option>
                        </select>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="card-footer px-6 py-4 border-t border-default-200 flex gap-3 justify-end items-center">
                    <button type="button" class="btn border border-default-200 text-default-700 hover:bg-default-100 px-4 py-2" data-hs-overlay="#addVideoModal">
                        Batal
                    </button>
                    <button type="submit" class="btn bg-primary text-white hover:bg-primary-600 px-5 py-2">
                        Simpan Video
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Berita -->
    <div id="editVideoModal"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
        role="dialog" tabindex="-1" aria-labelledby="editVideoModal-label">
        
        <!-- Modal Container dengan Max Width 640px -->
        <div class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center" style="max-width: 640px;">
            
            <form action="" method="POST" id="editVideoForm"
                class="card w-full flex flex-col border border-default-200 shadow-lg rounded-xl pointer-events-auto bg-white dark:bg-neutral-800">
                @csrf
                @method('PUT')

                <!-- Modal Header -->
                <div class="card-header flex items-center justify-between px-6 py-5 border-b border-default-200">
                    <h3 id="editVideoModal-label" class="font-semibold text-lg text-default-800 dark:text-white">
                        Edit Data Video
                    </h3>
                    <button type="button" class="size-6 text-default-600 hover:text-default-900 flex items-center justify-center rounded-lg transition-all" aria-label="Close"
                        data-hs-overlay="#editVideoModal">
                        <span class="sr-only">Close</span>
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="card-body px-6 py-5 space-y-4 max-h-[75vh] overflow-y-auto" data-simplebar>
                    
                    <!-- Judul Video -->
                    <div class="mb-2">
                        <label for="edit_judul" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Judul Video <span class="text-danger">*</span></label>
                        <input type="text" id="edit_judul" name="judul" class="form-input" placeholder="Masukkan judul video..." required>
                    </div>

                    <!-- URL YouTube -->
                    <div class="mb-2">
                        <label for="edit_url_youtube" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Link / URL YouTube <span class="text-danger">*</span></label>
                        <div class="relative">
                            <input type="url" id="edit_url_youtube" name="url_youtube" class="form-input ps-10" placeholder="https://www.youtube.com/watch?v=..." required>
                            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3 text-default-400">
                                <i data-lucide="youtube" class="size-4"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi Video -->
                    <div class="mb-2">
                        <label for="edit_deskripsi" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Deskripsi Video</label>
                        <textarea id="edit_deskripsi" name="deskripsi" class="form-input" placeholder="Masukkan deskripsi video..." rows="3"></textarea>
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
                    <button type="button" class="btn border border-default-200 text-default-700 hover:bg-default-100 px-4 py-2" data-hs-overlay="#editVideoModal">
                        Batal
                    </button>
                    <button type="submit" class="btn bg-primary text-white hover:bg-primary-600 px-5 py-2">
                        Perbarui Video
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // Listener Tombol Edit Video
            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function () {
                    const form = document.getElementById('editVideoForm');
                    if (!form) return;

                    // Set Form Action Route Update
                    form.action = this.dataset.action;

                    // Pass data attribute ke input modal
                    document.getElementById('edit_judul').value = this.dataset.judul || '';
                    document.getElementById('edit_url_youtube').value = this.dataset.url || '';
                    document.getElementById('edit_deskripsi').value = this.dataset.deskripsi || '';
                    document.getElementById('edit_status').value = this.dataset.status || 'published';
                });
            });

        }); // <-- Disesuaikan di sini (ditambahkan `);`)

        function confirmDeleteVideo(deleteUrl, judulVideo) {
            Swal.fire({
                title: 'Hapus Video?',
                text: `Video "${judulVideo}" akan dihapus secara permanen.`,
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
