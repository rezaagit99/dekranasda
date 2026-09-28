<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use DB;
use App\Models\User;
use App\Models\Umkm;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validasi Input Data User & UMKM
        $request->validate([
            // Input User
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'    => ['required', 'string', 'min:8', 'confirmed'],
            'no_telp'     => ['nullable', 'string', 'max:100'],
            'instagram'   => ['nullable', 'string', 'max:100'],
            'g-recaptcha-response' => ['required'],
            // Input UMKM
            'nama_umkm'   => ['required', 'string', 'max:255'],
            'kategori'    => ['nullable', 'string', 'max:255'],
            'alamat'      => ['nullable', 'string'],
            'deskripsi'   => ['nullable', 'string'],
            'foto_umkm'   => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'g-recaptcha-response.required' => 'Wajib mencentang verifikasi captcha terlebih dahulu.',
            'name.required'      => 'Nama pemilik wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email ini sudah terdaftar.',
            'password.required'  => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'nama_umkm.required' => 'Nama Usaha/UMKM wajib diisi.',
            'foto_umkm.max'      => 'Ukuran foto maksimal 2MB.',
        ]);

        // Verifikasi captcha ke API Google
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => config('services.recaptcha.secret_key'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!$response->json('success')) {
            return back()->withInput()->withErrors([
                'g-recaptcha-response' => 'Verifikasi captcha gagal, silakan coba lagi.'
            ]);
        }

        // 2. Gunakan DB Transaction agar pembuatan User & UMKM saling terikat
        DB::beginTransaction();
        try {
            // Upload foto UMKM jika ada
            $fotoPath = null;
            if ($request->hasFile('foto_umkm')) {
                $fotoPath = $request->file('foto_umkm')->store('umkm', 'public');
            }

            // A. Simpan Data User (role_id = 3, status = 'menunggu')
            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'role_id'   => 3,           // Role UMKM
                'status'    => 'menunggu',  // Perlu verifikasi Superadmin
                'no_telp'   => $request->no_telp,
                'alamat'    => $request->alamat,
                'instagram' => $request->instagram,
            ]);

            // B. Simpan Data UMKM
            $slugBase = Str::slug($request->nama_umkm);
            $slug = $slugBase . '-' . Str::random(5); // Slug unik

            $umkm = Umkm::create([
                'nama_umkm' => $request->nama_umkm,
                'slug'      => $slug,
                'kategori'  => $request->kategori,
                'alamat'    => $request->alamat,
                'deskripsi' => $request->deskripsi,
                'foto_umkm' => $fotoPath,
                'status'    => 'menunggu',
                'user_id'   => $user->id,
            ]);

            // C. Hubungkan umkm_id ke tabel users (relasi balik)
            $user->update([
                'umkm_id' => $umkm->umkm_id,
                'foto'    => $fotoPath,
            ]);

            DB::commit();

            return redirect()->route('login')->with(
                'status', 
                'Pendaftaran UMKM berhasil! Akun Anda saat ini sedang dalam proses verifikasi oleh Admin kami. Informasi selanjutnya akan kami kirimkan melalui email yang telah Anda daftarkan.'
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Gagal mendaftar: ' . $e->getMessage()]);
        }
    }

    public function login()
    {
        // Jika sudah login, langsung lempar ke dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login'); // Sesuaikan path lokasi view Blade Anda
    }

    /**
     * Memproses otentikasi login pengguna & mengelola Session.
     */
    public function authenticate(Request $request)
    {
        // 1. Validasi khusus format email & password
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // 2. Tambahkan syarat status 'terverifikasi' ke dalam attempt
        $credentialsWithStatus = array_merge($credentials, [
            'status' => 'terverifikasi'
        ]);

        // 3. Eksekusi Login
        if (Auth::attempt($credentialsWithStatus, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))
                            ->with('status', 'Selamat datang kembali!');
        }

        // 4. Cek alasan kegagalan: Apakah karena status belum terverifikasi?
        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            if ($user->status !== 'terverifikasi') {
                return back()->withErrors([
                    'email' => 'Akun Anda belum aktif/terverifikasi. Silakan tunggu konfirmasi dari Admin.',
                ])->onlyInput('email');
            }
        }

        // 5. Jika memang email atau password salah
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Memproses Logout dan Menghancurkan Session.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate session & regenerasi token CSRF demi keamanan
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Anda telah berhasil keluar.');
    }
}
