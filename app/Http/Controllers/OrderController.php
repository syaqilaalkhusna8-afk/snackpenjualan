<?php

// Controller ini menangani proses Pemesanan dan Riwayat Pesanan


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
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
        foreach ($cart as $item) {
            $total += $item['harga'] * $item['quantity'];
            $itemStrings[] = $item['quantity'] . 'x ' . $item['nama_menu'];
        }

        // Simpan header pesanan (kolom 'items' tetap diisi untuk ringkasan cepat)
        $order = Order::create([
            'nama_pelanggan' => Auth::user()->name,
            'items' => implode(', ', $itemStrings),
            'total_harga' => $total,
            'status' => 'menunggu'
        ]);

        // [Relasi Data] Simpan detail tiap item ke tabel order_details
        // supaya relasi order -> order_details -> menu benar-benar terpakai
        foreach ($cart as $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'menu_id'  => $item['id'],
                'qty'      => $item['quantity'],
                'subtotal' => $item['harga'] * $item['quantity'],
            ]);
        }

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

    // Data grafik penjualan (dipakai canvas Chart.js di halaman Pesanan/Laporan)
    public function chartData()
    {
        $salesPerDay = DB::table('orders')
            ->selectRaw('DATE(created_at) as tanggal, SUM(total_harga) as total')
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $bestSeller = OrderDetail::select('menu_id', DB::raw('SUM(qty) as total'))
            ->with('menu')
            ->groupBy('menu_id')
            ->having('total', '>', 1)
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->map(fn ($row) => [
                'items' => $row->menu->nama_menu ?? 'Menu Dihapus',
                'total' => $row->total,
            ])
            ->values();

        return response()->json([
            'salesPerDay' => $salesPerDay,
            'bestSeller'  => $bestSeller,
        ]);
    }

    // Menerima PNG hasil render Chart.js (base64) lalu menyimpannya
    // ke storage/app/public/reports (storage link), supaya bisa
    // dipakai ulang sebagai gambar di dalam laporan PDF.
    public function saveChartImage(Request $request)
    {
        $request->validate([
            'sales_chart'      => 'required|string',
            'bestseller_chart' => 'nullable|string',
        ]);

        $this->storeBase64Image($request->sales_chart, 'reports/sales_chart.png');

        if ($request->filled('bestseller_chart')) {
            $this->storeBase64Image($request->bestseller_chart, 'reports/bestseller_chart.png');
        }

        return response()->json(['success' => true]);
    }

    private function storeBase64Image(string $base64, string $path): void
    {
        $raw = substr($base64, strpos($base64, ',') + 1);
        Storage::disk('public')->put($path, base64_decode($raw));
    }

    public function exportPDF()
    {
        $orders = Order::with('details.menu')->latest()->get();

        $totalPendapatan = $orders->sum('total_harga');
        $totalPesanan    = $orders->count();

        // Ambil path file chart PNG yang sudah disimpan lewat storage link
        // (jika admin belum pernah menekan tombol "Generate Laporan", akan null
        // dan bagian grafik di PDF otomatis disembunyikan).
        $salesChartPath = Storage::disk('public')->exists('reports/sales_chart.png')
            ? Storage::disk('public')->path('reports/sales_chart.png')
            : null;

        $bestsellerChartPath = Storage::disk('public')->exists('reports/bestseller_chart.png')
            ? Storage::disk('public')->path('reports/bestseller_chart.png')
            : null;

        $pdf = Pdf::loadView('admin.pdf.orders', compact(
            'orders',
            'totalPendapatan',
            'totalPesanan',
            'salesChartPath',
            'bestsellerChartPath'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('laporan-penjualan-' . now()->format('Ymd_His') . '.pdf');
    }
}