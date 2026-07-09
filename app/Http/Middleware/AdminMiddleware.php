<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Middleware ini memastikan hanya user dengan role 'admin'
     * yang bisa mengakses route yang dilindungi (mis. semua route /admin/*).
     * Dipasang SETELAH middleware 'auth', jadi user pasti sudah login
     * saat middleware ini jalan.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman admin.');
        }

        return $next($request);
    }
}
