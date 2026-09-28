<!-- Topbar Start -->
<div
    class="app-header min-h-topbar-height flex items-center sticky top-0 z-30 bg-(--topbar-background) border-b border-default-200">
    <div class="w-full flex items-center justify-between px-6">
        <div class="flex items-center gap-5">
            <!-- Sidenav Menu Toggle Button -->
            <button class="btn btn-icon size-8 hover:bg-default-150 rounded" id="button-toggle-menu">
                <i class="iconify lucide--align-left text-xl"></i>
            </button>
            <!-- Topbar Search -->
            <div class="lg:flex hidden items-center relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <i class="iconify tabler--search text-base"></i>
                </div>
                <input class="form-input px-12 text-sm rounded border-transparent focus:border-transparent w-60"
                       id="topbar-search" placeholder="Search something..." type="search"/>
                <button class="absolute inset-y-0 end-0 flex items-center pe-4" type="button">
                    <span class="ms-auto font-medium">⌘ K</span>
                </button>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <!-- Setting Offcanvas Button -->
            <div class="topbar-item">
                <button aria-controls="theme-customization" aria-expanded="false" aria-haspopup="dialog"
                        class="btn btn-icon size-8 hover:bg-default-150 rounded-full"
                        data-hs-overlay="#theme-customization" type="button">
                    <i class="size-4.5" data-lucide="settings"></i>
                </button>
            </div>
            <!-- Profile Dropdown Button -->
            <div class="topbar-item hs-dropdown relative inline-flex">
                <button aria-expanded="false" aria-haspopup="menu" aria-label="Dropdown"
                        class="cursor-pointer bg-pink-100 rounded-full">
                    <img alt="{{ auth()->user()->name ?? 'User Avatar' }}" 
                        class="hs-dropdown-toggle rounded-full size-9.5 object-cover cursor-pointer"
                        src="{{ auth()->user()->foto ? asset('storage/' . auth()->user()->foto) : asset('images/logo_tuban.jpg') }}"/>
                </button>
                <div aria-labelledby="hs-dropdown-with-icons" aria-orientation="vertical"
                    class="hs-dropdown-menu min-w-48" role="menu">
                    <div class="p-2">
                        <h6 class="mb-2 text-default-500">Selamat datang di Dekranasda</h6>
                        <a class="flex gap-3 items-center" href="#!">
                            <div class="relative inline-block">
                                <div class="rounded bg-default-200 overflow-hidden size-12">
                                    <img alt="{{ auth()->user()->name ?? 'User Avatar' }}" 
                                        class="size-12 object-cover rounded" 
                                        src="{{ auth()->user()->foto ? asset('storage/' . auth()->user()->foto) : asset('images/user/avatar-1.png') }}"/>
                                </div>
                                <span class="-top-1 -end-1 absolute w-2.5 h-2.5 bg-green-400 border-2 border-white rounded-full"></span>
                            </div>
                            <div class="truncate">
                                <h6 class="mb-1 text-sm font-semibold text-default-800 truncate">
                                    {{ auth()->user()->name ?? 'Guest User' }}
                                </h6>
                                <p class="text-xs text-default-500 truncate capitalize">
                                    {{ auth()->user()->role->role_nama ?? auth()->user()->email }}
                                </p>
                            </div>
                        </a>
                    </div>
                    
                    <div class="border-t border-t-default-200 -mx-2 my-2"></div>
                    
                    <div class="flex flex-col gap-y-1">
                        @if (auth()->user()->role_id != 1)
                            <a class="flex items-center gap-x-3.5 py-1.5 font-medium px-3 text-default-600 hover:bg-default-150 rounded"
                                href="{{ route('profil-saya.index') }}">
                                    <i class="size-4" data-lucide="user"></i>
                                    Profil Saya
                            </a>
                        @endif
                        
                        <div class="border-t border-default-200 -mx-2 my-1"></div>
                        
                        <!-- Form Logout Aman (POST Method) -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full flex items-center gap-x-3.5 py-1.5 font-medium px-3 text-danger hover:bg-danger/10 rounded text-start cursor-pointer">
                                <i class="size-4" data-lucide="log-out"></i>
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Topbar End -->
