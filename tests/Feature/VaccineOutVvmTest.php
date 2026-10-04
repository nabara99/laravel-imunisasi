<?php

use App\Models\User;
use App\Models\Vaccine;
use App\Models\VaccineCategory;
use App\Models\VaccineOut;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->create());
    $this->vaccine = Vaccine::create([
        'vaccine_name' => 'Vaksin Uji',
        'id_category_vaccine' => VaccineCategory::create(['name' => 'Vial'])->id,
        'price' => 1000,
        'batch_number' => 'TEST001',
        'expired_date' => now()->addYear()->toDateString(),
        'stock' => 20,
        'date_in' => now()->toDateString(),
    ]);
});

it('stores the selected VVM and decreases stock', function (string $vvm) {
    $this->post(route('vaccine-out.store'), [
        'date_out' => now()->toDateString(),
        'id_vaccine' => $this->vaccine->id,
        'quantity' => 5,
        'vvm' => $vvm,
    ])->assertRedirect(route('vaccine-out.index'))->assertSessionHasNoErrors();

    $this->assertDatabaseHas('vaccine_out', [
        'id_vaccine' => $this->vaccine->id,
        'quantity' => 5,
        'vvm' => $vvm,
    ]);
    expect($this->vaccine->fresh()->stock)->toBe(15);
})->with(['A', 'B', 'C', 'D']);

it('updates VVM on a legacy record and adjusts stock', function () {
    $vaccineOut = VaccineOut::create([
        'date_out' => now()->toDateString(),
        'id_vaccine' => $this->vaccine->id,
        'quantity' => 5,
    ]);

    $this->put(route('vaccine-out.update', $vaccineOut), [
        'date_out' => now()->toDateString(),
        'quantity' => 7,
        'vvm' => 'B',
    ])->assertRedirect(route('vaccine-out.index'))->assertSessionHasNoErrors();

    expect($vaccineOut->fresh()->vvm)->toBe('B')
        ->and($vaccineOut->fresh()->quantity)->toBe(7)
        ->and($this->vaccine->fresh()->stock)->toBe(18);
});

it('rejects missing or invalid VVM without changing records or stock', function (?string $vvm) {
    $payload = [
        'date_out' => now()->toDateString(),
        'id_vaccine' => $this->vaccine->id,
        'quantity' => 5,
        'vvm' => $vvm,
    ];

    $this->post(route('vaccine-out.store'), $payload)->assertSessionHasErrors('vvm');
    $this->assertDatabaseCount('vaccine_out', 0);

    $vaccineOut = VaccineOut::create([
        'date_out' => now()->toDateString(),
        'id_vaccine' => $this->vaccine->id,
        'quantity' => 3,
        'vvm' => 'A',
    ]);
    $this->put(route('vaccine-out.update', $vaccineOut), $payload)->assertSessionHasErrors('vvm');

    expect($vaccineOut->fresh()->vvm)->toBe('A')
        ->and($vaccineOut->fresh()->quantity)->toBe(3)
        ->and($this->vaccine->fresh()->stock)->toBe(20);
})->with([null, 'E']);

it('renders the VVM column, modal choices, and legacy records', function () {
    foreach (['A', null] as $vvm) {
        VaccineOut::create([
            'date_out' => now()->toDateString(),
            'id_vaccine' => $this->vaccine->id,
            'quantity' => 1,
            'vvm' => $vvm,
        ]);
    }

    $this->get(route('vaccine-out.index'))->assertOk()
        ->assertSee('<th>VVM</th>', false)
        ->assertSee('Kondisi VVM *')
        ->assertSee('vvm-indicator')
        ->assertSee('name="vvm" value="D"', false);
});
