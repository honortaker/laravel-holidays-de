<?php

namespace Honortaker\LaravelHolidaysDe\Console\Commands;

use Carbon\Carbon;
use Honortaker\LaravelHolidaysDe\Models\Holiday;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class HolidaysImportCommand extends Command
{
    protected $signature = 'holidays:import {year=0 : The year which should be imported}';

    function handle()
    {
        if (!is_numeric($this->argument('year'))) {
            $this->error('The year must be a number.');
            return Command::INVALID;
        }
        $year = (int)$this->argument('year');
        if ($year === 0) {
            $year = Carbon::now()->year;
        }
        $apiUrl = config('holidays-de.api_url');
        $response = Http::retry(3, 250)
            ->get($apiUrl, ['year' => $year])
            ->json();

        switch ($response['status']) {
            case 'success':
                return $this->handleResponse($response);
            case 'error':
                $this->error($response['error_description']);
            default:
                return Command::FAILURE;
        }
    }

    protected function handleResponse(array $response): int
    {
        if ($response['feiertage'] === null) {
            $this->warn($response['additional_note']);
            return Command::FAILURE;
        }
        foreach ($response['feiertage'] as $item) {
            Holiday::create([
                'date' => $item['date'],
                'holiday' => $item['fname'],
                'all_states' => $item['all_states'] === '1',
                'baden_wurttemberg' => $item['bw'] === '1',
                'bayern' => $item['by'] === '1',
                'berlin' => $item['be'] === '1',
                'brandenburg' => $item['bb'] === '1',
                'bremen' => $item['hb'] === '1',
                'hamburg' => $item['hh'] === '1',
                'hessen' => $item['he'] === '1',
                'mecklenburg_vorpommern' => $item['mv'] === '1',
                'niedersachsen' => $item['ni'] === '1',
                'nordrhein_westfalen' => $item['nw'] === '1',
                'rheinland_pfalz' => $item['rp'] === '1',
                'saarland' => $item['sl'] === '1',
                'sachsen' => $item['sn'] === '1',
                'sachsen_anhalt' => $item['sn'] === '1',
                'schleswig_holstein' => $item['sh'] === '1',
                'thuringen' => $item['th'] === '1',
            ]);
        }
        return Command::SUCCESS;
    }
}
