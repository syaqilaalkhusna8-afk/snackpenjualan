<?php

// File Seeder ini berfungsi untuk mengisi data awal akun (Admin & User) ke tabel users
// [Kriteria 3: Menggunakan Migration+Seeder] & [Kriteria 7: Autentikasi Multi Role]


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Admin
        User::create([
            'name' => 'Admin Street Food',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Akun User Biasa
        User::create([
            'name' => 'Guest (User)',
            'email' => 'guest@gmail.com',
            'password' => Hash::make('guest123'),
            'role' => 'user',
        ]);
    }
}