@extends('Frontend::layouts.master')

@section('title', __('Property'))

@php
    enqueue_styles([
        'slick',
        'daterangepicker'
    ]);
    enqueue_scripts([
        'slick',
        'moment',
        'daterangepicker'
    ]);
@endphp

@section('content')
    @include('Frontend::services.property.items.slider')
    @include('Frontend::services.property.items.type')
    @include('Frontend::services.property.items.recent')
    @include('Frontend::services.property.items.destination')
    @include('Frontend::services.property.items.testimonial')
    @include('Frontend::components.sections.blog')
@stop

