@php
$testimonial = get_option('testimonials');
@endphp
@if(!empty($testimonial))

<div class="container-fluid mt-100 mt-60">
    <div class="rounded shadow py-5" style="background: url('storage/2024/01/23/1-1706015857.jpg') center center;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="card rounded p-4">
                        <div class="tns-outer" id="tns1-ow">
                            <div class="tns-liveregion tns-visually-hidden" aria-live="polite" aria-atomic="true">slide<span class="current">1</span> of {{ count($testimonial) }}</div>
                            <div id="tns1-mw" class="tns-ovh">
                                <div class="tns-inner" id="tns1-iw">
                                    <div class="tiny-single-item  tns-slider tns-carousel tns-subpixel tns-calc tns-horizontal" id="tns1" style="transform: translate3d(-83.3333%, 0px, 0px);">
                                        @foreach(array_values($testimonial) as $index => $item)
                                        @php
                                        $name = get_translate($item['name']);
                                        $content = get_translate($item['content']);
                                        @endphp

                                        <div class="tiny-slider tns-item {{ $index === 0 ? 'tns-slide-active' : '' }}" id="tns1-item{{ $index }}" aria-hidden="true" tabindex="-1">
                                            <div class="client-testi text-center">
                                                <p class="h6 text-muted fst-italic fw-normal">" {{ esc_html($content) }} "</p>
                                                <div class="commenter mt-4">
                                                    <div class="content mt-4">
                                                        <h5 class="text-primary mb-0">{{ esc_html($name) }}</h5>
                                                        <small class="text-muted">User</small>
                                                    </div>
                                                </div>
                                            </div><!--end review content-->
                                        </div>
                                        @endforeach



                                    </div>
                                </div>
                            </div>
                            <!-- <div class="tns-nav" aria-label="Carousel Pagination">
                                @foreach(array_values($testimonial) as $index => $item)
                                <button type="button" data-nav="{{ $index }}" aria-controls="tns1" style="" aria-label="Carousel Page {{ $index + 1 }}" class="{{ $index === 0 ? 'tns-nav-active' : '' }}" tabindex="-1"></button>
                                @endforeach

                            </div> -->
                        </div>
                        <!--end owl carousel-->
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end container-->
    </div>
</div>
<!-- <div class="container">
        <div class="carousel-s2">
            @foreach($testimonial as $item)
                @php
                    $name = get_translate($item['name']);
                    $content = get_translate($item['content']);
                @endphp
                <div class="testimonial-item text-white text-center">
                    <i class="fas fa-quote-left fa-3x"></i>
                    <p class="testimonial-item__comment">{{esc_html($content)}}</p>
                    <p class="testimonial-item__author">{{esc_html($name)}}</p>
                </div>
            @endforeach
        </div>
    </div> -->

@endif