<?php

use App\Exports\VaccineStockExport;
use App\Models\User;
use App\Models\Vaccine;
use App\Models\VaccineCategory;
use App\Models\VaccineIn;
use App\Models\VaccineOut;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->create());
    $this->travelTo(Carbon\Carbon::parse('2026-10-16 12:00:00'));
    $this->category = VaccineCategory::create(['name' => 'Vial']);
    $this->receive = function (int $quantity, array $attributes = []): Vaccine {
        $attributes = array_replace([
            'vaccine_name' => 'HPV',
            'id_category_vaccine' => $this->category->id,
            'batch_number' => '4016424',
            'expired_date' => '2027-06-03',
            'price' => 1000,
            'date_in' => '2026-01-01',
            'stock' => $quantity,
        ], $attributes);
        VaccineIn::create(array_replace($attributes, ['stock' => $quantity, 'vvm' => 'A']));

        return Vaccine::create($attributes);
    };
    $this->issue = fn (Vaccine $vaccine, int $quantity, string $date) => VaccineOut::create([
        'id_vaccine' => $vaccine->id,
        'quantity' => $quantity,
        'date_out' => $date,
        'vvm' => 'A',
    ]);
    $this->stockReport = fn (string $start = '2026-01-01', string $end = '2026-10-16', array $filter = []) => $this
        ->post(route('vaccine-report.stock'), array_merge(['start_date' => $start, 'end_date' => $end], $filter))
        ->assertOk()->viewData('vaccines');
});

it('carries old receipts and issues into the opening balance', function () {
    $vaccine = ($this->receive)(50, ['date_in' => '2025-10-30', 'stock' => 11]);
    ($this->issue)($vaccine, 10, '2025-12-15');
    ($this->issue)($vaccine, 9, '2026-01-01');
    ($this->issue)($vaccine, 20, '2026-10-16');

    $row = ($this->stockReport)()->sole();

    expect($row->opening_stock)->toBe(40)
        ->and($row->total_in)->toBe(0)
        ->and($row->total_out)->toBe(29)
        ->and($row->current_stock)->toBe(11);
});

it('counts each receipt once when the same batch is received repeatedly', function () {
    $first = ($this->receive)(20, ['stock' => 10]);
    $second = ($this->receive)(15, ['stock' => 5, 'date_in' => '2026-02-01']);
    ($this->issue)($first, 10, '2026-01-15');
    ($this->issue)($second, 10, '2026-02-15');

    $rows = ($this->stockReport)();
    $row = $rows->sole();

    expect($row->total_in)->toBe(35)
        ->and($row->total_out)->toBe(20)
        ->and($row->opening_stock)->toBe(0)
        ->and($row->current_stock)->toBe(15);

    $filtered = ($this->stockReport)('2026-01-01', '2026-10-16', ['id_vaccine' => $second->id]);
    expect($filtered->sole()->total_in)->toBe(35)
        ->and($filtered->sole()->total_out)->toBe(20);
});

it('keeps categories prices and expiry dates separate for the same name and batch', function () {
    ($this->receive)(10);
    ($this->receive)(20, ['id_category_vaccine' => VaccineCategory::create(['name' => 'Ampul'])->id]);
    ($this->receive)(30, ['price' => 2000]);
    ($this->receive)(40, ['expired_date' => '2028-01-01']);

    $rows = ($this->stockReport)();

    expect($rows)->toHaveCount(4)
        ->and($rows->pluck('total_in')->sort()->values()->all())->toBe([10, 20, 30, 40])
        ->and($rows->sum('total_in'))->toBe(100)
        ->and($rows->sum('current_stock'))->toBe(100);
});

it('includes receipts without a matching stock row and batches with no remaining stock', function () {
    $exhausted = ($this->receive)(10, ['stock' => 0]);
    ($this->issue)($exhausted, 10, '2026-01-15');
    VaccineIn::create([
        'vaccine_name' => 'BCG',
        'id_category_vaccine' => $this->category->id,
        'batch_number' => 'RECEIPT-ONLY',
        'expired_date' => '2027-01-01',
        'price' => 500,
        'date_in' => '2026-03-01',
        'stock' => 7,
    ]);

    $rows = ($this->stockReport)();

    expect($rows)->toHaveCount(2)
        ->and($rows->sum('total_in'))->toBe(17)
        ->and($rows->sum('total_out'))->toBe(10)
        ->and($rows->firstWhere('batch_number', 'RECEIPT-ONLY')->current_stock)->toBe(7)
        ->and($rows->firstWhere('batch_number', '4016424')->current_stock)->toBe(0);
});

it('reports stock at the period end using transactions rather than stored stock', function () {
    $vaccine = ($this->receive)(100, ['stock' => 50]);
    ($this->issue)($vaccine, 20, '2026-01-15');
    ($this->issue)($vaccine, 30, '2026-03-01');

    $row = ($this->stockReport)('2026-01-01', '2026-01-31')->sole();

    expect($row->current_stock)->toBe(80)
        ->and($row->stock)->toBe(80)
        ->and($row->total_out)->toBe(20)
        ->and($vaccine->fresh()->stock)->toBe(50);
});

