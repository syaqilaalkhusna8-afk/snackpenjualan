<?php

// Controller ini menangani logika Keranjang Belanja (Cart)


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class CartController extends Controller
{
    // Menampilkan Halaman Keranjang
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // Hitung total harga
        $total = 0;
        foreach($cart as $item) {
            $total += $item['harga'] * $item['quantity'];
        }

        return view('user.cart', compact('cart', 'total'));
    }

    // Menambah Menu ke Keranjang
    public function add(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        
        // Ambil data keranjang dari session saat ini
        $cart = session()->get('cart', []);

        // Jika menu sudah ada di keranjang, tambah jumlah
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Jika belum ada, buat data baru di keranjang
            $cart[$id] = [
                "id" => $menu->id,
                "nama_menu" => $menu->nama_menu,
                "quantity" => 1,
                "harga" => $menu->harga,
                "gambar" => $menu->gambar
            ];
        }

        // Simpan kembali ke session
        session()->put('cart', $cart);

        return back()->with('success', $menu->nama_menu . ' berhasil masuk ke keranjang!');
    }

    // Menghapus Menu dari Keranjang
    public function remove($id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            unset($cart[$id]); 
            session()->put('cart', $cart); 
        }

        return back()->with('success', 'Menu dihapus dari keranjang.');
    }
}