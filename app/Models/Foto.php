<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;

    protected $table = 'foto';
    protected $primaryKey = 'foto_id';

    protected $fillable = [
        'judul',
        'slug',
        'deskripsi',
        'file_foto',
        'kategori',
        'status',
        'user_id',
    ];

    /**
     * Relasi ke model User (Uploader)
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
