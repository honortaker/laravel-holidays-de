# honortaker/laravel-holidays-de

This package provides tools to import german holidays into your laravel application
using [api-feiertage.de](https://www.api-feiertage.de) API.

## Getting Started

1. Run `composer require honortaker/laravel-holidays-de` to install [the package]()
2. Run `php artisan migrate` to apply the [database scheme](#database-scheme)
3. Run `php artisan holidays:import` to [import holidays](#import-holidays) into the database
4. [Query holidays](#query-holidays) for your needs by using `Holiday::query()`

### Database Scheme

To get started using german holidays in your application, you need to run the `artisan migrate` command.
This package delivers a builtin [migration](./database/migrations/2025_01_25_create_holidays_table.php) that creates a table which will carry the information about the holidays.

> The package allows you to set an alternative database table name for the model by changing values in the [configuration file](#configuration).

### Import Holidays

After migrating your database, you can go ahead adn import the holiday information from the api using the [`HolidaysImportCommand`](./src/Console/Commands/HolidaysImportCommand.php):

```shell
php artisan holidays:import
```

By running the command, the holidays for the **current year** will be imported into the database.

Optionally you can pass in a specific year into the command:

```shell
php artisan holidays:import 2025
```

### Query Holidays

When you filled your database using the artisan command above, you are ready to query the data for your needs by using the [`Holiday`](./src/Models/Holiday.php) model:

```php
use Honortaker\LaravelHolidaysDe\Models\Holiday;

$holidays = Holiday::all();
```

### Configuration

The package delivers a builtin configuration file which can also be published to overwrite values:

```shell
php artisan vendor:publish --tag="holiday-config"
```

---

#### Configuration: `holidays-de.holidays_table_name`

To prevent collisions with your application tables, you can decide how the table storing the holiday information should be named.

By default, it is named `holidays`.

---

#### Configuration: `holidays-de.api_url`

The url of the API is also configurable. This config should not be changed because the package expects the response data to be in a specific scheme.
However, if the API will move to another domain or change the url in another way, the sourcecode does not need to be touched.

By default, it is set to `https://get.api-feiertage.de`.
