<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan - Snack Zone</title>

    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 11px;
            color: #333;
            margin: 25px 30px;
        }

        /* ===== HEADER ===== */
        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 6px; }
        .header-table td { border: none; vertical-align: middle; padding: 0; }
        .brand-name { font-size: 22px; font-weight: bold; color: #f59e0b; margin: 0; }
        .brand-tagline { font-size: 10px; color: #888; margin: 2px 0 0; }
        .report-title { text-align: right; font-size: 15px; font-weight: bold; color: #333; }
        .report-date { text-align: right; font-size: 10px; color: #888; }

        hr.divider { border: none; border-top: 2px solid #f59e0b; margin: 10px 0 16px; }

        /* ===== SUMMARY CARDS ===== */
        .summary-table { width: 100%; border-collapse: separate; border-spacing: 6px 0; margin-bottom: 18px; }
        .summary-cell {
            width: 33.33%;
            background: #fff8ec;
            border: 1px solid #f3d9a4;
            padding: 10px 12px;
            text-align: left;
        }
        .summary-label { font-size: 9px; text-transform: uppercase; letter-spacing: 0.5px; color: #a06c1f; margin: 0 0 4px; }
        .summary-value { font-size: 15px; font-weight: bold; color: #333; margin: 0; }

        /* ===== SECTION TITLE ===== */
        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #333;
            margin: 4px 0 8px;
            padding-bottom: 4px;
            border-bottom: 1px solid #eee;
        }

        /* ===== CHARTS ===== */
        .chart-table { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
        .chart-table td { border: 1px solid #eee; padding: 8px; text-align: center; vertical-align: top; }
        .chart-table img { max-width: 100%; max-height: 190px; }
        .chart-caption { font-size: 9px; color: #888; margin-top: 4px; }

        /* ===== ORDER TABLE ===== */
        table.data { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        table.data th {
            background: #f59e0b;
            color: #fff;
            padding: 8px 6px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        table.data td { border: 1px solid #eee; padding: 7px 6px; font-size: 10px; vertical-align: top; }
        table.data tr:nth-child(even) td { background: #fbfbfb; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 2px;
            font-size: 9px;
            font-weight: bold;
            color: #fff;
        }
        .badge-selesai { background: #16a34a; }
        .badge-menunggu { background: #d97706; }

        /* ===== FOOTER ===== */
        .footer-table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        .footer-table td { border: none; font-size: 10px; vertical-align: top; }
        .signature-box { text-align: center; padding-top: 45px; }
        .signature-line { border-top: 1px solid #333; width: 160px; margin: 0 auto; padding-top: 3px; }
        .print-meta { color: #999; font-size: 9px; text-align: right; margin-top: 4px; }
    </style>
</head>
<body>

    <!-- HEADER -->
    <table class="header-table">
        <tr>
            <td style="width:60%;">
                <p class="brand-name">Snack Zone</p>
                <p class="brand-tagline">Street Food &amp; Snack Management System</p>
            </td>
            <td style="width:40%;">
                <div class="report-title">LAPORAN PENJUALAN</div>
                <div class="report-date">Periode s/d {{ now()->translatedFormat('d F Y') }}</div>
            </td>
        </tr>
    </table>
    <hr class="divider">

    <!-- SUMMARY -->
    <table class="summary-table">
        <tr>
            <td class="summary-cell">
                <p class="summary-label">Jumlah Pesanan</p>
                <p class="summary-value">{{ $totalPesanan }}</p>
            </td>
            <td class="summary-cell">
                <p class="summary-label">Total Pendapatan</p>
                <p class="summary-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
            </td>
            <td class="summary-cell">
                <p class="summary-label">Tanggal Cetak</p>
                <p class="summary-value" style="font-size:12px;">{{ now()->translatedFormat('d F Y, H:i') }}</p>
            </td>
        </tr>
    </table>

    <!-- CHARTS -->
    @if($salesChartPath || $bestsellerChartPath)
    <div class="section-title">Grafik Penjualan</div>
    <table class="chart-table">
        <tr>
            @if($salesChartPath)
            <td style="width: {{ $bestsellerChartPath ? '58%' : '100%' }};">
                <img src="{{ $salesChartPath }}">
                <p class="chart-caption">Pendapatan 7 Hari Terakhir</p>
            </td>
            @endif
            @if($bestsellerChartPath)
            <td style="width: {{ $salesChartPath ? '42%' : '100%' }};">
                <img src="{{ $bestsellerChartPath }}">
                <p class="chart-caption">Menu Terlaris</p>
            </td>
            @endif
        </tr>
    </table>
    @endif

    <!-- DETAIL TABLE -->
    <div class="section-title">Detail Pesanan</div>
    <table class="data">
        <thead>
            <tr>
                <th style="width:6%;">No</th>
                <th style="width:16%;">Pelanggan</th>
                <th style="width:34%;">Detail Menu</th>
                <th style="width:16%;" class="text-right">Total Bayar</th>
                <th style="width:12%;" class="text-center">Status</th>
                <th style="width:16%;" class="text-center">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $no => $order)
            <tr>
                <td class="text-center">{{ $no + 1 }}</td>
                <td>{{ $order->nama_pelanggan }}</td>
                <td>
                    @if($order->details->isNotEmpty())
                        @foreach($order->details as $d)
                            &bull; {{ $d->qty }}x {{ $d->menu->nama_menu ?? 'Menu Dihapus' }}<br>
                        @endforeach
                    @else
                        &bull; {{ str_replace(', ', '<br>&bull; ', $order->items) }}
                    @endif
                </td>
                <td class="text-right">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                <td class="text-center">
                    @if($order->status == 'selesai')
                        <span class="badge badge-selesai">SELESAI</span>
                    @else
                        <span class="badge badge-menunggu">MENUNGGU</span>
                    @endif
                </td>
                <td class="text-center">{{ $order->created_at->format('d-m-Y H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada data pesanan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- FOOTER / SIGNATURE -->
    <table class="footer-table">
        <tr>
            <td style="width:60%;"></td>
            <td style="width:40%;" class="signature-box">
                Madiun, {{ now()->translatedFormat('d F Y') }}<br>
                Mengetahui,
                <div class="signature-line">Admin Snack Zone</div>
            </td>
        </tr>
    </table>
    <p class="print-meta">Dicetak otomatis oleh Sistem Snack Zone &mdash; {{ now()->format('d/m/Y H:i') }}</p>

</body>
</html>
