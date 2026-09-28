<table class="min-w-full divide-y divide-default-200">
    <thead class="bg-default-150">
        <tr class="text-sm font-normal text-default-700 whitespace-nowrap">
            <th class="px-3.5 py-3 text-center" scope="col">Aksi</th>
            <th class="px-3.5 py-3 text-start" scope="col">Video</th>
            <th class="px-3.5 py-3 text-start" scope="col">Pengunggah</th>
            <th class="px-3.5 py-3 text-start" scope="col">Tanggal Unggah</th>
            <th class="px-3.5 py-3 text-start" scope="col">Status</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-default-200">
        @forelse($videoList as $video)
            <tr class="text-default-800 font-normal text-sm whitespace-nowrap">
                <!-- Action Dropdown -->
                <td class="px-3.5 py-3 text-center">
                    <div class="hs-dropdown relative inline-flex">
                        <button class="hs-dropdown-toggle btn size-7.5 bg-default-200 hover:bg-default-600 text-default-500 hover:text-white rounded" type="button">
                            <i class="iconify lucide--ellipsis size-4"></i>
                        </button>
                        <div class="hs-dropdown-menu hidden z-10 min-w-32 bg-white shadow-md rounded p-1 text-start">
                            <button type="button" 
                                    class="btn-edit flex items-center gap-1.5 py-1.5 px-3 text-xs font-medium text-default-500 hover:bg-default-150 rounded w-full text-start"
                                    data-action="{{ route('publikasi.video.update', $video->video_id) }}"
                                    data-judul="{{ $video->judul }}"
                                    data-deskripsi="{{ e(str_replace(["\r", "\n"], ' ', $video->deskripsi)) }}"
                                    data-url="{{ $video->url_youtube }}"
                                    data-status="{{ $video->status }}"
                                    data-hs-overlay="#editVideoModal">
                                <i class="size-3" data-lucide="edit"></i> Edit
                            </button>
                            <button type="button" 
                                    class="flex items-center gap-1.5 py-1.5 px-3 text-xs font-medium text-danger hover:bg-danger/10 rounded w-full text-start"
                                    onclick="confirmDeleteVideo('{{ route('publikasi.video.destroy', $video->video_id) }}', '{{ addslashes($video->judul) }}')">
                                <i class="size-3" data-lucide="trash-2"></i> Delete
                            </button>
                        </div>
                    </div>
                </td>

                <!-- Thumbnail Otomatis & Judul Video -->
                <td class="py-3 px-3.5 max-w-sm">
                    <div class="flex items-center gap-3">
                        <div class="size-12 rounded bg-default-200 shrink-0 overflow-hidden border border-default-200 relative group">
                            <!-- Thumbnail dari Accessor Model -->
                            <img alt="{{ $video->judul }}" class="size-12 rounded object-cover" src="{{ $video->thumbnail_url }}"/>
                            <a href="{{ $video->url_youtube }}" target="_blank" class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <i data-lucide="play-circle" class="size-5 text-white"></i>
                            </a>
                        </div>
                        <div class="overflow-hidden">
                            <h6 class="mb-0.5 font-semibold truncate">
                                <a class="text-default-800 hover:text-primary" href="{{ $video->url_youtube }}" target="_blank" title="{{ $video->judul }}">
                                    {{ $video->judul }}
                                </a>
                            </h6>
                            <p class="text-xs text-default-400 truncate" title="{{ $video->url_youtube }}">
                                {{ $video->url_youtube }}
                            </p>
                        </div>
                    </div>
                </td>

                <!-- Pengunggah -->
                <td class="py-3 px-3.5">
                    <div class="flex items-center gap-1.5">
                        <i class="size-3.5 text-default-400" data-lucide="user"></i>
                        <span class="font-medium text-default-700">{{ $video->author->name ?? 'Admin' }}</span>
                    </div>
                </td>

                <!-- Tanggal Unggah -->
                <td class="py-3 px-3.5">
                    {{ $video->created_at ? $video->created_at->format('d M, Y H:i') : '-' }}
                </td>

                <!-- Status Badge -->
                <td class="px-3.5 py-3">
                    @if(strtolower($video->status) === 'published')
                        <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-success/10 text-success rounded">
                            <i class="size-3" data-lucide="check-circle-2"></i> Published
                        </span>
                    @else
                        <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-default-200 text-default-600 rounded">
                            <i class="size-3" data-lucide="archive"></i> Archived
                        </span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center py-6 text-default-500">Belum ada data video.</td>
            </tr>
        @endforelse
    </tbody>
</table>