@extends('layouts.base', ['title' => 'Login'])

@section('css')
@endsection

@section('content')
    <div class="relative min-h-screen w-full flex justify-center items-center py-16 md:py-10">
        <div class="card md:w-lg w-screen z-10">
            <div class="text-center px-10 py-12">
                <!-- Logo -->
                <a class="flex justify-center" href="{{ route('home') }}">
                    <img alt="logo dark" class="h-12 flex dark:hidden" src="{{ asset ('images/logo-dekranasda.png')}}"/>
                    <img alt="logo light" class="h-12 hidden dark:flex" src="{{ asset ('images/logo-dekranasda.png')}}"/>
                </a>
                <div class="mt-8 text-center">
                    <h4 class="mb-2.5 text-xl font-semibold text-primary">Selamat Datang !</h4>
                    <p class="text-base text-default-500">Masuk untuk melanjutkan ke Dekranasda.</p>
                </div>

                <!-- Alert Error jika Login Gagal -->
                @if ($errors->any())
                    <div class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-md text-sm text-left">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('status'))
                    <div class="mt-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-md text-sm text-left">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Form Login -->
                <form action="{{ route('authenticate') }}" method="POST" class="text-left w-full mt-10">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block font-medium text-default-900 text-sm mb-2" for="email">Email</label>
                        <input class="form-input w-full @error('email') border-red-500 @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               placeholder="Masukkan alamat email" 
                               type="email" 
                               required 
                               autofocus />
                        @error('email')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-default-900 text-sm mb-2" for="password">Password</label>
                        <input class="form-input w-full @error('password') border-red-500 @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="Masukkan Password" 
                               type="password" 
                               required />
                    </div>

                    <!-- mt-10 mengembalikan jarak tombol presisi seperti Gambar 1 -->
                    <div class="mt-10 text-center">
                        <button class="btn bg-primary text-white w-full" type="submit">
                            Masuk
                        </button>
                    </div>

                    {{-- <div class="my-9 relative text-center before:absolute before:top-2.5 before:left-0 before:border-t before:border-t-default-200 before:w-full before:h-0.5 before:right-0 before:-z-0">
                        <h4 class="relative z-1 py-0.5 px-2 inline-block font-medium text-default-600 bg-card">Masuk dengan</h4>
                    </div>

                    <div class="flex w-full justify-center items-center gap-2">
                        <a class="btn border border-default-200 flex-grow hover:bg-default-150 shadow-sm hover:text-default-800"
                           href="#">
                            <i class="iconify-color logos--google-icon"></i>
                            Google
                        </a>
                    </div> --}}

                    <div class="mt-10 text-center">
                        <p class="text-base text-default-500">Belum punya akun ?
                            <a class="font-semibold underline hover:text-primary transition duration-200" href="{{ route('register') }}">Daftar</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>

        <div class="absolute inset-0 overflow-hidden">
            <svg aria-hidden="true" class="absolute inset-0 size-full fill-black/2 stroke-black/5 dark:fill-white/2.5 dark:stroke-white/2.5">
                <defs>
                    <pattern height="56" id="authPattern" patternunits="userSpaceOnUse" width="56" x="50%" y="16">
                        <path d="M.5 56V.5H72" fill="none"></path>
                    </pattern>
                </defs>
                <rect fill="url(#authPattern)" height="100%" stroke-width="0" width="100%"></rect>
            </svg>
        </div>
    </div>
@endsection

@section('scripts')
@endsection