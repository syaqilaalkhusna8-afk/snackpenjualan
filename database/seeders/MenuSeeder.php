<?php

// File Seeder ini berfungsi untuk mengisi data awal daftar menu ke database
// [Kriteria 3: Menggunakan Migration+Seeder]


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu; // model Menu

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Data 1
        Menu::create([
            'nama_menu' => 'Spicy Tteokbokki',
            'harga' => 25000,
            'deskripsi' => 'Kue beras kenyal khas Korea dengan saus gochujang pedas manis yang autentik.',
            'gambar' => 'tteokbokki.jpg'
        ]);

        // Data 2
        Menu::create([
            'nama_menu' => 'Takoyaki Octopus',
            'harga' => 20000,
            'deskripsi' => 'Bola-bola gurita panas dengan taburan katsuobushi dan saus takoyaki spesial.',
            'gambar' => 'takoyaki.jpg'
        ]);

        // Data 3
        Menu::create([
            'nama_menu' => 'Corndog Mozzarella',
            'harga' => 18000,
            'deskripsi' => 'Sosis berbalut keju mozzarella lumer yang digoreng krispi dengan saus mustard.',
            'gambar' => 'corndog.jpg'
        ]);
    }
}