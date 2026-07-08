<?php

// [ Menggunakan Migration+Seeder] - File pusat untuk menjalankan semua seeder


namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Memanggil file Seeder lain agar ikut dijalankan
        $this->call([
            MenuSeeder::class,
            UserSeeder::class, 
        ]);
    }
}