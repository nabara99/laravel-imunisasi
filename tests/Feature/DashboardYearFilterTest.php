<?php

use App\Models\Children;
use App\Models\Ibl;
use App\Models\IblTarget;
use App\Models\Idl;
use App\Models\IdlTarget;
use App\Models\MotherTarget;
use App\Models\School;
use App\Models\Student;
use App\Models\StudentImun;
use App\Models\StudentTarget;
use App\Models\User;
use App\Models\Village;
use App\Models\Wus;
use App\Models\WusImun;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->travelTo(Carbon\Carbon::parse('2026-10-16 12:00:00'));
    $this->actingAs(User::factory()->create());
    $this->village = Village::create(['name' => 'Desa Uji']);
    $this->school = School::create(['name' => 'Sekolah Uji']);
    $this->sequence = 0;
    $this->child = fn () => Children::create([
        'name_child' => 'Anak Uji '.++$this->sequence,
        'nik' => str_pad($this->sequence, 16, '0', STR_PAD_LEFT),
        'date_birth' => '2024-01-01',
        'mother_name' => 'Ibu Uji',
        'mother_nik' => '0000000000000000',
        'gender' => 'L',
        'address' => 'Alamat Uji',
        'id_village' => $this->village->id,
    ]);
    $this->tt = function (array $dates) {
        $wus = Wus::create([
            'name_wus' => 'WUS Uji '.++$this->sequence,
            'nik' => str_pad($this->sequence, 16, '0', STR_PAD_LEFT),
            'date_birth' => '2000-01-01',
            'address' => 'Alamat Uji',
            'id_village' => $this->village->id,
            'hamil' => false,
        ]);

        return WusImun::create(['id_wus' => $wus->id] + $dates);
    };
    $this->bias = function (array $dates) {
        $student = Student::create([
            'name_student' => 'Siswa Uji '.++$this->sequence,
            'nik' => str_pad($this->sequence, 16, '0', STR_PAD_LEFT),
            'birth_date' => '2015-01-01',
            'gender' => 'P',
            'mother_name' => 'Ibu Uji',
            'mother_nik' => '0000000000000000',
            'id_school' => $this->school->id,
            'class' => '5',
        ]);

        return StudentImun::create(['id_student' => $student->id] + $dates);
    };

    foreach ([2025 => 1, 2026 => 2] as $year => $factor) {
        IdlTarget::create(['village_id' => $this->village->id, 'year' => $year, 'sum_boys' => 5 * $factor, 'sum_girls' => 5 * $factor]);
        IblTarget::create(['village_id' => $this->village->id, 'year' => $year, 'sum_boys' => 10 * $factor, 'sum_girls' => 10 * $factor]);
        MotherTarget::create(['village_id' => $this->village->id, 'year' => $year, 'pregnant' => 10 * $factor, 'no_pregnant' => 20 * $factor]);
        StudentTarget::create(['id_school' => $this->school->id, 'year' => $year, 'classroom' => '5', 'sum_boys' => 20 * $factor, 'sum_girls' => 20 * $factor]);

        foreach (['01-01', '12-31'] as $date) {
            Idl::create(['id_children' => ($this->child)()->id, 'mr1' => $year.'-'.$date, 'lengkap' => true]);
        }
        Idl::create(['id_children' => ($this->child)()->id, 'mr1' => $year.'-05-01', 'lengkap' => false]);
        Ibl::create(['id_children' => ($this->child)()->id, 'mr2' => $year.'-12-31', 'lengkap' => true]);
        Ibl::create(['id_children' => ($this->child)()->id, 'mr2' => $year.'-05-01', 'lengkap' => false]);
    }
    // These are entered in 2026, but must be counted by their dose dates.
    ($this->tt)(['t1' => '2025-12-31', 't2' => '2026-01-01', 't3' => '2026-12-31']);
    ($this->tt)(['t1' => '2026-01-01', 't2' => '2026-06-01']);
    ($this->tt)(['t1' => '2025-01-01']);
    ($this->tt)([]);
    ($this->bias)(['dt' => '2025-01-01', 'mr' => '2026-01-01', 'hpv2' => '2026-12-31']);
    ($this->bias)(['hpv1' => '2026-07-01']);
    ($this->bias)(['td1' => '2025-12-31']);
    ($this->bias)([]);
});

it('filters every dashboard target achievement and percentage by the selected year', function (int $year, int $factor) {
    $response = $this->get(route('dashboard', ['year' => $year]))->assertOk();

    $response->assertViewHas('dashboardYear', $year)
        ->assertViewHas('idlTargetTotal', 10 * $factor)
        ->assertViewHas('iblTargetTotal', 20 * $factor)
        ->assertViewHas('wusTargetTotal', 30 * $factor)
        ->assertViewHas('biasTargetTotal', 40 * $factor)
        ->assertViewHas('idlAchievement', 2)
        ->assertViewHas('iblAchievement', 1)
        ->assertViewHas('ttAchievement', 2)
        ->assertViewHas('biasAchievement', 2)
        ->assertSee('Monitoring Capaian Program Imunisasi Tahun '.$year);

    foreach (['idl' => [2, 10], 'ibl' => [1, 20], 'tt' => [2, 30], 'bias' => [2, 40]] as $program => [$achievement, $target]) {
        expect($response->viewData($program.'Percentage'))->toBe(round($achievement / ($target * $factor) * 100, 1));
    }

    $document = new DOMDocument;
    $document->loadHTML($response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);
    $rows = (new DOMXPath($document))->query('//table[@id="dashboard-summary-table"]/tbody/tr');
    expect($rows->length)->toBe(4);
    foreach ([[10, 2], [20, 1], [30, 2], [40, 2]] as $index => [$target, $achievement]) {
        $cells = $rows->item($index)->getElementsByTagName('td');
        expect(trim($cells->item(1)->textContent))->toBe((string) ($target * $factor))
            ->and(trim($cells->item(2)->textContent))->toBe((string) $achievement);
    }
})->with([[2025, 1], [2026, 2]]);

