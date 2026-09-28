<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'roles';

    // Primary key tabel roles (karena Anda menggunakan 'role_id')
    protected $primaryKey = 'role_id';

    // Jika primary key bukan auto-increment integer biasa (opsional, kosongkan jika integer)
    public $incrementing = true;

    // Kolom yang dapat diisi massal
    protected $fillable = [
        'role_nama',
    ];

    /**
     * Relasi Kebalikan: Satu Role bisa dimiliki oleh Banyak User (One-to-Many)
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role_id', 'role_id');
    }
}