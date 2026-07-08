<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Data Pesanan</title>

    <style>
        body{
            font-family: DejaVu Sans;
            font-size:12px;
            margin:30px;
            color:#333;
        }

        .header{
            text-align:center;
            margin-bottom:20px;
        }

        .header h2{
            margin:0;
            font-size:22px;
        }

        .header p{
            margin:3px 0;
            color:#666;
            font-size:11px;
        }

        hr{
            border:none;
            border-top:2px solid #f59e0b;
            margin:15px 0;
        }

        .info{
            margin-bottom:15px;
        }

        .info table{
            width:100%;
            border-collapse:collapse;
        }

        .info td{
            border:none;
            padding:4px 2px;
            text-align:left;
            vertical-align:top;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th{
            background:#f59e0b;
            color:white;
            padding:10px;
            font-size:12px;
        }   

        td{
            border:1px solid #ddd;
            padding:8px;
            text-align:center;
        }

        tr:nth-child(even){
            background:#f9f9f9;
        }

        .footer{
            margin-top:25px;
            text-align:right;
            font-size:11px;
            color:#666;
        }

    </style>
</head>

<body>

<div class="header">

    <h2>Snack Zone</h2>

    <p>Laporan Data Pesanan</p>

</div>

<hr>

<div class="info">

<table>

<tr>
    <td width="25%"><strong>Tanggal Cetak</strong></td>
    <td width="3%">:</td>
    <td>{{ date('d F Y') }}</td>
</tr>

<tr>
    <td><strong>Jumlah Pesanan</strong></td>
    <td>:</td>
    <td>{{ $orders->count() }}</td>
</tr>

<tr>
    <td><strong>Total Pendapatan</strong></td>
    <td>:</td>
    <td>Rp {{ number_format($orders->sum('total_harga'),0,',','.') }}</td>
</tr>

</table>

</div>

<table>

<thead>

<tr>
    <th width="5%">No</th>
    <th width="15%">Pelanggan</th>
    <th width="40%">Menu</th>
    <th width="15%">Total Harga</th>
    <th width="10%">Status</th>
    <th width="15%">Tanggal</th>
</tr>

</thead>

<tbody>

@foreach($orders as $no => $order)

<tr>

<td>{{ $no+1 }}</td>

<td>{{ $order->nama_pelanggan }}</td>

<td style="text-align:left; line-height:1.5;">
    {!! '• ' . str_replace(', ', '<br>• ', $order->items) !!}
</td>

<td>
Rp {{ number_format($order->total_harga,0,',','.') }}
</td>

<td>
{{ ucfirst($order->status) }}
</td>

<td>
{{ $order->created_at->format('d-m-Y') }}
</td>

</tr>

@endforeach

</tbody>

</table>

<div class="footer">

Dicetak oleh Sistem Snack Zone<br>

{{ date('d F Y H:i') }}

</div>

</body>
</html>