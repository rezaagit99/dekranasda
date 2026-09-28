<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Foto;
use App\Models\Video;
use App\Models\Berita;
use App\Models\KalenderKegiatan;
use App\Models\Slider;
use Illuminate\Support\Facades\Auth;

class PublikasiController extends Controller
{

    // ==========================================
    // 1. BERITA
    // ==========================================
    public function beritaIndex()
    {   
        if (auth()->user()->role_id != 1 && auth()->user()->role_id != 2) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $beritaList = Berita::with('author')->latest()->paginate(10);
        
        return view('konten-publikasi.berita', compact('beritaList'));
    }

    /**
     * Simpan berita baru
     */
    public function beritaStore(Request $request)
    {
        // 1. Validasi Input Data Berita
        $request->validate([
            'judul'        => 'required|string|max:255',
            'ringkasan'    => 'nullable|string',
            'isi'          => 'required|string',
            'status'       => 'required|in:published,draft,archived',
            'gambar_cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'judul.required'  => 'Judul berita wajib diisi.',
            'isi.required'    => 'Isi berita wajib diisi.',
            'status.required' => 'Status publikasi wajib dipilih.',
            'gambar_cover.image' => 'File cover harus berupa gambar.',
            'gambar_cover.max'   => 'Ukuran gambar cover maksimal 2MB.',
        ]);

        DB::beginTransaction();
        try {
            // 2. Handle Upload Gambar Cover (jika ada)
            $coverPath = null;
            if ($request->hasFile('gambar_cover')) {
                $coverPath = $request->file('gambar_cover')->store('berita-cover', 'public');
            }

            // 3. Simpan ke Database
            Berita::create([
                'judul'        => $request->judul,
                'slug'         => Str::slug($request->judul) . '-' . time(),
                'ringkasan'    => $request->ringkasan,
                'isi'          => $request->isi, // Menyimpan HTML dari Quill/Textarea
                'status'       => $request->status,
                'gambar_cover' => $coverPath,
                'user_id'      => auth()->id(), // Penulis diambil dari user yang sedang login
            ]);

            DB::commit();

            // Redirect kembali dengan session 'success' (pemicu SweetAlert di title-meta)
            return redirect()->back()->with('success', 'Berita berhasil disimpan!');

        } catch (Exception $e) {
            DB::rollBack();

            // Hapus gambar jika database gagal menyimpan
            if ($coverPath && Storage::disk('public')->exists($coverPath)) {
                Storage::disk('public')->delete($coverPath);
            }

            return redirect()->back()
                ->withInput($request->except('gambar_cover'))
                ->with('error', 'Gagal menyimpan berita: ' . $e->getMessage());
        }
    }

