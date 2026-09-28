@extends('frontend.layout.base-layout', ['title' => $umkm->nama_umkm])

@section('css')
@endsection

@section('content')
    <section class="relative w-full overflow-hidden bg-slate-100 pt-20 lg:pt-28">
        <div class="container mx-auto px-4 max-w-7xl">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- SISI KIRI: Detail Profil UMKM (4 Kolom pada Desktop) -->
                <div class="card lg:col-span-3 bg-white p-5 rounded-2xl border border-default-200 shadow-sm sticky top-28">
    
                    <!-- Foto Header / Sampul UMKM -->
                    <div class="relative overflow-hidden rounded-xl bg-default-100 h-52 w-full flex items-center justify-center mb-5">
                        @if($umkm->foto_umkm)
                            <img src="{{ asset('storage/' . $umkm->foto_umkm) }}" 
                                alt="{{ $umkm->nama_umkm }}" 
                                class="h-full w-full object-cover">
                        @else
                            <div class="flex flex-col items-center justify-center text-default-400">
                                <i data-lucide="store" class="size-16 mb-2 opacity-30"></i>
                                <span class="text-xs">Foto UMKM Tidak Tersedia</span>
                            </div>
                        @endif
                    </div>

                    <!-- 1. NAMA UMKM -->
                    <h1 class="text-2xl font-bold text-default-800 tracking-tight mb-4">
                        {{ $umkm->nama_umkm }}
                    </h1>

                    <div class="space-y-4 pt-4 border-t border-default-100 text-sm">
                        
                            <!-- Nama Pemilik (dari tabel users) -->
                        @if($umkm->user)
                            <div class="flex items-center gap-3">
                                <i data-lucide="user" class="size-4 text-red-500 flex-shrink-0"></i>
                                <div>
                                    <span class="text-xs text-slate-400 block">Pemilik Usaha</span>
                                    <span class="font-medium text-slate-800">{{ $umkm->user->name }}</span>
                                </div>
                            </div>

                            <!-- Nomor Telepon Pemilik (dari tabel users) -->
                            @if($umkm->user->no_telp)
                                <div class="flex items-center gap-3">
                                    <i data-lucide="phone" class="size-4 text-red-500 flex-shrink-0"></i>
                                    <div>
                                        <span class="text-xs text-slate-400 block">No. Telepon / WhatsApp</span>
                                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $umkm->user->no_telp)) }}" 
                                        target="_blank" 
                                        class="font-medium text-red-600 hover:underline">
                                            {{ $umkm->user->no_telp }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endif

                        <!-- 4. ALAMAT -->
                        @if($umkm->alamat)
                            <div class="flex items-start gap-3">
                                <i data-lucide="map-pin" class="size-4 text-primary mt-0.5 flex-shrink-0"></i>
                                <div>
                                    <span class="text-xs text-default-400 block font-medium">Alamat Usaha</span>
                                    <span class="text-default-700 leading-relaxed">{{ $umkm->alamat }}</span>
                                </div>
                            </div>
                        @endif
                        
                    </div>

                    <!-- 5. DESKRIPSI UMKM -->
                    @if($umkm->deskripsi)
                        <div class="mt-6 pt-4 border-t border-default-100">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-default-400 mb-2">
                                Tentang Usaha
                            </h3>
                            <p class="text-sm text-default-600 leading-relaxed whitespace-pre-line">
                                {{ $umkm->deskripsi }}
                            </p>
                        </div>
                    @endif

                    <!-- TOMBOL HUBUNGI VIA WHATSAPP (Opsional jika telepon tersedia) -->
                    @if($umkm->user && $umkm->user->no_telp)
                        <div class="mt-6">
                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $umkm->user->no_telp)) }}" 
                            target="_blank" 
                            class="w-full py-2.5 px-4 rounded-lg text-white font-medium text-xs flex items-center justify-center gap-2 shadow-sm transition-opacity hover:opacity-90"
                            style="background: linear-gradient(135deg, #e60707 0%, #761b2f 100%) !important;">
                                <i data-lucide="message-circle" class="size-4"></i> Hubungi Pemilik
                            </a>
                        </div>
                    @endif

                </div>

                <!-- SISI KANAN: Grid Produk UMKM (8 Kolom pada Desktop) -->
                <div class="lg:col-span-9" style="padding-left: 20px">
                    <div class="flex items-center justify-between gap-4 mb-2 pb-4">
                        <div>
                            <h2 class="text-xl font-bold text-slate-800">
                                Produk UMKM
                            </h2>
                            <p class="text-xs text-slate-500 mt-1">
                                Katalog produk dari {{ $umkm->nama_umkm }}
                            </p>
                        </div>

                        @if(isset($produks) && $produks->count() > 0)
                            <span class="text-xs font-semibold px-3 py-1.5 rounded-full bg-slate-200/70 text-slate-600">
                                Total {{ $produks->total() }} Produk
                            </span>
                        @endif
                    </div>

                    <!-- Grid 9 Produk (3x3) -->
                    @if(isset($produks) && $produks->count() > 0)
                        <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-6">
                            @foreach($produks as $produk)
                                <div class="card bg-card hover:shadow-xl transition-all duration-300 rounded-xl border border-default-200 overflow-hidden flex flex-col justify-between group">
                                    <div class="card-body p-4">
                                        <!-- Image Container -->
                                        <div class="relative overflow-hidden rounded-lg bg-default-100 h-52 w-full flex items-center justify-center">
                                            @php
                                                $fotos = is_array($produk->foto_produk) 
                                                    ? $produk->foto_produk 
                                                    : json_decode($produk->foto_produk, true);
                                                
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
                                                <a href="{{ route('frontend.produk.show', $produk->produk_id ?? $produk->id) }}">
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

                                    <!-- Card Footer -->
                                    <div class="px-4 pb-4 pt-2 border-t border-default-100 flex justify-between items-center mt-auto">
                                        <div>
                                            <span class="text-xs text-default-400 block">Harga</span>
                                            <h4 class="text-base font-bold text-primary">
                                                Rp {{ number_format($produk->harga ?? 0, 0, ',', '.') }}
                                            </h4>
                                        </div>

                                        <a style="background: linear-gradient(135deg, #e60707 0%, #761b2f 100%) !important; color: #ffffff !important;"
                                            href="{{ route('frontend.produk.show', $produk->produk_id ?? $produk->id) }}" class="btn border-0 btn-sm rounded-md inline-flex items-center gap-1 shadow-sm cursor-pointer transition-opacity hover:opacity-90">
                                            Detail <i class="size-3.5" data-lucide="arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Links Pagination Berangka -->
                        <div class="mt-10 flex justify-center">
                            {{ $produks->withQueryString()->links('vendor.pagination.custom') }}
                        </div>

                    @else
                        <!-- Fallback Kosong -->
                        <div class="text-center py-16 bg-default-100 rounded-2xl border border-dashed border-default-300">
                            <i class="size-12 text-default-400 mx-auto mb-3" data-lucide="package-open"></i>
                            <h3 class="text-lg font-semibold text-default-700">Tidak Ada Produk Ditemukan</h3>
                            <p class="text-sm text-default-500">UMKM ini belum memiliki katalog produk terdaftar.</p>
                        </div>
                    @endif
                </div>

            </div>

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