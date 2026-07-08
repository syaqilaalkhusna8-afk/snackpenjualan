<!-- NAVBAR TERPISAH -->
@extends('layouts.app')

    @section('content')

    <section class="pt-5 mt-4">
        <div class="container text-center">
            <h2 class="font-cursive mb-0">Our Menu</h2>
            <div class="divider-icon">
                <hr>
                <i class="bi bi-cup-hot-fill fs-4"></i> <hr>
            </div>
            <p class="text-muted mx-auto mb-5" style="max-width: 700px; font-size: 0.95rem;">
                Temukan snack favoritmu dengan rasa autentik dan tampilan menggoda. Perpaduan sempurna antara gurih, manis, dan pedas dalam setiap gigitan.
            </p>
        </div>
    </section>

    <section class="pb-5">
        <div class="container">
            <div class="row g-4">
                
                <!-- MEMBACA SEMUA TABEL MENUS DITAMPILAKN DALAM CARD -->
               @foreach($menus as $item)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm p-2 d-flex flex-column">
                        
                        <img src="{{ asset('images/' . $item->gambar) }}" onerror="this.src='https://img.magnific.com/premium-photo/chalsundae-sundae-rice-tteokbokki-tteokbokki-cup-rice-clear-fish-cake-spicy-fish-cake-sotteok-sotteok-colpalm-seaweed-roll-fried-yaki-dumpling_873119-8604.jpg?semt=ais_hybrid&w=740&q=80'" class="card-img-top rounded-0" style="height: 220px; object-fit: cover;" alt="{{ $item->nama_menu }}">
                        
                        <div class="card-body bg-white mt-2 d-flex flex-column p-2">
                            <h5 class="card-title fw-bold mb-1">{{ $item->nama_menu }}</h5>
                            
                            <p class="text-muted small mb-3"style="display: -webkit-box;display: box;line-clamp: 2;-webkit-line-clamp: 2;-webkit-box-orient: vertical;overflow: hidden;flex-grow:1;">
                                {{ $item->deskripsi ?? 'Belum ada deskripsi untuk camilan ini.' }}
                            </p>
                            
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <p class="card-text text-orange fw-bold fs-5 mb-0">
                                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                                </p>
                                <form action="{{ url('/cart/add/' . $item->id) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="btn btn-orange px-4 py-2">BELI</button>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endsection