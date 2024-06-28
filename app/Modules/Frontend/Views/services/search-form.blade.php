@php
$all_services = get_services_enabled();
$srvc = [];
if(in_array(GMZ_SERVICE_HOTEL, $all_services)){
array_push($srvc, GMZ_SERVICE_HOTEL);
}
if(in_array(GMZ_SERVICE_APARTMENT, $all_services)){
array_push($srvc, GMZ_SERVICE_APARTMENT);
}
if(in_array(GMZ_SERVICE_PROPERTY, $all_services)){
array_push($srvc, GMZ_SERVICE_PROPERTY);
}
if(in_array(GMZ_SERVICE_CAR, $all_services)){
array_push($srvc, GMZ_SERVICE_CAR);
}
if(in_array(GMZ_SERVICE_SPACE, $all_services)){
array_push($srvc, GMZ_SERVICE_SPACE);
}
if(in_array(GMZ_SERVICE_TOUR, $all_services)){
array_push($srvc, GMZ_SERVICE_TOUR);
}
if(in_array(GMZ_SERVICE_BEAUTY, $all_services)){
array_push($srvc, GMZ_SERVICE_BEAUTY);
}
@endphp
@if(count($srvc) > 0)
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-11 col-12 text-center mt-sm-0 pt-sm-0">
            <div class="text-center features-absolute">
                <div class="search-form-wrapper">
                    @if(count($srvc) > 1)
                    <ul class="nav nav-tabs bg-light shadow border-bottom flex-column flex-sm-row d-md-inline-flex nav-justified mb-0 rounded-top position-relative" id="searchFormTab" role="tablist">
                        @if(in_array(GMZ_SERVICE_HOTEL, $srvc))
                        <li class="nav-item">
                            <a class="nav-link active" id="hotel-search-tab" data-toggle="tab" href="#hotel-search" role="tab" aria-controls="hotel-search" aria-selected="true">
                                <div class="text-center">
                                    <h6 class="mb-0">{{__('Hotel')}}</h6>
                                </div>
                            </a>
                        </li>
                        @endif
                        @if(in_array(GMZ_SERVICE_APARTMENT, $srvc))
                        @php
                        if(!in_array('hotel', $srvc)){
                        $apartment_active = 'active';
                        }else{
                        $apartment_active = '';
                        }
                        @endphp
                        <li class="nav-item">
                            <a class="nav-link {{$apartment_active}}" id="apartment-search-tab" data-toggle="tab" href="#apartment-search" role="tab" aria-controls="apartment-search" aria-selected="true">
                                <div class="text-center">
                                    <h6 class="mb-0">{{__('Apartment')}}</h6>

                                </div>
                            </a>
                        </li>
                        @endif
                        @if(in_array(GMZ_SERVICE_PROPERTY, $srvc))
                        @php
                        if(!in_array('hotel', $srvc)){
                        $property_active_active = 'active';
                        }else{
                        $property_active = '';
                        }
                        @endphp
                        <li class="nav-item">
                            <a class="nav-link {{$property_active}}" id="property-search-tab" data-toggle="tab" href="#property-search" role="tab" aria-controls="rent-search" aria-selected="true" style="width: max-content;">
                                <div class="text-center">

                                    <h6 class="mb-0">{{__(' Selling Properties')}}</h6>

                                </div>
                            </a>
                        </li>
                        @endif
                        @if(in_array(GMZ_SERVICE_CAR, $srvc))
                        @php
                        if(!in_array('hotel', $srvc) && !in_array('apartment', $srvc)){
                        $car_active = 'active';
                        }else{
                        $car_active = '';
                        }
                        @endphp
                        <li class="nav-item">
                            <a class="nav-link {{$car_active}}" id="car-search-tab" data-toggle="tab" href="#car-search" role="tab" aria-controls="car-search" aria-selected="false">
                                <div class="text-center">

                                    <h6 class="mb-0">{{__('Car')}}</h6>
                                </div>
                            </a>
                        </li>
                        @endif
                        @if(in_array(GMZ_SERVICE_SPACE, $srvc))
                        @php
                        if(!in_array('hotel', $srvc) && !in_array('apartment', $srvc) && !in_array('car', $srvc)){
                        $space_active = 'active';
                        }else{
                        $space_active = '';
                        }
                        @endphp
                        <li class="nav-item">
                            <a class="nav-link {{$space_active}}" id="space-search-tab" data-toggle="tab" href="#space-search" role="tab" aria-controls="space-search" aria-selected="false">

                                <div class="text-center">

                                    <h6 class="mb-0">{{__('Space')}}</h6>
                                </div>
                            </a>
                        </li>
                        @endif
                        @if(in_array(GMZ_SERVICE_TOUR, $srvc))
                        @php
                        if(!in_array('hotel', $srvc) && !in_array('apartment', $srvc) && !in_array('car', $srvc) && !in_array('space', $srvc)){
                        $tour_active = 'active';
                        }else{
                        $tour_active = '';
                        }
                        @endphp
                        <li class="nav-item">
                            <a class="nav-link {{$tour_active}}" id="tour-search-tab" data-toggle="tab" href="#tour-search" role="tab" aria-controls="tour-search" aria-selected="false">
                                <div class="text-center">

                                    <h6 class="mb-0">{{__('Tour')}}</h6>
                                </div>
                            </a>
                        </li>
                        @endif
                        @if(in_array(GMZ_SERVICE_BEAUTY, $srvc))
                        <li class="nav-item">
                            <a class="nav-link" id="beauty-search-tab" data-toggle="tab" href="#beauty-search" role="tab" aria-controls="beauty-search" aria-selected="false">

                                <div class="text-center">

                                    <h6 class="mb-0">{{__('Beauty')}}</h6>
                                </div>
                            </a>
                        </li>
                        @endif
                    </ul>
                    @endif
                    <div class="tab-content" id="searchFormTab">
                        @if(in_array(GMZ_SERVICE_HOTEL, $srvc))
                        <div class="tab-pane fade show active hotel-search-form" id="hotel-search" role="tabpanel" aria-labelledby="hotel-search-tab">
                            @include('Frontend::services.hotel.search-form')
                        </div>
                        @endif
                        @if(in_array(GMZ_SERVICE_APARTMENT, $srvc))
                        @php
                        if(!in_array('hotel', $srvc)){
                        $apartment_active = 'show active';
                        }else{
                        $apartment_active = '';
                        }
                        @endphp
                        <div class="tab-pane fade {{$apartment_active}} apartment-search-form" id="apartment-search" role="tabpanel" aria-labelledby="apartment-search-tab">
                            @include('Frontend::services.apartment.search-form')
                        </div>
                        @endif
                        @if(in_array(GMZ_SERVICE_PROPERTY, $srvc))
                        @php
                        if(!in_array('hotel', $srvc)){
                        $property_active = 'show active';
                        }else{
                        $property_active = '';
                        }
                        @endphp
                        <div class="tab-pane fade {{$property_active}} property-search-form" id="property-search" role="tabpanel" aria-labelledby="property-search-tab">
                            @include('Frontend::services.property.search-form')
                        </div>
                        @endif
                        @if(in_array(GMZ_SERVICE_CAR, $srvc))
                        @php
                        if(!in_array('hotel', $srvc) && !in_array('apartment', $srvc)){
                        $car_active = 'show active';
                        }else{
                        $car_active = '';
                        }
                        @endphp
                        <div class="tab-pane fade {{$car_active}} car-search-form" id="car-search" role="tabpanel" aria-labelledby="car-search-tab">
                            @include('Frontend::services.car.search-form')
                        </div>
                        @endif

                        @if(in_array(GMZ_SERVICE_SPACE, $srvc))
                        @php
                        if(!in_array('hotel', $srvc) && !in_array('apartment', $srvc) && !in_array('car', $srvc)){
                        $space_active = 'show active';
                        }else{
                        $space_active = '';
                        }
                        @endphp
                        <div class="tab-pane fade {{$space_active}} space-search-form" id="space-search" role="tabpanel" aria-labelledby="space-search-tab">
                            @include('Frontend::services.space.search-form')
                        </div>
                        @endif

                        @if(in_array(GMZ_SERVICE_TOUR, $srvc))
                        @php
                        if(!in_array('hotel', $srvc) && !in_array('apartment', $srvc) && !in_array('car', $srvc) && !in_array('space', $srvc)){
                        $tour_active = 'show active';
                        }else{
                        $tour_active = '';
                        }
                        @endphp
                        <div class="tab-pane fade {{$tour_active}} tour-search-form" id="tour-search" role="tabpanel" aria-labelledby="tour-search-tab">
                            @include('Frontend::services.tour.search-form')
                        </div>
                        @endif

                        @if(in_array(GMZ_SERVICE_BEAUTY, $srvc))
                        <div class="tab-pane fade @if($srvc[0] == GMZ_SERVICE_BEAUTY)show active @endif beauty-search-form" id="beauty-search" role="tabpanel" aria-labelledby="beauty-search-tab">
                            @include('Frontend::services.beauty.search-form')
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif