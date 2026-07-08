<?php

// Controller ini berfungsi untuk manajemen Menu (CRUD) oleh Admin
// [Kriteria 2: Bisa CRUD] & [Kriteria 6: Menggunakan Validasi]


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\File; // Untuk menghapus file gambar lama

class MenuController extends Controller
{
    // Menampilkan Halaman Kelola Menu
    // Menampilkan daftar menu
    public function index()
    {
        $menus = Menu::orderBy('id', 'desc')->get(); // Ambil semua data menu, urutkan terbaru
        return view('admin.admin_menus', compact('menus'));
    }

    // Menyimpan Menu Baru (Create)
    public function store(Request $request)
    {
        
        // Memvalidasi input menu baru
        $request->validate([
            'nama_menu' => 'required',
            'harga' => 'required|numeric|max:10000000', 
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable'
        ]);


        $imageName = null; // jika tidak ada gambar

        // Cek apakah admin mengupload gambar
        if ($request->hasFile('gambar')) {
            $imageName = time() . '.' . $request->gambar->extension();  
            $request->gambar->move(public_path('images'), $imageName);
        }

        // Masukkan ke Database
        // Menyimpan data menu ke database
        Menu::create([
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga,
            'gambar' => $imageName, // Akan bernilai null jika tidak ada gambar
            'deskripsi' => $request->deskripsi,
        ]);

        return back()->with('success', 'Menu baru berhasil ditambahkan.');
    }


    // Mengupdate Menu (Edit)
    public function update(Request $request,int $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'nama_menu' => 'required',
            'harga' => 'required|numeric|max:1000000000',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Admin mengupload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if (File::exists(public_path('images/' . $menu->gambar))) {
                File::delete(public_path('images/' . $menu->gambar));
            }
            // Upload gambar baru
            $imageName = time() . '.' . $request->gambar->extension();  
            $request->gambar->move(public_path('images'), $imageName);
            $menu->gambar = $imageName;
        }

        // Update data lainnya
        $menu->nama_menu = $request->nama_menu;
        $menu->harga = $request->harga;
        $menu->deskripsi = $request->deskripsi;
        // [Kriteria 2: CRUD - Update] Menyimpan perubahan data ke database
        $menu->save();

        return back()->with('success', 'Menu berhasil diperbarui!');
    }


    // Menghapus Menu (Delete)
    public function destroy(int $id)
    {
        $menu = Menu::findOrFail($id);
        
        // Hapus file gambar dari folder public/images
        if (File::exists(public_path('images/' . $menu->gambar))) {
            File::delete(public_path('images/' . $menu->gambar));
        }

        // [Kriteria 2: CRUD - Delete] Menghapus data menu dari database
        $menu->delete(); // Hapus data dari database

        return back()->with('success', 'Menu berhasil dihapus!');
    }
}