<!DOCTYPE html>
<html lang="en">

<head>

</head>

<body>
    <table style="width: 100%; border-collapse: collapse; text-align: center; font-family: arial; font-size: 8pt;">
        <tr>
            <td colspan="3"><b>REKAP TT BUMIL PUSKESMAS GIRI MULYA</b></td>
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
                                <th>Desa</th>
                                <th>Sasaran TT BUMIL</th>
                                <th>TT1</th>
                                <th>%</th>
                                <th>TT2</th>
                                <th>%</th>
                                <th>TT3</th>
                                <th>%</th>
                                <th>TT4</th>
                                <th>%</th>
                                <th>TT5</th>
                                <th>%</th>
                                <th>T2+</th>
                                <th>%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reportTT as $report)
                                <tr>
                                    <td>{{ $report->village_name }}</td>
                                    <td>{{ $report->pregnant }}</td>
                                    <td>{{ $report->t1_pregnant }}</td>
                                    <td>{{ number_format(($report->t1_pregnant / $report->pregnant) * 100, 2) }}</td>
                                    <td>{{ $report->t2_pregnant }}</td>
                                    <td>{{ number_format(($report->t2_pregnant / $report->pregnant) * 100, 2) }}</td>
                                    <td>{{ $report->t3_pregnant }}</td>
                                    <td>{{ number_format(($report->t3_pregnant / $report->pregnant) * 100, 2) }}</td>
                                    <td>{{ $report->t4_pregnant }}</td>
                                    <td>{{ number_format(($report->t4_pregnant / $report->pregnant) * 100, 2) }}</td>
                                    <td>{{ $report->t5_pregnant }}</td>
                                    <td>{{ number_format(($report->t5_pregnant / $report->pregnant) * 100, 2) }}</td>
                                    <td>{{ $report->t2_pregnant + $report->t3_pregnant + $report->t4_pregnant + $report->t5_pregnant }}
                                    </td>
                                    <td>{{ number_format((($report->t2_pregnant + $report->t3_pregnant + $report->t4_pregnant + $report->t5_pregnant) / $report->pregnant) * 100, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Jumlah</td>
                                <td>{{ $reportTT->sum('pregnant') }}</td>
                                <td>{{ $reportTT->sum('t1_pregnant') }}</td>
                                <td>{{ number_format(($reportTT->sum('t1_pregnant') / $reportTT->sum('pregnant')) * 100, 2) }}
                                </td>
                                <td>{{ $reportTT->sum('t2_pregnant') }}</td>
                                <td>{{ number_format(($reportTT->sum('t2_pregnant') / $reportTT->sum('pregnant')) * 100, 2) }}
                                </td>
                                <td>{{ $reportTT->sum('t3_pregnant') }}</td>
                                <td>{{ number_format(($reportTT->sum('t3_pregnant') / $reportTT->sum('pregnant')) * 100, 2) }}
                                </td>
                                <td>{{ $reportTT->sum('t4_pregnant') }}</td>
                                <td>{{ number_format(($reportTT->sum('t4_pregnant') / $reportTT->sum('pregnant')) * 100, 2) }}
                                </td>
                                <td>{{ $reportTT->sum('t5_pregnant') }}</td>
                                <td>{{ number_format(($reportTT->sum('t5_pregnant') / $reportTT->sum('pregnant')) * 100, 2) }}
                                </td>
                                <td>{{ $reportTT->sum('t2_pregnant') + $reportTT->sum('t3_pregnant') + $reportTT->sum('t4_pregnant') + $reportTT->sum('t5_pregnant') }}
                                </td>
                                <td>{{ number_format((($reportTT->sum('t2_pregnant') + $reportTT->sum('t3_pregnant') + $reportTT->sum('t4_pregnant') + $reportTT->sum('t5_pregnant')) / $reportTT->sum('pregnant')) * 100, 2) }}
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
            <td colspan="3"><b>REKAP TT WUS PUSKESMAS GIRI MULYA</b></td>
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
                                <th>Desa</th>
                                <th>Sasaran WUS</th>
                                <th>TT1</th>
                                <th>%</th>
                                <th>TT2</th>
                                <th>%</th>
                                <th>TT3</th>
                                <th>%</th>
                                <th>TT4</th>
                                <th>%</th>
                                <th>TT5</th>
                                <th>%</th>
                                <th>T2+</th>
                                <th>%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reportTT as $report)
                                <tr>
                                    <td>{{ $report->village_name }}</td>
                                    <td>{{ $report->no_pregnant }}</td>
                                    <td>{{ $report->t1_no_pregnant }}</td>
                                    <td>{{ number_format(($report->t1_no_pregnant / $report->no_pregnant) * 100, 2) }}
                                    </td>
                                    <td>{{ $report->t2_no_pregnant }}</td>
                                    <td>{{ number_format(($report->t2_no_pregnant / $report->no_pregnant) * 100, 2) }}
                                    </td>
                                    <td>{{ $report->t3_no_pregnant }}</td>
                                    <td>{{ number_format(($report->t3_no_pregnant / $report->no_pregnant) * 100, 2) }}
                                    </td>
                                    <td>{{ $report->t4_no_pregnant }}</td>
                                    <td>{{ number_format(($report->t4_no_pregnant / $report->no_pregnant) * 100, 2) }}
                                    </td>
                                    <td>{{ $report->t5_no_pregnant }}</td>
                                    <td>{{ number_format(($report->t5_no_pregnant / $report->no_pregnant) * 100, 2) }}
                                    </td>
                                    <td>{{ $report->t2_no_pregnant + $report->t3_no_pregnant + $report->t4_no_pregnant + $report->t5_no_pregnant }}
                                    </td>
                                    <td>{{ number_format((($report->t2_no_pregnant + $report->t3_no_pregnant + $report->t4_no_pregnant + $report->t5_no_pregnant) / $report->no_pregnant) * 100, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Jumlah</td>
                                <td>{{ $reportTT->sum('no_pregnant') }}</td>
                                <td>{{ $reportTT->sum('t1_no_pregnant') }}</td>
                                <td>{{ number_format(($reportTT->sum('t1_no_pregnant') / $reportTT->sum('no_pregnant')) * 100, 2) }}
                                </td>
                                <td>{{ $reportTT->sum('t2_no_pregnant') }}</td>
                                <td>{{ number_format(($reportTT->sum('t2_no_pregnant') / $reportTT->sum('no_pregnant')) * 100, 2) }}
                                </td>
                                <td>{{ $reportTT->sum('t3_no_pregnant') }}</td>
                                <td>{{ number_format(($reportTT->sum('t3_no_pregnant') / $reportTT->sum('no_pregnant')) * 100, 2) }}
                                </td>
                                <td>{{ $reportTT->sum('t4_no_pregnant') }}</td>
                                <td>{{ number_format(($reportTT->sum('t4_no_pregnant') / $reportTT->sum('no_pregnant')) * 100, 2) }}
                                </td>
                                <td>{{ $reportTT->sum('t5_no_pregnant') }}</td>
                                <td>{{ number_format(($reportTT->sum('t5_no_pregnant') / $reportTT->sum('no_pregnant')) * 100, 2) }}
                                </td>
                                <td>{{ $reportTT->sum('t2_no_pregnant') + $reportTT->sum('t3_no_pregnant') + $reportTT->sum('t4_no_pregnant') + $reportTT->sum('t5_no_pregnant') }}
                                </td>
                                <td>{{ number_format((($reportTT->sum('t2_no_pregnant') + $reportTT->sum('t3_no_pregnant') + $reportTT->sum('t4_no_pregnant') + $reportTT->sum('t5_no_pregnant')) / $reportTT->sum('no_pregnant')) * 100, 2) }}
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
