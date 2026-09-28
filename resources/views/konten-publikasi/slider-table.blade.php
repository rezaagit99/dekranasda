<table class="min-w-full divide-y divide-default-200">
    <thead class="bg-default-100 dark:bg-neutral-700">
        <tr class="text-start text-xs font-semibold text-default-600 uppercase tracking-wider">
            <th class="px-6 py-3.5 text-center">Aksi</th>
            <th class="px-6 py-3.5">Banner</th>
            <th class="px-6 py-3.5">Judul & Deskripsi</th>
            <th class="px-6 py-3.5">Urutan</th>
            <th class="px-6 py-3.5">Status</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-default-200">
        @forelse ($sliderList as $slider)
            <tr class="hover:bg-default-50 transition-all">
                <!-- Action Dropdown -->
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    <div class="hs-dropdown relative inline-flex">
                        <button id="hs-dropdown-slider-{{ $slider->slider_id }}" type="button" class="hs-dropdown-toggle btn size-8 bg-default-100 text-default-600 hover:bg-default-200 rounded-full flex items-center justify-center">
                            <i data-lucide="more-vertical" class="size-4"></i>
                        </button>
                        <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-36 bg-white dark:bg-neutral-800 shadow-md rounded-lg p-2 mt-2 z-10 border border-default-200" aria-labelledby="hs-dropdown-slider-{{ $slider->slider_id }}">
                            <!-- Edit Button -->
                            <button type="button"
                                class="btn-edit flex items-center gap-2 w-full px-3 py-2 text-xs text-default-700 hover:bg-default-100 rounded-md transition-all"
                                data-action="{{ route('publikasi.slider.update', $slider->slider_id) }}"
                                data-judul="{{ $slider->judul }}"
                                data-deskripsi="{{ $slider->deskripsi }}"
                                data-link="{{ $slider->link }}"
                                data-urutan="{{ $slider->urutan }}"
                                data-status="{{ $slider->status }}"
                                data-preview="{{ asset('storage/' . $slider->gambar) }}"
                                data-hs-overlay="#editSliderModal">
                                <i data-lucide="edit-3" class="size-3.5"></i> Edit
                            </button>
                            
                            <!-- Delete Button -->
                            <button type="button" 
                                onclick="confirmDeleteSlider('{{ route('publikasi.slider.destroy', $slider->slider_id) }}', '{{ $slider->judul }}')"
                                class="flex items-center gap-2 w-full px-3 py-2 text-xs text-danger hover:bg-danger/10 rounded-md transition-all">
                                <i data-lucide="trash-2" class="size-3.5"></i> Delete
                            </button>
                        </div>
                    </div>
                </td>

                <!-- Banner Image -->
                <td class="px-6 py-4 whitespace-nowrap">
                    <img src="{{ asset('storage/' . $slider->gambar) }}" alt="Slider Banner" class="h-16 w-32 object-cover rounded-lg border border-default-200">
                </td>

                <!-- Judul & Deskripsi & Link -->
                <td class="px-6 py-4">
                    <div class="max-w-xs">
                        <h6 class="text-sm font-semibold text-default-800 truncate">{{ $slider->judul ?? '-' }}</h6>
                        <p class="text-xs text-default-500 truncate">{{ $slider->deskripsi ?? '-' }}</p>
                        @if($slider->link)
                            <a href="{{ $slider->link }}" target="_blank" class="text-xs text-primary underline truncate block mt-0.5">
                                {{ $slider->link }}
                            </a>
                        @endif
                    </div>
                </td>

                <!-- Urutan -->
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-default-700">
                    {{ $slider->urutan }}
                </td>

                <!-- Status -->
                <td class="px-6 py-4 whitespace-nowrap">
                    @if ($slider->status === 'active')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-success/10 text-success">
                            <span class="size-1.5 rounded-full bg-success"></span> Active
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-danger/10 text-danger">
                            <span class="size-1.5 rounded-full bg-danger"></span> Inactive
                        </span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-sm text-default-500">
                    Tidak ada data slider banner.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>