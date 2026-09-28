<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('beritas', function (Blueprint $table) {
            $table->id('berita_id'); // Primary key
            
            // Penulis (Relasi ke tabel users)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Konten Berita
            $table->string('judul');
            $table->string('slug')->unique(); // Untuk URL berita, misal: /berita/kegiatan-dekranasda-2026
            $table->text('ringkasan')->nullable(); // Untuk preview singkat di card/list berita
            $table->longText('isi'); // Konten utama (Rich Text / HTML)
            
            // Media & Status
            $table->string('gambar_cover')->nullable(); // Path gambar utama berita
            $table->enum('status', ['draft', 'published', 'archived'])->default('published');
            $table->unsignedBigInteger('views')->default(0); // Menghitung total pembaca

            // Tanggal Publikasi (Bisa diset khusus jika ingin scheduling)
            $table->timestamp('published_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
