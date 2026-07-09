<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $countUser = User::count();
        $countMenu = Menu::count();
        $countOrder = Order::count();
        $totalPendapatan = Order::sum('total_harga');
        $pesananTerbaru = Order::latest()->take(5)->get();

        $salesPerDay = DB::table('orders')
            ->selectRaw('DATE(created_at) as tanggal, SUM(total_harga) as total')
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // [Relasi Data] Menu terlaris dihitung dari tabel order_details
        // (relasi order_details -> menus), bukan lagi parsing string manual.
        $bestSeller = OrderDetail::select('menu_id', DB::raw('SUM(qty) as total'))
            ->with('menu')
            ->groupBy('menu_id')
            ->having('total', '>', 1) // hanya tampilkan yang terjual lebih dari 1 kali
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->map(fn ($row) => [
                'items' => $row->menu->nama_menu ?? 'Menu Dihapus',
                'total' => $row->total,
            ])
            ->values();

            return view('admin.dashboard', [
            'countUser' => $countUser,
            'countMenu' => $countMenu,
            'countOrder' => $countOrder,
            'totalPendapatan' => $totalPendapatan,
            'pesananTerbaru' => $pesananTerbaru,
            'salesPerDay' => $salesPerDay,
            'bestSeller' => $bestSeller
        ]);
    }
}