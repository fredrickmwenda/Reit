@php

@endphp
<form id="search-room" method="POST" class="search-form room" action="{{url('property-search')}}">
    <input type="hidden" name="property_id" value="{{$post['id']}}" />
    <div class="search-form__basic">
        

        <button class="btn btn-primary search-form__search" type="submit">{{__('CHECK AVAILABILITY')}}
        </button>
    </div>
</form>