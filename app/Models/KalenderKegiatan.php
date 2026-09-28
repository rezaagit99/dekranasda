<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KalenderKegiatan extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak menggunakan penamaan jamak bawaan Laravel
    protected $table = 'kalender_kegiatan';
    
    // Tentukan primary key jika tidak menggunakan 'id'
    protected $primaryKey = 'kegiatan_id';

    // Kolom yang diizinkan untuk dikirim via Mass Assignment
    protected $fillable = [
        'nama_kegiatan',
        'slug',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'penyelenggara',
        'status',
        'user_id',
    ];

    // Casting tipe data tanggal agar otomatis menjadi objek Carbon
    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    // Relasi ke tabel User (Penulis/Pembuat)
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
