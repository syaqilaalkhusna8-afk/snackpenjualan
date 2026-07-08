@extends('layouts.admin_layout')

@section('admin_content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-3 mb-4 border-bottom">
        <div>
            <h1 class="h3 fw-bold text-dark mb-0">Pesanan Masuk</h1>
            <p class="text-secondary small mb-0 mt-1">Daftar pesanan terbaru dari pelanggan Street Food.</p>
        </div>
            <a href="{{ route('orders.pdf') }}" class="btn btn-danger mb-3">
                <i class="bi bi-file-earmark-pdf"></i>Export PDF
            </a>
    </div>

    <div class="card border-0 shadow-sm rounded-0 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light text-secondary text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">
                        <tr>
                            <th class="ps-4 py-3 border-0 fw-semibold">ID Pesanan</th>
                            <th class="border-0 fw-semibold">Pelanggan</th>
                            <th class="border-0 fw-semibold">Detail Menu</th>
                            <th class="border-0 fw-semibold">Total Bayar</th>
                            <th class="border-0 fw-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="ps-4 py-3 fw-bold text-dark">#ORD-{{ $order->id }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $order->nama_pelanggan }}</div>
                                <div class="text-muted small">{{ $order->created_at->format('d M Y, H:i') }}</div>
                            </td>
                            <td class="text-dark small fw-medium">{{ $order->items }}</td>
                            <td class="text-orange fw-bold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                            <td class="text-center">
                                @if($order->status == 'menunggu')
                                    <form action="{{ url('/admin/orders/konfirmasi/' . $order->id) }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="btn btn-orange rounded-0 fw-bold border-0 shadow-sm" style="font-size: 0.75rem; min-width: 120px; height: 35px;">
                                            KONFIRMASI
                                        </button>
                                    </form>
                                @else
                                    <span class="badge bg-success rounded-0 fw-bold d-inline-flex align-items-center justify-content-center border-0 shadow-sm" style="font-size: 0.75rem; min-width: 120px; height: 35px;">
                                        <i class="bi bi-check-all me-1 fs-6"></i> SELESAI
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($orders->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-inbox text-muted fs-1"></i>
                        <p class="text-muted mt-2">Belum ada pesanan yang masuk.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection