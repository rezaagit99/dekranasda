<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;            // Tabel 'beritas'
use App\Models\Foto;              // Tabel 'foto'
use App\Models\KalenderKegiatan;  // Tabel 'kalender_kegiatan'
use App\Models\Produk;            // Tabel 'produks'
use App\Models\Umkm;              // Tabel 'umkm'
use App\Models\User;              // Tabel 'users'
use App\Models\Video;
use App\Models\Kategori;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Inisialisasi statistik
        $totalUmkm = 0;
        $totalProduk = 0;
        $totalKategori = 0;
        $totalUser = 0;

        $totalBerita = 0;
        $totalKegiatan = 0;
        $totalFoto = 0;
        $totalVideo = 0;

        $totalProdukSaya = 0;
        $totalProdukAktif = 0;
        $totalProdukTidakAktif = 0;

        // Query Dasar Produk Terbaru
        $produksQuery = Produk::with('umkm')->latest();

        // 2. Filter berdasarkan Role
        if ($user->role_id === 1) { // SUPERADMIN
            // Tidak ada filter where('umkm_id') -> Semua produk akan ditarik
            $totalUmkm     = Umkm::count();
            $totalProduk   = Produk::count();
            $totalKategori = Kategori::count();
            $totalUser     = User::count();

        } elseif ($user->role_id === 2) { // EDITOR
            $totalBerita   = Berita::count();
            $totalKegiatan = KalenderKegiatan::count();
            $totalFoto     = Foto::count();
            $totalVideo    = Video::count();

        } elseif ($user->role_id === 3) { // UMKM
            // Cari data UMKM yang terhubung dengan user yang login
            $umkmUser = Umkm::where('umkm_id', $user->umkm_id)->first();
            $umkmId   = $umkmUser ? $umkmUser->umkm_id : null;

            // KUNCI QUERY: Hanya ambil produk milik UMKM ini saja
            $produksQuery->where('umkm_id', $umkmId);

            $totalProdukSaya       = Produk::where('umkm_id', $umkmId)->count();
            $totalProdukAktif      = Produk::where('umkm_id', $umkmId)->where('status', 'available')->count();
            $totalProdukTidakAktif = Produk::where('umkm_id', $umkmId)->where('status', 'out_of_stock')->count();
        }

        // 3. Eksekusi Query (Mengambil 10 data terbaru sesuai filter role di atas)
        $produks = $produksQuery->take(10)->get();

        return view('dashboards.index', compact(
            'totalUmkm', 'totalProduk', 'totalKategori', 'totalUser',
            'totalBerita', 'totalKegiatan', 'totalFoto', 'totalVideo',
            'totalProdukSaya', 'totalProdukAktif', 'totalProdukTidakAktif',
            'produks'
        ));
    }
}
