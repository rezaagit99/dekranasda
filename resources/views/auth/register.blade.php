@extends('layouts.base', ['title' => 'Daftar Akun UMKM'])

@section('css')
@endsection

@section('content')
    <div class="relative min-h-screen w-full flex justify-center items-center py-12 md:py-16">
        <div class="card md:w-2xl w-screen z-10">
            <div class="text-center mt-4 px-6 sm:px-10 py-10">
                <!-- Logo -->
                <a class="flex justify-center" href="{{ route('home') }}">
                    <img alt="logo dark" class="h-12 flex dark:hidden" src="{{ asset ('images/logo-dekranasda.png')}}"/>
                    <img alt="logo light" class="h-12 hidden dark:flex" src="{{ asset ('images/logo-dekranasda.png')}}"/>
                </a>
                <div class="mt-6 text-center">
                    <h4 class="mb-2 text-xl font-semibold text-primary">Pendaftaran Akun UMKM</h4>
                    <p class="text-sm text-default-500">Lengkapi data pemilik dan data UMKM Anda untuk mendaftar.</p>
                </div>

                <!-- Alert Error -->
                @if ($errors->any())
                    <div class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-md text-sm text-left">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Registrasi -->
                <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data" class="text-left w-full mt-6">
                    @csrf

                    <!-- SECTION 1: DATA AKUN / PEMILIK -->
                    <div class="border-b border-default-200 pb-4 mb-6">
                        <h5 class="text-base font-semibold text-default-800 mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-primary inline-block"></span>
                            Data Pemilik (User)
                        </h5>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nama Lengkap Pemilik -->
                            <div>
                                <label class="block font-medium text-default-900 text-sm mb-1.5" for="name">Nama Pemilik <span class="text-red-500">*</span></label>
                                <input class="form-input w-full @error('name') border-red-500 @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" 
                                       placeholder="Nama Pemilik UMKM" type="text" required />
                            </div>

                            <!-- No Telp / WhatsApp -->
                            <div>
                                <label class="block font-medium text-default-900 text-sm mb-1.5" for="no_telp">No. HP / WhatsApp</label>
                                <input class="form-input w-full @error('no_telp') border-red-500 @enderror" 
                                       id="no_telp" name="no_telp" value="{{ old('no_telp') }}" 
                                       placeholder="08123456789" type="text" />
                            </div>

                            <!-- Email -->
                            <div class="md:col-span-2">
                                <label class="block font-medium text-default-900 text-sm mb-1.5" for="email">Email <span class="text-red-500">*</span></label>
                                <input class="form-input w-full @error('email') border-red-500 @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" 
                                       placeholder="alamat@email.com" type="email" required />
                            </div>

                            <!-- Password -->
                            <div>
                                <label class="block font-medium text-default-900 text-sm mb-1.5" for="password">Password <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input class="form-input w-full pr-10 @error('password') border-red-500 @enderror" 
                                        id="password" name="password" placeholder="Minimal 8 karakter" type="password" required />
                                    <button type="button" 
                                            onclick="togglePasswordVisibility('password', 'eye-icon-password')" 
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-default-400 hover:text-default-600 focus:outline-none">
                                        <i id="eye-icon-password" data-lucide="eye" class="size-4"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Konfirmasi Password -->
                            <div>
                                <label class="block font-medium text-default-900 text-sm mb-1.5" for="password_confirmation">Konfirmasi Password <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input class="form-input w-full pr-10" 
                                        id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" type="password" required />
                                    <button type="button" 
                                            onclick="togglePasswordVisibility('password_confirmation', 'eye-icon-confirm')" 
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-default-400 hover:text-default-600 focus:outline-none">
                                        <i id="eye-icon-confirm" data-lucide="eye" class="size-4"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: DATA UMKM -->
                    <div class="pb-4 mb-4">
                        <h5 class="text-base font-semibold text-default-800 mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-primary inline-block"></span>
                            Data Usaha (UMKM)
                        </h5>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nama UMKM -->
                            <div>
                                <label class="block font-medium text-default-900 text-sm mb-1.5" for="nama_umkm">Nama Usaha/UMKM <span class="text-red-500">*</span></label>
                                <input class="form-input w-full @error('nama_umkm') border-red-500 @enderror" 
                                       id="nama_umkm" name="nama_umkm" value="{{ old('nama_umkm') }}" 
                                       placeholder="Contoh: Batik Gedog Tuban" type="text" required />
                            </div>

                            <!-- Instagram -->
                            <div>
                                <label class="block font-medium text-default-900 text-sm mb-1.5" for="instagram">Akun Instagram</label>
                                <input class="form-input w-full @error('instagram') border-red-500 @enderror" 
                                       id="instagram" name="instagram" value="{{ old('instagram') }}" 
                                       placeholder="@nama_instagram_umkm" type="text" />
                            </div>

                            <!-- Alamat -->
                            <div class="md:col-span-2">
                                <label class="block font-medium text-default-900 text-sm mb-1.5" for="alamat">Alamat Lengkap Usaha</label>
                                <textarea class="form-input w-full @error('alamat') border-red-500 @enderror" 
                                          id="alamat" name="alamat" rows="2" placeholder="Jl. Raya No. XX, Kecamatan, Kabupaten">{{ old('alamat') }}</textarea>
                            </div>

                            <!-- Deskripsi Usaha -->
                            <div class="md:col-span-2">
                                <label class="block font-medium text-default-900 text-sm mb-1.5" for="deskripsi">Deskripsi Singkat Usaha</label>
                                <textarea class="form-input w-full @error('deskripsi') border-red-500 @enderror" 
                                          id="deskripsi" name="deskripsi" rows="3" placeholder="Jelaskan produk utama atau keunikan usaha Anda">{{ old('deskripsi') }}</textarea>
                            </div>

                            <!-- Foto UMKM -->
                            <div class="md:col-span-2">
                                <label class="block font-medium text-default-900 text-sm mb-1.5" for="foto_umkm">Foto Usaha / Logo</label>
                                <input class="form-input w-full text-xs" id="foto_umkm" name="foto_umkm" type="file" accept="image/*" />
                                <span class="text-[11px] text-default-400 mt-1 block">Format: JPG, PNG, WEBP (Maks: 2MB)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Informational Note -->
                    <div class="p-3 bg-amber-50 border border-amber-200 text-amber-800 rounded-md text-xs mb-6">
                        <strong>Informasi:</strong> <br>
                        Setelah melakukan pendaftaran, akun Anda akan melalui proses verifikasi dan validasi oleh Admin. Mohon bersabar, konfirmasi serta informasi selanjutnya akan kami kirimkan ke email yang telah Anda daftarkan.
                    </div>

                    <!-- reCAPTCHA Widget -->
                    <div class="mb-6 flex justify-center">
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                    </div>
                    @error('g-recaptcha-response')
                        <span class="text-xs text-red-500 text-center block -mt-4 mb-4">{{ $message }}</span>
                    @enderror

                    <!-- Tombol Submit -->
                    <div class="mt-6 text-center">
                        <button class="btn bg-primary text-white w-full py-2.5 rounded-lg font-semibold hover:bg-primary/90 transition duration-200" type="submit">
                            Daftarkan UMKM
                        </button>
                    </div>

                    <!-- Link Login -->
                    <div class="mt-6 mb-4 text-center">
                        <p class="text-sm text-default-500">Sudah punya akun?
                            <a class="font-semibold underline hover:text-primary transition duration-200" href="{{ route('login') }}">Masuk</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>

        <!-- Background Pattern -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <svg aria-hidden="true" class="absolute inset-0 size-full fill-black/2 stroke-black/5 dark:fill-white/2.5 dark:stroke-white/2.5">
                <defs>
                    <pattern height="56" id="authPattern" patternunits="userSpaceOnUse" width="56" x="50%" y="16">
                        <path d="M.5 56V.5H72" fill="none"></path>
                    </pattern>
                </defs>
                <rect fill="url(#authPattern)" height="100%" stroke-width="0" width="100%"></rect>
            </svg>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Google reCAPTCHA v2 Script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                input.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }

            if (window.lucide) {
                lucide.createIcons();
            }
        }
    </script>
@endsection