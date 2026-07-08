<!-- [Kriteria 5: Navbar Terpisah] - File ini adalah Layout utama yang berisi Navbar -->
<!-- [Kriteria 4: Menggunakan Blade Templating] - Menggunakan fitur yield dan auth -->
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snack Zone</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            color: #444;
            background-color: #f8f9fa;
        }
        
        .section-padding { padding: 90px 0; }
        
        /* Font Latin */
        .font-cursive { 
            font-family: 'Great Vibes', cursive; 
            color: #666; 
        }
        
        .text-orange { color: #f472b6 !important; }
        .bg-orange { background-color: #f472b6  !important; }
        
        /* Tombol Kotak Sesuai Gambar */
        .btn-orange { 
            background-color: #f472b6; 
            color: white; 
            border-radius: 0; 
            padding: 12px 35px; 
            font-weight: 500; 
            border: none; 
            text-transform: uppercase;
            font-size: 0.9rem;
        }
        .btn-orange:hover { background-color: #ec4899; color: white; }

        /* Styling Navbar */
        .navbar-nav .nav-link {
            font-weight: 400 !important;
            color: #6c757d !important; 
            transition: color 0.2s ease-in-out;
        }
        .navbar-nav .nav-link:hover {
            color: #212529 !important; 
            -webkit-text-stroke: 0.6px #212529; 
        }

        /* --- STYLING KHUSUS HEADER / HERO SECTION --- */
        .hero-section {
            position: relative;
            height: 600px; 
            background-image: url('https://cdn.pixabay.com/photo/2020/06/15/02/09/food-5300043_1280.jpg');
            background-size: cover;
            background-position: right center;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        .hero-text-box {
            background-color: rgba(255, 255, 255, 0.85); 
            backdrop-filter: blur(10px); 
            border-radius: 20px; 
            padding: 30px;
        }

        .divider-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 15px 0;
            color: #ec4899;
        }
        .divider-icon hr {
            width: 50px;
            border-top: 2px solid #ec4899;
            opacity: 1;
            margin: 0 15px;
        }

        /* Kustomisasi Slider */
        .custom-slider-btn {
            width: 45px;
            height: 45px;
            background-color: #f472b6; 
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .custom-slider-btn:hover {
            background-color: #ec4899;
            color: white;
        }
        .slider-prev { left: -15px; } 
        .slider-next { right: -15px; } 

        .carousel-indicators [data-bs-target] {
            width: 10px;
            height: 10px;
            border-radius: 50%; 
            background-color:  #fbcfe8;
            border: none;
            margin: 0 6px;
        }
        .carousel-indicators .active {
            background-color: #f472b6;
            transform: scale(1.2); 
        }
        
        /* Memperbaiki Input Form untuk Login/Register */
        .form-control { border-radius: 0; padding: 10px 15px; }
        .form-control:focus { 
    border-color: #f472b6; 
    box-shadow: 0 0 0 2px rgba(244, 114, 182, 0.2); /* glow soft */ }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- [Kriteria 5: Navbar Terpisah] Komponen Navbar Utama -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-1 sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand text-orange fw-bold fs-2" href="{{ url('/') }}">Snack Zone</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav text-uppercase mx-auto" style="font-size: 0.9rem; letter-spacing: 1px;">
                    <li class="nav-item mx-2"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item mx-2"><a class="nav-link" href="{{ url('/#about') }}">About</a></li>
                    <li class="nav-item mx-2"><a class="nav-link" href="{{ url('/#contact') }}">Contact</a></li>
                    <li class="nav-item mx-2"><a class="nav-link" href="{{ url('/menu') }}">Menu</a></li>
                    <li class="nav-item mx-2"><a class="nav-link" href="{{ url('/riwayat') }}">Pesanan Saya</a></li>
                </ul>

                @php 
                    $cartCount = session('cart') ? count(session('cart')) : 0; 
                @endphp

                <a href="{{ url('/cart') }}" class="position-relative me-3 text-dark text-decoration-none p-1">
                    <i class="bi bi-cart3 fs-5"></i>
                    @if($cartCount > 0)
                        <span class="position-absolute badge rounded-pill bg-orange shadow-sm" style="top: -2px; right: -6px; font-size: 0.6rem; padding: 0.3em 0.5em;">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
                
                <!-- LOGIN / LOGOUT -->
                <div class="d-flex align-items-center mt-3 mt-lg-0">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ url('/admin/dashboard') }}" class="btn btn-primary px-4 py-1 me-2" style="font-size: 0.85rem; border-radius: 0;">
                                <i class="bi bi-speedometer2 me-1"></i> PANEL ADMIN
                            </a>
                        @endif

                        <form action="{{ url('/logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-orange px-4 py-1" style="font-size: 0.85rem;">LOGOUT</button>
                        </form>
                    @else
                        <a href="{{ url('/login') }}" class="btn btn-orange px-4 py-1" style="font-size: 0.85rem;">LOGIN</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-dark text-white py-1 mt-auto">
        <hr class="border-secondary m-0">
        <div class="text-center text-secondary py-3">
            <small>&copy; 2026 Snack Zine. All Rights Reserved.</small>
        </div>
    </footer>

    @if(session('success'))
        <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1100;">
            <div class="toast align-items-center text-white bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>