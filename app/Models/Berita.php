<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'beritas';
    protected $primaryKey = 'berita_id';

    protected $fillable = [
        'user_id',
        'judul',
        'slug',
        'ringkasan',
        'isi',
        'gambar_cover',
        'status',
        'views',
        'published_at',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Relasi ke User (Penulis/Author Berita)
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
