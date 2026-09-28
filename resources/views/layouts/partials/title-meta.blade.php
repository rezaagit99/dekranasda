<meta charset="utf-8" />
<title>{{ $title }} | Dekranasda Tuban</title>
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
<meta content="Themesdesign" name="author" />
<!-- App favicon -->
<link href="/images/logo-dekranasda.ico" rel="shortcut icon" />
<!-- SweetAlert2 CDN (Wajib ada) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- CDN Quill.js (Snow Theme) -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        {{-- 1. Notifikasi Berhasil --}}
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: @json(session('success')),
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        @endif

        {{-- 2. Notifikasi Error Server / Catch Exception --}}
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal Simpan!',
                text: @json(session('error')),
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#ef4444'
            });
        @endif

        {{-- 3. Notifikasi Error Validasi Input (Email/No HP Duplikat, Dll) --}}
        @if ($errors->any())
            let errorList = `<ul style="text-align: left; margin-left: 20px; list-style-type: disc;">`;
            @foreach ($errors->all() as $error)
                errorList += `<li>{{ $error }}</li>`;
            @endforeach
            errorList += `</ul>`;

            Swal.fire({
                icon: 'warning',
                title: 'Periksa Kembali Inputan!',
                html: errorList,
                confirmButtonText: 'Mengerti',
                confirmButtonColor: '#3b82f6'
            });
        @endif

    });
</script>
