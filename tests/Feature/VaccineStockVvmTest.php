<?php

use App\Exports\VaccineStockExport;
use App\Models\User;
use App\Models\Vaccine;
use App\Models\VaccineCategory;
use App\Models\VaccineIn;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->create());
    $this->category = VaccineCategory::create(['name' => 'Vial']);
    $this->vaccine = Vaccine::create([
        'vaccine_name' => 'Vaksin Uji',
        'id_category_vaccine' => $this->category->id,
        'price' => 10,
        'batch_number' => 'TEST001',
        'expired_date' => now()->addYear()->toDateString(),
        'stock' => 15,
        'date_in' => '2026-10-01',
    ]);
    $this->receipt = fn (array $overrides = []) => VaccineIn::create(array_merge([
        'vaccine_name' => $this->vaccine->vaccine_name,
        'id_category_vaccine' => $this->category->id,
        'price' => 10,
        'batch_number' => $this->vaccine->batch_number,
        'expired_date' => now()->addYear()->toDateString(),
        'stock' => 5,
        'date_in' => '2026-10-02',
        'vvm' => 'A',
    ], $overrides));
});

it('uses the latest matching receipt VVM in the stock report', function () {
    ($this->receipt)();
    ($this->receipt)(['date_in' => '2026-10-01', 'vvm' => 'C']);
    ($this->receipt)(['vvm' => 'B']);
    ($this->receipt)(['date_in' => '2026-10-03', 'batch_number' => 'OTHER', 'vvm' => 'D']);
    ($this->receipt)(['date_in' => '2026-10-03', 'vaccine_name' => 'Vaksin Lain', 'vvm' => 'D']);
    ($this->receipt)([
        'date_in' => '2026-10-03',
        'id_category_vaccine' => VaccineCategory::create(['name' => 'Ampul'])->id,
        'vvm' => 'D',
    ]);

    $this->post(route('vaccine-report.stock'), [
        'start_date' => '2026-10-01',
        'end_date' => '2026-10-31',
        'id_vaccine' => $this->vaccine->id,
    ])->assertOk()
        ->assertSee('<th rowspan="2">VVM</th>', false)
        ->assertSee('<td>B</td>', false)
        ->assertSee('<td colspan="7">TOTAL</td>', false)
        ->assertViewHas('vaccines', function ($vaccines) {
            return $vaccines->count() === 1
                && $vaccines->first()->id === $this->vaccine->id
                && $vaccines->first()->vvm === 'B'
                && $vaccines->first()->current_stock === 15;
        });
});

it('shows a dash when the latest receipt has no VVM or no receipt matches', function () {
    ($this->receipt)();
    ($this->receipt)(['date_in' => '2026-10-03', 'vvm' => null]);
    $otherVaccine = $this->vaccine->replicate();
    $otherVaccine->batch_number = 'NO-RECEIPT';
    $otherVaccine->save();

    $this->post(route('vaccine-report.stock'), [
        'start_date' => '2026-10-01',
        'end_date' => '2026-10-31',
    ])->assertOk()
        ->assertSee('<td>-</td>', false)
        ->assertViewHas('vaccines', fn ($vaccines) => $vaccines->count() === 2
            && $vaccines->every(fn ($vaccine) => $vaccine->vvm === null));
});

it('uses the same receipt VVM source for the stock Excel export', function () {
    ($this->receipt)();
    ($this->receipt)(['date_in' => '2026-10-03', 'vvm' => 'B']);

    $export = new VaccineStockExport('2026-10-01', '2026-10-31', $this->vaccine->id);
    $vaccines = (new ReflectionProperty($export, 'vaccines'))->getValue($export);

    expect($vaccines)->toHaveCount(1)
        ->and($vaccines->first()->vvm)->toBe('B')
        ->and($vaccines->first()->total_in)->toBe(10)
        ->and($vaccines->first()->total_out)->toBe(0)
        ->and($vaccines->first()->current_stock)->toBe(15);
});
