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
                                <th colspan="4">HB0</th>
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
    <br>
    <table style="width: 100%; border-collapse: collapse; text-align: center; font-family: arial; font-size: 8pt;">
        <tr>
            <td colspan="3"><b>REKAP BCG PUSKESMAS GIRI MULYA</b></td>
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
                                <th colspan="4">BCG</th>
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
                                    <td>{{ $report->boys_bcg }}</td>
                                    <td>{{ $report->girls_bcg }}</td>
                                    <td>{{ $report->total_bcg }}</td>
                                    <td>{{ number_format(($report->total_bcg / ($report->sum_girls + $report->sum_girls)) * 100, 2) }}
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
                                <td>{{ $reportIdl->sum('boys_bcg') }}</td>
                                <td>{{ $reportIdl->sum('girls_bcg') }}</td>
                                <td>{{ $reportIdl->sum('total_bcg') }}</td>
                                <td>{{ number_format(($reportIdl->sum('total_bcg') / ($reportIdl->sum('sum_girls') + $reportIdl->sum('sum_boys'))) * 100, 2) }}
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
            <td colspan="3"><b>REKAP POLIO PUSKESMAS GIRI MULYA</b></td>
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
                                <th colspan="4">POLIO 1</th>
                                <th colspan="4">POLIO 2</th>
                                <th colspan="4">POLIO 3</th>
                                <th colspan="4">POLIO 4</th>
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
                                    <td>{{ $report->boys_polio1 }}</td>
                                    <td>{{ $report->girls_polio1 }}</td>
                                    <td>{{ $report->total_polio1 }}</td>
                                    <td>{{ number_format(($report->total_polio1 / ($report->sum_girls + $report->sum_girls)) * 100, 2) }}
                                    </td>
                                    <td>{{ $report->boys_polio2 }}</td>
                                    <td>{{ $report->girls_polio2 }}</td>
                                    <td>{{ $report->total_polio2 }}</td>
                                    <td>{{ number_format(($report->total_polio2 / ($report->sum_girls + $report->sum_girls)) * 100, 2) }}
                                    </td>
                                    <td>{{ $report->boys_polio3 }}</td>
                                    <td>{{ $report->girls_polio3 }}</td>
                                    <td>{{ $report->total_polio3 }}</td>
                                    <td>{{ number_format(($report->total_polio3 / ($report->sum_girls + $report->sum_girls)) * 100, 2) }}
                                    </td>
                                    <td>{{ $report->boys_polio4 }}</td>
                                    <td>{{ $report->girls_polio4 }}</td>
                                    <td>{{ $report->total_polio4 }}</td>
                                    <td>{{ number_format(($report->total_polio4 / ($report->sum_girls + $report->sum_girls)) * 100, 2) }}
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
                                <td>{{ $reportIdl->sum('boys_polio1') }}</td>
                                <td>{{ $reportIdl->sum('girls_polio1') }}</td>
                                <td>{{ $reportIdl->sum('total_polio1') }}</td>
                                <td>{{ number_format(($reportIdl->sum('total_polio1') / ($reportIdl->sum('sum_girls') + $reportIdl->sum('sum_boys'))) * 100, 2) }}
                                </td>
                                <td>{{ $reportIdl->sum('boys_polio2') }}</td>
                                <td>{{ $reportIdl->sum('girls_polio2') }}</td>
                                <td>{{ $reportIdl->sum('total_polio2') }}</td>
                                <td>{{ number_format(($reportIdl->sum('total_polio2') / ($reportIdl->sum('sum_girls') + $reportIdl->sum('sum_boys'))) * 100, 2) }}
                                </td>
                                <td>{{ $reportIdl->sum('boys_polio3') }}</td>
                                <td>{{ $reportIdl->sum('girls_polio3') }}</td>
                                <td>{{ $reportIdl->sum('total_polio3') }}</td>
                                <td>{{ number_format(($reportIdl->sum('total_polio3') / ($reportIdl->sum('sum_girls') + $reportIdl->sum('sum_boys'))) * 100, 2) }}
                                </td>
                                <td>{{ $reportIdl->sum('boys_polio4') }}</td>
                                <td>{{ $reportIdl->sum('girls_polio4') }}</td>
                                <td>{{ $reportIdl->sum('total_polio4') }}</td>
                                <td>{{ number_format(($reportIdl->sum('total_polio4') / ($reportIdl->sum('sum_girls') + $reportIdl->sum('sum_boys'))) * 100, 2) }}
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
            <td colspan="3"><b>REKAP PENTBIO PUSKESMAS GIRI MULYA</b></td>
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
                                <th colspan="4">DPT-HB-HIB 1</th>
                                <th colspan="4">DPT-HB-HIB 2</th>
                                <th colspan="4">DPT-HB-HIB 3</th>
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
                            @foreach ($reportIdl as $report)
                                <tr>
                                    <td>{{ $report->village_name }}</td>
                                    <td>{{ $report->sum_boys }}</td>
                                    <td>{{ $report->sum_girls }}</td>
                                    <td>{{ $report->sum_boys + $report->sum_girls }}</td>
                                    <td>{{ $report->boys_penta1 }}</td>
                                    <td>{{ $report->girls_penta1 }}</td>
                                    <td>{{ $report->total_penta1 }}</td>
                                    <td>{{ number_format(($report->total_penta1 / ($report->sum_girls + $report->sum_girls)) * 100, 2) }}
                                    </td>
                                    <td>{{ $report->boys_penta2 }}</td>
                                    <td>{{ $report->girls_penta2 }}</td>
                                    <td>{{ $report->total_penta2 }}</td>
                                    <td>{{ number_format(($report->total_penta2 / ($report->sum_girls + $report->sum_girls)) * 100, 2) }}
                                    </td>
                                    <td>{{ $report->boys_penta3 }}</td>
                                    <td>{{ $report->girls_penta3 }}</td>
                                    <td>{{ $report->total_penta3 }}</td>
                                    <td>{{ number_format(($report->total_penta3 / ($report->sum_girls + $report->sum_girls)) * 100, 2) }}
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
                                <td>{{ $reportIdl->sum('boys_penta1') }}</td>
                                <td>{{ $reportIdl->sum('girls_penta1') }}</td>
                                <td>{{ $reportIdl->sum('total_penta1') }}</td>
                                <td>{{ number_format(($reportIdl->sum('total_penta1') / ($reportIdl->sum('sum_girls') + $reportIdl->sum('sum_boys'))) * 100, 2) }}
                                </td>
                                <td>{{ $reportIdl->sum('boys_penta2') }}</td>
                                <td>{{ $reportIdl->sum('girls_penta2') }}</td>
                                <td>{{ $reportIdl->sum('total_penta2') }}</td>
                                <td>{{ number_format(($reportIdl->sum('total_penta2') / ($reportIdl->sum('sum_girls') + $reportIdl->sum('sum_boys'))) * 100, 2) }}
                                </td>
                                <td>{{ $reportIdl->sum('boys_penta3') }}</td>
                                <td>{{ $reportIdl->sum('girls_penta3') }}</td>
                                <td>{{ $reportIdl->sum('total_penta3') }}</td>
                                <td>{{ number_format(($reportIdl->sum('total_penta3') / ($reportIdl->sum('sum_girls') + $reportIdl->sum('sum_boys'))) * 100, 2) }}
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
            <td colspan="3"><b>REKAP IPV PUSKESMAS GIRI MULYA</b></td>
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
                                <th colspan="4">IPV 1</th>
                                <th colspan="4">IPV 2</th>
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reportIdl as $report)
                                <tr>
                                    <td>{{ $report->village_name }}</td>
                                    <td>{{ $report->sum_boys }}</td>
                                    <td>{{ $report->sum_girls }}</td>
                                    <td>{{ $report->sum_boys + $report->sum_girls }}</td>
                                    <td>{{ $report->boys_ipv1 }}</td>
                                    <td>{{ $report->girls_ipv1 }}</td>
                                    <td>{{ $report->total_ipv1 }}</td>
                                    <td>{{ number_format(($report->total_ipv1 / ($report->sum_girls + $report->sum_girls)) * 100, 2) }}
                                    </td>
                                    <td>{{ $report->boys_ipv2 }}</td>
                                    <td>{{ $report->girls_ipv2 }}</td>
                                    <td>{{ $report->total_ipv2 }}</td>
                                    <td>{{ number_format(($report->total_ipv2 / ($report->sum_girls + $report->sum_girls)) * 100, 2) }}
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
                                <td>{{ $reportIdl->sum('boys_ipv1') }}</td>
                                <td>{{ $reportIdl->sum('girls_ipv1') }}</td>
                                <td>{{ $reportIdl->sum('total_ipv1') }}</td>
                                <td>{{ number_format(($reportIdl->sum('total_ipv1') / ($reportIdl->sum('sum_girls') + $reportIdl->sum('sum_boys'))) * 100, 2) }}
                                </td>
                                <td>{{ $reportIdl->sum('boys_ipv2') }}</td>
                                <td>{{ $reportIdl->sum('girls_ipv2') }}</td>
                                <td>{{ $reportIdl->sum('total_ipv2') }}</td>
                                <td>{{ number_format(($reportIdl->sum('total_ipv2') / ($reportIdl->sum('sum_girls') + $reportIdl->sum('sum_boys'))) * 100, 2) }}
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
            <td colspan="3"><b>REKAP PCV PUSKESMAS GIRI MULYA</b></td>
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
                                <th colspan="4">PCV 1</th>
                                <th colspan="4">PCV 2</th>
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reportIdl as $report)
                                <tr>
                                    <td>{{ $report->village_name }}</td>
                                    <td>{{ $report->sum_boys }}</td>
                                    <td>{{ $report->sum_girls }}</td>
                                    <td>{{ $report->sum_boys + $report->sum_girls }}</td>
                                    <td>{{ $report->boys_pcv1 }}</td>
                                    <td>{{ $report->girls_pcv1 }}</td>
                                    <td>{{ $report->total_pcv1 }}</td>
                                    <td>{{ number_format(($report->total_pcv1 / ($report->sum_girls + $report->sum_girls)) * 100, 2) }}
                                    </td>
                                    <td>{{ $report->boys_pcv2 }}</td>
                                    <td>{{ $report->girls_pcv2 }}</td>
                                    <td>{{ $report->total_pcv2 }}</td>
                                    <td>{{ number_format(($report->total_pcv2 / ($report->sum_girls + $report->sum_girls)) * 100, 2) }}
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
                                <td>{{ $reportIdl->sum('boys_pcv1') }}</td>
                                <td>{{ $reportIdl->sum('girls_pcv1') }}</td>
                                <td>{{ $reportIdl->sum('total_pcv1') }}</td>
                                <td>{{ number_format(($reportIdl->sum('total_pcv1') / ($reportIdl->sum('sum_girls') + $reportIdl->sum('sum_boys'))) * 100, 2) }}
                                </td>
                                <td>{{ $reportIdl->sum('boys_pcv2') }}</td>
                                <td>{{ $reportIdl->sum('girls_pcv2') }}</td>
                                <td>{{ $reportIdl->sum('total_pcv2') }}</td>
                                <td>{{ number_format(($reportIdl->sum('total_pcv2') / ($reportIdl->sum('sum_girls') + $reportIdl->sum('sum_boys'))) * 100, 2) }}
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
            <td colspan="3"><b>REKAP ROTAVIRUS PUSKESMAS GIRI MULYA</b></td>
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
                                <th colspan="4">ROTAVIRUS 1</th>
                                <th colspan="4">ROTAVIRUS 2</th>
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reportIdl as $report)
                                <tr>
                                    <td>{{ $report->village_name }}</td>
                                    <td>{{ $report->sum_boys }}</td>
                                    <td>{{ $report->sum_girls }}</td>
                                    <td>{{ $report->sum_boys + $report->sum_girls }}</td>
                                    <td>{{ $report->boys_rotavirus1 }}</td>
                                    <td>{{ $report->girls_rotavirus1 }}</td>
                                    <td>{{ $report->total_rotavirus1 }}</td>
                                    <td>{{ number_format(($report->total_rotavirus1 / ($report->sum_girls + $report->sum_girls)) * 100, 2) }}
                                    </td>
                                    <td>{{ $report->boys_rotavirus2 }}</td>
                                    <td>{{ $report->girls_rotavirus2 }}</td>
                                    <td>{{ $report->total_rotavirus2 }}</td>
                                    <td>{{ number_format(($report->total_rotavirus2 / ($report->sum_girls + $report->sum_girls)) * 100, 2) }}
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
                                <td>{{ $reportIdl->sum('boys_rotavirus1') }}</td>
                                <td>{{ $reportIdl->sum('girls_rotavirus1') }}</td>
                                <td>{{ $reportIdl->sum('total_rotavirus1') }}</td>
                                <td>{{ number_format(($reportIdl->sum('total_rotavirus1') / ($reportIdl->sum('sum_girls') + $reportIdl->sum('sum_boys'))) * 100, 2) }}
                                </td>
                                <td>{{ $reportIdl->sum('boys_rotavirus2') }}</td>
                                <td>{{ $reportIdl->sum('girls_rotavirus2') }}</td>
                                <td>{{ $reportIdl->sum('total_rotavirus2') }}</td>
                                <td>{{ number_format(($reportIdl->sum('total_rotavirus2') / ($reportIdl->sum('sum_girls') + $reportIdl->sum('sum_boys'))) * 100, 2) }}
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
