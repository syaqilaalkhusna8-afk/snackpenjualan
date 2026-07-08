@extends('layouts.app')

@section('content')
<section class="pt-5 mt-4 pb-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="font-cursive mb-0" style="font-size: 3rem;">Keranjang Belanja</h2>
            <div class="divider-icon">
                <hr><i class="bi bi-cart-check-fill fs-4 text-orange"></i><hr>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="card border-0 shadow-sm rounded-0">
                    <div class="card-header bg-white py-3 border-bottom-0">
                        <h5 class="mb-0 fw-bold">Daftar Pesanan Anda</h5>
                    </div>
                    <div class="card-body p-0">
                        @if(session('cart') && count(session('cart')) > 0)
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead class="bg-light text-secondary small text-uppercase">
                                        <tr>
                                            <th class="ps-4 border-0">Produk</th>
                                            <th class="border-0">Harga</th>
                                            <th class="border-0 text-center">Jumlah</th>
                                            <th class="border-0">Subtotal</th>
                                            <th class="pe-4 border-0 text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(session('cart') as $id => $details)
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <span class="fw-bold text-dark">{{ $details['nama_menu'] }}</span>
                                                </div>
                                            </td>
                                            <td class="text-secondary">Rp {{ number_format($details['harga'], 0, ',', '.') }}</td>
                                            <td class="text-center fw-bold">{{ $details['quantity'] }}</td>
                                            <td class="text-orange fw-bold">Rp {{ number_format($details['harga'] * $details['quantity'], 0, ',', '.') }}</td>
                                            <td class="pe-4 text-end">
                                                <a href="{{ url('/cart/remove/' . $id) }}" class="btn btn-sm btn-outline-danger rounded-0 px-2 py-1" title="Hapus">
                                                    <i class="bi bi-x-lg"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-basket text-muted mb-3 d-block" style="font-size: 4rem;"></i>
                                <h5 class="text-muted">Keranjang Anda masih kosong.</h5>
                                <a href="{{ url('/menu') }}" class="btn btn-orange mt-3 rounded-0 px-4">Lihat Menu</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-0">
                    <div class="card-header bg-white py-3 border-bottom-0">
                        <h5 class="mb-0 fw-bold">Ringkasan Pesanan</h5>
                    </div>
                    <div class="card-body bg-light">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-secondary">Total Harga:</span>
                            <span class="fw-bold fs-5 text-dark">Rp {{ number_format($total ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <hr class="text-secondary">
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold fs-5">Total Bayar:</span>
                            <span class="fw-bold fs-4 text-orange">Rp {{ number_format($total ?? 0, 0, ',', '.') }}</span>
                        </div>
                        
                        <form action="{{ url('/checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-orange w-100 py-3 rounded-0 fw-bold" {{ (!session('cart') || count(session('cart')) == 0) ? 'disabled' : '' }}>
                                KONFIRMASI PESANAN
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection