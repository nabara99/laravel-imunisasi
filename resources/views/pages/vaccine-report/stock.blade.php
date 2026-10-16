<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan Stok Vaksin</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-family: arial;
            font-size: 10pt;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th,
        td {
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .summary {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>LAPORAN STOK VAKSIN</h2>
        <h3>PUSKESMAS GIRI MULYA</h3>
        <p>PERIODE {{ date('j F Y', strtotime($startDate)) }} s.d {{ date('j F Y', strtotime($endDate)) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="2" style="width: 3%">No.</th>
                <th rowspan="2">Nama Vaksin</th>
                <th rowspan="2">Kategori</th>
                <th rowspan="2">Batch</th>
                <th rowspan="2">VVM</th>
                <th rowspan="2">Expired</th>
                <th rowspan="2">Harga (Rp)</th>
                <th rowspan="2">Stok Awal</th>
                <th colspan="2">Periode</th>
                <th rowspan="2">Stok Saat Ini</th>
                <th rowspan="2">Status</th>
            </tr>
            <tr>
                <th>Masuk</th>
                <th>Keluar</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalStockValue = 0;
            @endphp
            @foreach ($vaccines as $index => $vaccine)
                @php
                    $stockValue = $vaccine->stock * $vaccine->price;
                    $totalStockValue += $stockValue;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="text-align: left">{{ $vaccine->vaccine_name }}</td>
                    <td>{{ $vaccine->category->name ?? '-' }}</td>
                    <td>{{ $vaccine->batch_number }}</td>
                    <td>{{ $vaccine->vvm ?? '-' }}</td>
                    <td>{{ $vaccine->expired_date->format('d/m/Y') }}</td>
                    <td style="text-align: right">{{ number_format($vaccine->price) }}</td>
                    <td>{{ number_format($vaccine->opening_stock) }}</td>
                    <td>{{ number_format($vaccine->total_in) }}</td>
                    <td>{{ number_format($vaccine->total_out) }}</td>
                    <td>{{ number_format($vaccine->current_stock) }}</td>
                    <td>{{ $vaccine->stock_status }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="font-weight: bold; background-color: #f0f0f0">
                <td colspan="7">TOTAL</td>
                <td>{{ number_format($vaccines->sum('opening_stock')) }}</td>
                <td>{{ number_format($vaccines->sum('total_in')) }}</td>
                <td>{{ number_format($vaccines->sum('total_out')) }}</td>
                <td>{{ number_format($vaccines->sum('current_stock')) }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <div class="summary">
        <p>Total Jenis Vaksin: {{ $vaccines->count() }} jenis</p>
        <p>Total Stok: {{ number_format($vaccines->sum('current_stock')) }} unit</p>
        <p>Total Nilai Stok: Rp {{ number_format($totalStockValue) }}</p>
        <p>Stok Awal: {{ number_format($vaccines->sum('opening_stock')) }} unit</p>
        <p>Periode Transaksi Masuk: {{ number_format($vaccines->sum('total_in')) }} unit</p>
        <p>Periode Transaksi Keluar: {{ number_format($vaccines->sum('total_out')) }} unit</p>
    </div>
    <p>Stok awal adalah seluruh penerimaan dikurangi pengeluaran sebelum tanggal awal periode.
        Stok saat ini = stok awal + masuk periode − keluar periode, dihitung sampai tanggal akhir periode.
        Penerimaan berulang dengan nama, kategori, batch, kedaluwarsa, dan harga yang sama digabung agar tidak dihitung ganda.</p>
</body>

</html>
