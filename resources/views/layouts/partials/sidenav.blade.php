<!-- Start Sidebar -->
<aside class="app-menu" id="app-menu">
    <!-- Sidenav Menu Brand Logo -->
    <a class="logo-box sticky top-0 flex min-h-topbar-height items-center justify-start px-6 backdrop-blur-xs"
        href="{{ route('dashboard') }}">
            
            <!-- Light Brand Logo -->
            <div class="logo-light flex items-center gap-2">
                <img alt="Light logo" class="logo-lg h-6" src="{{ asset('images/logo-dekranasda.png') }}">
                <img alt="Small logo" class="logo-sm h-6" src="{{ asset('images/logo-dekranasda.png') }}">
                
                <span class="logo-lg app-menu-label text-sm text-default-500 font-medium whitespace-nowrap">
                    <b>DEKRANASDA TUBAN</b>
                </span>
            </div>

            <!-- Dark Brand Logo -->
            <div class="logo-dark flex items-center gap-2">
                <img alt="Dark logo" class="logo-lg h-6" src="{{ asset('images/logo-dekranasda.png') }}">
                <img alt="Small logo" class="logo-sm h-6" src="{{ asset('images/logo-dekranasda.png') }}">
                
                <span class="logo-lg app-menu-label text-sm text-default-500 font-medium whitespace-nowrap">
                    <b>DEKRANASDA TUBAN</b>
                </span>
            </div>
    </a>

    <!-- Sidenav Menu Toggle Button -->
    <div class="absolute top-0 end-5 flex h-topbar items-center justify">
        <button class="" id="button-hover-toggle">
            <i class="iconify tabler--circle size-5"></i>
        </button>
    </div>

    <!-- Sidenav Menu Item Link -->
    <div class="relative min-h-0 flex-grow">
        <div class="size-full" data-simplebar="">
            <ul class="side-nav p-3 hs-accordion-group">
                
                @php
                    $roleId = auth()->user()->role_id ?? null;
                @endphp

                <!-- 1. OVERVIEW (Hanya Super Admin / Role 1) -->
                <li class="menu-title">
                    <span>Overview</span>
                </li>
                <li class="menu-item">
                    <a class="menu-link" href="{{ route('dashboard') }}">
                        <span class="menu-icon"><i data-lucide="monitor-dot"></i></span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>


                <!-- 2. KONTEN & PUBLIKASI (Super Admin / Role 1 & Editor / Role 2) -->
                @if(in_array($roleId, [1, 2]))
                    <li class="menu-title">
                        <span>Konten & Publikasi</span>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('publikasi.berita.index') }}">
                            <span class="menu-icon"><i data-lucide="newspaper"></i></span>
                            <span class="menu-text">Berita</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('publikasi.kalender.index') }}">
                            <span class="menu-icon"><i data-lucide="calendar-1"></i></span>
                            <span class="menu-text">Kalender Kegiatan</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('publikasi.foto.index') }}">
                            <span class="menu-icon"><i data-lucide="image"></i></span>
                            <span class="menu-text">Foto</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('publikasi.video.index') }}">
                            <span class="menu-icon"><i data-lucide="video"></i></span>
                            <span class="menu-text">Video</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('publikasi.slider.index') }}">
                            <span class="menu-icon"><i data-lucide="image-plus"></i></span>
                            <span class="menu-text">Slider</span>
                        </a>
                    </li>
                @endif


                <!-- 3. UMKM & PRODUK -->
                @if(in_array($roleId, [1, 3]))
                    <li class="menu-title">
                        <span>UMKM & Produk</span>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('umkm.kategori.index') }}">
                            <span class="menu-icon"><i data-lucide="tag"></i></span>
                            <span class="menu-text">Kategori</span>
                        </a>
                    </li>
                    
                    <!-- Daftar UMKM (Hanya Super Admin) -->
                    @if($roleId == 1)
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('umkm.umkm.index') }}">
                                <span class="menu-icon"><i data-lucide="building"></i></span>
                                <span class="menu-text">Daftar UMKM</span>
                            </a>
                        </li>
                    @endif

                    <!-- Produk (Super Admin & UMKM) -->
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('umkm.produk.index') }}">
                            <span class="menu-icon"><i data-lucide="package"></i></span>
                            <span class="menu-text">Produk</span>
                        </a>
                    </li>
                @endif


                <!-- 4. HALAMAN STATIS (Hanya Super Admin / Role 1) -->
                @if($roleId == 1)
                    <li class="menu-title">
                        <span>Halaman Statis</span>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('profil.index') }}">
                            <span class="menu-icon"><i data-lucide="building-2"></i></span>
                            <span class="menu-text">Profil Organisasi</span>
                        </a>
                    </li>
                @endif


                <!-- 5. PENGATURAN AKUN (Bisa diakses Semua Role: 1, 2, 3) -->
                @if(in_array($roleId, [2, 3]))
                    <li class="menu-title">
                        <span>Pengaturan Akun</span>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('profil-saya.index') }}">
                            <span class="menu-icon"><i data-lucide="user-cog"></i></span>
                            <span class="menu-text">Profil Saya</span>
                        </a>
                    </li>
                @endif


                <!-- 6. PENGATURAN SISTEM (Hanya Super Admin / Role 1) -->
                @if($roleId == 1)
                    <li class="menu-title">
                        <span>Pengaturan Sistem</span>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('manajemen-user.index') }}">
                            <span class="menu-icon"><i data-lucide="users-round"></i></span>
                            <span class="menu-text">Manajemen Pengguna</span>
                        </a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</aside>
<!-- End Sidebar -->