<?php

use Illuminate\Support\Facades\Route;
use App\Models\Menu;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;

/*
 PUBLIC ROUTES (Bisa diakses tanpa login)
*/

Route::get('/', function () {
    $menus = Menu::orderBy('id', 'desc')->take(6)->get();
    return view('user.beranda', compact('menus'));
});

Route::get('/menu', function () {
    $menus = Menu::orderBy('id', 'desc')->get();
    return view('user.menu', compact('menus'));
});
// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'processRegister']);

Route::post('/logout', [AuthController::class, 'logout']);

/*
 USER ROUTES (Harus Login)
*/

Route::middleware('auth')->group(function () {

    // Keranjang
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add/{id}', [CartController::class, 'add']);
    Route::get('/cart/remove/{id}', [CartController::class, 'remove']);

    // Checkout
    Route::post('/checkout', [OrderController::class, 'checkout']);

    // Riwayat Pesanan
    Route::get('/riwayat', [OrderController::class, 'history'])->name('riwayat');

});

/*
ADMIN ROUTES (Harus Login DAN role = admin)
*/

Route::middleware(['auth', 'admin'])->group(function () {

    // Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index']);

    // Kelola Menu
    Route::get('/admin/menus', [MenuController::class, 'index']);
    Route::post('/admin/menus', [MenuController::class, 'store']);
    Route::post('/admin/menus/update/{id}', [MenuController::class, 'update']);
    Route::get('/admin/menus/delete/{id}', [MenuController::class, 'destroy']);

    // Kelola Pesanan
    Route::get('/admin/orders', [OrderController::class, 'adminIndex'])->name('admin.orders');
    Route::post('/admin/orders/konfirmasi/{id}', [OrderController::class, 'konfirmasi']);

    // Grafik & Laporan PDF
    Route::get('/admin/orders/chart-data', [OrderController::class, 'chartData']);
    Route::post('/admin/orders/save-chart', [OrderController::class, 'saveChartImage']);
    Route::get('/admin/orders/pdf', [OrderController::class, 'exportPDF'])
    ->name('orders.pdf');
});