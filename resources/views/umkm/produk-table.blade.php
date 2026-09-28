<table class="min-w-full divide-y divide-default-200">
    <thead class="bg-default-150">
        <tr class="text-sm font-normal text-default-700 whitespace-nowrap">
            <th class="px-3.5 py-3 text-center" scope="col">Aksi</th>
            <th class="px-3.5 py-3 text-start" scope="col">Produk</th>
            <th class="px-3.5 py-3 text-start" scope="col">UMKM Pemilik</th>
            <th class="px-3.5 py-3 text-start" scope="col">Harga</th>
            <th class="px-3.5 py-3 text-start" scope="col">Deskripsi</th>
            <th class="px-3.5 py-3 text-start" scope="col">Tanggal Dibuat</th>
            <th class="px-3.5 py-3 text-start" scope="col">Status Stok</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-default-200">
        @forelse($produkList as $index => $produk)
            @php
                // Ambil foto pertama untuk thumbnail, atau null jika tidak ada foto
                $firstFoto = is_array($produk->foto_produk) && count($produk->foto_produk) > 0 
                             ? $produk->foto_produk[0] 
                             : null;
                
                // Siapkan URL gambar thumbnail
                $imgSrc = $firstFoto ? asset('storage/' . $firstFoto) : asset('images/default-product.png');
            @endphp

            <tr class="text-default-800 font-normal text-sm whitespace-nowrap">
                <!-- Action Dropdown -->
                <td class="px-3.5 py-3 text-center">
                    <div class="hs-dropdown relative inline-flex">
                        <button aria-expanded="false" 
                                aria-haspopup="menu" 
                                aria-label="Dropdown"
                                class="hs-dropdown-toggle btn size-7.5 bg-default-200 hover:bg-default-600 text-default-500 hover:text-white rounded"
                                hs-dropdown-placement="bottom-end" 
                                type="button">
                            <i class="iconify lucide--ellipsis size-4"></i>
                        </button>

                        <div class="hs-dropdown-menu hidden z-10 min-w-32 bg-white shadow-md rounded p-1 text-start" role="menu">
                            <!-- Tombol Edit Produk -->
                            <button type="button" 
                                class="btn-edit-produk flex items-center gap-1.5 py-1.5 px-3 text-xs font-medium text-default-500 hover:bg-default-150 rounded w-full text-start"
                                data-action="{{ route('umkm.produk.update', $produk->produk_id) }}"
                                data-umkm_id="{{ $produk->umkm_id }}"
                                data-kategori_id="{{ $produk->kategori_id }}"
                                data-nama_produk="{{ $produk->nama_produk }}"
                                data-harga="{{ (int)$produk->harga }}"
                                data-deskripsi="{{ e(str_replace(["\r", "\n"], ' ', $produk->deskripsi)) }}"
                                data-status="{{ $produk->status }}"
                                data-views="{{ $produk->views }}"
                                {{-- Mengirimkan array foto versi JSON agar JS Modal Edit bisa menampilkan semua gambar --}}
                                data-fotos='@json($produk->foto_produk ?? [])'
                                data-preview="{{ $imgSrc }}"
                                data-hs-overlay="#editProdukModal">
                                <i class="size-3" data-lucide="edit"></i> Edit
                            </button>

                            <!-- Tombol Delete Produk -->
                            <button type="button" 
                                    class="flex items-center gap-1.5 py-1.5 px-3 text-xs font-medium text-danger hover:bg-danger/10 rounded w-full text-start"
                                    onclick="confirmDeleteProduk('{{ route('umkm.produk.destroy', $produk->produk_id) }}', '{{ addslashes($produk->nama_produk) }}')">
                                <i class="size-3" data-lucide="trash-2"></i> Delete
                            </button>
                        </div>
                    </div>
                </td>

                <!-- Foto & Nama Produk -->
                <td class="py-3 px-3.5 max-w-sm">
                    <div class="flex items-center gap-3">
                        <div class="relative size-12 rounded bg-default-200 shrink-0 overflow-hidden border border-default-200">
                            <!-- Foto Utama -->
                            <img alt="{{ $produk->nama_produk }}" class="size-12 rounded object-cover" 
                                 src="{{ $imgSrc }}"/>

                            <!-- Indicator jika foto lebih dari 1 -->
                            @if(is_array($produk->foto_produk) && count($produk->foto_produk) > 1)
                                <span class="absolute bottom-0 right-0 bg-black/70 text-white text-[9px] font-bold px-1 rounded-tl">
                                    +{{ count($produk->foto_produk) - 1 }}
                                </span>
                            @endif
                        </div>
                        <div class="overflow-hidden">
                            <h6 class="mb-0.5 font-semibold truncate">
                                <a class="text-default-800 hover:text-primary" href="#!" title="{{ $produk->nama_produk }}">
                                    {{ $produk->nama_produk }}
                                </a>
                            </h6>
                            <p class="text-xs text-default-400 truncate" title="{{ $produk->slug }}">
                                /produk/{{ $produk->slug }}
                            </p>
                        </div>
                    </div>
                </td>

                <!-- UMKM Pemilik (Relasi ke Model Umkm) -->
                <td class="py-3 px-3.5">
                    <div class="flex items-center gap-1.5">
                        <i class="size-3.5 text-default-400" data-lucide="store"></i>
                        <span class="font-medium text-default-700">{{ $produk->umkm->nama_umkm ?? '-' }}</span>
                    </div>
                </td>

                <!-- Harga Produk -->
                <td class="py-3 px-3.5 font-medium text-default-800">
                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                </td>

                <!-- Deskripsi Produk -->
                <td class="py-3 px-3.5 max-w-xs truncate" title="{{ $produk->deskripsi }}">
                    {{ Str::limit(strip_tags($produk->deskripsi ?? ''), 50, '...') ?: '-' }}
                </td>

                <!-- Tanggal Dibuat -->
                <td class="py-3 px-3.5">
                    {{ $produk->created_at ? $produk->created_at->format('d M, Y H:i') : '-' }}
                </td>

                <!-- Status Ketersediaan (enum: available, out_of_stock) -->
                <td class="px-3.5 py-3">
                    @switch(strtolower($produk->status))
                        @case('available')
                            <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-success/10 text-success rounded">
                                <i class="size-3" data-lucide="check-circle-2"></i>
                                Available
                            </span>
                            @break

                        @case('out_of_stock')
                            <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-danger/10 text-danger rounded">
                                <i class="size-3" data-lucide="x-circle"></i>
                                Out of Stock
                            </span>
                            @break

                        @default
                            <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-default-100 text-default-500 rounded">
                                {{ ucfirst($produk->status) }}
                            </span>
                    @endswitch
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center py-6 text-default-500">
                    Belum ada data produk.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>