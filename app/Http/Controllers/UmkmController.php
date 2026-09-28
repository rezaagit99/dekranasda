<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\Produk; // Pastikan model Produk sudah ada
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class UmkmController extends Controller
{

    public function kategoriIndex()
    {
        $kategoriList = Kategori::latest()->paginate(10);

        return view('umkm.kategori', compact('kategoriList'));
    }

    public function kategoriStore(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
            'deskripsi'     => 'nullable|string',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori ini sudah ada.',
        ]);

        try {
            // 2. Simpan ke Database
            Kategori::create([
                'nama_kategori' => $request->nama_kategori,
                'slug'          => Str::slug($request->nama_kategori),
                'deskripsi'     => $request->deskripsi,
            ]);

            // 3. Redirect Kembali dengan Alert Sukses
            return redirect()->back()->with('success', 'Kategori baru berhasil ditambahkan.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan kategori: ' . $e->getMessage());
        }
    }

    public function kategoriUpdate(Request $request, $id)
    {
        // 1. Cari data kategori berdasarkan ID
        $kategori = Kategori::findOrFail($id);

        // 2. Validasi Input (Abaikan unique untuk ID kategori yang sedang diedit)
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $id . ',kategori_id',
            'deskripsi'     => 'nullable|string',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori ini sudah digunakan.',
        ]);

        try {
            // 3. Update data ke database
            $kategori->update([
                'nama_kategori' => $request->nama_kategori,
                'slug'          => Str::slug($request->nama_kategori),
                'deskripsi'     => $request->deskripsi,
            ]);

            return redirect()->back()->with('success', 'Kategori berhasil diperbarui.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui kategori: ' . $e->getMessage());
        }
    }

    // Method untuk Hapus Kategori
    public function kategoriDestroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }

    public function umkmIndex()
    {
        if (auth()->user()->role_id != 1) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        $user = Auth::user();

        // Jika login sebagai Admin / Super Admin
        // $umkmList = Umkm::with(['user', 'produk'])->latest()->paginate(10);
        $umkmList = Umkm::with('user')->latest()->paginate(10);
        return view('umkm.umkm', compact('umkmList'));
    }

    public function umkmStore(Request $request)
    {
        $request->validate([
            'nama_umkm' => 'required|string|max:255',
            // 'kategori'  => 'required|string',
            'alamat'    => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'foto_umkm' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'    => 'required|in:terverifikasi,menunggu,ditolak,nonaktif',
        ]);

        DB::beginTransaction();
        try {
            $path = null;
            if ($request->hasFile('foto_umkm')) {
                $path = $request->file('foto_umkm')->store('umkm', 'public');
            }

            // Tentukan user_id (jika admin bisa pilih user, jika role umkm pakai Auth::id())
            $userId = Auth::user()->role === 'umkm' ? Auth::id() : ($request->user_id ?? Auth::id());

            Umkm::create([
                'nama_umkm' => $request->nama_umkm,
                'slug'      => Str::slug($request->nama_umkm) . '-' . Str::random(5),
                // 'kategori'  => $request->kategori,
                'alamat'    => $request->alamat,
                'deskripsi' => $request->deskripsi,
                'foto_umkm' => $path,
                'status'    => $request->status,
                'user_id'   => $userId,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Data UMKM berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan UMKM: ' . $e->getMessage());
        }
    }

    public function umkmUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_umkm' => 'required|string|max:255',
            // 'kategori'  => 'required|string',
            'alamat'    => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'foto_umkm' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'    => 'required|in:terverifikasi,menunggu,ditolak,nonaktif',
        ]);

        DB::beginTransaction();
        try {
            $umkm = Umkm::findOrFail($id);
            $data = [
                'nama_umkm' => $request->nama_umkm,
                'slug'      => Str::slug($request->nama_umkm) . '-' . Str::random(5),
                // 'kategori'  => $request->kategori,
                'alamat'    => $request->alamat,
                'deskripsi' => $request->deskripsi,
                'status'    => $request->status,
            ];

            if ($request->hasFile('foto_umkm')) {
                if ($umkm->foto_umkm && Storage::disk('public')->exists($umkm->foto_umkm)) {
                    Storage::disk('public')->delete($umkm->foto_umkm);
                }
                $data['foto_umkm'] = $request->file('foto_umkm')->store('umkm', 'public');
            }

            $umkm->update($data);

            DB::commit();
            return redirect()->back()->with('success', 'Data UMKM berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui UMKM: ' . $e->getMessage());
        }
    }

    public function umkmDestroy($id)
    {
        DB::beginTransaction();
        try {
            $umkm = Umkm::findOrFail($id);
            $filePath = $umkm->foto_umkm;

            $umkm->delete();
            DB::commit();

            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            return redirect()->back()->with('success', 'Data UMKM berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus UMKM: ' . $e->getMessage());
        }
    }

    /* =========================================================================
     *  2. MANAJEMEN PRODUK UMKM
     * ========================================================================= */

    public function produkIndex()
    {
        $user = Auth::user();
        $kategoris = Kategori::latest()->get();

        // Jika Role adalah UMKM (role_id = 3)
        if ($user->role_id == 3) {
            // Ambil UMKM milik user via relasi umkmByUser
            $umkm = $user->umkmByUser;

            // Jika user belum terikat ke UMKM manapun
            if (!$umkm) {
                return redirect()->route('profil-saya.index')
                    ->with('error', 'Akun Anda belum terikat dengan data UMKM.');
            }

            // Query HANYA produk milik UMKM user yang login
            $produkList = Produk::with(['umkm', 'kategori'])
                                ->where('umkm_id', $umkm->umkm_id)
                                ->latest()
                                ->paginate(10);
                
            // Opsi UMKM untuk dropdown/modal hanya UMKM dia sendiri
            $umkmList = collect([$umkm]); 

        } else {
            // Jika Superadmin / Role lain (role_id != 3)
            // Tampilkan SELURUH produk dari SEMUA UMKM
            $produkList = Produk::with(['umkm', 'kategori'])
                                ->latest()
                                ->paginate(10);
            
            // Ambil daftar semua UMKM aktif/terverifikasi untuk dropdown modal
            $umkmList = Umkm::where('status', 'terverifikasi')
                            ->orderBy('nama_umkm', 'asc')
                            ->get();
        }

        return view('umkm.produk', compact('produkList', 'umkmList', 'kategoris'));
    }

    /**
     * Simpan Produk Baru
     */
    public function produkStore(Request $request)
    {
        // 1. Validasi Input (disesuaikan untuk multiple files)
        $request->validate([
            'umkm_id'       => 'required|exists:umkm,umkm_id',
            'kategori_id'   => 'required|exists:kategoris,kategori_id',
            'nama_produk'   => 'required|string|max:255',
            'harga'         => 'required|numeric|min:0',
            'deskripsi'     => 'nullable|string',
            'foto_produk'   => 'nullable|array', // Harus berbentuk Array
            'foto_produk.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048', // Validasi tiap file gambar
            'status'        => 'required|in:available,out_of_stock',
        ], [
            'kategori_id.required' => 'Kategori produk wajib dipilih.',
            'kategori_id.exists'   => 'Kategori yang dipilih tidak valid.',
            'foto_produk.*.image'  => 'File yang diunggah harus berupa gambar.',
            'foto_produk.*.max'    => 'Ukuran gambar maksimal adalah 2MB per file.',
        ]);

        try {
            // 2. Loop & Upload Banyak Foto
            $fotoPaths = [];
            if ($request->hasFile('foto_produk')) {
                foreach ($request->file('foto_produk') as $file) {
                    // Simpan tiap foto ke folder storage/app/public/produk
                    $fotoPaths[] = $file->store('produk', 'public');
                }
            }

            // 3. Simpan ke Database
            Produk::create([
                'umkm_id'     => $request->umkm_id,
                'kategori_id' => $request->kategori_id,
                'nama_produk' => $request->nama_produk,
                'slug'        => Str::slug($request->nama_produk),
                'harga'       => $request->harga,
                'deskripsi'   => $request->deskripsi,
                'foto_produk' => $fotoPaths, // Array ini otomatis di-convert ke JSON oleh Model
                'status'      => $request->status,
            ]);

            return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan produk: ' . $e->getMessage());
        }
    }

    /**
     * Update Produk
     */
    public function produkUpdate(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        // 1. Validasi
        $request->validate([
            'umkm_id'       => 'required|exists:umkm,umkm_id',
            'kategori_id'   => 'required|exists:kategoris,kategori_id',
            'nama_produk'   => 'required|string|max:255',
            'harga'         => 'required|numeric|min:0',
            'deskripsi'     => 'nullable|string',
            'foto_produk'   => 'nullable|array',
            'foto_produk.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'        => 'required|in:available,out_of_stock',
            'delete_fotos'  => 'nullable|array', // Menerima array foto yang dihapus dari JS
        ]);

        // 2. Ambil foto yang tersimpan saat ini
        $currentFotos = is_array($produk->foto_produk) ? $produk->foto_produk : [];

        // 3. Hapus foto yang dikirim dari input hidden `delete_fotos[]`
        if ($request->has('delete_fotos')) {
            foreach ($request->delete_fotos as $fotoToDelete) {
                // Hapus file fisik dari storage
                if (Storage::disk('public')->exists($fotoToDelete)) {
                    Storage::disk('public')->delete($fotoToDelete);
                }
                // Keluarkan dari array foto produk
                $currentFotos = array_filter($currentFotos, fn($item) => $item !== $fotoToDelete);
            }
        }

        // 4. Tambah foto-foto baru jika ada unggahan baru
        if ($request->hasFile('foto_produk')) {
            foreach ($request->file('foto_produk') as $file) {
                $newPath = $file->store('produk', 'public');
                $currentFotos[] = $newPath;
            }
        }

        // 5. Simpan Perubahan
        $data = [
            'umkm_id'     => $request->umkm_id,
            'kategori_id' => $request->kategori_id,
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
            'deskripsi'   => $request->deskripsi,
            'status'      => $request->status,
            'foto_produk' => array_values($currentFotos), // Re-index array & simpan sebagai JSON
        ];

        if ($produk->nama_produk !== $request->nama_produk) {
            $data['slug'] = Str::slug($request->nama_produk) . '-' . time();
        }

        $produk->update($data);

        return redirect()->back()->with('success', 'Data produk berhasil diperbarui!');
    }

    /**
     * Hapus Produk
     */
    public function produkDestroy($id)
{
    $produk = Produk::findOrFail($id);

    if ($produk->foto_produk) {
        // Ambil data foto (decode jika berupa JSON string, atau langsung gunakan jika sudah ter-cast array)
        $fotos = is_string($produk->foto_produk) 
            ? json_decode($produk->foto_produk, true) 
            : $produk->foto_produk;

        // Jika hasilnya berupa array (multiple foto)
        if (is_array($fotos)) {
            foreach ($fotos as $foto) {
                if ($foto && Storage::disk('public')->exists($foto)) {
                    Storage::disk('public')->delete($foto);
                }
            }
        } 
        // Jika ternyata berupa string tunggal
        elseif (is_string($fotos) && Storage::disk('public')->exists($fotos)) {
            Storage::disk('public')->delete($fotos);
        }
    }

    $produk->delete();

    return redirect()->back()->with('success', 'Produk berhasil dihapus!');
}
}
