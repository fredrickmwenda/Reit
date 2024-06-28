@extends('Backend::layouts.master')

@section('title', __(sprintf('New %s', 'Feature')))


@section('content')

<div class="layout-top-spacing">
    <div class="statbox widget box box-shadow">

        <div class="widget-header p-0 mb-4">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4></h4>

                        <a href="{{dashboard_url('feature')}}" class="btn btn-dark">{{__('Back to all')}}</a>
                    </div>
                </div>
            </div>
        </div>
        <form action="{{ route('feature.store') }}" method="POST" data-loader="body" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Feature Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>


            <div class="mb-3">
            <input type="checkbox" id="consumable" name="consumable" class="" data-toggle="switch" data-size="small" data-on-color="success" data-off-color="danger" value="1">
                <label for="consumable" class="form-label">Consumable</label>
                
            </div>

            <div class="mb-3">
            <input type="checkbox" id="quota" name="quota" class="" data-toggle="switch" data-size="small" data-on-color="success" data-off-color="danger" value="1">
                <label for="quota" class="form-label">Quota</label>
                
            </div>




            <button type="submit" class="btn btn-primary">Create Subscription</button>
        </form>






    </div>
</div>

@stop

