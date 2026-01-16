<!DOCTYPE html>
<html lang="en">

<head>
    <style>
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
        <h2>LAPORAN PENGELUARAN VAKSIN</h2>
        <h3>PUSKESMAS GIRI MULYA</h3>
        <p>PERIODE {{ date('j F Y', strtotime($startDate)) }} s.d {{ date('j F Y', strtotime($endDate)) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="2" style="width: 3%">No.</th>
                <th rowspan="2">Tanggal</th>
                <th rowspan="2">Nama Vaksin</th>
                <th rowspan="2">Kategori</th>
                <th rowspan="2">Batch</th>
                <th colspan="2">Pengeluaran</th>
                <th rowspan="2">Keterangan</th>
            </tr>
            <tr>
                <th>Jumlah</th>
                <th>Nilai (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vaccineOuts as $index => $vaccineOut)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $vaccineOut->date_out->format('d/m/Y') }}</td>
                    <td style="text-align: left">{{ $vaccineOut->vaccine->vaccine_name }}</td>
                    <td>{{ $vaccineOut->vaccine->category->name }}</td>
                    <td>{{ $vaccineOut->vaccine->batch_number }}</td>
                    <td>{{ number_format($vaccineOut->quantity) }}</td>
                    <td style="text-align: right">{{ number_format($vaccineOut->quantity * $vaccineOut->vaccine->price) }}
                    </td>
                    <td style="text-align: left">{{ $vaccineOut->notes ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="font-weight: bold; background-color: #f0f0f0">
                <td colspan="5">TOTAL</td>
                <td>{{ number_format($summary['total_quantity']) }}</td>
                <td style="text-align: right">{{ number_format($summary['total_value']) }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <div class="summary">
        <p>Total Transaksi: {{ $summary['total_transactions'] }} transaksi</p>
        <p>Total Jumlah: {{ number_format($summary['total_quantity']) }} unit</p>
        <p>Total Nilai: Rp {{ number_format($summary['total_value']) }}</p>
    </div>
</body>

</html>
