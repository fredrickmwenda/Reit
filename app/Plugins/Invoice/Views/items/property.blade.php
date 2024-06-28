@php
    $link = get_the_permalink($post['post_slug'], $order['post_type']);
    info($link);
    $title = get_translate($post['post_title']);
    info($title);
    $address = get_translate($post['location_address']);
    $cartData = $checkoutData['cart_data'];
info($cartData)
@endphp

<tr>
    <td class="label">{{__('Service Name')}}</td>
    <td class="val">
        <p><a href="{{$link}}">{{$title}}</a></p>
        <span>{{$address}}</span>
    </td>
</tr>