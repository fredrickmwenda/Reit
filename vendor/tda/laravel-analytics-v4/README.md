# GA4 integration for laravel 8



This package offers integration to GA4 properties with some out of the box methods. Inspired by [Spatie integration](https://github.com/spatie/laravel-analytics) for GA3 and originally forked from MyOutDeskLLC. Requires Laravel 8+.

## Installation

You can install the package via composer:

```bash
composer require tda/laravel-analytics-v4
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="analytics-v4-config"
```

This is the contents of the published config file:

```php
return [
    'property_id' => env('ANALYTICS_PROPERTY_ID', 'XXXXXXXXX'),
    'service_account_credentials_json' => storage_path('app/analytics/service-account-credentials.json'),
    // This data is passed into the built-in cache mechanism for google's CredentialWrapper
    'cache' => [
        'enableCaching' => env('ANALYTICS_CACHE',false),
        'authCache' => null,
        'authCacheOptions' => [
            'lifetime' => env('ANALYTICS_CACHE_LIFETIME', 60), // you may want to set this higher
            'prefix' => env('ANALYTICS_CACHE_PREFIX', 'analytics_'),
        ]
    ]
];
```

## Usage
Inside Laravel:

```php
use Tda\LaravelAnalyticsV4\Period;
use Tda\LaravelAnalyticsV4\PrebuiltRunConfigurations;

$client = App::make('laravel-analytics-v4');
$lastMonth = Period::months(1);
$results = $client->runReport(PrebuiltRunConfigurations::getMostVisitedPages($lastMonth));
```

You may configure your own report configuration, or use a pre-built report:
```php
// Use this on the laravel side to get it from the container
$analytics = App::make('laravel-analytics-v4');

// Prepare a filter
$filter = new StringFilter();
$filter->setDimension('country')->exactlyMatches('United States');

// Prepare a report
$reportConfig = (new RunReportConfiguration())
                ->setStartDate('2022-09-01')
                ->setEndDate('2022-09-30')
                ->addDimensions(['country', 'landingPage', 'date'])
                ->addMetric('sessions')
                ->addFilter($filter);

$analytics->convertResponseToArray()->runReport($reportConfig);
```
Yay, results:
```
  [
    "dimensions" => [
      "country" => "United States",
      "landingPage" => "/",
      "date" => "20220903",
    ],
    "metrics" => [
      "sessions" => "113",
    ],
  ],
  [
    "dimensions" => [
      "country" => "United States",
      "landingPage" => "/services/",
      "date" => "20220902",
    ],
    "metrics" => [
      "sessions" => "110",
    ],
  ],
```
Or Using Prebuilt Report Configurations:

```php
$lastMonth = Period::months(1);
$analytics->runReport(PrebuiltRunConfigurations::getMostVisitedPages($lastMonth));
```
## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Submit a PR with passing tests.

## Credits

- [JL](https://github.com/WalrusSoup)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
