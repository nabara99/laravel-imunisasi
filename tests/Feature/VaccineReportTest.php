<?php

use App\Exports\VaccineInExport;
use App\Exports\VaccineOutExport;
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

    $category = VaccineCategory::create(['name' => 'Vial']);
    $attributes = [
        'vaccine_name' => 'HB0',
        'id_category_vaccine' => $category->id,
        'price' => 1000,
        'batch_number' => 'BATCH-HB0',
        'expired_date' => now()->addYear()->toDateString(),
        'stock' => 15,
        'date_in' => '2026-10-01',
    ];

    // IDs deliberately overlap for different vaccines in the two tables.
    $this->vaccine = Vaccine::forceCreate(['id' => 101] + $attributes);
    $this->receipt = VaccineIn::forceCreate(['id' => 501, 'vvm' => 'A'] + $attributes);

    $otherAttributes = array_replace($attributes, [
        'vaccine_name' => 'BCG',
        'batch_number' => 'BATCH-BCG',
        'stock' => 0,
    ]);
    Vaccine::forceCreate(['id' => 501] + $otherAttributes);
    VaccineIn::forceCreate(['id' => 101, 'vvm' => 'B'] + $otherAttributes);

    $this->issue = VaccineOut::create([
        'id_vaccine' => $this->vaccine->id,
        'date_out' => '2026-10-02',
        'quantity' => 5,
        'vvm' => 'A',
    ]);
    VaccineOut::create([
        'id_vaccine' => 501,
        'date_out' => '2026-10-02',
        'quantity' => 1,
        'vvm' => 'B',
    ]);

    $this->reportForm = function (string $type): DOMElement {
        $response = $this->get(route('vaccine-report.index'))->assertOk();
        $document = new DOMDocument;
        $document->loadHTML($response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);

        return (new DOMXPath($document))->query('//form[@id="form-'.$type.'"]')->item(0);
    };
});

it('prints the selected vaccine even when receipt and stock IDs do not match', function (string $type) {
    $form = ($this->reportForm)($type);
    $xpath = new DOMXPath($form->ownerDocument);
    $option = $xpath->query('.//select/option[normalize-space(.) = "HB0 - BATCH-HB0"]', $form)->item(0);
    $expected = match ($type) {
        'in' => $this->receipt,
        'out' => $this->issue,
        'stock' => $this->vaccine,
    };
    $viewKey = match ($type) {
        'in' => 'vaccineIns',
        'out' => 'vaccineOuts',
        'stock' => 'vaccines',
    };

    $this->post($form->getAttribute('action'), [
        'start_date' => '2026-10-01',
        'end_date' => '2026-10-31',
        'id_vaccine' => $option->getAttribute('value'),
    ])->assertOk()
        ->assertSessionHasNoErrors()
        ->assertViewHas($viewKey, fn ($records) => $records->count() === 1
            && $records->first()->id === $expected->id)
        ->assertSee('BATCH-HB0')
        ->assertDontSee('BATCH-BCG');

    expect($form->getAttribute('target'))->toBe('_blank');
})->with(['in', 'out', 'stock']);

it('keeps all vaccines available in reports including exhausted stock', function (string $type) {
    $form = ($this->reportForm)($type);
    $xpath = new DOMXPath($form->ownerDocument);
    $options = $xpath->query('.//select/option[@value != ""]', $form);
    $viewKey = match ($type) {
        'in' => 'vaccineIns',
        'out' => 'vaccineOuts',
        'stock' => 'vaccines',
    };

    expect($options->length)->toBe(2);

    $this->post($form->getAttribute('action'), [
        'start_date' => '2026-10-01',
        'end_date' => '2026-10-31',
        'id_vaccine' => '',
    ])->assertOk()
        ->assertViewHas($viewKey, fn ($records) => $records->count() === 2);
})->with(['in', 'out', 'stock']);

it('uses the same form filters and validation for Excel exports', function (string $type) {
    $form = ($this->reportForm)($type);
    $xpath = new DOMXPath($form->ownerDocument);
    $button = $xpath->query('.//button[@id="excel-'.$type.'-btn"]', $form)->item(0);
    $option = $xpath->query('.//select/option[normalize-space(.) = "HB0 - BATCH-HB0"]', $form)->item(0);
    $exportClass = match ($type) {
        'in' => VaccineInExport::class,
        'out' => VaccineOutExport::class,
        'stock' => VaccineStockExport::class,
    };
    $viewKey = match ($type) {
        'in' => 'vaccineIns',
        'out' => 'vaccineOuts',
        'stock' => 'vaccines',
    };
    $expected = match ($type) {
        'in' => $this->receipt,
        'out' => $this->issue,
        'stock' => $this->vaccine,
    };
    $export = new $exportClass('2026-10-01', '2026-10-31', $option->getAttribute('value'));
    $records = (new ReflectionProperty($export, $viewKey))->getValue($export);

    expect($button->getAttribute('type'))->toBe('submit')
        ->and($button->getAttribute('formaction'))->toBe(route('vaccine-report.'.$type.'-excel'))
        ->and($button->hasAttribute('disabled'))->toBeFalse()
        ->and($records)->toHaveCount(1)
        ->and($records->first()->id)->toBe($expected->id);
})->with(['in', 'out', 'stock']);

it('rejects reversed date ranges and displays the validation errors', function (string $report) {
    $this->from(route('vaccine-report.index'))
        ->post(route('vaccine-report.'.$report), [
            'start_date' => '2026-10-31',
            'end_date' => '2026-10-01',
        ])->assertRedirect(route('vaccine-report.index'))
        ->assertSessionHasErrors('end_date');

    $this->get(route('vaccine-report.index'))
        ->assertOk()
        ->assertSee('Terjadi kesalahan validasi:');
})->with(['in', 'out', 'stock', 'in-excel', 'out-excel', 'stock-excel']);
