@extends('frontend.layout.base-layout', ['title' => $produk->nama_produk ?? $produk->nama])

@section('css')
@endsection

@section('content')
    <section class="relative w-full overflow-hidden bg-slate-100 pt-20 lg:pt-28" id="detail-produk">

    <div class="container mx-auto px-4">
        
        <!-- Breadcrumb Navigation -->
        <nav class="flex mb-6 text-sm text-default-500" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2">
                <li>
                    <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Beranda</a>
                </li>
                <li><i data-lucide="chevron-right" class="size-4 text-default-400"></i></li>
                <li>
                    <a href="{{ route('frontend.produk.index') }}" class="hover:text-primary transition-colors">Produk</a>
                </li>
                <li><i data-lucide="chevron-right" class="size-4 text-default-400"></i></li>
                <li class="text-default-800 font-medium truncate max-w-xs">
                    {{ $produk->nama_produk ?? $produk->nama }}
                </li>
            </ol>
        </nav>

        @php
            // Format foto produk (Array / JSON string)
            $fotos = is_array($produk->foto_produk) 
                ? $produk->foto_produk 
                : (json_decode($produk->foto_produk, true) ?? []);
            
            $fotoUtama = $fotos[0] ?? null;
            $fotoGrid = array_slice($fotos, 1, 5); // Ambil hingga 5 foto tambahan untuk grid
        @endphp

        <div class="grid lg:grid-cols-3 grid-cols-1 lg:gap-5">
            <!-- Left Column: Gallery & Store Summary -->
            <div class="col-span-1">
                <div class="sticky top-24">
                    <div class="card mb-5 border border-default-200 rounded-xl overflow-hidden bg-white">
                        <div class="card-body p-4">
                            
                            <!-- Display Image Utama & Secondary Thumbnails -->
                            <div class="grid grid-cols-1 gap-3 mb-3">
                                <div class="rounded-md bg-default-100 overflow-hidden h-72 w-full flex items-center justify-center border border-default-150">
                                    @if($fotoUtama)
                                        <img id="mainImage" alt="{{ $produk->nama_produk ?? $produk->nama }}" src="{{ asset('storage/' . $fotoUtama) }}" class="h-full w-full object-cover"/>
                                    @else
                                        <img alt="Default Image" src="/images/logo-dekranasda.png" class="h-32 opacity-40"/>
                                    @endif
                                </div>
                            </div>

                            <!-- List Gallery Thumbnails -->
                            @if(count($fotos) > 1)
                                <div class="grid grid-cols-4 gap-2 mb-4">
                                    @foreach($fotos as $foto)
                                        <button type="button" onclick="changeMainImage('{{ asset('storage/' . $foto) }}')" class="rounded-md bg-default-100 h-16 overflow-hidden border border-default-200 hover:border-primary focus:border-primary transition-all">
                                            <img alt="Thumbnail" src="{{ asset('storage/' . $foto) }}" class="h-full w-full object-cover"/>
                                        </button>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            @php
                                $whatsappNumber = $produk->no_hp ?? $produk->umkm->no_hp ?? '628123456789';
                                $textWA = rawurlencode("Halo, saya berminat dengan produk '" . ($produk->nama_produk ?? $produk->nama) . "' di situs Dekranasda Tuban.");
                            @endphp

                            <div class="grid grid-cols-1 gap-2 mt-4">
                                <a target="_blank" href="https://wa.me/{{ $whatsappNumber }}?text={{ $textWA }}" 
                                   style="background: linear-gradient(135deg, #e60707 0%, #761b2f 100%) !important;"
                                   class="w-full rounded btn text-white hover:opacity-90 flex items-center justify-center gap-2 py-2.5 font-medium shadow-sm">
                                    <i class="size-4" data-lucide="message-circle"></i> Hubungi Penjual (WA)
                                </a>
                            </div>

                            <div class="flex items-center gap-3 mt-4 justify-evenly border-t border-default-150 pt-3">
                                <!-- Tombol Bagikan dengan Web Share API / WhatsApp Fallback -->
                                <button 
                                    type="button"
                                    onclick="shareProduct('{{ $produk->nama_produk ?? $produk->nama }}', '{{ url()->current() }}')"
                                    class="flex items-center gap-1.25 text-default-600 text-xs transition-all duration-300 hover:text-primary cursor-pointer">
                                    <i class="size-3.5" data-lucide="share-2"></i>
                                    <span class="align-middle">Bagikan</span>
                                </button>

                                <a class="flex items-center gap-1.25 text-default-600 text-xs transition-all duration-300 hover:text-primary" href="{{ route('frontend.produk.index') }}">
                                    <i class="size-3.5" data-lucide="arrow-left"></i>
                                    <span class="align-middle">Katalog Lainnya</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- UMKM / Store Info Card -->
                    <div class="card border border-default-200 rounded-xl overflow-hidden bg-white">
                        <div class="card-body p-4 border-b border-b-default-200">
                            <div class="flex justify-between items-center flex-wrap gap-2">
                                <h6 class="text-default-800 font-semibold text-[15px] flex items-center gap-1.25">
                                    <i class="size-4 text-primary" data-lucide="store"></i>
                                    
                                    @if(isset($produk->umkm_id) || isset($produk->umkm->umkm_id))
                                        <a href="{{ route('frontend.umkm.show', $produk->umkm_id ?? $produk->umkm->umkm_id) }}" 
                                        class="hover:text-primary transition-colors">
                                            {{ $produk->nama_umkm ?? $produk->umkm->nama_umkm ?? 'UMKM Kab. Tuban' }}
                                        </a>
                                    @else
                                        <span>{{ $produk->nama_umkm ?? $produk->umkm->nama_umkm ?? 'UMKM Kab. Tuban' }}</span>
                                    @endif
                                </h6>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="flex gap-2 justify-between items-center">
                                <h6 class="text-default-600 text-xs flex items-center gap-1.25">
                                    <i class="size-4 text-red-500" data-lucide="map-pin"></i>
                                    {{ $produk->kecamatan ?? 'Kabupaten Tuban' }}
                                </h6>
                                <span class="text-xs text-default-400 font-medium">Terverifikasi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Product Detail Content -->
            <div class="lg:col-span-2 col-span-1">
                <div class="card border border-default-200 rounded-xl bg-white">
                    <div class="card-body p-6">
                        
                        <!-- Header & Badges -->
                        <div class="flex justify-between items-center mb-2">
                            <span class="px-2.5 py-0.5 text-xs inline-block font-semibold rounded bg-red-50 text-red-600 border border-red-100 uppercase">
                                {{ $produk->nama_kategori ?? $produk->kategori->nama_kategori ?? 'Kerajinan' }}
                            </span>
                            
                            <div class="flex items-center gap-1 text-xs text-default-400">
                                <i class="size-3.5" data-lucide="eye"></i>
                                <span>{{ number_format($produk->views ?? 0, 0, ',', '.') }} Dilihat</span>
                            </div>
                        </div>

                        <!-- Product Title -->
                        <h1 class="mt-2 mb-2 text-2xl text-default-800 font-bold tracking-tight">
                            {{ $produk->nama_produk ?? $produk->nama }}
                        </h1>

                        <!-- Metadata -->
                        <ul class="flex flex-wrap text-xs items-center gap-4 mb-4 text-default-500 pb-3">
                            <li>Ditambahkan: <span class="font-medium text-default-700">{{ $produk->created_at ? $produk->created_at->format('d M Y') : '-' }}</span></li>
                        </ul>

                        <!-- Price Section -->
                        <div class="mb-6 p-4 rounded-xl bg-default-50 border border-default-150">
                            <p class="mb-0.5 text-xs text-default-400">Harga Resmi UMKM</p>
                            <h2 class="text-default-900 font-bold text-2xl md:text-3xl text-primary">
                                Rp {{ number_format($produk->harga ?? 0, 0, ',', '.') }}
                            </h2>
                        </div>


                        <!-- Product Description -->
                        <div class="mt-6 pt-6">
                            <h6 class="text-base font-semibold text-default-800 mb-3">Deskripsi Produk:</h6>
                            <div class="text-sm text-default-600 leading-relaxed whitespace-pre-line">
                                {!! nl2br(e($produk->deskripsi ?? 'Belum ada deskripsi lengkap untuk produk ini.')) !!}
                            </div>
                        </div>

                        <!-- Highlights / Guarantees -->
                        <div class="grid lg:grid-cols-2 grid-cols-1 gap-3 my-6 mt-6">
                            <div class="flex items-center gap-4 p-3.5 border rounded-lg border-default-200 bg-white">
                                <div class="flex items-center justify-center p-2 rounded-lg bg-default-100">
                                    <i class="size-5 text-primary" data-lucide="shield-check"></i>
                                </div>
                                <div class="text-default-700 text-xs">
                                    <h6 class="mb-0.5 text-default-800 font-semibold text-sm">Produk Lokal Asli</h6>
                                    <p class="text-default-500">Binaan Dekranasda Kabupaten Tuban</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 p-3.5 border rounded-lg border-default-200 bg-white">
                                <div class="flex items-center justify-center p-2 rounded-lg bg-default-100">
                                    <i class="size-5 text-primary" data-lucide="message-square"></i>
                                </div>
                                <div class="text-default-700 text-xs">
                                    <h6 class="mb-0.5 text-default-800 font-semibold text-sm">Respon Cepat</h6>
                                    <p class="text-default-500">Transaksi langsung ke kontak pengrajin</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products Section -->
        @if(isset($relatedProduks) && $relatedProduks->count() > 0)
            <div class="mt-16 pt-8 border-t border-default-200">
                <h3 class="text-xl font-bold text-default-800 mb-6">Produk Terkait Lainnya</h3>
                <div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-6">
                    @foreach($relatedProduks as $rel)
                        <div class="card bg-card hover:shadow-xl transition-all duration-300 rounded-xl border border-default-200 overflow-hidden flex flex-col justify-between group">
                            <div class="card-body p-4">
                                <!-- Image Container -->
                                <div class="relative overflow-hidden rounded-lg bg-default-100 h-52 w-full flex items-center justify-center">
                                    @php
                                        $fotos = is_array($rel->foto_produk) 
                                            ? $rel->foto_produk 
                                            : json_decode($rel->foto_produk, true);
                                        
                                        $fotoUtama = $fotos[0] ?? null;
                                    @endphp

                                    @if($fotoUtama)
                                        <img 
                                            src="{{ asset('storage/' . $fotoUtama) }}" 
                                            alt="{{ $rel->nama_produk ?? $rel->nama }}" 
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
                                    <div class="flex items-center justify-between gap-2 mb-1">
                                        @if(isset($rel->kategori) || isset($rel->nama_kategori))
                                            <span class="text-xs font-medium text-primary uppercase tracking-wider">
                                                {{ $rel->nama_kategori ?? $rel->kategori->nama_kategori ?? "-" }}
                                            </span>
                                        @else
                                            <span></span>
                                        @endif

                                        <!-- Indikator Views -->
                                        <div class="flex items-center gap-1 text-xs text-default-400">
                                            <i data-lucide="eye" class="size-3.5"></i>
                                            <span>{{ number_format($rel->views ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                    </div>

                                    <h3 class="text-lg font-semibold text-default-800 mt-1 line-clamp-1 hover:text-red-600 transition-colors">
                                        <a href="{{ route('frontend.produk.show', $rel->produk_id ?? $produk->id) }}">
                                            {{ $rel->nama_produk ?? $rel->nama }}
                                        </a>
                                    </h3>

                                    @if(isset($rel->deskripsi))
                                        <p class="text-sm text-default-500 mt-1 line-clamp-2">
                                            {{ Str::limit(strip_tags($rel->deskripsi ?? ''), 100, '...') ?: '-' }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Card Footer -->
                            <div class="px-4 pb-4 pt-2 border-t border-default-100 flex justify-between items-center mt-auto">
                                <div>
                                    <span class="text-xs text-default-400 block">Harga</span>
                                    <h4 class="text-base font-bold text-primary">
                                        Rp {{ number_format($rel->harga ?? 0, 0, ',', '.') }}
                                    </h4>
                                </div>

                                <a style="background: linear-gradient(135deg, #e60707 0%, #761b2f 100%) !important; color: #ffffff !important;"
                                    href="{{ route('frontend.produk.show', $rel->produk_id ?? $rel->id) }}" class="btn border-0 btn-sm rounded-md inline-flex items-center gap-1 shadow-sm cursor-pointer transition-opacity hover:opacity-90">
                                    Detail <i class="size-3.5" data-lucide="arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</section>

<!-- Script Switch Image -->
<script>
    function changeMainImage(src) {
        document.getElementById('mainImage').src = src;
    }

    function shareProduct(title, url) {
        // Cek apakah browser mendukung Web Share API (Mobile & Chrome/Safari modern)
        if (navigator.share) {
            navigator.share({
                title: title,
                text: 'Lihat produk menarik ini di Dekranasda Tuban: ' + title,
                url: url,
            })
            .then(() => console.log('Berhasil dibagikan'))
            .catch((error) => console.log('Gagal membagikan:', error));
        } else {
            // Fallback jika dibuka di browser desktop tua: Langsung share ke WhatsApp Web & Salin Link
            const textWA = encodeURIComponent(`Lihat produk "${title}" di Dekranasda Tuban:\n${url}`);
            const waUrl = `https://api.whatsapp.com/send?text=${textWA}`;
            
            // Buka WhatsApp di tab baru
            window.open(waUrl, '_blank');
        }
    }
</script>
@endsection