<?php

namespace App\Modules\Backend\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
// use Spatie\Analytics\Analytics;
// use Spatie\Analytics\Period;
use Tda\LaravelAnalyticsV4\Period;
use Tda\LaravelAnalyticsV4\PrebuiltRunConfigurations;
use Tda\LaravelAnalyticsV4\RunReportConfiguration;

use Illuminate\Pagination\LengthAwarePaginator;



class AnalyticsController extends Controller
{


    public function index()
    {
        $client = App::make('laravel-analytics-v4');
        $lastMonth = Period::months(12);


        $country_visits = (new RunReportConfiguration())
            ->setStartDate('2023-01-01')
            ->setEndDate('2025-12-31')
            ->addDimensions(['country'])
            ->addMetric('totalUsers');

        $top_browsers = (new RunReportConfiguration())
            ->setStartDate('2023-01-01')
            ->setEndDate('2025-12-31')
            ->addDimensions(['browser'])
            ->addMetric('totalUsers');

        $devices = (new RunReportConfiguration())
            ->setStartDate('2023-01-01')
            ->setEndDate('2025-12-31')
            ->addDimensions(['deviceCategory'])
            ->addMetric('totalUsers');


        $devices_category = $client->convertResponseToArray()->runReport($devices);
        //dd($devices_category);
        // $items = $devices_category; // your array data
        // $page = LengthAwarePaginator::resolveCurrentPage(); // get current page
        // $perPage = 5; // items per page

        // // slice the collection to get the items for the current page
        // $currentItems = array_slice($items, ($page * $perPage) - $perPage, $perPage);

        // // create a new LengthAwarePaginator instance
        // $devices_category = new LengthAwarePaginator($currentItems, count($items), $perPage, $page, ['path' => LengthAwarePaginator::resolveCurrentPath()]);

        // dd($devices_category);


        $visited_pages = $client->runReport(PrebuiltRunConfigurations::getMostVisitedPages($lastMonth));

        $browsers = $client->convertResponseToArray()->runReport($top_browsers);

        $country_visited = $client->convertResponseToArray()->runReport($country_visits);
//         // dd($country_visited);
// // Paginate visited_pages
// $items = $visited_pages; // your array data
// $page = LengthAwarePaginator::resolveCurrentPage(); // get current page
// $currentItems = array_slice($items, ($page * $perPage) - $perPage, $perPage);
// $visited_pages = new LengthAwarePaginator($currentItems, count($items), $perPage, $page, ['path' => LengthAwarePaginator::resolveCurrentPath()]);

// // Paginate browsers
// $items = $browsers; // your array data
// $page = LengthAwarePaginator::resolveCurrentPage(); // get current page
// $currentItems = array_slice($items, ($page * $perPage) - $perPage, $perPage);
// $browsers = new LengthAwarePaginator($currentItems, count($items), $perPage, $page, ['path' => LengthAwarePaginator::resolveCurrentPath()]);
// dd($browsers);

// // Paginate country_visited
// $items = $country_visited; // your array data
// $page = LengthAwarePaginator::resolveCurrentPage(); // get current page
// $currentItems = array_slice($items, ($page * $perPage) - $perPage, $perPage);
// $country_visited = new LengthAwarePaginator($currentItems, count($items), $perPage, $page, ['path' => LengthAwarePaginator::resolveCurrentPath()]);

        return view('Backend::screens.admin.analytics.index', compact('devices_category', 'visited_pages', 'browsers', 'country_visited'));
    }

    public function report2()
    {
        $client = App::make('laravel-analytics-v4');
        $lastMonth = Period::months(1);
        $results = $client->runReport(PrebuiltRunConfigurations::getMostVisitedPages($lastMonth));
        return $results;
    }

    public function  fetchCountryVisitors()
    {
        $client = App::make('laravel-analytics-v4');
        $lastMonth = Period::days(1);
        $results = (new RunReportConfiguration())
            ->setStartDate('2023-01-01')
            ->setEndDate('2023-12-31')
            ->addDimensions(['country'])
            ->addMetric('totalUsers');


        $data = $client->convertResponseToArray()->runReport($results);
        return $data;
    }

    //fetch top browsers
    public function fetchTopBrowsers()
    {
        $client = App::make('laravel-analytics-v4');
        //$lastMonth = Period::days(1);
        $results = (new RunReportConfiguration())
            ->setStartDate('2023-01-01')
            ->setEndDate('2023-12-31')
            ->addDimensions(['browser'])
            ->addMetric('totalUsers');


        $data = $client->convertResponseToArray()->runReport($results);
        return $data;
    }

    public function fetchDeviceCategory()
    {
        $client = App::make('laravel-analytics-v4');
        //$lastMonth = Period::days(1);
        $results = (new RunReportConfiguration())
            ->setStartDate('2023-01-01')
            ->setEndDate('2023-12-31')
            ->addDimensions(['deviceCategory'])
            ->addMetric('totalUsers');


        $data = $client->convertResponseToArray()->runReport($results);
        return $data;
    }


    // protected $analytics;

    // public function __construct(Analytics $analytics)
    // {
    //     $this->analytics = $analytics;
    // }

    // public function fetchTodayVisitors(): Collection
    // {
    //     return $this->analytics->fetchTotalVisitorsAndPageViews(Period::days(1));
    // }
    // public function fetchVisitorsAndPageViewsByDate(Request $request): Collection
    // {
    //     $dt = Carbon::now();
    //     $startDate = empty($request->post('startDate')) ? $dt->subDays(29) : new \DateTime($request->post('startDate'));
    //     $endDate = empty($request->post('endDate')) ? $dt->today() : new \DateTime($request->post('endDate'));

    //     $period = Period::create($startDate, $endDate);
    //     return $this->analytics->fetchVisitorsAndPageViewsByDate($period);
    // }

    // public function fetchMostVisitedPages(Request $request, int $maxResults = 20): Collection
    // {
    //     $dt = Carbon::now();
    //     $startDate = empty($request->post('startDate')) ? $dt->subDays(29) : new \DateTime($request->post('startDate'));
    //     $endDate = empty($request->post('endDate')) ? $dt->today() : new \DateTime($request->post('endDate'));

    //     $period = Period::create($startDate, $endDate);
    //     return $this->analytics->fetchMostVisitedPages($period, $maxResults);
    // }

    // public function fetchTopBrowsers(Request $request, int $maxResults = 10): Collection
    // {
    //     $dt = Carbon::now();
    //     $startDate = empty($request->post('startDate')) ? $dt->subDays(29) : new \DateTime($request->post('startDate'));
    //     $endDate = empty($request->post('endDate')) ? $dt->today() : new \DateTime($request->post('endDate'));

    //     $period = Period::create($startDate, $endDate);
    //     return $this->analytics->fetchTopBrowsers($period, $maxResults);
    // }




}
