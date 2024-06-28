@if(is_enable_service(GMZ_SERVICE_HOTEL))
@php
enqueue_scripts('match-height');
$hotel_types = get_terms('name', 'property-type', 'full');
$search_url = url('hotel-search');
@endphp
@endif

@if(is_enable_service(GMZ_SERVICE_TOUR))
@php
enqueue_scripts('match-height');
$tour_types = get_terms('name', 'tour-type', 'full');
$search_url = url('tour-search');
@endphp
@endif

@if(is_enable_service(GMZ_SERVICE_CAR))
@php
enqueue_scripts('match-height');
$car_types = get_terms('name', 'car-type', 'full');
$search_url = url('car-search');
@endphp
@endif

@if(is_enable_service(GMZ_SERVICE_PROPERTY))
@php
enqueue_scripts('match-height');
$property_types = get_terms('name', 'sale-type', 'full');
$search_url = url('property-search');
@endphp
@endif


@if(is_enable_service(GMZ_SERVICE_APARTMENT))
@php
enqueue_scripts('match-height');
$apartment_types = get_terms('name', 'apartment-type', 'full');
$search_url = url('apartment-search');
@endphp
@endif


@if(is_enable_service(GMZ_SERVICE_BEAUTY))
@php
enqueue_scripts('match-height');
$beauty_types = get_terms('name', 'beauty-services', 'full');
$search_url = url('beauty-search');
@endphp
@endif


@if(is_enable_service(GMZ_SERVICE_SPACE))
    @php
        enqueue_scripts('match-height');
        $space_types = get_terms('name', 'space-type', 'full');
        $search_url = url('space-search');
    @endphp
@endif




