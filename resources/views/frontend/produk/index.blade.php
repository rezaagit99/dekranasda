@extends('frontend.layout.base-layout', ['title' => 'Semua Produk'])

@section('css')
@endsection

@section('content')

    <section class="relative w-full overflow-hidden bg-slate-100 pt-20 lg:pt-28" id="home">
        <div class="container mx-auto px-4">
            
            <!-- Header & Counter -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                {{-- <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-default-800 tracking-tight">
                        Semua Produk UMKM
                    </h1>
                    <p class="text-sm text-default-500 mt-1">
                        Jelajahi berbagai produk unggulan karya kerajinan dan kuliner lokal.
                    </p>
                </div> --}}

                <div class="text-center max-w-2xl mx-auto">
                    <h1 class="text-3xl md:text-4xl font-semibold text-default-800 mb-2">
                        Semua Produk UMKM
                    </h1>
                    <p class="text-default-500 text-sm md:text-base">    
                        Jelajahi berbagai produk unggulan karya kerajinan dan kuliner lokal.
                    </p>
                </div>


                {{-- @if(isset($produks) && $produks->count() > 0)
                    <span class="text-xs font-medium px-3.5 py-1.5 rounded-full bg-default-100 text-default-600 w-fit self-start md:self-auto">
                        Menampilkan {{ $produks->firstItem() }} - {{ $produks->lastItem() }} dari {{ $produks->total() }} produk
                    </span>
                @endif --}}
            </div>

            <!-- Filter & Search Bar -->
            <form method="GET" action="{{ route('frontend.produk.index') }}" class="mb-8 grid grid-cols-1 md:grid-cols-4 gap-4">
                
                <!-- Search Input dengan Icon Di Dalam -->
                <div class="md:col-span-2 relative flex items-center">
                    
                    <!-- Padding kiri dinaikkan ke pl-11 agar ada ruang aman setelah ikon -->
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ request('q') }}" 
                        placeholder="Cari produk..." 
                        class="w-full pl-11 pr-4 py-2.5 rounded-lg border border-default-200 text-sm focus:outline-none focus:border-red-600 bg-white"
                    />
                </div>

                <!-- Select Kategori -->
                <div>
                    <select name="kategori" onchange="this.form.submit()" class="w-full py-2.5 px-3 rounded-lg border border-default-200 text-sm focus:outline-none focus:border-red-600 text-default-700 bg-white">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->kategori_id ?? $kat->id }}" {{ request('kategori') == ($kat->kategori_id ?? $kat->id) ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sorting Dropdown -->
                <div>
                    <select name="sort" onchange="this.form.submit()" class="w-full py-2.5 px-3 rounded-lg border border-default-200 text-sm focus:outline-none focus:border-red-600 text-default-700 bg-white">
                        <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="harga_low" {{ request('sort') == 'harga_low' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                        <option value="harga_high" {{ request('sort') == 'harga_high' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                        <option value="terpopuler" {{ request('sort') == 'terpopuler' ? 'selected' : '' }}>Terpopuler (Views)</option>
                    </select>
                </div>
            </form>

            <!-- Grid Produk -->
            @if(isset($produks) && $produks->count() > 0)
                <div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-6">
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
                    <!-- Gantilah div pagination lama dengan ini -->
                    {{ $produks->withQueryString()->links('vendor.pagination.custom') }}
                </div>

            @else
                <!-- Fallback Kosong -->
                <div class="text-center py-16 bg-default-100 rounded-2xl border border-dashed border-default-300">
                    <i class="size-12 text-default-400 mx-auto mb-3" data-lucide="package-open"></i>
                    <h3 class="text-lg font-semibold text-default-700">Tidak Ada Produk Ditemukan</h3>
                    <p class="text-sm text-default-500">Coba ubah kata kunci atau filter pencarian Anda.</p>
                </div>
            @endif

        </div>
    </section>

@endsection