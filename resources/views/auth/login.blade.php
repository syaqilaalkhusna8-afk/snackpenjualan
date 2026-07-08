@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center py-5" style="min-height: 70vh;">
    
    <div class="card border shadow-none" style="width: 100%; max-width: 450px; border-radius: 10px; border-color: #dee2e6;">
        <div class="card-body p-4 p-md-5">
            
            <div class="text-center mb-4">
                <h2 class="font-cursive fs-1 mb-0 text-orange">Welcome Back</h2>
                <p class="text-muted">Login untuk melanjutkan pesananmu</p>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>

            <form action="{{ url('/login') }}" method="POST" autocomplete="off">
                @csrf 
                
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary small">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control border-end-0 password-field" placeholder="Masukkan password" required>
                        <button class="btn border border-start-0 bg-white toggle-password" type="button" style="border-radius: 0;">
                            <i class="bi bi-eye-slash text-secondary"></i>
                        </button>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-orange w-100 py-2 mb-3">LOGIN</button>
            </form>
            
            <div class="text-center mt-4">
                <p class="text-muted small mb-2">Belum punya akun? <a href="{{ url('/register') }}" class="text-orange text-decoration-none fw-bold">Daftar Sekarang</a></p>
                <a href="{{ url('/') }}" class="text-secondary text-decoration-none small"><i class="bi bi-arrow-left"></i> Kembali ke Beranda</a>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggleButtons = document.querySelectorAll('.toggle-password');

        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Mencari input password yang tepat berada di sebelah tombol
                const input = this.previousElementSibling;
                const icon = this.querySelector('i');

                // Jika tipenya password, ubah ke text (lihatkan), dan sebaliknya
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye');
                    icon.classList.remove('text-orange');
                    icon.classList.add('bi-eye-slash');
                }
            });
        });
    });
</script>
@endsection