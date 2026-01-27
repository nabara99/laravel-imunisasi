<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class IdlExport
{
    protected $startDate;
    protected $endDate;
    protected $reportIDL;

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

        $this->reportIDL = DB::table('idls')
            ->join('childrens', 'idls.id_children', '=', 'childrens.id')
            ->join('villages', 'childrens.id_village', '=', 'villages.id')
            ->join('idl_targets', function($join) use ($startYear, $endYear) {
                $join->on('villages.id', '=', 'idl_targets.village_id')
                     ->whereBetween('idl_targets.year', [$startYear, $endYear]);
            })
            ->select(
                'villages.name as village_name',
                'idl_targets.sum_boys',
                'idl_targets.sum_girls',
                DB::raw('COUNT(DISTINCT childrens.id) AS total_children'),
                DB::raw("SUM(CASE WHEN idls.mr1 BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS complete"),
                DB::raw("SUM(CASE WHEN idls.mr1 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_complete"),
                DB::raw("SUM(CASE WHEN idls.mr1 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_complete"),
                DB::raw("SUM(CASE WHEN idls.hb0 BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS total_hb0"),
                DB::raw("SUM(CASE WHEN idls.hb0 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_hb0"),
                DB::raw("SUM(CASE WHEN idls.hb0 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_hb0"),
                DB::raw("SUM(CASE WHEN idls.bcg BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS total_bcg"),
                DB::raw("SUM(CASE WHEN idls.bcg BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_bcg"),
                DB::raw("SUM(CASE WHEN idls.bcg BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_bcg"),
                DB::raw("SUM(CASE WHEN idls.polio1 BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS total_polio1"),
                DB::raw("SUM(CASE WHEN idls.polio1 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_polio1"),
                DB::raw("SUM(CASE WHEN idls.polio1 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_polio1"),
                DB::raw("SUM(CASE WHEN idls.polio2 BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS total_polio2"),
                DB::raw("SUM(CASE WHEN idls.polio2 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_polio2"),
                DB::raw("SUM(CASE WHEN idls.polio2 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_polio2"),
                DB::raw("SUM(CASE WHEN idls.polio3 BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS total_polio3"),
                DB::raw("SUM(CASE WHEN idls.polio3 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_polio3"),
                DB::raw("SUM(CASE WHEN idls.polio3 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_polio3"),
                DB::raw("SUM(CASE WHEN idls.polio4 BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS total_polio4"),
                DB::raw("SUM(CASE WHEN idls.polio4 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_polio4"),
                DB::raw("SUM(CASE WHEN idls.polio4 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_polio4"),
                DB::raw("SUM(CASE WHEN idls.penta1 BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS total_penta1"),
                DB::raw("SUM(CASE WHEN idls.penta1 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_penta1"),
                DB::raw("SUM(CASE WHEN idls.penta1 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_penta1"),
                DB::raw("SUM(CASE WHEN idls.penta2 BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS total_penta2"),
                DB::raw("SUM(CASE WHEN idls.penta2 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_penta2"),
                DB::raw("SUM(CASE WHEN idls.penta2 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_penta2"),
                DB::raw("SUM(CASE WHEN idls.penta3 BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS total_penta3"),
                DB::raw("SUM(CASE WHEN idls.penta3 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_penta3"),
                DB::raw("SUM(CASE WHEN idls.penta3 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_penta3"),
                DB::raw("SUM(CASE WHEN idls.ipv1 BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS total_ipv1"),
                DB::raw("SUM(CASE WHEN idls.ipv1 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_ipv1"),
                DB::raw("SUM(CASE WHEN idls.ipv1 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_ipv1"),
                DB::raw("SUM(CASE WHEN idls.ipv2 BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS total_ipv2"),
                DB::raw("SUM(CASE WHEN idls.ipv2 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_ipv2"),
                DB::raw("SUM(CASE WHEN idls.ipv2 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_ipv2"),
                DB::raw("SUM(CASE WHEN idls.pcv1 BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS total_pcv1"),
                DB::raw("SUM(CASE WHEN idls.pcv1 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_pcv1"),
                DB::raw("SUM(CASE WHEN idls.pcv1 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_pcv1"),
                DB::raw("SUM(CASE WHEN idls.pcv2 BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS total_pcv2"),
                DB::raw("SUM(CASE WHEN idls.pcv2 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_pcv2"),
                DB::raw("SUM(CASE WHEN idls.pcv2 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_pcv2"),
                DB::raw("SUM(CASE WHEN idls.rotavirus1 BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS total_rotavirus1"),
                DB::raw("SUM(CASE WHEN idls.rotavirus1 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_rotavirus1"),
                DB::raw("SUM(CASE WHEN idls.rotavirus1 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_rotavirus1"),
                DB::raw("SUM(CASE WHEN idls.rotavirus2 BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS total_rotavirus2"),
                DB::raw("SUM(CASE WHEN idls.rotavirus2 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_rotavirus2"),
                DB::raw("SUM(CASE WHEN idls.rotavirus2 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_rotavirus2"),
                DB::raw("SUM(CASE WHEN idls.rotavirus3 BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS total_rotavirus3"),
                DB::raw("SUM(CASE WHEN idls.rotavirus3 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_rotavirus3"),
                DB::raw("SUM(CASE WHEN idls.rotavirus3 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_rotavirus3"),
            )
            ->groupBy('villages.id', 'villages.name', 'idl_targets.sum_boys', 'idl_targets.sum_girls')
            ->orderBy('villages.id')
            ->get();
    }

    public function download()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Common header style
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E0E0E0']]
        ];

        $currentRow = 1;

        // Build all tables (MR/IDL, HB0, BCG, Polio, Penta, IPV, PCV, Rotavirus)
        $this->buildTable($sheet, $currentRow, 'MR DAN IDL (IMUNISASI LENGKAP)', 'complete', 'boys_complete', 'girls_complete', $headerStyle);
        $this->buildTable($sheet, $currentRow, 'HB0', 'total_hb0', 'boys_hb0', 'girls_hb0', $headerStyle);
        $this->buildTable($sheet, $currentRow, 'BCG', 'total_bcg', 'boys_bcg', 'girls_bcg', $headerStyle);
        $this->buildMultiTable($sheet, $currentRow, 'POLIO', ['polio1', 'polio2', 'polio3', 'polio4'], $headerStyle);
        $this->buildMultiTable($sheet, $currentRow, 'PENTA', ['penta1', 'penta2', 'penta3'], $headerStyle);
        $this->buildMultiTable($sheet, $currentRow, 'IPV', ['ipv1', 'ipv2'], $headerStyle);
        $this->buildMultiTable($sheet, $currentRow, 'PCV', ['pcv1', 'pcv2'], $headerStyle);
        $this->buildMultiTable($sheet, $currentRow, 'ROTAVIRUS', ['rotavirus1', 'rotavirus2', 'rotavirus3'], $headerStyle);

        // Auto size columns
        foreach (range('A', 'T') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Download
        $filename = 'Laporan_IDL_' . date('Y-m-d', strtotime($this->startDate)) . '_to_' . date('Y-m-d', strtotime($this->endDate)) . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    protected function buildTable($sheet, &$currentRow, $title, $totalField, $boysField, $girlsField, $headerStyle)
    {
        // Title
        $sheet->setCellValue('A' . $currentRow, 'REKAP ' . $title . ' PUSKESMAS GIRI MULYA');
        $sheet->mergeCells('A' . $currentRow . ':H' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow++;

        $sheet->setCellValue('A' . $currentRow, 'PERIODE ' . date('j F Y', strtotime($this->startDate)) . ' s.d ' . date('j F Y', strtotime($this->endDate)));
        $sheet->mergeCells('A' . $currentRow . ':H' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow += 2;

        // Headers
        $sheet->setCellValue('A' . $currentRow, 'Desa');
        $sheet->setCellValue('B' . $currentRow, 'Bayi Baru Lahir');
        $sheet->mergeCells('B' . $currentRow . ':D' . $currentRow);
        $sheet->setCellValue('E' . $currentRow, $title);
        $sheet->mergeCells('E' . $currentRow . ':H' . $currentRow);
        $currentRow++;

        $sheet->setCellValue('B' . $currentRow, 'L');
        $sheet->setCellValue('C' . $currentRow, 'P');
        $sheet->setCellValue('D' . $currentRow, 'JLH');
        $sheet->setCellValue('E' . $currentRow, 'L');
        $sheet->setCellValue('F' . $currentRow, 'P');
        $sheet->setCellValue('G' . $currentRow, 'JLH');
        $sheet->setCellValue('H' . $currentRow, '%');

        $sheet->mergeCells('A' . ($currentRow - 1) . ':A' . $currentRow);
        $sheet->getStyle('A' . ($currentRow - 1) . ':H' . $currentRow)->applyFromArray($headerStyle);
        $currentRow++;
        $startDataRow = $currentRow;

        // Data
        foreach ($this->reportIDL as $report) {
            $totalBabies = $report->sum_boys + $report->sum_girls;
            $sheet->setCellValue('A' . $currentRow, $report->village_name);
            $sheet->setCellValue('B' . $currentRow, $report->sum_boys);
            $sheet->setCellValue('C' . $currentRow, $report->sum_girls);
            $sheet->setCellValue('D' . $currentRow, $totalBabies);
            $sheet->setCellValue('E' . $currentRow, $report->$boysField);
            $sheet->setCellValue('F' . $currentRow, $report->$girlsField);
            $sheet->setCellValue('G' . $currentRow, $report->$totalField);
            $sheet->setCellValue('H' . $currentRow, $totalBabies > 0 ? number_format(($report->$totalField / $totalBabies) * 100, 2) : 0);
            $currentRow++;
        }

        // Total row
        $totalBoys = $this->reportIDL->sum('sum_boys');
        $totalGirls = $this->reportIDL->sum('sum_girls');
        $totalBabies = $totalBoys + $totalGirls;

        $sheet->setCellValue('A' . $currentRow, 'Jumlah');
        $sheet->setCellValue('B' . $currentRow, $totalBoys);
        $sheet->setCellValue('C' . $currentRow, $totalGirls);
        $sheet->setCellValue('D' . $currentRow, $totalBabies);
        $sheet->setCellValue('E' . $currentRow, $this->reportIDL->sum($boysField));
        $sheet->setCellValue('F' . $currentRow, $this->reportIDL->sum($girlsField));
        $sheet->setCellValue('G' . $currentRow, $this->reportIDL->sum($totalField));
        $sheet->setCellValue('H' . $currentRow, $totalBabies > 0 ? number_format(($this->reportIDL->sum($totalField) / $totalBabies) * 100, 2) : 0);

        $sheet->getStyle('A' . $currentRow . ':H' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $startDataRow . ':H' . $currentRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        $currentRow += 3;
    }

    protected function buildMultiTable($sheet, &$currentRow, $title, $fields, $headerStyle)
    {
        $colCount = count($fields) * 4 + 1;
        $lastCol = chr(64 + $colCount);

        // Title
        $sheet->setCellValue('A' . $currentRow, 'REKAP ' . $title . ' PUSKESMAS GIRI MULYA');
        $sheet->mergeCells('A' . $currentRow . ':' . $lastCol . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow++;

        $sheet->setCellValue('A' . $currentRow, 'PERIODE ' . date('j F Y', strtotime($this->startDate)) . ' s.d ' . date('j F Y', strtotime($this->endDate)));
        $sheet->mergeCells('A' . $currentRow . ':' . $lastCol . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow += 2;

        // Headers row 1
        $sheet->setCellValue('A' . $currentRow, 'Desa');
        $col = 'B';
        foreach ($fields as $field) {
            $sheet->setCellValue($col . $currentRow, strtoupper($field));
            $endCol = chr(ord($col) + 3);
            $sheet->mergeCells($col . $currentRow . ':' . $endCol . $currentRow);
            $col = chr(ord($endCol) + 1);
        }
        $currentRow++;

        // Headers row 2
        $col = 'B';
        foreach ($fields as $field) {
            $sheet->setCellValue($col . $currentRow, 'L');
            $sheet->setCellValue(chr(ord($col) + 1) . $currentRow, 'P');
            $sheet->setCellValue(chr(ord($col) + 2) . $currentRow, 'JLH');
            $sheet->setCellValue(chr(ord($col) + 3) . $currentRow, '%');
            $col = chr(ord($col) + 4);
        }

        $sheet->mergeCells('A' . ($currentRow - 1) . ':A' . $currentRow);
        $sheet->getStyle('A' . ($currentRow - 1) . ':' . $lastCol . $currentRow)->applyFromArray($headerStyle);
        $currentRow++;
        $startDataRow = $currentRow;

        // Data
        foreach ($this->reportIDL as $report) {
            $totalBabies = $report->sum_boys + $report->sum_girls;
            $sheet->setCellValue('A' . $currentRow, $report->village_name);
            $col = 'B';
            foreach ($fields as $field) {
                $boysField = 'boys_' . $field;
                $girlsField = 'girls_' . $field;
                $totalField = 'total_' . $field;

                $sheet->setCellValue($col . $currentRow, $report->$boysField);
                $sheet->setCellValue(chr(ord($col) + 1) . $currentRow, $report->$girlsField);
                $sheet->setCellValue(chr(ord($col) + 2) . $currentRow, $report->$totalField);
                $sheet->setCellValue(chr(ord($col) + 3) . $currentRow, $totalBabies > 0 ? number_format(($report->$totalField / $totalBabies) * 100, 2) : 0);
                $col = chr(ord($col) + 4);
            }
            $currentRow++;
        }

        // Total row
        $totalBabies = $this->reportIDL->sum('sum_boys') + $this->reportIDL->sum('sum_girls');
        $sheet->setCellValue('A' . $currentRow, 'Jumlah');
        $col = 'B';
        foreach ($fields as $field) {
            $boysField = 'boys_' . $field;
            $girlsField = 'girls_' . $field;
            $totalField = 'total_' . $field;

            $sheet->setCellValue($col . $currentRow, $this->reportIDL->sum($boysField));
            $sheet->setCellValue(chr(ord($col) + 1) . $currentRow, $this->reportIDL->sum($girlsField));
            $sheet->setCellValue(chr(ord($col) + 2) . $currentRow, $this->reportIDL->sum($totalField));
            $sheet->setCellValue(chr(ord($col) + 3) . $currentRow, $totalBabies > 0 ? number_format(($this->reportIDL->sum($totalField) / $totalBabies) * 100, 2) : 0);
            $col = chr(ord($col) + 4);
        }

        $sheet->getStyle('A' . $currentRow . ':' . $lastCol . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $startDataRow . ':' . $lastCol . $currentRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        $currentRow += 3;
    }
}
