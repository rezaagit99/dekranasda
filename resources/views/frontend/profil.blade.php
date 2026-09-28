@extends('frontend.layout.base-layout', ['title' => 'Semua Produk'])

@section('css')
@endsection

@section('content')

    <section class="relative w-full overflow-hidden bg-slate-100 pt-20 lg:pt-28">

    <div class="container mx-auto px-4 max-w-6xl">
        <!-- Header Section -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h1 class="text-3xl md:text-4xl font-bold text-slate-800 tracking-tight mb-2 mt-6">
                Dekranasda Kabupaten Tuban
            </h1>
            <p class="text-slate-500 text-sm md:text-base leading-relaxed">
                Mengenal lebih dekat visi, misi, dan struktur organisasi dalam mendorong potensi kerajinan lokal serta pemberdayaan UMKM daerah.
            </p>
        </div>

        <!-- Visi Section (Featured Card) -->
        <div class="bg-white rounded-2xl p-8 md:p-10 mb-10 relative overflow-hidden">
            <!-- Decorative Accent Bar -->
            <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-red-600 to-red-800"></div>

            <div class="flex flex-col md:flex-row gap-6 md:gap-10 items-start">
                <div class="md:w-1/4 flex-shrink-0">
                    <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Visi Kami</h2>
                </div>
                <div class="md:w-3/4 text-slate-600 text-base md:text-lg leading-relaxed font-normal whitespace-pre-line border-t md:border-t-0 md:border-l border-slate-100 pt-4 md:pt-0 md:pl-8">
                    {{ $profil->visi ?? 'Visi belum diisi.' }}
                </div>
            </div>
        </div>

        <!-- Misi Section (Grid Clean Cards) -->
        <div class="bg-white rounded-2xl p-8 md:p-10 mb-10 relative overflow-hidden">
            <!-- Decorative Accent Bar -->
            <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-red-600 to-red-800"></div>

            <div class="flex flex-col md:flex-row gap-6 md:gap-10 items-start">
                <div class="md:w-1/4 flex-shrink-0">
                    <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Misi Kami</h2>
                </div>
                <div class="md:w-3/4 text-slate-600 text-base md:text-lg leading-relaxed font-normal whitespace-pre-line border-t md:border-t-0 md:border-l border-slate-100 pt-4 md:pt-0 md:pl-8">
                    {{ $profil->misi ?? 'Visi belum diisi.' }}
                </div>
            </div>
        </div>

        <!-- Struktur Organisasi Section -->
        <div class="bg-white rounded-2xl p-8 md:p-10">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 pb-6">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Struktur Kepengurusan</h2>
                </div>
            </div>

            <div class="rounded-xl bg-slate-50/50 p-3 md:p-6 text-center">
                @if(isset($profil) && $profil->foto_struktur)
                    <img src="{{ asset('storage/' . $profil->foto_struktur) }}" 
                         alt="Struktur Organisasi Dekranasda Tuban" 
                         class="w-full h-auto object-contain max-h-[700px] mx-auto rounded-lg shadow-sm">
                @else
                    <div class="py-16 text-slate-400 flex flex-col items-center justify-center">
                        <i data-lucide="image-off" class="size-10 mb-3 opacity-40"></i>
                        <p class="text-xs md:text-sm font-medium">Bagan struktur organisasi belum diunggah.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</section>

@endsection