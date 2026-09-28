<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SistemController;
use App\Http\Controllers\PublikasiController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\FrontendController;

/*
|--------------------------------------------------------------------------
| Public / Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/produk', [FrontendController::class, 'produkIndex'])->name('frontend.produk.index');
Route::get('/produk/{id}', [FrontendController::class, 'produkShow'])->name('frontend.produk.show');
Route::get('/agenda-kegiatan', [FrontendController::class, 'kegiatanIndex'])->name('frontend.kegiatan.index');
Route::get('/berita', [FrontendController::class, 'beritaIndex'])->name('frontend.berita.index');
Route::get('/berita/{id}', [FrontendController::class, 'beritaShow'])->name('frontend.berita.show');
Route::get('/profil', [FrontendController::class, 'profilIndex'])->name('frontend.profil');
Route::get('/daftar-umkm', [FrontendController::class, 'umkmIndex'])->name('frontend.umkm.index');

/*
|--------------------------------------------------------------------------
| Guest Auth Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
});

/*
|--------------------------------------------------------------------------
| Authenticated / Backend Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    
    // Core App
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profil & Organisasi
    Route::get('/profil-organisasi', [ProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil-organisasi', [ProfilController::class, 'update'])->name('profil.update');
    Route::get('/profil-saya', [ProfilController::class, 'profilSaya'])->name('profil-saya.index');
    Route::put('/profil-saya', [ProfilController::class, 'updateProfilSaya'])->name('profil-saya.update');

    // User Management
    Route::resource('manajemen-user', SistemController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->parameters(['manajemen-user' => 'user']);

    // Sub-Grup Publikasi
    Route::prefix('publikasi')->name('publikasi.')->group(function () {
        Route::get('/berita', [PublikasiController::class, 'beritaIndex'])->name('berita.index');
        Route::post('/berita', [PublikasiController::class, 'beritaStore'])->name('berita.store');
        Route::put('/berita/{berita}', [PublikasiController::class, 'beritaUpdate'])->name('berita.update');
        Route::delete('/berita/{berita}', [PublikasiController::class, 'beritaDestroy'])->name('berita.destroy');

        Route::get('/kalender', [PublikasiController::class, 'kalenderIndex'])->name('kalender.index');
        Route::post('/kalender', [PublikasiController::class, 'kalenderStore'])->name('kalender.store');
        Route::put('/kalender/{kalender}', [PublikasiController::class, 'kalenderUpdate'])->name('kalender.update');
        Route::delete('/kalender/{kalender}', [PublikasiController::class, 'kalenderDestroy'])->name('kalender.destroy');

        Route::get('/foto', [PublikasiController::class, 'fotoIndex'])->name('foto.index');
        Route::post('/foto', [PublikasiController::class, 'fotoStore'])->name('foto.store');
        Route::put('/foto/{foto}', [PublikasiController::class, 'fotoUpdate'])->name('foto.update');
        Route::delete('/foto/{foto}', [PublikasiController::class, 'fotoDestroy'])->name('foto.destroy');

        Route::get('/video', [PublikasiController::class, 'videoIndex'])->name('video.index');
        Route::post('/video', [PublikasiController::class, 'videoStore'])->name('video.store');
        Route::put('/video/{video}', [PublikasiController::class, 'videoUpdate'])->name('video.update');
        Route::delete('/video/{video}', [PublikasiController::class, 'videoDestroy'])->name('video.destroy');

        Route::get('/slider', [PublikasiController::class, 'sliderIndex'])->name('slider.index');
        Route::post('/slider', [PublikasiController::class, 'sliderStore'])->name('slider.store');
        Route::put('/slider/{id}', [PublikasiController::class, 'sliderUpdate'])->name('slider.update');
        Route::delete('/slider/{id}', [PublikasiController::class, 'sliderDestroy'])->name('slider.destroy');
    });

    // Sub-Grup Backend UMKM
    Route::prefix('admin/umkm')->name('umkm.')->group(function () {
    
        // Kategori
        Route::get('/kategori', [UmkmController::class, 'kategoriIndex'])->name('kategori.index');
        Route::post('/kategori', [UmkmController::class, 'kategoriStore'])->name('kategori.store');
        Route::put('/kategori/{kategori}', [UmkmController::class, 'kategoriUpdate'])->name('kategori.update');
        Route::delete('/kategori/{kategori}', [UmkmController::class, 'kategoriDestroy'])->name('kategori.destroy');

        // Produk
        Route::get('/produk', [UmkmController::class, 'produkIndex'])->name('produk.index');
        Route::post('/produk', [UmkmController::class, 'produkStore'])->name('produk.store');
        Route::put('/produk/{produk}', [UmkmController::class, 'produkUpdate'])->name('produk.update');
        Route::delete('/produk/{produk}', [UmkmController::class, 'produkDestroy'])->name('produk.destroy');

        // Data UMKM Base
        Route::get('/', [UmkmController::class, 'umkmIndex'])->name('umkm.index');
        Route::post('/', [UmkmController::class, 'umkmStore'])->name('umkm.store');
        Route::put('/{umkm}', [UmkmController::class, 'umkmUpdate'])->name('umkm.update');
        Route::delete('/{umkm}', [UmkmController::class, 'umkmDestroy'])->name('umkm.destroy');
    });

});

/*
|--------------------------------------------------------------------------
| Public Detail UMKM Route (Ditaruh di bawah agar tidak memakan URL backend)
|--------------------------------------------------------------------------
*/
Route::get('/umkm/{id}', [FrontendController::class, 'umkmShow'])->name('frontend.umkm.show');