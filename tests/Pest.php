<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

pest()->extend(TestCase::class)
    ->beforeEach(function () {
        Http::fake([
            '*/provinces.csv' => Http::response("id,name\n11,ACEH\n12,SUMATERA UTARA\n51,BALI", 200),
            '*/regencies.csv' => Http::response("id,province_id,name\n1101,11,KABUPATEN ACEH SELATAN", 200),
            '*/districts.csv' => Http::response("id,regency_id,name\n1101010,1101,TEUPAH SELATAN", 200),
            '*/villages.csv' => Http::response("id,district_id,name\n1101010001,1101010,LATIUNG", 200),
        ]);
    })
    ->in('Feature');
