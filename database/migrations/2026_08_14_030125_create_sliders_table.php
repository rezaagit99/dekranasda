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
       Schema::create('sliders', function (Blueprint $table) {
            $table->id('slider_id');
            $table->string('judul')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('gambar');
            $table->string('link')->nullable(); // URL tujuan jika slider diklik
            $table->integer('urutan')->default(0); // Untuk pengurutan slide
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
