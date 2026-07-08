<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Menu;
use App\Models\Order;
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
        $orders = DB::table('orders')->pluck('items');
        $menuCounts = [];
            foreach ($orders as $items) {
        $menus = explode(',', $items);
            foreach ($menus as $menu) {
        $menu = trim($menu);
        // Menghapus "1x ", "2x ", dll.
        $menu = preg_replace('/^\d+x\s*/', '', $menu);

            if (!isset($menuCounts[$menu])) {
            $menuCounts[$menu] = 0;
             }
        $menuCounts[$menu]++;
            }
        }

        arsort($menuCounts);

        $bestSeller = collect($menuCounts)
            ->filter(function ($total) {
            return $total > 1; // hanya tampilkan yang terjual lebih dari 1 kali
            })
            ->take(5)
            ->map(function ($total, $menu) {
            return [
            'items' => $menu,
            'total' => $total
            ];
        })
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