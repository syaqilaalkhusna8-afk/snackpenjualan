<!-- [Kriteria 2: Bisa CRUD] Halaman ini menyediakan antarmuka untuk manajemen Menu -->

@extends('layouts.admin_layout')


@section('admin_content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-3 mb-4 border-bottom">
        <div>
            <h1 class="h3 fw-bold text-dark mb-0">Kelola Menu</h1>
            <p class="text-secondary small mb-0 mt-1">Atur daftar camilan dan minuman Street Food di sini.</p>
        </div>
        <button type="button" class="btn btn-orange px-4 py-2 fw-bold shadow-sm rounded-0" data-bs-toggle="modal" data-bs-target="#tambahMenuModal">
            <i class="bi bi-plus-lg me-2"></i> Tambah Menu
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-0 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light text-secondary text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">
                        <tr>
                            <th class="ps-4 py-3 border-0 fw-semibold">Gambar</th>
                            <th class="border-0 fw-semibold">Nama & Deskripsi</th>
                            <th class="border-0 fw-semibold">Harga</th>
                            <th class="border-0 fw-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($menus as $item)
                        <tr>
                            <td class="ps-4 py-3">
                                <img src="{{ asset('images/' . $item->gambar) }}" onerror="this.src='https://img.magnific.com/premium-photo/chalsundae-sundae-rice-tteokbokki-tteokbokki-cup-rice-clear-fish-cake-spicy-fish-cake-sotteok-sotteok-colpalm-seaweed-roll-fried-yaki-dumpling_873119-8604.jpg?semt=ais_hybrid&w=740&q=80'" alt="Menu" class="rounded-0 object-fit-cover shadow-sm border" style="width: 70px; height: 70px;">
                            </td>
                            <td>
                                <div class="fw-bold text-dark fs-6">{{ $item->nama_menu }}</div>
                                <div class="text-muted small mt-1" style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $item->deskripsi ?? 'Tidak ada deskripsi.' }}
                                </div>
                            </td>
                            <td class="text-orange fw-bold fs-6">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-sm btn-outline-dark rounded-0 px-3 fw-medium" data-bs-toggle="modal" data-bs-target="#editMenuModal{{ $item->id }}">
                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                    </button>
                                    <a href="{{ url('/admin/menus/delete/' . $item->id) }}" class="btn btn-sm btn-outline-danger rounded-0 px-3 fw-medium" onclick="return confirm('Apakah kamu yakin ingin menghapus menu {{ $item->nama_menu }} ini secara permanen?')">
                                        <i class="bi bi-trash3 me-1"></i> Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="editMenuModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg rounded-0">
                                    <div class="modal-header bg-light border-0 py-3">
                                        <h5 class="modal-title fw-bold text-dark">Edit Menu: {{ $item->nama_menu }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ url('/admin/menus/update/' . $item->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold text-secondary small text-uppercase">Nama Menu</label>
                                                <input type="text" name="nama_menu" class="form-control rounded-0 p-2" value="{{ $item->nama_menu }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold text-secondary small text-uppercase">Harga (Rp)</label>
                                                <input type="number" name="harga" class="form-control rounded-0 p-2" value="{{ $item->harga }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold text-secondary small text-uppercase">Deskripsi Singkat</label>
                                                <textarea name="deskripsi" class="form-control rounded-0 p-2" rows="3">{{ $item->deskripsi }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold text-secondary small text-uppercase">Ganti Gambar</label>
                                                <input type="file" name="gambar" class="form-control rounded-0" accept="image/*">
                                                <div class="form-text small mt-1">*Biarkan kosong jika tidak ingin mengubah gambar saat ini.</div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light border-0 p-3">
                                            <button type="button" class="btn btn-outline-secondary rounded-0 px-4" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-orange rounded-0 px-4">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
                
                @if($menus->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-2">Belum ada menu yang ditambahkan.</p>
                </div>
                @endif
                
            </div>
        </div>
    </div>

    <div class="modal fade" id="tambahMenuModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-0">
                <div class="modal-header bg-light border-0 py-3">
                    <h5 class="modal-title fw-bold text-dark">Tambah Menu Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('/admin/menus') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Nama Menu</label>
                            <input type="text" name="nama_menu" class="form-control rounded-0 p-2" placeholder="Contoh: Spicy Takoyaki" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Harga (Rp)</label>
                            <input type="number" name="harga" class="form-control rounded-0 p-2" placeholder="Contoh: 15000" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Deskripsi Singkat</label>
                            <textarea name="deskripsi" class="form-control rounded-0 p-2" rows="3" placeholder="Jelaskan rasa atau bahan utama camilan ini..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Upload Gambar</label>
                            <input type="file" name="gambar" class="form-control rounded-0" accept="image/*">
                            <div class="form-text small mt-1">*Boleh dikosongkan. Sistem akan memakai gambar cadangan otomatis.</div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0 p-3">
                        <button type="button" class="btn btn-outline-secondary rounded-0 px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-orange rounded-0 px-4">Tambah Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection