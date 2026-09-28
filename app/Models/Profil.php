<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class Profil extends Model
{
    use HasFactory;

    protected $table = 'profils';
    protected $primaryKey = 'profil_id';

    protected $fillable = [
        'visi',
        'misi',
        'foto_struktur',
        'deskripsi_singkat',
        'alamat',
        'telepon',
        'email',
        'link_maps',
        'instagram',
        'youtube',
        'foto_dekranasda'
    ];
}
