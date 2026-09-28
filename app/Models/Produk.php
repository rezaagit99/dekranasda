<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    // use HasFactory;

    // protected $table = 'produks';
    // protected $primaryKey = 'produk_id';

    // protected $fillable = [
    //     'umkm_id',
    //     'kategori_id',
    //     'nama_produk',
    //     'slug',
    //     'harga',
    //     'deskripsi',
    //     'foto_produk',
    //     'status',
    // ];

    // /**
    //  * Relasi ke Model Umkm (Setiap Produk milik 1 UMKM)
    //  */
    // public function umkm()
    // {
    //     return $this->belongsTo(Umkm::class, 'umkm_id', 'umkm_id');
    // }

    // public function kategori()
    // {
    //     return $this->belongsTo(Kategori::class, 'kategori_id', 'kategori_id');
    // }

    use HasFactory;

    protected $table = 'produks';
    protected $primaryKey = 'produk_id';

    protected $fillable = [
        'umkm_id',
        'kategori_id',
        'nama_produk',
        'slug',
        'harga',
        'deskripsi',
        'foto_produk',
        'status',
        'views',
    ];

    /**
     * Cast kolom foto_produk menjadi array otomatis
     */
    protected $casts = [
        'foto_produk' => 'array',
    ];

    /**
     * Relasi ke Model Umkm
     */
    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'umkm_id', 'umkm_id');
    }

    /**
     * Relasi ke Model Kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'kategori_id');
    }
}
