@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center py-5" style="min-height: 70vh;">
    
    <div class="card border shadow-none" style="width: 100%; max-width: 500px; border-radius: 10px; border-color: #dee2e6;">
        <div class="card-body p-4 p-md-5">
            
            <div class="text-center mb-4">
                <h2 class="font-cursive fs-1 mb-0 text-orange">Join Us</h2>
                <p class="text-muted">Daftar untuk menikmati layanan kami</p>
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <ul class="mb-0 ps-3 list-unstyled">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
               @endif  
            </div>

            <form action="{{ url('/register') }}" method="POST">
                @csrf 
                
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" placeholder="Masukkan Nama" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan Email" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control border-end-0 password-field" placeholder="Password" required>
                        <button class="btn border border-start-0 bg-white toggle-password" type="button" style="border-radius: 0;">
                            <i class="bi bi-eye-slash text-secondary"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary small">Konfirmasi</label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" class="form-control border-end-0 password-field" placeholder="Ulangi Password" required>
                        <button class="btn border border-start-0 bg-white toggle-password" type="button" style="border-radius: 0;">
                            <i class="bi bi-eye-slash text-secondary"></i>
                        </button>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-orange w-100 py-2 mb-3">DAFTAR SEKARANG</button>
            </form>
            
            <div class="text-center mt-3">
                <p class="text-muted small mb-2">Sudah punya akun? <a href="{{ url('/login') }}" class="text-orange text-decoration-none fw-bold">Login di sini</a></p>
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
                const input = this.previousElementSibling;
                const icon = this.querySelector('i');

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