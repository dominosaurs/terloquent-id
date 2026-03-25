<?php

declare(strict_types=1);

use TerloquentID\District;
use TerloquentID\Province;
use TerloquentID\Regency;
use TerloquentID\Village;

it('works', function () {
    $p = Province::inRandomOrder()->firstOrFail();
    $r = Regency::inRandomOrder()->firstOrFail();
    $d = District::inRandomOrder()->firstOrFail();
    $v = Village::inRandomOrder()->firstOrFail();

    expect($p)->toBeInstanceOf(Province::class);
    expect($r)->toBeInstanceOf(Regency::class);
    expect($d)->toBeInstanceOf(District::class);
    expect($v)->toBeInstanceOf(Village::class);
});

test('provinces have regencies', function () {
    $province = Province::findOrFail(11); // ACEH
    expect($province->regencies)->not->toBeEmpty()
        ->and($province->regencies->firstOrFail())->toBeInstanceOf(Regency::class)
        ->and($province->regencies->firstOrFail()->province_id)->toBe(11);
});

test('regencies have districts', function () {
    $regency = Regency::findOrFail(1101); // KABUPATEN ACEH SELATAN
    expect($regency->districts)->not->toBeEmpty()
        ->and($regency->districts->firstOrFail())->toBeInstanceOf(District::class)
        ->and($regency->districts->firstOrFail()->regency_id)->toBe(1101);
});

test('districts have villages', function () {
    $district = District::findOrFail(1101010); // TEUPAH SELATAN (Note: check actual ID in CSV)
    // Let's find a district from a regency instead to be sure
    $district = District::where('regency_id', 1101)->firstOrFail();

    expect($district->villages)->not->toBeEmpty()
        ->and($district->villages->firstOrFail())->toBeInstanceOf(Village::class)
        ->and($district->villages->firstOrFail()->district_id)->toBe($district->id);
});

test('inverse relationships work', function () {
    $village = Village::firstOrFail();
    expect($village->district)->toBeInstanceOf(District::class)
        ->and($village->district->regency)->toBeInstanceOf(Regency::class)
        ->and($village->district->regency->province)->toBeInstanceOf(Province::class);
});

test('can filter regencies by province', function () {
    $regencies = Regency::where('province_id', 11)->get();
    expect($regencies->every(fn ($r) => $r->province_id === 11))->toBeTrue();
});

test('advanced eloquent operations work', function () {
    // pluck
    $names = Province::whereIn('id', [11, 12])->pluck('name');
    expect($names)->toContain('ACEH', 'SUMATERA UTARA');

    // count
    $count = Province::count();
    expect($count)->toBeGreaterThan(30);

    // search
    $bali = Province::where('name', 'like', '%BALI%')->firstOrFail();
    expect($bali)->not->toBeNull()
        ->and($bali->name)->toBe('BALI');
});

test('it handles non-existent records gracefully', function () {
    $province = Province::findOrFail(999999);
    expect($province)->toBeNull();
});
