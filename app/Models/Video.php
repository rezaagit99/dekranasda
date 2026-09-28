<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;

    protected $table = 'video';
    protected $primaryKey = 'video_id';

    protected $fillable = [
        'judul',
        'slug',
        'deskripsi',
        'url_youtube',
        'status',
        'user_id',
    ];

    /**
     * Relasi ke model User (Uploader / Author)
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Accessor untuk mendapatkan URL Thumbnail YouTube secara otomatis
     */
    public function getThumbnailUrlAttribute()
    {
        if (empty($this->url_youtube)) {
            return asset('images/default-video.png');
        }

        preg_match(
            '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/shorts\/)([^"&?\/\s]{11})/',
            $this->url_youtube,
            $matches
        );

        $videoId = $matches[1] ?? null;

        if ($videoId) {
            return "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
        }

        return asset('images/default-video.png');
    }
}
