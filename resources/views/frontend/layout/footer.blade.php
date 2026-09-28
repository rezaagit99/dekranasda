<footer class="relative md:pt-20 pt-12 md:pb-0 border-t border-default-200" id="footer">
    <div class="absolute -top-16 start-0 size-64 bg-purple-500/10 blur-3xl"></div>
    <div class="container">
        <div class="grid grid-cols-12 md:gap-12 gap-6">
            <div class="lg:col-span-4 col-span-12">
                <div class="mb-5">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                        <img alt="Logo Dekranasda Tuban" class="h-7 w-auto block dark:hidden" src="{{ asset ('images/logo-dekranasda.png')}}"/>
                        <img alt="Logo Dekranasda Tuban" class="h-7 w-auto hidden dark:block" src="{{ asset ('images/logo-dekranasda.png')}}" />
                        
                        <div class="flex flex-col leading-tight">
                            <span class="text-base font-bold tracking-wider text-default-800 dark:text-white uppercase">
                                Dekranasda
                            </span>
                            <span class="text-[10px] font-medium tracking-widest text-default-500 uppercase">
                                Kabupaten Tuban
                            </span>
                        </div>
                    </a>
                </div>
                <p class="mb-5 text-sm text-default-500">
                    Portal resmi Dekranasda Kabupaten Tuban untuk promosi kerajinan lokal, fasilitasi pelaku UMKM, dan publikasi agenda kegiatan daerah.
                </p>
                <div class="flex flex-wrap gap-3 md:mt-0 mt-5">
                    <a href="{{ $profil->instagram ?? '#' }}" 
                        target="_blank" 
                        rel="noopener noreferrer"
                        class="inline-flex items-center justify-center size-10 border btn border-default-200 bg-transparent rounded-full text-default-500 hover:text-primary">
                            <i class="size-4" data-lucide="instagram"></i>
                    </a>

                    <a href="{{ $profil->youtube ?? '#' }}" 
                        target="_blank" 
                        rel="noopener noreferrer"
                        class="inline-flex items-center justify-center size-10 border btn border-default-200 bg-transparent rounded-full text-default-500 hover:text-primary">
                            <i class="size-4" data-lucide="youtube"></i>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-1 md:col-span-1 col-span-12"></div>
            
            <div class="lg:col-span-3 md:col-span-4 col-span-12">
                <h5 class="mb-4 font-medium text-lg text-default-700">Pusat Bantuan</h5>
                <ul class="flex flex-col gap-y-3 text-sm">
                    <li>
                        <a class="relative inline-block transition-all duration-200 ease-linear hover:text-default-900 text-default-600" href="#">Pendaftaran UMKM</a>
                    </li>
                    <li>
                        <a class="relative inline-block transition-all duration-200 ease-linear hover:text-default-900 text-default-600" href="#">Panduan Pelaku Usaha</a>
                    </li>
                    <li>
                        <a class="relative inline-block transition-all duration-200 ease-linear hover:text-default-900 text-default-600" href="tel:{{ $profil->telepon ?? '' }}">Kontak & Sekretariat</a>
                    </li>
                </ul>
            </div>

            <div class="lg:col-span-4 md:col-span-4 col-span-12">
                <h5 class="mb-4 font-medium text-lg text-default-700">Kontak Kami</h5>
                <ul class="flex flex-col gap-y-3.5 text-sm text-default-600">
                    <li class="mb-1">
                        <a href="{{ $profil->link_maps ?? '#' }}" target="_blank" rel="noopener noreferrer" class="flex items-start gap-3 hover:text-primary transition-colors">
                            <i data-lucide="map-pin" class="size-5 text-primary shrink-0 mt-0.5"></i>
                            <span>{{ $profil->alamat ?? '-' }}</span>
                        </a>
                    </li>
                    <li class="flex items-center gap-3 mb-1">
                        <i data-lucide="phone" class="size-5 text-primary shrink-0"></i>
                        <a href="tel:{{ $profil->telepon ?? '#' }}" class="hover:text-default-900 transition-colors">
                            {{ $profil->telepon ?? '-' }}
                        </a>
                    </li>
                    <li class="flex items-center gap-3 mb-1">
                        <i data-lucide="mail" class="size-5 text-primary shrink-0"></i>
                        <a href="mailto:{{ $profil->email ?? '#' }}" class="hover:text-default-900 transition-colors">
                            {{ $profil->email ?? '-' }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="lg:py-10 py-6 mt-12 text-center text-default-500 text-base border-t border-default-200">
        <p>2026 © Dekranasda Kabupaten Tuban. Design &amp; Develop by <a class="underline text-primary text-default-800 font-bold transition-all hover:text-primary-600" href="https://kominfo.tubankab.go.id/" target="_blank">Timdev Diskominfo</a></p>
    </div>
</footer>