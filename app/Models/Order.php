<?php

// Model ini merepresentasikan tabel 'orders' di database untuk pesanan
// [Kriteria 1: Jumlah Tabel Minimal 2] - (Tabel Order)

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Mengizinkan field yang boleh diisi
    protected $fillable = [
        'nama_pelanggan',
        'items',
        'total_harga',
        'status'
    ];

    // Relasi: satu order memiliki banyak detail pesanan
    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}