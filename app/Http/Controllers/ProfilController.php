<?php

namespace App\Http\Controllers;
use App\Models\Profil;
use App\Models\User;
use App\Models\Umkm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        if (auth()->user()->role_id != 1) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $profil = Profil::first();

        return view('profil.profil', compact('profil'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'visi'              => 'nullable|string',
            'misi'              => 'nullable|string',
            'deskripsi_singkat' => 'nullable|string',
            'foto_struktur'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'foto_dekranasda'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'alamat'            => 'nullable|string',
            'telepon'           => 'nullable|string|max:50',
            'email'             => 'nullable|email|max:255',
            'link_maps'         => 'nullable|url',
            'instagram'         => 'nullable|string|max:100',
            'youtube'           => 'nullable|url|max:255',
        ]);

        $profil = Profil::first() ?? new Profil();

        $data = $request->only([
            'visi', 
            'misi', 
            'deskripsi_singkat', 
            'alamat', 
            'telepon', 
            'email', 
            'link_maps',
            'instagram',
            'youtube',
            'foto_dekranasda'
        ]);

        // Ganti foto jika ada upload baru
        if ($request->hasFile('foto_struktur')) {
            if ($profil->foto_struktur && Storage::disk('public')->exists($profil->foto_struktur)) {
                Storage::disk('public')->delete($profil->foto_struktur);
            }
            $data['foto_struktur'] = $request->file('foto_struktur')->store('profil', 'public');
        }

        // Ganti foto jika ada upload baru
        if ($request->hasFile('foto_dekranasda')) {
            if ($profil->foto_dekranasda && Storage::disk('public')->exists($profil->foto_dekranasda)) {
                Storage::disk('public')->delete($profil->foto_dekranasda);
            }
            $data['foto_dekranasda'] = $request->file('foto_dekranasda')->store('profil', 'public');
        }

        $profil->fill($data);
        $profil->save();

        return redirect()->back()->with('success', 'Profil dan informasi kontak berhasil diperbarui!');
    }

    public function profilSaya()
    {
        $user = User::with('umkmByUser')->findOrFail(auth()->id());

        return view('profil.profil-saya', compact('user'));
    }

    public function updateProfilSaya(Request $request)
    {
        $user = User::findOrFail(auth()->id());

        // 1. Validasi Input Akun Pengguna
        $rules = [
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'no_telp'   => 'nullable|string|max:20',
            'instagram' => 'nullable|string|max:100',
            'alamat'    => 'nullable|string',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'password'  => 'nullable|string|min:8',
        ];

        // 2. Validasi Khusus Role UMKM (role_id = 3)
        if ($user->role_id == 3) {
            $rules['nama_umkm'] = 'required|string|max:255';
            $rules['kategori']  = 'required|string';
            $rules['foto_umkm'] = 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120';
        }

        $request->validate($rules);

        // 3. Update Data User
        $userData = [
            'name'      => $request->name,
            'email'     => $request->email,
            'no_telp'   => $request->no_telp,
            'instagram' => $request->instagram ? ltrim($request->instagram, '@') : null,
            'alamat'    => $request->alamat,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }
            $userData['foto'] = $request->file('foto')->store('foto-profil', 'public');
        }

        $user->update($userData);

        // 4. Update Data UMKM jika User memiliki Role 3 (UMKM)
        if ($user->role_id == 3 && $user->umkm_id) {
            // Ambil instance model UMKM via relasi belongsTo
            $umkm = $user->umkmByUser;

            if ($umkm) {
                $umkmData = [
                    'nama_umkm' => $request->nama_umkm,
                    'kategori'  => $request->kategori,
                    'deskripsi' => $request->deskripsi_umkm,
                    'alamat'    => $request->alamat_umkm,
                ];

                if (auth()->user()->role_id == 1 && $request->has('status_umkm')) {
                    $umkmData['status'] = $request->status_umkm;
                }

                // Handle upload Foto / Logo UMKM
                if ($request->hasFile('foto_umkm')) {
                    // Hapus foto lama jika ada di storage
                    if ($umkm->foto_umkm && Storage::disk('public')->exists($umkm->foto_umkm)) {
                        Storage::disk('public')->delete($umkm->foto_umkm);
                    }

                    // Simpan foto baru
                    $umkmData['foto_umkm'] = $request->file('foto_umkm')->store('umkm-logo', 'public');
                }

                // Lakukan update ke database
                $umkm->update($umkmData);
            }
        }

        return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui!');
    }


}
