@extends('layouts.admin_layout')

@section('admin_content')
    <div class="pt-3 pb-2 mb-4 border-bottom">
        <h3 class="fw-bold text-dark">Ringkasan Statistik Sistem</h3>
        <p class="text-secondary small">Pantau jumlah data pengguna, katalog menu, dan aktivitas transaksi Anda hari ini.</p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card border shadow-sm rounded-0 bg-white">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="bg-primary text-white rounded-0 p-3 me-3">
                        <i class="bi bi-people fs-3"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark mb-0">Total Pengguna</div>
                        <div class="fs-4 fw-bold text-dark">{{ $countUser }}</div>
                        <div class="text-muted" style="font-size: 0.75rem;">User yang terdaftar di sistem</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card border shadow-sm rounded-0 bg-white">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="bg-menu text-white rounded-0 p-3 me-3">
                        <i class="bi bi-grid-fill fs-3"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark mb-0">Katalog Menu</div>
                        <div class="fs-4 fw-bold text-dark">{{ $countMenu }}</div>
                        <div class="text-muted" style="font-size: 0.75rem;">Jumlah produk aktif saat ini</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card border shadow-sm rounded-0 bg-white">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="bg-dark text-white rounded-0 p-3 me-3">
                        <i class="bi bi-bag-check fs-3"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark mb-0">Total Pesanan</div>
                        <div class="fs-4 fw-bold text-dark">{{ $countOrder }}</div>
                        <div class="text-muted" style="font-size: 0.75rem;">Semua riwayat transaksi</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-12 col-sm-6">
                <div class="card border shadow-sm rounded-0 bg-white">
                    <div class="card-body d-flex align-items-center p-3">
                <div class="bg-success text-white rounded-0 p-3 me-3">
                <i class="bi bi-cash-stack fs-3"></i>
            </div>

            <div>
               <div class="fw-bold text-dark">Total Pendapatan</div>
                    <h4 class="fw-bold text-success mb-1">
                        Rp {{ number_format($totalPendapatan,0,',','.') }}
                    </h4>
                    <small class="text-muted">
                        Total seluruh transaksi
                    </small>
                </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border shadow-sm rounded-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom-0"> <div>
                <h6 class="m-0 fw-bold text-dark"><i class="bi bi-clock-history me-2 text-orange"></i>Aktivitas Pesanan Terbaru</h6>
                <p class="text-secondary small mb-0">Daftar transaksi terakhir yang masuk ke sistem</p>
            </div>
            <a href="{{ url('/admin/orders') }}" class="btn btn-sm btn-orange rounded-0 px-3 fw-bold">LIHAT DETAIL</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-white text-secondary small text-uppercase border-top-0"> 
                        <tr class="border-bottom">
                            <th class="ps-4 py-3 border-0">ID Pesanan</th>
                            <th class="border-0 text-center">Pelanggan</th> <th class="border-0">Detail Menu</th>
                            <th class="border-0 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesananTerbaru as $order)
                        <tr class="border-bottom">
                            <td class="ps-4 py-3 fw-bold text-dark">#ORD-{{ $order->id }}</td>
                            <td class="fw-bold text-center">{{ $order->nama_pelanggan }}</td>
                            <td class="text-muted small">{{ $order->items }}</td>
                            <td class="text-center">
                                @if($order->status == 'menunggu')
                                    <span class="badge bg-warning text-dark rounded-0 px-3 py-2 fw-bold" style="font-size: 0.7rem; min-width: 90px;">MENUNGGU</span>
                                @else
                                    <span class="badge bg-success rounded-0 px-3 py-2 fw-bold" style="font-size: 0.7rem; min-width: 90px;">SELESAI</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted small border-0">Belum ada aktivitas pesanan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        <!-- Grafik Pendapatan -->
<div class="card shadow rounded-4 border-0 mt-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold mb-1">
            <i class="bi bi-bar-chart-fill text-primary me-2"></i>
            Pendapatan 7 Hari Terakhir
        </h5>

        <small class="text-muted">
            Pendapatan harian berdasarkan transaksi berhasil
        </small>
    </div>

    <div class="card-body">
        <div style="height:300px;">
            <canvas id="orderChart"></canvas>
        </div>
    </div>
</div>

<!-- Grafik Menu Terlaris -->
<div class="card shadow rounded-4 border-0 mt-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="fw-bold mb-1">
            <i class="bi bi-star-fill text-warning me-2"></i>
            5 Menu Terlaris
        </h5>

        <small class="text-muted">
            Menu yang paling banyak dipesan pelanggan
        </small>
    </div>

    <div class="card-body">
        <div style="height:300px;">
            <canvas id="bestSellerChart"></canvas>
        </div>
    </div>
</div>
        
        

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script>
const chartData = @json($salesPerDay);

console.log(chartData);

const labels = chartData.map(item => {
    const tanggal = new Date(item.tanggal);

    return tanggal.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'short'
    });
});
const totals = chartData.map(item => item.total);

const ctx = document.getElementById('orderChart').getContext('2d');
Chart.register(ChartDataLabels);
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Pendapatan',
            data: totals,
            backgroundColor: '#ff8c00',
            borderColor: '#ff8c00',
            borderWidth: 2,
            borderRadius: 12,
            borderSkipped: false,
            maxBarThickness: 90,
            categoryPercentage: 0.5,
            barPercentage: 0.8
            }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,

        animation: {
            duration: 1200
        },

        plugins: {
            legend: {
            display: false
            },

        tooltip: {
            callbacks: {
            label: function(context){
                return 'Pendapatan : Rp ' + context.raw.toLocaleString('id-ID');
                    }      
                }
            },

        datalabels: {
            anchor: 'end',
            align: 'top',
            color: '#333',
            font: {
                weight: 'bold',
                size: 12
                },
            formatter: function(value){
            return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            },
        },

        scales: {
            x: {
                grid: {
                    display: false
                }
            },
            y: {
                beginAtZero: true,

                grace: '20%',   // memberi ruang di atas batang

                ticks: {
                    callback: function(value){
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
            },
                grid: {
                    color: '#eeeeee'
                }
            }
        }
    });
</script>
<script>

const data = @json($bestSeller);
console.log(data);

const ctx2 = document.getElementById("bestSellerChart").getContext("2d");

new Chart(ctx2,{
    type:"bar",
    data:{
        labels:data.map(x=>x.items),
        datasets: [{
            label: "Jumlah Terjual",
            data: data.map(x => x.total),

        backgroundColor: [
            "#f59e0b", // Menu terlaris (peringkat 1)
            "#fbbf24",
            "#fbbf24",
            "#fbbf24",
            "#fbbf24"
        ],

            borderRadius: 10,
            barThickness: 35
        }]
    },
        options:{
            indexAxis:'y',
            responsive:true,
            maintainAspectRatio:false,
        plugins:{
            legend:{
            display:false
            },

        datalabels:{
            display:false
        },

        tooltip:{
            callbacks:{
                label:function(context){
                    return context.raw + " kali dipesan";
                }
            }
        }
    },

        scales:{
        x:{
            beginAtZero:true,
            grace:'10%',

            ticks:{
                stepSize:1
            },

            grid:{
                display: false
            }
        },

        y:{
            grid:{
                display:false
            }
        }
    }
}
});
</script>
@endpush

@endsection