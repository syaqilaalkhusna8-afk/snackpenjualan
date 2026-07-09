@extends('layouts.admin_layout')

@section('admin_content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-3 mb-4 border-bottom">
        <div>
            <h1 class="h3 fw-bold text-dark mb-0">Pesanan Masuk</h1>
            <p class="text-secondary small mb-0 mt-1">Daftar pesanan terbaru dari pelanggan Street Food.</p>
        </div>
        <button id="btnGenerateLaporan" type="button" class="btn btn-danger mb-3">
            <i class="bi bi-file-earmark-pdf"></i>
            <span id="btnGenerateLaporanText">Generate Laporan</span>
        </button>
    </div>

    <!-- Grafik Penjualan: dirender di browser (Chart.js), lalu di-capture jadi PNG
         dan disimpan ke storage supaya bisa ditempel ke laporan PDF -->
    <div class="row g-3 mb-4">
        <div class="col-lg-7">
            <div class="card shadow-sm rounded-0 border-0 h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-1"><i class="bi bi-bar-chart-fill text-primary me-2"></i>Pendapatan 7 Hari Terakhir</h6>
                    <small class="text-muted">Grafik ini akan disertakan dalam laporan PDF</small>
                </div>
                <div class="card-body">
                    <div style="height:260px;">
                        <canvas id="orderChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card shadow-sm rounded-0 border-0 h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-1"><i class="bi bi-star-fill text-warning me-2"></i>Menu Terlaris</h6>
                    <small class="text-muted">Top 5 menu paling banyak dipesan</small>
                </div>
                <div class="card-body">
                    <div style="height:260px;">
                        <canvas id="bestSellerChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let salesChart, bestSellerChart;

// Ambil data grafik dari server, lalu render dua chart-nya
fetch("{{ url('/admin/orders/chart-data') }}")
    .then(res => res.json())
    .then(data => {
        const labels = data.salesPerDay.map(item => {
            const tanggal = new Date(item.tanggal);
            return tanggal.toLocaleDateString('id-ID', { day: '2-digit', month: 'short' });
        });
        const totals = data.salesPerDay.map(item => item.total);

        salesChart = new Chart(document.getElementById('orderChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan',
                    data: totals,
                    backgroundColor: '#ff8c00',
                    borderRadius: 8,
                    maxBarThickness: 60
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') } }
                }
            }
        });

        bestSellerChart = new Chart(document.getElementById('bestSellerChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: data.bestSeller.map(x => x.items),
                datasets: [{
                    label: 'Terjual',
                    data: data.bestSeller.map(x => x.total),
                    backgroundColor: '#f59e0b',
                    borderRadius: 8,
                    barThickness: 28
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { x: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });
    });

// Tombol "Generate Laporan":
// 1) tunggu chart selesai render -> ubah jadi PNG (toBase64Image)
// 2) kirim PNG ke server buat disimpan di storage (storage link)
// 3) baru redirect ke route export PDF, supaya gambar chart sudah ada saat PDF dibuat
document.getElementById('btnGenerateLaporan').addEventListener('click', async function () {
    const btn = this;
    const btnText = document.getElementById('btnGenerateLaporanText');
    btn.disabled = true;
    btnText.textContent = 'Menyiapkan grafik...';

    try {
        const payload = {
            sales_chart: salesChart ? salesChart.toBase64Image() : null,
            bestseller_chart: bestSellerChart ? bestSellerChart.toBase64Image() : null,
        };

        const res = await fetch("{{ url('/admin/orders/save-chart') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(payload)
        });

        if (!res.ok) throw new Error('Gagal menyimpan grafik');

        btnText.textContent = 'Membuat PDF...';
        window.location.href = "{{ route('orders.pdf') }}";
    } catch (err) {
        alert('Gagal generate laporan: ' + err.message);
    } finally {
        setTimeout(() => {
            btn.disabled = false;
            btnText.textContent = 'Generate Laporan';
        }, 2000);
    }
});
</script>
@endpush
@endsection