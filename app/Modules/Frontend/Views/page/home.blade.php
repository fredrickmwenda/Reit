@extends('Frontend::layouts.master')

@section('title', __('Home Page'))

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
@push('css')
<link href="{{asset('css/ui.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('css/tiny-slider.css')}}" rel="stylesheet" type="text/css" />

<style>
.features-absolute {
    position: relative;
    z-index: 2;
    -webkit-transition: all .5s ease;
    transition: all .5s ease
}
.tab-pane{
    position: relative;
    z-index: 500; 
}
.rounded-bottom {
    border-bottom-left-radius: 6px!important;
    border-bottom-right-radius: 6px!important
}

.badge {
    letter-spacing: .5px;
    padding: 4px 8px;
    font-weight: 600;
    line-height: 11px;
}

.bg-soft-primary {
    background-color: #6f70c3!important;
    border: 1px solid #bdbdcd!important;
    color: #111266!important;
}

.rounded-pill {
    border-radius: 50rem!important;
}
.section-title .title {
    letter-spacing: .5px;
    font-size: 30px!important;
}


#tns1 {
    width: calc(600%);
    transition-duration: 0.4s;
}
#tns1 > .tns-item {
    width: calc(16.6667%);
    padding-right: 16px;
    font-size: 16px;
}
.client-testi .content:before {
    content: "";
    position: absolute;
    top: 30px;
    left: 0;
    margin-left: 13px;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    border: 8px solid #212529;
    border-color: transparent #fff #fff transparent;
    -webkit-transform-origin: 0 0;
    transform-origin: 0 0;
    -webkit-transform: rotate(135deg);
    transform: rotate(135deg);
    -webkit-box-shadow: 2px 2px 2px -1px rgba(33,37,41,.15);
    box-shadow: 2px 2px 2px -1px rgba(33,37,41,.15)
}

.tns-nav {
    text-align: center;
    margin-top: 10px
}

.tns-nav button {
    border-radius: 3px;
    background: #6f70c3!important;
    -webkit-transition: all .5s ease;
    transition: all .5s ease;
    border: none;
    margin: 0 5px;
    padding: 5px
}

.tns-nav button.tns-nav-active {
    background: #11124b!important;
    -webkit-transform: rotate(45deg);
    transform: rotate(45deg)
}

.tns-controls button[data-controls=next],.tns-controls button[data-controls=prev] {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    transform: translateY(-50%);
    font-size: 16px;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #fff;
    color: #212529;
    border: none;
    -webkit-transition: all .5s ease;
    transition: all .5s ease;
    z-index: 1;
    -webkit-box-shadow: 0 10px 25px rgba(60,72,88,.15);
    box-shadow: 0 10px 25px rgba(60,72,88,.15)
}

.tns-controls button[data-controls=next]:hover,.tns-controls button[data-controls=prev]:hover {
    background: #16a34a;
    color: #fff
}

.tns-controls button[data-controls=prev] {
    left: 0
}

.tns-controls button[data-controls=next] {
    right: 0
}

.tns-outer button{
    visibility: hidden;
}

.meti{
    border-top: 1px solid #eee;
    border-bottom: 1px solid #eee;
    padding: 13px 0 10px 0;
}

.jadi{
    bottom: 100px;
}

</style>
@endpush
@section('content')
    @include('Frontend::page.home.slider2')
    @action('gmz_homepage_after_slider')
    @include('Frontend::page.home.about-us')
    @include('Frontend::page.home.howitworks')
    @include('Frontend::page.home.destination')
    @include('Frontend::page.home.projects')

    @include('Frontend::page.home.testimonial')
    @include('Frontend::components.sections.blog')
@stop
@push('scripts')
<script src="{{asset('js/tiny-slider.js')}}"  ></script>
<!-- <script>
$(document).ready(function() {
  // Get the active slide
  const activeSlide = $('.tns-slide-active');

  // Remove the aria-hidden attribute
  activeSlide.removeAttr('aria-hidden');

  // Remove the tabindex attribute
  activeSlide.removeAttr('tabindex');

  const paginationActive = $('.tns-nav-active');
  paginationActive.removeAttr('tabindex');
});

let slider = tns({
    container: '#tns1',
    items: 1,
    autoplay: true,
    controls:false,
    
    
    responsive: {
        640: {
            items: 1
        },
        1000: {
            items: 1
        },
        1400: {
            items: 1
        }
    }
});


</script> -->
<script>
    let slider = tns({
    container: '#tns1',
    items: 1,
    autoplay: true,
    controls:false,
    
    
    responsive: {
        640: {
            items: 1
        },
        1000: {
            items: 1
        },
        1400: {
            items: 1
        }
    }
});
 </script>
 <script src="{{asset('js/easy_background.js')}}"  ></script>
<script>
            easy_background("#homey",
                {
                    slide: ["images/1.jpg", "images/2.jpg", "images/3.jpg"],
                    delay: [4000, 4000, 4000]
                }
            );
        </script> 
@endpush

