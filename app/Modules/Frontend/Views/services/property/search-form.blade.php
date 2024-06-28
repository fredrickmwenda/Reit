@php
    $has_advanced = true;
   if(isset($advanced) && !$advanced){
       $has_advanced = false;
   }

   enqueue_styles([
       'mapbox-gl',
       'mapbox-gl-geocoder'
    ]);
    enqueue_scripts([
       'mapbox-gl',
       'mapbox-gl-geocoder'
    ]);

   if($has_advanced){ 

       $price_range = get_price_range(GMZ_SERVICE_PROPERTY);
       $property_types = get_terms('name','sale-type');
       $property_amenity = get_terms('name','property-amenity');
       $extension_range = get_range_extension();

       enqueue_styles([
          'icon.rangeSlider'
       ]);

        enqueue_scripts([
          'icon.rangeSlider'
       ]);
   }

   $address = request()->get('address', '');
   $lat = request()->get('lat', '');
   $lng = request()->get('lng', '');

@endphp
@push('css')
<style>
#search-property{
    position: relative;
}

.search-form__basic{
    display: flex;
        align-items: center;
        width: 100%;
        background-color: #fff;
        box-shadow: 0 0 2px 0 rgba(25, 32, 36, 0.12), 0 2px 4px 0 rgba(25, 32, 36, 0.22);
        
}

#basic-search{
    justify-content: flex-end;
    margin-right: -10px;
}

.search-form__address{
        height: 60px;
        display: flex;
        align-items: center;
        padding-left: 30px;
        
}

#address_search{
    width: calc(100% - 50px);
}



.mapboxgl-ctrl-geocoder {
    box-shadow: none;
    height: 100%;
    width: 100%;
    background: transparent;

    .mapboxgl-ctrl-geocoder--icon {
      display: none;

      &.mapboxgl-ctrl-geocoder--icon-loading {
        top: 50%;
        margin-top: -12px;
      }
    }

    .mapboxgl-ctrl-geocoder--input {
      height: 100%;
      padding-left: 65px;
      font-weight: 450;
      font-size: 16px;
      border:3px solid #2628A6!important;
    }

    .suggestions-wrapper {
      overflow: visible !important;

      .suggestions {
        top: calc(100% + 10px);
        border-radius: 0;
        overflow: visible !important;

        &:before {
          content: '';
          display: block !important;
          transform: rotate(45deg);
          position: absolute;
          top: -5px;
          left: 5px;
          z-index: 9999;
          border: 5px solid #fff;
          border-right-color: transparent;
          border-bottom-color: transparent;
        }
      }
    }
  }

.search-form__address input {
    width: 100%;
    outline: 0 !important;
    border: 0;
}

.search-form__address i{
    font-size: 22px;
    margin-right: 8px;
}

.search-form__search{
    display: flex;
        align-items: center;
        border-radius: 0;
        height: 60px;
        padding-left: 20px;
        padding-right: 20px;
        margin-left: auto;

        i {
          font-size: 22px;
          margin-right: 8px;
        }
} 
 #searching{
    margin:0px!important;
}


.search-form__more {
  border-radius: 0;
  height: 60px;
  background-color: hsla(239, 63%, 40%, 1);
  
  
  border-color: #1b55e2 !important;
  color: #fff !important;
  display: flex;
  align-items: center;
  padding-left: 20px;
  padding-right: 20px;
  border-right: 1px solid rgba(255,255,255,0.3);

  i {
    font-size: 22px;
  }

  &:hover {
    background-color: 'blue';
    border-color: 'blue';
    border-right-color: rgba(255,255,255,0.3);
  }

  &:focus {
    outline: none !important;
  }
} 
  



.search-form__advanced {
        padding-top: 20px;
        padding-bottom: 20px;
        position: absolute;
        width: 100%;
        display: none;
        box-shadow: 0 0 2px 0 rgba(25, 32, 36, 0.12), 0 2px 4px 0 rgba(25, 32, 36, 0.22);

        .irs {
          max-width: 300px;
        }
}

      .input-hidden {
        visibility: hidden;
        width: 0;
        height: 0;
        padding: 0;
        border: 0;
      }


  .search-form__from{
    border:3px solid #2628A6!important;
  }
  .search-form__to{
    border:3px solid #2628A6!important;
  }
  .search-form__time .dropdown .dropdown-toggle{
    border:3px solid #2628A6!important;

  }
  #dropdownGuestButton{
    border:3px solid #2628A6!important;
  }
   .search-form__from-time{
    border:3px solid #2628A6!important;

  }
  .search-form__select{
    border:3px solid #2628A6!important;
  }

</style>
@endpush
<form id="search-property" method="GET" class="search-form property" action="{{url('property-search')}}">
    <div class="search-form__basic" id="basic-search">
        <div class="search-form__address" id="address_search">
            <i class="fal fa-city"></i> 
            <div class="form-control h-100 border-0" data-plugin="mapbox-geocoder" data-value="{{$address}}"
                 data-placeholder="{{__('Location')}}" data-lang="{{get_current_language()}}">
            </div>
            <div class="map d-none"></div>
            <input type="hidden" name="lat" value="{{$lat}}">
            <input type="hidden" name="lng" value="{{$lng}}">
            <input type="hidden" name="address" value="{{$address}}">
        </div>


       
        <button class="btn search-form__more"  type="button"><i class="fal fa-search-plus"></i></button>
        
        <button class="btn btn-primary search-form__search"  type="submit"><i class="fal fa-search"></i>{{__('Search')}}
        </button>
    </div>
    

    @if($has_advanced)
        <div class="search-form__advanced bg-white jadi">
            <div class="cont">
                <div class="row">
                    <div class="col-md-6">
                        <div class="search-form__label" style="color: black; text-align:left; padding-left:10px;">{{__('Price')}}</div>
                        <input type="text" class="price-range-slider" name="price_range" value=""
                               data-min="{{$price_range['min']}}"
                               data-max="{{$price_range['max']}}"
                               data-form="{{$price_range['from']}}"
                               data-to="{{$price_range['to']}}"
                               data-prefix="{{$extension_range['prefix']}}"
                               data-postfix="{{$extension_range['postfix']}}"
                        />

                    </div>
                    @if(!empty($property_types))
                        <div class="col-md-6 gmz-checkbox-wrapper">
                            <div class="search-form__label" style="color: black; text-align:left; padding-left:10px;">{{__('Types')}}</div>
                            @foreach($property_types as $key => $type)
                                <label class="checkbox-inline"><input type="checkbox" class="gmz-checkbox-item" name="property_types[]" value="{{$key}}"><span style="color: black;">{{get_translate($type)}}</span></label>
                            @endforeach
                            <input type="hidden" name="property_type" value=""/>
                        </div>
                    @endif

                    @if(!empty($property_amenity))
                        <div class="col-md-6 gmz-checkbox-wrapper">
                            <div class="search-form__label" style="color: black; text-align:left; padding-left:10px;">{{__('Amenities')}}</div>
                            @foreach($property_amenity as $key => $value)
                                <label class="checkbox-inline"><input type="checkbox" class="gmz-checkbox-item" name="property_amenities[]" value="{{$key}}"><span style="color: black;">{{get_translate($value)}}</span></label>
                            @endforeach
                            <input type="hidden" name="property_amenity" value=""/>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</form>