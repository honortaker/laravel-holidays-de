<?php

namespace Honortaker\LaravelHolidaysDe\Tests\Models;

use Honortaker\LaravelHolidaysDe\Models\Holiday;
use Honortaker\LaravelHolidaysDe\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HolidayTest extends TestCase
{
    use RefreshDatabase;

    const fillableAttributes = [
        'date' => '2025-01-01',
        'holiday' => 'Neujahr',
        'all_states' => true,
        'baden_wurttemberg' => true,
        'bayern' => true,
        'berlin' => true,
        'brandenburg' => true,
        'bremen' => true,
        'hamburg' => true,
        'hessen' => true,
        'mecklenburg_vorpommern' => true,
        'niedersachsen' => true,
        'nordrhein_westfalen' => true,
        'rheinland_pfalz' => true,
        'saarland' => true,
        'sachsen' => true,
        'sachsen_anhalt' => true,
        'schleswig_holstein' => true,
        'thuringen' => true,
    ];

    #region [CRUD]

    public function test_create(): void
    {
        // [GIVEN]
        $fillableAttributes = static::fillableAttributes;
        // [WHEN]
        $model = Holiday::create($fillableAttributes);
        // [THEN]
        $this->assertModelExists($model);
    }

    #endregion [CRUD]
}