it('defaults to the current year and shows the selected filter beside the user menu', function () {
    $response = $this->get(route('dashboard'))->assertOk()->assertViewHas('dashboardYear', 2026)
        ->assertViewHas('idlTargetTotal', 20)->assertViewHas('idlAchievement', 2);
    $document = new DOMDocument;
    $document->loadHTML($response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);
    $xpath = new DOMXPath($document);
    $form = $xpath->query('//nav[contains(@class, "navbar")]//form[@id="dashboard-year-form"]')->item(0);

    expect($form)->not->toBeNull()
        ->and(strtolower($form->getAttribute('method')))->toBe('get')
        ->and($form->getAttribute('action'))->toBe(route('dashboard'))
        ->and($xpath->query('.//select[@name="year"]/option[@selected]', $form)->item(0)->getAttribute('value'))->toBe('2026')
        ->and($xpath->query('ancestor::li[1]/following-sibling::li[1]//a[@data-bs-toggle="dropdown"]', $form)->length)->toBe(1);
});

it('returns zero values instead of falling back to another years targets or achievements', function () {
    $response = $this->get(route('dashboard', ['year' => 2024]))->assertOk()->assertViewHas('dashboardYear', 2024);

    foreach (['idlTargetTotal', 'iblTargetTotal', 'wusTargetTotal', 'biasTargetTotal', 'idlAchievement', 'iblAchievement', 'ttAchievement', 'biasAchievement', 'idlPercentage', 'iblPercentage', 'ttPercentage', 'biasPercentage'] as $attribute) {
        expect($response->viewData($attribute))->toBe(0);
    }
});

it('counts each recipient once even with several doses or duplicated records', function () {
    foreach ([Idl::class => 'mr1', Ibl::class => 'mr2', WusImun::class => 't2', StudentImun::class => 'mr'] as $model => $dateColumn) {
        $model::whereYear($dateColumn, 2026)->first()->replicate()->save();
    }

    $this->get(route('dashboard', ['year' => 2026]))->assertOk()
        ->assertViewHas('idlAchievement', 2)
        ->assertViewHas('iblAchievement', 1)
        ->assertViewHas('ttAchievement', 2)
        ->assertViewHas('biasAchievement', 2);
});

it('does not count complete flags with no completion dose in the selected year', function () {
    Idl::create(['id_children' => ($this->child)()->id, 'hb0' => '2026-01-01', 'lengkap' => true]);
    Ibl::create(['id_children' => ($this->child)()->id, 'pcv3' => '2026-01-01', 'lengkap' => true]);

    $this->get(route('dashboard', ['year' => 2026]))->assertOk()
        ->assertViewHas('idlAchievement', 2)->assertViewHas('iblAchievement', 1);
});

it('offers years found in targets and dose dates even without targets for that year', function () {
    IdlTarget::create(['village_id' => $this->village->id, 'year' => 2021, 'sum_boys' => 1, 'sum_girls' => 1]);
    ($this->tt)(['t4' => '2023-01-01']);
    ($this->bias)(['hpv2' => '2022-01-01']);

    $this->get(route('dashboard'))->assertOk()
        ->assertViewHas('dashboardYears', [2026, 2025, 2023, 2022, 2021]);
});

it('does not show the dashboard year filter on other pages', function () {
    $this->get(route('vaccine-report.index'))->assertOk()->assertDontSee('id="dashboard-year-form"', false);
});

it('keeps achievements visible when the selected year has no targets', function () {
    IdlTarget::where('year', 2026)->delete();
    IblTarget::where('year', 2026)->delete();
    MotherTarget::where('year', 2026)->delete();
    StudentTarget::where('year', 2026)->delete();

    $this->get(route('dashboard', ['year' => 2026]))->assertOk()
        ->assertViewHas('idlTargetTotal', 0)->assertViewHas('idlAchievement', 2)->assertViewHas('idlPercentage', 0)
        ->assertViewHas('iblTargetTotal', 0)->assertViewHas('iblAchievement', 1)->assertViewHas('iblPercentage', 0)
        ->assertViewHas('wusTargetTotal', 0)->assertViewHas('ttAchievement', 2)->assertViewHas('ttPercentage', 0)
        ->assertViewHas('biasTargetTotal', 0)->assertViewHas('biasAchievement', 2)->assertViewHas('biasPercentage', 0);
});

it('rejects invalid year parameters', function ($year) {
    $this->getJson(route('dashboard', ['year' => $year]))->assertUnprocessable()->assertJsonValidationErrors('year');
})->with(['all', 1899, 10000, '2026.5', [[2025, 2026]]]);
