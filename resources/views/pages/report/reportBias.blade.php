<!DOCTYPE html>
<html lang="en">

<head>

</head>

<body>
    <table style="width: 100%; border-collapse: collapse; text-align: center; font-family: arial; font-size: 8pt;">
        <tr>
            <td colspan="3"><b>REKAP DT BIAS PUSKESMAS GIRI MULYA</b></td>
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
                                <th rowspan="2">Sekolah</th>
                                <th rowspan="2">Kelas</th>
                                <th colspan="3">Sasaran Siswa</th>
                                <th colspan="4">DT</th>
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
                            @foreach ($reportBias as $report)
                                <tr>
                                    <td>{{ $report->school_name }}</td>
                                    <td>{{ $report->classroom }}</td>
                                    <td>{{ $report->sum_boys }}</td>
                                    <td>{{ $report->sum_girls }}</td>
                                    <td>{{ $report->sum_boys + $report->sum_girls }}</td>
                                    <td>{{ $report->boys_dt }}</td>
                                    <td>{{ $report->girls_dt }}</td>
                                    <td>{{ $report->total_dt }}</td>
                                    <td>{{ $report->sum_boys + $report->sum_girls > 0 ? number_format(($report->total_dt / ($report->sum_boys + $report->sum_girls)) * 100, 2) : 0 }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">Jumlah</td>
                                <td>{{ $reportBias->sum('sum_boys') }}</td>
                                <td>{{ $reportBias->sum('sum_girls') }}</td>
                                <td>{{ $reportBias->sum('sum_boys') + $reportBias->sum('sum_girls') }}</td>
                                <td>{{ $reportBias->sum('boys_dt') }}</td>
                                <td>{{ $reportBias->sum('girls_dt') }}</td>
                                <td>{{ $reportBias->sum('total_dt') }}</td>
                                <td>{{ $reportBias->sum('sum_boys') + $reportBias->sum('sum_girls') > 0 ? number_format(($reportBias->sum('total_dt') / ($reportBias->sum('sum_boys') + $reportBias->sum('sum_girls'))) * 100, 2) : 0 }}
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
            <td colspan="3"><b>REKAP MR BIAS PUSKESMAS GIRI MULYA</b></td>
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
                                <th rowspan="2">Sekolah</th>
                                <th rowspan="2">Kelas</th>
                                <th colspan="3">Sasaran Siswa</th>
                                <th colspan="4">MR</th>
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
                            @foreach ($reportBias as $report)
                                <tr>
                                    <td>{{ $report->school_name }}</td>
                                    <td>{{ $report->classroom }}</td>
                                    <td>{{ $report->sum_boys }}</td>
                                    <td>{{ $report->sum_girls }}</td>
                                    <td>{{ $report->sum_boys + $report->sum_girls }}</td>
                                    <td>{{ $report->boys_mr }}</td>
                                    <td>{{ $report->girls_mr }}</td>
                                    <td>{{ $report->total_mr }}</td>
                                    <td>{{ $report->sum_boys + $report->sum_girls > 0 ? number_format(($report->total_mr / ($report->sum_boys + $report->sum_girls)) * 100, 2) : 0 }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">Jumlah</td>
                                <td>{{ $reportBias->sum('sum_boys') }}</td>
                                <td>{{ $reportBias->sum('sum_girls') }}</td>
                                <td>{{ $reportBias->sum('sum_boys') + $reportBias->sum('sum_girls') }}</td>
                                <td>{{ $reportBias->sum('boys_mr') }}</td>
                                <td>{{ $reportBias->sum('girls_mr') }}</td>
                                <td>{{ $reportBias->sum('total_mr') }}</td>
                                <td>{{ $reportBias->sum('sum_boys') + $reportBias->sum('sum_girls') > 0 ? number_format(($reportBias->sum('total_mr') / ($reportBias->sum('sum_boys') + $reportBias->sum('sum_girls'))) * 100, 2) : 0 }}
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
            <td colspan="3"><b>REKAP TD BIAS PUSKESMAS GIRI MULYA</b></td>
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
                                <th rowspan="2">Sekolah</th>
                                <th rowspan="2">Kelas</th>
                                <th colspan="3">Sasaran Siswa</th>
                                <th colspan="4">TD1</th>
                                <th colspan="4">TD2 PA</th>
                                <th colspan="4">TD2 PI</th>
                            </tr>
                            <tr>
                                <th>L</th>
                                <th>P</th>
                                <th>JLH</th>
                                <th>L</th>
                                <th>P</th>
                                <th>JLH</th>
                                <th>%</th>
                                <th>L</th>
                                <th>P</th>
                                <th>JLH</th>
                                <th>%</th>
                                <th>L</th>
                                <th>P</th>
                                <th>JLH</th>
                                <th>%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reportBias as $report)
                                <tr>
                                    <td>{{ $report->school_name }}</td>
                                    <td>{{ $report->classroom }}</td>
                                    <td>{{ $report->sum_boys }}</td>
                                    <td>{{ $report->sum_girls }}</td>
                                    <td>{{ $report->sum_boys + $report->sum_girls }}</td>
                                    <td>{{ $report->boys_td1 }}</td>
                                    <td>{{ $report->girls_td1 }}</td>
                                    <td>{{ $report->total_td1 }}</td>
                                    <td>{{ $report->sum_boys + $report->sum_girls > 0 ? number_format(($report->total_td1 / ($report->sum_boys + $report->sum_girls)) * 100, 2) : 0 }}
                                    </td>
                                    <td>{{ $report->boys_td2pa }}</td>
                                    <td>{{ $report->girls_td2pa }}</td>
                                    <td>{{ $report->total_td2pa }}</td>
                                    <td>{{ $report->sum_boys + $report->sum_girls > 0 ? number_format(($report->total_td2pa / ($report->sum_boys + $report->sum_girls)) * 100, 2) : 0 }}
                                    </td>
                                    <td>{{ $report->boys_td2pi }}</td>
                                    <td>{{ $report->girls_td2pi }}</td>
                                    <td>{{ $report->total_td2pi }}</td>
                                    <td>{{ $report->sum_boys + $report->sum_girls > 0 ? number_format(($report->total_td2pi / ($report->sum_boys + $report->sum_girls)) * 100, 2) : 0 }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">Jumlah</td>
                                <td>{{ $reportBias->sum('sum_boys') }}</td>
                                <td>{{ $reportBias->sum('sum_girls') }}</td>
                                <td>{{ $reportBias->sum('sum_boys') + $reportBias->sum('sum_girls') }}</td>
                                <td>{{ $reportBias->sum('boys_td1') }}</td>
                                <td>{{ $reportBias->sum('girls_td1') }}</td>
                                <td>{{ $reportBias->sum('total_td1') }}</td>
                                <td>{{ $reportBias->sum('sum_boys') + $reportBias->sum('sum_girls') > 0 ? number_format(($reportBias->sum('total_td1') / ($reportBias->sum('sum_boys') + $reportBias->sum('sum_girls'))) * 100, 2) : 0 }}
                                </td>
                                <td>{{ $reportBias->sum('boys_td2pa') }}</td>
                                <td>{{ $reportBias->sum('girls_td2pa') }}</td>
                                <td>{{ $reportBias->sum('total_td2pa') }}</td>
                                <td>{{ $reportBias->sum('sum_boys') + $reportBias->sum('sum_girls') > 0 ? number_format(($reportBias->sum('total_td2pa') / ($reportBias->sum('sum_boys') + $reportBias->sum('sum_girls'))) * 100, 2) : 0 }}
                                </td>
                                <td>{{ $reportBias->sum('boys_td2pi') }}</td>
                                <td>{{ $reportBias->sum('girls_td2pi') }}</td>
                                <td>{{ $reportBias->sum('total_td2pi') }}</td>
                                <td>{{ $reportBias->sum('sum_boys') + $reportBias->sum('sum_girls') > 0 ? number_format(($reportBias->sum('total_td2pi') / ($reportBias->sum('sum_boys') + $reportBias->sum('sum_girls'))) * 100, 2) : 0 }}
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
            <td colspan="3"><b>REKAP HPV BIAS PUSKESMAS GIRI MULYA</b></td>
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
                                <th rowspan="2">Sekolah</th>
                                <th rowspan="2">Kelas</th>
                                <th colspan="2">Sasaran Siswa Perempuan</th>
                                <th colspan="2">HPV 1</th>
                                <th colspan="2">HPV 2</th>
                            </tr>
                            <tr>
                                <th>P</th>
                                <th>JLH</th>
                                <th>JLH</th>
                                <th>%</th>
                                <th>JLH</th>
                                <th>%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reportBias as $report)
                                <tr>
                                    <td>{{ $report->school_name }}</td>
                                    <td>{{ $report->classroom }}</td>
                                    <td>{{ $report->sum_girls }}</td>
                                    <td>{{ $report->sum_girls }}</td>
                                    <td>{{ $report->girls_hpv1 }}</td>
                                    <td>{{ $report->sum_girls > 0 ? number_format(($report->girls_hpv1 / $report->sum_girls) * 100, 2) : 0 }}
                                    </td>
                                    <td>{{ $report->girls_hpv2 }}</td>
                                    <td>{{ $report->sum_girls > 0 ? number_format(($report->girls_hpv2 / $report->sum_girls) * 100, 2) : 0 }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">Jumlah</td>
                                <td>{{ $reportBias->sum('sum_girls') }}</td>
                                <td>{{ $reportBias->sum('sum_girls') }}</td>
                                <td>{{ $reportBias->sum('girls_hpv1') }}</td>
                                <td>{{ $reportBias->sum('sum_girls') > 0 ? number_format(($reportBias->sum('girls_hpv1') / $reportBias->sum('sum_girls')) * 100, 2) : 0 }}
                                </td>
                                <td>{{ $reportBias->sum('girls_hpv2') }}</td>
                                <td>{{ $reportBias->sum('sum_girls') > 0 ? number_format(($reportBias->sum('girls_hpv2') / $reportBias->sum('sum_girls')) * 100, 2) : 0 }}
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
