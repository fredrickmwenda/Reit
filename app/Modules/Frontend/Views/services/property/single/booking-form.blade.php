@php

$booking_form = $post['sale_form'];


@endphp
<div class="booking-form apartment">
    <div class="booking-form__heading">
        <span class="price-label">{{__('Price')}}</span><span class="price-value">{{convert_price($post['base_price'])}}</span><span class="price-unit">
     
        </span>
        <div id="booking-form-close" class="close">+</div>
    </div>
    <div class="booking-form__content">
        @if($booking_form == 'both')
        <ul class="nav nav-tabs" id="bookingTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="instant-tab" data-toggle="tab" href="#instant" role="tab" aria-controls="instant" aria-selected="true">{{__('Instant')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="enquiry-tab" data-toggle="tab" href="#enquiry" role="tab" aria-controls="enquiry" aria-selected="false">{{__('Enquiry')}}</a>
            </li>
        </ul>
        @endif
        @if($booking_form == 'both')
           <div class="tab-content" id="mybookingTabContent">
        @endif
        @if($booking_form == 'both' || $booking_form == 'instant')
           <div class="tab-pane fade show active" id="instant" role="tabpanel" aria-labelledby="instant-tab">
            
                    <form class="gmz-form-action booking-form-single" action="{{ url('property-add-cart') }}" method="POST" data-price-url="{{url('property-get-real-price')}}">
            <input type="hidden" name="post_type" value="{{GMZ_SERVICE_PROPERTY}}"/>
            <input type="hidden" name="post_id" value="{{$post['id']}}"/>
            <input type="hidden" name="post_hashing" value="{{gmz_hashing($post['id'])}}"/>
            @include('Frontend::components.loader')
         

       
            @php
                $extras = maybe_unserialize($post['extra_services']);
            @endphp
            @if(!empty($extras) && $extras != '[]')
            <div class="booking-equipment">
                <div class="accordion" id="accordionEquipment">
                    <div class="card">
                        <div class="card-header" id="headingEquipment">
                            <div class="card-header-panel collapsed" data-toggle="collapse" data-target="#collapseEquipment" aria-expanded="false" aria-controls="collapseEquipment">
                                {{__('Extra Services')}}
                                <i class="fal fa-chevron-down"></i>
                            </div>
                        </div>
                        <div id="collapseEquipment" class="collapse" aria-labelledby="headingEquipment" data-parent="#accordionEquipment">
                            <div class="card-body">
                                @foreach($extras as $key => $val)
                                    @if($val['required'] == 'on')
                                        <div class="item">
                                            <div class="name">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="extras[]" value="{{$key}}" checked onclick="return false;"><span>{{get_translate($val['title'])}}</span>
                                                    <small class="required">({{__('required')}})</small>
                                                </label>
                                            </div>
                                            <div class="price">
                                                {{convert_price($val['price'])}}
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                @foreach($extras as $key => $val)
                                    @if($val['required'] == 'off')
                                        <div class="item">
                                            <div class="name">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="extras[]" value="{{$key}}"><span>{{get_translate($val['title'])}}</span>
                                                </label>
                                            </div>
                                            <div class="price">
                                                {{convert_price($val['price'])}}
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="gmz-message"></div>
            <button type="submit" class="btn btn-primary btn-book-now">{{__('BUY NOW')}}</button>
        </form>
              
            </div>
        @endif
        @if($booking_form == 'both' || $booking_form == 'enquiry')
           <div class="tab-pane fade show" id="enquiry" role="tabpanel" aria-labelledby="enquiry-tab">
               <form class="gmz-form-action enquiry-form-single" action="{{ url('property-send-enquiry') }}" method="POST">
                   <input type="hidden" name="post_id" value="{{$post['id']}}"/>
                   <input type="hidden" name="post_hashing" value="{{gmz_hashing($post['id'])}}"/>
                @include('Frontend::components.loader')
                   <div class="form-group">
                       <label for="full-name">{{__('Full Name')}}<span class="required">*</span> </label>
                       <input type="text" name="full_name"  class="form-control gmz-validation" data-validation="required" id="full-name"/>
                   </div>
                   <div class="form-group">
                       <label for="email">{{__('Email')}}<span class="required">*</span></label>
                       <input type="text" name="email"  class="form-control gmz-validation" data-validation="required" id="email"/>
                   </div>
                   <div class="form-group">
                       <label for="content">{{__('Message')}}<span class="required">*</span> </label>
                       <textarea name="content" rows="4" class="form-control gmz-validation" data-validation="required" id="content"></textarea>
                   </div>
                   <div class="gmz-message"></div>
                   <button type="submit" class="btn btn-primary">{{__('SUBMIT REQUEST')}}</button>
               </form>
           </div>
        @endif
        @if($booking_form == 'both')
           </div>
        @endif
    </div>
</div>