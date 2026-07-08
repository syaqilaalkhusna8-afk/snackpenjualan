<!-- NAVBAR TERPISAH -->
@extends('layouts.app')
    
    @section('content')
    <!-- HEADER AWAL WELLCOME USER -->
    <section class="hero-section">
        <div class="container position-relative" style="z-index: 2;">
            <div class="row">
                <div class="col-md-8 col-lg-7 ms-xl-5">
                    
                    <div class="hero-text-box p-4 p-md-5 shadow-sm">
                        @auth
                            <div class="font-cursive text-orange mb-2" style="font-size: 3rem;">Welcome to Snack Zone, {{ Auth::user()->name }}!</div>
                        @else
                            <div class="font-cursive text-orange mb-2" style="font-size: 3rem;">Welcome to Snack Zone</div>
                        @endauth
                        
                        <h1 class="fw-bold mb-3 text-dark" style="font-size: 3.2rem; letter-spacing: 1px;">Temukan Snack Favoritmu</h1>
                        
                        <p class="text-secondary mb-4 lh-lg" style="font-size: 0.95rem; max-width: 550px;">
                            Nikmati berbagai pilihan snack lezat mulai dari yang asin, gurih, pedas, dan manis dengan harga terjangkau!
                        </p>
                        
                        <a href="#dishes" class="btn btn-orange mt-2">Order Sekarang</a>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>

    <!-- ABOUT -->
    <section id="about" class="section-padding bg-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 text-center text-md-start">
                    <h2 class="font-cursive mb-0" style="font-size: 3.5rem;">Our Story</h2>
                    <div class="divider-icon justify-content-center justify-content-md-start">
                        <hr style="margin-left: 0;">
                        <i class="bi bi-heart-fill fs-5"></i>
                        <hr>
                    </div>
                    <p class="text-muted lh-lg">Kami percaya bahwa makanan enak bisa dinikmati kapan saja, tanpa harus di tempat mewah. Snack Zone hadir untuk memberikan pengalaman kuliner lezat dengan harga yang ramah di kantong. Semua menu kami dibuat dari bahan segar pilihan setiap harinya.</p>
                    <a href="#" class="btn btn-orange mt-3">READ MORE</a>
                </div>
                <div class="col-md-6">
                    <img src="https://i.pinimg.com/1200x/ed/50/2a/ed502a74c7e7371c5ebcaf5a3dda5521.jpg" class="img-fluid rounded shadow" alt="Couple Dining">
                </div>
            </div>
        </div>
    </section>

    <!-- MENU POPULAR -->
    <section id="dishes" class="section-padding bg-light">
        <div class="container text-center position-relative">
            <h2 class="font-cursive mb-0" style="font-size: 3.5rem;">Our Popular</h2>
            <div class="divider-icon">
                <hr>
                <i class="bi bi-cup-hot-fill fs-4"></i>
                <hr>
            </div>
            <p class="text-muted mx-auto mb-5" style="max-width: 700px; font-size: 0.95rem;">
                Pilihan menu terbaru dari kami. Nikmati kelezatan snack dengan rasa yang tak terlupakan.
            </p>
            
            <!-- CAROUSEL MENU TERBARU -->
            <div id="popularMenuCarousel" class="carousel slide pb-5 position-relative" data-bs-ride="carousel">
                
                <div class="carousel-indicators" style="bottom: -15px;">
                    @foreach($menus->chunk(3) as $key => $chunk)
                        <button type="button" data-bs-target="#popularMenuCarousel" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}" aria-current="{{ $key == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $key + 1 }}"></button>
                    @endforeach
                </div>

                <div class="carousel-inner px-2">
                    
                    @foreach($menus->chunk(3) as $key => $chunk)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}" data-bs-interval="4000">
                        <div class="row g-4 mt-2">
                            
                            @foreach($chunk as $item)
                            <div class="col-md-4">
                                <div class="card h-100 border-0 shadow-sm p-2 text-start d-flex flex-column">
                                    
                                    <img src="{{ asset('images/' . $item->gambar) }}" onerror="this.src='https://img.magnific.com/premium-photo/chalsundae-sundae-rice-tteokbokki-tteokbokki-cup-rice-clear-fish-cake-spicy-fish-cake-sotteok-sotteok-colpalm-seaweed-roll-fried-yaki-dumpling_873119-8604.jpg?semt=ais_hybrid&w=740&q=80'" class="card-img-top rounded-0" style="height: 220px; object-fit: cover;" alt="{{ $item->nama_menu }}">
                                    
                                    <div class="card-body bg-white mt-2 d-flex flex-column p-2">
                                        <h5 class="card-title fw-bold mb-1">{{ $item->nama_menu }}</h5>
                                        
                                        <p class="text-muted small mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; flex-grow: 1;">
                                            {{ $item->deskripsi ?? 'Belum ada deskripsi untuk camilan ini.' }}
                                        </p>
                                        
                                        <div class="d-flex justify-content-between align-items-center mt-auto">
                                            <p class="card-text text-orange fw-bold fs-5 mb-0">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                            
                                            <form action="{{ url('/cart/add/' . $item->id) }}" method="POST" class="m-0">
                                                @csrf
                                                <button type="submit" class="btn btn-orange px-3 py-2">BELI</button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                    </div>
                
                <a class="custom-slider-btn slider-prev shadow" href="#popularMenuCarousel" role="button" data-bs-slide="prev">
                    <i class="bi bi-chevron-left fs-4"></i>
                </a>
                <a class="custom-slider-btn slider-next shadow" href="#popularMenuCarousel" role="button" data-bs-slide="next">
                    <i class="bi bi-chevron-right fs-4"></i>
                </a>
            </div>
            <div class="mt-5">
                <a href="{{ url('/menu') }}" class="btn btn-orange px-5 py-3 fw-bold shadow-sm" style="font-size: 0.95rem;">
                    LIHAT SEMUA MENU <i class="bi bi-arrow-right ms-2 fs-5 align-middle"></i>
                </a>
            </div>

        </div>
    </section>

    <!-- CONTACT ME -->
    <section id="contact" class="section-padding bg-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <h2 class="font-cursive mb-0" style="font-size: 3.5rem;">Hubungi Kami</h2>
                    <div class="divider-icon justify-content-start">
                        <i class="bi bi-geo-alt-fill fs-5"></i>
                        <hr style="margin-right: 0;">
                    </div>
                    <p class="text-muted mb-4">Silakan hubungi kami untuk informasi lebih lanjut atau pemesanan tempat.</p>
                    
                    <ul class="list-unstyled lh-lg fs-5 text-secondary">
                        <li class="mb-3">
                            <i class="bi bi-whatsapp text-success me-3 fs-4 align-middle"></i> 
                            <strong>WhatsApp:</strong> +62 819-9999-9999
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-envelope text-orange me-3 fs-4 align-middle"></i> 
                            <strong>Email:</strong> snackzone@gmail.com
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-clock text-orange me-3 fs-4 align-middle"></i> 
                            <strong>Jam Buka:</strong> 09:00 - 21:00 (Setiap Hari)
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-house-door text-orange me-3 fs-4 align-middle"></i> 
                            <strong>Alamat:</strong> Jl. Amhad Yani Alamat No. 123, Kediri, Jawa Timur Indonesia
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 text-center">
                    <img src="https://i.pinimg.com/1200x/ba/f5/d4/baf5d491ed6c8b71f7b8e68e7c33c398.jpg" class="img-fluid rounded shadow" style="object-fit: cover;" alt="Contact Us">
                </div>
            </div>
        </div>
    </section>
@endsection
