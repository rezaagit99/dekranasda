<?php

namespace App\Http\Controllers;
use App\Models\Slider;
use App\Models\Produk;
use App\Models\Profil;
use App\Models\Foto;
use App\Models\Umkm;
use App\Models\Berita;
use App\Models\Kategori;
use App\Models\KalenderKegiatan; // atau Model sesuai nama file kamu (misal: Kegiatan)
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class FrontendController extends Controller
{
    public function index()
    {
        // 1. Ambil Data Slider yang Aktif
        $sliders = Slider::where('status', 'active')
            ->orderBy('urutan', 'asc')
            ->get();

        // 2. Ambil Produk Terbaru
        $produks = Produk::select('produks.*', 'kategoris.nama_kategori')
                    ->leftJoin('kategoris', 'produks.kategori_id', '=', 'kategoris.kategori_id')
                    ->where('status', 'available')
                    ->orderBy('views', 'desc')
                    ->take(4)
                    ->get();

        // 3. Ambil Galeri Foto Publikasi
        $fotos = Foto::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $totalUmkm = Umkm::count();
        $totalProduk = Produk::count();
        $totalKategori = Kategori::count();

        $kegiatans = KalenderKegiatan::where('tanggal_mulai', '>=', Carbon::today())
                        ->orderBy('tanggal_mulai', 'asc')
                        ->take(5)
                        ->get();

        $beritas = Berita::where('status', 'published') // opsional jika ada status
                    ->latest()
                    ->take(4)
                    ->get();

        $profil = Profil::first();

        $today = now()->toDateString();
        $startOfWeek = now()->startOfWeek()->toDateString();
        $thisMonth = now()->month;
        $thisYear = now()->year;

        $visitorToday = DB::table('visitors')->where('visit_date', $today)->count();
        $visitorWeek  = DB::table('visitors')->where('visit_date', '>=', $startOfWeek)->count();
        $visitorMonth = DB::table('visitors')->whereYear('visit_date', $thisYear)->whereMonth('visit_date', $thisMonth)->count();
        $visitorYear  = DB::table('visitors')->whereYear('visit_date', $thisYear)->count();
        $visitorTotal = DB::table('visitors')->count();

        return view('frontend.index', compact('sliders', 
                                            'produks', 
                                            'fotos', 
                                            'totalUmkm', 
                                            'totalProduk', 
                                            'totalKategori',
                                            'kegiatans', 
                                            'profil',
                                            'beritas',
                                            'visitorToday',
                                            'visitorWeek',
                                            'visitorMonth',
                                            'visitorYear',
                                            'visitorTotal'
                                        ));
    }

    public function produkIndex(Request $request){
        $query = Produk::query();
        $profil = Profil::first();
        
        if (method_exists(Produk::class, 'kategori')) {
            $query->with('kategori');
        }

        if ($request->filled('q')) {
            $query->where('nama_produk', 'like', '%' . $request->q . '%')
                    ->orWhere('deskripsi', 'like', '%' . $request->q . '%');
        }

        // Fitur Kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Fitur Sorting
        switch ($request->sort) {
            case 'harga_low':
                $query->orderBy('harga', 'asc');
                break;
            case 'harga_high':
                $query->orderBy('harga', 'desc');
                break;
            case 'terpopuler':
                $query->orderBy('views', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        // Paginate 12 item per halaman (pasti memicu pagination jika data > 10)
        $produks = $query->paginate(12);
        $kategoris = class_exists(Kategori::class) ? Kategori::all() : collect();

        return view('frontend.produk.index', compact('produks', 'kategoris','profil'));
    }

    // 3. Halaman Detail Produk
    public function produkShow($id)
    {
        // Mengambil produk beserta relasi kategorinya
        $produk = Produk::with('kategori')->findOrFail($id);

        if (is_null($produk->views)) {
            $produk->views = 0;
            $produk->save();
        }
        
        // Counter jumlah view produk
        $produk->increment('views');

        // Ambil 4 produk terkait dengan kategori sama (kecuali produk yang sedang dibuka)
        $relatedProduks = Produk::where('kategori_id', $produk->kategori_id)
            ->where('produk_id', '!=', $produk->produk_id)
            ->latest()
            ->take(4)
            ->get();

        return view('frontend.produk.show', compact('produk', 'relatedProduks'));
    }

    public function kegiatanIndex(Request $request){
        $kegiatans = KalenderKegiatan::where('status', '!=', 'selesai')
                        ->orderBy('tanggal_mulai', 'asc')
                        ->paginate(9);

        return view('frontend.kegiatan.index', compact('kegiatans'));
    }

    // Berita
    public function beritaIndex(Request $request){
        $beritas = Berita::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate(9); // 9 data per halaman untuk grid 3x3

        return view('frontend.berita.index', compact('beritas'));
    }

    public function beritaShow($idOrSlug){
        // 1. Ambil Berita Utama
        $berita = Berita::where('status', 'published')
            ->where(function ($query) use ($idOrSlug) {
                $query->where('slug', $idOrSlug)
                    ->orWhere('berita_id', $idOrSlug);
            })
            ->firstOrFail();

        // 2. Increment Views berita utama
        $berita->increment('views');

        // 3. Ambil 3 Berita Populer (views terbanyak, mengabaikan berita yang sedang dibaca)
        $beritaPopuler = Berita::where('status', 'published')
            ->where('berita_id', '!=', $berita->berita_id)
            ->orderBy('views', 'desc')
            ->take(3)
            ->get();

        return view('frontend.berita.show', compact('berita', 'beritaPopuler'));
    }

    public function profilIndex()
    {
        $profil = Profil::first();

        return view('frontend.profil', compact('profil'));
    }

    public function umkmIndex(){
        $umkms = Umkm::where('status', 'terverifikasi')
                 ->paginate(9);

        $profil = Profil::first();


        return view('frontend.umkm.index', compact('umkms', 'profil'));
    }

    public function umkmShow($id)
    {
        $umkm = Umkm::with('user')
                ->where('umkm_id', $id)
                ->orWhere('slug', $id)
                ->firstOrFail();

        // Ambil produk milik UMKM (9 item per halaman)
        $produks = $umkm->produk()->latest()->paginate(9);
        $profil = Profil::first();


        return view('frontend.umkm.show', compact('umkm', 'produks', 'profil'));
    }
}
