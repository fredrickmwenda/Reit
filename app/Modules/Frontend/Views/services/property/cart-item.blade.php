@php
    $post_object = maybe_unserialize($cart['post_object']);
    $thumbnail = get_attachment_url($post_object['thumbnail_id'], [70, 70]);
    $link = get_property_permalink($post_object['post_slug']);
    $title = get_translate($post_object['post_title']);
    $address = get_translate($post_object['location_address']);

@endphp
<div class="page-heading checkout">
    <h1>{{__('Detail')}}</h1>
</div>
<div class="cart-info">
    <div class="cart-info__heading d-flex">
        @if(!empty($thumbnail))
            <div class="thumbnail">
                <a href="{{$link}}">
                    <img src="{{$thumbnail}}" alt="{{$title}}"/>
                </a>
            </div>
        @endif
        <div class="info">
            <h3 class="title">
                <a href="{{$link}}">
                    {{$title}}
                </a>
            </h3>
            @if(!empty($address))
                <p class="location"><i class="fal fa-map-marker-alt mr-2"></i>{{$address}}</p>
            @endif
        </div>
    </div>

    @php
        $extras = $cart['cart_data']['extra_data'];
    @endphp
    @if(!empty($extras) && $extras != '[]')
        <div class="cart-info__equipment">
            <div class="__label">
                {{__('Extra Services')}}
            </div>
            <table>
                <tr>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Price')}}</th>
                </tr>
                @foreach($extras as $item)
                    <tr>
                        <td>{{get_translate($item['title'])}}</td>
                        <td>{{convert_price($item['price'])}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif

    <div class="cart-info__coupon">
        @php
            $coupon_code = $cart['coupon'];
            $coupon_percent = $cart['coupon_percent'];
            $coupon_value = $cart['coupon_value'];
        @endphp
        <p class="coupon-title">{{__('Coupon Code')}}</p>
        <form class="gmz-form-action" action="{{url('apply-coupon')}}">
            @include('Frontend::components.loader')
            <div class="inner">
                <input class="form-control gmz-validation" data-validation="required" type="text" id="coupon-code" name="coupon" placeholder="{{__('Have a coupon?')}}" value="@if(!empty($coupon_code)) {{$coupon_code}} @endif"/>
                <button type="submit" class="btn btn-primary">{{__('Apply')}}</button>
            </div>
            <div class="gmz-message"></div>
        </form>
    </div>

    <div class="cart-info__price">
        <ul>
            <li>
                <span class="label">{{__('Base Price')}}</span>
                <span class="value">{{convert_price($cart['base_price'])}}</span>
            </li>
            @if(!empty($extras) && $extras != '[]')
                <li>
                    <span class="label">{{__('Extra Price')}}</span>
                    <span class="value">{{convert_price($cart['extra_price'])}}</span>
                </li>
            @endif
            @if(!empty($coupon_code))
                <li>
                    <span class="label">{{__('Coupon')}}<br /><a href="javascript:void(0);" class="gmz-link-action text-danger" data-confirm="true" data-action="{{url('remove-coupon')}}" data-params="{{base64_encode(json_encode([]))}}"><small>{{__('Remove')}}</small></a></span>
                    <span class="value">-{{$coupon_percent}}%</span>
                </li>
            @endif
            <li>
                <span class="label">{{__('Sub Total')}}</span>
                <span class="value">{{convert_price($cart['sub_total'])}}</span>
            </li>
            @if(!empty($cart['tax']['included']) && !empty($cart['tax']['percent']))
                <li>
                                    <span class="label">
                                        {{__('Tax')}}
                                        @if($cart['tax']['included'] == 'on')
                                            <small>{{__('(included)')}}</small>
                                        @endif
                                    </span>
                    <span class="value">{{$cart['tax']['percent']}}%</span>
                </li>
            @endif
            <li class="total">
                <span class="label">{{__('Total Amount')}}</span>
                <span class="value">{{convert_price($cart['total'])}}</span>
            </li>
        </ul>
    </div>
</div>