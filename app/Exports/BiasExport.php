<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class BiasExport
{
    protected $startDate;
    protected $endDate;
    protected $reportBIAS;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->fetchData();
    }

    protected function fetchData()
    {
        $startYear = date('Y', strtotime($this->startDate));
        $endYear = date('Y', strtotime($this->endDate));

        $this->reportBIAS = DB::table('student_targets')
            ->join('schools', 'student_targets.id_school', '=', 'schools.id')
            ->leftJoin('students', 'schools.id', '=', 'students.id_school')
            ->leftJoin('student_imuns', 'students.id', '=', 'student_imuns.id_student')
            ->whereBetween('student_targets.year', [$startYear, $endYear])
            ->select(
                'schools.name as school_name',
                'student_targets.classroom',
                'student_targets.sum_boys',
                'student_targets.sum_girls',
                DB::raw('COUNT(DISTINCT students.id) AS total_students'),
                DB::raw("SUM(CASE WHEN student_imuns.dt BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS total_dt"),
                DB::raw("SUM(CASE WHEN student_imuns.dt BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND students.gender = 'L' THEN 1 ELSE 0 END) AS boys_dt"),
                DB::raw("SUM(CASE WHEN student_imuns.dt BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND students.gender = 'P' THEN 1 ELSE 0 END) AS girls_dt"),
                DB::raw("SUM(CASE WHEN student_imuns.mr BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS total_mr"),
                DB::raw("SUM(CASE WHEN student_imuns.mr BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND students.gender = 'L' THEN 1 ELSE 0 END) AS boys_mr"),
                DB::raw("SUM(CASE WHEN student_imuns.mr BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND students.gender = 'P' THEN 1 ELSE 0 END) AS girls_mr"),
                DB::raw("SUM(CASE WHEN student_imuns.td1 BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS total_td1"),
                DB::raw("SUM(CASE WHEN student_imuns.td1 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND students.gender = 'L' THEN 1 ELSE 0 END) AS boys_td1"),
                DB::raw("SUM(CASE WHEN student_imuns.td1 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND students.gender = 'P' THEN 1 ELSE 0 END) AS girls_td1"),
                DB::raw("SUM(CASE WHEN student_imuns.td2pa BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS total_td2pa"),
                DB::raw("SUM(CASE WHEN student_imuns.td2pa BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND students.gender = 'L' THEN 1 ELSE 0 END) AS boys_td2pa"),
                DB::raw("SUM(CASE WHEN student_imuns.td2pa BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND students.gender = 'P' THEN 1 ELSE 0 END) AS girls_td2pa"),
                DB::raw("SUM(CASE WHEN student_imuns.td2pi BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS total_td2pi"),
                DB::raw("SUM(CASE WHEN student_imuns.td2pi BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND students.gender = 'L' THEN 1 ELSE 0 END) AS boys_td2pi"),
                DB::raw("SUM(CASE WHEN student_imuns.td2pi BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND students.gender = 'P' THEN 1 ELSE 0 END) AS girls_td2pi"),
                DB::raw("SUM(CASE WHEN student_imuns.hpv1 BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS total_hpv1"),
                DB::raw("SUM(CASE WHEN student_imuns.hpv1 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND students.gender = 'P' THEN 1 ELSE 0 END) AS girls_hpv1"),
                DB::raw("SUM(CASE WHEN student_imuns.hpv2 BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS total_hpv2"),
                DB::raw("SUM(CASE WHEN student_imuns.hpv2 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND students.gender = 'P' THEN 1 ELSE 0 END) AS girls_hpv2")
            )
            ->groupBy('schools.id', 'schools.name', 'student_targets.classroom', 'student_targets.sum_boys', 'student_targets.sum_girls', 'student_targets.year')
            ->orderBy('schools.id')
            ->get();
    }

    public function download()
    {
        $spreadsheet = new Spreadsheet();

        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E0E0E0']]
        ];

        // Sheet 1: DT BIAS
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('DT BIAS');
        $this->buildSimpleSheet($sheet, 'DT', 'total_dt', 'boys_dt', 'girls_dt', $headerStyle);

        // Sheet 2: MR BIAS
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('MR BIAS');
        $this->buildSimpleSheet($sheet2, 'MR', 'total_mr', 'boys_mr', 'girls_mr', $headerStyle);

        // Sheet 3: TD BIAS
        $sheet3 = $spreadsheet->createSheet();
        $sheet3->setTitle('TD BIAS');
        $this->buildTdSheet($sheet3, $headerStyle);

        // Sheet 4: HPV BIAS
        $sheet4 = $spreadsheet->createSheet();
        $sheet4->setTitle('HPV BIAS');
        $this->buildHpvSheet($sheet4, $headerStyle);

        // Download
        $filename = 'Laporan_BIAS_' . date('Y-m-d', strtotime($this->startDate)) . '_to_' . date('Y-m-d', strtotime($this->endDate)) . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    protected function buildSimpleSheet($sheet, $title, $totalField, $boysField, $girlsField, $headerStyle)
    {
        // Header
        $sheet->setCellValue('A1', 'REKAP ' . $title . ' BIAS PUSKESMAS GIRI MULYA');
        $sheet->mergeCells('A1:I1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'PERIODE ' . date('j F Y', strtotime($this->startDate)) . ' s.d ' . date('j F Y', strtotime($this->endDate)));
        $sheet->mergeCells('A2:I2');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Table header
        $sheet->setCellValue('A4', 'Sekolah');
        $sheet->setCellValue('B4', 'Kelas');
        $sheet->setCellValue('C4', 'Sasaran Siswa');
        $sheet->mergeCells('C4:E4');
        $sheet->setCellValue('F4', $title);
        $sheet->mergeCells('F4:I4');

        $sheet->setCellValue('C5', 'L');
        $sheet->setCellValue('D5', 'P');
        $sheet->setCellValue('E5', 'JLH');
        $sheet->setCellValue('F5', 'L');
        $sheet->setCellValue('G5', 'P');
        $sheet->setCellValue('H5', 'JLH');
        $sheet->setCellValue('I5', '%');

        $sheet->mergeCells('A4:A5');
        $sheet->mergeCells('B4:B5');
        $sheet->getStyle('A4:I5')->applyFromArray($headerStyle);

        // Data
        $row = 6;
        foreach ($this->reportBIAS as $report) {
            $totalStudents = $report->sum_boys + $report->sum_girls;
            $percentage = $totalStudents > 0 ? ($report->$totalField / $totalStudents) * 100 : 0;

            $sheet->setCellValue('A' . $row, $report->school_name);
            $sheet->setCellValue('B' . $row, $report->classroom);
            $sheet->setCellValue('C' . $row, $report->sum_boys);
            $sheet->setCellValue('D' . $row, $report->sum_girls);
            $sheet->setCellValue('E' . $row, $totalStudents);
            $sheet->setCellValue('F' . $row, $report->$boysField);
            $sheet->setCellValue('G' . $row, $report->$girlsField);
            $sheet->setCellValue('H' . $row, $report->$totalField);
            $sheet->setCellValue('I' . $row, number_format($percentage, 2));
            $row++;
        }

        // Total row
        $totalStudentsSum = $this->reportBIAS->sum('sum_boys') + $this->reportBIAS->sum('sum_girls');
        $totalPercentage = $totalStudentsSum > 0 ? ($this->reportBIAS->sum($totalField) / $totalStudentsSum) * 100 : 0;

        $sheet->setCellValue('A' . $row, 'Jumlah');
        $sheet->mergeCells('A' . $row . ':B' . $row);
        $sheet->setCellValue('C' . $row, $this->reportBIAS->sum('sum_boys'));
        $sheet->setCellValue('D' . $row, $this->reportBIAS->sum('sum_girls'));
        $sheet->setCellValue('E' . $row, $totalStudentsSum);
        $sheet->setCellValue('F' . $row, $this->reportBIAS->sum($boysField));
        $sheet->setCellValue('G' . $row, $this->reportBIAS->sum($girlsField));
        $sheet->setCellValue('H' . $row, $this->reportBIAS->sum($totalField));
        $sheet->setCellValue('I' . $row, number_format($totalPercentage, 2));
        $sheet->getStyle('A' . $row . ':I' . $row)->getFont()->setBold(true);

        $sheet->getStyle('A6:I' . $row)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);
        $sheet->getStyle('A6:I' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    protected function buildTdSheet($sheet, $headerStyle)
    {
        // Header
        $sheet->setCellValue('A1', 'REKAP TD BIAS PUSKESMAS GIRI MULYA');
        $sheet->mergeCells('A1:Q1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'PERIODE ' . date('j F Y', strtotime($this->startDate)) . ' s.d ' . date('j F Y', strtotime($this->endDate)));
        $sheet->mergeCells('A2:Q2');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Table header
        $sheet->setCellValue('A4', 'Sekolah');
        $sheet->setCellValue('B4', 'Kelas');
        $sheet->setCellValue('C4', 'Sasaran Siswa');
        $sheet->mergeCells('C4:E4');
        $sheet->setCellValue('F4', 'TD1');
        $sheet->mergeCells('F4:I4');
        $sheet->setCellValue('J4', 'TD2 PA');
        $sheet->mergeCells('J4:M4');
        $sheet->setCellValue('N4', 'TD2 PI');
        $sheet->mergeCells('N4:Q4');

        $sheet->setCellValue('C5', 'L');
        $sheet->setCellValue('D5', 'P');
        $sheet->setCellValue('E5', 'JLH');
        $sheet->setCellValue('F5', 'L');
        $sheet->setCellValue('G5', 'P');
        $sheet->setCellValue('H5', 'JLH');
        $sheet->setCellValue('I5', '%');
        $sheet->setCellValue('J5', 'L');
        $sheet->setCellValue('K5', 'P');
        $sheet->setCellValue('L5', 'JLH');
        $sheet->setCellValue('M5', '%');
        $sheet->setCellValue('N5', 'L');
        $sheet->setCellValue('O5', 'P');
        $sheet->setCellValue('P5', 'JLH');
        $sheet->setCellValue('Q5', '%');

        $sheet->mergeCells('A4:A5');
        $sheet->mergeCells('B4:B5');
        $sheet->getStyle('A4:Q5')->applyFromArray($headerStyle);

        // Data
        $row = 6;
        foreach ($this->reportBIAS as $report) {
            $totalStudents = $report->sum_boys + $report->sum_girls;
            $percentageTd1 = $totalStudents > 0 ? ($report->total_td1 / $totalStudents) * 100 : 0;
            $percentageTd2pa = $totalStudents > 0 ? ($report->total_td2pa / $totalStudents) * 100 : 0;
            $percentageTd2pi = $totalStudents > 0 ? ($report->total_td2pi / $totalStudents) * 100 : 0;

            $sheet->setCellValue('A' . $row, $report->school_name);
            $sheet->setCellValue('B' . $row, $report->classroom);
            $sheet->setCellValue('C' . $row, $report->sum_boys);
            $sheet->setCellValue('D' . $row, $report->sum_girls);
            $sheet->setCellValue('E' . $row, $totalStudents);
            $sheet->setCellValue('F' . $row, $report->boys_td1);
            $sheet->setCellValue('G' . $row, $report->girls_td1);
            $sheet->setCellValue('H' . $row, $report->total_td1);
            $sheet->setCellValue('I' . $row, number_format($percentageTd1, 2));
            $sheet->setCellValue('J' . $row, $report->boys_td2pa);
            $sheet->setCellValue('K' . $row, $report->girls_td2pa);
            $sheet->setCellValue('L' . $row, $report->total_td2pa);
            $sheet->setCellValue('M' . $row, number_format($percentageTd2pa, 2));
            $sheet->setCellValue('N' . $row, $report->boys_td2pi);
            $sheet->setCellValue('O' . $row, $report->girls_td2pi);
            $sheet->setCellValue('P' . $row, $report->total_td2pi);
            $sheet->setCellValue('Q' . $row, number_format($percentageTd2pi, 2));
            $row++;
        }

        // Total row
        $totalStudentsSum = $this->reportBIAS->sum('sum_boys') + $this->reportBIAS->sum('sum_girls');
        $totalPercentageTd1 = $totalStudentsSum > 0 ? ($this->reportBIAS->sum('total_td1') / $totalStudentsSum) * 100 : 0;
        $totalPercentageTd2pa = $totalStudentsSum > 0 ? ($this->reportBIAS->sum('total_td2pa') / $totalStudentsSum) * 100 : 0;
        $totalPercentageTd2pi = $totalStudentsSum > 0 ? ($this->reportBIAS->sum('total_td2pi') / $totalStudentsSum) * 100 : 0;

        $sheet->setCellValue('A' . $row, 'Jumlah');
        $sheet->mergeCells('A' . $row . ':B' . $row);
        $sheet->setCellValue('C' . $row, $this->reportBIAS->sum('sum_boys'));
        $sheet->setCellValue('D' . $row, $this->reportBIAS->sum('sum_girls'));
        $sheet->setCellValue('E' . $row, $totalStudentsSum);
        $sheet->setCellValue('F' . $row, $this->reportBIAS->sum('boys_td1'));
        $sheet->setCellValue('G' . $row, $this->reportBIAS->sum('girls_td1'));
        $sheet->setCellValue('H' . $row, $this->reportBIAS->sum('total_td1'));
        $sheet->setCellValue('I' . $row, number_format($totalPercentageTd1, 2));
        $sheet->setCellValue('J' . $row, $this->reportBIAS->sum('boys_td2pa'));
        $sheet->setCellValue('K' . $row, $this->reportBIAS->sum('girls_td2pa'));
        $sheet->setCellValue('L' . $row, $this->reportBIAS->sum('total_td2pa'));
        $sheet->setCellValue('M' . $row, number_format($totalPercentageTd2pa, 2));
        $sheet->setCellValue('N' . $row, $this->reportBIAS->sum('boys_td2pi'));
        $sheet->setCellValue('O' . $row, $this->reportBIAS->sum('girls_td2pi'));
        $sheet->setCellValue('P' . $row, $this->reportBIAS->sum('total_td2pi'));
        $sheet->setCellValue('Q' . $row, number_format($totalPercentageTd2pi, 2));
        $sheet->getStyle('A' . $row . ':Q' . $row)->getFont()->setBold(true);

        $sheet->getStyle('A6:Q' . $row)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);
        $sheet->getStyle('A6:Q' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        foreach (range('A', 'Q') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    protected function buildHpvSheet($sheet, $headerStyle)
    {
        // Header
        $sheet->setCellValue('A1', 'REKAP HPV BIAS PUSKESMAS GIRI MULYA');
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'PERIODE ' . date('j F Y', strtotime($this->startDate)) . ' s.d ' . date('j F Y', strtotime($this->endDate)));
        $sheet->mergeCells('A2:H2');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Table header
        $sheet->setCellValue('A4', 'Sekolah');
        $sheet->setCellValue('B4', 'Kelas');
        $sheet->setCellValue('C4', 'Sasaran Siswa Perempuan');
        $sheet->mergeCells('C4:D4');
        $sheet->setCellValue('E4', 'HPV 1');
        $sheet->mergeCells('E4:F4');
        $sheet->setCellValue('G4', 'HPV 2');
        $sheet->mergeCells('G4:H4');

        $sheet->setCellValue('C5', 'P');
        $sheet->setCellValue('D5', 'JLH');
        $sheet->setCellValue('E5', 'JLH');
        $sheet->setCellValue('F5', '%');
        $sheet->setCellValue('G5', 'JLH');
        $sheet->setCellValue('H5', '%');

        $sheet->mergeCells('A4:A5');
        $sheet->mergeCells('B4:B5');
        $sheet->getStyle('A4:H5')->applyFromArray($headerStyle);

        // Data
        $row = 6;
        foreach ($this->reportBIAS as $report) {
            $percentageHpv1 = $report->sum_girls > 0 ? ($report->girls_hpv1 / $report->sum_girls) * 100 : 0;
            $percentageHpv2 = $report->sum_girls > 0 ? ($report->girls_hpv2 / $report->sum_girls) * 100 : 0;

            $sheet->setCellValue('A' . $row, $report->school_name);
            $sheet->setCellValue('B' . $row, $report->classroom);
            $sheet->setCellValue('C' . $row, $report->sum_girls);
            $sheet->setCellValue('D' . $row, $report->sum_girls);
            $sheet->setCellValue('E' . $row, $report->girls_hpv1);
            $sheet->setCellValue('F' . $row, number_format($percentageHpv1, 2));
            $sheet->setCellValue('G' . $row, $report->girls_hpv2);
            $sheet->setCellValue('H' . $row, number_format($percentageHpv2, 2));
            $row++;
        }

        // Total row
        $totalGirls = $this->reportBIAS->sum('sum_girls');
        $totalPercentageHpv1 = $totalGirls > 0 ? ($this->reportBIAS->sum('girls_hpv1') / $totalGirls) * 100 : 0;
        $totalPercentageHpv2 = $totalGirls > 0 ? ($this->reportBIAS->sum('girls_hpv2') / $totalGirls) * 100 : 0;

        $sheet->setCellValue('A' . $row, 'Jumlah');
        $sheet->mergeCells('A' . $row . ':B' . $row);
        $sheet->setCellValue('C' . $row, $totalGirls);
        $sheet->setCellValue('D' . $row, $totalGirls);
        $sheet->setCellValue('E' . $row, $this->reportBIAS->sum('girls_hpv1'));
        $sheet->setCellValue('F' . $row, number_format($totalPercentageHpv1, 2));
        $sheet->setCellValue('G' . $row, $this->reportBIAS->sum('girls_hpv2'));
        $sheet->setCellValue('H' . $row, number_format($totalPercentageHpv2, 2));
        $sheet->getStyle('A' . $row . ':H' . $row)->getFont()->setBold(true);

        $sheet->getStyle('A6:H' . $row)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);
        $sheet->getStyle('A6:H' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}
