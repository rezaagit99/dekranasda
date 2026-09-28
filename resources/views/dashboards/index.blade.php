@extends('layouts.vertical', ['title' => 'Dashboard'])

@section('content')
    {{-- Header Halaman --}}
    @include('layouts.partials/page-title', ['subtitle' => 'Dashboards', 'title' => 'Overview'])

    <div class="card-body relative overflow-hidden bg-zinc-900 rounded-md mb-5">
        <div class="relative z-10 grid grid-cols-12 items-center">
            <div class="lg:col-span-8 col-span-12">
                <h5 class="mb-3 text-lg text-white">Selamat Datang {{ Auth::user()->name }} 🎉</h5>
                <p class="mb-5 text-white/70 text-sm">
                    @if (Auth::user()->role_id == 3)
                        Tambahkan produk unggulan Anda ke etalase digital Dekranasda. Pastikan nomor WhatsApp yang terdaftar selalu aktif untuk menerima pemesanan dari pengunjung.
                    @else
                        Kelola katalog produk kerajinan lokal dan pantau data pengrajin binaan. Seluruh promosi produk terhubung langsung ke WhatsApp masing-masing pembuat produk.
                    @endif
                </p>
                @if(auth()->user()->role_id === 1)
                    <a href="{{ route('umkm.umkm.index') }}" class="btn bg-primary text-white">
                        Update UMKM
                    </a>
                @elseif(auth()->user()->role_id === 3)
                    <a href="{{ route('umkm.produk.index') }}" class="btn bg-primary text-white">
                        Update Produk
                    </a>
                @endif
            </div>
            <div class="col-span-4 ms-auto lg:block hidden">
                <img alt="" class="h-40" src="/images/dashboard.png" />
            </div>
        </div>
        <div class="absolute inset-0">
            <svg class="size-full" preserveaspectratio="none" version="1.1" viewbox="0 0 1440 560"
                xmlns="http://www.w3.org/2000/svg" xmlns:svgjs="http://svgjs.dev/svgjs"
                xmlns:xlink="http://www.w3.org/1999/xlink">
                <g fill="none" mask='url("#SvgjsMask1000")'>
                    <use x="0" xlink:href="#SvgjsSymbol1007" y="0"></use>
                    <use x="720" xlink:href="#SvgjsSymbol1007" y="0"></use>
                </g>
                <defs>
                    <mask id="SvgjsMask1000">
                        <rect fill="#ffffff" height="560" width="1440"></rect>
                    </mask>
                    <path d="M-1 0 a1 1 0 1 0 2 0 a1 1 0 1 0 -2 0z" id="SvgjsPath1003"></path>
                    <path d="M-3 0 a3 3 0 1 0 6 0 a3 3 0 1 0 -6 0z" id="SvgjsPath1004"></path>
                    <path d="M-5 0 a5 5 0 1 0 10 0 a5 5 0 1 0 -10 0z" id="SvgjsPath1001"></path>
                    <path d="M2 -2 L-2 2z" id="SvgjsPath1005"></path>
                    <path d="M6 -6 L-6 6z" id="SvgjsPath1002"></path>
                    <path d="M30 -30 L-30 30z" id="SvgjsPath1006"></path>
                </defs>
                <symbol id="SvgjsSymbol1007">
                    <use stroke="rgba(32, 43, 61, 1)" x="30" xlink:href="#SvgjsPath1001" y="30"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="30" xlink:href="#SvgjsPath1002" y="90"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="30" xlink:href="#SvgjsPath1001" y="150"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="30" xlink:href="#SvgjsPath1003" y="210"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="30" xlink:href="#SvgjsPath1002" y="270"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="30" xlink:href="#SvgjsPath1001" y="330"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="30" xlink:href="#SvgjsPath1002" y="390"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="30" xlink:href="#SvgjsPath1003" y="450"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="30" xlink:href="#SvgjsPath1001" y="510"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="30" xlink:href="#SvgjsPath1002" y="570"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="90" xlink:href="#SvgjsPath1001" y="30"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="90" xlink:href="#SvgjsPath1003" y="90"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="90" xlink:href="#SvgjsPath1001" y="150"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="90" xlink:href="#SvgjsPath1001" y="210"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="90" xlink:href="#SvgjsPath1004" y="270"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="90" xlink:href="#SvgjsPath1003" y="330"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="90" xlink:href="#SvgjsPath1001" y="390"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="90" xlink:href="#SvgjsPath1001" y="450"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="90" xlink:href="#SvgjsPath1001" y="510"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="90" xlink:href="#SvgjsPath1002" y="570"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="150" xlink:href="#SvgjsPath1002" y="30"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="150" xlink:href="#SvgjsPath1005" y="90"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="150" xlink:href="#SvgjsPath1002" y="150"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="150" xlink:href="#SvgjsPath1005" y="210"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="150" xlink:href="#SvgjsPath1005" y="270"></use>
                    <use stroke="rgba(32, 43, 61, 1)" stroke-width="3" x="150" xlink:href="#SvgjsPath1006" y="330">
                    </use>
                    <use stroke="rgba(32, 43, 61, 1)" x="150" xlink:href="#SvgjsPath1004" y="390"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="150" xlink:href="#SvgjsPath1002" y="450"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="150" xlink:href="#SvgjsPath1001" y="510"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="150" xlink:href="#SvgjsPath1001" y="570"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="210" xlink:href="#SvgjsPath1002" y="30"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="210" xlink:href="#SvgjsPath1002" y="90"></use>
                    <use stroke="rgba(32, 43, 61, 1)" stroke-width="3" x="210" xlink:href="#SvgjsPath1006"
                        y="150"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="210" xlink:href="#SvgjsPath1002" y="210"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="210" xlink:href="#SvgjsPath1001" y="270"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="210" xlink:href="#SvgjsPath1005" y="330"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="210" xlink:href="#SvgjsPath1001" y="390"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="210" xlink:href="#SvgjsPath1002" y="450"></use>
                    <use stroke="rgba(32, 43, 61, 1)" stroke-width="3" x="210" xlink:href="#SvgjsPath1006"
                        y="510"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="210" xlink:href="#SvgjsPath1003" y="570"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="270" xlink:href="#SvgjsPath1002" y="30"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="270" xlink:href="#SvgjsPath1005" y="90"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="270" xlink:href="#SvgjsPath1001" y="150"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="270" xlink:href="#SvgjsPath1002" y="210"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="270" xlink:href="#SvgjsPath1005" y="270"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="270" xlink:href="#SvgjsPath1001" y="330"></use>
                    <use stroke="rgba(32, 43, 61, 1)" stroke-width="3" x="270" xlink:href="#SvgjsPath1006"
                        y="390"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="270" xlink:href="#SvgjsPath1002" y="450"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="270" xlink:href="#SvgjsPath1005" y="510"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="270" xlink:href="#SvgjsPath1005" y="570"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="330" xlink:href="#SvgjsPath1002" y="30"></use>
                    <use stroke="rgba(32, 43, 61, 1)" stroke-width="3" x="330" xlink:href="#SvgjsPath1006"
                        y="90"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="330" xlink:href="#SvgjsPath1002" y="150"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="330" xlink:href="#SvgjsPath1002" y="210"></use>
                    <use stroke="rgba(32, 43, 61, 1)" stroke-width="3" x="330" xlink:href="#SvgjsPath1006"
                        y="270"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="330" xlink:href="#SvgjsPath1001" y="330"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="330" xlink:href="#SvgjsPath1002" y="390"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="330" xlink:href="#SvgjsPath1001" y="450"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="330" xlink:href="#SvgjsPath1003" y="510"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="330" xlink:href="#SvgjsPath1001" y="570"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="390" xlink:href="#SvgjsPath1004" y="30"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="390" xlink:href="#SvgjsPath1005" y="90"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="390" xlink:href="#SvgjsPath1002" y="150"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="390" xlink:href="#SvgjsPath1005" y="210"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="390" xlink:href="#SvgjsPath1001" y="270"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="390" xlink:href="#SvgjsPath1002" y="330"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="390" xlink:href="#SvgjsPath1002" y="390"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="390" xlink:href="#SvgjsPath1003" y="450"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="390" xlink:href="#SvgjsPath1002" y="510"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="390" xlink:href="#SvgjsPath1001" y="570"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="450" xlink:href="#SvgjsPath1001" y="30"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="450" xlink:href="#SvgjsPath1004" y="90"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="450" xlink:href="#SvgjsPath1002" y="150"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="450" xlink:href="#SvgjsPath1001" y="210"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="450" xlink:href="#SvgjsPath1002" y="270"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="450" xlink:href="#SvgjsPath1001" y="330"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="450" xlink:href="#SvgjsPath1001" y="390"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="450" xlink:href="#SvgjsPath1002" y="450"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="450" xlink:href="#SvgjsPath1001" y="510"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="450" xlink:href="#SvgjsPath1001" y="570"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="510" xlink:href="#SvgjsPath1002" y="30"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="510" xlink:href="#SvgjsPath1003" y="90"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="510" xlink:href="#SvgjsPath1005" y="150"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="510" xlink:href="#SvgjsPath1005" y="210"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="510" xlink:href="#SvgjsPath1002" y="270"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="510" xlink:href="#SvgjsPath1004" y="330"></use>
                    <use stroke="rgba(32, 43, 61, 1)" stroke-width="3" x="510" xlink:href="#SvgjsPath1006"
                        y="390"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="510" xlink:href="#SvgjsPath1001" y="450"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="510" xlink:href="#SvgjsPath1002" y="510"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="510" xlink:href="#SvgjsPath1002" y="570"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="570" xlink:href="#SvgjsPath1005" y="30"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="570" xlink:href="#SvgjsPath1002" y="90"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="570" xlink:href="#SvgjsPath1001" y="150"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="570" xlink:href="#SvgjsPath1001" y="210"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="570" xlink:href="#SvgjsPath1001" y="270"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="570" xlink:href="#SvgjsPath1001" y="330"></use>
                    <use stroke="rgba(32, 43, 61, 1)" stroke-width="3" x="570" xlink:href="#SvgjsPath1006"
                        y="390"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="570" xlink:href="#SvgjsPath1005" y="450"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="570" xlink:href="#SvgjsPath1001" y="510"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="570" xlink:href="#SvgjsPath1002" y="570"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="630" xlink:href="#SvgjsPath1002" y="30"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="630" xlink:href="#SvgjsPath1005" y="90"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="630" xlink:href="#SvgjsPath1005" y="150"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="630" xlink:href="#SvgjsPath1002" y="210"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="630" xlink:href="#SvgjsPath1001" y="270"></use>
                    <use stroke="rgba(32, 43, 61, 1)" stroke-width="3" x="630" xlink:href="#SvgjsPath1006"
                        y="330"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="630" xlink:href="#SvgjsPath1002" y="390"></use>
                    <use stroke="rgba(32, 43, 61, 1)" stroke-width="3" x="630" xlink:href="#SvgjsPath1006"
                        y="450"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="630" xlink:href="#SvgjsPath1001" y="510"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="630" xlink:href="#SvgjsPath1005" y="570"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="690" xlink:href="#SvgjsPath1001" y="30"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="690" xlink:href="#SvgjsPath1005" y="90"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="690" xlink:href="#SvgjsPath1002" y="150"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="690" xlink:href="#SvgjsPath1002" y="210"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="690" xlink:href="#SvgjsPath1005" y="270"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="690" xlink:href="#SvgjsPath1001" y="330"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="690" xlink:href="#SvgjsPath1003" y="390"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="690" xlink:href="#SvgjsPath1003" y="450"></use>
                    <use stroke="rgba(32, 43, 61, 1)" stroke-width="3" x="690" xlink:href="#SvgjsPath1006"
                        y="510"></use>
                    <use stroke="rgba(32, 43, 61, 1)" x="690" xlink:href="#SvgjsPath1003" y="570"></use>
                </symbol>
            </svg>
        </div>
    </div>

    {{-- ==================== STATISTIC CARDS ==================== --}}
    <div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-5 mb-5">
        {{-- ROLE SUPERADMIN --}}
        @if(auth()->user()->role_id === 1)
            <div class="card p-4">
                <div class="flex items-center justify-center mx-auto rounded-full size-14 bg-primary/10 mb-3">
                    <i class="size-6 text-primary" data-lucide="store"></i>
                </div>
                <h5 class="text-center font-semibold text-lg text-default-800">{{ $totalUmkm }}</h5>
                <p class="text-center text-sm text-default-500">Total UMKM</p>
            </div>

            <div class="card p-4">
                <div class="flex items-center justify-center mx-auto rounded-full size-14 bg-info/10 mb-3">
                    <i class="size-6 text-info" data-lucide="package"></i>
                </div>
                <h5 class="text-center font-semibold text-lg text-default-800">{{ $totalProduk }}</h5>
                <p class="text-center text-sm text-default-500">Total Produk</p>
            </div>

            <div class="card p-4">
                <div class="flex items-center justify-center mx-auto rounded-full size-14 bg-warning/10 mb-3">
                    <i class="size-6 text-warning" data-lucide="layers"></i>
                </div>
                <h5 class="text-center font-semibold text-lg text-default-800">{{ $totalKategori }}</h5>
                <p class="text-center text-sm text-default-500">Total Kategori</p>
            </div>

            <div class="card p-4">
                <div class="flex items-center justify-center mx-auto rounded-full size-14 bg-success/10 mb-3">
                    <i class="size-6 text-success" data-lucide="users"></i>
                </div>
                <h5 class="text-center font-semibold text-lg text-default-800">{{ $totalUser }}</h5>
                <p class="text-center text-sm text-default-500">Total User</p>
            </div>

        {{-- ROLE EDITOR --}}
        @elseif(auth()->user()->role_id === 2)
            <div class="card p-4">
                <div class="flex items-center justify-center mx-auto rounded-full size-14 bg-primary/10 mb-3">
                    <i class="size-6 text-primary" data-lucide="newspaper"></i>
                </div>
                <h5 class="text-center font-semibold text-lg text-default-800">{{ $totalBerita }}</h5>
                <p class="text-center text-sm text-default-500">Total Berita</p>
            </div>

            <div class="card p-4">
                <div class="flex items-center justify-center mx-auto rounded-full size-14 bg-info/10 mb-3">
                    <i class="size-6 text-info" data-lucide="calendar"></i>
                </div>
                <h5 class="text-center font-semibold text-lg text-default-800">{{ $totalKegiatan }}</h5>
                <p class="text-center text-sm text-default-500">Total Kegiatan</p>
            </div>

            <div class="card p-4">
                <div class="flex items-center justify-center mx-auto rounded-full size-14 bg-success/10 mb-3">
                    <i class="size-6 text-success" data-lucide="image"></i>
                </div>
                <h5 class="text-center font-semibold text-lg text-default-800">{{ $totalFoto }}</h5>
                <p class="text-center text-sm text-default-500">Total Galeri Foto</p>
            </div>

            <div class="card p-4">
                <div class="flex items-center justify-center mx-auto rounded-full size-14 bg-danger/10 mb-3">
                    <i class="size-6 text-danger" data-lucide="video"></i>
                </div>
                <h5 class="text-center font-semibold text-lg text-default-800">{{ $totalVideo }}</h5>
                <p class="text-center text-sm text-default-500">Total Galeri Video</p>
            </div>

        {{-- ROLE UMKM --}}
        @elseif(auth()->user()->role_id === 3)
            <div class="card p-4">
                <div class="flex items-center justify-center mx-auto rounded-full size-14 bg-primary/10 mb-3">
                    <i class="size-6 text-primary" data-lucide="package"></i>
                </div>
                <h5 class="text-center font-semibold text-lg text-default-800">{{ $totalProdukSaya }}</h5>
                <p class="text-center text-sm text-default-500">Total Produk Saya</p>
            </div>

            <div class="card p-4">
                <div class="flex items-center justify-center mx-auto rounded-full size-14 bg-success/10 mb-3">
                    <i class="size-6 text-success" data-lucide="check-circle"></i>
                </div>
                <h5 class="text-center font-semibold text-lg text-default-800">{{ $totalProdukAktif }}</h5>
                <p class="text-center text-sm text-default-500">Produk Tayang</p>
            </div>

            <div class="card p-4">
                <div class="flex items-center justify-center mx-auto rounded-full size-14 bg-danger/10 mb-3">
                    <i class="size-6 text-danger" data-lucide="x-circle"></i>
                </div>
                <h5 class="text-center font-semibold text-lg text-default-800">{{ $totalProdukTidakAktif }}</h5>
                <p class="text-center text-sm text-default-500">Produk Tidak Tayang</p>
            </div>

            <div class="card p-4">
                <div class="flex items-center justify-center mx-auto rounded-full size-14 bg-info/10 mb-3">
                    <i class="size-6 text-info" data-lucide="user-check"></i>
                </div>
                <h5 class="text-center font-semibold text-lg text-default-800">Aktif</h5>
                <p class="text-center text-sm text-default-500">Status Profil UMKM</p>
            </div>
        @endif
    </div> 

    {{-- ==================== TABEL PRODUK TERBARU ==================== --}}
    <div class="grid grid-cols-1 gap-5 mb-5">
        <div class="card">
            <div class="card-header flex justify-between items-center">
                <h6 class="card-title">Produk Terbaru</h6>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-default-200">
                    <thead class="bg-default-150">
                        <tr class="text-sm font-normal text-default-700 whitespace-nowrap">
                            <th class="px-3.5 py-3 text-start" scope="col">Produk</th>
                            <th class="px-3.5 py-3 text-start" scope="col">UMKM Pemilik</th>
                            <th class="px-3.5 py-3 text-start" scope="col">Harga</th>
                            <th class="px-3.5 py-3 text-start" scope="col">Deskripsi</th>
                            <th class="px-3.5 py-3 text-start" scope="col">Tanggal Dibuat</th>
                            <th class="px-3.5 py-3 text-start" scope="col">Status Stok</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-default-200">
                        @forelse($produks as $produk)
                            <tr class="text-default-800 text-sm">

                                {{-- Produk (Foto + Nama) --}}
                                <td class="px-3.5 py-2.5 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        @php
                                            $fotos = is_array($produk->foto_produk) ? $produk->foto_produk : json_decode($produk->foto_produk, true);
                                            $fotoUtama = $fotos[0] ?? null;
                                        @endphp

                                        @if ($fotoUtama)
                                            <img src="{{ asset('storage/' . $fotoUtama) }}" alt="{{ $produk->nama_produk }}" class="size-10 rounded-md object-cover">
                                        @else
                                            <div class="size-10 rounded-md bg-default-200 flex items-center justify-center text-default-500">
                                                <i data-lucide="package" class="size-5"></i>
                                            </div>
                                        @endif
                                        <span class="font-medium text-default-800">{{ $produk->nama_produk }}</span>
                                    </div>
                                </td>

                                {{-- UMKM Pemilik --}}
                                <td class="px-3.5 py-2.5 whitespace-nowrap">
                                    {{ $produk->umkm->nama_umkm ?? '-' }}
                                </td>

                                {{-- Harga --}}
                                <td class="px-3.5 py-2.5 whitespace-nowrap font-medium">
                                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </td>

                                {{-- Deskripsi --}}
                                <td class="px-3.5 py-2.5">
                                    <span class="line-clamp-1 max-w-xs" title="{{ $produk->deskripsi }}">
                                        {{ $produk->deskripsi ?? '-' }}
                                    </span>
                                </td>

                                {{-- Tanggal Dibuat --}}
                                <td class="px-3.5 py-2.5 whitespace-nowrap">
                                    {{ $produk->created_at ? $produk->created_at->translatedFormat('d M Y H:i') : '-' }}
                                </td>

                                {{-- Status Stok --}}
                                <td class="px-3.5 py-2.5 whitespace-nowrap">
                                    @if($produk->status === 'available')
                                        <span class="py-0.5 px-2.5 inline-flex items-center gap-1 rounded-full text-xs font-medium bg-success/10 text-success">
                                            <span class="size-1.5 rounded-full bg-success"></span>
                                            Tersedia
                                        </span>
                                    @else
                                        <span class="py-0.5 px-2.5 inline-flex items-center gap-1 rounded-full text-xs font-medium bg-danger/10 text-danger">
                                            <span class="size-1.5 rounded-full bg-danger"></span>
                                            Habis
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-3.5 py-6 text-center text-default-500">
                                    Belum ada data produk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @vite(['resources/js/pages/dashboard-ecommerce.js'])
@endsection