    public function beritaUpdate(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $request->validate([
            'judul'        => 'required|string|max:255',
            'ringkasan'    => 'nullable|string',
            'isi'          => 'required|string',
            'status'       => 'required|in:published,draft,archived',
            'gambar_cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $coverPath = $berita->gambar_cover;

            if ($request->hasFile('gambar_cover')) {
                // Hapus cover lama jika ada
                if ($coverPath && Storage::disk('public')->exists($coverPath)) {
                    Storage::disk('public')->delete($coverPath);
                }
                $coverPath = $request->file('gambar_cover')->store('berita-cover', 'public');
            }

            $berita->update([
                'judul'        => $request->judul,
                'ringkasan'    => $request->ringkasan,
                'isi'          => $request->isi,
                'status'       => $request->status,
                'gambar_cover' => $coverPath,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Berita berhasil diperbarui!');

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui berita: ' . $e->getMessage());
        }
    }

    public function beritaDestroy($id)
    {
        DB::beginTransaction();
        try {
            // 1. Cari data berita berdasarkan ID
            $berita = Berita::findOrFail($id);

            // 2. Hapus file gambar cover dari storage jika ada
            if ($berita->gambar_cover && Storage::disk('public')->exists($berita->gambar_cover)) {
                Storage::disk('public')->delete($berita->gambar_cover);
            }

            // 3. Hapus record dari database
            $berita->delete();

            DB::commit();

            // Return redirect dengan notifikasi BERHASIL (dipicu oleh SweetAlert di title-meta)
            return redirect()->back()->with('success', 'Berita berhasil dihapus!');

        } catch (Exception $e) {
            DB::rollBack();

            // Return redirect dengan notifikasi GAGAL
            return redirect()->back()->with('error', 'Gagal menghapus berita: ' . $e->getMessage());
        }
    }

    // ==========================================
    // 2. KALENDER (Kegiatan)
    // ==========================================
    public function kalenderIndex()
    {
        if (auth()->user()->role_id != 1 && auth()->user()->role_id != 2) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $kegiatanList = KalenderKegiatan::with('author')
        ->orderBy('tanggal_mulai', 'desc')
        ->paginate(10);

        return view('konten-publikasi.kalender-kegiatan', compact('kegiatanList'));
    }

    public function kalenderStore(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama_kegiatan'   => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'waktu_mulai'     => 'nullable',
            'waktu_selesai'   => 'nullable',
            'lokasi'          => 'nullable|string|max:255',
            'penyelenggara'   => 'nullable|string|max:255',
            'status'          => 'required|in:mendatang,berlangsung,selesai,dibatalkan',
        ], [
            'nama_kegiatan.required'   => 'Nama kegiatan wajib diisi.',
            'tanggal_mulai.required'   => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh kurang dari tanggal mulai.',
            'status.required'          => 'Status kegiatan wajib dipilih.',
        ]);

        DB::beginTransaction();
        try {
            // 2. Simpan Data
            KalenderKegiatan::create([
                'nama_kegiatan'   => $request->nama_kegiatan,
                'slug'            => Str::slug($request->nama_kegiatan) . '-' . time(),
                'deskripsi'       => $request->deskripsi,
                'tanggal_mulai'   => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai ?? $request->tanggal_mulai,
                'waktu_mulai'     => $request->waktu_mulai,
                'waktu_selesai'   => $request->waktu_selesai,
                'lokasi'          => $request->lokasi,
                'penyelenggara'   => $request->penyelenggara,
                'status'          => $request->status,
                'user_id'         => auth()->id(),
            ]);

            DB::commit();

            // Redirect back memicu Toast SweetAlert di title-meta
            return redirect()->back()->with('success', 'Kegiatan berhasil ditambahkan!');

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan kegiatan: ' . $e->getMessage());
        }
    }

    public function kalenderUpdate(Request $request, $id)
    {
        $kegiatan = KalenderKegiatan::findOrFail($id);

        $request->validate([
            'nama_kegiatan'   => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'waktu_mulai'     => 'nullable',
            'waktu_selesai'   => 'nullable',
            'lokasi'          => 'nullable|string|max:255',
            'penyelenggara'   => 'nullable|string|max:255',
            'status'          => 'required|in:mendatang,berlangsung,selesai,dibatalkan',
        ]);

        DB::beginTransaction();
        try {
            $kegiatan->update([
                'nama_kegiatan'   => $request->nama_kegiatan,
                'deskripsi'       => $request->deskripsi,
                'tanggal_mulai'   => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai ?? $request->tanggal_mulai,
                'waktu_mulai'     => $request->waktu_mulai,
                'waktu_selesai'   => $request->waktu_selesai,
                'lokasi'          => $request->lokasi,
                'penyelenggara'   => $request->penyelenggara,
                'status'          => $request->status,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Kegiatan berhasil diperbarui!');

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui kegiatan: ' . $e->getMessage());
        }
    }

    public function kalenderDestroy($id)
    {
        DB::beginTransaction();
        try {
            $kegiatan = KalenderKegiatan::findOrFail($id);
            $kegiatan->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Kegiatan berhasil dihapus!');

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal menghapus kegiatan: ' . $e->getMessage());
        }
    }

    // ==========================================
    // 3. FOTO (Galeri Foto)
    // ==========================================
    public function fotoIndex()
    {
        if (auth()->user()->role_id != 1 && auth()->user()->role_id != 2) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        $fotoList = Foto::with('author')
            ->latest('created_at')
            ->paginate(10);

        return view('konten-publikasi.foto', compact('fotoList'));
    }

    public function fotoStore(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_foto' => 'required|image|mimes:jpeg,png,jpg,webp|max:3072', // Max 3MB
            'status'    => 'required|in:published,archived',
        ], [
            'judul.required'     => 'Judul foto wajib diisi.',
            'file_foto.required' => 'File foto wajib diunggah.',
            'file_foto.image'    => 'File harus berupa gambar.',
            'file_foto.mimes'    => 'Format gambar yang diperbolehkan: jpeg, png, jpg, webp.',
            'file_foto.max'      => 'Ukuran foto maksimal 3MB.',
            'status.required'    => 'Status foto wajib dipilih.',
        ]);

        DB::beginTransaction();
        try {
            // Handle File Upload
            $filePath = null;
            if ($request->hasFile('file_foto')) {
                $filePath = $request->file('file_foto')->store('galeri-foto', 'public');
            }

            Foto::create([
                'judul'     => $request->judul,
                'slug'      => Str::slug($request->judul) . '-' . time(),
                'deskripsi' => $request->deskripsi,
                'file_foto' => $filePath,
                'status'    => $request->status,
                'user_id'   => auth()->id(),
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Foto berhasil ditambahkan ke galeri!');

        } catch (Exception $e) {
            DB::rollBack();

            // Hapus file jika database gagal simpan
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan foto: ' . $e->getMessage());
        }
    }

    public function fotoUpdate(Request $request, $id)
    {
        $foto = Foto::findOrFail($id);

        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'status'    => 'required|in:published,archived',
        ]);

        DB::beginTransaction();
        try {
            $oldFilePath = $foto->file_foto;

            // Update gambar jika ada unggahan baru
            if ($request->hasFile('file_foto')) {
                $foto->file_foto = $request->file('file_foto')->store('galeri-foto', 'public');
            }

            $foto->judul     = $request->judul;
            $foto->deskripsi = $request->deskripsi;
            $foto->status    = $request->status;
            $foto->save();

            DB::commit();

            // Hapus gambar lama jika ganti gambar baru
            if ($request->hasFile('file_foto') && $oldFilePath && Storage::disk('public')->exists($oldFilePath)) {
                Storage::disk('public')->delete($oldFilePath);
            }

            return redirect()->back()->with('success', 'Data foto berhasil diperbarui!');

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui foto: ' . $e->getMessage());
        }
    }

    public function fotoDestroy($id)
    {
        DB::beginTransaction();
        try {
            $foto = Foto::findOrFail($id);
            $filePath = $foto->file_foto;

            $foto->delete();

            DB::commit();

            // Hapus file fisik di storage
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            return redirect()->back()->with('success', 'Foto berhasil dihapus!');

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal menghapus foto: ' . $e->getMessage());
        }
    }

    // ==========================================
    // 4. VIDEO (Galeri Video)
    // ==========================================
    public function videoIndex()
    {
        if (auth()->user()->role_id != 1 && auth()->user()->role_id != 2) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        $videoList = Video::with('author')->latest()->paginate(10);
        return view('konten-publikasi.video', compact('videoList'));
    }

    public function videoStore(Request $request)
    {
        $request->validate([
            'judul'       => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'url_youtube' => 'required|url',
            'status'      => 'required|in:published,archived',
        ]);

        DB::beginTransaction();
        try {
            Video::create([
                'judul'       => $request->judul,
                'slug'        => Str::slug($request->judul) . '-' . Str::random(5),
                'deskripsi'   => $request->deskripsi,
                'url_youtube' => $request->url_youtube,
                'status'      => $request->status,
                'user_id'     => Auth::id() ?? 1,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Video berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan video: ' . $e->getMessage());
        }
    }

    public function videoUpdate(Request $request, $id)
    {
        $request->validate([
            'judul'       => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'url_youtube' => 'required|url',
            'status'      => 'required|in:published,archived',
        ]);

        DB::beginTransaction();
        try {
            $video = Video::findOrFail($id);

            $video->update([
                'judul'       => $request->judul,
                'slug'        => Str::slug($request->judul) . '-' . Str::random(5),
                'deskripsi'   => $request->deskripsi,
                'url_youtube' => $request->url_youtube,
                'status'      => $request->status,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Video berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui video: ' . $e->getMessage());
        }
    }

    public function videoDestroy($id)
    {
        DB::beginTransaction();
        try {
            $video = Video::findOrFail($id);
            $video->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Video berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus video: ' . $e->getMessage());
        }
    }

    // ==========================================
    // 5. SLIDER (Galeri Slider)
    // ==========================================

    public function sliderIndex()
    {
        $sliderList = Slider::orderBy('urutan', 'asc')
            ->orderBy('urutan', 'desc')
            ->paginate(10);

        return view('konten-publikasi.slider', compact('sliderList'));
    }

    public function sliderStore(Request $request)
    {
        $request->validate([
            'judul'     => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar'    => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link'      => 'nullable|url',
            'urutan'    => 'nullable|integer',
            'status'    => 'required|in:active,inactive',
        ], [
            'gambar.required' => 'Gambar banner wajib diunggah.',
            'gambar.image'    => 'File yang diunggah harus berupa gambar.',
            'gambar.max'      => 'Ukuran gambar maksimal 2MB.',
        ]);

        try {
            $gambarPath = null;
            if ($request->hasFile('gambar')) {
                $gambarPath = $request->file('gambar')->store('sliders', 'public');
            }

            Slider::create([
                'judul'     => $request->judul,
                'deskripsi' => $request->deskripsi,
                'gambar'    => $gambarPath,
                'link'      => $request->link,
                'urutan'    => $request->urutan ?? 0,
                'status'    => $request->status,
            ]);

            return redirect()->back()->with('success', 'Banner slider berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan slider: ' . $e->getMessage());
        }
    }

    public function sliderUpdate(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);

        $request->validate([
            'judul'     => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link'      => 'nullable|url',
            'urutan'    => 'nullable|integer',
            'status'    => 'required|in:active,inactive',
        ], [
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.max'   => 'Ukuran gambar maksimal 2MB.',
        ]);

        try {
            $gambarPath = $slider->gambar;

            // Jika mengunggah gambar baru, hapus gambar lama dari storage
            if ($request->hasFile('gambar')) {
                if ($slider->gambar && Storage::disk('public')->exists($slider->gambar)) {
                    Storage::disk('public')->delete($slider->gambar);
                }
                $gambarPath = $request->file('gambar')->store('sliders', 'public');
            }

            $slider->update([
                'judul'     => $request->judul,
                'deskripsi' => $request->deskripsi,
                'gambar'    => $gambarPath,
                'link'      => $request->link,
                'urutan'    => $request->urutan ?? 0,
                'status'    => $request->status,
            ]);

            return redirect()->back()->with('success', 'Banner slider berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui slider: ' . $e->getMessage());
        }
    }

    public function sliderDestroy($id)
    {
        try {
            $slider = Slider::findOrFail($id);

            // Hapus file fisik dari Storage
            if ($slider->gambar && Storage::disk('public')->exists($slider->gambar)) {
                Storage::disk('public')->delete($slider->gambar);
            }

            $slider->delete();

            return redirect()->back()->with('success', 'Banner slider berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus slider: ' . $e->getMessage());
        }
    }
}
