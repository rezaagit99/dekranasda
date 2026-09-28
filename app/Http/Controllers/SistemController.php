<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Validation\Rule;
use App\Notifications\StatusAccountUpdated;

class SistemController extends Controller
{
    public function index(Request $request) {

        // Cek apakah user yang login BUKAN Super Admin (Role 1)
        if (auth()->user()->role_id != 1) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        $users = User::select(
            'users.*', 
            'roles.role_nama',
            'umkm.nama_umkm'
        )
        ->leftJoin('roles', 'users.role_id', '=', 'roles.role_id') // Cocokkan users.role_id dengan roles.id (atau roles.role_id)
        ->leftJoin('umkm', 'users.umkm_id', '=', 'umkm.umkm_id') // Cocokkan users.umkm dengan umkm.id
        ->paginate(10);

        $roles = DB::table('roles')->get();

        // 1. Data UMKM khusus untuk Modal TAMBAH (hanya yang BELUM terikat user)
        $umkmsUnassigned = Umkm::whereDoesntHave('user')->get();

        // 2. Data UMKM untuk Modal EDIT (ambil semua agar option yang sedang terikat tetap valid di Blade)
        $umkmsAll = Umkm::all();

        // Jika request dipanggil via AJAX (misal: saat pencarian, filter, atau reload tabel)
        if ($request->ajax()) {
            return view('pengaturan-sistem.manajemen-user-table', compact('users', 'roles', 'umkmsAll', 'umkmsUnassigned'))->render();
        }

        // Tampilan normal saat halaman pertama kali dibuka/di-refresh browser
        return view('pengaturan-sistem.manajemen-user', compact('users', 'roles', 'umkmsAll', 'umkmsUnassigned'));
    }

    public function store(Request $request) {

        if (auth()->user()->role_id != 1) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // 1. Validasi Data Input
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:8',
            'role_id'    => 'required|exists:roles,role_id',
            'status'     => 'required|in:terverifikasi,menunggu,ditolak,nonaktif',
            
            // Aturan UMKM: Wajib diisi jika role_id == 3, harus ada di tabel umkms, dan harus unik (1 UMKM = 1 Akun)
            'umkm_id'    => [
                'required_if:role_id,3',
                'nullable',
                'exists:umkm,umkm_id',
                'unique:users,umkm_id',
            ],
            
            'no_telp'    => 'nullable|string|max:20|unique:users,no_telp',
            'instagram'  => 'nullable|string|max:100',
            'alamat'     => 'nullable|string',
            'foto'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            // Pesan Error Kustom
            'name.required'       => 'Nama lengkap wajib diisi.',
            'email.required'      => 'Email wajib diisi.',
            'email.email'         => 'Format email tidak valid.',
            'email.unique'        => 'Email sudah terdaftar, gunakan email lain.',
            'password.required'   => 'Password wajib diisi.',
            'password.min'        => 'Password minimal 8 karakter.',
            'role_id.required'    => 'Role pengguna wajib dipilih.',
            'status.required'     => 'Status akun wajib dipilih.',
            'umkm_id.required_if' => 'UMKM wajib dipilih jika role adalah UMKM.',
            'umkm_id.exists'      => 'Data UMKM yang dipilih tidak ditemukan.',
            'umkm_id.unique'      => 'UMKM ini sudah terikat dengan pengguna lain.',
            'no_telp.unique'      => 'Nomor telepon/WA sudah terdaftar.',
            'foto.image'          => 'File foto profil harus berupa gambar.',
            'foto.mimes'          => 'Format foto harus JPEG, PNG, JPG, atau WEBP.',
            'foto.max'            => 'Ukuran foto profil maksimal 2MB.',
        ]);

        DB::beginTransaction();
        $fotoPath = null;

        try {
            // 2. Handle Upload Foto Profil jika ada
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('foto-profil', 'public');
            }

            // 3. Simpan Data Pengguna Baru
            User::create([
                'name'       => $request->name,
                'email'      => $request->email,
                'password'   => Hash::make($request->password),
                'role_id'    => $request->role_id,
                'status'     => $request->status,
                
                // Hanya simpan umkm_id jika role_id = 3 (UMKM), selain itu set NULL
                'umkm_id'    => $request->role_id == 3 ? $request->umkm_id : null,
                
                'no_telp'    => $request->no_telp,
                'instagram'  => $request->instagram ? ltrim($request->instagram, '@') : null,
                'alamat'     => $request->alamat,
                'foto'       => $fotoPath,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan!');

        } catch (Exception $e) {
            DB::rollBack();

            // Hapus file foto dari storage jika proses simpan DB gagal
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }

            return redirect()->back()
                ->withInput($request->except('password', 'foto'))
                ->with('error', 'Gagal menambahkan pengguna: ' . $e->getMessage());
        }
    }

    public function update(Request $request, User $user)
    {
        if (auth()->user()->role_id != 1) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // 1. Simpan status LAMA sebelum di-update
        $oldStatus = $user->status;

        // 2. Validasi Input
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password'  => ['nullable', 'string', 'min:8'],
            'role_id'   => ['required', 'exists:roles,role_id'],
            'status'    => ['required', Rule::in(['terverifikasi', 'menunggu', 'ditolak', 'nonaktif'])],
            'umkm'      => ['nullable', 'string', 'max:255'],
            'no_telp'   => ['nullable', 'string', 'max:20'],
            'instagram' => ['nullable', 'string', 'max:100'],
            'alamat'    => ['nullable', 'string'],
            'foto'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        try {
            // 3. Handle Upload Foto Baru
            if ($request->hasFile('foto')) {
                if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                    Storage::disk('public')->delete($user->foto);
                }
                $validated['foto'] = $request->file('foto')->store('users', 'public');
            } else {
                unset($validated['foto']);
            }

            // 4. Handle Password
            if ($request->filled('password')) {
                $validated['password'] = Hash::make($request->password);
            } else {
                unset($validated['password']);
            }

            // 5. Update Database User
            $user->update($validated);

            // 6. SINKRONISASI STATUS KE TABEL UMKM & KIRIM EMAIL
            if ($oldStatus !== $user->status) {
                
                // Update status pada tabel UMKM milik user terkait (jika ada)
                // Catatan: Gunakan nama relasi yang sesuai di model User (misal: umkmByUser atau umkm)
                $umkm = $user->umkmByUser ?? $user->umkm; 
                
                if ($umkm) {
                    $umkm->update([
                        'status' => $user->status
                    ]);
                }

                // Kirim email notifikasi ke user mengenai perubahan status
                $user->notify(new StatusAccountUpdated($user->status));
            }

            return redirect()->route('manajemen-user.index')
                ->with('success', "Data user {$user->name} dan status UMKM berhasil diperbarui.");

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy(User $user) {
        if (auth()->user()->role_id != 1) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        try {
            // 1. Hapus Foto dari Storage jika ada
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            // 2. Simpan nama untuk alert pesan
            $userName = $user->name;

            // 3. Hapus Record dari Database
            $user->delete();

            return redirect()->route('manajemen-user.index')
                ->with('success', "User {$userName} berhasil dihapus.");

        } catch (Exception $e) {
            return redirect()->route('manajemen-user.index')
                ->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }

}
