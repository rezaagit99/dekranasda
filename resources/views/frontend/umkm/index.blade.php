@extends('frontend.layout.base-layout', ['title' => 'Semua Produk'])

@section('css')
@endsection

@section('content')

        <section class="relative w-full overflow-hidden bg-slate-100 pt-20 lg:pt-28">

        <div class="container mx-auto px-4 max-w-7xl">
            
            <!-- Header & Deskripsi -->
            <div class="text-center max-w-2xl mx-auto mb-12">
                <h1 class="text-3xl md:text-4xl font-bold text-slate-800 tracking-tight mb-2">
                    Daftar Pelaku UMKM
                </h1>
                <p class="text-slate-500 text-sm md:text-base">    
                    Mengenal para pelaku usaha mikro, kecil, dan menengah binaan Dekranasda Kabupaten Tuban.
                </p>
            </div>

            <!-- Grid UMKM -->
            @if(isset($umkms) && $umkms->count() > 0)
                <div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-6 mt-4">
                    @foreach($umkms as $umkm)
                        <a href="{{ route('frontend.umkm.show', $umkm->umkm_id) }}" 
                            class="card bg-card bg-white hover:shadow-xl transition-all duration-300 rounded-2xl overflow-hidden flex flex-col justify-between group cursor-pointer block">
                                
                                <div class="card-body p-4">
                                    <!-- Image Container -->
                                    <div class="relative overflow-hidden rounded-xl bg-slate-100 h-48 w-full flex items-center justify-center">
                                        @if($umkm->foto_umkm)
                                            <img 
                                                src="{{ asset('storage/' . $umkm->foto_umkm) }}" 
                                                alt="{{ $umkm->nama_umkm }}" 
                                                class="h-full w-full object-cover object-center group-hover:scale-105 transition-transform duration-300" 
                                            />
                                        @else
                                            <div class="flex flex-col items-center justify-center text-slate-400">
                                                <i data-lucide="store" class="size-12 mb-1 opacity-40"></i>
                                                <span class="text-xs">Foto tidak tersedia</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Content -->
                                    <div class="mt-4">
                                        <h3 class="text-lg font-bold text-slate-800 line-clamp-1 group-hover:text-red-600 transition-colors">
                                            {{ $umkm->nama_umkm }}
                                        </h3>

                                        <!-- Alamat UMKM -->
                                        @if($umkm->alamat)
                                            <div class="flex items-start gap-1.5 text-xs text-slate-500 mt-2">
                                                <i data-lucide="map-pin" class="size-3.5 flex-shrink-0 text-red-500 mt-0.5"></i>
                                                <span class="line-clamp-1">{{ $umkm->alamat }}</span>
                                            </div>
                                        @endif

                                        <!-- Deskripsi Singkat -->
                                        @if($umkm->deskripsi)
                                            <p class="text-xs text-slate-500 mt-2.5 line-clamp-2 leading-relaxed">
                                                {{ Str::limit(strip_tags($umkm->deskripsi), 90, '...') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </a>
                    @endforeach
                </div>

                <!-- Links Pagination -->
                <div class="mt-12 flex justify-center">
                    {{ $umkms->withQueryString()->links('vendor.pagination.custom') }}
                </div>

            @else
                <!-- Fallback Kosong -->
                <div class="text-center py-16 bg-white rounded-2xl border border-dashed border-slate-300 max-w-2xl mx-auto shadow-sm">
                    <i class="size-12 text-slate-300 mx-auto mb-3" data-lucide="store"></i>
                    <h3 class="text-base font-bold text-slate-700">Belum Ada UMKM Terdaftar</h3>
                    <p class="text-xs text-slate-500 mt-1">Data pelaku UMKM saat ini belum tersedia.</p>
                </div>
            @endif

        </div>
    </section>

@endsection