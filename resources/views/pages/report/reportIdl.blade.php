<!DOCTYPE html>
<html lang="en">

<head>

</head>

<body>
    <table style="width: 100%; border-collapse: collapse; text-align: center; font-family: arial; font-size: 8pt;">
        <tr>
            <td colspan="3"><b>REKAP MR DAN IDL PUSKESMAS GIRI MULYA</b></td>
        </tr>
        <tr>
            <td colspan="3"><b>PERIODE <?= date('j F Y', strtotime($startDate)) ?> s.d
                    <?= date('j F Y', strtotime($endDate)) ?></b></td>
        </tr>
        <tr>
            <td colspan="3">
                <br>
                <center>
                    <table border="1" cellpadding="5"
                        style="border-collapse: collapse; border: 1px solid #000; text-align: center; width: 80%">
                        <thead>
                            <tr>
                                <th rowspan="2">Desa</th>
                                <th colspan="3">Bayi Baru Lahir</th>
                                <th colspan="4">Imunisasi Lengkap</th>
                            </tr>
                            <tr>
                                <th>L</th>
                                <th>P</th>
                                <th>JLH</th>
                                <th>L</th>
                                <th>P</th>
                                <th>JLH</th>
                                <th>%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reportIdl as $report)
                                <tr>
                                    <td>{{ $report->village_name }}</td>
                                    <td>{{ $report->sum_boys }}</td>
                                    <td>{{ $report->sum_girls }}</td>
                                    <td>{{ $report->sum_boys + $report->sum_girls }}</td>
                                    <td>{{ $report->boys_complete }}</td>
                                    <td>{{ $report->girls_complete }}</td>
                                    <td>{{ $report->complete }}</td>
                                    <td>{{ number_format(($report->complete / ($report->sum_girls + $report->sum_girls)) * 100, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Jumlah</td>
                                <td>{{ $reportIdl->sum('sum_boys') }}</td>
                                <td>{{ $reportIdl->sum('sum_girls') }}</td>
                                <td>{{ $reportIdl->sum('sum_girls') + $reportIdl->sum('sum_boys') }}</td>
                                <td>{{ $reportIdl->sum('boys_complete') }}</td>
                                <td>{{ $reportIdl->sum('girls_complete') }}</td>
                                <td>{{ $reportIdl->sum('complete') }}</td>
                                <td>{{ number_format(($reportIdl->sum('complete') / ($reportIdl->sum('sum_girls') + $reportIdl->sum('sum_boys'))) * 100, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </center>
            </td>
        <tr>
    </table>
    <br>
    <table style="width: 100%; border-collapse: collapse; text-align: center; font-family: arial; font-size: 8pt;">
        <tr>
            <td colspan="3"><b>REKAP HB0 PUSKESMAS GIRI MULYA</b></td>
        </tr>
        <tr>
            <td colspan="3"><b>PERIODE <?= date('j F Y', strtotime($startDate)) ?> s.d
                    <?= date('j F Y', strtotime($endDate)) ?></b></td>
        </tr>
        <tr>
            <td colspan="3">
                <br>
                <center>
                    <table border="1" cellpadding="5"
                        style="border-collapse: collapse; border: 1px solid #000; text-align: center; width: 80%">
                        <thead>
                            <tr>
                                <th rowspan="2">Desa</th>
                                <th colspan="3">Bayi Baru Lahir</th>
                                <th colspan="4">Imunisasi Lengkap</th>
                            </tr>
                            <tr>
                                <th>L</th>
                                <th>P</th>
                                <th>JLH</th>
                                <th>L</th>
                                <th>P</th>
                                <th>JLH</th>
                                <th>%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reportIdl as $report)
                                <tr>
                                    <td>{{ $report->village_name }}</td>
                                    <td>{{ $report->sum_boys }}</td>
                                    <td>{{ $report->sum_girls }}</td>
                                    <td>{{ $report->sum_boys + $report->sum_girls }}</td>
                                    <td>{{ $report->boys_hb0 }}</td>
                                    <td>{{ $report->girls_hb0 }}</td>
                                    <td>{{ $report->total_hb0 }}</td>
                                    <td>{{ number_format(($report->total_hb0 / ($report->sum_girls + $report->sum_girls)) * 100, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Jumlah</td>
                                <td>{{ $reportIdl->sum('sum_boys') }}</td>
                                <td>{{ $reportIdl->sum('sum_girls') }}</td>
                                <td>{{ $reportIdl->sum('sum_girls') + $reportIdl->sum('sum_boys') }}</td>
                                <td>{{ $reportIdl->sum('boys_hb0') }}</td>
                                <td>{{ $reportIdl->sum('girls_hb0') }}</td>
                                <td>{{ $reportIdl->sum('total_hb0') }}</td>
                                <td>{{ number_format(($reportIdl->sum('total_hb0') / ($reportIdl->sum('sum_girls') + $reportIdl->sum('sum_boys'))) * 100, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </center>
            </td>
        <tr>
    </table>
</body>

</html>
