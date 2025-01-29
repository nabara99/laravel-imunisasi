<!DOCTYPE html>
<html lang="en">

<head>

</head>

<body>
    <table style="width: 100%; border-collapse: collapse; text-align: center; font-family: arial; font-size: 8pt;">
        <tr>
            <td colspan="3"><b>REKAP PVC 3 PUSKESMAS GIRI MULYA</b></td>
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
                                <th colspan="4">PCV 3</th>
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
                            @foreach ($reportIbl as $report)
                                <tr>
                                    <td>{{ $report->village_name }}</td>
                                    <td>{{ $report->sum_boys }}</td>
                                    <td>{{ $report->sum_girls }}</td>
                                    <td>{{ $report->sum_boys + $report->sum_girls }}</td>
                                    <td>{{ $report->boys_pcv3 }}</td>
                                    <td>{{ $report->girls_pcv3 }}</td>
                                    <td>{{ $report->total_pcv3 }}</td>
                                    <td>{{ number_format(($report->total_pcv3 / ($report->sum_girls + $report->sum_girls)) * 100, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Jumlah</td>
                                <td>{{ $reportIbl->sum('sum_boys') }}</td>
                                <td>{{ $reportIbl->sum('sum_girls') }}</td>
                                <td>{{ $reportIbl->sum('sum_girls') + $reportIbl->sum('sum_boys') }}</td>
                                <td>{{ $reportIbl->sum('boys_pcv3') }}</td>
                                <td>{{ $reportIbl->sum('girls_pcv3') }}</td>
                                <td>{{ $reportIbl->sum('total_pcv3') }}</td>
                                <td>{{ number_format(($reportIbl->sum('total_pcv3') / ($reportIbl->sum('sum_girls') + $reportIbl->sum('sum_boys'))) * 100, 2) }}
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
            <td colspan="3"><b>REKAP DPT-HB-HIB 4 PUSKESMAS GIRI MULYA</b></td>
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
                                <th colspan="4">DPT-HB-HIB 4</th>
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
                            @foreach ($reportIbl as $report)
                                <tr>
                                    <td>{{ $report->village_name }}</td>
                                    <td>{{ $report->sum_boys }}</td>
                                    <td>{{ $report->sum_girls }}</td>
                                    <td>{{ $report->sum_boys + $report->sum_girls }}</td>
                                    <td>{{ $report->boys_penta4 }}</td>
                                    <td>{{ $report->girls_penta4 }}</td>
                                    <td>{{ $report->total_penta4 }}</td>
                                    <td>{{ number_format(($report->total_penta4 / ($report->sum_girls + $report->sum_girls)) * 100, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Jumlah</td>
                                <td>{{ $reportIbl->sum('sum_boys') }}</td>
                                <td>{{ $reportIbl->sum('sum_girls') }}</td>
                                <td>{{ $reportIbl->sum('sum_girls') + $reportIbl->sum('sum_boys') }}</td>
                                <td>{{ $reportIbl->sum('boys_penta4') }}</td>
                                <td>{{ $reportIbl->sum('girls_penta4') }}</td>
                                <td>{{ $reportIbl->sum('total_penta4') }}</td>
                                <td>{{ number_format(($reportIbl->sum('total_penta4') / ($reportIbl->sum('sum_girls') + $reportIbl->sum('sum_boys'))) * 100, 2) }}
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
            <td colspan="3"><b>REKAP MR 2 PUSKESMAS GIRI MULYA</b></td>
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
                                <th colspan="4">MR 2</th>
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
                            @foreach ($reportIbl as $report)
                                <tr>
                                    <td>{{ $report->village_name }}</td>
                                    <td>{{ $report->sum_boys }}</td>
                                    <td>{{ $report->sum_girls }}</td>
                                    <td>{{ $report->sum_boys + $report->sum_girls }}</td>
                                    <td>{{ $report->boys_mr2 }}</td>
                                    <td>{{ $report->girls_mr2 }}</td>
                                    <td>{{ $report->total_mr2 }}</td>
                                    <td>{{ number_format(($report->total_mr2 / ($report->sum_girls + $report->sum_girls)) * 100, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Jumlah</td>
                                <td>{{ $reportIbl->sum('sum_boys') }}</td>
                                <td>{{ $reportIbl->sum('sum_girls') }}</td>
                                <td>{{ $reportIbl->sum('sum_girls') + $reportIbl->sum('sum_boys') }}</td>
                                <td>{{ $reportIbl->sum('boys_mr2') }}</td>
                                <td>{{ $reportIbl->sum('girls_mr2') }}</td>
                                <td>{{ $reportIbl->sum('total_mr2') }}</td>
                                <td>{{ number_format(($reportIbl->sum('total_mr2') / ($reportIbl->sum('sum_girls') + $reportIbl->sum('sum_boys'))) * 100, 2) }}
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
