@if(is_enable_service(GMZ_SERVICE_PROPERTY))
    @php
        enqueue_scripts('match-height');
        $property_types = get_terms('name', 'sale-type', 'full');
        $search_url = url('property-search');
    @endphp
    @if(!$property_types->isEmpty())
        <section class="property-type">
            <div class="container py-40">
                <h2 class="section-title mb-20">{{__('Property Types')}}</h2>
                <div class="row">
                    @foreach($property_types as $item)
                        @php
                            $img = get_attachment_url($item->term_image, [250, 150]);
                            $term_title = get_translate($item->term_title);
                            $search_url = add_query_arg(['sale_type' => $item->id], $search_url);
                        @endphp
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="property-type__item" data-plugin="matchHeight">
                                @if(!empty($img))
                                    <div class="property-type__thumbnail">
                                        <a href="{{$search_url}}">
                                            <img class="_image-property" src="{{$img}}" alt="{{$term_title}}">
                                        </a>
                                    </div>
                                @endif
                                <div class="property-type__info">
                                    <h3 class="property-type__name"><a href="{{$search_url}}">{{$term_title}}</a></h3>
                                    <div class="property-type__description">
                                        {{get_translate($item->term_description)}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endif