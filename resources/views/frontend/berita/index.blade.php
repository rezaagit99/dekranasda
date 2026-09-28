@extends('frontend.layout.base-layout', ['title' => 'Berita'])

@section('css')
@endsection

@section('content')

    <section class="relative w-full overflow-hidden bg-slate-100 pt-20 lg:pt-28" id="home">

        <div class="container mx-auto px-4">
            <div class="flex flex-col gap-y-10">
                
                <!-- Header Section (Center) -->
                <div class="text-center max-w-2xl mx-auto">
                    <h1 class="text-3xl md:text-4xl font-semibold text-default-800 mb-2">
                       Berita Terbaru
                    </h1>
                    <p class="text-default-500 text-sm md:text-base">
                        Dukungan penuh Dekranasda Kabupaten Tuban untuk mendorong pertumbuhan dan daya saing UMKM lokal.
                    </p>
                </div>

            <!-- Grid Berita (3 Kolom x 3 Baris) -->
            @if(isset($beritas) && $beritas->count() > 0)
                <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-6 mt-5">
                    @foreach($beritas as $berita)
                        @php
                            $tglBerita = \Carbon\Carbon::parse($berita->published_at ?? $berita->created_at);
                            $gambar = $berita->gambar_cover ? asset('storage/' . $berita->gambar_cover) : asset('assets/images/placeholder-news.jpg');
                            $urlDetail = route('frontend.berita.show', $berita->slug ?? $berita->berita_id);
                        @endphp

                        <div class="card bg-white dark:bg-default-50 shadow-lg shadow-black/20 hover:-translate-y-1 transition-all duration-300 rounded-2xl border border-default-200 overflow-hidden flex flex-col justify-between group">
                            <div class="card-body p-4">
                                
                                <!-- Container Gambar Berita -->
                                <div class="relative overflow-hidden rounded-xl h-48 w-full bg-slate-100 dark:bg-default-200">
                                    <img src="{{ $gambar }}" 
                                        alt="{{ $berita->judul }}" 
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
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
                                        <a href="{{ $urlDetail }}" title="{{ $berita->judul }}">
                                            {{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($berita->judul)), 60, '...') }}
                                        </a>
                                    </h3>

                                    <!-- Ringkasan / Excerpt (Menggunakan kolom ringkasan atau fallback ke isi) -->
                                    <p class="text-xs text-default-500 mt-2 line-clamp-2 leading-relaxed">
                                        {{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($berita->ringkasan ?? $berita->isi)), 110, '...', true) }}
                                    </p>
                                </div>
                            </div>

                            <!-- Footer Link / Read More -->
                            <div class="px-4 pb-4 pt-3 border-t border-default-100 mt-auto">
                                <a href="{{ $urlDetail }}" 
                                class="inline-flex items-center gap-1 text-xs font-bold text-primary hover:gap-2 transition-all">
                                    Baca Selengkapnya
                                    <i data-lucide="chevron-right" class="size-3.5"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination Container -->
                <div class="mt-10 flex justify-center">
                    {{ $beritas->withQueryString()->links() }}
                </div>
            @else
                <!-- Fallback Kosong -->
                <div class="text-center py-12 bg-white/10 backdrop-blur-md rounded-2xl border border-dashed border-white/30 max-w-2xl mx-auto">
                    <i class="size-12 text-white/70 mx-auto mb-3" data-lucide="newspaper"></i>
                    <h3 class="text-lg font-semibold text-white">Belum Ada Berita</h3>
                    <p class="text-sm text-white/80">Berita dan artikel terbaru akan ditampilkan di sini.</p>
                </div>
            @endif
        </div>
    </section>
@endsection