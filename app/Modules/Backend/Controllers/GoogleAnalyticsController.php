<?php

namespace App\Modules\Backend\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\Analytics\Period;
use Spatie\Analytics\Analytics;

class GoogleAnalyticsController extends Controller
{
    protected $analytics;

    public function __construct(Analytics $analytics)
    {
        $this->analytics = $analytics;
    }

    public function index(Request $request)
    {
        $action = $request->input('action');
        $countriesData = $this->fetchVisitorsByCountry($request);

        switch ($action) {
            case 'fetchTodayVisitors':
                $data = $this->fetchTodayVisitors();
                break;
            case 'fetchMostVisitedPages':
                $data = $this->fetchMostVisitedPages($request);
                break;
            case 'fetchTopBrowsers':
                $data = $this->fetchTopBrowsers($request);
                break;
            case 'fetchVisitorsByCountry':
                $data = $this->fetchVisitorsByCountry($request);
                break;
            default:
                return response()->json(['message' => 'Invalid action'], 400);
                break;
        }

        // Assuming 'index' is the name of your Blade view
        return view('your-folder.index', compact('data'));
    }

    public function fetchTodayVisitors()
    {
        $data = $this->analytics->fetchTotalVisitorsAndPageViews(Period::days(1));
        // Use `info`, `dd`, or `var_dump` to check the fetched data
        

        return response()->json($data);
    }


    public function fetchVisitorsAndPageViews(Request $request)
    {
        $dt = Carbon::now();
        $startDate = empty($request->post('startDate')) ? $dt->subDays(29) : new \DateTime($request->post('startDate'));
        $endDate = empty($request->post('endDate')) ? $dt->today() : new \DateTime($request->post('endDate'));

        $period = Period::create($startDate, $endDate);
        $data = $this->analytics->fetchMostVisitedPages($period);
        return response()->json($data);
    }


    public function fetchMostVisitedPages(Request $request, int $maxResults = 20)
    {
        $dt = Carbon::now();
        $startDate = empty($request->post('startDate')) ? $dt->subDays(29) : new \DateTime($request->post('startDate'));
        $endDate = empty($request->post('endDate')) ? $dt->today() : new \DateTime($request->post('endDate'));

        $period = Period::create($startDate, $endDate);
        $data = $this->analytics->fetchMostVisitedPages($period, $maxResults);
        return response()->json($data);
    }

    public function fetchTopBrowsers(Request $request, int $maxResults = 10)
    {
        $dt = Carbon::now();
        $startDate = empty($request->post('startDate')) ? $dt->subDays(29) : new \DateTime($request->post('startDate'));
        $endDate = empty($request->post('endDate')) ? $dt->today() : new \DateTime($request->post('endDate'));

        $period = Period::create($startDate, $endDate);
        $data = $this->analytics->fetchTopBrowsers($period, $maxResults);
        return response()->json($data);
       
    }

    public function fetchVisitorsByCountry(Request $request, int $maxResults = 10): Collection
    {
        $dt = now();
        $startDate = empty($request->post('startDate')) ? $dt->subDays(29) : new \DateTime($request->post('startDate'));
        $endDate = empty($request->post('endDate')) ? $dt->today() : new \DateTime($request->post('endDate'));

        $period = Period::create($startDate, $endDate);

        // Fetch visitors by country for the given period
        $analyticsData =$this->analytics->performQuery($period, 'ga:sessions', [
            'dimensions' => 'ga:country',
            'sort' => '-ga:sessions',
            'max-results' => $maxResults,
        ]);

        // Extract and format the data into a collection
        $visitorDataByCountry = collect($analyticsData['rows'] ?? [])->map(function ($row) {
            return [
                'country' => $row[0] ?? 'Unknown',
                'visitors' => $row[1] ?? 0,
            ];
        });

        // $data = $this->analytics->fetchTopBrowsers($period, $maxResults);
        // return response()->json($data);

        return $visitorDataByCountry;
    }
}
