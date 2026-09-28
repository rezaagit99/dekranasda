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
        Schema::create('profils', function (Blueprint $table) {
            $table->id('profil_id');
            
            // Profil & Struktur Organisasi
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->string('foto_struktur')->nullable();
            $table->text('deskripsi_singkat')->nullable();
            
            // Informasi Kontak / Tentang Kami (Dari Gambar)
            $table->text('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->text('link_maps')->nullable(); // URL Google Maps

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profils');
    }
};
