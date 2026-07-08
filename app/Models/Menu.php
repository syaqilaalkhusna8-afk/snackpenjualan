<?php

// Model ini merepresentasikan tabel 'menus' di database
// [Kriteria 1: Jumlah Tabel Minimal 2] - (Tabel Menu)


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    // Pastikan Laravel tahu ini terhubung ke tabel 'menus'
    protected $table = 'menus';

    // Kolom-kolom yang diizinkan untuk diisi data
    protected $fillable = [
        'nama_menu',
        'harga',
        'gambar',
        'deskripsi'
    ];
    public function details()
{
    return $this->hasMany(OrderDetail::class);
}
}