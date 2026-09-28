<table class="min-w-full divide-y divide-default-200">
    <thead class="bg-default-150">
        <tr class="text-sm font-normal text-default-700 whitespace-nowrap">
            <th class="px-3.5 py-3 text-center" scope="col">Aksi</th>
            <th class="px-3.5 py-3 text-start" scope="col">Foto</th>
            <th class="px-3.5 py-3 text-start" scope="col">Pengunggah</th>
            <th class="px-3.5 py-3 text-start" scope="col">Tanggal Unggah</th>
            <th class="px-3.5 py-3 text-start" scope="col">Status</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-default-200">
        @forelse($fotoList as $index => $foto)
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
                                data-action="{{ route('publikasi.foto.update', $foto->foto_id) }}"
                                data-judul="{{ $foto->judul }}"
                                data-deskripsi="{{ e(str_replace(["\r", "\n"], ' ', $foto->deskripsi)) }}"
                                data-status="{{ $foto->status }}"
                                data-preview="{{ $foto->file_foto ? asset('storage/' . $foto->file_foto) : '' }}"
                                data-hs-overlay="#editFotoModal">
                            <i class="size-3" data-lucide="edit"></i> Edit
                        </button>

                            <!-- Tombol Delete -->
                            <button type="button" 
                                    class="flex items-center gap-1.5 py-1.5 px-3 text-xs font-medium text-danger hover:bg-danger/10 rounded w-full text-start"
                                    onclick="confirmDeleteFoto('{{ route('publikasi.foto.destroy', $foto->foto_id) }}', '{{ addslashes($foto->judul) }}')">
                                <i class="size-3" data-lucide="trash-2"></i> Delete
                            </button>
                        </div>
                    </div>
                </td>

                <!-- Thumbnail & Judul Foto -->
                <td class="py-3 px-3.5 max-w-sm">
                    <div class="flex items-center gap-3">
                        <div class="size-12 rounded bg-default-200 shrink-0 overflow-hidden border border-default-200">
                            <img alt="{{ $foto->judul }}" class="size-12 rounded object-cover" 
                                 src="{{ $foto->file_foto ? asset('storage/' . $foto->file_foto) : asset('images/default-image.png') }}"/>
                        </div>
                        <div class="overflow-hidden">
                            <h6 class="mb-0.5 font-semibold truncate">
                                <a class="text-default-800 hover:text-primary" href="#!" title="{{ $foto->judul }}">
                                    {{ $foto->judul }}
                                </a>
                            </h6>
                            <p class="text-xs text-default-400 truncate" title="{{ $foto->deskripsi }}">
                                {{ $foto->deskripsi ?? '/foto/' . $foto->slug }}
                            </p>
                        </div>
                    </div>
                </td>

                <!-- Pengunggah (Author) -->
                <td class="py-3 px-3.5">
                    <div class="flex items-center gap-1.5">
                        <i class="size-3.5 text-default-400" data-lucide="user"></i>
                        <span class="font-medium text-default-700">{{ $foto->author->name ?? 'Admin' }}</span>
                    </div>
                </td>

                <!-- Tanggal Unggah -->
                <td class="py-3 px-3.5">
                    {{ $foto->created_at ? $foto->created_at->format('d M, Y H:i') : '-' }}
                </td>

                <!-- Status Badge -->
                <td class="px-3.5 py-3">
                    @switch(strtolower($foto->status))
                        @case('published')
                            <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-success/10 text-success rounded">
                                <i class="size-3" data-lucide="check-circle-2"></i>
                                Published
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
                                {{ ucfirst($foto->status) }}
                            </span>
                    @endswitch
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center py-6 text-default-500">
                    Belum ada data foto.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>