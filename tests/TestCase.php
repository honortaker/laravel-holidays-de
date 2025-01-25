<?php

namespace Honortaker\LaravelHolidaysDe\Tests;

use Honortaker\LaravelHolidaysDe\LaravelHolidaysDeServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelHolidaysDeServiceProvider::class,
        ];
    }

    function getEnvironmentSetUp($app)
    {
    }
}
