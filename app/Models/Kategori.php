<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';
    protected $primaryKey = 'kategori_id';

    protected $fillable = [
        'nama_kategori',
        'slug',
        'deskripsi',
    ];

    // Relasi ke Produk (opsional jika nanti tabel produks menggunakan kategori_id)
    public function produks()
    {
        return $this->hasMany(Produk::class, 'kategori_id', 'kategori_id');
    }
}
