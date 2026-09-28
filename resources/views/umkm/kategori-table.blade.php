<table class="min-w-full divide-y divide-default-200">
    <thead class="bg-default-150">
        <tr class="text-sm font-normal text-default-700 whitespace-nowrap">
            <th class="px-3.5 py-3 text-center" scope="col">Aksi</th>
            <th class="px-3.5 py-3 text-start" scope="col">Nama Kategori</th>
            <th class="px-3.5 py-3 text-start" scope="col">Slug</th>
            <th class="px-3.5 py-3 text-start" scope="col">Deskripsi</th>
            <th class="px-3.5 py-3 text-start" scope="col">Tanggal Dibuat</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-default-200">
        @forelse($kategoriList as $index => $kategori)
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
                            <!-- Tombol Edit (Single Modal via Data Attributes) -->
                            <button type="button" 
                                class="btn-edit-kategori flex items-center gap-1.5 py-1.5 px-3 text-xs font-medium text-default-500 hover:bg-default-150 rounded w-full text-start"
                                data-action="{{ route('umkm.kategori.update', $kategori->kategori_id) }}"
                                data-nama_kategori="{{ $kategori->nama_kategori }}"
                                data-deskripsi="{{ e(str_replace(["\r", "\n"], ' ', $kategori->deskripsi)) }}"
                                data-hs-overlay="#editKategoriModal">
                                <i class="size-3" data-lucide="edit"></i> Edit
                            </button>

                            <!-- Tombol Delete -->
                            <button type="button" 
                                    class="flex items-center gap-1.5 py-1.5 px-3 text-xs font-medium text-danger hover:bg-danger/10 rounded w-full text-start"
                                    onclick="confirmDeleteKategori('{{ route('umkm.kategori.destroy', $kategori->kategori_id) }}', '{{ addslashes($kategori->nama_kategori) }}')">
                                <i class="size-3" data-lucide="trash-2"></i> Delete
                            </button>
                        </div>
                    </div>
                </td>

                <!-- Nama Kategori -->
                <td class="py-3 px-3.5 max-w-sm">
                    <div class="flex items-center gap-3">
                        <div class="overflow-hidden">
                            <h6 class="mb-0.5 font-semibold truncate">
                                <a class="text-default-800 hover:text-primary" href="#!" title="{{ $kategori->nama_kategori }}">
                                    {{ $kategori->nama_kategori }}
                                </a>
                            </h6>
                        </div>
                    </div>
                </td>

                <!-- Slug -->
                <td class="py-3 px-3.5">
                    <span class="py-0.5 px-2.5 inline-flex items-center text-xs font-medium bg-default-100 text-default-600 rounded">
                        {{ $kategori->slug }}
                    </span>
                </td>

                <!-- Deskripsi -->
                <td class="py-3 px-3.5 max-w-xs truncate text-default-600" title="{{ $kategori->deskripsi }}">
                    {{ $kategori->deskripsi ?? '-' }}
                </td>

                <!-- Tanggal Dibuat -->
                <td class="py-3 px-3.5 text-default-600">
                    {{ $kategori->created_at ? $kategori->created_at->format('d M, Y H:i') : '-' }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center py-6 text-default-500">
                    Belum ada data kategori.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>