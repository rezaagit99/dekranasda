@extends('layouts.vertical', ['title' => 'Berita'])

@section('css')

@endsection

@section('content')
    @include('layouts.partials/page-title', ['title' => 'Berita'] )

    <div class="card">
        <div class="card-header">
            <h6 class="card-title">Daftar Berita</h6>
            {{-- <button class="btn btn-sm bg-primary text-white">
                <i class="size-4 me-1" data-lucide="plus"></i>Add user
            </button> --}}
            <button aria-controls="addBeritaModal" aria-expanded="false" aria-haspopup="dialog"
                class="btn btn-sm bg-primary text-white" data-hs-overlay="#addBeritaModal" type="button">
                <i class="size-4 ms-1" data-lucide="plus"></i>
                Add Berita
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
                        @include('konten-publikasi.berita-table')
                    </div>
                </div>
            </div>
            <div class="card-footer px-6 py-4 border-t border-default-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <!-- Teks Showing Dinamis -->
                <p class="text-default-500 text-sm">
                    Showing <b>{{ $beritaList->firstItem() ?? 0 }}</b> to <b>{{ $beritaList->lastItem() ?? 0 }}</b> of <b>{{ $beritaList->total() }}</b> Results
                </p>

                <!-- Navigasi Tombol Pagination Dinamis -->
                @if ($beritaList->hasPages())
                    <nav aria-label="Pagination" class="flex items-center gap-1.5">
                        
                        {{-- Tombol Previous --}}
                        @if ($beritaList->onFirstPage())
                            <button class="btn btn-sm border bg-transparent border-default-200 text-default-400 opacity-50 cursor-not-allowed" type="button" disabled>
                                <i class="size-4 me-1" data-lucide="chevron-left"></i> Prev
                            </button>
                        @else
                            <a href="{{ $beritaList->previousPageUrl() }}" class="btn btn-sm border bg-transparent border-default-200 text-default-600 hover:bg-primary/10 hover:text-primary hover:border-primary/10">
                                <i class="size-4 me-1" data-lucide="chevron-left"></i> Prev
                            </a>
                        @endif

                        {{-- Angka Halaman --}}
                        @foreach ($beritaList->getUrlRange(1, $beritaList->lastPage()) as $page => $url)
                            @if ($page == $beritaList->currentPage())
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
                        @if ($beritaList->hasMorePages())
                            <a href="{{ $beritaList->nextPageUrl() }}" class="btn btn-sm border bg-transparent border-default-200 text-default-600 hover:bg-primary/10 hover:text-primary hover:border-primary/10">
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

    <div id="addBeritaModal"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
        role="dialog" tabindex="-1" aria-labelledby="addBeritaModal-label">
        
        <!-- Modal Container (Max Width diperlebar ke 640px agar area penulisan isi berita lebih leluasa) -->
        <div class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center" style="max-width: 640px;">
            
            <!-- Form Tambah Berita -->
            <form action="{{ route('publikasi.berita.store') }}" method="POST" enctype="multipart/form-data" 
                id="addBeritaForm"
                class="card w-full flex flex-col border border-default-200 shadow-lg rounded-xl pointer-events-auto bg-white dark:bg-neutral-800">
                @csrf

                <!-- Modal Header -->
                <div class="card-header flex items-center justify-between px-6 py-5 border-b border-default-200">
                    <h3 id="addBeritaModal-label" class="font-semibold text-lg text-default-800 dark:text-white">
                        Tambah Berita Baru
                    </h3>
                    <button type="button" class="size-6 text-default-600 hover:text-default-900 flex items-center justify-center rounded-lg transition-all" aria-label="Close"
                        data-hs-overlay="#addBeritaModal">
                        <span class="sr-only">Close</span>
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="card-body px-6 py-5 space-y-4 max-h-[75vh] overflow-y-auto" data-simplebar>
                    
                    <!-- Judul Berita -->
                    <div class="mb-2">
                        <label for="judul" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Judul Berita <span class="text-danger">*</span></label>
                        <input type="text" id="judul" name="judul" class="form-input" placeholder="Masukkan judul berita..." required>
                    </div>

                    <!-- Isi Berita Lengkap -->
                    <div class="mb-2">
                        <label class="inline-block mb-1.5 text-sm text-default-800 font-medium">Isi Berita <span class="text-danger">*</span></label>
                        
                        <!-- Textarea Asli (Hidden untuk menampung value saat form submit) -->
                        <textarea id="isi" name="isi" class="hidden" required></textarea>
                        
                        <!-- Container Editor Quill -->
                        <div id="editor-container" class="bg-white rounded-b-lg min-h-[180px]"></div>
                    </div>

                    <!-- Status Publikasi -->
                    <div class="mb-2">
                        <label for="status" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Status <span class="text-danger">*</span></label>
                        <select id="status" name="status" class="form-input" required>
                            <option value="published" selected>Published (Langsung Terbit)</option>
                            <option value="draft">Draft (Simpan Sementara)</option>
                            <option value="archived">Archived (Arsip)</option>
                        </select>
                    </div>

                    <!-- Gambar Cover -->
                    <div class="mb-2">
                        <label class="inline-block mb-1.5 text-sm text-default-800 font-medium">Gambar Sampul / Cover</label>
                        <div class="relative w-full">
                            <!-- Input File Asli -->
                            <input type="file" id="gambar_cover" name="gambar_cover" accept="image/png, image/jpeg, image/webp" 
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                                onchange="document.getElementById('cover-file-name').textContent = this.files[0]?.name || 'Pilih gambar sampul...'; document.getElementById('cover-file-name').classList.remove('text-default-400'); document.getElementById('cover-file-name').classList.add('text-default-800');">
                            
                            <!-- Custom Box Display -->
                            <div class="flex items-center justify-between w-full border border-default-200 rounded-lg p-1.5 bg-white cursor-pointer hover:border-default-400 transition-all">
                                <span id="cover-file-name" class="text-sm text-default-400 px-2 truncate">Pilih gambar sampul...</span>
                                <span class="px-3 py-1.5 rounded-md bg-default-100 text-default-700 text-xs font-medium hover:bg-default-200 shrink-0">
                                    Browse
                                </span>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-default-400">PNG, JPG, atau WEBP (Maksimal 2MB)</p>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="card-footer px-6 py-4 border-t border-default-200 flex gap-3 justify-end items-center">
                    <button type="button" class="btn border border-default-200 text-default-700 hover:bg-default-100 px-4 py-2" data-hs-overlay="#addBeritaModal">
                        Batal
                    </button>
                    <button type="submit" class="btn bg-primary text-white hover:bg-primary-600 px-5 py-2">
                        Simpan Berita
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Berita -->
    <div id="editBeritaModal"
        class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none"
        role="dialog" tabindex="-1" aria-labelledby="editBeritaModal-label">
        
        <!-- Modal Container dengan Max Width 640px -->
        <div class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200 w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center" style="max-width: 640px;">
            
            <form id="editBeritaForm" method="POST" enctype="multipart/form-data" 
                class="card w-full flex flex-col border border-default-200 shadow-lg rounded-xl pointer-events-auto bg-white dark:bg-neutral-800">
                @csrf
                @method('PUT')

                <!-- Header -->
                <div class="card-header flex items-center justify-between px-6 py-5 border-b border-default-200">
                    <h3 id="editBeritaModal-label" class="font-semibold text-lg text-default-800 dark:text-white">
                        Edit Berita
                    </h3>
                    <button type="button" class="size-6 text-default-600 hover:text-default-900 flex items-center justify-center rounded-lg transition-all" aria-label="Close" data-hs-overlay="#editBeritaModal">
                        <span class="sr-only">Close</span>
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                </div>

                <!-- Body -->
                <div class="card-body px-6 py-5 space-y-4 max-h-[75vh] overflow-y-auto" data-simplebar>
                    
                    <!-- ID Berita Hidden -->
                    <input type="hidden" id="edit_berita_id" name="berita_id">

                    <!-- Judul Berita -->
                    <div class="mb-2">
                        <label for="edit_judul" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Judul Berita <span class="text-danger">*</span></label>
                        <input type="text" id="edit_judul" name="judul" class="form-input w-full" placeholder="Masukkan judul berita..." required>
                    </div>

                    <!-- Edit Isi Berita dengan Quill Editor -->
                    <div class="mb-2">
                        <label class="inline-block mb-1.5 text-sm text-default-800 font-medium">Isi Berita <span class="text-danger">*</span></label>
                        
                        <textarea id="edit_isi" name="isi" class="hidden" required></textarea>
                        <div id="edit-editor-container" class="bg-white rounded-b-lg min-h-[180px]"></div>
                    </div>

                    <!-- Status Publikasi -->
                    <div class="mb-2">
                        <label for="edit_status" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Status <span class="text-danger">*</span></label>
                        <select id="edit_status" name="status" class="form-input w-full" required>
                            <option value="published">Published (Terbit)</option>
                            <option value="draft">Draft (Simpan Sementara)</option>
                            <option value="archived">Archived (Arsip)</option>
                        </select>
                    </div>

                    <!-- Gambar Cover -->
                    <div class="mb-2">
                        <label class="inline-block mb-1.5 text-sm text-default-800 font-medium">Gambar Sampul / Cover</label>
                        <div class="relative w-full">
                            <input type="file" id="edit_gambar_cover" name="gambar_cover" accept="image/png, image/jpeg, image/webp" 
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                                onchange="document.getElementById('edit-cover-file-name').textContent = this.files[0]?.name || 'Ganti gambar sampul...';">
                            
                            <div class="flex items-center justify-between w-full border border-default-200 rounded-lg p-1.5 bg-white cursor-pointer hover:border-default-400">
                                <span id="edit-cover-file-name" class="text-sm text-default-400 px-2 truncate">Ganti gambar sampul...</span>
                                <span class="px-3 py-1.5 rounded-md bg-default-100 text-default-700 text-xs font-medium shrink-0">Browse</span>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-default-400">Kosongkan jika tidak ingin mengganti gambar sampul.</p>
                    </div>

                </div>

                <!-- Footer -->
                <div class="card-footer px-6 py-4 border-t border-default-200 flex gap-3 justify-end items-center">
                    <button type="button" class="btn border border-default-200 text-default-700 hover:bg-default-100 px-4 py-2" data-hs-overlay="#editBeritaModal">
                        Batal
                    </button>
                    <button type="submit" class="btn bg-primary text-white hover:bg-primary-600 px-5 py-2">
                        Perbarui Berita
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // ------------------------------------------------------------------
            // 1. Inisialisasi Quill.js Editor (Tambah & Edit Berita)
            // ------------------------------------------------------------------
            const toolbarOptions = [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['link', 'clean']
            ];

            // Inisialisasi Quill untuk Modal Tambah Berita
            const editorTambah = document.getElementById('editor-container');
            let quillAdd = null;
            if (editorTambah) {
                quillAdd = new Quill('#editor-container', {
                    theme: 'snow',
                    modules: { toolbar: toolbarOptions },
                    placeholder: 'Tuliskan isi berita lengkap di sini...'
                });

                quillAdd.on('text-change', () => {
                    const inputIsi = document.getElementById('isi');
                    if (inputIsi) {
                        inputIsi.value = quillAdd.root.innerHTML === '<p><br></p>' ? '' : quillAdd.root.innerHTML;
                    }
                });
            }

            // Inisialisasi Quill untuk Modal Edit Berita
            const editorEdit = document.getElementById('edit-editor-container');
            let quillEdit = null;
            if (editorEdit) {
                quillEdit = new Quill('#edit-editor-container', {
                    theme: 'snow',
                    modules: { toolbar: toolbarOptions },
                    placeholder: 'Tuliskan isi berita lengkap di sini...'
                });

                quillEdit.on('text-change', () => {
                    const inputEditIsi = document.getElementById('edit_isi');
                    if (inputEditIsi) {
                        inputEditIsi.value = quillEdit.root.innerHTML === '<p><br></p>' ? '' : quillEdit.root.innerHTML;
                    }
                });
            }


            // ------------------------------------------------------------------
            // 2. Handler Autofill Data Modal Edit Berita
            // ------------------------------------------------------------------
            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function () {
                    const form = document.getElementById('editBeritaForm');
                    if (!form) return;
                    
                    // Assign Action Route secara dinamis
                    form.action = this.dataset.action;

                    // Mapping Input Teks & Textarea (Judul & Ringkasan)
                    const textFields = ['judul', 'ringkasan'];
                    textFields.forEach(field => {
                        if (form.elements[field]) {
                            form.elements[field].value = this.dataset[field] || '';
                        }
                    });

                    // Mapping Isi Berita ke Quill Editor
                    const isiHtml = this.dataset.isi || '';
                    if (quillEdit) {
                        quillEdit.root.innerHTML = isiHtml;
                    }
                    if (form.elements['isi']) {
                        form.elements['isi'].value = isiHtml;
                    }

                    // Mapping Select Status (Lowercasing agar presisi)
                    if (form.elements['status']) {
                        const statusValue = String(this.dataset.status || '').toLowerCase().trim();
                        form.elements['status'].value = statusValue;
                    }

                    // Reset Display Name untuk Upload Gambar Cover
                    const fileNameLabel = document.getElementById('edit-cover-file-name');
                    if (fileNameLabel) {
                        fileNameLabel.textContent = 'Ganti gambar sampul...';
                        fileNameLabel.classList.remove('text-default-800');
                        fileNameLabel.classList.add('text-default-400');
                    }
                });
            });

        });

        // ------------------------------------------------------------------
        // 3. Handler SweetAlert2 Delete Berita
        // ------------------------------------------------------------------
        function confirmDeleteBerita(deleteUrl, beritaJudul) {
            Swal.fire({
                title: 'Hapus Berita?',
                text: `Berita "${beritaJudul}" akan dihapus secara permanen.`,
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
