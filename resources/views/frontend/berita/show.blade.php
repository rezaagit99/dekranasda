@extends('frontend.layout.base-layout', ['title' => $berita->judul])

@section('css')
@endsection

@section('content')
    <section class="relative py-12 md:py-16 bg-slate-50 dark:bg-default-100">
        <div class="container mx-auto px-4 max-w-7xl">
            
            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center gap-2 text-xs text-default-400 mb-4">
                <a href="{{ url('/') }}" class="hover:text-primary transition-colors">Beranda</a>
                <i data-lucide="chevron-right" class="size-3.5"></i>
                <a href="{{ route('frontend.berita.index') }}" class="hover:text-primary transition-colors">Berita</a>
                <i data-lucide="chevron-right" class="size-3.5"></i>
                <span class="text-default-700 font-medium truncate max-w-[200px] sm:max-w-xs">{{ $berita->judul }}</span>
            </nav>

            <!-- Layout 2 Kolom: Content (8) + Sidebar (4) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- KOLOM KIRI: Detail Berita Utama (Col 8) -->
                <div class="lg:col-span-8">
                    <div class="bg-white dark:bg-default-50 rounded-2xl p-6 sm:p-8 shadow-sm border border-default-200">
                        
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-default-900 leading-tight mb-4">
                            {{ $berita->judul }}
                        </h1>

                        <!-- Meta Info (Tanggal & Views) -->
                        <div class="flex items-center gap-6 text-xs sm:text-sm text-default-500 pb-6">
                            @php
                                $tglBerita = \Carbon\Carbon::parse($berita->published_at ?? $berita->created_at)->locale('id');
                            @endphp
                            <div class="flex items-center gap-1.5">
                                <i data-lucide="calendar" class="size-4 text-primary"></i>
                                <span>{{ $tglBerita->translatedFormat('l, d F Y') }}</span>
                            </div>

                            <div class="flex items-center gap-1.5">
                                <i data-lucide="eye" class="size-4 text-primary"></i>
                                <span>{{ number_format($berita->views ?? 0, 0, ',', '.') }} Dilihat</span>
                            </div>
                        </div>

                        <!-- Cover Image -->
                        @if($berita->gambar_cover)
                            <div class="mb-2 mt-2 my-6 overflow-hidden rounded-xl bg-slate-100 dark:bg-default-200 max-h-[450px]">
                                <img src="{{ asset('storage/' . $berita->gambar_cover) }}" 
                                     alt="{{ $berita->judul }}" 
                                     class="w-full h-full object-cover">
                            </div>
                        @endif

                        <!-- Isi Berita Utama -->
                        <div class="prose prose-sm sm:prose max-w-none text-default-700 leading-relaxed dark:prose-invert" 
                             style="text-align: justify !important;">
                            <style>
                                .prose-content-berita * {
                                    text-align: justify !important;
                                }
                                .prose-content-berita p {
                                    margin-bottom: 1rem !important;
                                }
                            </style>
                            <div class="prose-content-berita">
                                {!! $berita->isi !!}
                            </div>
                        </div>

                        <!-- Footer Artikel: Bagikan -->
                        <div class="mt-8 pt-6 border-t border-default-200 flex flex-col sm:flex-row items-center justify-between gap-4">

                            <div class="flex items-center gap-2">
                                <span class="text-xs text-default-400 font-medium">Bagikan:</span>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                                   target="_blank" 
                                   class="size-8 rounded-lg bg-blue-600/10 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all">
                                    <i data-lucide="facebook" class="size-4"></i>
                                </a>
                                <a href="https://api.whatsapp.com/send?text={{ urlencode($berita->judul . ' ' . url()->current()) }}" 
                                   target="_blank" 
                                   class="size-8 rounded-lg bg-emerald-600/10 text-emerald-600 flex items-center justify-center hover:bg-emerald-600 hover:text-white transition-all">
                                    <i data-lucide="message-circle" class="size-4"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- KOLOM KANAN: Sidebar Berita Populer (Col 4) -->
                <div class="lg:col-span-4 ml-1" >
                    <div class="bg-white dark:bg-default-50 rounded-2xl p-6 shadow-sm border border-default-200 sticky top-24">
                        
                        <!-- Header Sidebar -->
                        <div class="flex items-center justify-between pb-4 mb-4 border-b border-default-200">
                            <h3 class="text-lg font-bold text-default-900 flex items-center gap-2">
                                <i data-lucide="trending-up" class="size-5 text-primary"></i>
                                Berita Populer
                            </h3>
                        </div>

                        <!-- List 3 Berita Populer -->
                        @if(isset($beritaPopuler) && $beritaPopuler->count() > 0)
                            <div class="flex flex-col gap-4">
                                @foreach($beritaPopuler as $populer)
                                    @php
                                        $tglPopuler = \Carbon\Carbon::parse($populer->published_at ?? $populer->created_at)->locale('id');
                                        $imgPopuler = $populer->gambar_cover ? asset('storage/' . $populer->gambar_cover) : asset('assets/images/placeholder-news.jpg');
                                        $urlPopuler = route('frontend.berita.show', $populer->slug ?? $populer->berita_id);
                                    @endphp

                                    <div class="flex items-start gap-3 group">
                                        <!-- Thumbnail -->
                                        <a href="{{ $urlPopuler }}" class="shrink-0 size-20 rounded-xl overflow-hidden bg-slate-100 dark:bg-default-200">
                                            <img src="{{ $imgPopuler }}" 
                                                 alt="{{ $populer->judul }}" 
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                        </a>

                                        <!-- Detail berita populer -->
                                        <div class="flex-1 min-w-0">
                                            <span class="text-[10px] text-default-400 flex items-center gap-1 mb-1">
                                                <i data-lucide="calendar" class="size-3 text-primary"></i>
                                                {{ $tglPopuler->translatedFormat('d M Y') }}
                                            </span>

                                            <h4 class="text-xs sm:text-sm font-semibold text-default-800 line-clamp-2 group-hover:text-primary transition-colors leading-snug">
                                                <a href="{{ $urlPopuler }}" title="{{ $populer->judul }}">
                                                    {{ $populer->judul }}
                                                </a>
                                            </h4>

                                            <span class="text-[11px] text-default-400 flex items-center gap-1 mt-1">
                                                <i data-lucide="eye" class="size-3 text-default-400"></i>
                                                {{ number_format($populer->views ?? 0, 0, ',', '.') }} views
                                            </span>
                                        </div>
                                    </div>

                                    @if(!$loop->last)
                                        <hr class="border-default-100 my-1">
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-default-400 text-center py-4">Belum ada berita populer.</p>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection