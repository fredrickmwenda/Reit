@if(is_enable_service(GMZ_SERVICE_PROPERTY))
    @php
        enqueue_scripts('match-height');
        $list_properties = get_posts([
            'post_type' => GMZ_SERVICE_PROPERTY,
            'posts_per_page' => 3,
            'status' => 'publish',
            'is_featured' => 'on'
        ]);
        $search_url = url('property-search');
    @endphp
    @if(!$list_properties->isEmpty())
        <section class="list-property list-property--grid py-40 bg-gray-100">
            <div class="container">
                <h2 class="section-title mb-20">{{__('List Of Selling Properties')}}</h2>
                <div class="row">
                    @foreach($list_properties as $item)
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            @include('Frontend::services.property.items.grid-item')
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endif