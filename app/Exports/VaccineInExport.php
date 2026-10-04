<?php

namespace App\Exports;

use App\Models\VaccineIn;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class VaccineInExport
{
    protected $startDate;
    protected $endDate;
    protected $vaccineId;
    protected $vaccineIns;
    protected $summary;

    public function __construct($startDate, $endDate, $vaccineId = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->vaccineId = $vaccineId;
        $this->fetchData();
    }

    protected function fetchData()
    {
        $query = VaccineIn::with('category')
            ->whereBetween('date_in', [$this->startDate, $this->endDate]);

        if ($this->vaccineId) {
            $query->where('id', $this->vaccineId);
        }

        $this->vaccineIns = $query->orderBy('date_in', 'desc')->get();

        $this->summary = [
            'total_quantity' => $this->vaccineIns->sum('stock'),
            'total_value' => $this->vaccineIns->sum(function ($item) {
                return $item->stock * $item->price;
            }),
            'total_transactions' => $this->vaccineIns->count()
        ];
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

        // Title
        $sheet->setCellValue('A' . $currentRow, 'LAPORAN PENERIMAAN VAKSIN');
        $sheet->mergeCells('A' . $currentRow . ':J' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow++;

        $sheet->setCellValue('A' . $currentRow, 'PUSKESMAS GIRI MULYA');
        $sheet->mergeCells('A' . $currentRow . ':J' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow++;

        $sheet->setCellValue('A' . $currentRow, 'PERIODE ' . date('j F Y', strtotime($this->startDate)) . ' s.d ' . date('j F Y', strtotime($this->endDate)));
        $sheet->mergeCells('A' . $currentRow . ':J' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow += 2;

        // Headers - Row 1
        $sheet->setCellValue('A' . $currentRow, 'No');
        $sheet->setCellValue('B' . $currentRow, 'Tanggal');
        $sheet->setCellValue('C' . $currentRow, 'Nama Vaksin');
        $sheet->setCellValue('D' . $currentRow, 'Kategori');
        $sheet->setCellValue('E' . $currentRow, 'Batch');
        $sheet->setCellValue('F' . $currentRow, 'VVM');
        $sheet->setCellValue('G' . $currentRow, 'Expired');
        $sheet->setCellValue('H' . $currentRow, 'Penerimaan');
        $sheet->mergeCells('H' . $currentRow . ':I' . $currentRow);
        $sheet->setCellValue('J' . $currentRow, 'Keterangan');

        // Merge cells for main headers
        $sheet->mergeCells('A' . $currentRow . ':A' . ($currentRow + 1));
        $sheet->mergeCells('B' . $currentRow . ':B' . ($currentRow + 1));
        $sheet->mergeCells('C' . $currentRow . ':C' . ($currentRow + 1));
        $sheet->mergeCells('D' . $currentRow . ':D' . ($currentRow + 1));
        $sheet->mergeCells('E' . $currentRow . ':E' . ($currentRow + 1));
        $sheet->mergeCells('F' . $currentRow . ':F' . ($currentRow + 1));
        $sheet->mergeCells('G' . $currentRow . ':G' . ($currentRow + 1));
        $sheet->mergeCells('J' . $currentRow . ':J' . ($currentRow + 1));

        $currentRow++;

        // Headers - Row 2 (Sub-headers for Penerimaan)
        $sheet->setCellValue('H' . $currentRow, 'Jumlah');
        $sheet->setCellValue('I' . $currentRow, 'Nilai (Rp)');

        $sheet->getStyle('A' . ($currentRow - 1) . ':J' . $currentRow)->applyFromArray($headerStyle);
        $currentRow++;

        $startDataRow = $currentRow;
        $no = 1;

        // Data
        foreach ($this->vaccineIns as $vaccineIn) {
            $sheet->setCellValue('A' . $currentRow, $no++);
            $sheet->setCellValue('B' . $currentRow, date('d/m/Y', strtotime($vaccineIn->date_in)));
            $sheet->setCellValue('C' . $currentRow, $vaccineIn->vaccine_name);
            $sheet->setCellValue('D' . $currentRow, $vaccineIn->category->name ?? '-');
            $sheet->setCellValue('E' . $currentRow, $vaccineIn->batch_number);
            $sheet->setCellValue('F' . $currentRow, $vaccineIn->vvm ?? '-');
            $sheet->getStyle('F' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('G' . $currentRow, date('d/m/Y', strtotime($vaccineIn->expired_date)));
            $sheet->setCellValue('H' . $currentRow, $vaccineIn->stock);
            $sheet->setCellValue('I' . $currentRow, number_format($vaccineIn->stock * $vaccineIn->price, 0, ',', '.'));
            $sheet->setCellValue('J' . $currentRow, $vaccineIn->notes ?? '-');

            // Align right for numeric columns
            $sheet->getStyle('I' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('C' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('J' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $currentRow++;
        }

        // Total row
        $sheet->setCellValue('A' . $currentRow, 'TOTAL');
        $sheet->mergeCells('A' . $currentRow . ':G' . $currentRow);
        $sheet->setCellValue('H' . $currentRow, $this->summary['total_quantity']);
        $sheet->setCellValue('I' . $currentRow, number_format($this->summary['total_value'], 0, ',', '.'));
        $sheet->setCellValue('J' . $currentRow, '');

        $sheet->getStyle('A' . $currentRow . ':J' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('I' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('A' . $startDataRow . ':J' . $currentRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        $currentRow += 2;

        // Summary information
        $sheet->setCellValue('A' . $currentRow, 'Total Transaksi: ' . $this->summary['total_transactions'] . ' transaksi');
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $currentRow++;

        $sheet->setCellValue('A' . $currentRow, 'Total Jumlah: ' . number_format($this->summary['total_quantity']) . ' unit');
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $currentRow++;

        $sheet->setCellValue('A' . $currentRow, 'Total Nilai: Rp ' . number_format($this->summary['total_value']));
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);

        // Auto size columns
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Download
        $filename = 'Laporan_Penerimaan_Vaksin_' . date('Y-m-d', strtotime($this->startDate)) . '_to_' . date('Y-m-d', strtotime($this->endDate)) . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
