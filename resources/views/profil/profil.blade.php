@extends('layouts.vertical', ['title' => 'Profil Organisasi'])

@section('css')

@endsection

@section('content')
    @include('layouts.partials/page-title', ['title' => 'Profil Organisasi'] )

    <div class="container-fluid p-6 space-y-6">

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h3 class="text-xl font-semibold text-default-800 dark:text-white">Profil & Informasi Organisasi</h3>
                <p class="text-sm text-default-500">Kelola informasi Visi, Misi, Struktur Organisasi, dan Informasi Kontak Resmi.</p>
            </div>
        </div>

        <!-- Alert Success -->
        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-success bg-success/10 rounded-lg border border-success/20 flex items-center gap-2">
                <i data-lucide="check-circle-2" class="size-5 shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Form Kelola Profil & Kontak -->
        <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Card 1: Visi & Misi -->
            <div class="card p-6 border border-default-200 rounded-xl bg-white dark:bg-neutral-800 shadow-sm space-y-4">
                <h4 class="text-base font-semibold text-default-800 dark:text-white flex items-center gap-2 border-b border-default-200 pb-3">
                    <i data-lucide="target" class="size-5 text-primary"></i> Visi & Misi
                </h4>

                <div>
                    <label for="visi" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Visi Organisasi</label>
                    <textarea id="visi" name="visi" class="form-input w-full" rows="3" placeholder="Masukkan visi organisasi...">{{ old('visi', $profil->visi ?? '') }}</textarea>
                </div>

                <div>
                    <label for="misi" class="inline-block mb-1.5 text-sm text-default-800 font-medium">Misi Organisasi</label>
                    <textarea id="misi" name="misi" class="form-input w-full" rows="5" placeholder="Masukkan poin-poin misi organisasi...">{{ old('misi', $profil->misi ?? '') }}</textarea>
                </div>
            </div>

            <!-- Card 2: Foto Dekranasda (DITAMBAHKAN) -->
            <div class="card p-6 border border-default-200 rounded-xl bg-white dark:bg-neutral-800 shadow-sm space-y-4">
                <h4 class="text-base font-semibold text-default-800 dark:text-white flex items-center gap-2 border-b border-default-200 pb-3">
                    <i data-lucide="image" class="size-5 text-primary"></i> Foto Dekranasda
                </h4>

                @if(!empty($profil->foto_dekranasda))
                    <div>
                        <label class="inline-block mb-1.5 text-sm text-default-800 font-medium">Foto Saat Ini</label>
                        <div class="p-2 border border-default-200 rounded-lg bg-default-50 inline-block">
                            <img src="{{ asset('storage/' . $profil->foto_dekranasda) }}" alt="Foto Dekranasda" class="max-h-64 rounded object-contain">
                        </div>
                    </div>
                @endif

                <div>
                    <label class="inline-block mb-1.5 text-sm text-default-800 font-medium">
                        {{ !empty($profil->foto_dekranasda) ? 'Ganti Foto Dekranasda' : 'Upload Foto Dekranasda' }}
                    </label>
                    <div class="relative w-full">
                        <input type="file" id="foto_dekranasda" name="foto_dekranasda" accept="image/png, image/jpeg, image/webp" 
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                            onchange="document.getElementById('dekranasda-file-name').textContent = this.files[0]?.name || 'Pilih foto dekranasda...'; document.getElementById('dekranasda-file-name').classList.remove('text-default-400'); document.getElementById('dekranasda-file-name').classList.add('text-default-800');">
                        
                        <div class="flex items-center justify-between w-full border border-default-200 rounded-lg p-1.5 bg-white dark:bg-neutral-800 cursor-pointer hover:border-default-400 transition-all">
                            <span id="dekranasda-file-name" class="text-sm text-default-400 px-2 truncate">Pilih gambar Dekranasda...</span>
                            <span class="px-3 py-1.5 rounded-md bg-default-100 text-default-700 text-xs font-medium hover:bg-default-200 shrink-0">
                                Browse
                            </span>
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-default-400">PNG, JPG, atau WEBP (Maksimal 2MB)</p>
                </div>
            </div>

            <!-- Card 3: Struktur Organisasi -->
            <div class="card p-6 border border-default-200 rounded-xl bg-white dark:bg-neutral-800 shadow-sm space-y-4">
                <h4 class="text-base font-semibold text-default-800 dark:text-white flex items-center gap-2 border-b border-default-200 pb-3">
                    <i data-lucide="network" class="size-5 text-primary"></i> Bagan Struktur Organisasi
                </h4>

                @if(!empty($profil->foto_struktur))
                    <div>
                        <label class="inline-block mb-1.5 text-sm text-default-800 font-medium">Bagan Saat Ini</label>
                        <div class="p-2 border border-default-200 rounded-lg bg-default-50 inline-block">
                            <img src="{{ asset('storage/' . $profil->foto_struktur) }}" alt="Struktur Organisasi" class="max-h-64 rounded object-contain">
                        </div>
                    </div>
                @endif

                <div>
                    <label class="inline-block mb-1.5 text-sm text-default-800 font-medium">
                        {{ !empty($profil->foto_struktur) ? 'Ganti Bagan Struktur' : 'Upload Bagan Struktur' }}
                    </label>
                    <div class="relative w-full">
                        <input type="file" id="foto_struktur" name="foto_struktur" accept="image/png, image/jpeg, image/webp" 
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                            onchange="document.getElementById('struktur-file-name').textContent = this.files[0]?.name || 'Pilih bagan gambar...'; document.getElementById('struktur-file-name').classList.remove('text-default-400'); document.getElementById('struktur-file-name').classList.add('text-default-800');">
                        
                        <div class="flex items-center justify-between w-full border border-default-200 rounded-lg p-1.5 bg-white dark:bg-neutral-800 cursor-pointer hover:border-default-400 transition-all">
                            <span id="struktur-file-name" class="text-sm text-default-400 px-2 truncate">Pilih gambar bagan struktur...</span>
                            <span class="px-3 py-1.5 rounded-md bg-default-100 text-default-700 text-xs font-medium hover:bg-default-200 shrink-0">
                                Browse
                            </span>
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-default-400">PNG, JPG, atau WEBP (Maksimal 2MB)</p>
                </div>
            </div>

            <!-- Card 4: Informasi Kontak -->
            <div class="card p-6 border border-default-200 rounded-xl bg-white dark:bg-neutral-800 shadow-sm space-y-4">
                <h4 class="text-base font-semibold text-default-800 dark:text-white flex items-center gap-2 border-b border-default-200 pb-3">
                    <i data-lucide="phone-call" class="size-5 text-primary"></i> Informasi Kontak & Media Sosial
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Alamat -->
                    <div class="md:col-span-2">
                        <label for="alamat" class="flex items-center gap-1.5 mb-1.5 text-sm text-default-800 font-medium">
                            <i data-lucide="map-pin" class="size-4 text-default-500"></i>
                            <span>Alamat Lengkap</span>
                        </label>
                        <textarea id="alamat" name="alamat" class="form-input w-full" rows="2" placeholder="Masukkan alamat lengkap kantor...">{{ old('alamat', $profil->alamat ?? '') }}</textarea>
                    </div>

                    <!-- Telepon -->
                    <div>
                        <label for="telepon" class="flex items-center gap-1.5 mb-1.5 text-sm text-default-800 font-medium">
                            <i data-lucide="phone" class="size-4 text-default-500"></i>
                            <span>Nomor Telepon</span>
                        </label>
                        <input type="text" id="telepon" name="telepon" class="form-input w-full" placeholder="Contoh: (024) 866****" value="{{ old('telepon', $profil->telepon ?? '') }}">
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="flex items-center gap-1.5 mb-1.5 text-sm text-default-800 font-medium">
                            <i data-lucide="mail" class="size-4 text-default-500"></i>
                            <span>E-mail Resmi</span>
                        </label>
                        <input type="email" id="email" name="email" class="form-input w-full" placeholder="Contoh: email@domain.go.id" value="{{ old('email', $profil->email ?? '') }}">
                    </div>

                    <!-- Link Maps -->
                    <div class="md:col-span-2">
                        <label for="link_maps" class="flex items-center gap-1.5 mb-1.5 text-sm text-default-800 font-medium">
                            <i data-lucide="map" class="size-4 text-default-500"></i>
                            <span>Link Google Maps</span>
                        </label>
                        <input type="url" id="link_maps" name="link_maps" class="form-input w-full" placeholder="https://maps.google.com/..." value="{{ old('link_maps', $profil->link_maps ?? '') }}">
                    </div>

                    <!-- Instagram -->
                    <div>
                        <label for="instagram" class="flex items-center gap-1.5 mb-1.5 text-sm text-default-800 font-medium">
                            <i data-lucide="instagram" class="size-4 text-default-500"></i>
                            <span>Instagram</span>
                        </label>
                        <input type="url" id="instagram" name="instagram" class="form-input w-full" placeholder="https://instagram.com/username" value="{{ old('instagram', $profil->instagram ?? '') }}">
                    </div>

                    <!-- YouTube -->
                    <div>
                        <label for="youtube" class="flex items-center gap-1.5 mb-1.5 text-sm text-default-800 font-medium">
                            <i data-lucide="youtube" class="size-4 text-default-500"></i>
                            <span>Channel YouTube</span>
                        </label>
                        <input type="url" id="youtube" name="youtube" class="form-input w-full" placeholder="https://youtube.com/@channel" value="{{ old('youtube', $profil->youtube ?? '') }}">
                    </div>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="flex justify-end">
                <button type="submit" class="btn bg-primary text-white hover:bg-primary-600 px-6 py-2.5 rounded-lg flex items-center gap-2">
                    <i data-lucide="save" class="size-4"></i>
                    Simpan Profil & Kontak
                </button>
            </div>
        </form>
    </div>

@endsection

@section('scripts')
    <script></script>
@endsection
