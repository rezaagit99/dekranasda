<table class="min-w-full divide-y divide-default-200">
    <thead class="bg-default-150">
        <tr class="text-sm font-normal text-default-700 whitespace-nowrap">
            <th class="px-3.5 py-3 text-center" scope="col">Aksi</th>
            <th class="px-3.5 py-3 text-start" scope="col">Berita</th>
            <th class="px-3.5 py-3 text-start" scope="col">Penulis</th>
            <th class="px-3.5 py-3 text-start" scope="col">Dilihat</th>
            <th class="px-3.5 py-3 text-start" scope="col">Tanggal Terbit</th>
            <th class="px-3.5 py-3 text-start" scope="col">Status</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-default-200">
        @forelse($beritaList as $index => $berita)
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
                            <!-- Tombol Edit -->
                            <button type="button" 
                                    class="btn-edit flex items-center gap-1.5 py-1.5 px-3 text-xs font-medium text-default-500 hover:bg-default-150 rounded w-full text-start"
                                    data-action="{{ route('publikasi.berita.update', $berita->berita_id) }}"
                                    data-judul="{{ $berita->judul }}"
                                    data-isi="{{ $berita->isi }}"
                                    data-status="{{ $berita->status }}"
                                    data-hs-overlay="#editBeritaModal">
                                <i class="size-3" data-lucide="edit"></i> Edit
                            </button>

                            <!-- Tombol Delete -->
                            <button type="button" 
                                    class="flex items-center gap-1.5 py-1.5 px-3 text-xs font-medium text-danger hover:bg-danger/10 rounded w-full text-start"
                                    onclick="confirmDeleteBerita('{{ route('publikasi.berita.destroy', $berita->berita_id) }}', '{{ addslashes($berita->judul) }}')">
                                <i class="size-3" data-lucide="trash-2"></i> Delete
                            </button>
                        </div>
                    </div>
                </td>

                <!-- Cover & Judul Berita -->
                <td class="py-3 px-3.5 max-w-sm">
                    <div class="flex items-center gap-3">
                        <div class="size-12 rounded bg-default-200 shrink-0 overflow-hidden">
                            <img alt="{{ $berita->judul }}" class="size-12 rounded object-cover" 
                                 src="{{ $berita->gambar_cover ? asset('storage/' . $berita->gambar_cover) : asset('images/default-news.png') }}"/>
                        </div>
                        <div class="overflow-hidden">
                            <h6 class="mb-0.5 font-semibold truncate">
                                <a class="text-default-800 hover:text-primary" href="#!" title="{{ $berita->judul }}">
                                    {{ $berita->judul }}
                                </a>
                            </h6>
                            <p class="text-xs text-default-400">/berita/{{ $berita->slug }}</p>
                        </div>
                    </div>
                </td>

                <!-- Penulis (Author) -->
                <td class="py-3 px-3.5">
                    <div class="flex items-center gap-1.5">
                        <i class="size-3.5 text-default-400" data-lucide="user"></i>
                        <span class="font-medium text-default-700">{{ $berita->author->name ?? 'Admin' }}</span>
                    </div>
                </td>

                <!-- Total Views -->
                <td class="py-3 px-3.5">
                    <span class="py-0.5 px-2 inline-flex items-center gap-x-1 text-xs font-medium bg-default-100 text-default-600 rounded">
                        <i class="size-3" data-lucide="eye"></i>
                        {{ number_format($berita->views ?? 0) }}
                    </span>
                </td>

                <!-- Tanggal Terbit -->
                <td class="py-3 px-3.5">
                    {{ $berita->published_at ? $berita->published_at->format('d M, Y H:i') : ($berita->created_at ? $berita->created_at->format('d M, Y') : '-') }}
                </td>

                <!-- Status Badge -->
                <td class="px-3.5 py-3">
                    @switch(strtolower($berita->status))
                        @case('published')
                            <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-success/10 text-success rounded">
                                <i class="size-3" data-lucide="check-circle-2"></i>
                                Published
                            </span>
                            @break
                        @case('draft')
                            <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-warning/10 text-warning rounded">
                                <i class="size-3" data-lucide="file-text"></i>
                                Draft
                            </span>
                            @break
                        @case('archived')
                            <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-default-200 text-default-600 rounded">
                                <i class="size-3" data-lucide="archive"></i>
                                Archived
                            </span>
                            @break

                        @default
                            <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-default-100 text-default-500 rounded">
                                {{ ucfirst($berita->status ?? 'Draft') }}
                            </span>
                    @endswitch
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center py-6 text-default-500">
                    Belum ada data berita.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>