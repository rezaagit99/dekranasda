<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Produk;

class Umkm extends Model
{
    use HasFactory;

    protected $table = 'umkm';
    protected $primaryKey = 'umkm_id';

    protected $fillable = [
        'nama_umkm',
        'slug',
        'kategori',
        'alamat',
        'deskripsi',
        'foto_umkm',
        'status',
        'user_id',
    ];

    /**
     * Relasi ke User (Pemilik UMKM)
     */
    public function user()
    {
        return $this->hasOne(User::class, 'umkm_id', 'umkm_id');
    }

    public function produk()
    {
        return $this->hasMany(Produk::class, 'umkm_id', 'umkm_id');
    }
}