it('uses identical balances for printed stock reports and Excel exports', function () {
    $vaccine = ($this->receive)(50, ['date_in' => '2025-10-30', 'stock' => 30]);
    ($this->receive)(10);
    ($this->issue)($vaccine, 20, '2026-02-01');

    $printed = ($this->stockReport)()->sole();
    $export = new VaccineStockExport('2026-01-01', '2026-10-16');
    $excel = (new ReflectionProperty($export, 'vaccines'))->getValue($export)->sole();

    foreach (['opening_stock', 'total_in', 'total_out', 'current_stock'] as $attribute) {
        expect($excel->$attribute)->toBe($printed->$attribute);
    }
    expect($excel->opening_stock)->toBe(50)
        ->and($excel->current_stock)->toBe(40);
});

it('calculates expiry status using days remaining rather than signed days in the past', function (string $expiry, string $status) {
    ($this->receive)(10, ['expired_date' => $expiry]);

    $this->post(route('vaccine-report.stock'), [
        'start_date' => '2026-01-01',
        'end_date' => '2026-10-16',
    ])->assertOk()->assertSee('<td>'.$status.'</td>', false);
})->with([
    ['2028-03-31', 'Tersedia'],
    ['2026-11-16', 'Tersedia'],
    ['2026-11-15', 'Segera Kadaluarsa'],
    ['2026-10-16', 'Segera Kadaluarsa'],
    ['2026-10-15', 'Kadaluarsa'],
]);

it('downloads a valid stock workbook with balances in the correct columns', function (bool $withData) {
    if ($withData) {
        $vaccine = ($this->receive)(50, ['date_in' => '2025-10-30', 'stock' => 30, 'batch_number' => '00016424']);
        ($this->receive)(10, ['batch_number' => '00016424']);
        ($this->issue)($vaccine, 20, '2026-02-01');
    }

    $response = $this->post(route('vaccine-report.stock-excel'), [
        'start_date' => '2026-01-01',
        'end_date' => '2026-10-16',
    ])->assertOk()->assertDownload('Laporan_Stok_Vaksin_2026-01-01_to_2026-10-16.xlsx');

    $path = tempnam(sys_get_temp_dir(), 'imunisasi-stock-');
    try {
        file_put_contents($path, $response->streamedContent());
        $workbook = PhpOffice\PhpSpreadsheet\IOFactory::load($path);
        $sheet = $workbook->getActiveSheet();
        $totalsRow = $withData ? 8 : 7;

        expect($sheet->getCell('H5')->getValue())->toBe('Stok Awal')
            ->and($sheet->getCell('I6')->getValue())->toBe('Masuk')
            ->and($sheet->getCell('J6')->getValue())->toBe('Keluar')
            ->and($sheet->getCell('K5')->getValue())->toBe('Stok Saat Ini')
            ->and($sheet->getCell('L5')->getValue())->toBe('Status')
            ->and($sheet->getHighestDataColumn())->toBe('L')
            ->and($sheet->getMergeCells())->toHaveKey('I5:J5')
            ->and($sheet->getCell('A'.$totalsRow)->getValue())->toBe('TOTAL')
            ->and($sheet->getCell('H'.$totalsRow)->getValue())->toBe($withData ? 50 : 0)
            ->and($sheet->getCell('I'.$totalsRow)->getValue())->toBe($withData ? 10 : 0)
            ->and($sheet->getCell('J'.$totalsRow)->getValue())->toBe($withData ? 20 : 0)
            ->and($sheet->getCell('K'.$totalsRow)->getValue())->toBe($withData ? 40 : 0);

        if ($withData) {
            expect($sheet->getCell('D7')->getValue())->toBe('00016424')
                ->and($sheet->getCell('L7')->getValue())->toBe('Tersedia');
        }
        $workbook->disconnectWorksheets();
    } finally {
        unlink($path);
    }
})->with([true, false]);

it('prints transaction stock and status when stored stock still contains the receipt quantity', function (int $received, int $earlierOut, int $periodOut, int $expectedStock, string $status) {
    $vaccine = ($this->receive)($received, ['date_in' => '2025-10-30']);
    if ($earlierOut) {
        ($this->issue)($vaccine, $earlierOut, '2025-12-01');
    }
    ($this->issue)($vaccine, $periodOut, '2026-10-16');

    $response = $this->post(route('vaccine-report.stock'), [
        'start_date' => '2026-01-01',
        'end_date' => '2026-10-16',
    ])->assertOk()
        ->assertSee('Stok Awal')
        ->assertDontSee('Saldo Awal')
        ->assertDontSee('Saldo Akhir')
        ->assertSee('Total Nilai Stok: Rp '.number_format($expectedStock * 1000));
    $row = $response->viewData('vaccines')->sole();

    expect($row->opening_stock)->toBe($received - $earlierOut)
        ->and($row->current_stock)->toBe($expectedStock)
        ->and($row->stock_status)->toBe($status)
        ->and($vaccine->fresh()->stock)->toBe($received);

    $document = new DOMDocument;
    $document->loadHTML($response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);
    $cells = (new DOMXPath($document))->query('//tbody/tr[1]/td');
    expect($cells->length)->toBe(12)
        ->and(trim($cells->item(10)->textContent))->toBe((string) $expectedStock)
        ->and(trim($cells->item(11)->textContent))->toBe($status);
})->with([
    'remaining HPV stock' => [50, 0, 39, 11, 'Tersedia'],
    'exhausted HB0 stock' => [22, 15, 7, 0, 'Habis'],
]);
