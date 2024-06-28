<?php

namespace Tda\LaravelAnalyticsV4\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tda\LaravelAnalyticsV4\LaravelAnalyticsV4
 */
class LaravelAnalyticsV4 extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Tda\LaravelAnalyticsV4\LaravelAnalyticsV4::class;
    }
}
