@extends('Frontend::layouts.master')
@section('title', get_translate($post['post_title']))
@section('class_body', 'single-property single-service')

@php
    enqueue_styles([
       'mapbox-gl',
       'mapbox-gl-geocoder',
       'daterangepicker'
    ]);
    enqueue_scripts([
       'mapbox-gl',
       'mapbox-gl-geocoder',
       'moment',
       'daterangepicker'
    ]);
    $post_content = get_translate($post['post_content']);
    $amenities = $post['property_amenity'];

@endphp

@section('content')
    @include('Frontend::services.property.single.gallery')
    @php
        the_breadcrumb($post, GMZ_SERVICE_PROPERTY);
    @endphp
    <div class="container">
        <div class="row">
            <div class="col-lg-8 pb-5">
                <h1 class="post-title">
                    @php echo add_wishlist_box($post['id'], GMZ_SERVICE_PROPERTY); @endphp
                    {{get_translate($post['post_title'])}}
                    @if($post['is_featured'] == 'on')
                        <span class="is-featured">{{__('Featured')}}</span>
                    @endif
                </h1>
                @if(!empty($post['rating']))
                    <div class="count-reviews">
                        @php
                            review_rating_star($post['rating'])
                        @endphp
                    </div>
                @endif
                <p class="location">
                    <i class="fal fa-map-marker-alt"></i> {{get_translate($post['location_address'])}}
                </p>
                <div class="meta">
                    <ul>
                        <li>
                            <span class="value">{{$post['size']}}</span>
                            <span class="label">{{__('Size')}}<small> ({{get_option('unit_of_measure', 'm2')}})</small></span>
                        </li>
                        @php
                            $term = get_term('id', $post['sale_type']);
                        @endphp
                        @if($term)
                            <li>
                                <span class="value">{{get_translate($term->term_title)}}</span>
                                <span class="label">{{__('Type')}}</span>
                            </li>
                        @endif
                    </ul>
                </div>
                @if(!empty($post_content))
                    <section class="description">
                        <h2 class="section-title">{{__('Detail')}}</h2>
                        <div class="section-content">
                            {!! balance_tags($post_content) !!}
                        </div>
                    </section>
                @endif
                @if(!empty($amenities))
                    <section class="feature">
                        <h2 class="section-title">{{__('Amenities')}}</h2>
                        <div class="section-content">
                            @php
                                $amenities = explode(',', $amenities);
                            @endphp
                            <div class="row">
                                @foreach($amenities as $item)
                                    @php
                                        $term = get_term('id', $item);
                                    @endphp
                                    @if($term)
                                        <div class="col-md-3 col-6">
                                            <div class="term-item">
                                                @if(!empty($term->term_icon))
                                                    @if(strpos($term->term_icon, ' fa-'))
                                                        <i class="{{$term->term_icon}} term-icon"></i>
                                                    @else
                                                        {!! get_icon($term->term_icon) !!}
                                                    @endif
                                                @endif
                                                <div class="term-item__title">
                                                    {{get_translate($term->term_title)}}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </section>
                @endif

                @include('Frontend::services.property.single.availability')
          
                <section class="map">
                    <h2 class="section-title">{{__('Property On Map')}}</h2>
                    <div class="section-content">
                        <div class="map-single" data-lat="{{$post['location_lat']}}" data-lng="{{$post['location_lng']}}"></div>
                    </div>
                </section>
                @include('Frontend::services.property.single.review')
            </div>
            <!-- <div class="col-lg-4">
                <div class="siderbar-single">
              
                   
                    <div id="booking-mobile" class="booking-mobile btn btn-primary">
                        {{__('Check Availability')}}
                    </div>
                    @include('Frontend::components.sections.partner-info')
                </div>
            </div> -->
            <div class="col-lg-4">
                <div class="siderbar-single">
                    @include('Frontend::services.property.single.booking-form')
                    <div id="booking-mobile" class="booking-mobile btn btn-primary">
                        {{__('Check Availability')}}
                    </div>
                    @include('Frontend::components.sections.partner-info')
                </div>
            </div>
        </div>
    </div>
    @include('Frontend::services.property.single.nearby')
@stop

