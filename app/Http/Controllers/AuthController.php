<?php

// Controller ini berfungsi untuk menangani sistem Autentikasi (Login, Register, Logout)



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Memanggil tabel users
use Illuminate\Support\Facades\Hash; // Untuk menyandikan password
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman Register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Memproses data Register
    public function processRegister(Request $request)
    {
        // Validasi data (pastikan tidak ada yang kosong dan email belum dipakai)
        // [KMenggunakan Validasi] - Memastikan data input sesuai aturan sebelum masuk database
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed' //  mencocokkan dengan password
        ], [
            // Pesan error 
            'email.unique' => 'Email ini sudah terdaftar!',
            'password.confirmed' => 'Konfirmasi password tidak cocok!'
        ]);

        // Masuk ke database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password di-hash
            'role' => 'user', // Default role "user"
        ]);

        // Pindah ke halaman login (pesan sukses)
        return redirect('/login')->with('success', 'Akun berhasil dibuat. Silakan Login.');
    }

    // Menampilkan halaman Login
    public function showLogin()
    {
        return view('auth.login');
    }


    // Memproses data Login
    public function processLogin(Request $request)
    {
        // Validasi input form
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Siapkan data email dan password untuk dicek
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        // Cek apakah email dan password cocok di database
        if (Auth::attempt($credentials)) {
            // Buat sesi baru untuk keamanan
            $request->session()->regenerate();

            // Autentikasi Multi Role] - Memeriksa role user untuk menentukan halaman tujuan login
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } 
            
            // Jika user, arahkan ke beranda
            return redirect()->intended('/');
        }

        // Jika salah, kembalikan ke halaman login dengan pesan error
        return back()->with('error', 'Email atau Password salah!');
    }


    // Memproses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 'success' dibaca oleh @if(session('success')) di blade
        return redirect('/')->with('success', 'Berhasil logout!');
    }
}