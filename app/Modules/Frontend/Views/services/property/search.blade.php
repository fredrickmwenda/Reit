@extends('Frontend::layouts.master')

@section('title', __('Property Search Page'))
@section('class_body', 'search-page')

@php
    enqueue_styles([
        'slick',
        'daterangepicker'
    ]);
    enqueue_scripts([
        'slick',
        'moment',
        'daterangepicker',
        'jquery.nicescroll',
        'match-height',
        'gmz-search-property'
    ]);
@endphp

@section('content')
    <section class="search-archive-top bg-secondary">
        <div class="container">
            <div class="search-form-wrapper">
                <div class="apartment-search-form">
                    @php
                        $text_slider = get_translate(get_option('property_slider_text'));
                    @endphp
                    @if(!empty($text_slider))
                        <p class="_title">{{$text_slider}}</p>
                    @endif
                    @include('Frontend::services.property.search-form', ['advanced' => false])
                </div>
            </div>
        </div>
    </section>
    <section class="list-half-map gmz-search-result" data-action="{{url('property-search')}}">
        <div class="container-fluid">
            <div class="search-filter d-flex align-items-center">
                <div class="heading"><i class="fal fa-sliders-v-square"></i></div>
                @include('Frontend::services.property.filter.price')
                @include('Frontend::services.property.filter.term')
            </div>
            <div class="row">
                @include('Frontend::services.property.search.result')
                @include('Frontend::services.property.search.map')
            </div>
        </div>
    </section>
@stop

