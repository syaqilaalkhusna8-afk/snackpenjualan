<?php

// File Migration ini berfungsi untuk membuat tabel 'menus' di database
// [Kriteria 1: Jumlah Tabel Minimal 2] - (Tabel Kedua)


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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_menu');
            $table->integer('harga');
            $table->string('gambar')->nullable(); // Menyimpan link gambar atau nama file foto
            $table->text('deskripsi')->nullable(); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};