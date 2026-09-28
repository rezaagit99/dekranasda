<header>
    <nav class="fixed inset-x-0 top-0 z-50 bg-card py-6 border-b border-default-150 flex justify-between items-center">
        <div class="container">
            <div class="grid lg:grid-cols-12 md:grid-cols-10 grid-cols-3 items-center">
                <div class="lg:col-span-3 md:col-span-2 col-span-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                        <img alt="Logo Dekranasda Tuban" class="h-7 w-auto block dark:hidden" src="{{ asset ('images/logo-dekranasda.png')}}" />
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
                <div class="lg:col-span-7 md:col-span-6 md:block hidden">
                    <ul class="flex items-center justify-center lg:gap-8 md:gap-6 font-medium text-sm">
                        <li>
                            <a class="text-default-800 hover:text-primary transition duration-300" href="{{ route('home') }}#home">Beranda</a>
                        </li>
                        <li>
                            <a class="text-default-800 hover:text-primary transition duration-300" href="{{ route('frontend.profil') }}">Profil</a>
                        </li>
                        <li>
                            <a class="text-default-800 hover:text-primary transition duration-300" href="{{ route('frontend.umkm.index') }}">UMKM</a>
                        </li>
                        <li>
                            <a class="text-default-800 hover:text-primary transition duration-300" href="{{ route('frontend.produk.index') }}">Produk</a>
                        </li>
                        <li>
                            <a class="text-default-800 hover:text-primary transition duration-300" href="#footer">Tentang Kami</a>
                        </li>
                    </ul>
                </div>
                <div class="lg:col-span-2 md:col-span-2 col-span-2 flex items-center justify-end gap-4">
                    <a class="flex justify-end" href="{{ route('login') }}">
                        <button
                            style="background: linear-gradient(135deg, #e60707 0%, #761b2f 100%) !important; color: #ffffff !important;"
                            class="border-0 rounded-md inline-flex items-center gap-2 px-5 py-2.5 shadow-md cursor-pointer transition-opacity hover:opacity-90"
                            type="button">
                            Masuk <i class="size-4" data-lucide="log-in"></i>
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>