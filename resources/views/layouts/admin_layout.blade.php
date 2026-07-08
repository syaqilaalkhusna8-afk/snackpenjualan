<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Snack Zone</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #f4f7f6; 
        }
        
        .font-cursive { 
            font-family: 'Great Vibes', cursive; 
        }
        
        .text-pink {
    color: #f472b6 !important;
}

.bg-pink {
    background-color: #f472b6 !important;
}
        /* KONSISTENSI WARNA TOMBOL */
       .btn-pink {
    background-color: #ec4899;
    color: white;
    border: none;
    transition: 0.3s;
}
.bg-pink {
    background-color: #ec4899 !important;
}

.text-pink {
    color: #ec4899 !important;
}
.bg-menu {
    background-color: #f59e0b !important;
}

.text-menu {
    color: #f59e0b !important;
}
.btn-pink:hover {
    background-color: #db2777;
}
       .btn-outline-pink {
    color: #ec4899;
    border: 1px solid #ec4899;
    background-color: transparent;
    transition: all 0.3s ease;
}

.btn-outline-pink:hover {
    background-color: #ec4899;
    color: #fff;
}

        /* SIDEBAR STYLING */
        .sidebar {
            min-height: 100vh;
            background-color: #ffffff;
            border-right: 1px solid #dee2e6;
            padding: 0;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
        }
        
        .sidebar .nav-link {
            font-weight: 500;
            color: #6c757d;
            padding: 12px 20px;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover, 
        .sidebar .nav-link.active {
        background-color: #fff1f7; 
        color: #ec4899;
        }
        
        .sidebar .nav-link.active { 
    border-right: 3px solid #ec4899; 
        }
        
        .sidebar-heading {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            color:  #ec4899;
            padding: 1.5rem 1.25rem 0.5rem;
        }

        @media (min-width: 768px) {
            main { margin-left: 25%; }
        }
        @media (min-width: 992px) {
            main { margin-left: 16.666667%; }
        }
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="px-4 py-3 mb-2 text-center">
                        <div class="bg-orange text-white d-inline-flex align-items-center justify-content-center rounded-circle mb-2" style="width: 50px; height: 50px;">
                            <i class="bi bi-person-badge fs-3"></i>
                        </div>
                        <div class="font-cursive text-orange" style="font-size: 2.2rem; line-height: 1;">Snack Zone</div>
                        <div class="text-secondary fw-bold small text-uppercase mt-1" style="letter-spacing: 2px; font-size: 0.65rem;">Admin Panel</div>
                    </div>
                    
                    <hr class="mx-3">

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ url('/admin/dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i> Dashboard
                            </a>
                        </li>
                        <a class="nav-link {{ request()->is('admin/orders') ? 'active' : '' }}" href="{{ url('/admin/orders') }}">
                            <i class="bi bi-bag-check me-2"></i> Pesanan
                        </a>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/menus') ? 'active' : '' }}" href="{{ url('/admin/menus') }}">
                                <i class="bi bi-card-list me-2"></i> Kelola Menu
                            </a>
                        </li>
                    </ul>

                    <div class="sidebar-heading">Akun</div>
                    <ul class="nav flex-column mb-4">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}"><i class="bi bi-house me-2"></i> Lihat Website</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ url('/logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- HALAMAN KONTEN ADMIN -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                @yield('admin_content')
            </main>
        </div>
    </div>

    <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1100; margin-top: 20px;">
        @if(session('success'))
            <div class="toast show align-items-center text-white bg-dark border-0 shadow-lg rounded-0" role="alert" aria-live="assertive" aria-atomic="true" style="border-bottom: 3px solid #f2552c !important; min-width: 300px;">
                <div class="d-flex">
                    <div class="toast-body py-3 fw-medium text-center w-100">
                        <i class="bi bi-check-circle-fill text-orange me-2"></i>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
    
</body>
</html>