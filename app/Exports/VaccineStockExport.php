<?php

namespace App\Exports;

use App\Services\VaccineStockReport;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
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
        $this->vaccines = app(VaccineStockReport::class)->get($this->startDate, $this->endDate, $this->vaccineId);
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
        $sheet->mergeCells('A' . $currentRow . ':L' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow++;

        $sheet->setCellValue('A' . $currentRow, 'PUSKESMAS GIRI MULYA');
        $sheet->mergeCells('A' . $currentRow . ':L' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow++;

        $sheet->setCellValue('A' . $currentRow, 'PERIODE ' . date('j F Y', strtotime($this->startDate)) . ' s.d ' . date('j F Y', strtotime($this->endDate)));
        $sheet->mergeCells('A' . $currentRow . ':L' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $currentRow += 2;

        // Headers - Row 1
        $sheet->setCellValue('A' . $currentRow, 'No');
        $sheet->setCellValue('B' . $currentRow, 'Nama Vaksin');
        $sheet->setCellValue('C' . $currentRow, 'Kategori');
        $sheet->setCellValue('D' . $currentRow, 'Batch');
        $sheet->setCellValue('E' . $currentRow, 'VVM');
        $sheet->setCellValue('F' . $currentRow, 'Expired');
        $sheet->setCellValue('G' . $currentRow, 'Harga (Rp)');
        $sheet->setCellValue('H' . $currentRow, 'Stok Awal');
        $sheet->setCellValue('I' . $currentRow, 'Periode');
        $sheet->mergeCells('I' . $currentRow . ':J' . $currentRow);
        $sheet->setCellValue('K' . $currentRow, 'Stok Saat Ini');
        $sheet->setCellValue('L' . $currentRow, 'Status');

        // Merge cells for main headers
        $sheet->mergeCells('A' . $currentRow . ':A' . ($currentRow + 1));
        $sheet->mergeCells('B' . $currentRow . ':B' . ($currentRow + 1));
        $sheet->mergeCells('C' . $currentRow . ':C' . ($currentRow + 1));
        $sheet->mergeCells('D' . $currentRow . ':D' . ($currentRow + 1));
        $sheet->mergeCells('E' . $currentRow . ':E' . ($currentRow + 1));
        $sheet->mergeCells('F' . $currentRow . ':F' . ($currentRow + 1));
        $sheet->mergeCells('G' . $currentRow . ':G' . ($currentRow + 1));
        $sheet->mergeCells('H' . $currentRow . ':H' . ($currentRow + 1));
        $sheet->mergeCells('K' . $currentRow . ':K' . ($currentRow + 1));
        $sheet->mergeCells('L' . $currentRow . ':L' . ($currentRow + 1));

        $currentRow++;

        // Headers - Row 2 (Sub-headers for Periode)
        $sheet->setCellValue('I' . $currentRow, 'Masuk');
        $sheet->setCellValue('J' . $currentRow, 'Keluar');

        $sheet->getStyle('A' . ($currentRow - 1) . ':L' . $currentRow)->applyFromArray($headerStyle);
        $currentRow++;

        $startDataRow = $currentRow;
        $no = 1;
        $totalStockValue = 0;

        // Data
        foreach ($this->vaccines as $vaccine) {
            $stockValue = $vaccine->stock * $vaccine->price;
            $totalStockValue += $stockValue;

            $sheet->setCellValue('A' . $currentRow, $no++);
            $sheet->setCellValue('B' . $currentRow, $vaccine->vaccine_name);
            $sheet->setCellValue('C' . $currentRow, $vaccine->category->name ?? '-');
            $sheet->setCellValueExplicit('D' . $currentRow, $vaccine->batch_number, DataType::TYPE_STRING);
            $sheet->setCellValue('E' . $currentRow, $vaccine->vvm ?? '-');
            $sheet->getStyle('E' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('F' . $currentRow, date('d/m/Y', strtotime($vaccine->expired_date)));
            $sheet->setCellValue('G' . $currentRow, number_format($vaccine->price, 0, ',', '.'));
            $sheet->setCellValue('H' . $currentRow, $vaccine->opening_stock);
            $sheet->setCellValue('I' . $currentRow, $vaccine->total_in);
            $sheet->setCellValue('J' . $currentRow, $vaccine->total_out);
            $sheet->setCellValue('K' . $currentRow, $vaccine->current_stock);
            $sheet->setCellValue('L' . $currentRow, $vaccine->stock_status);

            // Align right for numeric columns
            $sheet->getStyle('G' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $currentRow++;
        }

        // Total row
        $totalIn = $this->vaccines->sum('total_in');
        $totalOut = $this->vaccines->sum('total_out');
        $totalStock = $this->vaccines->sum('current_stock');

        $sheet->setCellValue('A' . $currentRow, 'TOTAL');
        $sheet->mergeCells('A' . $currentRow . ':G' . $currentRow);
        $sheet->setCellValue('H' . $currentRow, $this->vaccines->sum('opening_stock'));
        $sheet->setCellValue('I' . $currentRow, $totalIn);
        $sheet->setCellValue('J' . $currentRow, $totalOut);
        $sheet->setCellValue('K' . $currentRow, $totalStock);
        $sheet->setCellValue('L' . $currentRow, '');

        $sheet->getStyle('A' . $currentRow . ':L' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $startDataRow . ':L' . $currentRow)->applyFromArray([
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
        $currentRow++;

        $sheet->setCellValue('A' . $currentRow, 'Stok Awal: ' . number_format($this->vaccines->sum('opening_stock')) . ' unit');
        $currentRow += 2;
        $sheet->setCellValue('A' . $currentRow, 'Stok awal mencakup penerimaan dan pengeluaran sebelum periode. Stok saat ini = stok awal + masuk periode - keluar periode, sampai tanggal akhir periode.');
        $sheet->mergeCells('A' . $currentRow . ':L' . $currentRow);
        $sheet->getStyle('A' . $currentRow)->getAlignment()->setWrapText(true);

        // Auto size columns
        foreach (range('A', 'L') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Download
        $filename = 'Laporan_Stok_Vaksin_' . date('Y-m-d', strtotime($this->startDate)) . '_to_' . date('Y-m-d', strtotime($this->endDate)) . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            (new Xlsx($spreadsheet))->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
