<?php

namespace App\Exports;

use App\Models\VaccineOut;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class VaccineOutExport
{
    protected $startDate;
    protected $endDate;
    protected $vaccineId;
    protected $vaccineOuts;
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
        $query = VaccineOut::with('vaccine.category')
            ->whereBetween('date_out', [$this->startDate, $this->endDate]);

        if ($this->vaccineId) {
            $query->where('id_vaccine', $this->vaccineId);
        }

        $this->vaccineOuts = $query->orderBy('date_out', 'desc')->get();

        $this->summary = [
            'total_quantity' => $this->vaccineOuts->sum('quantity'),
            'total_value' => $this->vaccineOuts->sum(function ($item) {
                return $item->quantity * ($item->vaccine ? $item->vaccine->price : 0);
            }),
            'total_transactions' => $this->vaccineOuts->count()
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
        $sheet->setCellValue('A' . $currentRow, 'LAPORAN PENGELUARAN VAKSIN');
        $sheet->mergeCells('A' . $currentRow . ':H' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow++;

        $sheet->setCellValue('A' . $currentRow, 'PUSKESMAS GIRI MULYA');
        $sheet->mergeCells('A' . $currentRow . ':H' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow++;

        $sheet->setCellValue('A' . $currentRow, 'PERIODE ' . date('j F Y', strtotime($this->startDate)) . ' s.d ' . date('j F Y', strtotime($this->endDate)));
        $sheet->mergeCells('A' . $currentRow . ':H' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow += 2;

        // Headers - Row 1
        $sheet->setCellValue('A' . $currentRow, 'No');
        $sheet->setCellValue('B' . $currentRow, 'Tanggal');
        $sheet->setCellValue('C' . $currentRow, 'Nama Vaksin');
        $sheet->setCellValue('D' . $currentRow, 'Kategori');
        $sheet->setCellValue('E' . $currentRow, 'Batch');
        $sheet->setCellValue('F' . $currentRow, 'Pengeluaran');
        $sheet->mergeCells('F' . $currentRow . ':G' . $currentRow);
        $sheet->setCellValue('H' . $currentRow, 'Keterangan');

        // Merge cells for main headers
        $sheet->mergeCells('A' . $currentRow . ':A' . ($currentRow + 1));
        $sheet->mergeCells('B' . $currentRow . ':B' . ($currentRow + 1));
        $sheet->mergeCells('C' . $currentRow . ':C' . ($currentRow + 1));
        $sheet->mergeCells('D' . $currentRow . ':D' . ($currentRow + 1));
        $sheet->mergeCells('E' . $currentRow . ':E' . ($currentRow + 1));
        $sheet->mergeCells('H' . $currentRow . ':H' . ($currentRow + 1));

        $currentRow++;

        // Headers - Row 2 (Sub-headers for Pengeluaran)
        $sheet->setCellValue('F' . $currentRow, 'Jumlah');
        $sheet->setCellValue('G' . $currentRow, 'Nilai (Rp)');

        $sheet->getStyle('A' . ($currentRow - 1) . ':H' . $currentRow)->applyFromArray($headerStyle);
        $currentRow++;

        $startDataRow = $currentRow;
        $no = 1;

        // Data
        foreach ($this->vaccineOuts as $vaccineOut) {
            $sheet->setCellValue('A' . $currentRow, $no++);
            $sheet->setCellValue('B' . $currentRow, date('d/m/Y', strtotime($vaccineOut->date_out)));
            $sheet->setCellValue('C' . $currentRow, $vaccineOut->vaccine->vaccine_name ?? '-');
            $sheet->setCellValue('D' . $currentRow, $vaccineOut->vaccine->category->name ?? '-');
            $sheet->setCellValue('E' . $currentRow, $vaccineOut->vaccine->batch_number ?? '-');
            $sheet->setCellValue('F' . $currentRow, $vaccineOut->quantity);
            $vaccinePrice = $vaccineOut->vaccine ? $vaccineOut->vaccine->price : 0;
            $sheet->setCellValue('G' . $currentRow, number_format($vaccineOut->quantity * $vaccinePrice, 0, ',', '.'));
            $sheet->setCellValue('H' . $currentRow, $vaccineOut->notes ?? '-');

            // Align right for numeric columns
            $sheet->getStyle('G' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('C' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('H' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $currentRow++;
        }

        // Total row
        $sheet->setCellValue('A' . $currentRow, 'TOTAL');
        $sheet->mergeCells('A' . $currentRow . ':E' . $currentRow);
        $sheet->setCellValue('F' . $currentRow, $this->summary['total_quantity']);
        $sheet->setCellValue('G' . $currentRow, number_format($this->summary['total_value'], 0, ',', '.'));
        $sheet->setCellValue('H' . $currentRow, '');

        $sheet->getStyle('A' . $currentRow . ':H' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('G' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('A' . $startDataRow . ':H' . $currentRow)->applyFromArray([
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
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Download
        $filename = 'Laporan_Pengeluaran_Vaksin_' . date('Y-m-d', strtotime($this->startDate)) . '_to_' . date('Y-m-d', strtotime($this->endDate)) . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
