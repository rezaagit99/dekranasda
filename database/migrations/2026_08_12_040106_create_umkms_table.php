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
        Schema::create('umkm', function (Blueprint $table) {
            $table->id('umkm_id');
            $table->string('nama_umkm');
            $table->string('slug')->unique();
            $table->string('kategori')->nullable(); // Kuliner, Kerajinan, dll.
            $table->text('alamat')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('foto_umkm')->nullable();
            $table->enum('status', ['published', 'archived'])->default('published');
            
            // Foreign key ke tabel users (Setiap UMKM dimiliki oleh 1 User)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkm');
    }
};
