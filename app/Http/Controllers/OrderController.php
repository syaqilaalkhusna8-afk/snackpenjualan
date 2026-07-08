<?php

// Controller ini menangani proses Pemesanan dan Riwayat Pesanan


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    // === FITUR USER ===

    // Simpan Pesanan (Checkout)
    public function checkout(Request $request)
    {
        $cart = session()->get('cart');
        if (!$cart) { return back()->with('error', 'Keranjang kosong!'); }

        $total = 0;
        $itemStrings = []; 
        foreach($cart as $item) {
            $total += $item['harga'] * $item['quantity'];
            $itemStrings[] = $item['quantity'] . 'x ' . $item['nama_menu'];
        }

        Order::create([
            'nama_pelanggan' => Auth::user()->name,
            'items' => implode(', ', $itemStrings), 
            'total_harga' => $total,
            'status' => 'menunggu'
        ]); 

        session()->forget('cart');
        return redirect('/riwayat')->with('success', 'Pesanan berhasil dikirim!');
    }

    // Lihat Riwayat (User)
    public function history()
    {
        $namaUser = Auth::user()->name;
        $ordersMenunggu = Order::where('nama_pelanggan', $namaUser)->where('status', 'menunggu')->orderBy('id', 'desc')->get();
        $ordersSelesai = Order::where('nama_pelanggan', $namaUser)->where('status', 'selesai')->orderBy('id', 'desc')->get();

        return view('user.riwayat', compact('ordersMenunggu', 'ordersSelesai'));
    }

    // === FITUR ADMIN ===

    // Lihat Semua Pesanan (Admin)
    public function adminIndex()
    {
        $orders = Order::orderBy('id', 'desc')->get();
        return view('admin.admin_orders', compact('orders'));
    }

    // Konfirmasi Pesanan (Admin)
    public function konfirmasi(int $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'selesai']);
        return back()->with('success', 'Pesanan #' . $order->id . ' dikonfirmasi!');
    }
    public function exportPDF()
    {
        $orders = Order::latest()->get();
        $pdf = Pdf::loadView('admin.pdf.orders', compact('orders'));
        return $pdf->download('laporan-pesanan.pdf');
    }
}