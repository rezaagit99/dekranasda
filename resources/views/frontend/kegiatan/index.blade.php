@extends('frontend.layout.base-layout', ['title' => 'Agenda & Kegiatan'])

@section('css')
@endsection

@section('content')
    <section class="relative w-full overflow-hidden bg-slate-100 pt-20 lg:pt-28">
        <div class="container mx-auto px-4">
            <div class="flex flex-col gap-y-10">
                
                <!-- Header Section (Center) -->
                <div class="text-center max-w-2xl mx-auto">
                    <h1 class="text-3xl md:text-4xl font-semibold text-default-800 mb-2">
                        Agenda & Kegiatan
                    </h1>
                    <p class="text-default-500 text-sm md:text-base">
                        Jadwal pameran, pelatihan, dan acara mendatang Dekranasda Kabupaten Tuban.
                    </p>
                </div>

                <!-- Grid Container (4 Kolom per Baris di Desktop, Total 3 Baris = 12 Items) -->
                @if(isset($kegiatans) && $kegiatans->count() > 0)
                    <!-- Grid 3 Kolom pada Layar Large/Desktop (lg:grid-cols-3) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4 mb-4">
                        @foreach($kegiatans->take(9) as $kegiatan)
                            @php
                                $tgl = \Carbon\Carbon::parse($kegiatan->tanggal_mulai);
                                $waktuMulai = $kegiatan->waktu_mulai ? \Carbon\Carbon::parse($kegiatan->waktu_mulai)->format('H:i') : null;
                                $waktuSelesai = $kegiatan->waktu_selesai ? \Carbon\Carbon::parse($kegiatan->waktu_selesai)->format('H:i') : null;
                            @endphp
                            
                            <div class="card bg-white rounded-xl border border-default-200 hover:border-primary/50 hover:shadow-lg transition-all duration-300 w-full flex flex-col justify-between">
                                <div class="card-body p-5 flex flex-col h-full">
                                    
                                    <!-- Header Card: Box Tanggal + Badge & Jam -->
                                    <div class="flex items-start gap-4 mb-3">
                                        <!-- Box Tanggal Minimalis -->
                                        <div class="size-16 rounded-xl bg-red-500/10 dark:bg-red-500/20 text-red-600 dark:text-red-400 flex flex-col items-center justify-center shrink-0 border border-red-500/20">
                                            <span class="text-xl font-black leading-none">
                                                {{ $tgl->format('d') }}
                                            </span>
                                            <span class="text-xs font-bold uppercase mt-1 tracking-wider">
                                                {{ $tgl->translatedFormat('M') }}
                                            </span>
                                        </div>

                                        <!-- Badge & Jam -->
                                        <div class="min-w-0 text-left flex-1">
                                            <div class="flex gap-2 mb-1 flex-wrap items-center">
                                                <span class="px-2 py-0.5 text-[10px] font-bold rounded bg-primary/10 text-primary capitalize">
                                                    {{ $kegiatan->penyelenggara ?? $kegiatan->kategori->nama ?? 'Dekranasda' }}
                                                </span>
                                                <span class="text-xs text-default-400 flex items-center gap-1">
                                                    <i data-lucide="clock" class="size-3.5 shrink-0"></i>
                                                    @if($waktuMulai && $waktuSelesai)
                                                        {{ $waktuMulai }} - {{ $waktuSelesai }} WIB
                                                    @elseif($waktuMulai)
                                                        {{ $waktuMulai }} WIB - Selesai
                                                    @else
                                                        {{ $kegiatan->jam ?? '08:00 WIB' }}
                                                    @endif
                                                </span>
                                            </div>

                                            <h3 class="text-base font-bold text-default-800 line-clamp-2 hover:text-primary transition-colors">
                                                <a href="" title="{{ $kegiatan->nama_kegiatan }}">
                                                    {{ Str::limit(strip_tags($kegiatan->nama_kegiatan ?? ''), 30, '...') ?: '-' }}
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
                        @endforeach
                    </div>
                @else
                    <!-- Fallback Kosong -->
                    <div class="card p-8 text-center rounded-xl border border-default-200 max-w-2xl mx-auto">
                        <i data-lucide="calendar-x" class="size-10 text-default-400 mx-auto mb-2"></i>
                        <p class="text-default-500 text-sm">Belum ada agenda kegiatan mendatang.</p>
                    </div>
                @endif

                <!-- Pagination Container (Tengah Bawah) -->
                <div class="mt-10 flex justify-center">
                    {{ $kegiatans->withQueryString()->links('vendor.pagination.custom') }}
                </div>

            </div>
        </div>
    </section>
@endsection