@extends('layouts.app')

@section('content')
<section class="pt-5 mt-4 pb-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="font-cursive mb-0" style="font-size: 3rem;">Status Pesanan</h2>
            <div class="divider-icon">
                <hr><i class="bi bi-clock-history fs-4 text-orange"></i><hr>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <ul class="nav nav-pills justify-content-center mb-4" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-0 px-4 py-2 fw-bold me-2" id="pills-menunggu-tab" data-bs-toggle="pill" data-bs-target="#pills-menunggu" type="button" role="tab">PESANAN MENUNGGU</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-0 px-4 py-2 fw-bold" id="pills-selesai-tab" data-bs-toggle="pill" data-bs-target="#pills-selesai" type="button" role="tab">RIWAYAT PESANAN</button>
                    </li>
                </ul>

                <div class="tab-content pt-2" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-menunggu" role="tabpanel">
                        <div class="card border-0 shadow-sm rounded-0">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0">
                                        <thead class="bg-light small text-uppercase">
                                            <tr>
                                                <th class="ps-4 py-3 border-0">Order ID</th>
                                                <th class="border-0">Menu</th>
                                                <th class="border-0">Total</th>
                                                <th class="pe-4 border-0 text-end">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($ordersMenunggu as $order)
                                            <tr>
                                                <td class="ps-4 fw-bold">#{{ $order->id }}</td>
                                                <td class="text-muted small">{{ $order->items }}</td>
                                                <td class="fw-bold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                                <td class="pe-4 text-end">
                                                    <span class="badge bg-warning text-dark rounded-0 px-3 py-2 fw-bold" style="font-size: 0.7rem;">MENUNGGU</span>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr><td colspan="4" class="text-center py-5 text-muted">Belum ada pesanan yang sedang diproses.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-selesai" role="tabpanel">
                        <div class="card border-0 shadow-sm rounded-0">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0">
                                        <thead class="bg-light small text-uppercase">
                                            <tr>
                                                <th class="ps-4 py-3 border-0">Order ID</th>
                                                <th class="border-0">Menu</th>
                                                <th class="border-0">Total</th>
                                                <th class="pe-4 border-0 text-end">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($ordersSelesai as $order)
                                            <tr>
                                                <td class="ps-4 fw-bold">#{{ $order->id }}</td>
                                                <td class="text-muted small">{{ $order->items }}</td>
                                                <td class="fw-bold text-success">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                                <td class="pe-4 text-end">
                                                    <span class="badge bg-success rounded-0 px-3 py-2 fw-bold" style="font-size: 0.7rem;">SELESAI</span>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr><td colspan="4" class="text-center py-5 text-muted">Belum ada riwayat pesanan selesai.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .nav-pills .nav-link { color: #6c757d; background: #fff; border: 1px solid #dee2e6; transition: 0.3s; }
    .nav-pills .nav-link.active { background-color: #f2552c !important; color: #fff !important; border-color: #f2552c; }
    .nav-pills .nav-link:hover:not(.active) { color: #f2552c; border-color: #f2552c; }
</style>
@endsection