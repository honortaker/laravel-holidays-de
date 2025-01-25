<?php

namespace Honortaker\LaravelHolidaysDe\Tests\Console\Commands;

use Carbon\Carbon;
use Honortaker\LaravelHolidaysDe\Console\Commands\HolidaysImportCommand;
use Honortaker\LaravelHolidaysDe\Models\Holiday;
use Honortaker\LaravelHolidaysDe\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

class HolidaysImportCommandTest extends TestCase
{
    use RefreshDatabase;

    protected string|null $requestedUrl = null;
    protected string $dummyResponseFile = self::exampleSuccess;
    const exampleSuccess = __DIR__ . '/../../Mock/ApiResponses/example-success.json';
    const exampleMissingData = __DIR__ . '/../../Mock/ApiResponses/example-missingdata.json';
    const exampleError = __DIR__ . '/../../Mock/ApiResponses/example-error.json';

    protected function setUp(): void
    {
        parent::setUp();

        Http::fake(function (Request $request, array $options) {
            $this->requestedUrl = $request->url();
            $json = json_decode(file_get_contents($this->dummyResponseFile), true);
            return Http::response($json);
        });
    }

    #region [ARGS]

    public function test_year_default_argument(): void
    {
        // [GIVEN]
        $currentYear = Carbon::now()->year;
        // [WHEN]
        $this->artisan(HolidaysImportCommand::class);
        // [THEN]
        $this->assertStringContainsString(config('holidays-de.api_url'), $this->requestedUrl);
        $this->assertStringContainsString("year={$currentYear}", $this->requestedUrl);
    }

    public function test_year_valid_argument(): void
    {
        // [GIVEN]
        $validArgument = 1234;
        // [WHEN]
        $this->artisan(HolidaysImportCommand::class, ['year' => $validArgument]);
        // [THEN]
        $this->assertStringContainsString(config('holidays-de.api_url'), $this->requestedUrl);
        $this->assertStringContainsString("year={$validArgument}", $this->requestedUrl);
    }

    public function test_year_invalid_argument(): void
    {
        // [GIVEN]
        $invalidArgument = 'NaN';
        // [WHEN]
        $this->artisan(HolidaysImportCommand::class, ['year' => $invalidArgument])
            // [THEN]
            ->assertFailed();
    }

    #endregion [ARGS]

    #region [COMMAND]

    public function test_success()
    {
        // [SETUP]
        $this->dummyResponseFile = self::exampleSuccess;
        // [GIVEN]
        $count = count(json_decode(file_get_contents($this->dummyResponseFile), true)['feiertage']);
        // [WHEN]
        $this->artisan(HolidaysImportCommand::class)
            // [THEN]
            ->assertOk();
        $this->assertEquals($count, Holiday::query()->count());
    }

    public function test_missing_data()
    {
        // [SETUP]
        $this->dummyResponseFile = self::exampleMissingData;
        // [GIVEN]
        // [WHEN]
        $this->artisan(HolidaysImportCommand::class)
            // [THEN]
            ->assertFailed();
    }

    public function test_error()
    {
        // [SETUP]
        $this->dummyResponseFile = self::exampleError;
        // [GIVEN]
        // [WHEN]
        $this->artisan(HolidaysImportCommand::class)
            // [THEN]
            ->assertFailed();
    }

    #endregion [COMMAND]
}
