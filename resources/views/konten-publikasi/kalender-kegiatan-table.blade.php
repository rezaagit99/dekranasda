<table class="min-w-full divide-y divide-default-200">
    <thead class="bg-default-150">
        <tr class="text-sm font-normal text-default-700 whitespace-nowrap">
            <th class="px-3.5 py-3 text-center" scope="col">Aksi</th>
            <th class="px-3.5 py-3 text-start" scope="col">Nama Kegiatan</th>
            <th class="px-3.5 py-3 text-start" scope="col">Penyelenggara</th>
            <th class="px-3.5 py-3 text-start" scope="col">Tanggal & Waktu</th>
            <th class="px-3.5 py-3 text-start" scope="col">Lokasi</th>
            <th class="px-3.5 py-3 text-start" scope="col">Status</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-default-200">
        @forelse($kegiatanList as $index => $item)
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
                                class="btn-edit-kegiatan flex items-center gap-1.5 py-1.5 px-3 text-xs font-medium text-default-500 hover:bg-default-150 rounded w-full text-start"
                                data-hs-overlay="#editKegiatanModal"
                                data-action="{{ route('publikasi.kalender.update', $item->kegiatan_id) }}"
                                data-nama_kegiatan="{{ $item->nama_kegiatan }}"
                                data-deskripsi="{{ $item->deskripsi }}"
                                data-tanggal_mulai="{{ $item->tanggal_mulai ? \Carbon\Carbon::parse($item->tanggal_mulai)->format('Y-m-d') : '' }}"
                                data-tanggal_selesai="{{ $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('Y-m-d') : '' }}"
                                data-waktu_mulai="{{ $item->waktu_mulai }}"
                                data-waktu_selesai="{{ $item->waktu_selesai }}"
                                data-lokasi="{{ $item->lokasi }}"
                                data-penyelenggara="{{ $item->penyelenggara }}"
                                data-status="{{ $item->status }}">
                            <i class="size-3" data-lucide="edit"></i> Edit
                        </button>

                            <!-- Tombol Delete -->
                            <button type="button" 
                                    class="flex items-center gap-1.5 py-1.5 px-3 text-xs font-medium text-danger hover:bg-danger/10 rounded w-full text-start"
                                    onclick="confirmDeleteKegiatan('{{ route('publikasi.kalender.destroy', $item->kegiatan_id) }}', '{{ addslashes($item->nama_kegiatan) }}')">
                                <i class="size-3" data-lucide="trash-2"></i> Delete
                            </button>
                        </div>
                    </div>
                </td>

                <!-- Nama Kegiatan & Deskripsi -->
                <td class="py-3 px-3.5 max-w-sm">
                    <div class="overflow-hidden">
                        <h6 class="mb-0.5 font-semibold truncate">
                            <a class="text-default-800 hover:text-primary" href="#!" title="{{ $item->nama_kegiatan }}">
                                {{ $item->nama_kegiatan }}
                            </a>
                        </h6>
                        <p class="text-xs text-default-400 truncate" title="{{ $item->deskripsi }}">
                            {{ $item->deskripsi ?? '/kegiatan/' . $item->slug }}
                        </p>
                    </div>
                </td>

                <!-- Penyelenggara -->
                <td class="py-3 px-3.5">
                    <div class="flex items-center gap-1.5">
                        <i class="size-3.5 text-default-400" data-lucide="building-2"></i>
                        <span class="font-medium text-default-700">{{ $item->penyelenggara ?? '-' }}</span>
                    </div>
                </td>

                <!-- Tanggal & Waktu -->
                <td class="py-3 px-3.5">
                    <div class="flex flex-col">
                        <span class="font-medium text-default-700">
                            {{ $item->tanggal_mulai ? $item->tanggal_mulai->format('d M, Y') : '-' }}
                            @if($item->tanggal_selesai && $item->tanggal_selesai->ne($item->tanggal_mulai))
                                - {{ $item->tanggal_selesai->format('d M, Y') }}
                            @endif
                        </span>
                        <span class="text-xs text-default-400 flex items-center gap-1 mt-0.5">
                            <i class="size-3" data-lucide="clock"></i>
                            {{ $item->waktu_mulai ? substr($item->waktu_mulai, 0, 5) : '00:00' }} 
                            {{ $item->waktu_selesai ? '- ' . substr($item->waktu_selesai, 0, 5) : '' }} WIB
                        </span>
                    </div>
                </td>

                <!-- Lokasi -->
                <td class="py-3 px-3.5 max-w-xs">
                    <div class="flex items-center gap-1.5 text-default-600">
                        <i class="size-3.5 text-default-400 shrink-0" data-lucide="map-pin"></i>
                        <span class="truncate" title="{{ $item->lokasi }}">{{ $item->lokasi ?? '-' }}</span>
                    </div>
                </td>

                <!-- Status Badge -->
                <td class="px-3.5 py-3">
                    @switch(strtolower($item->status))
                        @case('berlangsung')
                            <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-primary/10 text-primary rounded">
                                <i class="size-3" data-lucide="play-circle"></i>
                                Berlangsung
                            </span>
                            @break
                        @case('mendatang')
                            <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-info/10 text-info rounded">
                                <i class="size-3" data-lucide="calendar"></i>
                                Mendatang
                            </span>
                            @break
                        @case('selesai')
                            <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-success/10 text-success rounded">
                                <i class="size-3" data-lucide="check-circle-2"></i>
                                Selesai
                            </span>
                            @break
                        @case('dibatalkan')
                            <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-danger/10 text-danger rounded">
                                <i class="size-3" data-lucide="x-circle"></i>
                                Dibatalkan
                            </span>
                            @break
                        @default
                            <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-default-100 text-default-500 rounded">
                                {{ ucfirst($item->status ?? 'Mendatang') }}
                            </span>
                    @endswitch
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center py-6 text-default-500">
                    Belum ada data kegiatan.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- Form Hidden untuk Delete Global -->
<form id="global-delete-form" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>