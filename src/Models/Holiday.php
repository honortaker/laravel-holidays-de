<?php

namespace Honortaker\LaravelHolidaysDe\Models;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    public function __construct(array $attributes = [])
    {
        $this->table = config('holidays-de.holidays_table_name');
        parent::__construct($attributes);
    }

    protected $fillable = [
        'date',
        'holiday',
        'all_states',
        'baden_wurttemberg',
        'bayern',
        'berlin',
        'brandenburg',
        'bremen',
        'hamburg',
        'hessen',
        'mecklenburg_vorpommern',
        'niedersachsen',
        'nordrhein_westfalen',
        'rheinland_pfalz',
        'saarland',
        'sachsen',
        'sachsen_anhalt',
        'schleswig_holstein',
        'thuringen',
    ];
}
