<table class="min-w-full divide-y divide-default-200">
    <thead class="bg-default-150">
        <tr class="text-sm font-normal text-default-700 whitespace-nowrap">
            <th class="px-3.5 py-3 text-center" scope="col">Aksi</th>
            <th class="px-3.5 py-3 text-start" scope="col">UMKM</th>
            <th class="px-3.5 py-3 text-start" scope="col">Pemilik</th>
            {{-- <th class="px-3.5 py-3 text-start" scope="col">Kategori</th> --}}
            <th class="px-3.5 py-3 text-start" scope="col">Alamat</th>
            <th class="px-3.5 py-3 text-start" scope="col">Tanggal Dibuat</th>
            <th class="px-3.5 py-3 text-start" scope="col">Status</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-default-200">
        @forelse($umkmList as $index => $umkm)
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
                                data-action="{{ route('umkm.umkm.update', $umkm->umkm_id) }}"
                                data-nama_umkm="{{ $umkm->nama_umkm }}"
                                {{-- data-kategori="{{ $umkm->kategori }}" --}}
                                data-alamat="{{ e(str_replace(["\r", "\n"], ' ', $umkm->alamat)) }}"
                                data-deskripsi="{{ e(str_replace(["\r", "\n"], ' ', $umkm->deskripsi)) }}"
                                data-status="{{ $umkm->status }}"
                                data-preview="{{ $umkm->foto_umkm ? asset('storage/' . $umkm->foto_umkm) : '' }}"
                                data-hs-overlay="#editUmkmModal">
                                <i class="size-3" data-lucide="edit"></i> Edit
                            </button>

                            <!-- Tombol Delete -->
                            <button type="button" 
                                    class="flex items-center gap-1.5 py-1.5 px-3 text-xs font-medium text-danger hover:bg-danger/10 rounded w-full text-start"
                                    onclick="confirmDeleteUmkm('{{ route('umkm.umkm.destroy', $umkm->umkm_id) }}', '{{ addslashes($umkm->nama_umkm) }}')">
                                <i class="size-3" data-lucide="trash-2"></i> Delete
                            </button>
                        </div>
                    </div>
                </td>

                <!-- Foto & Nama UMKM -->
                <td class="py-3 px-3.5 max-w-sm">
                    <div class="flex items-center gap-3">
                        <div class="size-12 rounded bg-default-200 shrink-0 overflow-hidden border border-default-200">
                            <img alt="{{ $umkm->nama_umkm }}" class="size-12 rounded object-cover" 
                                 src="{{ $umkm->foto_umkm ? asset('storage/' . $umkm->foto_umkm) : asset('images/default-store.png') }}"/>
                        </div>
                        <div class="overflow-hidden">
                            <h6 class="mb-0.5 font-semibold truncate">
                                <a class="text-default-800 hover:text-primary" href="#!" title="{{ $umkm->nama_umkm }}">
                                    {{ $umkm->nama_umkm }}
                                </a>
                            </h6>
                            <p class="text-xs text-default-400 truncate" title="{{ $umkm->deskripsi }}">
                                {{ $umkm->deskripsi ?? '/umkm/' . $umkm->slug }}
                            </p>
                        </div>
                    </div>
                </td>

                <!-- Pemilik / Penginput (User Relation) -->
                <td class="py-3 px-3.5">
                    <div class="flex items-center gap-1.5">
                        <i class="size-3.5 text-default-400" data-lucide="user"></i>
                        <span class="font-medium text-default-700">{{ $umkm->user->name ?? 'Admin' }}</span>
                    </div>
                </td>

                <!-- Kategori -->
                {{-- <td class="py-3 px-3.5">
                    <span class="py-0.5 px-2.5 inline-flex items-center text-xs font-medium bg-primary/10 text-primary rounded">
                        {{ $umkm->kategori ?? '-' }}
                    </span>
                </td> --}}

                <!-- Alamat -->
                <td class="py-3 px-3.5 max-w-xs truncate" title="{{ $umkm->alamat }}">
                    {{ $umkm->alamat ?? '-' }}
                </td>

                <!-- Tanggal Dibuat -->
                <td class="py-3 px-3.5">
                    {{ $umkm->created_at ? $umkm->created_at->format('d M, Y H:i') : '-' }}
                </td>

                <!-- Status Badge -->
                <td class="px-3.5 py-3">
                    @switch(strtolower($umkm->status))
                        @case('terverifikasi')
                        @case('disetujui')
                        @case('aktif')
                            <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-success/10 text-success rounded">
                                <i class="size-3" data-lucide="check-circle-2"></i>
                                Terverifikasi
                            </span>
                            @break

                        @case('menunggu')
                        @case('pending')
                            <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-warning/10 text-warning rounded">
                                <i class="size-3" data-lucide="clock"></i>
                                Menunggu
                            </span>
                            @break

                        @case('ditolak')
                            <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-danger/10 text-danger rounded">
                                <i class="size-3" data-lucide="x-circle"></i>
                                Ditolak
                            </span>
                            @break

                        @case('nonaktif')
                        @case('archived')
                            <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-default-200 text-default-600 rounded">
                                <i class="size-3" data-lucide="minus-circle"></i>
                                Nonaktif
                            </span>
                            @break

                        @default
                            <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-default-100 text-default-500 rounded">
                                <i class="size-3" data-lucide="help-circle"></i>
                                {{ ucfirst($umkm->status ?? 'Draft') }}
                            </span>
                    @endswitch
                </td>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center py-6 text-default-500">
                    Belum ada data UMKM.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>