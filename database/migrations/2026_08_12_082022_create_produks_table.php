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
        Schema::create('produks', function (Blueprint $table) {
            $table->id('produk_id'); // Primary key
            
            // Foreign Key ke tabel umkm
            $table->unsignedBigInteger('umkm_id');
            $table->foreign('umkm_id')
                  ->references('umkm_id')
                  ->on('umkm')
                  ->onDelete('cascade'); // Jika UMKM dihapus, produk ikut terhapus

            $table->string('nama_produk');
            $table->string('slug')->nullable();
            $table->decimal('harga', 12, 2)->default(0);
            $table->text('deskripsi')->nullable();
            $table->string('foto_produk')->nullable();
            
            // Status ketersediaan: available / out_of_stock
            $table->enum('status', ['available', 'out_of_stock'])->default('available');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
