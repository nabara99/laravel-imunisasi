<?php

namespace App\Exports;

use App\Models\Vaccine;
use App\Models\VaccineIn;
use App\Models\VaccineOut;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class VaccineStockExport
{
    protected $startDate;
    protected $endDate;
    protected $vaccineId;
    protected $vaccines;

    public function __construct($startDate, $endDate, $vaccineId = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->vaccineId = $vaccineId;
        $this->fetchData();
    }

    protected function fetchData()
    {
        $query = Vaccine::with('category');

        if ($this->vaccineId) {
            $query->where('id', $this->vaccineId);
        }

        $this->vaccines = $query->get()->map(function ($vaccine) {
            // Hitung total masuk dalam periode
            $totalIn = VaccineIn::where('vaccine_name', $vaccine->vaccine_name)
                ->where('batch_number', $vaccine->batch_number)
                ->whereBetween('date_in', [$this->startDate, $this->endDate])
                ->sum('stock');

            // Hitung total keluar dalam periode
            $totalOut = VaccineOut::where('id_vaccine', $vaccine->id)
                ->whereBetween('date_out', [$this->startDate, $this->endDate])
                ->sum('quantity');

            $vaccine->total_in = $totalIn;
            $vaccine->total_out = $totalOut;
            $vaccine->current_stock = $vaccine->stock;

            return $vaccine;
        });
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
        $sheet->setCellValue('A' . $currentRow, 'LAPORAN STOK VAKSIN');
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
        $sheet->setCellValue('B' . $currentRow, 'Nama Vaksin');
        $sheet->setCellValue('C' . $currentRow, 'Kategori');
        $sheet->setCellValue('D' . $currentRow, 'Batch');
        $sheet->setCellValue('E' . $currentRow, 'Expired');
        $sheet->setCellValue('F' . $currentRow, 'Harga (Rp)');
        $sheet->setCellValue('G' . $currentRow, 'Periode');
        $sheet->mergeCells('G' . $currentRow . ':H' . $currentRow);
        $sheet->setCellValue('I' . $currentRow, 'Stok Saat Ini');
        $sheet->setCellValue('J' . $currentRow, 'Status');

        // Merge cells for main headers
        $sheet->mergeCells('A' . $currentRow . ':A' . ($currentRow + 1));
        $sheet->mergeCells('B' . $currentRow . ':B' . ($currentRow + 1));
        $sheet->mergeCells('C' . $currentRow . ':C' . ($currentRow + 1));
        $sheet->mergeCells('D' . $currentRow . ':D' . ($currentRow + 1));
        $sheet->mergeCells('E' . $currentRow . ':E' . ($currentRow + 1));
        $sheet->mergeCells('F' . $currentRow . ':F' . ($currentRow + 1));
        $sheet->mergeCells('I' . $currentRow . ':I' . ($currentRow + 1));
        $sheet->mergeCells('J' . $currentRow . ':J' . ($currentRow + 1));

        $currentRow++;

        // Headers - Row 2 (Sub-headers for Periode)
        $sheet->setCellValue('G' . $currentRow, 'Masuk');
        $sheet->setCellValue('H' . $currentRow, 'Keluar');

        $sheet->getStyle('A' . ($currentRow - 1) . ':J' . $currentRow)->applyFromArray($headerStyle);
        $currentRow++;

        $startDataRow = $currentRow;
        $no = 1;
        $totalStockValue = 0;

        // Data
        foreach ($this->vaccines as $vaccine) {
            // Determine status
            $isExpired = strtotime($vaccine->expired_date) < time();
            $daysUntilExpiry = (strtotime($vaccine->expired_date) - time()) / (60 * 60 * 24);
            $isExpiringSoon = $daysUntilExpiry <= 30 && !$isExpired;

            if ($isExpired) {
                $status = 'Kadaluarsa';
            } elseif ($isExpiringSoon) {
                $status = 'Segera Kadaluarsa';
            } elseif ($vaccine->stock == 0) {
                $status = 'Habis';
            } else {
                $status = 'Tersedia';
            }

            $stockValue = $vaccine->stock * $vaccine->price;
            $totalStockValue += $stockValue;

            $sheet->setCellValue('A' . $currentRow, $no++);
            $sheet->setCellValue('B' . $currentRow, $vaccine->vaccine_name);
            $sheet->setCellValue('C' . $currentRow, $vaccine->category->name ?? '-');
            $sheet->setCellValue('D' . $currentRow, $vaccine->batch_number);
            $sheet->setCellValue('E' . $currentRow, date('d/m/Y', strtotime($vaccine->expired_date)));
            $sheet->setCellValue('F' . $currentRow, number_format($vaccine->price, 0, ',', '.'));
            $sheet->setCellValue('G' . $currentRow, $vaccine->total_in);
            $sheet->setCellValue('H' . $currentRow, $vaccine->total_out);
            $sheet->setCellValue('I' . $currentRow, $vaccine->current_stock);
            $sheet->setCellValue('J' . $currentRow, $status);

            // Align right for numeric columns
            $sheet->getStyle('F' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $currentRow++;
        }

        // Total row
        $totalIn = $this->vaccines->sum('total_in');
        $totalOut = $this->vaccines->sum('total_out');
        $totalStock = $this->vaccines->sum('current_stock');

        $sheet->setCellValue('A' . $currentRow, 'TOTAL');
        $sheet->mergeCells('A' . $currentRow . ':F' . $currentRow);
        $sheet->setCellValue('G' . $currentRow, $totalIn);
        $sheet->setCellValue('H' . $currentRow, $totalOut);
        $sheet->setCellValue('I' . $currentRow, $totalStock);
        $sheet->setCellValue('J' . $currentRow, '');

        $sheet->getStyle('A' . $currentRow . ':J' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $startDataRow . ':J' . $currentRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        $currentRow += 2;

        // Summary information
        $sheet->setCellValue('A' . $currentRow, 'Total Jenis Vaksin: ' . $this->vaccines->count() . ' jenis');
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $currentRow++;

        $sheet->setCellValue('A' . $currentRow, 'Total Stok: ' . number_format($totalStock) . ' unit');
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $currentRow++;

        $sheet->setCellValue('A' . $currentRow, 'Total Nilai Stok: Rp ' . number_format($totalStockValue));
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $currentRow++;

        $sheet->setCellValue('A' . $currentRow, 'Periode Transaksi Masuk: ' . number_format($totalIn) . ' unit');
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $currentRow++;

        $sheet->setCellValue('A' . $currentRow, 'Periode Transaksi Keluar: ' . number_format($totalOut) . ' unit');
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);

        // Auto size columns
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Download
        $filename = 'Laporan_Stok_Vaksin_' . date('Y-m-d', strtotime($this->startDate)) . '_to_' . date('Y-m-d', strtotime($this->endDate)) . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
