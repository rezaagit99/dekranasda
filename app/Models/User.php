<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use App\Models\Berita;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Nama tabel (opsional karena secara default Eloquent membaca 'users')
     */
    protected $table = 'users';

    /**
     * Kolom yang dapat diisi secara mass assignment (Create/Update)
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
        'remember_token',
        'role_id',
        'status',
        'foto',
        'umkm_id',
        'no_telp',
        'alamat',
        'instagram',
    ];

    /**
     * Kolom yang disembunyikan saat data di-convert ke Array atau JSON
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * Casting tipe data kolom agar otomatis dikonversi oleh Laravel
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'two_factor_confirmed_at' => 'datetime',
        'password' => 'hashed', // Otomatis meng-hash password saat disimpan
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function beritas(): HasMany
    {
        return $this->hasMany(Berita::class, 'user_id', 'id');
    }

    public function umkm()
    {
        return $this->hasOne(Umkm::class, 'user_id');
    }

    public function umkmByUser()
    {
        return $this->belongsTo(Umkm::class, 'umkm_id', 'umkm_id');
    }
}
