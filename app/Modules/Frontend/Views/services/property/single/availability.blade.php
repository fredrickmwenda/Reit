@php
    enqueue_styles('fotorama');
    enqueue_scripts('fotorama');
@endphp

<section class="feature">
    <h2 class="section-title d-flex align-items-center justify-content-between">
        {{__('Property Availability')}}
        <div>
            <a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal" data-target="#propertyEnquiryModal">
                {{__('Send Enquiry')}}
            </a>
        </div>
    </h2>

    <!-- <div class="section-content">
        <div id="room-render-wrapper" class="room-render-wrapper">
            @include('Frontend::services.property.single.search-form')
            @include('Frontend::components.loader')
            <form id="gmz-room-booking" action="{{url('property-add-cart')}}" method="POST" data-action-real-price="{{url('property-get-real-price')}}">
                <input type="hidden" name="hotel_hashing" value="{{gmz_hashing($post['id'])}}" />

                <div class="room-html"></div>
                <div id="room-booking-form" class="room-booking-form">
                    @include('Frontend::components.loader')
                    <h4 class="room-booking-form-title">{{__('Sale Form')}}</h4>
                    <div class="d-flex justify-content-between">
                        @php
                            $extra_services = maybe_unserialize($post['extra_services']);
                        @endphp
                        @if(!empty($extra_services))
                            <div class="hotel-extra-services">
                                <h5>{{__('Extra Services')}}</h5>
                                <div class="row gmz-checkbox-wrapper">
                                    @foreach($extra_services as $ek => $ev)
                                        <div class="col-lg-6">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" class="gmz-checkbox-item" name="extra_service[]" value="{{$ek}}" />
                                                <span>{{get_translate($ev['title'])}}</span>
                                                ({{convert_price($ev['price'])}})
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <div class="booking-form-detail @if(empty($extra_services)) alone @endif">
                            <h5>{{__('Details')}}</h5>
                       
                            <div class="total-price">
                                <div class="label">
                                    {{__('Total Price')}}
                                </div>
                                <div class="value" id="gmz-render-price-room">
                                    {{convert_price(300)}}
                                </div>
                            </div>
                            <button class="btn btn-primary">{{__('BUY NOW')}}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div> -->
</section>

@include('Frontend::services.property.single.modal-enquiry')
