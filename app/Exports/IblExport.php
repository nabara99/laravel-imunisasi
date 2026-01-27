<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class IblExport
{
    protected $startDate;
    protected $endDate;
    protected $reportIBL;

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

        $this->reportIBL = DB::table('ibls')
            ->join('childrens', 'ibls.id_children', '=', 'childrens.id')
            ->join('villages', 'childrens.id_village', '=', 'villages.id')
            ->join('ibl_targets', function($join) use ($startYear, $endYear) {
                $join->on('villages.id', '=', 'ibl_targets.village_id')
                     ->whereBetween('ibl_targets.year', [$startYear, $endYear]);
            })
            ->select(
                'villages.name as village_name',
                'ibl_targets.sum_boys',
                'ibl_targets.sum_girls',
                DB::raw('COUNT(DISTINCT childrens.id) AS total_children'),
                DB::raw("SUM(CASE WHEN ibls.pcv3 BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS total_pcv3"),
                DB::raw("SUM(CASE WHEN ibls.pcv3 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_pcv3"),
                DB::raw("SUM(CASE WHEN ibls.pcv3 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_pcv3"),
                DB::raw("SUM(CASE WHEN ibls.penta4 BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS total_penta4"),
                DB::raw("SUM(CASE WHEN ibls.penta4 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_penta4"),
                DB::raw("SUM(CASE WHEN ibls.penta4 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_penta4"),
                DB::raw("SUM(CASE WHEN ibls.mr2 BETWEEN '{$this->startDate}' AND '{$this->endDate}' THEN 1 ELSE 0 END) AS total_mr2"),
                DB::raw("SUM(CASE WHEN ibls.mr2 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'L' THEN 1 ELSE 0 END) AS boys_mr2"),
                DB::raw("SUM(CASE WHEN ibls.mr2 BETWEEN '{$this->startDate}' AND '{$this->endDate}' AND childrens.gender = 'P' THEN 1 ELSE 0 END) AS girls_mr2"),
            )
            ->groupBy('villages.id', 'villages.name', 'ibl_targets.sum_boys', 'ibl_targets.sum_girls')
            ->orderBy('villages.id')
            ->get();
    }

    public function download()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E0E0E0']]
        ];

        $currentRow = 1;

        // Build PCV3, Penta4, and MR2 tables
        $this->buildTable($sheet, $currentRow, 'PCV3', 'total_pcv3', 'boys_pcv3', 'girls_pcv3', $headerStyle);
        $this->buildTable($sheet, $currentRow, 'PENTA4', 'total_penta4', 'boys_penta4', 'girls_penta4', $headerStyle);
        $this->buildTable($sheet, $currentRow, 'MR2', 'total_mr2', 'boys_mr2', 'girls_mr2', $headerStyle);

        // Auto size columns
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Download
        $filename = 'Laporan_IBL_' . date('Y-m-d', strtotime($this->startDate)) . '_to_' . date('Y-m-d', strtotime($this->endDate)) . '.xlsx';

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
        $sheet->setCellValue('B' . $currentRow, 'Baduta');
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
        foreach ($this->reportIBL as $report) {
            $totalBaduta = $report->sum_boys + $report->sum_girls;
            $sheet->setCellValue('A' . $currentRow, $report->village_name);
            $sheet->setCellValue('B' . $currentRow, $report->sum_boys);
            $sheet->setCellValue('C' . $currentRow, $report->sum_girls);
            $sheet->setCellValue('D' . $currentRow, $totalBaduta);
            $sheet->setCellValue('E' . $currentRow, $report->$boysField);
            $sheet->setCellValue('F' . $currentRow, $report->$girlsField);
            $sheet->setCellValue('G' . $currentRow, $report->$totalField);
            $sheet->setCellValue('H' . $currentRow, $totalBaduta > 0 ? number_format(($report->$totalField / $totalBaduta) * 100, 2) : 0);
            $currentRow++;
        }

        // Total row
        $totalBoys = $this->reportIBL->sum('sum_boys');
        $totalGirls = $this->reportIBL->sum('sum_girls');
        $totalBaduta = $totalBoys + $totalGirls;

        $sheet->setCellValue('A' . $currentRow, 'Jumlah');
        $sheet->setCellValue('B' . $currentRow, $totalBoys);
        $sheet->setCellValue('C' . $currentRow, $totalGirls);
        $sheet->setCellValue('D' . $currentRow, $totalBaduta);
        $sheet->setCellValue('E' . $currentRow, $this->reportIBL->sum($boysField));
        $sheet->setCellValue('F' . $currentRow, $this->reportIBL->sum($girlsField));
        $sheet->setCellValue('G' . $currentRow, $this->reportIBL->sum($totalField));
        $sheet->setCellValue('H' . $currentRow, $totalBaduta > 0 ? number_format(($this->reportIBL->sum($totalField) / $totalBaduta) * 100, 2) : 0);

        $sheet->getStyle('A' . $currentRow . ':H' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $startDataRow . ':H' . $currentRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        $currentRow += 3;
    }
}
