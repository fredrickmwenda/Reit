@extends('Backend::layouts.master')

@section('title', __('Analytics'))

@php
admin_enqueue_styles([
'apexcharts',
'flatpickr',
'perfect-scrollbar',
'modules-widgets',
]);
admin_enqueue_scripts([
'apexcharts',
'flatpickr',
'perfect-scrollbar',
'gmz-widget'
]);

admin_enqueue_styles('mapbox-gl');
admin_enqueue_styles('mapbox-gl-geocoder');
admin_enqueue_scripts('mapbox-gl');
admin_enqueue_scripts('mapbox-gl-geocoder');

$map_token = gmz_params.mapbox_token;
@endphp




@push('styles')

<style>
    /* Set the map container size */
    #map {
        height: 400px;
        width: 100%;
    }
</style>
@endpush



@section('content')
<!-- <h1>Mapbox GL Map</h1>
<div id="map"></div>
<div id="chart"></div>
<div id="map"></div> -->



<div class="layout-px-spacing">
    <div class="layout-top-spacing analytics-page">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
            <div id="map"></div>
                <div class="row">

                    <div class="col-xl-6 col-md-8 col-12 layout-spacing">
                        <div class="table-responsive mb-1 mt-4">

                            <table class="multi-table table table-striped table-bordered table-hover non-hover w-100" data-plugin="footable">
                                <thead>
                                    <tr>
                                        <th>{{ __('Page Path') }}</th>
                                        <th data-breakpoints="xs sm md">{{ __('Screen Page Views') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($visited_pages as $item)
                                    <tr>
                                        <td>{{ $item['dimensions']['pagePath'] === '/' ? 'HomePage' : ltrim($item['dimensions']['pagePath'], '/') }}</td>
                                        <!-- <td>{{ $item['dimensions']['pagePath'] === '/' ? 'HomePage' : $item['dimensions']['pagePath'] }}</td> -->
                                        <td>{{ $item['metrics']['screenPageViews'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>




                        </div>

                    </div>
                    <div class="col-xl-6 col-md-8 col-12 layout-spacing">
                        <div class="table-responsive mb-1 mt-4">

                            <table class="multi-table table table-striped table-bordered table-hover non-hover w-100" data-plugin="footable">
                                <thead>
                                    <tr>
                                        <th>{{__('Device Category')}}</th>
                                        <th data-breakpoints="xs sm md">{{__('Users')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($devices_category as $item)
                                    <tr>
                                        <td>{{ $item['dimensions']['deviceCategory'] }}</td>
                                        <td>{{ $item['metrics']['totalUsers'] }}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>




                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@stop

