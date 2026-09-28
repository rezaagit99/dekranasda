@extends('frontend.layout.base-layout', ['title' => 'Beranda'])

@section('css')
@endsection

@section('content')

    <!-- ================= SLIDER HERO BANNER UTUH ================= -->
    <section class="relative w-full overflow-hidden bg-slate-100 pt-20 lg:pt-24" id="home">
        @if(isset($sliders) && $sliders->count() > 0)
            <div class="swiper heroSwiper w-full relative group">
                <div class="swiper-wrapper">
                    @foreach($sliders as $slider)
                        <div class="swiper-slide w-full">
                            @if($slider->link)
                                <a href="{{ $slider->link }}" target="_blank" class="block w-full">
                                    <img 
                                        src="{{ asset('storage/' . $slider->gambar) }}" 
                                        alt="{{ $slider->judul }}" 
                                        class="w-full h-auto object-contain block"
                                    />
                                </a>
                            @else
                                <img 
                                    src="{{ asset('storage/' . $slider->gambar) }}" 
                                    alt="{{ $slider->judul }}" 
                                    class="w-full h-auto object-contain block"
                                />
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Tombol Navigasi Panah Kiri (Prev) -->
                <button type="button" class="btn-prev-slide absolute left-4 top-1/2 -translate-y-1/2 z-50 flex items-center justify-center w-10 h-10 bg-white/90 hover:bg-white text-gray-800 rounded-md shadow-lg border border-gray-300 transition-all cursor-pointer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>

                <!-- Tombol Navigasi Panah Kanan (Next) -->
                <button type="button" class="btn-next-slide absolute right-4 top-1/2 -translate-y-1/2 z-50 flex items-center justify-center w-10 h-10 bg-white/90 hover:bg-white text-gray-800 rounded-md shadow-lg border border-gray-300 transition-all cursor-pointer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <!-- Pagination Dots -->
                <div class="swiper-pagination !bottom-2"></div>
            </div>
        @else
            <div class="w-full h-[350px] bg-sky-800 flex items-center justify-center">
                <h2 class="text-2xl font-bold text-white">Banner Informasi Portal Resmi</h2>
            </div>
        @endif
    </section>

    <!-- hero section -->
    <section class="relative lg:pb-24 md:pt-48 pt-40" id="profil">
        <div class="absolute top-0 start-0 size-64 bg-primary/10 blur-3xl"></div>
        <div class="absolute bottom-0 end-0 size-64 bg-purple-500/10 blur-3xl"></div>
        <div class="container">
            <div class="grid lg:grid-cols-12 items-center gap-5">
                <div class="lg:col-span-5">
                    <h1 class="mb-4 leading-relaxed lg:text-5xl md:text-4xl text-3xl font-bold text-default-800">
                        Dekranasda Kabupaten Tuban
                    </h1>
                    <p class="mb-6 text-base md:text-lg text-default-600 leading-relaxed">
                        Wadah pengembangan seni kerajinan daerah yang menaungi para perajin dan pelaku UMKM lokal. Kami berkomitmen melestarikan warisan budaya seperti Batik Gedog serta mendorong daya saing produk kerajinan khas Tuban hingga pasar nasional.
                    </p>
                    <div>
                        <a href="#produk">
                            <button
                                style="background: linear-gradient(135deg, #e60707 0%, #761b2f 100%) !important; color: #ffffff !important;"
                                class="border-0 rounded-md inline-flex items-center gap-2 px-5 py-2.5 shadow-md cursor-pointer transition-opacity hover:opacity-90"
                                type="button">
                                Lihat Produk <i class="size-4" data-lucide="shopping-bag"></i>
                            </button>
                        </a>
                    </div>
                </div>
                <div class="lg:col-span-6">
                    <div class="relative">
                        <div
                            class="absolute text-center -z-20 -top-20 -end-64 md:text-[10rem] lg:text-[14rem] text-default-100/50 font-normal font-tourney lg:block hidden">
                            Dekranasda Tuban
                        </div>
                        <div class="hs-tooltip [--placement:top] inline-block z-40">
                            <img alt="" class="lg:ms-40 md:ms-20 w-xl mx-auto"
                                src="{{ asset('storage/' . $profil->foto_dekranasda) }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= SECTION PRODUK UMKM ================= -->
    <section class="relative lg:py-24 py-16" id="produk">
        <div class="container">
            <!-- Section Header -->
            <div class="lg:w-3xl mx-auto text-center mb-12">
                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-600 mb-2">
                    Katalog Kerajinan & Kuliner
                </span>
                <h2 class="leading-normal capitalize text-3xl md:text-4xl font-bold text-default-800">
                    Produk Unggulan UMKM
                </h2>
                <p class="text-default-600 mt-2 text-base">
                    Temukan karya kerajinan tangan, batik lokal, dan kuliner khas buatan perajin binaan Dekranasda Kabupaten Tuban.
                </p>
            </div>

            <!-- Grid Produk -->
            @if(isset($produks) && $produks->count() > 0)
                <div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-6 mt-4">
                    @foreach($produks as $produk)
                        <div class="card bg-card hover:shadow-xl transition-all duration-300 rounded-xl border border-default-200 overflow-hidden flex flex-col justify-between group">
                            <div class="card-body p-4">
                                <!-- Image Container -->
                                <div class="relative overflow-hidden rounded-lg bg-default-100 h-52 w-full flex items-center justify-center">
                                    @php
                                        // Decode JSON array dari kolom foto_produk
                                        $fotos = is_array($produk->foto_produk) 
                                            ? $produk->foto_produk 
                                            : json_decode($produk->foto_produk, true);
                                        
                                        // Ambil elemen pertama (gambar paling depan)
                                        $fotoUtama = $fotos[0] ?? null;
                                    @endphp

                                    @if($fotoUtama)
                                        <img 
                                            src="{{ asset('storage/' . $fotoUtama) }}" 
                                            alt="{{ $produk->nama_produk ?? $produk->nama }}" 
                                            class="h-full w-full object-cover object-center group-hover:scale-105 transition-transform duration-300" 
                                        />
                                    @else
                                        <img 
                                            src="/images/logo-dekranasda.png" 
                                            alt="Default Image" 
                                            class="h-32 opacity-50" 
                                        />
                                    @endif
                                </div>

                                <!-- Content -->
                                <div class="mt-4">
                                    <!-- Baris Kategori & Total Views -->
                                    <div class="flex items-center justify-between gap-2 mb-1">
                                        @if(isset($produk->kategori) || isset($produk->nama_kategori))
                                            <span class="text-xs font-medium text-primary uppercase tracking-wider">
                                                {{ $produk->nama_kategori ?? $produk->kategori->nama_kategori ?? "-" }}
                                            </span>
                                        @else
                                            <span></span>
                                        @endif

                                        <!-- Indikator Views -->
                                        <div class="flex items-center gap-1 text-xs text-default-400">
                                            <i data-lucide="eye" class="size-3.5"></i>
                                            <span>{{ number_format($produk->views ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                    </div>

                                    <h3 class="text-lg font-semibold text-default-800 mt-1 line-clamp-1 hover:text-red-600 transition-colors">
                                        <a href="{{ route('frontend.produk.show', $produk->produk_id) }}">
                                            {{ $produk->nama_produk ?? $produk->nama }}
                                        </a>
                                    </h3>

                                    @if(isset($produk->deskripsi))
                                        <p class="text-sm text-default-500 mt-1 line-clamp-2">
                                            {{ Str::limit(strip_tags($produk->deskripsi ?? ''), 100, '...') ?: '-' }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Card Footer / Price & Button -->
                            <div class="px-4 pb-4 pt-2 border-t border-default-100 flex justify-between items-center mt-auto">
                                <div>
                                    <span class="text-xs text-default-400 block">Harga</span>
                                    <h4 class="text-base font-bold text-primary">
                                        Rp {{ number_format($produk->harga ?? 0, 0, ',', '.') }}
                                    </h4>
                                </div>

                                <a style="background: linear-gradient(135deg, #e60707 0%, #761b2f 100%) !important; color: #ffffff !important;"
                                    href="{{ route('frontend.produk.show', $produk->produk_id) }}" class="btn border-0 btn-sm rounded-md inline-flex items-center gap-1 shadow-sm cursor-pointer transition-opacity hover:opacity-90">
                                    Detail <i class="size-3.5" data-lucide="arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Fallback Jika Belum Ada Data Produk -->
                <div class="text-center py-12 bg-default-100 rounded-2xl border border-dashed border-default-300">
                    <i class="size-12 text-default-400 mx-auto mb-3" data-lucide="package-open"></i>
                    <h3 class="text-lg font-semibold text-default-700">Belum Ada Produk Ditampilkan</h3>
                    <p class="text-sm text-default-500">Produk UMKM akan segera diperbarui oleh admin.</p>
                </div>
            @endif
            <!-- Tombol Semua Produk (Tengah Bawah) -->
            <div class="mt-10 text-center">
                <a href="{{ route('frontend.produk.index') }}" 
                style="background: linear-gradient(135deg, #e60707 0%, #761b2f 100%) !important; color: #ffffff !important;"
                class="inline-flex items-center justify-center gap-2 px-6 py-3 font-semibold rounded-lg shadow-md transition-all duration-300 hover:opacity-90 hover:shadow-lg">
                    Semua Produk
                    <i class="size-4" data-lucide="arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <section style="background: linear-gradient(135deg, rgba(220, 38, 38, 0.92) 0%, rgba(226, 92, 92, 0.95) 100%), url('{{ asset('images/batik_tuban2.webp') }}') center/cover no-repeat !important;" class="relative py-12 md:py-18 lg:py-16 flex items-center justify-center min-h-[500px] mb-16 overflow-hidden" id="counter">
    
        <!-- Soft Glow Ornaments (Pemanis Tampilan) -->
        <div class="absolute -top-20 -left-20 w-80 h-80 rounded-full bg-red-400/20 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -right-20 w-96 h-96 rounded-full bg-black/30 blur-3xl pointer-events-none"></div>

        <div class="container my-auto relative z-10">
            <div class="flex flex-col gap-y-10 md:gap-y-12">
                
                <!-- Section Header -->
                <div class="text-center text-white lg:w-3xl mx-auto mb-4">
                    <h1 class="!text-white leading-relaxed text-3xl md:text-4xl font-semibold drop-shadow-md">
                        Mitra & Produk Terdaftar
                    </h1>
                    <p class="text-bas text-white md:text-lg !text-white/90 font-normal drop-shadow">
                        Gambaran singkat statistik perkembangan pelaku UMKM dan potensi ekonomi kreatif Dekranasda Kabupaten Tuban.
                    </p>
                </div>

                <!-- Grid 3 Kolom Simetris -->
                <div class="grid lg:grid-cols-3 md:grid-cols-3 grid-cols-1 gap-5">
                    
                    <!-- Card 1: Total UMKM -->
                    <div class="card shadow-lg shadow-black/20 transition-transform duration-300 hover:-translate-y-1">
                        <div class="card-body p-5 sm:p-6">
                            <h5 class="mb-2 flex items-center gap-2">
                                <i class="text-primary size-5" data-lucide="store"></i>
                                <span class="text-base font-semibold text-default-800">Mitra UMKM</span>
                            </h5>
                            <p class="mb-3 text-sm text-default-500">Pelaku usaha terdaftar</p>
                            
                            <h1 class="mb-3 text-3xl text-default-800 font-bold tracking-tight">
                                {{ number_format($totalUmkm ?? 0, 0, ',', '.') }}
                                <small class="text-sm font-normal text-default-500">UMKM</small>
                            </h1>

                            <div class="pt-3 border-t border-default-200">
                                <ul class="flex flex-col gap-2 text-xs">
                                    <li class="flex items-center gap-2">
                                        <i class="size-3.5 text-success shrink-0" data-lucide="check-check"></i>
                                        <span class="text-default-900">Terverifikasi Dekranasda</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <i class="size-3.5 text-success shrink-0" data-lucide="check-check"></i>
                                        <span class="text-default-900">Binaan Kab. Tuban</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Katalog Produk -->
                    <div class="card shadow-lg shadow-black/20 transition-transform duration-300 hover:-translate-y-1">
                        <div class="card-body p-5 sm:p-6">
                            <h5 class="mb-2 flex items-center gap-2">
                                <i class="text-purple-500 size-5" data-lucide="shopping-bag"></i>
                                <span class="text-base font-semibold text-default-800">Katalog Produk</span>
                            </h5>
                            <p class="mb-3 text-sm text-default-500">Produk unggulan daerah</p>
                            
                            <h1 class="mb-3 text-3xl text-default-800 font-bold tracking-tight">
                                {{ number_format($totalProduk ?? 0, 0, ',', '.') }}
                                <small class="text-sm font-normal text-default-500">Produk</small>
                            </h1>

                            <div class="pt-3 border-t border-default-200">
                                <ul class="flex flex-col gap-2 text-xs">
                                    <li class="flex items-center gap-2">
                                        <i class="size-3.5 text-success shrink-0" data-lucide="check-check"></i>
                                        <span class="text-default-900">Kerajinan & Batik Khas</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <i class="size-3.5 text-success shrink-0" data-lucide="check-check"></i>
                                        <span class="text-default-900">Siap Dipasarkan</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Kategori Produk -->
                    <div class="card shadow-lg shadow-black/20 transition-transform duration-300 hover:-translate-y-1">
                        <div class="card-body p-5 sm:p-6">
                            <h5 class="mb-2 flex items-center gap-2">
                                <i class="text-emerald-500 size-5" data-lucide="shapes"></i>
                                <span class="text-base font-semibold text-default-800">Kategori Usaha</span>
                            </h5>
                            <p class="mb-3 text-sm text-default-500">Sektor & variasi produk</p>
                            
                            <h1 class="mb-3 text-3xl text-default-800 font-bold tracking-tight">
                                {{ number_format($totalKategori ?? 0, 0, ',', '.') }}
                                <small class="text-sm font-normal text-default-500">Kategori</small>
                            </h1>

                            <div class="pt-3 border-t border-default-200">
                                <ul class="flex flex-col gap-2 text-xs">
                                    <li class="flex items-center gap-2">
                                        <i class="size-3.5 text-success shrink-0" data-lucide="check-check"></i>
                                        <span class="text-default-900">Batik, Ukiran, Olahan, dll</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <i class="size-3.5 text-success shrink-0" data-lucide="check-check"></i>
                                        <span class="text-default-900">Ragam Produk Binaan</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- ================= SECTION KALENDER KEGIATAN (LIST STYLE) ================= -->
    <section class="relative lg:pb-2 md:pb-18 pb-12" id="kalender">
        <div class="container">
            <div class="flex flex-col gap-y-10">
                
                <!-- Header Section (Center) -->
                <div class="text-center lg:w-2xl mx-auto ">
                    <h1 class="text-3xl md:text-4xl font-semibold text-default-800 mb-2">
                        Agenda & Kegiatan
                    </h1>
                    <p class="text-default-500 text-sm md:text-base">
                        Jadwal pameran, pelatihan, dan acara mendatang Dekranasda Kabupaten Tuban.
                    </p>
                </div>

                <!-- List Container -->
                <div class="flex gap-4 mt-6 mx-auto text-center flex-col lg:w-2xl">
                    @forelse($kegiatans ?? [] as $kegiatan)
                        @php
                            $tgl = \Carbon\Carbon::parse($kegiatan->tanggal_mulai ?? $kegiatan->created_at);
                        @endphp
                        
                        <div class="card rounded-xl hover:border-primary/50 transition-all duration-300 w-xl">
                            <div class="card-body p-4 sm:p-5 flex sm:flex-row sm:items-center align-items justify-between gap-4 sm:gap-6">
                                
                                <!-- Kiri: Box Tanggal & Info Utama -->
                                <div class="flex items-center gap-4 sm:gap-5 min-w-0">
                                    
                                    <!-- Box Tanggal Minimalis -->
                                    <div class="size-16 sm:size-20 rounded-xl bg-red-500/10 dark:bg-red-500/20 text-red-600 dark:text-red-400 flex flex-col items-center justify-center shrink-0 border border-red-500/20">
                                        <span class="text-xl sm:text-2xl font-black leading-none">
                                            {{ $tgl->format('d') }}
                                        </span>
                                        <span class="text-xs font-bold uppercase mt-1 tracking-wider">
                                            {{ $tgl->translatedFormat('M') }}
                                        </span>
                                    </div>

                                    <!-- Detail Kegiatan -->
                                    <div class="min-w-0 text-left">
                                        <div class="flex gap-2 mb-1 flex-wrap">
                                            <!-- Badge Status / Kategori -->
                                            <span class="px-2 py-0.5 text-[10px] font-bold rounded bg-primary/10 text-primary">
                                                {{ $kegiatan->kategori->nama ?? 'Agenda Binaan' }}
                                            </span>
                                            <span class="text-xs text-default-400 flex items-center gap-1">
                                                <i data-lucide="clock" class="size-3.5"></i>
                                                {{ $kegiatan->jam ?? '08:00 WIB - Selesai' }}
                                            </span>
                                        </div>

                                        <h3 class="text-base sm:text-lg font-bold text-default-800 truncate hover:text-primary transition-colors">
                                            <a href="">
                                                {{ $kegiatan->nama_kegiatan ?? $kegiatan->judul }}
                                            </a>
                                        </h3>

                                        <p class="text-xs sm:text-sm text-default-500 flex items-center gap-1.5 mt-1 truncate">
                                            <i data-lucide="map-pin" class="size-3.5 text-danger shrink-0"></i>
                                            <span>{{ $kegiatan->lokasi ?? 'Kabupaten Tuban' }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <!-- Fallback Kosong -->
                        <div class="card p-8 text-center">
                            <i data-lucide="calendar-x" class="size-10 text-default-400 mx-auto mb-2"></i>
                            <p class="text-default-500 text-sm">Belum ada agenda kegiatan mendatang.</p>
                        </div>
                    @endforelse
                </div>
                <!-- Tombol Semua Agenda (Tengah Bawah) -->
                <div class="mt-12 text-center">
                    <a href="{{ route('frontend.kegiatan.index') }}" 
                    style="background: linear-gradient(135deg, #e60707 0%, #761b2f 100%) !important; color: #ffffff !important;"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 font-semibold rounded-lg shadow-md transition-all duration-300 hover:opacity-90 hover:shadow-lg">
                        Semua Agenda
                        <i class="size-4" data-lucide="arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= SECTION FITUR / LAYANAN UTAMA ================= -->
    <section class="relative lg:pb-2 md:pb-18 pb-12" id="layanan">
        <div class="container">
            <div class="flex flex-col gap-y-12">
                
                <!-- Section Header -->
                <div class="text-center lg:w-3xl mx-auto">
                    <h1 class="leading-relaxed text-4xl font-semibold text-default-800">
                        Layanan & Fitur Utama
                    </h1>
                    <p class="text-lg text-default-500">
                        Dukungan penuh Dekranasda Kabupaten Tuban untuk mendorong pertumbuhan dan daya saing UMKM lokal.
                    </p>
                </div>

                <!-- Grid 3 Card (Sesuai Struktur Class HTML Anda) -->
                <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-5 mb-6">
                    
                    <!-- Card 1: Layanan Dekranasda -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-2 flex items-center gap-2">
                                <i class="text-pink-500 size-6" data-lucide="users"></i>
                                <span class="text-lg font-semibold text-default-800">Layanan Dekranasda</span>
                            </h5>
                            <p class="mb-4 text-default-500">
                                Fasilitasi pelaku UKM/IKM kerajinan agar memiliki daya saing global.
                            </p>
                            
                            <div class="pt-4 border-t border-default-200">
                                <ul class="flex flex-col gap-3 text-sm">
                                    <li class="flex items-center gap-2.5">
                                        <i class="size-4 text-success" data-lucide="check-check"></i>
                                        <span class="text-default-900">Pendampingan Usaha & Legalitas</span>
                                    </li>
                                    <li class="flex items-center gap-2.5">
                                        <i class="size-4 text-success" data-lucide="check-check"></i>
                                        <span class="text-default-900">Pelatihan & Workshop Desain</span>
                                    </li>
                                    <li class="flex items-center gap-2.5">
                                        <i class="size-4 text-success" data-lucide="check-check"></i>
                                        <span class="text-default-900">Fasilitasi Pameran Produk</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Statistik Mitra -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-2 flex items-center gap-2">
                                <i class="text-purple-500 size-6" data-lucide="pie-chart"></i>
                                <span class="text-lg font-semibold text-default-800">Statistik Mitra</span>
                            </h5>
                            <p class="mb-4 text-default-500">
                                Perkembangan Mitra Dekranasda Kabupaten Tuban untuk pemantauan pertumbuhan usaha.
                            </p>

                            <div class="pt-4 border-t border-default-200">
                                <ul class="flex flex-col gap-3 text-sm">
                                    <li class="flex items-center gap-2.5">
                                        <i class="size-4 text-success" data-lucide="check-check"></i>
                                        <span class="text-default-900">Data Terintegrasi Real-time</span>
                                    </li>
                                    <li class="flex items-center gap-2.5">
                                        <i class="size-4 text-success" data-lucide="check-check"></i>
                                        <span class="text-default-900">Pemetaan Wilayah Potensi UMKM</span>
                                    </li>
                                    <li class="flex items-center gap-2.5">
                                        <i class="size-4 text-success" data-lucide="check-check"></i>
                                        <span class="text-default-900">Monitoring Capaian Usaha</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Katalog Produk -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-2 flex items-center gap-2">
                                <i class="text-emerald-500 size-6" data-lucide="package"></i>
                                <span class="text-lg font-semibold text-default-800">Katalog Produk</span>
                            </h5>
                            <p class="mb-4 text-default-500">
                                Beragam produk unggulan Mitra Dekranasda yang mencerminkan kreativitas lokal.
                            </p>

                            <div class="pt-4 border-t border-default-200">
                                <ul class="flex flex-col gap-3 text-sm">
                                    <li class="flex items-center gap-2.5">
                                        <i class="size-4 text-success" data-lucide="check-check"></i>
                                        <span class="text-default-900">Produk Kerajinan & Batik Khas</span>
                                    </li>
                                    <li class="flex items-center gap-2.5">
                                        <i class="size-4 text-success" data-lucide="check-check"></i>
                                        <span class="text-default-900">Akses Langsung ke Pengrajin</span>
                                    </li>
                                    <li class="flex items-center gap-2.5">
                                        <i class="size-4 text-success" data-lucide="check-check"></i>
                                        <span class="text-default-900">Kualitas Produk Terjamin</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- ================= SECTION BERITA TERBARU ================= -->
    <section style="background: linear-gradient(135deg, rgba(107, 12, 12, 0.92) 0%, rgba(219, 67, 67, 0.95) 100%), url('{{ asset('images/batik_tuban3.jpg') }}') center/cover no-repeat !important;" class="relative py-12 md:py-18 lg:py-16 flex items-center justify-center min-h-[500px] mb-16 overflow-hidden">
    
        <!-- Soft Glow Ornaments -->
        <div class="absolute -top-20 -left-20 w-80 h-80 rounded-full bg-red-400/20 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -right-20 w-96 h-96 rounded-full bg-black/30 blur-3xl pointer-events-none"></div>

        <div class="container relative z-10">

            <!-- Section Header -->
            <div class="text-center text-white max-w-4xl mx-auto mb-10">
                <h1 class="!text-white leading-relaxed text-3xl md:text-4xl font-semibold drop-shadow-md">
                    Berita Terbaru
                </h1>
                <p class="text-base md:text-lg !text-white/90 font-normal drop-shadow leading-relaxed">
                    Dukungan penuh Dekranasda Kabupaten Tuban untuk mendorong pertumbuhan dan daya saing UMKM lokal.
                </p>
            </div>

            <!-- Grid Berita (Card Style Konsisten dengan Produk/Kegiatan) -->
            @if(isset($beritas) && $beritas->count() > 0)
                <div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-6 mt-5">
                    @foreach($beritas as $berita)
                        @php
                            $tglBerita = \Carbon\Carbon::parse($berita->created_at ?? $berita->published_at);
                            $gambar = $berita->gambar_cover ? asset('storage/' . $berita->gambar_cover) : asset('assets/images/placeholder-news.jpg');
                        @endphp

                        <div class="card bg-white dark:bg-default-50 shadow-lg shadow-black/20 hover:-translate-y-1 transition-all duration-300 rounded-2xl border border-default-200 overflow-hidden flex flex-col justify-between group">
                            <div class="card-body p-4">
                                
                                <!-- Container Gambar Berita -->
                                <div class="relative overflow-hidden rounded-xl h-48 w-full bg-slate-100 dark:bg-default-200">
                                    <img src="{{ $gambar }}" 
                                        alt="{{ $berita->judul }}" 
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    
                                    <!-- Badge Kategori (di atas gambar) -->
                                    @if(isset($berita->kategori))
                                        <span class="absolute top-3 left-3 px-2.5 py-1 text-[10px] font-bold rounded-lg bg-white/90 dark:bg-default-100/90 text-slate-800 dark:text-white backdrop-blur-md shadow-sm">
                                            {{ $berita->kategori->nama ?? $berita->kategori }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Content Berita -->
                                <div class="mt-4">
                                    <!-- Tanggal Rilis -->
                                    <div class="flex items-center gap-1.5 text-xs text-default-400 mb-2">
                                        <i data-lucide="calendar" class="size-3.5 text-primary"></i>
                                        <span>{{ $tglBerita->translatedFormat('d F Y') }}</span>
                                    </div>

                                    <!-- Judul Berita -->
                                    <h3 class="text-base font-bold text-default-800 line-clamp-2 group-hover:text-primary transition-colors leading-snug">
                                        <a href="" title="{{ $berita->judul }}">
                                            {{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($berita->judul)), 50, '...') }}
                                        </a>
                                    </h3>

                                    <!-- Ringkasan / Excerpt -->
                                    <p class="text-xs text-default-500 mt-2 line-clamp-2 leading-relaxed">
                                        {{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($berita->isi)), 100, '...', true) }}
                                    </p>
                                </div>
                            </div>

                            <!-- Footer Link / Read More -->
                            <div class="px-4 pb-4 pt-3 border-t border-default-100 mt-auto">
                                <a href="" 
                                class="inline-flex items-center gap-1 text-xs font-bold text-primary hover:gap-2 transition-all">
                                    Baca Selengkapnya
                                    <i data-lucide="chevron-right" class="size-3.5"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Fallback Jika Belum Ada Berita -->
                <div class="text-center py-12 bg-white/10 backdrop-blur-md rounded-2xl border border-dashed border-white/30 max-w-2xl mx-auto">
                    <i class="size-12 text-white/70 mx-auto mb-3" data-lucide="newspaper"></i>
                    <h3 class="text-lg font-semibold text-white">Belum Ada Berita</h3>
                    <p class="text-sm text-white/80">Berita dan artikel terbaru akan ditampilkan di sini.</p>
                </div>
            @endif
            <!-- Tombol Semua Berita (Tengah Bawah) -->
            <div class="mt-10 text-center">
                <a href="{{ route('frontend.berita.index') }}" 
                style="background: linear-gradient(135deg, #e60707 0%, #761b2f 100%) !important; color: #ffffff !important;"
                class="inline-flex items-center justify-center gap-2 px-6 py-3 font-semibold rounded-lg shadow-md transition-all duration-300 hover:opacity-90 hover:shadow-lg">
                    Semua Berita
                    <i class="size-4" data-lucide="arrow-right"></i>
                </a>
            </div>   
        </div>
    </section>

    <!-- ================= SECTION STATISTIK KUNJUNGAN ================= -->
    <div class="p-10 rounded-md mt-20" style="background: linear-gradient(135deg, rgba(100, 10, 10, 0.92) 0%, rgba(82, 13, 13, 0.95) 100%), url('{{ asset('images/batik_tuban3.jpg') }}') center/cover no-repeat !important;">
        <div class="grid lg:grid-cols-5 md:grid-cols-2 gap-6">
            <div class="text-center">
                <h3 class="mb-2 text-white text-2xl font-semibold">
                    <span class="me-1" data-target="{{ number_format($visitorToday ?? 0, 0, ',', '.') }}">{{ number_format($visitorToday ?? 0, 0, ',', '.') }}</span>+
                </h3>
                <p class="text-base text-white">Hari ini</p>
            </div>
            <div class="text-center">
                <h3 class="mb-2 text-white text-2xl font-semibold">
                    <span class="me-1" data-target="{{ number_format($visitorWeek ?? 0, 0, ',', '.') }}">{{ number_format($visitorWeek ?? 0, 0, ',', '.') }}</span>+
                </h3>
                <p class="text-base text-white">Minggu ini </p>
            </div>
            <div class="text-center">
                <h3 class="mb-2 text-white text-2xl font-semibold">
                    <span class="me-1" data-target="{{ number_format($visitorMonth ?? $visitorThisMonth ?? 0, 0, ',', '.') }}">{{ number_format($visitorMonth ?? $visitorThisMonth ?? 0, 0, ',', '.') }}</span>+
                </h3>
                <p class="text-base text-white">Bulan ini</p>
            </div>
            <div class="text-center">
                <h3 class="mb-2 text-white text-2xl font-semibold">
                    <span class="me-1" data-target="{{ number_format($visitorYear ?? 0, 0, ',', '.') }}">{{ number_format($visitorYear ?? 0, 0, ',', '.') }}</span>+
                </h3>
                <p class="text-base text-white">Tahun ini</p>
            </div>
            <div class="text-center">
                <h3 class="mb-2 text-white text-2xl font-semibold">
                    <span class="me-1" data-target="{{ number_format($visitorTotal ?? 0, 0, ',', '.') }}">{{ number_format($visitorTotal ?? 0, 0, ',', '.') }}</span>+
                </h3>
                <p class="text-base text-white">Total</p>
            </div>
        </div>
    </div>

    <!-- Elfsight Instagram Feed | Untitled Instagram Feed -->
    <script src="https://elfsightcdn.com/platform.js" async></script>
    <div class="elfsight-app-17a8af8e-d46b-4c4d-a42e-5a2535fc62d2" data-elfsight-app-lazy></div>

@endsection

@section('scripts')
    @vite(['resources/js/pages/landing.js'])

    <!-- CDN CSS Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <!-- CDN JS Swiper -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Swiper !== 'undefined') {
                new Swiper('.heroSwiper', {
                    loop: true,
                    autoplay: {
                        delay: 4000,
                        disableOnInteraction: false,
                    },
                    navigation: {
                        nextEl: '.btn-next-slide',
                        prevEl: '.btn-prev-slide',
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                });
            }
        });
    </script>

@endsection