<section class="hotel-type">
  
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="section-title mb-4 pb-2 text-center">
                <span class="badge rounded-pill bg-soft-primary">Featured Items</span>
                <h4 class="title mt-3 mb-4">Latest Services</h4>
                <p class="max-w-xl mx-auto text-slate-400">We make the best choices with the hottest and most prestigious services, please visit the details below to find out more.</p>
            </div>
        </div>
    </div>

    <section class="relative bg-gray-100" >
    
        
        

     

        <div class="container">
        <!-- Convert collections to arrays -->
        <!-- Combine all types into one array  -->
        @php 
            $tour_types_array = $tour_types->map(function ($item) {
                $search_url = url('tour-search');
                return array_merge($item->toArray(), ['type' => 'tour', 'search_url' => $search_url]);
            })->toArray();

            $car_types_array = $car_types->map(function ($item) {
                $search_url = url('car-search');
                return array_merge($item->toArray(), ['type' => 'car', 'search_url' => $search_url]);
            })->toArray();

            $space_types_array = $space_types->map(function ($item) {
                $search_url = url('space-search');
                return array_merge($item->toArray(), ['type' => 'space', 'search_url' => $search_url]);
            })->toArray();

           
            $property_types_array = $property_types->map(function ($item) {
                $search_url = url('property-search');
                return array_merge($item->toArray(), ['type' => 'property', 'search_url' => $search_url]);
            })->toArray();

            $beauty_types_array = $beauty_types->map(function ($item) {
                $search_url = url('beauty-search');
                return array_merge($item->toArray(), ['type' => 'beauty', 'search_url' => $search_url]);
            })->toArray();

            $apartment_types_array = $apartment_types->map(function ($item) {
                $search_url = url('apartment-search');
                return array_merge($item->toArray(), ['type' => 'apartment', 'search_url' => $search_url]);
            })->toArray();

            $hotel_types_array = $hotel_types->map(function ($item) {
                $search_url = url('hotel-search');
                return array_merge($item->toArray(), ['type' => 'hotel', 'search_url' => $search_url]);
            })->toArray();
            
            // Combine all types into one array
            $all_types = array_merge(
                $tour_types_array,
                $car_types_array,
                $space_types_array,
                $property_types_array,
                $beauty_types_array,
                $apartment_types_array,
                $hotel_types_array
            );
            
            
        @endphp

            <div class="row pt-4" id="slick-carousel">
                @foreach($all_types as $item)
                   @php
                        
                        $img = $item['term_image'] ? get_attachment_url($item['term_image'], [96, 96]) :  asset('images/cabin.jpg');
                        
                        $term_title = get_translate($item['term_title']);
                        $search_url = add_query_arg($item['type'] . '_type', $item['id'], $item['search_url']);
                    @endphp

                    <div class="carousel-item">
                        <a href="{{$search_url}}" class="mr-2">
                           
                            <img class="_image-tour" src="{{$img}}" alt="{{$term_title}}" width="50" height="50">
                            <p class="all-items__title">{{$term_title}}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        @if(is_enable_service(GMZ_SERVICE_TOUR))
    @php
        enqueue_scripts('match-height');
        $list_tours = get_posts([
            'post_type' => GMZ_SERVICE_TOUR,
            'posts_per_page' => 3,
            'status' => 'publish'
        ]);
        $search_url = url('tour-search');
    @endphp
        @if(!$list_tours->isEmpty())
        <div class="list-tour list-tour--grid bg-gray-100">
 
            <div class="container">


                <div class="row">
                    @foreach($list_tours as $item)
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        @include('Frontend::services.tour.items.grid-item')
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        @endif


        @if(is_enable_service(GMZ_SERVICE_SPACE))
        @php
            enqueue_scripts('match-height');
            $list_spaces = get_posts([
                'post_type' => GMZ_SERVICE_SPACE,
                'posts_per_page' => 3,
                'status' => 'publish'
            ]);
            $search_url = url('space-search');
        @endphp
        @if(!$list_spaces->isEmpty())
        <div class="list-space list-space--grid bg-gray-100">
 
            <div class="container">
                <!-- <h2 class="section-title mb-20">{{__('List Of Space')}}</h2> -->
                <div class="row">
                    @foreach($list_spaces as $item)
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        @include('Frontend::services.space.items.grid-item')
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        @endif

        @if(is_enable_service(GMZ_SERVICE_PROPERTY))
        @php
        enqueue_scripts('match-height');
        $list_properties = get_posts([
        'post_type' => GMZ_SERVICE_PROPERTY,
        'posts_per_page' => 3,
        'status' => 'publish',
        'is_featured' => 'on'
        ]);
        $property_types = get_terms('name', 'sale-type', 'full');
        $search_url = url('property-search');
        @endphp
        @if(!$list_properties->isEmpty())
        <div class="list-property list-property--grid bg-gray-100">

            <div class="container">

                <div class="row">
                    @foreach($list_properties as $item)
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        @include('Frontend::services.property.items.grid-item')
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        @endif


        @if(is_enable_service(GMZ_SERVICE_HOTEL))
        @php
        enqueue_scripts('match-height');
        $list_hotels = get_posts([
        'post_type' => GMZ_SERVICE_HOTEL,
        'posts_per_page' => 3,
        'status' => 'publish'
        ]);
        $property_types = get_terms('name', 'property-type', 'full');
        $search_url = url('hotel-search');
        @endphp
        @if(!$list_hotels->isEmpty())
        <div class="list-hotel list-hotel--grid  bg-gray-100">


            <div class="container">
                <!-- <h2 class="section-title mb-20">{{__('List Of Hotels')}}</h2> -->
                <div class="row">
                    @foreach($list_hotels as $item)
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        @include('Frontend::services.hotel.items.grid-item')
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        @endif

        @if(is_enable_service(GMZ_SERVICE_CAR))
        @php
        enqueue_scripts('match-height');
        $list_cars = get_posts([
        'post_type' => GMZ_SERVICE_CAR,
        'posts_per_page' => 3,
        'status' => 'publish'
        ]);
        $car_types = get_terms('name', 'car-type', 'full');
        $search_url = url('car-search');
        @endphp
        @if(!$list_cars->isEmpty())
        <div class="list-car list-car--grid bg-gray-100">
          
            <div class="container">
                <!-- <h2 class="section-title mb-20">{{__('List Of Cars')}}</h2> -->
                <div class="row">
                    @foreach($list_cars as $item)
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        @include('Frontend::services.car.items.grid-item')
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        @endif

        @if(is_enable_service(GMZ_SERVICE_BEAUTY))
        @php
        enqueue_scripts('match-height');
        $list_beauty = get_posts([
        'post_type' => GMZ_SERVICE_BEAUTY,
        'posts_per_page' => 3,
        'status' => 'publish'
        ]);
        $beauty_types = get_terms('name', 'beauty-services', 'full');
        $search_url = url('beauty-search');
        @endphp
        @if(!$list_beauty->isEmpty())
        <div class="list-beauty list-beauty--grid  bg-gray-100">
  
            <div class="container">
                <!-- <h2 class="section-title mb-20">{{__('List Of Beauty')}}</h2> -->
                <div class="row">
                    @foreach($list_beauty as $item)
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        @include('Frontend::services.beauty.items.grid-item')
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        @endif

        @if(is_enable_service(GMZ_SERVICE_APARTMENT))
        @php
        enqueue_scripts('match-height');
        $list_apartments = get_posts([
        'post_type' => GMZ_SERVICE_APARTMENT,
        'posts_per_page' => 3,
        'status' => 'publish',
        'is_featured' => 'on'
        ]);
        $apartment_types = get_terms('name', 'apartment-type', 'full');
        $search_url = url('apartment-search');
        @endphp
        @if(!$list_apartments->isEmpty())
        <div class="list-apartment list-apartment--grid bg-gray-100">

            <div class="container">
                <!-- <h2 class="section-title mb-20">{{__('List Of Apartments')}}</h2> -->
                <div class="row">
                    @foreach($list_apartments as $item)
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        @include('Frontend::services.apartment.items.grid-item')
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        @endif
    </section>
</section>