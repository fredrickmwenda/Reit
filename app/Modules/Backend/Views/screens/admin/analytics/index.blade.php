@extends('Backend::layouts.master')

@section('title', __('Analytics'))

@php
admin_enqueue_styles([
'apexcharts',
'mapbox-gl',
'flatpickr',
'perfect-scrollbar',
'modules-widgets',
]);
admin_enqueue_scripts([
'apexcharts',
'mapbox-gl',
'flatpickr',
'perfect-scrollbar',
'gmz-widget'
]);
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
<div id="chart"></div>
<div id="map"></div> -->



 <!-- <div id='map' style='width: 100%; height: 600px;'></div> -->
 <div class="layout-px-spacing">
    <div class="layout-top-spacing analytics-page">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row mt-4 mb-4">
                    <div class="col-xl-6">
                        <h2>{{ __('Country Statistics') }}</h2>
                        <div class="table-responsive mb-1 mt-4">
                            <table class="multi-table table table-striped table-bordered table-hover non-hover w-100 footable footable-1 breakpoint-lg" data-plugin="footable">
                                <thead>
                                    <tr>
                                        <th>{{ __('Country') }}</th>
                                        <th data-breakpoints="xs sm md">{{ __('Visitors') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($country_visited as $item)
                                        <tr>
                                            <td>{{ $item['dimensions']['country']  }}</td>
                                            <td>{{ $item['metrics']['totalUsers'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <h2>{{ __('Browser Statistics') }}</h2>
                        <div class="table-responsive mb-1 mt-4">
                            <table class="multi-table table table-striped table-bordered table-hover non-hover w-100" data-plugin="footable">
                                <thead>
                                    <tr>
                                        <th>{{ __('Browser') }}</th>
                                        <th data-breakpoints="xs sm md">{{ __('Users') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($browsers as $item)
                                        <tr>
                                            <td>{{ $item['dimensions']['browser']  }}</td>
                                            <td>{{ $item['metrics']['totalUsers'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-6 col-md-8 col-12 layout-spacing">
                        <h2>{{ __('Page Path Statistics') }}</h2>
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
                                            <td>{{ $item['metrics']['screenPageViews'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-xl-6 col-md-8 col-12 layout-spacing">
                        <h2>{{ __('Device Category Statistics') }}</h2>
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

@push('scripts')

<!-- <script>
    mapboxgl.accessToken = gmz_params.mapbox_token;
    console.log(mapboxgl.accessToken);

    const analyticsData = @json($country_visited);

    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/light-v11', // Replace with your desired Mapbox style URL
        center: [0, 0], // Set the initial center coordinates
        zoom: 1, // Set the initial zoom level
    });

    // Function to add data to the map
    function addDataToMap() {
        console.log(analyticsData); // Check your data
        $.each(analyticsData, (index, el) => {
            const isoCountryCode = el.dimensions.country;
            const totalUsers = parseInt(el.metrics.totalUsers) || 0;
            console.log(`isoCountryCode: ${isoCountryCode}, totalUsers: ${totalUsers}`); // Check your variables

            const layerId = `country-fill-${isoCountryCode}`;

            // Check if layer already exists
            if (!map.getLayer(layerId)) {
                map.addLayer({
                    id: layerId,
                    type: 'fill',
                    source: 'country-boundaries',
                    'source-layer': 'country_boundaries',
                    paint: {
                        'fill-color': totalUsers > 0 ? '#f6f8fb' : 'white',
                        'fill-outline-color': totalUsers > 0 ? '#0000ff' : 'black',
                    },
                    filter: ['==', ['get', 'iso_3166_1'], isoCountryCode],
                });
            } else {
                console.log(`Layer ${layerId} already exists`);
            }
        });
        // $.each(analyticsData, (index, el) => {
        //     const isoCountryCode = el.dimensions.country;
        //     const totalUsers = parseInt(el.metrics.totalUsers) || 0;
        //     console.log(`isoCountryCode: ${isoCountryCode}, totalUsers: ${totalUsers}`); // Check your variables

        //     map.addLayer({
        //         id: `country-fill-${isoCountryCode}`,
        //         type: 'fill',
        //         source: 'country-boundaries',
        //         'source-layer': 'country_boundaries',
        //         paint: {
        //             'fill-color': totalUsers > 0 ? '#f6f8fb' : 'white',
        //             'fill-outline-color': totalUsers > 0 ? '#0000ff' : 'black',
        //         },
        //         filter: ['==', ['get', 'iso_3166_1'], isoCountryCode],
        //     });
        // });
    }

    map.on('style.load', function() {
        map.addSource('country-boundaries', {
            type: 'vector',
            url: 'mapbox://mapbox.country-boundaries-v1',
        });

        map.on('sourcedata', function(e) {
            if (e.sourceId === 'country-boundaries' && map.isSourceLoaded('country-boundaries')) {
                console.log('Source loaded');
                addDataToMap();
            }
        });
    });
</script> -->


<!-- <script>
    mapboxgl.accessToken = gmz_params.mapbox_token;


    const analyticsData = @json($country_visited);

    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/light-v11',
        center: [0, 0],
        zoom: 1,
    });

    function addDataToMap() {
        console.log(analyticsData);
        $.each(analyticsData, (index, el) => {
            const isoCountryCode = el.dimensions.country;
            const totalUsers = parseInt(el.metrics.totalUsers) || 0;
            console.log(`isoCountryCode: ${isoCountryCode}, totalUsers: ${totalUsers}`);

            const layerID = `country-fill-${isoCountryCode}`;

            if (!map.getLayer(layerID)) {
                map.addLayer({
                    id: layerID,
                    type: 'fill',
                    source: 'country-boundaries',
                    'source-layer': 'country_boundaries',
                    paint: {
                        'fill-color': totalUsers > 0 ? '#f6f8fb' : 'white',
                        'fill-outline-color': totalUsers > 0 ? 'red' : 'black',
                    },
                    filter: ['==', ['get', 'iso_3166_1'], isoCountryCode],
                });

                // Add hover event listener
                map.on('mouseenter', layerID, function(e) {
                    console.log('hovering');
                    const popup = new mapboxgl.Popup()
                        .setLngLat(e.lngLat)
                        .setHTML(`${isoCountryCode}: ${totalUsers} users`)
                        .addTo(map);
                });

                // Remove popup on mouse leave
                map.on('mouseleave', layerID, function() {
                    map.getCanvas().style.cursor = '';
                    popup.remove();
                });
            } else {

            }
        });
    }

    map.on('load', function() {
        map.addSource('country-boundaries', {
            type: 'vector',
            url: 'mapbox://mapbox.country-boundaries-v1',
        });

        map.on('idle', function() {
            if (map.isSourceLoaded('country-boundaries')) {
                console.log('Source loaded');
                addDataToMap();
            } else {
                console.log('Source not loaded');
            }
        });
    });
</script> -->


<!-- <script>
        document.addEventListener("DOMContentLoaded", function () {
            const countryVisitedData = {!! json_encode($country_visited) !!};

            // Convert the received data into GeoJSON format
            const countriesGeoJSON = {
                "type": "FeatureCollection",
                "features": countryVisitedData.map(country => ({
                    "type": "Feature",
                    "geometry": {
                        // Define the geometry for each country (if available)
                    },
                    "properties": {
                        "countryName": country.dimensions.country,
                        "totalUsers": parseInt(country.metrics.totalUsers)
                    }
                }))
            };

            // Initialize Mapbox map
            mapboxgl.accessToken = gmz_params.mapbox_token;
            mapboxgl.accessToken = 'YOUR_MAPBOX_ACCESS_TOKEN'; // Replace with your Mapbox access token
            var map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/dark-v10',// Replace with your desired Mapbox style URL
                center: [0, 0], // Set initial center coordinates
                zoom: 1 // Set initial zoom level
            });

            map.on('load', function () {
                // Add the GeoJSON source for countries
                map.addSource('countries', {
                    'type': 'geojson',
                    'data': countriesGeoJSON
                });

                // Add a layer to the map
                map.addLayer({
                    'id': 'countries-layer',
                    'type': 'fill',
                    'source': 'countries',
                    'layout': {},
                    'paint': {
                        'fill-color': [
                            'interpolate',
                            ['linear'],
                            ['get', 'totalUsers'],
                            0, 'rgba(0, 0, 255, 0)', // Change the color and range as needed
                            10, 'rgba(255, 0, 0, 1)'
                        ],
                        'fill-opacity': 0.7
                    }
                });

                // ... (Other map interactions or features)
            });
        });
    </script> -->

@endpush