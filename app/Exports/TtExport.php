<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TtExport
{
    protected $startDate;
    protected $endDate;
    protected $reportTT;

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

        $this->reportTT = DB::table('wus_imuns')
            ->join('wuses', 'wus_imuns.id_wus', '=', 'wuses.id')
            ->join('villages', 'wuses.id_village', '=', 'villages.id')
            ->join('mother_targets', function($join) use ($startYear, $endYear) {
                $join->on('villages.id', '=', 'mother_targets.village_id')
                     ->whereBetween('mother_targets.year', [$startYear, $endYear]);
            })
            ->select(
                'villages.name as village_name',
                'mother_targets.no_pregnant',
                'mother_targets.pregnant',
            )
            ->addSelect([
                DB::raw("COUNT(CASE WHEN wus_imuns.t1 BETWEEN ? AND ? AND wus_imuns.t1_status = '1' THEN 1 END) AS t1_pregnant"),
                DB::raw("COUNT(CASE WHEN wus_imuns.t1 BETWEEN ? AND ? AND wus_imuns.t1_status = '0' THEN 1 END) AS t1_no_pregnant"),
                DB::raw("COUNT(CASE WHEN wus_imuns.t2 BETWEEN ? AND ? AND wus_imuns.t2_status = '1' THEN 1 END) AS t2_pregnant"),
                DB::raw("COUNT(CASE WHEN wus_imuns.t2 BETWEEN ? AND ? AND wus_imuns.t2_status = '0' THEN 1 END) AS t2_no_pregnant"),
                DB::raw("COUNT(CASE WHEN wus_imuns.t3 BETWEEN ? AND ? AND wus_imuns.t3_status = '1' THEN 1 END) AS t3_pregnant"),
                DB::raw("COUNT(CASE WHEN wus_imuns.t3 BETWEEN ? AND ? AND wus_imuns.t3_status = '0' THEN 1 END) AS t3_no_pregnant"),
                DB::raw("COUNT(CASE WHEN wus_imuns.t4 BETWEEN ? AND ? AND wus_imuns.t4_status = '1' THEN 1 END) AS t4_pregnant"),
                DB::raw("COUNT(CASE WHEN wus_imuns.t4 BETWEEN ? AND ? AND wus_imuns.t4_status = '0' THEN 1 END) AS t4_no_pregnant"),
                DB::raw("COUNT(CASE WHEN wus_imuns.t5 BETWEEN ? AND ? AND wus_imuns.t5_status = '1' THEN 1 END) AS t5_pregnant"),
                DB::raw("COUNT(CASE WHEN wus_imuns.t5 BETWEEN ? AND ? AND wus_imuns.t5_status = '0' THEN 1 END) AS t5_no_pregnant")
            ])
            ->groupBy('villages.id', 'villages.name', 'mother_targets.no_pregnant', 'mother_targets.pregnant')
            ->orderBy('villages.id')
            ->setBindings(array_fill(0, 10, [$this->startDate, $this->endDate]))
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

        // Sheet 1: TT BUMIL
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('TT BUMIL');
        $this->buildBumilSheet($sheet, $headerStyle);

        // Sheet 2: TT WUS
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('TT WUS');
        $this->buildWusSheet($sheet2, $headerStyle);

        // Download
        $filename = 'Laporan_WUS_BUMIL_' . date('Y-m-d', strtotime($this->startDate)) . '_to_' . date('Y-m-d', strtotime($this->endDate)) . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    protected function buildBumilSheet($sheet, $headerStyle)
    {
        // Header
        $sheet->setCellValue('A1', 'REKAP TT BUMIL PUSKESMAS GIRI MULYA');
        $sheet->mergeCells('A1:N1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'PERIODE ' . date('j F Y', strtotime($this->startDate)) . ' s.d ' . date('j F Y', strtotime($this->endDate)));
        $sheet->mergeCells('A2:N2');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Table header
        $sheet->setCellValue('A4', 'Desa');
        $sheet->setCellValue('B4', 'Sasaran TT BUMIL');
        $sheet->setCellValue('C4', 'TT1');
        $sheet->setCellValue('D4', '%');
        $sheet->setCellValue('E4', 'TT2');
        $sheet->setCellValue('F4', '%');
        $sheet->setCellValue('G4', 'TT3');
        $sheet->setCellValue('H4', '%');
        $sheet->setCellValue('I4', 'TT4');
        $sheet->setCellValue('J4', '%');
        $sheet->setCellValue('K4', 'TT5');
        $sheet->setCellValue('L4', '%');
        $sheet->setCellValue('M4', 'T2+');
        $sheet->setCellValue('N4', '%');
        $sheet->getStyle('A4:N4')->applyFromArray($headerStyle);

        // Data
        $row = 5;
        foreach ($this->reportTT as $report) {
            $t2Plus = $report->t2_pregnant + $report->t3_pregnant + $report->t4_pregnant + $report->t5_pregnant;
            $percentT1 = $report->pregnant > 0 ? ($report->t1_pregnant / $report->pregnant) * 100 : 0;
            $percentT2 = $report->pregnant > 0 ? ($report->t2_pregnant / $report->pregnant) * 100 : 0;
            $percentT3 = $report->pregnant > 0 ? ($report->t3_pregnant / $report->pregnant) * 100 : 0;
            $percentT4 = $report->pregnant > 0 ? ($report->t4_pregnant / $report->pregnant) * 100 : 0;
            $percentT5 = $report->pregnant > 0 ? ($report->t5_pregnant / $report->pregnant) * 100 : 0;
            $percentT2Plus = $report->pregnant > 0 ? ($t2Plus / $report->pregnant) * 100 : 0;

            $sheet->setCellValue('A' . $row, $report->village_name);
            $sheet->setCellValue('B' . $row, $report->pregnant);
            $sheet->setCellValue('C' . $row, $report->t1_pregnant);
            $sheet->setCellValue('D' . $row, number_format($percentT1, 2));
            $sheet->setCellValue('E' . $row, $report->t2_pregnant);
            $sheet->setCellValue('F' . $row, number_format($percentT2, 2));
            $sheet->setCellValue('G' . $row, $report->t3_pregnant);
            $sheet->setCellValue('H' . $row, number_format($percentT3, 2));
            $sheet->setCellValue('I' . $row, $report->t4_pregnant);
            $sheet->setCellValue('J' . $row, number_format($percentT4, 2));
            $sheet->setCellValue('K' . $row, $report->t5_pregnant);
            $sheet->setCellValue('L' . $row, number_format($percentT5, 2));
            $sheet->setCellValue('M' . $row, $t2Plus);
            $sheet->setCellValue('N' . $row, number_format($percentT2Plus, 2));
            $row++;
        }

        // Total row
        $totalPregnant = $this->reportTT->sum('pregnant');
        $totalT2Plus = $this->reportTT->sum('t2_pregnant') + $this->reportTT->sum('t3_pregnant') + $this->reportTT->sum('t4_pregnant') + $this->reportTT->sum('t5_pregnant');
        $totalPercentT1 = $totalPregnant > 0 ? ($this->reportTT->sum('t1_pregnant') / $totalPregnant) * 100 : 0;
        $totalPercentT2 = $totalPregnant > 0 ? ($this->reportTT->sum('t2_pregnant') / $totalPregnant) * 100 : 0;
        $totalPercentT3 = $totalPregnant > 0 ? ($this->reportTT->sum('t3_pregnant') / $totalPregnant) * 100 : 0;
        $totalPercentT4 = $totalPregnant > 0 ? ($this->reportTT->sum('t4_pregnant') / $totalPregnant) * 100 : 0;
        $totalPercentT5 = $totalPregnant > 0 ? ($this->reportTT->sum('t5_pregnant') / $totalPregnant) * 100 : 0;
        $totalPercentT2Plus = $totalPregnant > 0 ? ($totalT2Plus / $totalPregnant) * 100 : 0;

        $sheet->setCellValue('A' . $row, 'Jumlah');
        $sheet->setCellValue('B' . $row, $totalPregnant);
        $sheet->setCellValue('C' . $row, $this->reportTT->sum('t1_pregnant'));
        $sheet->setCellValue('D' . $row, number_format($totalPercentT1, 2));
        $sheet->setCellValue('E' . $row, $this->reportTT->sum('t2_pregnant'));
        $sheet->setCellValue('F' . $row, number_format($totalPercentT2, 2));
        $sheet->setCellValue('G' . $row, $this->reportTT->sum('t3_pregnant'));
        $sheet->setCellValue('H' . $row, number_format($totalPercentT3, 2));
        $sheet->setCellValue('I' . $row, $this->reportTT->sum('t4_pregnant'));
        $sheet->setCellValue('J' . $row, number_format($totalPercentT4, 2));
        $sheet->setCellValue('K' . $row, $this->reportTT->sum('t5_pregnant'));
        $sheet->setCellValue('L' . $row, number_format($totalPercentT5, 2));
        $sheet->setCellValue('M' . $row, $totalT2Plus);
        $sheet->setCellValue('N' . $row, number_format($totalPercentT2Plus, 2));
        $sheet->getStyle('A' . $row . ':N' . $row)->getFont()->setBold(true);

        $sheet->getStyle('A5:N' . $row)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);
        $sheet->getStyle('A5:N' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        foreach (range('A', 'N') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    protected function buildWusSheet($sheet, $headerStyle)
    {
        // Header
        $sheet->setCellValue('A1', 'REKAP TT WUS PUSKESMAS GIRI MULYA');
        $sheet->mergeCells('A1:N1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'PERIODE ' . date('j F Y', strtotime($this->startDate)) . ' s.d ' . date('j F Y', strtotime($this->endDate)));
        $sheet->mergeCells('A2:N2');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Table header
        $sheet->setCellValue('A4', 'Desa');
        $sheet->setCellValue('B4', 'Sasaran WUS');
        $sheet->setCellValue('C4', 'TT1');
        $sheet->setCellValue('D4', '%');
        $sheet->setCellValue('E4', 'TT2');
        $sheet->setCellValue('F4', '%');
        $sheet->setCellValue('G4', 'TT3');
        $sheet->setCellValue('H4', '%');
        $sheet->setCellValue('I4', 'TT4');
        $sheet->setCellValue('J4', '%');
        $sheet->setCellValue('K4', 'TT5');
        $sheet->setCellValue('L4', '%');
        $sheet->setCellValue('M4', 'T2+');
        $sheet->setCellValue('N4', '%');
        $sheet->getStyle('A4:N4')->applyFromArray($headerStyle);

        // Data
        $row = 5;
        foreach ($this->reportTT as $report) {
            $t2Plus = $report->t2_no_pregnant + $report->t3_no_pregnant + $report->t4_no_pregnant + $report->t5_no_pregnant;
            $percentT1 = $report->no_pregnant > 0 ? ($report->t1_no_pregnant / $report->no_pregnant) * 100 : 0;
            $percentT2 = $report->no_pregnant > 0 ? ($report->t2_no_pregnant / $report->no_pregnant) * 100 : 0;
            $percentT3 = $report->no_pregnant > 0 ? ($report->t3_no_pregnant / $report->no_pregnant) * 100 : 0;
            $percentT4 = $report->no_pregnant > 0 ? ($report->t4_no_pregnant / $report->no_pregnant) * 100 : 0;
            $percentT5 = $report->no_pregnant > 0 ? ($report->t5_no_pregnant / $report->no_pregnant) * 100 : 0;
            $percentT2Plus = $report->no_pregnant > 0 ? ($t2Plus / $report->no_pregnant) * 100 : 0;

            $sheet->setCellValue('A' . $row, $report->village_name);
            $sheet->setCellValue('B' . $row, $report->no_pregnant);
            $sheet->setCellValue('C' . $row, $report->t1_no_pregnant);
            $sheet->setCellValue('D' . $row, number_format($percentT1, 2));
            $sheet->setCellValue('E' . $row, $report->t2_no_pregnant);
            $sheet->setCellValue('F' . $row, number_format($percentT2, 2));
            $sheet->setCellValue('G' . $row, $report->t3_no_pregnant);
            $sheet->setCellValue('H' . $row, number_format($percentT3, 2));
            $sheet->setCellValue('I' . $row, $report->t4_no_pregnant);
            $sheet->setCellValue('J' . $row, number_format($percentT4, 2));
            $sheet->setCellValue('K' . $row, $report->t5_no_pregnant);
            $sheet->setCellValue('L' . $row, number_format($percentT5, 2));
            $sheet->setCellValue('M' . $row, $t2Plus);
            $sheet->setCellValue('N' . $row, number_format($percentT2Plus, 2));
            $row++;
        }

        // Total row
        $totalNoPregnant = $this->reportTT->sum('no_pregnant');
        $totalT2PlusWus = $this->reportTT->sum('t2_no_pregnant') + $this->reportTT->sum('t3_no_pregnant') + $this->reportTT->sum('t4_no_pregnant') + $this->reportTT->sum('t5_no_pregnant');
        $totalPercentT1Wus = $totalNoPregnant > 0 ? ($this->reportTT->sum('t1_no_pregnant') / $totalNoPregnant) * 100 : 0;
        $totalPercentT2Wus = $totalNoPregnant > 0 ? ($this->reportTT->sum('t2_no_pregnant') / $totalNoPregnant) * 100 : 0;
        $totalPercentT3Wus = $totalNoPregnant > 0 ? ($this->reportTT->sum('t3_no_pregnant') / $totalNoPregnant) * 100 : 0;
        $totalPercentT4Wus = $totalNoPregnant > 0 ? ($this->reportTT->sum('t4_no_pregnant') / $totalNoPregnant) * 100 : 0;
        $totalPercentT5Wus = $totalNoPregnant > 0 ? ($this->reportTT->sum('t5_no_pregnant') / $totalNoPregnant) * 100 : 0;
        $totalPercentT2PlusWus = $totalNoPregnant > 0 ? ($totalT2PlusWus / $totalNoPregnant) * 100 : 0;

        $sheet->setCellValue('A' . $row, 'Jumlah');
        $sheet->setCellValue('B' . $row, $totalNoPregnant);
        $sheet->setCellValue('C' . $row, $this->reportTT->sum('t1_no_pregnant'));
        $sheet->setCellValue('D' . $row, number_format($totalPercentT1Wus, 2));
        $sheet->setCellValue('E' . $row, $this->reportTT->sum('t2_no_pregnant'));
        $sheet->setCellValue('F' . $row, number_format($totalPercentT2Wus, 2));
        $sheet->setCellValue('G' . $row, $this->reportTT->sum('t3_no_pregnant'));
        $sheet->setCellValue('H' . $row, number_format($totalPercentT3Wus, 2));
        $sheet->setCellValue('I' . $row, $this->reportTT->sum('t4_no_pregnant'));
        $sheet->setCellValue('J' . $row, number_format($totalPercentT4Wus, 2));
        $sheet->setCellValue('K' . $row, $this->reportTT->sum('t5_no_pregnant'));
        $sheet->setCellValue('L' . $row, number_format($totalPercentT5Wus, 2));
        $sheet->setCellValue('M' . $row, $totalT2PlusWus);
        $sheet->setCellValue('N' . $row, number_format($totalPercentT2PlusWus, 2));
        $sheet->getStyle('A' . $row . ':N' . $row)->getFont()->setBold(true);

        $sheet->getStyle('A5:N' . $row)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);
        $sheet->getStyle('A5:N' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        foreach (range('A', 'N') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}
