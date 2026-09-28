<table class="min-w-full divide-y divide-default-200">
    <thead class="bg-default-150">
        <tr class="text-sm font-normal text-default-700 whitespace-nowrap">
            <th class="px-3.5 py-3 text-center" scope="col">Aksi</th>
            <th class="px-3.5 py-3 text-start" scope="col">Nama</th>
            <th class="px-3.5 py-3 text-start" scope="col">Email</th>
            <th class="px-3.5 py-3 text-start" scope="col">Alamat</th>
            <th class="px-3.5 py-3 text-start" scope="col">Nomor Telp</th>
            <th class="px-3.5 py-3 text-start" scope="col">Instagram</th>
            <th class="px-3.5 py-3 text-start" scope="col">Role</th>
            <th class="px-3.5 py-3 text-start" scope="col">Tanggal Dibuat</th>
            <th class="px-3.5 py-3 text-start" scope="col">Status</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-default-200">
        @forelse($users as $index => $user)
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
                                    data-action="{{ route('manajemen-user.update', $user->id) }}"
                                    data-name="{{ $user->name }}"
                                    data-email="{{ $user->email }}"
                                    data-role="{{ $user->role_id }}"
                                    data-status="{{ $user->status }}"
                                    data-umkm="{{ $user->umkm_id }}"
                                    data-no_telp="{{ $user->no_telp }}"
                                    data-instagram="{{ $user->instagram }}"
                                    data-alamat="{{ $user->alamat }}"
                                    data-hs-overlay="#editUserModal">
                                <i class="size-3" data-lucide="edit"></i> Edit
                            </button>

                            <!-- Tombol Delete -->
                            <button type="button" 
                                    class="flex items-center gap-1.5 py-1.5 px-3 text-xs font-medium text-danger hover:bg-danger/10 rounded w-full text-start"
                                    onclick="confirmDelete('{{ route('manajemen-user.destroy', $user->id) }}', '{{ $user->name }}')">
                                <i class="size-3" data-lucide="trash-2"></i> Delete
                            </button>
                        </div>
                    </div>
                </td>

                <!-- Nama & UMKM -->
                <td class="py-3 px-3.5">
                    <div class="flex items-center gap-3">
                        <div class="size-10 rounded-full bg-default-200 shrink-0 overflow-hidden">
                            <img alt="{{ $user->name }}" class="size-10 rounded-full object-cover" 
                                 src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('images/user/logo_tuban.jpg') }}"/>
                        </div>
                        <div>
                            <h6 class="mb-0.5 font-semibold">
                                <a class="text-default-800 hover:text-primary" href="#">{{ $user->name }}</a>
                            </h6>
                            <p class="text-xs text-default-500">{{ $user->nama_umkm ?? '-' }}</p>
                        </div>
                    </div>
                </td>

                <!-- Email -->
                <td class="py-3 px-3.5">{{ $user->email }}</td>

                <!-- Alamat -->
                <td class="py-3 px-3.5 max-w-xs truncate">{{ $user->alamat ?? '-' }}</td>

                <!-- No Telp -->
                <td class="py-3 px-3.5">{{ $user->no_telp ?? '-' }}</td>

                <!-- Instagram -->
                <td class="py-3 px-3.5">
                    <span class="font-medium text-default-700">{{ $user->instagram ?? '-' }}</span>
                </td>

                <!-- Role -->
                <td class="py-3 px-3.5">
                    @php
                        // Ambil nama role, ubah ke huruf kecil untuk pengecekan aman
                        $roleName = strtolower($user->role_nama ?? '');
                    @endphp

                    @switch($roleName)
                        @case('superadmin')
                        @case('super admin')
                            <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1.5 text-xs font-semibold bg-danger/10 text-danger rounded-full">
                                <i class="size-3.5" data-lucide="shield-check"></i>
                                Superadmin
                            </span>
                            @break

                        @case('editor')
                        @case('operator')
                            <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1.5 text-xs font-semibold bg-info/10 text-info rounded-full">
                                <i class="size-3.5" data-lucide="file-text"></i>
                                Editor
                            </span>
                            @break

                        @case('umkm')
                        @case('pelaku umkm')
                            <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1.5 text-xs font-semibold bg-warning/10 text-warning rounded-full">
                                <i class="size-3.5" data-lucide="store"></i>
                                UMKM
                            </span>
                            @break

                        @default
                            <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1.5 text-xs font-medium bg-default-100 text-default-600 rounded-full">
                                <i class="size-3.5" data-lucide="user"></i>
                                {{ $user->role_nama ?? 'User' }}
                            </span>
                    @endswitch
                </td>

                <!-- Tanggal Dibuat -->
                <td class="py-3 px-3.5">{{ $user->created_at ? $user->created_at->format('d M, Y') : '-' }}</td>

                <!-- Status Badge -->
                <td class="px-3.5 py-3">
                    @switch(strtolower($user->status))
                        @case('terverifikasi')
                            <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-success/10 text-success rounded">
                                <i class="size-3" data-lucide="check-circle-2"></i>
                                Terverifikasi
                            </span>
                            @break
                        @case('menunggu')
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
                            <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-default-200 text-default-600 rounded">
                                <i class="size-3" data-lucide="minus-circle"></i>
                                Nonaktif
                            </span>
                            @break

                        @default
                            <span class="py-0.5 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-default-100 text-default-500 rounded">
                                {{ ucfirst($user->status ?? 'Draft') }}
                            </span>
                    @endswitch
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center py-6 text-default-500">
                    Belum ada data pengguna.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>